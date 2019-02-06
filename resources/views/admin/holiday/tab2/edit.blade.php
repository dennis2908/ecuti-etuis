<!-- Modal -->
<div class="modal fade" id="modal-editSpecific" tabindex="-1" role="dialog" aria-labelledby="addModalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalTitle">Kemaskini <span class="bold">Cuti Negeri</span></h5>
                <small class="text-muted">Sila isi maklumat pada ruangan di bawah.</small>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body m-t-20">
				<form id="form-edit-specific" role="form" method="post" action="{{ route('admin.holiday.specific.form', $specific->id) }}">
					@include('components.input', [
	                    'name' => 'name',
	                    'label' => 'Nama Cuti',
	                    'mode' => 'required',
                        'value' => $specific->name,
	                ])

                    <div class="form-group form-group-default form-group-default-custom form-group-default-select2 required">
                        <label><span>Negeri</span></label>
                        <select id="edit_state_id" name="states[]" class="full-width autoscroll" data-init-plugin="select2" required="" multiple required="">
                            @foreach($states as $state)
                            <option value="{{ $state->id }}"
                                @foreach($holiday_states as $holiday_state)
                                    @if($state->id == $holiday_state->state_id)
                                        selected
                                    @endif
                                @endforeach
                                >{{ $state->name }}</option>
                            @endforeach
                        </select>
                    </div>

					@include('components.input', [
	                    'name' => 'duration',
	                    'label' => 'Jumlah Hari',
	                    'mode' => 'required',
	                    'class' => 'numeric',
                        'value' => $specific->duration
	                ])

					@include('components.date', [
	                    'name' => 'start_date',
	                    'label' => 'Mulai Cuti Pada',
	                    'mode' => 'required',
                        'value' => $specific->start_date ? date('d/m/Y', strtotime($specific->start_date)) : date('d/m/Y')
	                ])
				</form>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                <button type="button" class="btn btn-info" onclick="submitForm('form-edit-specific')"><i class="fa fa-check m-r-5"></i> Hantar</button>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/global.js') }}"></script>
<script type="text/javascript">

    $('#edit_state_id').select2({
        dropdownParent: $('#edit_state_id').parents(".modal-dialog").find('.modal-content'),
        language: 'ms',
    });

    $('#modal-editSpecific').modal('show');
    $(".modal form").validate();

    $("#form-edit-specific").submit(function(e) {
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
                $("#modal-editSpecific").modal("hide");
                table2.api().ajax.reload(null, false);
            }
        });
    });

    $(".datepicker").datepicker({
        language: 'ms',
    	format: 'dd/mm/yyyy',
        autoclose: true,
        onClose: function() {
            $(this).valid();
        },
    }).on('changeDate', function(){
        $(this).trigger('change');
    });;

</script>
