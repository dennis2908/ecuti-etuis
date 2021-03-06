<div class="modal fade" id="modal-edit-fdaccount" tabindex="-1" role="dialog" aria-hidden="false">
	<div class="modal-dialog ">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="modal-header clearfix text-left">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
					</button>
					<h5>Maklumat <span class="semi-bold">Akaun Simpanan Tetap</span></h5>
				</div>
				<div class="modal-body">
					<form id="form-edit-fdaccount" role="form" method="post" action="{{ route('pbp2.fd-account.form', [request()->id, $fdaccount->id]) }}">
						<div class="form-group-attached">
							<div class="row">
								<div class="col-md-12">
									@include('components.input', [
										'name' => 'bank_name',
										'label' => 'Nama Bank',
										'mode' => 'required',
										'value' => $fdaccount->bank_name,
									])
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									@include('components.input', [
										'name' => 'certificate_no',
										'label' => 'No. Sijil',
										'mode' => 'required',
										'value' => $fdaccount->certificate_no,
									])
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									@include('components.date', [
										'name' => 'matured_date',
										'label' => 'Tarikh Matang',
										'mode' => 'required',
										'value' => date('d/m/Y', strtotime($fdaccount->matured_at)),
									])
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									@include('components.input', [
										'name' => 'total',
										'class' => 'decimal',
										'label' => 'Jumlah (RM)',
										'mode' => 'required',
										'value' => $fdaccount->total,
									])
								</div>
							</div>
						</div>
					</form>
					<div class="row">
						<div class="col-md-12 p-t-10">
							<button type="button" class="btn btn-info m-t-5 pull-right" onclick="submitForm('form-edit-fdaccount')"><i class="fa fa-check mr-1"></i> Simpan</button>
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

$('#modal-edit-fdaccount').modal('show');
$(".modal form").validate();

$("#form-edit-fdaccount").submit(function(e) {
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
            $("#modal-edit-fdaccount").modal("hide");
            table4.api().ajax.reload(null, false);
        }
    });
});
</script>