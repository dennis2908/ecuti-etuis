<!-- Modal -->
<div class="modal fade" id="modal-view" tabindex="-1" role="dialog" aria-labelledby="addModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalTitle">Papar <span class="bold">Jejak Audit</span></h5>
                <small class="text-muted">Sila lihat maklumat di bawah.</small>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body m-t-20">

                <div class="row">
                    <div class="col-md-5">
                        @component('components.label', [
                            'name' => 'module',
                            'label' => 'Modul',
                        ])
                        {{ $audit_log->module->name }}
                        @endcomponent

                        @component('components.label', [
                            'name' => 'activity_type',
                            'label' => 'Jenis Aktiviti',
                        ])
                        @if($audit_log->activity_type_id == 6)
                            <span class="badge badge-danger">{{ $audit_log->activity_type->name }}</span>
                        @else
                            <span class="badge badge-default">{{ $audit_log->activity_type->name }}</span>
                        @endif
                        @endcomponent

                        @component('components.label', [
                            'name' => 'description',
                            'label' => 'Butiran',                    
                        ])
                        {{ $audit_log->description }}
                        @endcomponent

                        @component('components.label', [
                            'name' => 'url',
                            'label' => 'URL / Pautan',
                        ])
                        <span class="badge badge-default">{{ $audit_log->method }}</span> <a href="{{ $audit_log->url }}">{{ $audit_log->url }}</a>
                        @endcomponent

                        @component('components.label', [
                            'name' => 'ip_address',
                            'label' => 'Alamat IP',
                        ])
                        {{ $audit_log->ip_address }}
                        @endcomponent

                        @component('components.label', [
                            'name' => 'created_by',
                            'label' => 'Dibuat Oleh',
                        ])
                        {{ $audit_log->created_by->name }}
                        @endcomponent

                        @component('components.label', [
                            'name' => 'created_at',
                            'label' => 'Dibuat Pada',
                        ])
                        {{ $audit_log->created_at }}
                        @endcomponent
                    </div>
                    <div class="col-md-7">
                        @component('components.label', [
                            'name' => 'data_old',
                            'label' => 'Data Lama',
                        ])
                        <div id="json-new" style="word-wrap: break-word;"></div>
                        @endcomponent

                        @component('components.label', [
                            'name' => 'data_new',
                            'label' => 'Data Baru',
                        ])
                        <div id="json-old" style="word-wrap: break-word;"></div>
                        @endcomponent
                    </div>
                </div>

            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div> -->
        </div>
    </div>
</div>
<script type="text/javascript">
$('#modal-view').modal('show');

$('#json-new').jsonPresenter({
    json: {!! $audit_log->data_old ? $audit_log->data_old : "{}" !!} // JSON objects here
});

$('#json-old').jsonPresenter({
    json: {!! $audit_log->data_new ? $audit_log->data_new : "{}" !!} // JSON objects here
});
</script>