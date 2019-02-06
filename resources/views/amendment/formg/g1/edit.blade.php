<div class="modal fade" id="modal-editMember" tabindex="-1" role="dialog" aria-hidden="false">
	<div class="modal-dialog">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="modal-header clearfix text-left">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
					</button>
					<h5>Maklumat <span class="semi-bold">Ahli</span></h5>
					<p class="p-b-10">Sila lengkapkan ruangan di bawah.</p>
				</div>
				<div class="modal-body">
					<form id="form-edit-member" role="form" method="post" action="{{ route('formg.g1.form.member.item', [$formg->id, $member->id]) }}">
						<div class="form-group-attached">
							<div class="row">
								<div class="col-md-12">
                                    @include('components.input', [
										'name' => 'name',
										'label' => 'Nama Ahli',
										'mode' => 'required',
                                        'value' => $member->name,
									])
                                </div>
							</div>
						</div>
					</form>
					<div class="row">
						<div class="col-md-12 p-t-10">
							<button type="button" class="btn btn-info m-t-5 pull-right submit" onclick="submitForm('form-edit-member')"><i class="fa fa-check" ></i> Simpan</button>
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
</script>
