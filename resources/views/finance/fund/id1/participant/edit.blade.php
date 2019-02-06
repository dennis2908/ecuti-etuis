<div class="modal fade" id="modal-editParticipant" tabindex="-1" role="dialog" aria-hidden="false">
	<div class="modal-dialog ">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="modal-header clearfix text-left">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
					</button>
					<h5>Kemaskini <span class="semi-bold">Individu / Agensi Luar yang terlibat</span></h5>
                    <p class="p-b-10">Sila isi maklumat pada ruangan di bawah.</p>
				</div>
				<div class="modal-body">
					<form id="form-edit-participant" role="form" method="post" action="{{ route('fund.id1.participant.form', [$fund->id, $participant->id]) }}">
						<div class="form-group form-group-default required">
							<label>
								<span> Jenis Pihak yang terlibat</span>
							</label>
							<div class="radio radio-primary">
								@foreach($party_types as $party_type)
								<input name="edit_party_type_id" value="{{ $party_type->id }}" id="edit_type{{ $party_type->id }}" type="radio" class="hidden" onchange="editParticipantType()" required>
								<label for="edit_type{{ $party_type->id }}">{{ $party_type->name }}</label>
								@endforeach
							</div>
						</div>

						<div class="type1 hidden">
							@include('components.input', [
								'name' => 'member_no',
								'label' => 'Nombor Ahli',
                                'value' => $participant->member_no,
							])
						</div>

						<div class="form-group-attached type2 hidden">
							<div class="row">
								<div class="col-md-12">
									@include('components.input', [
										'name' => 'individual_name',
										'label' => 'Nama',
                                        'value' => $participant->name,
									])
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									@include('components.input', [
										'name' => 'occupation',
										'label' => 'Pekerjaan',
                                        'value' => $participant->occupation,
									])
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									@include('components.input', [
										'name' => 'identification_no',
										'label' => 'No Kad Pengenalan',
                                        'value' => $participant->identification_no,
				                        'options' => 'maxlength=12 minlength=12',
				                        'class' => 'numeric',
									])
								</div>
								<div class="col-md-6">
									@include('components.input', [
										'name' => 'phone',
										'label' => 'No Telefon',
                                        'value' => $participant->phone,
									])
								</div>
							</div>
						</div>
						<div class="form-group-attached type3 hidden">
							<div class="row">
								<div class="col-md-12">
									@include('components.input', [
										'name' => 'company_name',
										'label' => 'Nama Agensi Syarikat',
                                        'value' => $participant->name,
									])
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									@include('components.input', [
										'name' => 'registration_no',
										'label' => 'No Pendaftaran Syarikat',
                                        'value' => $participant->registration_no,
									])
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									@include('components.textarea', [
										'name' => 'address_company',
										'label' => 'Alamat',
                                        'value' => $participant->address_company,
									])
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									@include('components.input', [
										'name' => 'email',
										'label' => 'Emel',
                                        'value' => $participant->email,
									])
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									@include('components.input', [
										'name' => 'fax',
										'label' => 'No Faks',
                                        'value' => $participant->fax,
									])
								</div>
								<div class="col-md-6">
									@include('components.input', [
										'name' => 'phone',
										'label' => 'Telefon',
                                        'value' => $participant->phone,
									])
								</div>
							</div>
						</div>
					</form>
					<div class="row">
						<div class="col-md-12 p-t-10">
							<button type="button" class="btn btn-info m-t-5 pull-right" onclick="submitForm('form-edit-participant')"><i class="fa fa-check mr-1"></i> Simpan</button>
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

    var party_type = {{ $participant->party_type_id }};

    if(party_type == 1)
        $("#edit_type1").prop('checked', true).trigger('change');
    else if(party_type == 2)
        $("#edit_type2").prop('checked', true).trigger('change');
    else
        $("#edit_type3").prop('checked', true).trigger('change');

    function editParticipantType() {
        var type = $('input[name="edit_party_type_id"]:checked').val();

        if(type == 1) {
            $(".type1").removeClass("hidden");
            $(".type2").addClass("hidden");
            $(".type3").addClass("hidden");
         }
        else if(type == 2) {
            $(".type1").addClass("hidden");
            $(".type2").removeClass("hidden");
            $(".type3").addClass("hidden");
         }
        else if(type == 3) {
            $(".type1").addClass("hidden");
            $(".type2").addClass("hidden");
            $(".type3").removeClass("hidden");
         }
    }

    $('#modal-editParticipant').modal('show');
    $(".modal form").validate();

    $("#form-edit-participant").submit(function(e) {
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
                $("#modal-editParticipant").modal("hide");
                table.api().ajax.reload(null, false);
            }
        });
    });
</script>
