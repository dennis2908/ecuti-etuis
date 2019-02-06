<!-- Modal -->
<div class="modal fade" id="modal-handover" tabindex="-1" role="dialog" aria-labelledby="addModalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalTitle">Serahan <span class="bold">Tugas</span></h5>
                <small class="text-muted">Sila isi maklumat pada ruangan di bawah.</small>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body m-t-20">
            	<form id='form-handover' role="form" method="post" action="{{ route('admin.user.external.handover.form', $user->id) }}">
                @include('components.input', [
                    'name' => 'new_email',
                    'label' => 'Email Setiausaha Baru',
                    'mode' => 'required',
                    'modal' => true,
                    'type' => 'email',
                ])
            	</form>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                <button type="button" class="btn btn-info" onclick="submitForm('form-handover')"><i class="fa fa-check m-r-5"></i> Hantar</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$('#modal-handover').modal('show');
$(".modal form").validate();

$("#form-handover").submit(function(e) {
    e.preventDefault();
    var form = $(this);

    if(!form.valid())
       return;

    $.ajax({
        url: form.attr('action'),
        method: form.attr('method'),
        data: new FormData(form[0]),
        dataType: 'json',
        async: true,
        contentType: false,
        processData: false,
        success: function(data) {
            swal(data.title, data.message, data.status);
            $("#modal-handover").modal("hide");
            table.api().ajax.reload(null, false);
        }
    });
});
</script>