<div class="modal fade" id="modal-editLeaving" tabindex="-1" role="dialog" aria-hidden="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="modal-header clearfix text-left">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
					</button>
					<h5>Maklumat <span class="semi-bold">Pegawai</span></h5>
					<p class="p-b-10">Maklumat pegawai yang meninggalkan jawatan.</p>
				</div>
				<div class="modal-body">
					<form id="form-edit-leaving" role="form" method="post" action="{{ route('formn.leaving.form', [request()->id, $leaving_officer->id]) }}">
						<div class="form-group-attached">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group form-group-default required">
										<label>Nama</label>
										<input type="text" class="form-control" name="name" value="{{ $leaving_officer->name }}">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group form-group-default form-group-default-custom form-group-default-select2 required">
										<label>Jawatan</label>
										<select id="edit_leaving_designation_id" name="designation_id" class="full-width autoscroll" data-init-plugin="select2" required>
											<option value="" selected="" disabled="">Pilih satu..</option>
											@foreach($designations as $designation)
											<option value="{{ $designation->id }}"
												>{{ $designation->name }}
											</option>
											@endforeach
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									@include('components.date', [
										'name' => 'left_date',
										'label' => 'Tarikh Melepaskan Jawatan',
										'mode' => 'required',
										'value' => $leaving_officer->left_at ? date('d/m/Y' , strtotime($leaving_officer->left_at)) : date('d/m/Y')
									])
								</div>								
							</div>
						</div>
					</form>
				</div>

				<div class="modal-footer">
					<div class="col-md-12 p-t-10">
						<button type="button" class="btn btn-info m-t-5 pull-right submit" onclick="submitForm('form-edit-leaving')"><i class="fa fa-check" ></i> Simpan</button>
					</div>
				</div>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
</div>

<script src="{{ asset('js/global.js') }}"></script>
<script type="text/javascript">
	$('#edit_leaving_designation_id').select2({
	    dropdownParent: $('#edit_leaving_designation_id').parents(".modal-dialog").find('.modal-content'),
	    language: 'ms',
	});
	
    $('#modal-editLeaving').modal('show');
    $(".modal form").validate();

    $("#form-edit-leaving").submit(function(e) {
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
                $("#modal-editLeaving").modal("hide");
                table9.api().ajax.reload(null, false);
            }
        });
    });

    $("#edit_leaving_designation_id").val( {{ $leaving_officer->designation_id }} ).trigger('change');
</script>
