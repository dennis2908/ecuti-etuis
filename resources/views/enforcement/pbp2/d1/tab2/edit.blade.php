<div class="modal fade" id="modal-edit-trustee" tabindex="-1" role="dialog" aria-hidden="false">
	<div class="modal-dialog ">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="modal-header clearfix text-left">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
					</button>
					<h5>Maklumat <span class="semi-bold">Pemegang Amanah</span></h5>
					<p class="p-b-10">Maklumat pemegang amanah.</p>
				</div>
				<div class="modal-body">
					<form id="form-edit-trustee" role="form" method="post" action="{{ route('pbp2.d1.trustee.form', [request()->id, $trustee->id]) }}">
						<div class="form-group-attached">
							<div class="row">
								<div class="col-md-12">
									@include('components.input', [
										'name' => 'name',
										'label' => 'Nama',
										'mode' => 'required',
										'value' => $trustee->name
									])
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									@include('components.input', [
										'name' => 'identification_no',
										'label' => 'No. KPPN / No. Passpot',
										'mode' => 'required',
										'value' => $trustee->identification_no
									])
								</div>
							</div>
							<div class="row clearfix">
								<div class="col-md-6">
									@include('components.date', [
										'name' => 'appointed_date',
										'label' => 'Tarikh Dilantik',
										'mode' => 'required',
										'value' => $trustee->appointed_at ? date('d/m/Y', strtotime($trustee->appointed_at)) : date('d/m/Y')
									])
								</div>
								<div class="col-md-6">
									@include('components.date', [
										'name' => 'birth_date',
										'label' => 'Tarikh Lahir',
										'mode' => 'required',
										'value' => $trustee->date_of_birth ? date('d/m/Y', strtotime($trustee->date_of_birth)) : date('d/m/Y')
									])
								</div>
							</div>
						</div>
					</form>
					<div class="row">
						<div class="col-md-12 p-t-10">
							<button type="button" class="btn btn-info m-t-5 pull-right" onclick="submitForm('form-edit-trustee')"><i class="fa fa-check mr-1"></i> Simpan</button>
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

$('#modal-edit-trustee').modal('show');
$(".modal form").validate();

$("#form-edit-trustee").submit(function(e) {
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
            $("#modal-edit-trustee").modal("hide");
            table2.api().ajax.reload(null, false);
        }
    });
});
</script>