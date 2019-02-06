<!-- START CONTAINER FLUID -->
<div class=" container-fluid container-fixed-lg bg-white">
	<!-- START card -->
	<div class="card card-transparent">
		<div class="card-header px-0">
			<div class="pull-right">
				<div class="col-xs-12">
					<input type="text" id="leaving-search-table" class="form-control search-table pull-right" placeholder="Carian">
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="card-block">
			<table class="table table-hover " id="table-leaving">
				<thead>
					<tr>
						<th class="fit">Bil.</th>
						<th>Jawatan</th>
						<th>Nama Pegawai</th>
						<th class="fit">Tarikh Meninggalkan Jawatan</th>
						<th class="fit">Tindakan</th>
					</tr>
				</thead>
			</table>
			<div class="card-title p-t-10">
				<button id="" class="btn btn-primary btn-cons" type="button" onclick="addLeaving()"><i class="fa fa-plus m-r-5"></i> Tambah Pegawai</button>
			</div>
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
<div class="modal fade" id="modal-addLeaving" tabindex="-1" role="dialog" aria-hidden="false">
	<div class="modal-dialog">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="modal-header clearfix text-left">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
					</button>
					<h5>Maklumat <span class="semi-bold">Pegawai</span></h5>
					<p class="p-b-10">Maklumat pegawai yang meninggalkan jawatan.</p>
				</div>
				<div class="modal-body">
					<form id="form-add-leaving" role="form" method="post" action="{{ route('forml.leaving', $forml->id) }}">
						<div class="form-group-attached">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group form-group-default form-group-default-custom form-group-default-select2 required">
	                                    <label><span>Nama</span></label>
	                                    <select id="officer_id" name="officer_id" class="full-width autoscroll" data-init-plugin="select2" required="">
	                                        <option value="" selected="" disabled="">Pilih satu..</option>
	                                        @foreach($officers as $officer)
                                            <option value="{{ $officer->id }}" designation="{{ $officer->designation->name }}">{{ $officer->name }}</option>
	                                        @endforeach
	                                    </select>
	                                </div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
                                    @include('components.input', [
                                    	'name' => 'designation',
										'label' => 'Jawatan',
										'mode' => 'readonly',
										'class' => 'text-capitalize'
									])
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									@include('components.date', [
										'name' => 'left_at',
										'label' => 'Tarikh Meninggalkan Jawatan',
										'mode' => 'required',
										'value' => date('d/m/Y'),
									])
								</div>
							</div>
						</div>
					</form>
					<div class="row">
						<div class="col-md-12 p-t-10">
							<button type="button" class="btn btn-info m-t-5 pull-right submit" onclick="submitForm('form-add-leaving')"><i class="fa fa-check" ></i> Simpan</button>
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
<script>

var table = $('#table-leaving');

var settings = {
	"processing": true,
	"serverSide": true,
	"deferRender": true,
	"ajax": "{{ route('forml.leaving', $forml->id) }}",
	"columns": [
		{ data: 'index', defaultContent: '', orderable: false, searchable: false, render: function (data, type, row, meta) {
			return meta.row + meta.settings._iDisplayStart + 1;
		}},
		{ data: "officer.designation.name", name: "officer.designation.name", searchable: false},
		{ data: "officer.name", name: "officer.name"},
		{ data: "left_at", name: "left_at"},
		{ data: "action", name: "action", orderable: false, searchable: false},
	],
	"columnDefs": [
		{ className: "nowrap", "targets": [ 4 ] }
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
	"iDisplayLength": 10
};

table.dataTable(settings);

// search box for table
$('#leaving-search-table').keyup(function() {
	table.fnFilter($(this).val());
});

function addLeaving() {
	$('#modal-addLeaving').modal('show');
	$('.modal form').trigger("reset");
	$('.modal form').validate();
}

function editLeaving(id) {
	$("#modal-div").load("{{ route('forml.leaving', $forml->id) }}/"+id);
}

$("#form-add-leaving").submit(function(e) {
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
			$("#modal-addLeaving").modal("hide");
			if(data.count < 1) {
				$("a[data-target='#tab2'] i").removeClass('text-success');
				$("a[data-target='#tab2'] i").removeClass('fa-check');
				$("a[data-target='#tab2'] i").addClass('text-danger');
				$("a[data-target='#tab2'] i").addClass('fa-times');
			}
			else {
				$("a[data-target='#tab2'] i").removeClass('text-danger');
				$("a[data-target='#tab2'] i").removeClass('fa-times');
				$("a[data-target='#tab2'] i").addClass('text-success');
				$("a[data-target='#tab2'] i").addClass('fa-check');
			}
			table.api().ajax.reload(null, false);
		},
		error: function(xhr, ajaxOptions, thrownError){
	        swal('Harap Maaf!', 'Pegawai ini sudah dipilih.', 'error');
		}
	});
});

function removeLeaving(id) {
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
				url: '{{ route('forml.leaving', $forml->id) }}/'+id,
				method: 'delete',
				dataType: 'json',
				async: true,
				contentType: false,
				processData: false,
				success: function(data) {
					swal(data.title, data.message, data.status);
					if(data.count < 1) {
						$("a[data-target='#tab2'] i").removeClass('text-success');
						$("a[data-target='#tab2'] i").removeClass('fa-check');
						$("a[data-target='#tab2'] i").addClass('text-danger');
						$("a[data-target='#tab2'] i").addClass('fa-times');
					}
					else {
						$("a[data-target='#tab2'] i").removeClass('text-danger');
						$("a[data-target='#tab2'] i").removeClass('fa-times');
						$("a[data-target='#tab2'] i").addClass('text-success');
						$("a[data-target='#tab2'] i").addClass('fa-check');
					}
					table.api().ajax.reload(null, false);
				}
			});
		}
	});
}

$("#officer_id").change(function() {
	$("#designation").val($("#officer_id option:selected").attr("designation"));
});

</script>
@endpush
