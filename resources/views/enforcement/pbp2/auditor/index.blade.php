<div class="form-group row">
	<label for="checklist27" class="col-md-4 control-label">
		<div class="checkbox check-success mt-0 data-true">
			<input value="1" id="checklist27" type="checkbox" class="hidden">
			<label for="checklist27">Juruaudit dalam yang di lantik mengikut Perlembagaan Kesatuan
			</label>
		</div>
	</label>
	<div class="col-md-8">
		<button onclick="addAuditor()" class="btn btn-primary btn-cons" type="button"><i class="fa fa-plus m-r-5"></i> Tambah Juruaudit</button>
		<table class="table table-hover " id="table-auditor">
			<thead>
				<tr>
					<th class="fit">Bil.</th>
					<th>Nama</th>
					<th class="fit">Jawatan</th>
					<th class="fit">Tindakan</th>
				</tr>
			</thead>
		</table>
	</div>
</div>
@push('modal')
<div class="modal fade" id="modal-add-auditor" tabindex="-1" role="dialog" aria-hidden="false">
	<div class="modal-dialog ">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="modal-header clearfix text-left">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
					</button>
					<h5>Maklumat <span class="semi-bold">Juru Audit Dalam</span></h5>
				</div>
				<div class="modal-body">
					<form id="form-add-auditor" role="form" method="post" action="{{ route('pbp2.auditor', request()->id) }}">
						<div class="form-group-attached">
							<div class="row">
								<div class="col-md-12">
									@include('components.input', [
										'name' => 'name',
										'label' => 'Nama',
										'mode' => 'required',
									])
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									@include('components.input', [
										'name' => 'designation',
										'label' => 'Jawatan',
										'mode' => 'required',
									])
								</div>
							</div>
						</div>
					</form>
					<div class="row">
						<div class="col-md-12 p-t-10">
							<button type="button" class="btn btn-info m-t-5 pull-right" onclick="submitForm('form-add-auditor')"><i class="fa fa-check mr-1"></i> Simpan</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
</div>
@endpush
@push('js')
<script type="text/javascript">

	var table8 = $('#table-auditor');

	var settings8 = {
	    "processing": true,
	    "serverSide": true,
	    "deferRender": true,
	    "ajax": "{{ route('pbp2.auditor', request()->id) }}",
	    "columns": [
	        { data: 'index', defaultContent: '', orderable: false, searchable: false, render: function (data, type, row, meta) {
	            return meta.row + meta.settings._iDisplayStart + 1;
	        }},
	        { data: "name", name: "name"},
	        { data: "designation", name: "designation"},
	        { data: "action", name: "action", orderable: false, searchable: false},
	    ],
	    "columnDefs": [
	        { className: "nowrap", "targets": [ 3 ] }
	    ],
	    "sDom": "<t><'row'<p i>>",
	    "destroy": true,
	    "scrollCollapse": true,
	    "oLanguage": {
	        "sEmptyTable":      "Tiada data",
	        "sInfo":            "Paparan dari _START_ hingga _END_ dari _TOTAL_ rekod",
	        "sInfoEmpty":       "Paparan 0 hingga 0 dari 0 rekod",
	        "sInfoFiltered":    "(Ditapis dari jumlah _MAX_ rekod)",
	        "sInfoPostFix":     "",
	        "sInfoThousands":   ",",
	        "sLengthMenu":      "Papar _MENU_ rekod",
	        "sLoadingRecords":  "Diproses...",
	        "sProcessing":      "Sedang diproses...",
	        "sSearch":          "Carian:",
	       "sZeroRecords":      "Tiada padanan rekod yang dijumpai.",
	       "oPaginate": {
	           "sFirst":        "Pertama",
	           "sPrevious":     "Sebelum",
	           "sNext":         "Kemudian",
	           "sLast":         "Akhir"
	       },
	       "oAria": {
	           "sSortAscending":  ": diaktifkan kepada susunan lajur menaik",
	           "sSortDescending": ": diaktifkan kepada susunan lajur menurun"
	       }
	    },
	    "iDisplayLength": -1
	};

	table8.dataTable(settings8);

	// search box for table
	$('#search-table-auditor').keyup(function() {
	    table8.fnFilter($(this).val());
	});

	function addAuditor() {
	    $('#modal-add-auditor').modal('show');
	    $('.modal form').trigger("reset");
	    $('.modal form').validate();
	}

	function editAuditor(id) {
		$("#modal-div").load("{{ route('pbp2.auditor', request()->id) }}/"+id);
	}

	$("#form-add-auditor").submit(function(e) {
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
	            $("#modal-add-auditor").modal("hide");
	            table8.api().ajax.reload(null, false);
	        }
	    });
	});

	function removeAuditor(id) {
	    swal({
	        title: "Padam Data",
	        text: "Data yang telah dipadam tidak boleh dikembalikan. Teruskan?",
	        icon: "warning",
	        buttons: ["Batal", { text: "Padam", closeModal: false }],
	        dangerMode: true,
	    })
	    .then((confirm) => {
	        if (confirm) {
	            $.ajax({
	                url: '{{ route('pbp2.auditor', request()->id) }}/'+id,
	                method: 'delete',
	                dataType: 'json',
	                async: true,
	                contentType: false,
	                processData: false,
	                success: function(data) {
	                    swal(data.title, data.message, data.status);
	                    table8.api().ajax.reload(null, false);
	                }
	            });
	        }
	    });
	}

</script>
@endpush