<!-- START CONTAINER FLUID -->
<div class="form-group row">
	<label for="fname" class="col-md-3 control-label">
		Laporan
	</label>
	<div class="col-md-9">
		<div class=" container-fluid container-fixed-lg bg-white">
			<table class="table table-hover " id="table-report">
				<thead>
					<tr>
						<th class="fit">Bil.</th>
						<th>Laporan</th>
						<th class="fit">Tindakan</th>
					</tr>
				</thead>
			</table>
			<div class="card-title p-t-10">
				<button id="" class="btn btn-primary btn-cons" type="button" onclick="add()"><i class="fa fa-plus m-r-5"></i> Tambah Laporan</button>
			</div>
		</div>
	</div>
	<!-- END card -->
</div>
@push('modal')
<div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-hidden="false">
	<div class="modal-dialog">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="modal-header clearfix text-left">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
					</button>
					<h5>Maklumat <span class="semi-bold">Laporan</span></h5>
					<p class="p-b-10">Maklumat laporan affidavit.</p>
				</div>
				<div class="modal-body">
					<form id="form-add-report" role="form" method="post" action="{{ route('affidavit.report', $affidavit->id) }}">
						<div class="form-group-attached">
							<div class="row">
								<div class="col-md-12">
									@include('components.textarea', [
                                    	'name' => 'data',
										'label' => 'Laporan',
										'mode' => 'required'
									])
								</div>
							</div>
						</div>
					</form>
					<div class="row">	
						<div class="col-md-12 p-t-10">
							<button type="button" class="btn btn-info m-t-5 pull-right submit" onclick="submitForm('form-add-report')"><i class="fa fa-check" ></i> Simpan</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
</div>
@endpush
<!-- END CONTAINER FLUID -->
@push('js')
<script type="text/javascript">
	
	var table = $('#table-report');

	var settings = {
	    "processing": true,
	    "serverSide": true,
	    "deferRender": true,
	    "ajax": "{{ route('affidavit.report', request()->id) }}",
	    "columns": [
	        { data: 'index', defaultContent: '', orderable: false, searchable: false, render: function (data, type, row, meta) {
	            return meta.row + meta.settings._iDisplayStart + 1;
	        }},
	        { data: "data", name: "data", defaultContent: '-'},
	        { data: "action", name: "action", orderable: false, searchable: false},
	    ],
	    "columnDefs": [
	        { className: "nowrap", "targets": [ 2 ] }
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

	table.dataTable(settings);

	// search box for table
	$('#search-table').keyup(function() {
	    table.fnFilter($(this).val());
	});

	function add() {
	    $('#modal-add').modal('show');
	    $('.modal form').trigger("reset");
	    $('.modal form').validate();
	}

	function edit(id) {
		if(id == null)
			addResign();
		else
	    	$("#modal-div").load("{{ route('affidavit.report', request()->id) }}/"+id);
	}

	$("#form-add-report").submit(function(e) {
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
	            $("#modal-add").modal("hide");
	            table.api().ajax.reload(null, false);
	        }
	    });
	});

	function remove(id) {
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
	                url: '{{ route('affidavit.report', $affidavit->id) }}/'+id,
	                method: 'delete',
	                dataType: 'json',
	                async: true,
	                contentType: false,
	                processData: false,
	                success: function(data) {
	                    swal(data.title, data.message, data.status);
	                    table.api().ajax.reload(null, false);
	                }
	            });
	        }
	    });
	}

</script>
@endpush