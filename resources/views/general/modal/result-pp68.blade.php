<!-- Modal -->
<div class="modal fade" id="modal-result" tabindex="-1" role="dialog" aria-labelledby="addModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalTitle">Keputusan <span class="bold">Pengarah Wilayah</span></h5>
                <small class="text-muted">Sila isi maklumat pada ruangan di bawah.</small>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            	<form class="form-horizontal" role="form" id='form-result' role="form" method="post" action="{{ $route }}">
                    <div class="form-group row">
                        <label for="participant" class="col-md-5 control-label">
                            1. Pengecualian daripada menyelenggarakan buku daftar yuran mengikut format AP 3
                            <span style="color:red;">*</span>
                        </label>
                        <div class="col-md-7 result">
                            <div class="radio radio-primary">
                                <input name="is_fee_approved" value="1" id="result1_1" type="radio" class="hidden approved">
                                <label for="result1_1"> Lulus</label>

                                <input name="is_fee_approved" value="0" id="result1_0" type="radio" class="hidden unapproved">
                                <label for="result1_0">Tidak Lulus</label>
                            </div>
                            <textarea class="hidden form-control" id="result1_data" name="justification_fee_approved" placeholder="Ulasan"  style="height: 100px;">{{ $exception->justification_fee_approved }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="participant" class="col-md-5 control-label">
                            2. Pengecualian mengeluarkan resit rasmi kepada ahli yang membayar yuran bulanan melalu potongan gaji
                            <span style="color:red;">*</span>
                        </label>
                        <div class="col-md-7 result">
                            <div class="radio radio-primary">
                                <input name="is_receipt_approved" value="1" id="result2_1" type="radio" class="hidden approved">
                                <label for="result2_1"> Lulus</label>

                                <input name="is_receipt_approved" value="0" id="result2_0" type="radio" class="hidden unapproved">
                                <label for="result2_0">Tidak Lulus</label>
                            </div>
                            <textarea class="hidden form-control" id="result2_data" name="justification_receipt_approved" placeholder="Ulasan"  style="height: 100px;">{{ $exception->justification_receipt_approved }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="participant" class="col-md-5 control-label">
                            3. Pengecualian daripada menyelenggarakan buku tunai mengikut format AP. 1 secara manual kepada berkomputer
                            <span style="color:red;">*</span>
                        </label>
                        <div class="col-md-7 result">
                            <div class="radio radio-primary">
                                <input name="is_computer_approved" value="1" id="result3_1" type="radio" class="hidden approved">
                                <label for="result3_1"> Lulus</label>

                                <input name="is_computer_approved" value="0" id="result3_0" type="radio" class="hidden unapproved">
                                <label for="result3_0">Tidak Lulus</label>
                            </div>
                            <textarea class="hidden form-control" id="result3_data" name="justification_computer_approved" placeholder="Ulasan"  style="height: 100px;">{{ $exception->justification_computer_approved }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="participant" class="col-md-5 control-label">
                            4. Pengecualian daripada menyelenggarakan buku tunai mengikut format AP. 1 digantikan dengan sistem perakaunan
                            <span style="color:red;">*</span>
                        </label>
                        <div class="col-md-7 result">
                            <div class="radio radio-primary">
                                <input name="is_system_approved" value="1" id="result4_1" type="radio" class="hidden approved">
                                <label for="result4_1"> Lulus</label>

                                <input name="is_system_approved" value="0" id="result4_0" type="radio" class="hidden unapproved">
                                <label for="result4_0">Tidak Lulus</label>
                            </div>
                            <textarea class="hidden form-control" id="result4_data" name="justification_system_approved" placeholder="Ulasan"  style="height: 100px;">{{ $exception->justification_system_approved }}</textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                <button type="button" class="btn btn-info" onclick="submitForm('form-result')"><i class="fa fa-check m-r-5"></i> Hantar</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $("#modal-view").modal('hide');
    $('#modal-result').modal('show');
    $("#form-result").validate();

    $(document).ready(function() {
        $('input').on('change', function() {

            if($(this).val() == 0) {
                $(this).parents('.result').find('textarea').removeClass('hidden');
            }
            else {
                $(this).parents('.result').find('textarea').addClass('hidden');
            }
        });
    });

    $("#form-result").submit(function(e) {
        e.preventDefault();
        var form = $(this);

        if(!form.valid())
           return;

        swal({
            title: "Teruskan?",
            text: "Adakah anda pasti untuk menghantar keputusan tersebut?",
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
                        $("#modal-result").modal("hide");
                        table.api().ajax.reload(null, false);
                    },
                    error: function(data) {
                        swal('Ralat', 'Sila semak semula ruangan borang yang di hantar.', 'error');
                    }
                });
            }
        });
    });

    $("#result1_{{ $exception->is_fee_approved }}").prop('checked', true).trigger('change');
    $("#result2_{{ $exception->is_receipt_approved }}").prop('checked', true).trigger('change');
    $("#result3_{{ $exception->is_computer_approved }}").prop('checked', true).trigger('change');
    $("#result4_{{ $exception->is_system_approved }}").prop('checked', true).trigger('change');

</script>