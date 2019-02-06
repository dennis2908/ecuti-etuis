<div class="modal fade" id="modal-editWorker" tabindex="-1" role="dialog" aria-hidden="false">
	<div class="modal-dialog">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="modal-header clearfix text-left">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
					</button>
					<h5>Maklumat <span class="semi-bold">Pekerja</span></h5>
					<p class="p-b-10">Maklumat pekerja yang dilantik.</p>
				</div>
				<div class="modal-body">
					<form id="form-edit-worker" role="form" method="post" action="{{ route('forml1.worker.form', [ request()->id, $worker->id ]) }}">
					<form role="form">
						<p class="m-t-10 bold">Maklumat Pekerja</p>
						<div class="form-group-attached">							
							<div class="row">
								<div class="col-md-12">
									@include('components.input', [
										'name' => 'name',
										'label' => 'Nama',
										'mode' => 'required',
										'value' => $worker->name
									])
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									@include('components.input', [
										'name' => 'appointment',
										'label' => 'Perlantikan',
										'mode' => 'required',
										'value' => $worker->name
									])
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									@include('components.input', [
										'name' => 'identification_no',
										'label' => 'No Kad Pengenalan',
				                        'options' => 'maxlength=12 minlength=12',
				                        'class' => 'numeric',
										'mode' => 'required',
										'value' => $worker->identification_no
									])
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									@include('components.date', [
										'name' => 'dob',
										'label' => 'Tarikh Lahir',
										'mode' => 'required',
										'value' => date('d/m/Y', strtotime($worker->date_of_birth)),
									])
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									@include('components.input', [
										'name' => 'occupation',
										'label' => 'Pekerjaan',
										'mode' => 'required',
										'value' => $worker->occupation
									])
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									@include('components.date', [
										'name' => 'appointed_date',
										'label' => 'Tarikh Perlantikan',
										'value' => date('d/m/Y', strtotime($worker->appointed_at)),
									])
								</div>
							</div>
						</div>


						<p class="m-t-10 bold">Alamat Pekerja</p>
						<div class="form-group-attached">
							@include('components.input', [
								'name' => 'address1',
								'label' => 'Alamat 1',
								'mode' => 'required',
								'info' => 'Alamat Surat Menyurat terkini',
								'value' => $worker->address ? $worker->address->address1 : ''
							])

							<div class="row clearfix">
								<div class="col-md-6">
									@include('components.input', [
										'name' => 'address2',
										'label' => 'Alamat 2',
										'value' => $worker->address ? $worker->address->address2 : ''
									])
								</div>
								<div class="col-md-6">
									@include('components.input', [
										'name' => 'address3',
										'label' => 'Alamat 3',
										'value' => $worker->address ? $worker->address->address3 : ''
									])
								</div>
							</div>

							<div class="row clearfix address">
								<div class="col-md-4">
									<div class="form-group form-group-default required">
										<label>Poskod</label>
										<input class="form-control numeric postcode" name="postcode" aria-required="true" type="text" value="{{ $worker->address->postcode }}" required minlength="5" maxlength="5">
									</div>
								</div>
								<div class="col-md-4">
	                                <div class="form-group form-group-default form-group-default-custom form-group-default-select2 required">
	                                    <label><span>Negeri</span></label>
	                                    <select id="edit_worker_state_id" name="state_id" class="full-width autoscroll state" data-init-plugin="select2" required="">
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
	                                    <select id="edit_worker_district_id" name="district_id" class="full-width autoscroll district" data-init-plugin="select2" required="">
	                                    </select>
	                                </div>
	                            </div>
							</div>
						</div>
					</form>
					<div class="row">	
						<div class="col-md-12 p-t-10">
							<button type="button" class="btn btn-info m-t-5 pull-right submit" onclick="submitForm('form-edit-worker')"><i class="fa fa-check" ></i> Simpan</button>
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

$('#edit_worker_state_id').select2({
    dropdownParent: $('#edit_worker_state_id').parents(".modal-dialog").find('.modal-content'),
    language: 'ms',
});

$('#edit_worker_district_id').select2({
    dropdownParent: $('#edit_worker_district_id').parents(".modal-dialog").find('.modal-content'),
    language: 'ms',
});

$('#modal-editWorker').modal('show');
$(".modal form").validate();

$("#form-edit-worker").submit(function(e) {
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
            $("#modal-editWorker").modal("hide");
            table3.api().ajax.reload(null, false);
        }
    });
});

$("#edit_worker_state_id").val( {{ $worker->address->state_id }} ).trigger('change');

$("#edit_worker_district_id").val( {{ $worker->address->district_id }} ).trigger('change');
</script>