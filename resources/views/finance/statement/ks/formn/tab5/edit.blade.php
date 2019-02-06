<div class="modal fade" id="modal-editAppointed" tabindex="-1" role="dialog" aria-hidden="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="modal-header clearfix text-left">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
					</button>
					<h5>Maklumat <span class="semi-bold">Pegawai</span></h5>
					<p class="p-b-10">Maklumat pegawai yang dilantik.</p>
				</div>
				<div class="modal-body">
					<form id="form-edit-appointed" role="form" method="post" action="{{ route('formn.appointed.form', [request()->id, $officer->id]) }}">
						<div class="form-group-attached">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group form-group-default required">
										<label>Nama</label>
										<input type="text" class="form-control" name="name" value="{{ $officer->name }}">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group form-group-default required">
										<label>Perkerjaan Peribadi</label>
										<input type="text" class="form-control" name="occupation" value="{{ $officer->occupation }}">
									</div>
								</div>
							</div>	
							<div class="row">
								<div class="col-md-12">
									<div class="form-group form-group-default form-group-default-custom form-group-default-select2 required">
										<label>Jawatan dalam Kesatuan</label>
										<select id="edit_officer_designation_id" name="designation_id" class="full-width autoscroll" data-init-plugin="select2" required>
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
								<div class="col-md-6">
									@include('components.date', [
										'name' => 'appointed_date',
										'label' => 'Tarikh Memegang Jawatan',
										'mode' => 'required',
										'value' => $officer->appointed_at ? date('d/m/Y', strtotime($officer->appointed_at)) : date('d/m/Y')
									])
								</div>									
								<div class="col-md-6">
									@include('components.date', [
										'name' => 'birth_date',
										'label' => 'Tarikh Lahir',
										'mode' => 'required',
										'value' => $officer->date_of_birth ? date('d/m/Y', strtotime($officer->date_of_birth)) : date('d/m/Y')
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
								'info' => 'Alamat Surat Menyurat terkini',
								'value' => $officer->address ? $officer->address->address1 : ''
							])

							<div class="row clearfix">
								<div class="col-md-6">
									@include('components.input', [
										'name' => 'address2',
										'label' => 'Alamat 2',
										'value' => $officer->address ? $officer->address->address2 : ''
									])
								</div>
								<div class="col-md-6">
									@include('components.input', [
										'name' => 'address3',
										'label' => 'Alamat 3',
										'value' => $officer->address ? $officer->address->address3 : ''
									])
								</div>
							</div>

							<div class="row clearfix address">
								<div class="col-md-4">
									<div class="form-group form-group-default required">
										<label>Poskod</label>
										<input class="form-control numeric postcode" name="postcode" aria-required="true" type="text" value="{{ $officer->address ? $officer->address->postcode : '' }}" required minlength="5" maxlength="5">
									</div>
								</div>
								<div class="col-md-4">
	                                <div class="form-group form-group-default form-group-default-custom form-group-default-select2 required">
	                                    <label><span>Negeri</span></label>
	                                    <select id="edit_officer_state_id" name="state_id" class="full-width autoscroll state" data-init-plugin="select2" required="">
	                                        <option value="" selected="" disabled="">Pilih satu..</option>
	                                        @foreach($states as $index => $state)
	                                        <option value="{{ $state->id }}">{{ $state->name }}</option>
	                                        @endforeach
	                                    </select>
	                                </div>
	                            </div>
	                            <div class="col-md-4">
	                                <div class="form-group form-group-default form-group-default-custom form-group-default-select2 required">
	                                    <label><span>Daerah</span></label>
	                                    <select id="edit_officer_district_id" name="district_id" class="full-width autoscroll district" data-init-plugin="select2" required="">
	                                    	@foreach($districts as $index => $district)
	                                        <option value="{{ $district->id }}">{{ $district->name }}</option>
	                                        @endforeach
	                                    </select>
	                                </div>
	                            </div>
							</div>							
						</div>
					</form>
					<div class="row">
						<div class="col-md-12 p-t-10">
							<button type="button" class="btn btn-info m-t-5 pull-right"onclick="submitForm('form-edit-appointed')"><i class="fa fa-check mr-1"></i> Simpan</button>
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

	$('#edit_officer_designation_id').select2({
	    dropdownParent: $('#edit_officer_designation_id').parents(".modal-dialog").find('.modal-content'),
	    language: 'ms',
	});

	$('#edit_officer_state_id').select2({
	    dropdownParent: $('#edit_officer_state_id').parents(".modal-dialog").find('.modal-content'),
	    language: 'ms',
	});

	$('#edit_officer_district_id').select2({
	    dropdownParent: $('#edit_officer_district_id').parents(".modal-dialog").find('.modal-content'),
	    language: 'ms',
	});

    $('#modal-editAppointed').modal('show');
    $(".modal form").validate();

    $("#form-edit-appointed").submit(function(e) {
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
                $("#modal-editAppointed").modal("hide");
                table10.api().ajax.reload(null, false);
            },
        });
    });

    $("#edit_officer_designation_id").val( {{ $officer->designation_id }} ).trigger('change');
    $("#edit_officer_state_id").val( {{ $officer->address->state_id }} ).trigger('change');
    $("#edit_officer_district_id").val( {{ $officer->address->district_id }} ).trigger('change');
</script>
