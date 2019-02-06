<!-- Modal -->
<div class="modal fade" id="modal-view" tabindex="-1" role="dialog" aria-labelledby="addModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalTitle">Subjek: <span class="bold">{{ $inbox->subject }}</span></h5>
                <small class="text-muted">Dihantar oleh: <b>{{ $inbox->sender->name }}</b> pada <b>{{ date('d/m/Y h:i A', strtotime($inbox->created_at)) }}</b></small>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body m-t-20">
                {!! str_replace('class="header"','class="headers"',$inbox->message) !!}
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$('#modal-view').modal('show');
</script>