<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="addModalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalTitle">Kemaskini <span class="bold">Cawangan</span></h5>
                <small class="text-muted">Sila isi maklumat pada ruangan di bawah.</small>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body m-t-20">
                <form id='form-edit' role="form" method="post" action="{{ route('branch.form', $branch->id) }}">
                    @include('components.input', [
                        'name' => 'name',
                        'label' => 'Nama',
                        'mode' => 'required',
                        'value' => $branch->name
                    ])

                    <div class="form-group-attached m-b-10">
                        @include('components.input', [
                            'name' => 'address1',
                            'mode' => 'required',
                            'label' => 'Alamat 1',
                            'value' => $branch->address->address1
                        ])

                        @include('components.input', [
                            'name' => 'address2',
                            'label' => 'Alamat 2',
                            'value' => $branch->address->address2
                        ])

                        @include('components.input', [
                            'name' => 'address3',
                            'label' => 'Alamat 3',
                            'value' => $branch->address->address3
                        ])

                        <div class="row clearfix address">
                            <div class="col-md-4">
                                @include('components.input', [
                                    'name' => 'postcode',
                                    'label' => 'Poskod',
                                    'mode' => 'required',
                                    'class' => 'postcode numeric',
                                    'options' => 'minlength="5" maxlength="5"',
                                    'value' => $branch->address->postcode
                                ])
                            </div>
                            <div class="col-md-4">
                                <div class="form-group form-group-default form-group-default-custom form-group-default-select2">
                                    <label><span>Negeri</span></label>
                                    <select id="edit_state_id" name="state_id" class="full-width autoscroll state" data-init-plugin="select2" required="">
                                        <option value="" selected="" disabled="">Pilih satu..</option>
                                        @foreach($states as $index => $state)
                                        <option value="{{ $state->id }}"
                                            @if($state->id == $branch->address->state_id)
                                                selected
                                            @endif
                                            >{{ $state->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group form-group-default form-group-default-custom form-group-default-select2">
                                    <label><span>Daerah</span></label>
                                    <select id="edit_district_id" name="district_id" class="full-width autoscroll district" data-init-plugin="select2" required="">
                                        <option value="" selected="" disabled="">Pilih satu..</option>
                                        @foreach($districts as $index => $district)
                                        <option value="{{ $district->id }}"
                                            @if($district->id == $branch->address->district_id)
                                                selected
                                            @endif
                                            >{{ $district->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    @include('components.input', [
                        'name' => 'secretary_name',
                        'label' => 'Nama Setiausaha',
                        'mode' => 'required',
                        'value' => $branch->secretary_name
                    ])

                    @include('components.input', [
                        'name' => 'secretary_email',
                        'label' => 'Emel Setiausaha',
                        'type' => 'email',
                        'value' => $branch->secretary_email,
                    ])

                    @include('components.input', [
                        'name' => 'secretary_phone',
                        'label' => 'No Telefon Setiausaha',
                        'value' => $branch->secretary_phone
                    ])

                    @include('components.input', [
                        'name' => 'total_member',
                        'label' => 'Bilangan Ahli',
                        'value' => $branch->total_member
                    ])

                    @include('components.date', [
                        'name' => 'established_at',
                        'label' => 'Tarikh Penubuhan',
                        'mode' => 'required',
                        'value' => date('d/m/Y', strtotime($branch->established_at))
                    ])

                    @include('components.date', [
                        'name' => 'meeting_at',
                        'label' => 'Tarikh Mesyuarat Agung',
                        'mode' => 'required',
                        'value' => date('d/m/Y', strtotime($branch->meeting_at))
                    ])
                </form>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                <button type="button" class="btn btn-info" onclick="submitForm('form-edit')"><i class="fa fa-check m-r-5"></i> Hantar</button>
            </div>
        </div>
    </div>
</div>
@include('components.ajax.address')
<script type="text/javascript">

$('#edit_state_id').select2({
    dropdownParent: $('#edit_state_id').parents(".modal-dialog").find('.modal-content'),
    language: 'ms',
});

$('#edit_district_id').select2({
    dropdownParent: $('#edit_district_id').parents(".modal-dialog").find('.modal-content'),
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
