<div class="modal fade" id="modal-editAccused" tabindex="-1" role="dialog" aria-hidden="false">
	<div class="modal-dialog ">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="modal-header clearfix text-left">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
					</button>
					<h5>Maklumat <span class="semi-bold">Tertuduh</span></h5>
				</div>
				<div class="modal-body">
                    <form id="form-edit-accused" role="form" method="post" action="{{ route('prosecution.accused.form', [$prosecution->id, $accused->id]) }}">

						<div class="form-group-attached">
							<div class="row">
								<div class="col-md-12">
									@include('components.input', [
										'name' => 'accused',
										'label' => 'Nama Tertuduh',
										'mode' => 'required',
                                        'value' => $accused->accused,
									])
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									@include('components.input', [
										'name' => 'identification_no',
										'label' => 'No KP Tertuduh',
										'mode' => 'required',
										'class' => 'numeric',
										'options' => 'maxlength=12 minlength=12',
                                        'value' => $accused->identification_no,
									])
								</div>
							</div>
						</div>
					</form>
					<div class="row">
						<div class="col-md-12 p-t-10">
							<button type="button" class="btn btn-info m-t-5 pull-right" onclick="submitForm('form-edit-accused')"><i class="fa fa-check mr-1"></i> Simpan</button>
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

    $('#modal-editAccused').modal('show');
    $(".modal form").validate();

    $("#form-edit-accused").submit(function(e) {
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
                $("#modal-editAccused").modal("hide");
                table.api().ajax.reload(null, false);
            }
        });
    });
</script>
