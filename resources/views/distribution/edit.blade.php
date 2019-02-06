<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="addModalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalTitle">Ubah <span class="bold">Agihan</span></h5>
                <small class="text-muted">Sila isi maklumat pada ruangan di bawah.</small>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body m-t-20">
                <form id="form-edit-distribution" role="form" method="post" action="{{ route('distribution.form', $distribution->id) }}">
                    <div class="col-md-12">
                        <div class="form-group form-group-default form-group-default-custom form-group-default-select2 required">
                            <label><span>Nama</span></label>
                            <select id="assigned_to_user_id" name="assigned_to_user_id" class="full-width autoscroll" data-init-plugin="select2" required="">
                                <option value="" selected="" disabled="">Pilih satu..</option>
                                @foreach($userstaff as $staff)
                                <option value="{{ $staff->user->id }}">{{ $staff->user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                <button type="button" class="btn btn-info submit" onclick="submitForm('form-edit-distribution')"><i class="fa fa-check m-r-5"></i> Hantar</button>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/global.js') }}"></script>
<script type="text/javascript">

$('#assigned_to_user_id').select2({
    dropdownParent: $('#assigned_to_user_id').parents(".modal-dialog").find('.modal-content'),
    language: 'ms',
});
$('#modal-edit').modal('show');
    $(".modal form").validate();

$("#form-edit-distribution").submit(function(e) {
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
            $("#modal-edit").modal("hide");
            table.api().ajax.reload(null, false);
        }
    });
});

$("#assigned_to_user_id").val( {{ $distribution->assigned_to_user_id }} ).trigger('change');
</script>