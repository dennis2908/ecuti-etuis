<div class="modal fade slide-up show" id="modal-search" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content-wrapper">
            <div class="modal-content">
                <div class="modal-header clearfix text-left" style="background-color: #f3f3f3;">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                    </button>
                    <h5>Maklumat <span class="semi-bold">Permohonan {{ $entity->name }}</span></h5>
                    <p class="p-b-10">Semua maklumat berkenaan Permohonan tersebut telah dipaparkan dalam bentuk kronologi dibawah</p>

                    <div class="pb-3">
                        Nama {{ $entity->user->user_type_id == 3 ? 'Kesatuan' : 'Persekutuan' }} : <a onclick="openModalKS()" href="javascript:;" class="text-complete bold">{{ $entity->name }}</a ></span><br>
                        Tarikh Penubuhan : <strong>{{ date('d/m/Y', strtotime($entity->registered_at)) }}</strong><br>
                        Nama Setiausaha : <strong>{{ $entity->user->name }}</strong>
                    </div>
                </div>
                <div class="modal-body pt-3">
                    <div class="notification-panel no-border">
                    	<div class="notification-body">
                            <div class="row">
                                <div class="col-md-8">
                                    @foreach($logs as $log)
                                        @component('components.timeline.item', [
                                            'title' => $log->activity_type->name,
                                            'subtitle' => $log->role->description,
                                            'date' => date('d/m/Y', strtotime($log->created_at)),
                                            'type' => $log->data ? 'warning' : 'complete',
                                        ])
                                        @if($log->data)
                                            @component('components.timeline.content', ['title'=>''])
                                                {!! $log->data !!}
                                            @endcomponent
                                        @endif
                                        @endcomponent
                                    @endforeach
                                </div>
                                <div class="col-md-4">
                                    <h6 class="bold">Lampiran Dokumen</h6>
                                    <hr>
                                    <!-- Filing attachment -->

                                    <!-- Letter attachment -->
                                    <a class="btn btn-default btn-xs"><i class="fa fa-download m-r-5"></i> Borang Notis / Permohonan</a>
                                    <a class="btn btn-default btn-xs"><i class="fa fa-download m-r-5"></i> Surat Kelulusan</a>
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
