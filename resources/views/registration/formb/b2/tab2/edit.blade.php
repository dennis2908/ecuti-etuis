<!-- Modal -->
<div class="modal fade" id="modal-editRequester" tabindex="-1" role="dialog" aria-hidden="false">
	<div class="modal-dialog ">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="modal-header clearfix text-left">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
					</button>
					<h5>Maklumat <span class="semi-bold">Pemohon</span></h5>
					<p class="p-b-10">Maklumat ahli yang membuat permohonan.</p>
				</div>
				<div class="modal-body">
					<form id="form-edit-requester" role="form" method="post" action="{{ route('formb.b2.requester.form', $requester->id) }}">
						<div class="form-group-attached">
							<div class="row">
								<div class="col-md-12">
									@include('components.input', [
										'name' => 'name',
										'label' => 'Nama',
										'mode' => 'required',
                                        'value' => $requester->name,
									])
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									@include('components.input', [
										'name' => 'identification_no',
										'label' => 'No. Kad Pengenalan',
										'mode' => 'required',
										'class' => 'numeric',
										'options' => 'maxlength=12 minlength=12',
                                        'value' => $requester->identification_no,
									])
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									@include('components.input', [
										'name' => 'occupation',
										'label' => 'Pekerjaan',
										'mode' => 'required',
                                        'value' => $requester->occupation,
									])
								</div>
							</div>
						</div>
						<p class="m-t-10 bold">Alamat Pemohon</p>
						<div class="form-group-attached">
							<div class="row clearfix">
								<div class="form-group form-group-default required">
									<label>Alamat 1</label>
									<input id="edit_requester_address1" class="form-control " name="address1" placeholder="" required="" type="text" value="{{ $requester->address->address1 }}">
								</div>
							</div>

							<div class="row clearfix">
								<div class="col-md-6">
        							<div class="form-group form-group-default">
										<label>Alamat 2</label>
										<input id="edit_requester_address2" class="form-control " name="address2" placeholder="" type="text" value="{{ $requester->address->address2 }}">
									</div>
								</div>
								<div class="col-md-6">
        							<div class="form-group form-group-default">
										<label>Alamat 3</label>
										<input id="edit_requester_address3" class="form-control " name="address3" placeholder="" type="text" value="{{ $requester->address->address3 }}">
									</div>
								</div>
							</div>

							<div class="row clearfix address">
								<div class="col-md-4">
	    							<div class="form-group form-group-default required">
										<label>Poskod</label>
										<input class="form-control numeric postcode" name="postcode" aria-required="true" type="text" value="{{ $requester->address->postcode or '' }}" required minlength="5" maxlength="5">
									</div>
								</div>
								<div class="col-md-4">
	                                <div class="form-group form-group-default form-group-default-custom form-group-default-select2 required">
	                                    <label><span>Negeri</span></label>
	                                    <select id="edit_requester_state_id" name="requester_state_id" class="full-width autoscroll state" data-init-plugin="select2" required="">
	                                        <option value="" selected="" disabled="">Pilih satu..</option>
	                                        @foreach($states as $index => $state)
                                            <option value="{{ $state->id }}"
                                            	@if($requester->address)
                                            		@if($requester->address->state_id == $state->id)
                                            			selected
                                            		@endif
                                            	@endif
                                            	>{{ $state->name }}
                                            </option>
	                                        @endforeach
	                                    </select>
	                                </div>
	                            </div>
	                            <div class="col-md-4">
	                                <div class="form-group form-group-default form-group-default-custom form-group-default-select2 required">
	                                    <label><span>Daerah</span></label>
	                                    <select id="edit_requester_district_id" name="requester_district_id" class="full-width autoscroll district" data-init-plugin="select2" required="">
	                                           <option value="" selected="" disabled="">Pilih satu..</option>
                                    </select>
	                                </div>
	                            </div>
							</div>
						</div>
                        <input type="hidden" name="created_by_user_id" value="{{ auth()->id() }}"/>
					</form>
					<div class="row">
						<div class="col-md-12 p-t-10">
							<button type="button" onclick="submitForm('form-edit-requester')" class="btn btn-info m-t-5 pull-right"><i class="fa fa-check mr-1"></i> Simpan</button>
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

$('#edit_requester_state_id').select2({
    dropdownParent: $('#edit_requester_state_id').parents(".modal-dialog").find('.modal-content'),
    language: 'ms',
});

$('#edit_requester_district_id').select2({
    dropdownParent: $('#edit_requester_district_id').parents(".modal-dialog").find('.modal-content'),
    language: 'ms',
});

$('#modal-editRequester').modal('show');
$(".modal form").validate();

$("#form-edit-requester").submit(function(e) {
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
            $("#modal-editRequester").modal("hide");
            table.api().ajax.reload(null, false);
        }
    });
});

$("#edit_requester_state_id").val( {{ $requester->address->state_id }} ).trigger('change');

$("#edit_requester_district_id").val( {{ $requester->address->district_id }} ).trigger('change');
</script>
