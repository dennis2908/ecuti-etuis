<div class="modal fade" id="modal-edit-incentive" tabindex="-1" role="dialog" aria-hidden="false">
	<div class="modal-dialog ">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="modal-header clearfix text-left">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
					</button>
					<h5>Elaun Insentif Pegawai Kesatuan</h5>
				</div>
				<div class="modal-body">
					<form id="form-edit-incentive" role="form" method="post" action="{{ route('pbp2.a4.incentive.form', [request()->id, request()->a4_id, $incentive->id]) }}">
						<div class="form-group-attached">
							<div class="row">
								<div class="col-md-12">
									@include('components.input', [
										'name' => 'incentive',
										'label' => 'Nama',
										'mode' => 'required',
										'value' => $incentive->name
									])
								</div>
							</div>
                            <div class="row">
								<div class="col-md-12">
									@include('components.input', [
										'name' => 'incentive_value',
										'label' => 'Jumlah (RM)',
										'mode' => 'required',
										'value' => $incentive->value,
										'class' => 'decimal',
									])
								</div>
							</div>
                        </div>
					</form>
					<div class="row">
						<div class="col-md-12 p-t-10">
							<button type="button" class="btn btn-info m-t-5 pull-right" onclick="submitForm('form-edit-incentive')"><i class="fa fa-check mr-1"></i> Simpan</button>
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

$('#modal-edit-incentive').modal('show');
$(".modal form").validate();

$("#form-edit-incentive").submit(function(e) {
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
            $("#modal-edit-incentive").modal("hide");
            table2.api().ajax.reload(null, false);
        }
    });
});

</script>
