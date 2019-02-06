<!-- Modal -->
<div class="modal fade" id="modal-editOfficer" tabindex="-1" role="dialog" aria-hidden="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="modal-header clearfix text-left">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
					</button>
					<h5>Maklumat <span class="semi-bold">Pegawai</span></h5>
					<p class="p-b-10">Maklumat pegawai yang membuat permohonan.</p>
				</div>
				<div class="modal-body">
					<form id="form-edit-officer" role="form" method="post" class="is-icpassport" action="{{ route('formbb.bb2.officer.form', $officer->id) }}">
						<p class="m-t-10 bold">Maklumat Pegawai</p>
						<div class="form-group-attached">
							<div class="row">
								<div class="col-md-12">
									@include('components.input', [
										'name' => 'name',
										'label' => 'Nama',
										'mode' => 'required',
                                        'value' => $officer->name,
									])
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
                                    <div class="form-group form-group-default form-group-default-custom form-group-default-select2 required">
                                        <label>Jawatan</label>
                                        <select id="edit_officer_designation_id" name="designation_id" class="full-width autoscroll state" data-init-plugin="select2" required>
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
									@include('components.input', [
										'name' => 'age',
										'label' => 'Umur',
										'mode' => 'required',
                                        'value' => $officer->age,
                                        'class' => 'numeric',
									])
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									@component('components.label', [
										'name' => 'nationality_country_id',
										'label' => 'Jenis Kewarganegaraan',
										'mode' => 'required',
									])
									<div class="radio radio-primary ">
										<input name="edit_is_malaysian" value="1" id="edit_is_malaysian_yes" class="hidden is-ic" required="" type="radio">
										<label for="edit_is_malaysian_yes">Warganegara</label>
										<input name="edit_is_malaysian" value="2" id="edit_is_malaysian_no" class="hidden is-passport" required="" type="radio">
										<label for="edit_is_malaysian_no">Bukan Warganegara</label>
									</div>
									@endcomponent
								</div>
							</div>
							<div class="row nationality hidden">
								<div class="col-md-12">
									<div class="form-group form-group-default required form-group-default-select2 form-group-default-custom required">
										<label>Negara Kewarganegaraan</label>
										<select  id="edit_officer_nationality_country_id" name="nationality_country_id" class="full-width autoscroll select-modal" data-init-plugin="select2" >
											<option disabled hidden selected>Pilih satu</option>
											@foreach($countries as $country)
												<option value="{{ $country->id }}">{{ $country->name }}</option>
											@endforeach
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 input-ic">
									@include('components.input', [
										'name' => 'identification_no',
										'label' => 'No. K.P.P.N',
										'mode' => 'required',
										'class' => 'numeric',
										'options' => 'maxlength=12 minlength=12',
                                        'value' => $officer->identification_no,
									])
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 input-passport">
									@include('components.input', [
										'name' => 'identification_no',
										'label' => 'No. Passport',
										'mode' => 'required',
                                        'value' => $officer->identification_no,
									])
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									@include('components.input', [
										'name' => 'occupation',
										'label' => 'Pekerjaan Sekarang',
										'mode' => 'required',
                                        'value' => $officer->occupation,
									])
								</div>
							</div>
						</div>


						<p class="m-t-10 bold">Alamat Pegawai</p>
						<div class="form-group-attached">
							<div class="row clearfix">
								<div class="form-group form-group-default required">
									<label>Alamat 1</label>
									<input id="edit_officer_address1" class="form-control " name="address1" placeholder="" required="" type="text" value="{{ $officer->address->address1 }}">
								</div>
							</div>

							<div class="row clearfix">
								<div class="col-md-6">
        							<div class="form-group form-group-default">
										<label>Alamat 2</label>
										<input id="edit_officer_address2" class="form-control " name="address2" placeholder="" type="text" value="{{ $officer->address->address2 }}">
									</div>
								</div>
								<div class="col-md-6">
        							<div class="form-group form-group-default">
										<label>Alamat 3</label>
										<input id="edit_officer_address3" class="form-control " name="address3" placeholder="" type="text" value="{{ $officer->address->address3 }}">
									</div>
								</div>
							</div>

							<div class="row clearfix address">
								<div class="col-md-4">
	    							<div class="form-group form-group-default required">
										<label>Poskod</label>
										<input class="form-control numeric postcode" name="postcode" aria-required="true" type="text" value="{{ $officer->address->postcode or '' }}" required placeholder="Poskod" minlength="5" maxlength="5">
									</div>
								</div>
								<div class="col-md-4">
	                                <div class="form-group form-group-default form-group-default-custom form-group-default-select2">
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
	                                <div class="form-group form-group-default form-group-default-custom form-group-default-select2">
	                                    <label><span>Daerah</span></label>
	                                    <select id="edit_officer_district_id" name="district_id" class="full-width autoscroll district" data-init-plugin="select2" required="">
	                                        <option value="" selected="" disabled="">Pilih satu..</option>
	                                    </select>
	                                </div>
	                            </div>
							</div>
						</div>
						<input type="hidden" name="created_by_user_id" value="{{ auth()->id() }}"/>
					</form>
				</div>

				<div class="modal-footer">
					<div class="col-md-12 p-t-10">
						<button type="button" onclick="submitForm('form-edit-officer')" class="btn btn-info m-t-5 pull-right submit"><i class="fa fa-check"></i> Simpan</button>

					</div>
				</div>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
</div>

@include('components.ajax.address')

<script type="text/javascript">

    $('#edit_officer_state_id').select2({
        dropdownParent: $('#edit_officer_state_id').parents(".modal-dialog").find('.modal-content'),
        language: 'ms',
    });

    $('#edit_officer_district_id').select2({
        dropdownParent: $('#edit_officer_district_id').parents(".modal-dialog").find('.modal-content'),
        language: 'ms',
    });

    $('#edit_officer_nationality_country_id').select2({
        dropdownParent: $('#edit_officer_nationality_country_id').parents(".modal-dialog").find('.modal-content'),
        language: 'ms',
    });

    $('#edit_officer_designation_id').select2({
        dropdownParent: $('#edit_officer_designation_id').parents(".modal-dialog").find('.modal-content'),
        language: 'ms',
    });

    $('#modal-editOfficer').modal('show');
    $(".modal form").validate();

    $("#form-edit-officer").submit(function(e) {
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
                $("#modal-editOfficer").modal("hide");
                table.api().ajax.reload(null, false);
            }
        });
    });

    $("input[name=edit_is_malaysian]").on('change', function() {
		if( $(this).val() == 1 )
			$(".nationality").addClass("hidden");
		else
			$(".nationality").removeClass("hidden");
	});

    $("#edit_is_malaysian_{{ $officer->nationality_country_id == 1 ? 'yes' : 'no' }}").prop('checked', true).trigger('change');

    $("#edit_officer_designation_id").val({{ $officer->designation_id }}).trigger('change');

    $("#edit_officer_nationality_country_id").val({{ $officer->nationality_country_id }}).trigger('change');

    $("#edit_officer_state_id").val( {{ $officer->address->state_id }} ).trigger('change');

    $("#edit_officer_district_id").val( {{ $officer->address->district_id }} ).trigger('change');

</script>
