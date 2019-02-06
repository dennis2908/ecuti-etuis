<!-- Modal -->
<div class="modal fade" id="modal-editGeneral" tabindex="-1" role="dialog" aria-labelledby="addModalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalTitle">Kemaskini <span class="bold">Cuti Persekutuan</span></h5>
                <small class="text-muted">Sila isi maklumat pada ruangan di bawah.</small>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
			<form id="form-edit-general" role="form" method="post" action="{{ route('staff.holiday_approved.general.form', $general->id) }}">
				<div class="modal-body m-t-20">

					@include('components.input', [
	                    'name' => 'duration',
	                    'label' => 'Jumlah Hari',
	                    'mode' => 'required',
	                    'class' => 'numeric',
                        'value' => $general->duration
	                ])

					@include('components.date', [
	                    'name' => 'start_date',
	                    'label' => 'Mulai Cuti Pada',
	                    'mode' => 'required',
                        'value' => $general->start_date ? date('d/m/Y', strtotime($general->start_date)) : date('d/m/Y')
	                ])
	            </div>
			</form>
        </div>
    </div>
</div>

<script src="{{ asset('js/global.js') }}"></script>
<script type="text/javascript">

    $('#edit_general_type_id').select2({
        dropdownParent: $('#edit_general_type_id').parents(".modal-dialog").find('.modal-content'),
        language: 'ms',
    });

    $('#modal-editGeneral').modal('show');
    $(".modal form").validate();

    $("#form-edit-general").submit(function(e) {
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
                $("#modal-editGeneral").modal("hide");
                table.api().ajax.reload(null, false);
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
    });

    $('#edit_general_type_id').val({{ $general->holiday_type_id }}).trigger('change');
    
</script>
