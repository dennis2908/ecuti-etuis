<div class="modal fade slide-up show" id="modal-search" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content-wrapper">
            <div class="modal-content">
                <div class="modal-header clearfix text-left" style="background-color: #f3f3f3;">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                    </button>
                    <h5>Maklumat <span class="semi-bold">Permohonan {{ $entity->name }}</span></h5>
                    <p class="p-b-10">Semua maklumat berkenaan Permohonan tersebut telah dipaparkan dalam bentuk kronologi dibawah</p>

                    @if($entity->user->user_type_id > 2)
                    <div class="pb-3">
                        Nama {{ $entity->user->user_type_id == 3 ? 'Kesatuan' : 'Persekutuan' }} : <strong>{{ $entity->name }}</strong></span><br>
                        Tarikh Penubuhan : <strong>{{ date('d/m/Y', strtotime($entity->registered_at)) }}</strong><br>
                        Nama Setiausaha : <strong>{{ $entity->user->name }}</strong>
                    </div>
                    @endif
                </div>
                <div class="modal-body pt-3">
                    <div class="notification-panel no-border">
                    	<div class="notification-body">
                            <div class="row">
                                <div class="col-md-8">
                                    @foreach($filing->logs as $log)

                                        <?php
                                            $item_title = $log->activity_type->name;

                                            if($log->activity_type_id == 13 || $log->activity_type_id == 14) {
                                                $item_type = 'warning';
                                            }
                                            else if($log->activity_type_id == 16) {
                                                if($filing->filing_status_id > 8) {
                                                    $item_type = 'success';
                                                    $item_title = 'Permohonan Diluluskan';
                                                }
                                                else if($filing->filing_status_id == 2) {
                                                    $item_type = 'success';
                                                    $item_title = 'Pemeriksaan Diluluskan';
                                                }
                                                else {
                                                    $item_type = 'danger';
                                                    $item_title = 'Permohonan Ditolak';
                                                }
                                            }
                                            else
                                                $item_type = 'complete';
                                        ?>

                                        @component('components.timeline.item', [
                                            'title' => $item_title,
                                            'subtitle' => $log->role->description,
                                            'date' => date('d/m/Y', strtotime($log->created_at)),
                                            'type' => $item_type,
                                        ])
                                        @if($log->data)
                                            @if(auth()->user()->hasRole('ks') && $log->activity_type_id >= 14 && $log->activity_type_id <= 16 )
                                            @else
                                                @component('components.timeline.content', ['title'=>''])
                                                    <span style="padding-left: 30px;">{!! $log->data !!}</span>
                                                @endcomponent
                                            @endif
                                        @elseif($log->activity_type_id == 13)
                                            @component('components.timeline.content', ['title'=>''])
                                                <ul>
                                                    @foreach($log->queries as $query)
                                                    <li class="small hint-text">{!! $query->content !!}</li>
                                                    @endforeach
                                                </ul>
                                            @endcomponent
                                        @endif
                                        @endcomponent
                                    @endforeach
                                </div>
                                <div class="col-md-4">
                                    <h6 class="bold">Lampiran Dokumen</h6>
                                    <hr>
                                    <!-- Filing attachment -->
                                    @if(get_class($filing) == 'App\\FilingModel\FormB')
                                        <a href="{{ route('download.formb', ['id' => $filing->id]) }}" class="btn btn-default btn-xs m-b-5"><i class="fa fa-download m-r-5"></i> Borang B2</a><br>
                                        @if(!$filing->has_branch)
                                            <a href="{{ route('download.formb3', ['id' => $filing->id]) }}" class="btn btn-default btn-xs m-b-5"><i class="fa fa-download m-r-5"></i> Borang B3</a><br>
                                        @else
                                            <a href="{{ route('download.formb4', ['id' => $filing->id]) }}" class="btn btn-default btn-xs m-b-5"><i class="fa fa-download m-r-5"></i> Borang B4</a><br>
                                        @endif
                                    @elseif(get_class($filing) == 'App\\FilingModel\FormBB')
                                        <a href="{{ route('download.formbb', ['id' => $filing->id]) }}" class="btn btn-default btn-xs m-b-5"><i class="fa fa-download m-r-5"></i> Borang BB2</a><br>
                                        <a href="{{ route('download.formbb3', ['id' => $filing->id]) }}" class="btn btn-default btn-xs m-b-5"><i class="fa fa-download m-r-5"></i> Borang BB3</a><br>
                                    @elseif(get_class($filing) == 'App\\FilingModel\FormPQ')
                                        <a href="{{ route('download.formp', ['id' => $filing->id]) }}" class="btn btn-default btn-xs m-b-5"><i class="fa fa-download m-r-5"></i> Borang P</a><br>
                                        <a href="{{ route('download.formq', ['id' => $filing->id]) }}" class="btn btn-default btn-xs m-b-5"><i class="fa fa-download m-r-5"></i> Borang Q</a><br>
                                    @elseif(get_class($filing) == 'App\\FilingModel\FormWW')
                                        <a href="{{ route('download.formww', ['id' => $filing->id]) }}" class="btn btn-default btn-xs m-b-5"><i class="fa fa-download m-r-5"></i> Borang WW</a><br>
                                    @elseif(get_class($filing) == 'App\\FilingModel\FormW')
                                        <a href="{{ route('download.formw', ['id' => $filing->id]) }}" class="btn btn-default btn-xs m-b-5"><i class="fa fa-download m-r-5"></i> Borang W</a><br>
                                    @elseif(get_class($filing) == 'App\\FilingModel\FormG')
                                        <a href="{{ route('download.formg', ['id' => $filing->id]) }}" class="btn btn-default btn-xs m-b-5"><i class="fa fa-download m-r-5"></i> Borang G</a><br>
                                    @elseif(get_class($filing) == 'App\\FilingModel\FormJ')
                                        <a href="{{ route('download.formj', ['id' => $filing->id]) }}" class="btn btn-default btn-xs m-b-5"><i class="fa fa-download m-r-5"></i> Borang J</a><br>
                                    @elseif(get_class($filing) == 'App\\FilingModel\FormK')
                                        <a href="{{ route('download.formk', ['id' => $filing->id]) }}" class="btn btn-default btn-xs m-b-5"><i class="fa fa-download m-r-5"></i> Borang K</a><br>
                                        <a href="{{ route('download.formk2', ['id' => $filing->id]) }}" class="btn btn-default btn-xs m-b-5"><i class="fa fa-download m-r-5"></i> Borang K2</a><br>
                                        <a href="{{ route('download.formk3', ['id' => $filing->id]) }}" class="btn btn-default btn-xs m-b-5"><i class="fa fa-download m-r-5"></i> Borang K3</a><br>
                                    @elseif(get_class($filing) == 'App\\FilingModel\FormLU')
                                        <a href="{{ route('download.formlu.forml', ['id' => $filing->id]) }}" class="btn btn-default btn-xs m-b-5"><i class="fa fa-download m-r-5"></i> Borang L</a><br>
                                        <a href="{{ route('download.formlu.formu', ['id' => $filing->id]) }}" class="btn btn-default btn-xs m-b-5"><i class="fa fa-download m-r-5"></i> Borang U</a><br>
                                    @elseif(get_class($filing) == 'App\\FilingModel\FormL')
                                        <a href="{{ route('download.forml', ['id' => $filing->id]) }}" class="btn btn-default btn-xs m-b-5"><i class="fa fa-download m-r-5"></i> Borang L</a><br>
                                    @elseif(get_class($filing) == 'App\\FilingModel\FormL1')
                                        <a href="{{ route('download.forml1', ['id' => $filing->id]) }}" class="btn btn-default btn-xs m-b-5"><i class="fa fa-download m-r-5"></i> Borang L1</a><br>
                                    @elseif(get_class($filing) == 'App\\FilingModel\FormIEU')
                                        <a href="{{ route('download.formi', ['id' => $filing->id]) }}" class="btn btn-default btn-xs m-b-5"><i class="fa fa-download m-r-5"></i> Borang I</a><br>
                                        <a href="{{ route('download.forme', ['id' => $filing->id]) }}" class="btn btn-default btn-xs m-b-5"><i class="fa fa-download m-r-5"></i> Borang E</a><br>
                                        <a href="{{ route('download.formieu.formu', ['id' => $filing->id]) }}" class="btn btn-default btn-xs m-b-5"><i class="fa fa-download m-r-5"></i> Borang U</a><br>
                                    @elseif(get_class($filing) == 'App\\FilingModel\Fund')
                                        <a href="{{ route('download.fund', ['id' => $filing->id]) }}" class="btn btn-default btn-xs m-b-5"><i class="fa fa-download m-r-5"></i> Borang ID1</a><br>
                                    @elseif(get_class($filing) == 'App\\FilingModel\Insurance')
                                        <a href="{{ route('download.insurance', ['id' => $filing->id]) }}" class="btn btn-default btn-xs m-b-5"><i class="fa fa-download m-r-5"></i> Borang INS1</a><br>
                                        <a href="{{ route('download.insurance.formu', ['id' => $filing->id]) }}" class="btn btn-default btn-xs m-b-5"><i class="fa fa-download m-r-5"></i> Borang U</a><br>
                                    @elseif(get_class($filing) == 'App\\FilingModel\Levy')
                                        <a href="{{ route('download.levy', ['id' => $filing->id]) }}" class="btn btn-default btn-xs m-b-5"><i class="fa fa-download m-r-5"></i> Borang PLV1</a><br>
                                        <a href="{{ route('download.levy.formu', ['id' => $filing->id]) }}" class="btn btn-default btn-xs m-b-5"><i class="fa fa-download m-r-5"></i> Borang U</a><br>
                                    @elseif(get_class($filing) == 'App\\FilingModel\FormJL1')
                                        <a href="{{ route('download.jl1', ['id' => $filing->id]) }}" class="btn btn-default btn-xs m-b-5"><i class="fa fa-download m-r-5"></i> Borang JL11</a><br>
                                    @elseif(get_class($filing) == 'App\\FilingModel\FormN')
                                        <a href="{{ route('download.formn', ['id' => $filing->id]) }}" class="btn btn-default btn-xs m-b-5"><i class="fa fa-download m-r-5"></i> Borang BN1</a><br>
                                    @elseif(get_class($filing) == 'App\\FilingModel\Exception68')
                                        <a href="{{ route('download.exception_68', ['id' => $filing->id]) }}" class="btn btn-default btn-xs m-b-5"><i class="fa fa-download m-r-5"></i> Borang PP68</a><br>
                                    @elseif(get_class($filing) == 'App\\FilingModel\Exception30')
                                        <a href="{{ route('download.exception_30', ['id' => $filing->id]) }}" class="btn btn-default btn-xs m-b-5"><i class="fa fa-download m-r-5"></i> Notis Pengecualian</a><br>
                                    @elseif(get_class($filing) == 'App\\FilingModel\Strike')
                                        <a href="{{ route('download.strike', ['id' => $filing->id]) }}" class="btn btn-default btn-xs m-b-5"><i class="fa fa-download m-r-5"></i> Notis Mogok</a><br>
                                    @elseif(get_class($filing) == 'App\\FilingModel\Lockout')
                                        <a href="{{ route('download.lockout', ['id' => $filing->id]) }}" class="btn btn-default btn-xs m-b-5"><i class="fa fa-download m-r-5"></i> Notis Tutup Pintu</a><br>
                                    @elseif(get_class($filing) == 'App\\FilingModel\Enforcement')
                                        <a href="{{ route('download.pbp2', ['id' => $filing->id]) }}" class="btn btn-default btn-xs m-b-5"><i class="fa fa-download m-r-5"></i> Laporan Pemeriksaan</a><br>
                                        @if($filing->a1->count() != 0)
                                            <a href="{{ route('download.pbp2.a1', ['id' => $filing->id]) }}" target="_blank" class="btn btn-default mr-2 mb-1 btn-lock"><i class="fa fa-print mr-1"></i> Cetak Lampiran A1</a><br>
                                            @endif
                                            @if($filing->a2->count() != 0)
                                            <a href="{{ route('download.pbp2.a2', ['id' => $filing->id]) }}" target="_blank" class="btn btn-default mr-2 mb-1 btn-lock"><i class="fa fa-print mr-1"></i> Cetak Lampiran A2</a><br>
                                            @endif
                                            @if($filing->a3->count() != 0)
                                            <a href="{{ route('download.pbp2.a3', ['id' => $filing->id]) }}" target="_blank" class="btn btn-default mr-2 mb-1 btn-lock"><i class="fa fa-print mr-1"></i> Cetak Lampiran A3</a><br>
                                            @endif
                                            @if($filing->a4->count() != 0)
                                            <a href="{{ route('download.pbp2.a4', ['id' => $filing->id]) }}" target="_blank" class="btn btn-default mr-2 mb-1 btn-lock"><i class="fa fa-print mr-1"></i> Cetak Lampiran A4</a><br>
                                            @endif
                                            @if($filing->a5->count() != 0)
                                                @foreach($filing->a5 as $a5)
                                                <a href="{{ route('download.pbp2.a5', ['id' => $filing->id, 'a5_id' => $a5->branch_id]) }}" target="_blank" class="btn btn-default mr-2 mb-1 btn-lock"><i class="fa fa-print mr-1"></i> Cetak Lampiran A5 [ {{ $a5->branch->name }} ]</a><br>
                                                @endforeach
                                            @endif
                                            @if($filing->a6->count() != 0)
                                            <a href="{{ route('download.pbp2.a6', ['id' => $filing->id]) }}" target="_blank" class="btn btn-default mr-2 mb-1 btn-lock"><i class="fa fa-print mr-1"></i> Cetak Lampiran A6</a><br>
                                            @endif
                                            @if($filing->b1->count() != 0)
                                            <a href="{{ route('download.pbp2.b1', ['id' => $filing->id]) }}" target="_blank" class="btn btn-default mr-2 mb-1 btn-lock"><i class="fa fa-print mr-1"></i> Cetak Lampiran B1</a><br>
                                            @endif
                                            @if($filing->c1)
                                            <a href="{{ route('download.pbp2.c1', ['id' => $filing->id]) }}" target="_blank" class="btn btn-default mr-2 mb-1 btn-lock"><i class="fa fa-print mr-1"></i> Cetak Lampiran C1</a><br>
                                            @endif
                                            @if($filing->d1->count() != 0)
                                            <a href="{{ route('download.pbp2.d1', ['id' => $filing->id]) }}" target="_blank" class="btn btn-default mr-2 mb-1 btn-lock"><i class="fa fa-print mr-1"></i> Cetak Lampiran D1</a><br>
                                            @endif
                                    @endif

                                    <!-- Uploaded attachment -->
                                    @if($filing->attachments)
                                        @foreach($filing->attachments as $index => $attachment)
                                            <a href="{{ route('general.getAttachment', [$attachment->id, $attachment->name]) }}" class="btn btn-default btn-xs m-b-5"><i class="fa fa-download m-r-5"></i> Lampiran{{ $filing->attachments->count() > 1 ? ' #'. strval($index+1) : '' }}</a><br>
                                        @endforeach
                                    @endif

                                    <!-- Letter attachment -->
                                    @if($filing->letters)
                                        @foreach($filing->letters as $letter)
                                            @if($letter->attachment)
                                                <a href="{{ route('general.getAttachment', [$letter->attachment->id, $letter->attachment->name]) }}" class="btn btn-default btn-xs m-b-5"><i class="fa fa-download m-r-5"></i> {{ $letter->type->name }}</a><br>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                    	</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/global.js') }}"></script>
<script type="text/javascript">
    $('#modal-search').modal('show');
</script>
