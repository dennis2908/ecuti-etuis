<!-- START CONTAINER FLUID -->
<div class=" container-fluid container-fixed-lg bg-white">
	<!-- START card -->
	<div class="card card-transparent mb-0 mt-3">
		<form class="p-b-10" id="form-specific" role="form" autocomplete="off" method="post" action="{{ route('admin.holiday.specific') }}" novalidate>
			<div class="form-group-attached">
				<div class="row clearfix filter">
					<div class="col-md-6">
						<div class="form-group form-group-default form-group-default-select2">
							<label>Negeri</label>
							<select name="state_id" id="state_id" class="full-width" data-placeholder="Pilih satu..." data-init-plugin="select2" required>
								<option selected disabled hidden>Pilih satu..</option>
								@foreach($states as $state)
								<option value="{{ $state->id }}">{{ $state->name }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group form-group-default form-group-default-select2">
							<label>Tahun</label>
							<select name="specific_year" id="specific_year" class="full-width" data-placeholder="Pilih satu..." data-init-plugin="select2" required>
								<option selected disabled hidden>Pilih satu..</option>
								@foreach($years as $year)
								<option value="{{ $year }}">{{ $year }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group form-group-default form-group-default-select2">
							<label>Bulan</label>
							<select name="specific_month" id="specific_month" class="full-width" data-placeholder="Pilih satu..." data-init-plugin="select2" required>
								<option selected value="-1">-- Semua Bulan --</option>
								@foreach($months as $month)
								<option value="{{ $month->id }}">{{ $month->name }}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="card card-transparent">
		<div class="card-header px-0 search-on-button">
			<div class="pull-right">
				<div class="col-xs-12">
					<input type="text" id="specific-search-table" class="form-control search-table pull-right" placeholder="Carian..">
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="card-block">
			
			<table class="table table-hover " id="table-specific">
				<thead>
					<tr>
						<th class="fit">Bil.</th>
						<th>Cuti</th>
						<th>Negeri</th>
						<th class="fit">Jumlah Hari</th>
						<th class="fit">Tarikh Mula</th>
						<th class="fit">Hari</th>
						<th>Tindakan</th>
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
				<li class="previous">
					<button class="btn btn-default btn-cons btn-animated from-left fa fa-angle-left" type="button">
						<span>Kembali</span>
					</button>
				</li>
			</ul>
		</div>
	</div>
</div>
<!-- END CONTAINER FLUID -->

@push('modal')
<!-- Modal -->
<div class="modal fade" id="modal-addSpecific" tabindex="-1" role="dialog" aria-labelledby="addModalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalTitle">Tambah <span class="bold">Cuti Negeri</span></h5>
                <small class="text-muted">Sila isi maklumat pada ruangan di bawah.</small>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body m-t-20">
				<form id="form-add-specific" role="form" method="post" action="{{ route('admin.holiday.specific') }}">
					@include('components.input', [
	                    'name' => 'name',
	                    'label' => 'Nama Cuti',
	                    'mode' => 'required',
	                ])

					<div class="form-group form-group-default form-group-default-custom form-group-default-select2 required">
                        <label><span>Negeri</span></label>
                        <select id="state_id" name="states[]" class="full-width autoscroll" data-init-plugin="select2" required="" multiple required="">
                            <option value="" disabled="">Pilih..</option>
                            @foreach($states as $state)
                            <option value="{{ $state->id }}">{{ $state->name }}</option>
                            @endforeach
                        </select>
                    </div>

					@include('components.input', [
	                    'name' => 'duration',
	                    'label' => 'Jumlah Hari',
	                    'mode' => 'required',
	                    'class' => 'numeric',
	                ])

					@include('components.date', [
	                    'name' => 'start_date',
	                    'label' => 'Mulai Cuti Pada',
	                    'mode' => 'required',
	                ])
				</form>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                <button type="button" class="btn btn-info" onclick="submitForm('form-add-specific')"><i class="fa fa-check m-r-5"></i> Hantar</button>
            </div>
        </div>
    </div>
</div>
@endpush

@push('js')
<script>
var table2 = $('#table-specific');

var settings2 = {
	"processing": true,
	"serverSide": true,
	"deferRender": true,
	"ajax": "{{ route('admin.holiday.specific') }}",
	"columns": [
		{ data: 'index', defaultContent: '', orderable: false, searchable: false, render: function (data, type, row, meta) {
			return meta.row + meta.settings._iDisplayStart + 1;
		}},
		{ data: "name", name: "name"},
		{ data: "states.name", name: "states.name", searchable: false, defaultContent: '-'},
		{ data: "duration", name: "duration"},
		{ data: "start_date", name: "start_date"},
		{ data: "day", name: "day"},
		{ data: "action", name: "action", orderable: false, searchable: false},
	],
	"columnDefs": [
		{ className: "nowrap", "targets": [ 6 ] }
	],
    "sDom": "B<t><'row'<p i>>",
    "buttons": [
        {
            text: '<i class="fa fa-plus m-r-5"></i> Cuti Negeri',
            className: 'btn btn-success btn-cons',
            action: function ( e, dt, node, config ) {
                addSpecific();
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

table2.dataTable(settings2);

// search box for table
$('#specific-search-table').keyup(function() {
	table2.fnFilter($(this).val());
});

$(".filter select").on('change', function() {
    var form2 = $("#form-specific");

    settings2 = {
        "processing": true,
        "serverSide": true,
        "deferRender": true,
        "ajax" : form2.attr('action')+"?"+form2.serialize(),
        "columns": [
			{ data: 'index', defaultContent: '', orderable: false, searchable: false, render: function (data, type, row, meta) {
				return meta.row + meta.settings._iDisplayStart + 1;
			}},
			{ data: "name", name: "name"},
			{ data: "states.name", name: "states.name", searchable: false, defaultContent: '-'},
			{ data: "duration", name: "duration"},
			{ data: "start_date", name: "start_date"},
			{ data: "day", name: "day"},
			{ data: "action", name: "action", orderable: false, searchable: false},
		],
		"columnDefs": [
			{ className: "nowrap", "targets": [ 6 ] }
		],
	    "sDom": "B<t><'row'<p i>>",
	    "buttons": [
	        {
	            text: '<i class="fa fa-plus m-r-5"></i> Cuti Negeri',
	            className: 'btn btn-success btn-cons',
	            action: function ( e, dt, node, config ) {
	                addSpecific();
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

    table2.dataTable(settings2);
});

function addSpecific() {
	$('#modal-addSpecific').modal('show');
	$('.modal form').trigger("reset");
	$('.modal form').validate();
}

function editSpecific(id) {
	$("#modal-div").load("{{ route('admin.holiday.specific') }}/"+id);
}

$("#form-add-specific").submit(function(e) {
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
			$("#modal-addSpecific").modal("hide");
			table2.api().ajax.reload(null, false);
		}
	});
});

function removeSpecific(id) {
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
				url: '{{ route('admin.holiday.specific') }}/'+id,
				method: 'delete',
				dataType: 'json',
				async: true,
				contentType: false,
				processData: false,
				success: function(data) {
					swal(data.title, data.message, data.status);
					table2.api().ajax.reload(null, false);
				}
			});
		}
	});
}
</script>
@endpush
