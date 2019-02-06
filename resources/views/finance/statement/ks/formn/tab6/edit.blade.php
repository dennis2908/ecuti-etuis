<div class="modal fade" id="modal-editSecurity" tabindex="-1" role="dialog" aria-hidden="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="modal-header clearfix text-left">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
					</button>
					<h5>Maklumat <span class="semi-bold">Sekuriti</span></h5>
					<!-- <p class="p-b-10">Maklumat w.</p> -->
				</div>
				<div class="modal-body">
					<form id="form-edit-security" role="form" method="post" action="{{ route('formn.security.form', [request()->id, $security->id]) }}">
						<div class="form-group-attached">
							
							<div class="row">
								<div class="col-md-12">
									<div class="form-group form-group-default required">
										<label>Butir-butir</label>
										<textarea style="height: 100px;" name="description" placeholder="" class="form-control" required>{{ $security->description }}</textarea>
									</div>
								</div>
							</div>
							<div class="form-group-attached">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group form-group-default required">
											<label>Nilai Zahir</label>
											<input type="text" class="form-control decimal" name="external_value" value="{{ $security->external_value }}">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group form-group-default required">
											<label>Nilai Kos</label>
											<input type="text" class="form-control decimal" name="cost_value" value="{{ $security->cost_value }}">
										</div>
									</div>
								</div>								
							</div>
							<div class="form-group-attached">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group form-group-default required">
											<label>Nilai pasaran pada tarikh akaun-akaun itu dibuat</label>
											<input type="text" class="form-control decimal" name="market_value" value="{{ $security->market_value }}">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group form-group-default required">
											<label>Dalam Tangan</label>
											<input type="text" class="form-control decimal" name="cash" value="{{ $security->cash }}">
										</div>
									</div>
								</div>								
							</div>
						</div>
					</form>
					<div class="row">
						<div class="col-md-12 p-t-10">
							<button type="button" class="btn btn-info m-t-5 pull-right" onclick="submitForm('form-edit-security')"><i class="fa fa-check mr-1"></i> Simpan</button>
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

    $('#modal-editSecurity').modal('show');
    $(".modal form").validate();

    $("#form-edit-security").submit(function(e) {
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
                $("#modal-editSecurity").modal("hide");
                table11.api().ajax.reload(null, false);
            },
        });
    });
</script>
