<!-- Modal -->
<div class="modal fade" id="modal-recommend" tabindex="-1" role="dialog" aria-labelledby="addModalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalTitle">Maklumat <span class="bold">Ulasan / Syor</span></h5>
                <small class="text-muted">Sila isi maklumat pada ruangan di bawah.</small>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body m-t-20">
            	<form id='form-recommend' role="form" method="post" action="{{ $route }}">
            	@include('components.textarea', [
                    'name' => 'data',
                    'label' => 'Ulasan / Syor',
                    'mode' => 'required',
                    'value' => $recommendation->data,
                ])
            	</form>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                <button type="button" class="btn btn-info" onclick="submitForm('form-recommend')"><i class="fa fa-check m-r-5"></i> Hantar</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $("#modal-view").modal('hide');
    $('#modal-recommend').modal('show');
    $("#form-recommend").validate();

    $("#form-recommend").submit(function(e) {
        e.preventDefault();
        var form = $(this);

        if(!form.valid())
           return;

        swal({
            title: "Teruskan?",
            text: "Adakah anda pasti untuk menghantar ulasan/syor tersebut?",
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
                        $("#modal-recommend").modal("hide");
                        table.api().ajax.reload(null, false);
                    }
                });
            }
        });

        
    });
</script>