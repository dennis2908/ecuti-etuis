<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-hidden="false">
	<div class="modal-dialog ">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="modal-header clearfix text-left">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
					</button>
					<h5>Maklumat <span class="semi-bold">Pegawai</span></h5>
				</div>
				<div class="modal-body">
					<form id="form-edit" role="form" method="post" action="{{ route('pbp2.a1.form', [request()->id, $a1->id]) }}">
						<div class="form-group-attached">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group form-group-default form-group-default-custom form-group-default-select2 required">
	                                    <label><span>Jawatan</span></label>
	                                    <select id="edit_designation_id" name="designation_id" class="full-width autoscroll" data-init-plugin="select2" required="">
	                                        @foreach($designations as $index => $designation)
	                                        <option value="{{ $designation->id }}">{{ $designation->name }}</option>
	                                        @endforeach
	                                    </select>
	                                </div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									@include('components.input', [
										'name' => 'name',
										'label' => 'Nama Pegawai',
										'mode' => 'required',
										'value' => $a1->name
									])
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									@include('components.input', [
										'name' => 'phone',
										'label' => 'No. Telefon',
										'mode' => 'required',
										'value' => $a1->phone
									])
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									@include('components.input', [
										'name' => 'email',
										'label' => 'Emel',
										'mode' => 'required',
										'value' => $a1->email
									])
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									@include('components.input', [
										'name' => 'office_location',
										'label' => 'Tempat Pekerjaan',
										'mode' => 'required',
										'value' => $a1->office_location
									])
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									@include('components.input', [
										'name' => 'grade',
										'label' => 'Gred Jawatan',
										'mode' => 'required',
										'value' => $a1->grade
									])
								</div>
							</div>
						</div>
						<p class="m-t-10 bold">Alamat Pegawai</p>
						<div class="form-group-attached">
							@include('components.input', [
								'name' => 'address1',
								'label' => 'Alamat 1',
								'mode' => 'required',
								'value' => $a1->address ? $a1->address->address1 : ''
							])

							<div class="row clearfix">
								<div class="col-md-6">
									@include('components.input', [
										'name' => 'address2',
										'label' => 'Alamat 2',
										$a1->address ? $a1->address->address2 : ''
									])
								</div>
								<div class="col-md-6">
									@include('components.input', [
										'name' => 'address3',
										'label' => 'Alamat 3',
										$a1->address ? $a1->address->address3 : ''
									])
								</div>
							</div>

							<div class="row clearfix address">
								<div class="col-md-4">
									<div class="form-group form-group-default required">
										<label>Poskod</label>
										<input class="form-control numeric postcode" name="postcode" aria-required="true" type="text" value="{{ $a1->address->postcode }}" required minlength="5" maxlength="5">
									</div>
								</div>
								<div class="col-md-4">
	                                <div class="form-group form-group-default form-group-default-custom form-group-default-select2 required">
	                                    <label><span>Negeri</span></label>
	                                    <select id="edit_state_id" name="state_id" class="full-width autoscroll state" data-init-plugin="select2" required="">
	                                        @foreach($states as $index => $state)
	                                        <option value="{{ $state->id }}">{{ $state->name }}</option>
	                                        @endforeach
	                                    </select>
	                                </div>
	                            </div>
	                            <div class="col-md-4">
	                                <div class="form-group form-group-default form-group-default-custom form-group-default-select2 required">
	                                    <label><span>Daerah</span></label>
	                                    <select id="edit_district_id" name="district_id" class="full-width autoscroll district" data-init-plugin="select2" required="">
	                                    </select>
	                                </div>
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


@include('components.ajax.address')

<script src="{{ asset('js/global.js') }}"></script>
<script type="text/javascript">

$('#edit_state_id').select2({
    dropdownParent: $('#edit_state_id').parents(".modal-dialog").find('.modal-content'),
    language: 'ms',
});

$('#edit_district_id').select2({
    dropdownParent: $('#edit_district_id').parents(".modal-dialog").find('.modal-content'),
    language: 'ms',
});

$('#edit_designation_id').select2({
    dropdownParent: $('#edit_designation_id').parents(".modal-dialog").find('.modal-content'),
    language: 'ms',
});

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

$("#edit_state_id").val( {{ $a1->address->state_id }} ).trigger('change');

$("#edit_district_id").val( {{ $a1->address->district_id }} ).trigger('change');

$("#edit_designation_id").val( {{ $a1->designation_id }} ).trigger('change');
</script>
