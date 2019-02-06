<div class="modal fade" id="modal-editLiability" tabindex="-1" role="dialog" aria-hidden="false">
	<div class="modal-dialog ">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="modal-header clearfix text-left">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
					</button>
					<h5>Maklumat <span class="semi-bold">Liabiliti Lain </span></h5>
				</div>
				<div class="modal-body">
					<form id="form-edit-liability" role="form" method="post" action="{{ route('formn.liability.form', [request()->id, $liability->id] ) }}">
						<div class="form-group-attached">
							<div class="row">
								<div class="col-md-12">
									@include('components.input', [
										'name' => 'name',
										'label' => 'Liabiliti Lain',
										'mode' => 'required',
										'value' => $liability->name
									])
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									@include('components.input', [
										'name' => 'total',
										'label' => 'RM sen',
										'mode' => 'required',
										'class' => 'decimal',
										'value' => $liability->total
									])
								</div>
							</div>
						</div>
					</form>
					<div class="row">
						<div class="col-md-12 p-t-10">
							<button type="button" class="btn btn-info m-t-5 pull-right" onclick="submitForm('form-edit-liability')"><i class="fa fa-check mr-1"></i> Simpan</button>
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
    $('#modal-editLiability').modal('show');
    $(".modal form").validate();

    $("#form-edit-liability").submit(function(e) {
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
                $("#modal-editLiability").modal("hide");
                table3.api().ajax.reload(null, false);
            }
        });
    });
</script>