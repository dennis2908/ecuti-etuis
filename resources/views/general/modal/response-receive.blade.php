<!-- Modal -->
<div class="modal fade" id="modal-responseReceive" tabindex="-1" role="dialog" aria-labelledby="addModalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalTitle">Terima <span class="bold">Maklum Balas</span></h5>
                <small class="text-muted">Sila isi maklumat pada ruangan di bawah.</small>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body m-t-20">
            	<form id='form-responseReceive' role="form" method="post" action="{{ $route }}">
            	@include('components.date', [
                    'name' => 'received_at',
                    'label' => 'Tarikh Terima Maklum Balas',
                    'mode' => 'required',
                    'value' => date('d/m/Y'),
                ])
            	</form>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                <button type="button" class="btn btn-info" onclick="submitForm('form-responseReceive')"><i class="fa fa-check m-r-5"></i> Hantar</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $("#modal-view").modal('hide');
    $('#modal-responseReceive').modal('show');
    $(".modal form").validate();

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

    $("#form-responseReceive").submit(function(e) {
        e.preventDefault();
        var form = $(this);

        if(!form.valid())
           return;

        swal({
            title: "Teruskan?",
            text: "Adakah anda pasti maklum balas diterima pada " + $('#received_at').val(),
            icon: "warning",
            buttons: {
                cancel: "Batal",
                confirm: {
                    text: "Teruskan",
                    value: "confirm",
                    closeModal: false,
                    className: "btn-info",
                },
            },
            dangerMode: true,
        })
        .then((confirm) => {
            if (confirm) {
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
                        $("#modal-responseReceive").modal("hide");
                        table.api().ajax.reload(null, false);
                    }
                });
            }
        });

        
    });
</script>