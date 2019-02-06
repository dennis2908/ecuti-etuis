<!-- Modal -->
<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="addModalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalTitle">Kemaskini <span class="bold">Jenis Cuti</span></h5>
                <small class="text-muted">Sila isi maklumat pada ruangan di bawah.</small>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body m-t-20">
                <form id='form-edit' role="form" method="post" action="{{ route('admin.master.holiday-type.form', $type->id) }}">
                    @include('components.input', [
                        'name' => 'name',
                        'label' => 'Nama',
                        'mode' => 'required',
                        'value' => $type->name
                    ])

                    @include('components.input', [
	                    'name' => 'duration',
	                    'label' => 'Jumlah Hari',
	                    'mode' => 'required',
	                    'class' => 'numeric',
                        'value' => $type->duration
	                ])

					@include('components.date', [
	                    'name' => 'start_date',
	                    'label' => 'Mulai Cuti Pada',
                        'value' => $type->start_date ? date('d/m/Y', strtotime($type->start_date)) : date('d/m/Y')
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

<script src="{{ asset('js/global.js') }}"></script>
<script type="text/javascript">

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
</script>
