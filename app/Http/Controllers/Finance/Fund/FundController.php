<?php

namespace App\Http\Controllers\Finance\Fund;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ViewModel\ViewUserDistributionPTW;
use App\ViewModel\ViewUserDistributionPPW;
use App\ViewModel\ViewUserDistributionPTHQ;
use App\ViewModel\ViewUserDistributionPPHQ;
use App\Mail\Filing\Queried;
use App\Mail\Filing\Distributed;
use App\Mail\Filing\SendToHQ;
use App\Mail\Filing\Received;
use App\Mail\Filing\ReceivedHQ;
use App\Mail\Fund\ApprovedKS;
use App\Mail\Fund\ApprovedPWN;
use App\Mail\Fund\Rejected;
use App\Mail\Fund\Sent;
use App\Mail\Fund\NotReceived;
use App\Mail\Fund\DocumentApproved;
use App\Mail\Fund\ReminderStatement;
use App\LogModel\LogSystem;
use App\LogModel\LogFiling;
use App\FilingModel\Query;
use App\FilingModel\Fund;
use App\FilingModel\FundBranch;
use App\FilingModel\FundParticipant;
use App\FilingModel\FundCollection;
use App\FilingModel\FundBank;
use App\MasterModel\MasterMeetingType;
use App\MasterModel\MasterPartyType;
use App\UserStaff;
use App\User;
use Validator;
use Carbon\Carbon;
use Mail;
use PDF;
use Storage;
use App\Custom\PhpWord;

