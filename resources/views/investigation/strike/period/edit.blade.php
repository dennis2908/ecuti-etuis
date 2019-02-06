<div class="modal fade" id="modal-editPeriod" tabindex="-1" role="dialog" aria-hidden="false">
	<div class="modal-dialog ">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="modal-header clearfix text-left">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
					</button>
					<h5>Maklumat <span class="semi-bold">Tempoh Mogok</span></h5>
					<p class="p-b-10">Sila isi maklumat pada ruangan berikut.</p>
				</div>
				<div class="modal-body">
                    <form id="form-edit-period" role="form" method="post" action="{{ route('strike.period.form', [$strike->id, $period->id]) }}">
						<div class="form-group-attached">
							<div class="row clearfix">
								<div class="col-md-6">
									@include('components.date', [
									'name' => 'start_date',
									'label' => 'Tarikh Mula',
									'mode' => 'required',
                                    'value' => date('d/m/Y', strtotime($period->start_date)),
									])
								</div>
								<div class="col-md-6">
									@include('components.date', [
									'name' => 'end_date',
									'label' => 'Tarikh Akhir',
									'mode' => 'required',
                                    'value' => date('d/m/Y', strtotime($period->end_date)),
									])
								</div>
							</div>
						</div>
					</form>
					<div class="row p-t-10">
						<div class="col-md-12">
							<button type="button" class="btn btn-info m-t-5 pull-right" onclick="submitForm('form-edit-period')"><i class="fa fa-check mr-1"></i> Simpan</button>
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

    $('#modal-editPeriod').modal('show');
    $(".modal form").validate();

    $("#form-edit-period").submit(function(e) {
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
                $("#modal-editPeriod").modal("hide");
                table.api().ajax.reload(null, false);
            }
        });
    });
</script>
