<!-- START CONTAINER FLUID -->
<div class=" container-fluid container-fixed-lg bg-white">
	<!-- START card -->
	<div class="card card-transparent">
		<div class="card-block">
			<table class="table table-hover " id="table-general">
				<thead>
					<tr>
						<th class="fit">Bil.</th>
						<th>Cuti</th>
						<th class="fit">Jumlah Hari</th>
						<th class="fit">Tarikh Mula</th>
						<th class="fit">Hari</th>
						<th class="fit">Tindakan</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
	<!-- END card -->
	<div class="row mt-5">
		<div class="col-md-12">
			<ul class="pager wizard no-style">
				<li class="next">
					<button class="btn btn-success btn-cons btn-animated from-left pull-right fa fa-angle-right" type="button">
						<span>Seterusnya</span>
					</button>
				</li>
				<li>
					<button class="btn btn-default btn-cons btn-animated from-left fa fa-angle-left" type="button" onclick="back()">
						<span>Kembali</span>
					</button>
				</li>
			</ul>
		</div>
	</div>
</div>


@push('js')
<script>
var table = $('#table-general');

var settings = {
	"processing": true,
	"serverSide": true,
	"deferRender": true,
	"ajax": "{{ route('staff.holiday_approved.general') }}",
	"columns": [
		{ data: 'index', defaultContent: '', orderable: false, searchable: false, render: function (data, type, row, meta) {
			return meta.row + meta.settings._iDisplayStart + 1;
		}},
		{ data: "name", name: "name"},
		{ data: "duration", name: "duration"},
		{ data: "start_date", name: "start_date"},
		{ data: "day", name: "day"},
		{ data: "action", name: "action", orderable: false, searchable: false},
	],
	"columnDefs": [
		{ className: "nowrap", "targets": [ 5 ] }
	],
    "sDom": "B<t><'row'<p i>>",
    "buttons": [
        {
            text: '<i class="fa fa-print m-r-5"></i> Cetak',
            extend: 'print',
            className: 'btn btn-default btn-sm',
            exportOptions: {
                columns: ':visible:not(.nowrap)'
            }
        },
        {
            text: '<i class="fa fa-download m-r-5"></i> Excel',
            extend: 'excelHtml5',
            className: 'btn btn-default btn-sm',
            exportOptions: {
                columns: ':visible:not(.nowrap)'
            }
        },
        {
            text: '<i class="fa fa-download m-r-5"></i> PDF',
            extend: 'pdfHtml5',
            className: 'btn btn-default btn-sm',
            exportOptions: {
                columns: ':visible:not(.nowrap)'
            }
        },
    ],
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
	"iDisplayLength": 10
};

table.dataTable(settings);

// search box for table
$('#general-search-table').keyup(function() {
	table.fnFilter($(this).val());
});


$(".filter select").on('change', function() {
    var form = $("#form-general");

    settings = {
        "processing": true,
        "serverSide": true,
        "deferRender": true,
        "ajax" : form.attr('action')+"?"+form.serialize(),
        "columns": [
			{ data: 'index', defaultContent: '', orderable: false, searchable: false, render: function (data, type, row, meta) {
				return meta.row + meta.settings._iDisplayStart + 1;
			}},
			{ data: "name", name: "name"},
			{ data: "duration", name: "duration"},
			{ data: "start_date", name: "start_date"},
			{ data: "day", name: "day"},
			{ data: "action", name: "action", orderable: false, searchable: false},
		],
		"columnDefs": [
			{ className: "nowrap", "targets": [ 5 ] }
		],
	    "sDom": "B<t><'row'<p i>>",
	    "buttons": [
	        {
	            text: '<i class="fa fa-plus m-r-5"></i> Cuti Persekutuan',
	            className: 'btn btn-success btn-cons',
	            action: function ( e, dt, node, config ) {
	                addGeneral();
	            }
	        },
	        {
	            text: '<i class="fa fa-print m-r-5"></i> Cetak',
	            extend: 'print',
	            className: 'btn btn-default btn-sm',
	            exportOptions: {
	                columns: ':visible:not(.nowrap)'
	            }
	        },
	        {
	            text: '<i class="fa fa-download m-r-5"></i> Excel',
	            extend: 'excelHtml5',
	            className: 'btn btn-default btn-sm',
	            exportOptions: {
	                columns: ':visible:not(.nowrap)'
	            }
	        },
	        {
	            text: '<i class="fa fa-download m-r-5"></i> PDF',
	            extend: 'pdfHtml5',
	            className: 'btn btn-default btn-sm',
	            exportOptions: {
	                columns: ':visible:not(.nowrap)'
	            }
	        },
	    ],
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
		"iDisplayLength": 10
    };

    table.dataTable(settings);
});


function addGeneral() {
	$('#modal-addGeneral').modal('show');
	$('.modal form').trigger("reset");
	$('.modal form').validate();
}

function editGeneral(id) {
	$("#modal-div").load("{{ route('staff.holiday_approved.general') }}/"+id);
}

$("#form-add-general").submit(function(e) {
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
			$("#modal-addGeneral").modal("hide");
			table.api().ajax.reload(null, false);
		}
	});
});

function upd_approvedGeneral(id) {

			$.ajax({
				url: '{{ route('staff.holiday_approved.upd_approved') }}/'+id,
				method: 'GET',
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
</script>
@endpush
