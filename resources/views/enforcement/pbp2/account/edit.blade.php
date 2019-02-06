<div class="modal fade" id="modal-edit-account" tabindex="-1" role="dialog" aria-hidden="false">
	<div class="modal-dialog ">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="modal-header clearfix text-left">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
					</button>
					<h5>Maklumat <span class="semi-bold">Akaun Semasa/Simpanan Tetap</span></h5>
				</div>
				<div class="modal-body">
					<form id="form-edit-account" role="form" method="post" action="{{ route('pbp2.account.form', [request()->id, $account->id]) }}">
						<div class="form-group-attached">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group form-group-default form-group-default-custom form-group-default-select2 required">
	                                    <label><span>Jenis Akaun</span></label>
	                                    <select id="edit_account_type_id" name="account_type_id" class="full-width autoscroll state" data-init-plugin="select2" required="">
	                                        <option value="1">Akaun Simpanan</option>
	                                        <option value="2">Akaun Semasa</option>
	                                    </select>
	                                </div>
								</div>
							</div>						
							<div class="row">
								<div class="col-md-12">
									@include('components.input', [
										'name' => 'account_no',
										'label' => 'No. Akaun',
										'mode' => 'required',
										'value' => $account->account_no
									])
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									@include('components.input', [
										'name' => 'bank_name',
										'label' => 'Nama Bank',
										'mode' => 'required',
										'value' => $account->bank_name
									])
								</div>
							</div>
						</div>
					</form>
					<div class="row">
						<div class="col-md-12 p-t-10">
							<button type="button" class="btn btn-info m-t-5 pull-right" onclick="submitForm('form-edit-account')"><i class="fa fa-check mr-1"></i> Simpan</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
</div>
@include('components.ajax.address')

<script src="{{ asset('js/global.js') }}"></script>
<script type="text/javascript">

$('#edit_account_type_id').select2({
    dropdownParent: $('#edit_account_type_id').parents(".modal-dialog").find('.modal-content'),
    language: 'ms',
});

$('#modal-edit-account').modal('show');
$(".modal form").validate();

$("#form-edit-account").submit(function(e) {
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
            $("#modal-edit-account").modal("hide");
            table3.api().ajax.reload(null, false);
        }
    });
});
$("#edit_account_type_id").val( {{ $account->account_type_id }} ).trigger('change');
</script>