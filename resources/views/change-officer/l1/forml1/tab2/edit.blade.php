<div class="modal fade" id="modal-editResign" tabindex="-1" role="dialog" aria-hidden="false">
	<div class="modal-dialog">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="modal-header clearfix text-left">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
					</button>
					<h5>Maklumat <span class="semi-bold">Pekerja</span></h5>
					<p class="p-b-10">Maklumat pekerja yang meninggalkan jawatan.</p>
				</div>
				<div class="modal-body">
					<form id="form-edit-resign" role="form" method="post" action="{{ route('forml1.resign.form', [request()->id, $resign->id ]) }}">
						<div class="form-group-attached">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group form-group-default form-group-default-custom form-group-default-select2 required">
	                                    <label><span>Nama</span></label>
	                                    <select id="edit_worker_id" name="worker_id" class="full-width autoscroll" data-init-plugin="select2" required="">
	                                        <option value="" selected="" disabled="">Pilih satu..</option>
	                                        @foreach($workers as $index => $worker)
                                            <option value="{{ $worker->id }}" appointment="{{ $worker->appointment }}">{{ $worker->name }}</option>
	                                        @endforeach
	                                    </select>
	                                </div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									@include('components.input', [
                                    	'name' => 'edit_appointment',
										'label' => 'Pelantikan',
										'mode' => 'readonly',
										'class' => 'text-capitalize',
										'value' => $worker->appointment
									])
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									@include('components.date', [
										'name' => 'left_date',
										'label' => 'Tarikh Meninggalkan Perlantikan',
										'value' => $worker->left_at ? date('d/m/Y', strtotime($worker->left_at)) : date('d/m/Y'),
									])
								</div>
							</div>
						</div>
					</form>
					<div class="row">	
						<div class="col-md-12 p-t-10">
							<button type="button" class="btn btn-info m-t-5 pull-right submit" onclick="submitForm('form-edit-resign')"><i class="fa fa-check" ></i> Simpan</button>
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
	$('#edit_worker_id').select2({
        dropdownParent: $('#edit_worker_id').parents(".modal-dialog").find('.modal-content'),
        language: 'ms',
    });

    $('#modal-editResign').modal('show');
    $(".modal form").validate();

    $("#form-edit-resign").submit(function(e) {
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
                $("#modal-editResign").modal("hide");
                table2.api().ajax.reload(null, false);
            },
    		error: function(xhr, ajaxOptions, thrownError){
    	        swal('Harap Maaf!', 'Pekerja ini sudah dipilih.', 'error');
    		}
        });
    });

    $("#edit_worker_id").val( {{ $resign->worker_id }} ).trigger('change');

    $("#worker_id").change(function() {
		$("#edit_appointment").val($("#worker_id option:selected").attr("appointment"));
	});


</script>