<!-- Modal -->
<div class="modal fade" id="modal-announcement" tabindex="-1" role="dialog" aria-labelledby="addModalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalTitle"><span class="bold">{{ $announcement->title }}</span></h5>
                <p class="no-margin hint-text small">Oleh {{ $announcement->created_by->name }}, pada {{ date('d/m/Y', strtotime($announcement->created_at)) }}</p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body m-t-20">

               <span>{!! nl2br( $announcement->description) !!}</span>

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
	$('#modal-announcement').modal('show');
</script>