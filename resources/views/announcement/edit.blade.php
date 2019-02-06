<!-- Modal -->
<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="addModalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalTitle">Kemaskini <span class="bold">Pengumuman</span></h5>
                <small class="text-muted">Sila isi maklumat pada ruangan di bawah.</small>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body m-t-20">
                <form id='form-edit' role="form" method="post" action="{{ route('announcement.form', $announcement->id) }}">
                    @include('components.input', [
                        'name' => 'created_by_user_id',
                        'label' => 'Dibuat Oleh',
                        'mode' => 'hidden',
                        'value' => auth()->user()->id
                    ])

                    @include('components.input', [
                        'name' => 'title',
                        'label' => 'Tajuk Pengumuman',
                        'mode' => 'required',
                        'value' => $announcement->title
                    ])

                    @include('components.textarea', [
                        'name' => 'description',
                        'label' =>'Pengumuman',
                        'mode' => 'required',
                        'value' => $announcement->description
                    ])

                    <div class="form-group form-group-default form-group-default-custom form-group-default-select2">
                        <label><span>Jenis Pengumuman</span></label>
                        <select id="edit_announcement_type_id" name="announcement_type_id" class="full-width autoscroll" data-init-plugin="select2" required="" required="">
                            <option value="" selected="" disabled="">Pilih satu..</option>
                            @foreach($types as $index => $type)
                            <option value="{{ $type->id }}"
                                @if($type->id == $announcement->announcement_type_id)
                                    selected
                                @endif
                                >{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group form-group-default form-group-default-custom form-group-default-select2">
                        <label><span>Papar Kepada</span></label>
                        <select id="edit_target_roles" name="target_roles[]" class="full-width autoscroll" data-init-plugin="select2" required="" multiple required="">
                            @foreach($roles as $index => $role)
                            <option value="{{ $role->id }}"
                                @foreach($targets as $target)
                                    @if($role->id == $target->role_id)
                                        selected
                                    @endif
                                @endforeach
                                >{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group-attached">
                        <div class="row clearfix">
                            <div class="col-md-6">
                                @include('components.date', [
                                    'name' => 'date_start',
                                    'label' => 'Tarikh Mula',
                                    'mode' => 'required',
                                    'value' => date('d/m/Y' , strtotime($announcement->date_start))
                                ])
                            </div>
                            <div class="col-md-6">
                                @include('components.date', [
                                    'name' => 'date_end',
                                    'label' => 'Tarikh Tamat',
                                    'mode' => 'required',
                                    'value' => date('d/m/Y' , strtotime($announcement->date_end))
                                ])
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

$('#edit_announcement_type_id').select2({
    dropdownParent: $('#edit_announcement_type_id').parents(".modal-dialog").find('.modal-content'),
    language: 'ms',
});

$('#edit_target_roles').select2({
    dropdownParent: $('#edit_target_roles').parents(".modal-dialog").find('.modal-content'),
    language: 'ms',
});

$(".datepicker").datepicker({
    language: 'ms',
    format : "dd/mm/yyyy",
    autoclose: true,
    onClose: function() {
        $(this).valid();
    },
}).on('changeDate', function(){
    $(this).trigger('change');
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
</script>
