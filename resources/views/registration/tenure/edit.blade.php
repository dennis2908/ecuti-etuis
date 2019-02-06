<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="addModalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalTitle">Kemaskini <span class="bold">Penggal</span></h5>
                <small class="text-muted">Sila isi maklumat pada ruangan di bawah.</small>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body m-t-20">
                <form id='form-edit' role="form" method="post" action="{{ route('tenure.form', $tenure->id) }}">
                    @component('components.label', [
                        'name' => 'meeting',
                        'label' => 'Mesyuarat',
                        'value' => ''
                    ])
                    <div class="radio radio-primary">
                        @foreach($meeting_types as $meeting_type)
                        <input name="meeting_type_id" value="{{ $meeting_type->id }}" id="edit_meeting_type_{{ $meeting_type->id }}" type="radio" class="hidden" required>
                        <label for="edit_meeting_type_{{ $meeting_type->id }}">{{ $meeting_type->name }}</label>
                        @endforeach
                    </div>
                    @endcomponent

                    @include('components.date', [
                        'name' => 'meeting_date',
                        'label' => 'Tarikh Mesyuarat',
                        'mode' => 'required',
                        'value' => date('d/m/Y', strtotime($tenure->meeting_at)),
                    ])

                    @include('components.input', [
                        'name' => 'duration',
                        'label' => 'Tempoh Masa (Tahun)',
                        'mode' => 'required',
                        'class' => 'numeric',
                        'value' => $tenure->duration,
                    ])

                    @include('components.input', [
                        'name' => 'start_year',
                        'label' => 'Tahun Bermula',
                        'mode' => 'required',
                        'class' => 'numeric',
                        'value' => $tenure->start_year,
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

$("#edit_meeting_type_{{ $tenure->meeting_type_id }}").prop('checked', true).trigger('change');

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
