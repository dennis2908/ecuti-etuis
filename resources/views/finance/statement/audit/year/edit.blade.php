<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-hidden="false">
	<div class="modal-dialog ">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="modal-header clearfix text-left">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
					</button>
					<h5>Maklumat <span class="semi-bold">Tahun Kewangan Borang N Yang Lepas</span></h5>
					<p class="p-b-10">Sila lengkapkan maklumat pada ruangan di bawah.</p>
				</div>
				<div class="modal-body">
					<form id="form-edit-formn" role="form" method="post" action="{{ route('formjl1.formn.form', [$auditor->id, $formn->id]) }}">
						<div class="form-group-attached">
							<div class="row">
								<div class="col-md-12">
									<select id="edit_formn_id" name="formn_id" class="full-width autoscroll" data-init-plugin="select2" required>
                                        <option value="" selected="" disabled="">Pilih satu..</option>
                                        @foreach($prior_formns as $formn)
                                        <option value="{{ $formn->id }}" auditor_name="{{ $formn->auditor_name }}">{{ $formn->year }}</option>
                                        @endforeach
                                    </select>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									@component('components.label', [
										'label' => 'Nama Juruaudit',
										'mode' => 'required',
									])
									-
                                    @endcomponent
								</div>
							</div>
						</div>
					</form>
					<div class="row">
						<div class="col-md-12 p-t-10">
							<button type="button" class="btn btn-info m-t-5 pull-right" onclick="submitForm('form-edit-formn')"><i class="fa fa-check mr-1"></i> Simpan</button>
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
	$('#edit_formn_id').select2({
	    dropdownParent: $('#edit_formn_id').parents(".modal-dialog").find('.modal-content'),
	    language: 'ms',
	});
    $('#modal-edit').modal('show');
    $(".modal form").validate();

    $("#form-edit-formn").submit(function(e) {
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
</script>
