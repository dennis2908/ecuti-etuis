
<!-- Modal -->
<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="addModalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalTitle">Kemaskini <span class="bold">Pengguna</span></h5>
                <small class="text-muted">Sila isi maklumat pada ruangan di bawah.</small>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body m-t-20">
                <form id='form-edit' role="form" method="post" action="{{ route('admin.user.internal.form', $user->id) }}">
                    @include('components.input', [
                        'label' => 'Nama Penuh',
                        'mode' => 'required',
                        'name' => 'name',
                        'value' => $user->name
                    ])

                    @include('components.input', [
                        'label' => 'ID Pengguna',
                        'mode' => 'required',
                        'name' => 'username',
                        'value' => $user->username
                    ])

                    @include('components.input', [
                        'label' => 'Alamat Emel',
                        'mode' => 'required',
                        'name' => 'email',
                        'type' => 'email',
                        'value' => $user->email
                    ])

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group form-group-default form-group-default-custom form-group-default-select2 required">
                                <label><span>Status</span></label>
                                <select id="edit_status_id" name="user_status_id" class="full-width autoscroll state" data-init-plugin="select2" required="">
                                    <option value="" selected="" disabled="">Pilih satu..</option>
                                    @foreach($all_status as $index => $status)
                                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group form-group-default form-group-default-custom form-group-default-select2 required">
                                <label><span>Peranan</span></label>
                                <select id="edit_roles_id" name="roles[]" class="full-width autoscroll state" data-init-plugin="select2" required="" multiple="">
                                    @foreach($roles as $index => $role)                                    
                                    <option
                                    @foreach($staff_roles as $staff_role)
                                    @if($role->name == $staff_role) 
                                        selected
                                    @endif
                                    @endforeach
                                    value="{{ $role->name }}">{{ $role->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
					
					<div class="row">
                        <div class="col-md-12">
                            <div class="form-group form-group-default form-group-default-custom form-group-default-select2 required">
                                <label><span>Atasan Role</span></label>
                                <select id="edit_atasan_role" name="atasan_role[]" class="full-width autoscroll state" data-init-plugin="select2" required>
                                    @foreach($roles as $index => $role)                                    
                                    <option
									@if($atasan_role['name'] == $role->name) 
                                        selected 
                                    @endif
									value="{{ $role->name }}">{{ $role->description }}
									</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
					
					

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group form-group-default form-group-default-custom form-group-default-select2 required">
                                <label><span>Pejabat Wilayah</span></label>
                                <select id="edit_province_office_id" name="province_office_id" class="full-width autoscroll state" data-init-plugin="select2" required="">
                                    <option value="" selected="" disabled="">Pilih satu..</option>
                                    @foreach($provinces as $index => $provinces)
                                    <option value="{{ $provinces->id }}">{{ $provinces->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                <button type="button" class="btn btn-info" onclick="submitForm('form-edit')"><i class="fa fa-check m-r-5"></i> Hantar</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

$('#edit_roles_id').select2({
    dropdownParent: $('#edit_roles_id').parents(".modal-dialog").find('.modal-content'),
    language: 'ms',
});

$('#edit_atasan_role').select2({
    dropdownParent: $('#edit_atasan_role').parents(".modal-dialog").find('.modal-content'),
    language: 'ms',
});

$('#edit_status_id').select2({
    dropdownParent: $('#edit_status_id').parents(".modal-dialog").find('.modal-content'),
    language: 'ms',
});

$('#edit_province_office_id').select2({
    dropdownParent: $('#edit_province_office_id').parents(".modal-dialog").find('.modal-content'),
    language: 'ms',
});

$('#modal-edit').modal('show');
$(".modal form").validate();

$("#form-edit").submit(function(e) {
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

@if($user->user_status_id)
$("#edit_status_id").val( {{ $user->user_status_id }} ).trigger('change');
@endif

@if($user->entity->province_office_id)
$("#edit_province_office_id").val( {{ $user->entity->province_office_id }} ).trigger('change');
@endif

</script>