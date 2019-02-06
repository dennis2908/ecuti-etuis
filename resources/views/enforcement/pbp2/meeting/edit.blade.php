<div class="modal fade" id="modal-edit-meeting" tabindex="-1" role="dialog" aria-hidden="false">
	<div class="modal-dialog ">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="modal-header clearfix text-left">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
					</button>
					<h5>Maklumat <span class="semi-bold">Tarikh Mesyuarat Sebelumnya</span></h5>
				</div>
				<div class="modal-body">
					<form id="form-edit-meeting" role="form" method="post" action="{{ route('pbp2.meeting.form', [request()->id, $meeting->id]) }}">
						<div class="form-group-attached">
							<div class="row">
								<div class="col-md-12">
									@include('components.input', [
										'name' => 'total_meeting',
										'label' => 'Bilangan Mesyuarat',
										'mode' => 'required',
										'value' => $meeting->total_meeting
									])
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									@include('components.date', [
										'name' => 'meeting_date',
										'label' => 'Tarikh Mesyuarat',
										'mode' => 'required',
										'value' => date('d/m/Y', strtotime($meeting->meeting_at))
									])
								</div>
							</div>
						</div>
					</form>
					<div class="row">
						<div class="col-md-12 p-t-10">
							<button type="button" class="btn btn-info m-t-5 pull-right" onclick="submitForm('form-edit-meeting')"><i class="fa fa-check mr-1"></i> Simpan</button>
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

$('#modal-edit-meeting').modal('show');
$(".modal form").validate();

$("#form-edit-meeting").submit(function(e) {
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
            $("#modal-edit-meeting").modal("hide");
            table5.api().ajax.reload(null, false);
        }
    });
});