<div class="modal fade" id="modal-editBank" tabindex="-1" role="dialog" aria-hidden="false">
	<div class="modal-dialog ">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="modal-header clearfix text-left">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
					</button>
					<h5>Maklumat <span class="semi-bold">Baki Terkini Bank</span></h5>
                    <p class="p-b-10">Sila isi maklumat pada ruangan di bawah.</p>
				</div>
				<div class="modal-body">
					<form id="form-edit-bank" role="form" method="post" action="{{ route('fund.id1.bank.form', [$fund->id, $bank->id]) }}">
						<div class="form-group-attached">
							<div class="row">
								<div class="col-md-12">
									@include('components.input', [
										'name' => 'name',
										'label' => 'Nama Bank',
										'mode' => 'required',
                                        'value' => $bank->name,
									])
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									@include('components.input', [
										'name' => 'account_no',
										'label' => 'Nombor Akaun',
										'mode' => 'required',
                                        'value' => $bank->account_no,
									])
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group form-group-default input-group">
										<div class="input-group-addon">
											RM
										</div>
										<div class="form-input-group">
											<label>Baki Bank</label>
                                            <input type="text" class="form-control decimal" name="balance" value="{{ $bank->balance }}" required>
										</div>
									</div>
								</div>
							</div>
						</div>
					</form>
					<div class="row">
						<div class="col-md-12 p-t-10">
							<button type="button" class="btn btn-info m-t-5 pull-right" onclick="submitForm('form-edit-bank')"><i class="fa fa-check mr-1"></i> Simpan</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
</div>

<script src="{{ asset('js/global.js') }}"></script>
<script type="text/javascript">

    $('#modal-editBank').modal('show');
    $(".modal form").validate();

    $("#form-edit-bank").submit(function(e) {
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
                $("#modal-editBank").modal("hide");
                table3.api().ajax.reload(null, false);
            }
        });
    });
</script>