class FundController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        $fund = Fund::create([
            'tenure_id' => auth()->user()->entity->tenures->last()->id,
            'address_id' => auth()->user()->entity->addresses->last()->address->id,
            'created_by_user_id' => auth()->id(),
            'applied_at' => Carbon::now(),
        ]);
        $fund->branches()->create([]);

        $errors_fund = count(($this->getErrors($fund))['fund']);

        $log = new LogSystem;
        $log->module_id = 22;
        $log->activity_type_id = 4;
        $log->description = "Tambah Borang ID1";
        $log->data_new = json_encode($fund);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

    	return view('finance.fund.index', compact('fund', 'meeting_types', 'errors_fund'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request) {

        $fund = Fund::findOrFail($request->id);

        $errors_fund = count(($this->getErrors($fund))['fund']);

        return view('finance.fund.index', compact('fund', 'meeting_types', 'errors_fund'));
    }

    /**
     * Show the list of data
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request) {

        if($request->ajax()) {
            $log = new LogSystem;
            $log->module_id = 22;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai Borang ID1";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $fund = Fund::with(['tenure.entity','status']);

            if(auth()->user()->hasRole('ks')) {
                $fund = $fund->whereHas('tenure', function($tenure) {
                    return $tenure->where('entity_type', auth()->user()->entity_type)->where('entity_id', auth()->user()->entity_id);
                });
            }
            else if(auth()->user()->hasAnyRole(['ptw','pthq'])) {
                $fund = $fund->where(function($fund) {
                    return $fund->where('filing_status_id', '>', 1)->whereHas('distributions', function($distributions) {
                        return $distributions->where('assigned_to_user_id', auth()->id());
                    })->orWhere(function($fund){
                        if(auth()->user()->hasRole('ptw'))
                            return $fund->whereDoesntHave('logs', function($logs) {
                                return $logs->where('activity_type_id', 12)->where('filing_status_id','<=', 3);
                            });
                        else
                            return $fund->whereHas('logs', function($logs) {
                                return $logs->where('role_id', 8)->where('activity_type_id', 14);
                            });
                    });
                });
            }
            else {
                $fund = $fund->where('filing_status_id', '>', 1)->whereHas('distributions', function($distributions) {
                    return $distributions->where('assigned_to_user_id', auth()->id());
                });
            }

            return datatables()->of($fund)
                ->editColumn('tenure.entity.name', function ($fund) {
                    return $fund->tenure->entity->name;
                })
                ->editColumn('tenure.entity.type', function ($fund) {
                    return $fund->tenure->entity_type == "App\\UserUnion" ? 'Kesatuan' : 'Persekutuan';
                })
                ->editColumn('applied_at', function ($fund) {
                    return $fund->applied_at ? date('d/m/Y', strtotime($fund->applied_at)) : '-';
                })
                ->editColumn('status.name', function ($fund) {
                    if($fund->filing_status_id == 9)
                        return '<span class="badge badge-success">'.$fund->status->name.'</span>';
                    else if($fund->filing_status_id == 8)
                        return '<span class="badge badge-danger">'.$fund->status->name.'</span>';
                    else if($fund->filing_status_id == 7)
                        return '<span class="badge badge-warning">'.$fund->status->name.'</span>';
                    else
                        return '<span class="badge badge-default">'.$fund->status->name.'</span>';
                })
                ->editColumn('letter', function($fund) {
                    $result = "";
                    if($fund->filing_status_id == 9){
                        $result .= letterButton(37, get_class($fund), $fund->id);
                    }
                    elseif($fund->filing_status_id == 8){
                        $result .= letterButton(38, get_class($fund), $fund->id);
                    }
                    return $result;
                    // return '<a href="'.route('fund.pdf', $fund->id).'" target="_blank" class="btn btn-default btn-xs mb-1"><i class="fa fa-download mr-1"></i>'.($fund->logs->count() > 0 ? date('d/m/Y', strtotime($fund->logs->first()->created_at)).' - ' : '').$fund->union->name.'</a><br>';
                })
                ->editColumn('action', function ($fund) {
                    $button = "";
                    $button .= '<a onclick="viewFiling(\''.addslashes(get_class($fund)).'\','.$fund->id.')" href="javascript:;" class="btn btn-default btn-xs mb-1"><i class="fa fa-search mr-1"></i> Lihat</a><br>';

                    if((auth()->user()->hasAnyRole(['ppw','pphq']) || (auth()->user()->hasRole('ks') && $fund->is_editable)) && $fund->filing_status_id < 7)
                        $button .= '<a href="'.route('fund.form', $fund->id).'" class="btn btn-primary btn-xs mb-1"><i class="fa fa-edit mr-1"></i> Kemaskini Borang</a><br>';

                    if(auth()->user()->hasRole('pthq'))
                        $button .= '<a onclick="status('.$fund->id.')" href="javascript:;" class="btn btn-primary btn-xs mb-1"><i class="fa fa-spinner mr-1"></i> Kemaskini Status</a><br>';

                    if( ((auth()->user()->hasRole('ptw') && $fund->distributions->count() == 0) || (auth()->user()->hasRole('pthq') && $fund->distributions->count() == 3)) && $fund->filing_status_id < 7 )
                        $button .= '<a onclick="receive('.$fund->id.')" href="javascript:;" class="btn btn-info btn-xs mb-1"><i class="fa fa-check mr-1"></i> Terima Dokumen Fizikal</a><br>';

                    if(auth()->user()->hasAnyRole(['ppw','pw', 'pphq', 'pkpp', 'kpks']) && $fund->filing_status_id < 8)
                        $button .= '<a onclick="query('.$fund->id.')" href="javascript:;" class="btn btn-warning btn-xs mb-1"><i class="fa fa-question mr-1"></i> Kuiri</a><br>';

                    if(auth()->user()->hasAnyRole(['ppw','pw', 'pphq', 'pkpp']) && $fund->filing_status_id < 7)
                        $button .= '<a onclick="recommend('.$fund->id.')" href="javascript:;" class="btn btn-warning btn-xs mb-1"><i class="fa fa-comment mr-1"></i> Ulasan/Syor</a><br>';

                    if(auth()->user()->hasRole('kpks') && $fund->filing_status_id < 8)
                        $button .= '<a onclick="process('.$fund->id.')" href="javascript:;" class="btn btn-success btn-xs mb-1"><i class="fa fa-spinner mr-1"></i> Proses</a><br>';

                    return $button;
                })
                ->make(true);
        }
        else {
            $log = new LogSystem;
            $log->module_id = 22;
            $log->activity_type_id = 9;
            $log->description = "Buka paparan Borang ID1";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();
        }

        return view('finance.fund.list');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function id1_index(Request $request) {

        $fund = Fund::findOrFail($request->id);
        $party_types = MasterPartyType::all();
        $meeting_types = MasterMeetingType::whereIn('id', [2,3])->get();
        $prior_collections = Fund::whereHas('tenure.entity', function($entity) {
                                return $entity->where('id', auth()->user()->entity->id);
                            })->where('filing_status_id', 9)->get();

    	return view('finance.fund.id1.index', compact('fund', 'meeting_types', 'prior_collections', 'party_types'));
    }

    // Participant CRUD START
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function participant_index(Request $request) {

        $log = new LogSystem;
        $log->module_id = 22;
        $log->activity_type_id = 1;
        $log->description = "Papar senarai Borang ID1 - Butiran Pengutip Dana";
        $log->data_old = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $fund = Fund::findOrFail($request->id);
        $participants = $fund->participants()->with(['party_type']);

        return datatables()->of($participants)
            ->editColumn('participant.name', function($participant) {
                return $participant->name;
            })
            ->editColumn('action', function ($participant) {
                $button = "";

                $button .= '<a onclick="editParticipant('.$participant->id.')" href="javascript:;" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a> ';
                $button .= '<a onclick="removeParticipant('.$participant->id.')" href="javascript:;" class="btn btn-danger btn-xs "><i class="fa fa-trash"></i></a> ';

                return $button;
            })
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function participant_insert(Request $request) {

        if($request->party_type_id == 1) {
            $validator = Validator::make($request->all(), [
                'member_no' => 'required|string',
                'individual_name' => 'required|string',
                'occupation' => 'required|string',
                'identification_no' => 'required|string',
                'phone' => 'required|string',
            ]);
        } else if($request->party_type_id == 2) {
            $validator = Validator::make($request->all(), [
                'individual_name' => 'required|string',
                'occupation' => 'required|string',
                'identification_no' => 'required|string',
                'phone' => 'required|string',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'company_name' => 'required|string',
                'registration_no' => 'required|string',
                'address_company' => 'required|string',
                'fax' => 'required|string',
                'email' => 'required|string',
                'phone_company' => 'required',
            ]);
        }

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $fund = Fund::findOrFail($request->id);

        if($request->party_type_id == 3) {
            $request->request->add(['name' => $request->company_name]);
            $request->request->add(['phone' => $request->phone_company]);
        } else
            $request->request->add(['name' => $request->individual_name]);

        $participant = $fund->participants()->create($request->all());

        $log = new LogSystem;
        $log->module_id = 22;
        $log->activity_type_id = 4;
        $log->description = "Tambah Borang ID1 - Butiran Pengutip Dana";
        $log->data_new = json_encode($participant);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data baru telah ditambah.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function participant_edit(Request $request) {

        $log = new LogSystem;
        $log->module_id = 22;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini Borang ID1 - Butiran Pengutip Dana";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $participant = FundParticipant::findOrFail($request->participant_id);
        $fund = Fund::findOrFail($request->id);
        $party_types = MasterPartyType::all();

        return view('finance.fund.id1.participant.edit', compact('participant', 'fund', 'party_types'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function participant_update(Request $request) {

        if($request->edit_party_type_id == 1) {
            $validator = Validator::make($request->all(), [
                'member_no' => 'required|string',
            ]);
        } else if($request->edit_party_type_id == 2) {
            $validator = Validator::make($request->all(), [
                'individual_name' => 'required|string',
                'occupation' => 'required|string',
                'identification_no' => 'required|string',
                'phone' => 'required|string',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'company_name' => 'required|string',
                'registration_no' => 'required|string',
                'address_company' => 'required|string',
                'fax' => 'required|string',
                'email' => 'required|string',
                'phone' => 'required|string',
            ]);
        }

        $participant = FundParticipant::findOrFail($request->participant_id);

        if($request->edit_party_type_id == 2)
            $request->request->add(['name' => $request->individual_name]);
        else
            $request->request->add(['name' => $request->company_name]);

        $request->request->add(['party_type_id' => $request->edit_party_type_id]);

        $log = new LogSystem;
        $log->module_id = 22;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Borang ID1 - Butiran Pengutip Dana";
        $log->data_old = json_encode($participant);

        // if($participant->party_type != $request->party_type)
        //     Empty the record to not have clashing data?
        $participant->update($request->all());

        $log->data_new = json_encode($participant);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Remove the specified resource from storage.
     * @param  Request $request
     * @return Response
     */
    public function participant_delete(Request $request) {

        $participant = FundParticipant::findOrFail($request->participant_id);

        $log = new LogSystem;
        $log->module_id = 22;
        $log->activity_type_id = 6;
        $log->description = "Padam Borang ID1 - Butiran Pengutip Dana";
        $log->data_old = json_encode($participant);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $participant->delete();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }

    // Participant CRUD END

    // Collection CRUD START
    public function collection_index(Request $request) {
        if($request->ajax()) {
            $log = new LogSystem;
            $log->module_id = 22;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai Borang ID1 - Kutipan Dana Terdahulu";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $fund = Fund::findOrFail($request->id);
            $collections = $fund->collections;

            return datatables()->of($collections)
                ->editColumn('year', function($collection) {
                    return date('Y', strtotime($collection->year));
                })
                ->editColumn('action', function ($collection) {
                    $button = "";
                    $button .= '<a onclick="viewCollection('.$collection->id.')" href="javascript:;" class="btn btn-primary btn-xs"><i class="fa fa-search"></i></a> ';
                    $button .= '<a onclick="removeCollection('.$collection->id.')" href="javascript:;" class="btn btn-danger btn-xs "><i class="fa fa-trash"></i></a> ';

                    return $button;
                })
                ->make(true);
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function collection_insert(Request $request) {

        $validator = Validator::make($request->all(), [
            'prior_fund_id' => 'required',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $fund = Fund::findOrFail($request->id);

        $prior = Fund::findOrFail($request->prior_fund_id);
        $request->request->add(['year' => $prior->start_date]);
        $request->request->add(['objective' => $prior->objective]);

        $collection = $fund->collections()->create($request->all());

        $log = new LogSystem;
        $log->module_id = 22;
        $log->activity_type_id = 4;
        $log->description = "Tambah Borang ID1 - Kutipan Dana Terdahulu";
        $log->data_new = json_encode($collection);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data baru telah ditambah.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function collection_view(Request $request) {

        $log = new LogSystem;
        $log->module_id = 22;
        $log->activity_type_id = 2;
        $log->description = "Popup lihat maklumat Borang ID1 - Kutipan Dana Terdahulu";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $fund_collection = FundCollection::findOrFail($request->collection_id);
        $collection = Fund::findOrFail($fund_collection->prior_fund_id);
        $fund = Fund::findOrFail($request->id);

        return view('finance.fund.id1.collection.view', compact('collection', 'fund'));
    }

    /**
     * Remove the specified resource from storage.
     * @param  Request $request
     * @return Response
     */
    public function collection_delete(Request $request) {

        $collection = FundCollection::findOrFail($request->collection_id);

        $log = new LogSystem;
        $log->module_id = 22;
        $log->activity_type_id = 6;
        $log->description = "Padam Borang ID1 - Kutipan Dana Terdahulu";
        $log->data_old = json_encode($collection);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $collection->delete();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }

    // Collection CRUD END

    // Bank CRUD START
    public function bank_index(Request $request) {
        if($request->ajax()) {
            $log = new LogSystem;
            $log->module_id = 22;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai Borang ID1 - Butiran Bank";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $fund = Fund::findOrFail($request->id);
            $banks = $fund->banks;

            return datatables()->of($banks)
                ->editColumn('action', function ($bank) {
                    $button = "";

                    $button .= '<a onclick="editBank('.$bank->id.')" href="javascript:;" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a> ';
                    $button .= '<a onclick="removeBank('.$bank->id.')" href="javascript:;" class="btn btn-danger btn-xs "><i class="fa fa-trash"></i></a> ';

                    return $button;
                })
                ->make(true);
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function bank_insert(Request $request) {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'account_no' => 'required|string',
            'balance' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $fund = Fund::findOrFail($request->id);

        $request->request->add(['fund_id', $request->id]);
        $bank = $fund->banks()->create($request->all());

        $log = new LogSystem;
        $log->module_id = 22;
        $log->activity_type_id = 4;
        $log->description = "Tambah Borang ID1 - Butiran Bank";
        $log->data_new = json_encode($bank);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data baru telah ditambah.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function bank_edit(Request $request) {

        $log = new LogSystem;
        $log->module_id = 22;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini Borang ID1 - Butiran Bank";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $bank = FundBank::findOrFail($request->bank_id);
        $fund = Fund::findOrFail($request->id);

        return view('finance.fund.id1.bank.edit', compact('bank', 'fund'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function bank_update(Request $request) {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'account_no' => 'required|string',
            'balance' => 'required|integer',
        ]);

        if ($validator->fails()) {
            // If validation fails
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $bank = FundBank::findOrFail($request->bank_id);

        $log = new LogSystem;
        $log->module_id = 22;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Borang ID1 - Butiran Bank";
        $log->data_old = json_encode($bank);

        $bank->update($request->all());

        $log->data_new = json_encode($bank);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Remove the specified resource from storage.
     * @param  Request $request
     * @return Response
     */
    public function bank_delete(Request $request) {

        $bank = FundBank::findOrFail($request->bank_id);

        $log = new LogSystem;
        $log->module_id = 22;
        $log->activity_type_id = 6;
        $log->description = "Padam Borang ID1 - Butiran Bank";
        $log->data_old = json_encode($bank);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $bank->delete();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }

    // Bank CRUD END

    private function getErrors($fund) {

        $errors = [];

        $validate_fund = Validator::make($fund->toArray(), [
            'objective' => 'required',
            'target_amount' => 'required|numeric',
            'estimated_expenses' => 'required|numeric',
            'start_date' => 'required',
            'end_date' => 'required',
            'meeting_type_id' => 'required',
            'resolved_at' => 'required',
            'quorum' => 'required|integer',
            'method' => 'required',
            'applied_at' => 'required',
        ]);

        $errors_fund = [];

        if ($validate_fund->fails())
            $errors_fund = array_merge($errors_fund, $validate_fund->errors()->toArray());

        if($fund->branches->count() == 0)
            $errors_fund = array_merge($errors_fund, ['branches' => 'Sila pilih sekurang-kurangnya satu cawangan.']);

        $errors['fund'] = $errors_fund;

        return $errors;
    }

    /**
     * Validate the application
     *
     * @return \Illuminate\Http\Response
     */
    public function submit(Request $request) {

        $fund = Fund::findOrFail($request->id);

        $error_list = $this->getErrors($fund);
        //return response()->json(['errors' => $errors], 422);

        if(count($error_list['fund']) > 0)
            return response()->json(['status' => 'error', 'title' => 'Harap Maaf!', 'message' => 'Anda masih belum melengkapkan borang ini. Sila semak semula.']);

        else {
            $log = new LogSystem;
            $log->module_id = 22;
            $log->activity_type_id = 5;
            $log->description = "Kemaskini Kutipan Dana - Hantar Notis";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $fund->logs()->updateOrCreate(
                [
                    'module_id' => 22,
                    'activity_type_id' => 11,
                    'filing_status_id' => $fund->filing_status_id,
                    'created_by_user_id' => auth()->id(),
                    'role_id' => auth()->user()->roles->last()->id,
                ],
                [
                    'data' => ''
                ]
            );

            $fund->filing_status_id = 2;
            $fund->is_editable = 0;
            $fund->save();

            $fund->references()->updateOrCreate(
                [ 'reference_type_id' => 1 ],[
                'reference_no' => '-',
                'module_id' => 22,
            ]);

            Mail::to($fund->created_by->email)->send(new Sent($fund, 'Permohonan Kutipan Dana'));

            return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Notis anda telah dihantar.']);
        }
    }

    /**
     * Distribute the application to specific user
     *
     * @return \Illuminate\Http\Response
     */
    private function distribute($fund, $target) {

        $check = $fund->distributions()->whereHas('assigned_to.entity_staff.role', function($role) use($target) {
            return $role->where('name', trim(strtolower($target)));
        });

        if($check->count() > 0)
            return;

        if($target == "ptw") {
            if($fund->distributions()->where('filing_status_id', 2)->count() > 1)
                return;

            // Distribute based on portfolio
            $ptw = ViewUserDistributionPTW::where('filing_type', 'App\FilingModel\Fund')->where('filing_status_id', 2)->orderBy('count');

            if($ptw->count() > 0)
                $ptw = $ptw->first();
            else
                $ptw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 6)->first();

            $fund->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $fund->filing_status_id,
                    'assigned_to_user_id' => auth()->id()
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );
        }
        else if($target == "ppw") {
            if($fund->distributions()->where('filing_status_id', 3)->count() > 2)
                return;

            // Distribute based on portfolio
            $ppw = ViewUserDistributionPPW::where('province_office_id', auth()->user()->entity->province_office_id)->where('filing_type', 'App\FilingModel\Fund')->where('filing_status_id', 3)->orderBy('count');

            if($ppw->count() > 0)
                $ppw = $ppw->first();
            else
                $ppw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 7)->first();

            $fund->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $fund->filing_status_id,
                    'assigned_to_user_id' => $ppw->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($ppw->user->email)->send(new Distributed($fund, 'Serahan Permohonan Kutipan Dana'));
        }
        else if($target == "pw") {
            if($fund->distributions()->where('filing_status_id', 6)->count() > 1)
                return;

            // Distribute based on portfolio
            $pw = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('province_office_id', auth()->user()->entity->province_office_id)->where('role_id', 8)->first();

            $fund->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $fund->filing_status_id,
                    'assigned_to_user_id' => $pw->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pw->user->email)->send(new Distributed($fund, 'Serahan Permohonan Kutipan Dana'));
        }
        else if($target == "pthq") {
            if($fund->distributions()->where('filing_status_id', 6)->count() > 2)
                return;

            // Distribute based on portfolio
            $pthq = ViewUserDistributionPTHQ::where('filing_type', 'App\FilingModel\Fund')->where('filing_status_id', 6)->orderBy('count');

            if($pthq->count() > 0)
                $pthq = $pthq->first();
            else
                $pthq = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',9)->first();

            $fund->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $fund->filing_status_id,
                    'assigned_to_user_id' => auth()->id()
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );
        }
        else if($target == "pphq") {
            if($fund->distributions()->where('filing_status_id', 4)->count() > 2)
                return;

            // Distribute based on portfolio
            $pphq = ViewUserDistributionPPHQ::where('province_office_id', auth()->user()->entity->province_office_id)->where('filing_type', 'App\FilingModel\Fund')->where('filing_status_id', 3)->orderBy('count');

            if($pphq->count() > 0)
                $pphq = $pphq->first();
            else
                $pphq = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',10)->first();

            $fund->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $fund->filing_status_id,
                    'assigned_to_user_id' => $pphq->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pphq->user->email)->send(new Distributed($fund, 'Serahan Permohonan Kutipan Dana'));
        }
        else if($target == "pkpp") {
            if($fund->distributions()->where('filing_status_id', 6)->count() > 3)
                return;

            // Distribute based on portfolio
            $pkpp = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',11)->first();

            $fund->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $fund->filing_status_id,
                    'assigned_to_user_id' => $pkpp->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($pkpp->user->email)->send(new Distributed($fund, 'Serahan Permohonan Kutipan Dana'));
        }
        else if($target == "kpks") {
            if($fund->distributions()->where('filing_status_id', 6)->count() > 4)
                return;

            // Distribute based on portfolio
            $kpks = UserStaff::whereHas('user', function($user) { return $user->where('user_status_id', 1); })->where('role_id',17)->first();

            $fund->distributions()->updateOrCreate(
                [
                    'filing_status_id' => $fund->filing_status_id,
                    'assigned_to_user_id' => $kpks->user->id
                ],
                [
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($kpks->user->email)->send(new Distributed($fund, 'Serahan Permohonan Kutipan Dana'));
        }
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_documentReceive_edit(Request $request) {

        $fund = Fund::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 22;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Kutipan Dana - Terima Dokumen Fizikal";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('fund.process.document-receive', $fund->id);

        return view('general.modal.document-receive', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_documentReceive_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 22;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Kutipan Dana - Terima Dokumen Fizikal";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $fund = Fund::findOrFail($request->id);

        $fund->filing_status_id = 3;
        $fund->save();

        $fund->references()->updateOrCreate(
            [
                'reference_type_id' => auth()->user()->hasAnyRole(['ptw','ppw','pw']) ? 1 : 2,
            ],
            [
                'reference_no' => $request->reference_no,
                'module_id' => 22,
            ]
        );

        $fund->logs()->updateOrCreate(
            [
                'module_id' => 22,
                'activity_type_id' => 12,
                'filing_status_id' => $fund->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->received_at
            ]
        );

        $this->distribute($fund, auth()->user()->entity->role->name);

        if(auth()->user()->hasRole('ptw')) {
            $this->distribute($fund, 'ppw');
            Mail::to($fund->created_by->email)->send(new Received(auth()->user(), $fund, 'Pengesahan Penerimaan Permohonan Kutipan Dana'));
        }
        else if(auth()->user()->hasRole('pthq')) {
            $this->distribute($fund, 'pphq');
            Mail::to($fund->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ppw'); })->first()->assigned_to->email)->send(new ReceivedHQ(auth()->user(), $fund, 'Pengesahan Penerimaan Permohonan Kutipan Dana'));
            Mail::to($fund->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pw'); })->first()->assigned_to->email)->send(new ReceivedHQ(auth()->user(), $fund, 'Pengesahan Penerimaan Permohonan Kutipan Dana'));
        }

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_query_edit(Request $request) {

        $fund = Fund::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 22;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Kutipan Dana - Kuiri";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('fund.process.query.item', $fund->id);
        $route2 = route('fund.process.query', $fund->id);

        return view('general.modal.query', compact('route','route2'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_query_update(Request $request) {

        $fund = Fund::findOrFail($request->id);

        if(count($fund->queries()->whereNull('log_filing_id')->get()) == 0) {
            return response()->json(['status' => 'error', 'title' => 'Harap Maaf!', 'message' => 'Sila masukkan sekurang-kurangnya satu (1) kuiri sebelum hantar.']);
        }

        $log = new LogSystem;
        $log->module_id = 22;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Kutipan Dana - Kuiri";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $fund->filing_status_id = 5;
        $fund->is_editable = 1;
        $fund->save();

        $log2 = $fund->logs()->updateOrCreate(
            [
                'module_id' => 22,
                'activity_type_id' => 13,
                'filing_status_id' => $fund->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => ''
            ]
        );

        if(auth()->user()->hasRole('pw')) {
            // Send to PPW
            $log = $fund->logs()->where('role_id', 7)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $fund, 'Kuiri Kutipan Dana oleh PW'));
        } else if(auth()->user()->hasRole('pkpp')) {
            // Send to PPHQ
            $log = $fund->logs()->where('role_id', 10)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $fund, 'Kuiri Kutipan Dana oleh PKPP'));
        } else if(auth()->user()->hasRole('kpks')) {
            // Send to pkpp
            $log = $fund->logs()->where('role_id', 11)->get()->last();
            Mail::to($log->created_by->email)->send(new Queried(auth()->user(), $fund, 'Kuiri Kutipan Dana oleh KPKS'));
        }
        else {
            // Send to KS
            Mail::to($fund->created_by->email)->send(new Queried(auth()->user(), $fund, 'Kuiri Kutipan Dana'));
        }

        $fund->queries()->where('created_by_user_id', auth()->id())->whereNull('log_filing_id')->update(['log_filing_id' => $log2->id]);

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the list of instance
     *
     * @return \Illuminate\Http\Response
     */
    public function process_query_item_list(Request $request) {
        if($request->ajax()) {
            $log = new LogSystem;
            $log->module_id = 22;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai (Proses) Kutipan Dana - Kuiri";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $fund = Fund::findOrFail($request->id);

            $queries = $fund->queries()->where('created_by_user_id', auth()->id())->whereNull('log_filing_id');

            return datatables()->of($queries)
                ->editColumn('action', function ($query) {
                    $button = "";
                    $button .= '<a href="javascript:;" onclick="edit(this,'.$query->id.')" class="btn btn-success btn-xs" data-toggle="tooltip" title="Kemaskini"><i class="fa fa-edit"></i></a> ';
                    $button .= '<a href="javascript:;" onclick="remove('.$query->id.')" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Padam"><i class="fa fa-trash"></i></a>';
                    return $button;
                })
                ->make(true);
        }
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_query_item_update(Request $request) {

        $fund = Fund::findOrFail($request->id);

        if($request->query_id) {
            $query = Query::findOrFail($request->query_id);

            $log = new LogSystem;
            $log->module_id = 22;
            $log->activity_type_id = 5;
            $log->description = "Kemaskini (Proses) Kutipan Dana - Kuiri";
            $log->data_old = json_encode($query);

            $query->update([
                'content' => $request->content
            ]);

            $log->data_new = json_encode($query);
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
        }
        else {
            $query = $fund->queries()->create([
                'content' => $request->content,
                'created_by_user_id' => auth()->id(),
            ]);

            $log = new LogSystem;
            $log->module_id = 22;
            $log->activity_type_id = 4;
            $log->description = "Tambah (Proses) Kutipan Dana - Kuiri";
            $log->data_new = json_encode($query);
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah disimpan.']);
        }


    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_query_item_delete(Request $request) {
        $query = Query::findOrFail($request->query_id);

        $log = new LogSystem;
        $log->module_id = 22;
        $log->activity_type_id = 6;
        $log->description = "Padam (Proses) Kutipan Dana - Kuiri";
        $log->data_old = json_encode($query);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $query->delete();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_recommend_edit(Request $request) {

        $fund = Fund::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 22;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Kutipan Dana - Ulasan / Syor";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $recommendation = $fund->logs()->where('activity_type_id',14)->where('filing_status_id', $fund->filing_status_id)->where('created_by_user_id', auth()->id());

        if($recommendation->count() > 0)
            $recommendation = $recommendation->first();
        else
            $recommendation = new LogFiling;

        $route = route('fund.process.recommend', $fund->id);

        return view('general.modal.recommend', compact('route', 'recommendation'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_recommend_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 22;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Kutipan Dana - Ulasan / Syor";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $fund = Fund::findOrFail($request->id);
        $fund->filing_status_id = 6;
        $fund->is_editable = 0;
        $fund->save();

        $fund->logs()->updateOrCreate(
            [
                'module_id' => 22,
                'activity_type_id' => 14,
                'filing_status_id' => $fund->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        if(auth()->user()->hasRole('ppw'))
            $this->distribute($fund, 'pw');
        else if(auth()->user()->hasRole('pphq'))
            $this->distribute($fund, 'pkpp');
        else if(auth()->user()->hasRole('pkpp'))
            $this->distribute($fund, 'kpks');
        else if(auth()->user()->hasRole('pw'))
            Mail::to($fund->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ptw'); })->first()->assigned_to->email)->send(new SendToHQ(auth()->user(), $fund, 'Serahan Permohonan Kutipan Dana'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_delay_edit(Request $request) {

        $fund = Fund::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 22;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Kutipan Dana - Tangguh";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('fund.process.delay', $fund->id);

        return view('general.modal.delay', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_delay_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 22;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Kutipan Dana - Tangguh";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $fund = Fund::findOrFail($request->id);
        $fund->filing_status_id = 7;
        $fund->is_editable = 0;
        $fund->save();

        $fund->logs()->updateOrCreate(
            [
                'module_id' => 22,
                'activity_type_id' => 15,
                'filing_status_id' => $fund->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_status_edit(Request $request) {

        $fund = Fund::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 22;
        $log->activity_type_id = 3;
        $log->description = "Popup (Kemaskini) Kutipan Dana - Status";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('fund.process.status', $fund->id);

        return view('general.modal.status', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_status_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 22;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini Kutipan Dana - Status";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $fund = Fund::findOrFail($request->id);

        $log = $fund->logs()->create([
                'module_id' => 22,
                'activity_type_id' => 20,
                'filing_status_id' => $fund->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id,
                'data' => $request->status_data,
        ]);

        $log->created_at = Carbon::createFromFormat('d/m/Y', $request->status_date)->toDateTimeString();
        $log->save();

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dikemaskini.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_result(Request $request) {

        $form = $fund = Fund::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 22;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Kutipan Dana - Keputusan";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route_reject = route("fund.process.result.reject", $form->id);
        $route_approve = route("fund.process.result.approve", $form->id);
        $route_delay = route("fund.process.delay", $form->id);

        return view('general.modal.result', compact('route_reject','route_approve','route_delay'));
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_result_approve_edit(Request $request) {

        $fund = Fund::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 22;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Kutipan Dana - Lulus";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('fund.process.result.approve', $fund->id);

        return view('general.modal.approve', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_result_approve_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 22;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Kutipan Dana - Lulus";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $fund = Fund::findOrFail($request->id);
        $fund->filing_status_id = 9;
        $fund->is_editable = 0;
        $fund->save();

        $fund->logs()->updateOrCreate(
            [
                'module_id' => 22,
                'activity_type_id' => 16,
                'filing_status_id' => $fund->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        Mail::to($fund->created_by->email)->send(new ApprovedKS($fund, 'Status Permohonan Kutipan Dana'));
        Mail::to($fund->created_by->email)->send(new ReminderStatement($fund, 'Peringatan Serahan Penyata Penerimaan Dan Pembayaran'));

        Mail::to($fund->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ptw'); })->first()->assigned_to->email)->send(new ApprovedPWN($fund, 'Status Permohonan Kutipan Dana'));
        Mail::to($fund->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ppw'); })->first()->assigned_to->email)->send(new ApprovedPWN($fund, 'Status Permohonan Kutipan Dana'));
        Mail::to($fund->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pw'); })->first()->assigned_to->email)->send(new ApprovedPWN($fund, 'Status Permohonan Kutipan Dana'));
        Mail::to($fund->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pthq'); })->first()->assigned_to->email)->send(new DocumentApproved($fund, 'Sedia Dokumen Kelulusan Kutipan Dana'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Permohonan Kesatuan Sekerja ini telah diluluskan. Pegawai Tadbir HQ akan dimaklumkan melalui emel.']);
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function process_result_reject_edit(Request $request) {

        $fund = Fund::findOrFail($request->id);

        $log = new LogSystem;
        $log->module_id = 22;
        $log->activity_type_id = 3;
        $log->description = "Popup (Proses) Kutipan Dana - Tidak Lulus";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $route = route('fund.process.result.reject', $fund->id);

        return view('general.modal.reject', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function process_result_reject_update(Request $request) {

        $log = new LogSystem;
        $log->module_id = 22;
        $log->activity_type_id = 5;
        $log->description = "Kemaskini (Proses) Kutipan Dana - Tidak Lulus";
        $log->data_new = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $fund = Fund::findOrFail($request->id);
        $fund->filing_status_id = 8;
        $fund->is_editable = 0;
        $fund->save();

        $fund->logs()->updateOrCreate(
            [
                'module_id' => 22,
                'activity_type_id' => 16,
                'filing_status_id' => $fund->filing_status_id,
                'created_by_user_id' => auth()->id(),
                'role_id' => auth()->user()->entity->role_id
            ],
            [
                'data' => $request->data
            ]
        );

        Mail::to($fund->created_by->email)->send(new Rejected($fund, 'Status Permohonan Kutipan Dana'));

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Permohonan Kesatuan Sekerja ini telah ditolak. Kesatuan Sekerja akan dimaklumkan melalui emel.']);
    }

    public function download(Request $request) {

        $filing = Fund::findOrFail($request->id);
                                                             // Change here
        setlocale(LC_TIME, "ms", "my_MS", "ms_MY");
        $data = [                                                                                       // Change here
            'entity_name' => htmlspecialchars($filing->tenure->entity->name),
            'entity_address' => htmlspecialchars($filing->address->address1).
                ($filing->address->address2 ? ', '.htmlspecialchars($filing->address->address2) : '').
                ($filing->address->address3 ? ', '.htmlspecialchars($filing->address->address3) : '').
                ', '.($filing->address->postcode).
                ($filing->address->district ? ' '.htmlspecialchars($filing->address->district->name) : '').
                ($filing->address->state ? ', '.htmlspecialchars($filing->address->state->name) : ''),
            'meeting_type' => $filing->meeting_type ? htmlspecialchars($filing->meeting_type->name) : '',
            'resolved_at' => htmlspecialchars(strftime('%e %B %Y', strtotime($filing->resolved_at))),
            'objective' => htmlspecialchars(preg_replace('<br>', '<w:br/>', $filing->objective)),
            'target_amount' => htmlspecialchars($filing->target_amount),
            'estimated_expenses' => htmlspecialchars($filing->estimated_expenses),
            'quorum' => htmlspecialchars($filing->quorum),
            'method' => htmlspecialchars(preg_replace('<br>', '<w:br/>', $filing->method)),
            'is_participate' => $filing->participants()->whereIn('party_type', [2,3])->get() ? htmlspecialchars('Ya') : htmlspecialchars('Tidak'),
            'start_date' => htmlspecialchars(date('d/m/Y', strtotime($filing->start_date))),
            'end_date' => htmlspecialchars(date('d/m/Y', strtotime($filing->end_date))),
            'today_date' => htmlspecialchars(strftime('%e %B %Y')),
            'secretary_name' => htmlspecialchars($filing->tenure->entity->user->name),
            'identification_no' => htmlspecialchars($filing->tenure->entity->user->username),
        ];

        $log = new LogSystem;
        $log->module_id = 22;                                                                            // Change here
        $log->activity_type_id = 19;
        $log->description = "Cetak Dokumen";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        // Creating the new document...
        $phpWord = new PhpWord();

        //Searching for values to replace
        $document = $phpWord->loadTemplate(storage_path('templates/filings/finance/id1.docx'));        // Change here

        foreach($data as $key => $value) {
            $document->setValue($key, $value);
        }

        // Generate list
        $collections = $filing->collections;

        $document->cloneBlockString('list', count($collections));

        foreach($collections as $index => $collection){
            $content = preg_replace('~\R~u', '<w:br/>', $collection->year);
            $document->setValue('year', ucfirst($content), 1);
        }
        // Generate list
        $branches = $filing->branches;

        $document->cloneBlockString('list2', count($branches));

        foreach($branches as $index => $branch){
            $address = $branch->branch ?
                ', '.htmlspecialchars($branch->branch->address->address1).
                ($branch->branch->address->address2 ? ', '.htmlspecialchars($branch->branch->address->address2) : '').
                ($branch->branch->address->address3 ? ', '.htmlspecialchars($branch->branch->address->address3) : '').
                ', '.($branch->branch->address->postcode).
                ($branch->branch->address->district ? ' '.htmlspecialchars($branch->branch->address->district->name) : '').
                ($branch->branch->address->state ? ', '.htmlspecialchars($branch->branch->address->state->name) : '') : '';
            $document->setValue('branch_name', ($branch->branch ? $branch->branch->name : ''), 1);
            $document->setValue('branch_address', $address, 1);
        }

        // Generate table participant-nonmember
        $rows2 = $filing->participants()->whereNotNull('identification_no')->get();

        // dd($document->getVariables());
        $document->cloneRow('individualname', count($rows2));

        foreach($rows2 as $index => $row2) {

            $document->setValue('no#'.($index+1), $index+1);
            $document->setValue('individualname#'.($index+1), htmlspecialchars(ucwords($row2->name)));
            $document->setValue('occupation#'.($index+1), htmlspecialchars(ucwords($row2->occupation)));
            $document->setValue('identificationno#'.($index+1), htmlspecialchars(strtoupper($row2->identification_no)));
            $document->setValue('phoneno#'.($index+1), htmlspecialchars($row2->phone));
        }

        // Generate table participant-company
        $rows3 = $filing->participants()->whereNotNull('registration_no')->get();
        $document->cloneRow('registration_no', count($rows3));

        foreach($rows3 as $index => $row3) {

            $document->setValue('no#'.($index+1), $index+1);
            $document->setValue('registration_no#'.($index+1), htmlspecialchars($row3->registration_no));
            $document->setValue('address_company#'.($index+1), htmlspecialchars(ucwords(preg_replace('<br>', '<w:br/>', $row3->address_company))));
            $document->setValue('email#'.($index+1), htmlspecialchars($row3->email));
            $document->setValue('phonecompany#'.($index+1), htmlspecialchars($row3->phone));
            $document->setValue('fax#'.($index+1), htmlspecialchars($row3->fax));
        }

        // Generate table bank
        $rows4 = $filing->banks;
        $document->cloneRow('account_name', count($rows4));

        foreach($rows4 as $index => $row4) {

            $document->setValue('account_name#'.($index+1), htmlspecialchars(strtoupper($row4->name)));
            $document->setValue('account_no#'.($index+1), htmlspecialchars(strtoupper($row4->account_no)));
            $document->setValue('balance#'.($index+1), htmlspecialchars(strtoupper($row4->balance)));
        }

        // Generate table participant
        $rows5 = $filing->participants()->whereNotNull('member_no')->get();
        $document->cloneRow('no', count($rows5));

        foreach($rows5 as $index => $row5) {

            $document->setValue('no#'.($index+1), ($index+1));
            $document->setValue('member_name#'.($index+1), '');
            $document->setValue('member_designation#'.($index+1), '');
            $document->setValue('member_ic#'.($index+1), '');
            $document->setValue('member_phone#'.($index+1), '');
        }

        // save as a random file in temp file
        $file_name = uniqid().'_'.'Borang ID1';                                                          // Change here
        $temp_file = storage_path('tmp/'.$file_name.'.docx');
        $document->saveAs($temp_file);

        return docxToPdf($temp_file);
    }
}
