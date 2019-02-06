<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MasterModel\MasterLetterType;
use App\LogModel\LogSystem;
use Storage;

class LetterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        if($request->ajax()) {
            $log = new LogSystem;
            $log->module_id = 47;
            $log->activity_type_id = 1;
            $log->description = "Papar senarai Pengurusan Paparan Surat";
            $log->data_old = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            $types = MasterLetterType::with(['module']);

            return datatables()->of($types)
                ->editColumn('action', function ($type) {
                    $button = "";
                    // $button .= '<a href="#" class="btn btn-info btn-xs"><i class="fa fa-search"></i></a> ';
                    $button .= '<a onclick="edit('.$type->id.')" href="javascript:;" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a> ';
                    return $button;
                })
                ->make(true);
        }
        else {
            $log = new LogSystem;
            $log->module_id = 47;
            $log->activity_type_id = 9;
            $log->description = "Buka paparan Pengurusan Paparan Surat";
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();
        }

        return view('admin.letter.index');
    }

    /**
     * Show the specified resource.
     * @param  Request $request
     * @return Response
     */
    public function edit(Request $request)
    {
        $log = new LogSystem;
        $log->module_id = 47;
        $log->activity_type_id = 3;
        $log->description = "Popup kemaskini Pengurusan Paparan Surat";
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $type = MasterLetterType::findOrFail($request->id);

        return view('admin.letter.edit', compact('type'));
    }

    /**
     * Show the list of resources
     *
     * @return \Illuminate\Http\Response
     */
    public function attachment_index(Request $request) {

        $type = MasterLetterType::findOrFail($request->id);
        $dir = str_replace('.', '/', $type->template_name);

        $log = new LogSystem;
        $log->module_id = 47;
        $log->activity_type_id = 1;
        $log->description = "Papar senarai Pengurusan Paparan Surat - Dokumen Sokongan";
        $log->data_old = json_encode($request->input());
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        $attachments = [];

        if(Storage::disk('templates_letters')->exists($dir.'.docx'))
            array_push($attachments, [
                'id' => $type->id,
                'name' => $type->name,
                'url' => route('general.getLetterTemplate', ['letter_type_id' => $type->id, 'filename' => $type->name.'.docx']),
                'size' => Storage::disk('templates_letters')->size($dir.'.docx')
            ]);

        return response()->json($attachments);
    }

    /**
     * Store resources into storage
     *
     * @return \Illuminate\Http\Response
     */
    public function attachment_insert(Request $request) {

        $type = MasterLetterType::findOrFail($request->id);
        $paths = explode('.', $type->template_name);

        if($request->file('file')->isValid()) {
            $path = Storage::disk('templates_letters')->putFileAs(
                $paths[0],
                $request->file('file'),
                $paths[1].'.docx'
            );

            $log = new LogSystem;
            $log->module_id = 47;
            $log->activity_type_id = 4;
            $log->description = "Tambah Pengurusan Paparan Surat - Dokumen Sokongan";
            $log->data_new = json_encode($request->input());
            $log->url = $request->fullUrl();
            $log->method = strtoupper($request->method());
            $log->ip_address = $request->ip();
            $log->created_by_user_id = auth()->id();
            $log->save();

            return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah disimpan.', 'id' => $type->id]);
        }
    }

    /**
     * Delete resources from storage
     *
     * @return \Illuminate\Http\Response
     */
    public function attachment_delete(Request $request) {
        $type = MasterLetterType::findOrFail($request->id);
        $dir = str_replace('.', '/', $type->template_name);

        $log = new LogSystem;
        $log->module_id = 47;
        $log->activity_type_id = 6;
        $log->description = "Padam Pengurusan Paparan Surat - Dokumen Sokongan";
        $log->data_old = json_encode($type);
        $log->url = $request->fullUrl();
        $log->method = strtoupper($request->method());
        $log->ip_address = $request->ip();
        $log->created_by_user_id = auth()->id();
        $log->save();

        Storage::disk('templates_letters')->delete($dir.'.docx');

        return response()->json(['status' => 'success', 'title' => 'Berjaya!', 'message' => 'Data telah dipadam.']);
    }
}
