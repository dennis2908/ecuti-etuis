<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-hidden="false">
	<div class="modal-dialog ">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="modal-header clearfix text-left">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
					</button>
					<h5>Maklumat <span class="semi-bold">Aset / Harta</span></h5>
				</div>
				<div class="modal-body">
					<form id="form-edit" role="form" method="post" action="{{ route('pbp2.b1.form', [request()->id, $b1->id]) }}">
						<div class="form-group-attached">
							<div class="row">
								<div class="col-md-12">
									@include('components.input', [
										'name' => 'asset_type',
										'label' => 'Jenis Aset / Harta',
										'mode' => 'required',
										'value' => $b1->asset_type
									])
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									@include('components.input', [
										'name' => 'year_obtained',
										'label' => 'Tahun Diperoleh',
										'mode' => 'required',
										'value' => $b1->year_obtained
									])
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									@include('components.input', [
										'name' => 'current_value',
										'label' => 'Nilai Semasa',
										'mode' => 'required',
										'class' => 'decimal',
										'value' => $b1->current_value
									])
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									@include('components.textarea', [
										'name' => 'location',
										'label' => 'Lokasi',
										'mode' => 'required',
										'value' => $b1->location
									])
								</div>
							</div>
						</div>
					</form>
					<div class="row">
						<div class="col-md-12 p-t-10">
							<button type="button" class="btn btn-info m-t-5 pull-right" onclick="submitForm('form-edit')"><i class="fa fa-check mr-1"></i> Simpan</button>
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
