<!-- Modal -->
<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="addModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalTitle">Kemaskini <span class="bold">Peranan</span></h5>
                <small class="text-muted">Sila isi maklumat pada ruangan di bawah.</small>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body m-t-20">
                <form id="form-role-edit" role="form" method="post" action="{{ route('admin.role.form', $role->id) }}">
                    @include('components.input', [
                        'name' => 'name',
                        'label' => 'Nama Peranan',
                        'mode' => 'required',
                        'value' => $role->name
                    ])

                    @include('components.textarea', [
                        'name' => 'description',
                        'label' => 'Penerangan',
                        'mode' => 'required',
                        'value' => $role->description
                    ])

                    @component('components.label', [
                        'name' => 'permissions',
                        'label' => 'Keizinan',
                        'value' => ''
                    ])
                    <div class="checkbox check-primary">
                        <div class="row">
                            @foreach($permissions as $index => $permission)
                            <div class="col-md-4" style="padding-left: 7px">
                                <input name="permissions[]" value="{{ $permission->name }}" id="permission_edit_{{ $permission->id }}" class="hidden" type="checkbox" @if($role->hasPermissionTo($permission->name)) checked @endif>
                                <label for="permission_edit_{{ $permission->id }}">{{ $permission->name }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endcomponent
                </form>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                <button type="button" class="btn btn-info" onclick="submitForm('form-role-edit')"><i class="fa fa-check m-r-5"></i> Hantar</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$("#modal-edit").modal("show");
$(".modal form").validate();

$("#form-role-edit").submit(function(e) {
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
</script>
