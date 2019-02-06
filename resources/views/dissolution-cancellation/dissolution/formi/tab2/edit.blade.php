<div class="modal fade" id="modal-editMember" tabindex="-1" role="dialog" aria-hidden="false">
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
                    <form  id="form-edit-member" role="form" method="post" action="{{ route('formi.member.form', [$dissolution->id, $member->id]) }}">
						<div class="form-group-attached">
							<div class="row">
								<div class="col-md-12">
                                    @include('components.input', [
										'name' => 'name',
										'label' => 'Nama',
										'mode' => 'required',
                                        'value' => $member->name,
									])
								</div>
							</div>
                        </div>
                        
                        <p class="m-t-10 bold">Alamat</p>
                        <div class="form-group-attached">
    						<div class="form-group-attached">
                                <div class="row clearfix">
    								<div class="form-group form-group-default required">
    									<label>Alamat 1</label>
    									<input id="edit_address1" class="form-control " name="address1" placeholder="" required="" type="text" value="{{ $member->address->address1 }}">
    								</div>
    							</div>

                                <div class="row clearfix">
    								<div class="col-md-6">
            							<div class="form-group form-group-default">
    										<label>Alamat 2</label>
    										<input id="edit_address2" class="form-control " name="address2" placeholder="" type="text" value="{{ $member->address->address2 }}">
    									</div>
    								</div>
    								<div class="col-md-6">
            							<div class="form-group form-group-default">
    										<label>Alamat 3</label>
    										<input id="edit_address3" class="form-control " name="address3" placeholder="" type="text" value="{{ $member->address->address3 }}">
    									</div>
    								</div>
    							</div>

    							<div class="row clearfix address">
    								<div class="col-md-4">
    	    							<div class="form-group form-group-default required">
    										<label>Poskod</label>
    										<input class="form-control numeric postcode" name="postcode" aria-required="true" type="text" value="{{ $member->address->postcode or '' }}" required minlength="5" maxlength="5">
    									</div>
    								</div>
    								<div class="col-md-4">
    	                                <div class="form-group form-group-default form-group-default-custom form-group-default-select2 required">
    	                                    <label><span>Negeri</span></label>
    	                                    <select id="edit_state_id" name="state_id" class="full-width autoscroll state" data-init-plugin="select2" required="">
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
    	                                    <select id="edit_district_id" name="district_id" class="full-width autoscroll district" data-init-plugin="select2" required="">
    	                                        <option value="" selected="" disabled="">Pilih satu..</option>
    	                                    </select>
    	                                </div>
    	                            </div>
    							</div>
    						</div>
						</div>
					</form>
					<div class="row">
						<div class="col-md-12 p-t-10">
							<button type="button" class="btn btn-info m-t-5 pull-right" onclick="submitForm('form-edit-member')"><i class="fa fa-check mr-1"></i> Simpan</button>
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

    $('#modal-editMember').modal('show');
    $(".modal form").validate();

    $("#form-edit-member").submit(function(e) {
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
                $("#modal-editMember").modal("hide");
                table.api().ajax.reload(null, false);
            }
        });
    });

    $("#edit_state_id").val( {{ $member->address->state_id }} ).trigger('change');

    $("#edit_district_id").val( {{ $member->address->district_id }} ).trigger('change');

</script>
