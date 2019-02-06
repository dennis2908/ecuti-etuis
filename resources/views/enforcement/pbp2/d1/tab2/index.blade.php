<!-- START CONTAINER FLUID -->
<div class=" container-fluid container-fixed-lg bg-white">
	<!-- START card -->
	<div class="card card-transparent">
		<div class="card-header px-0">
			<div class="pull-right">
				<div class="col-xs-12">
					<input type="text" id="search-table" class="form-control search-table pull-right" placeholder="Carian">
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="card-block">
			<table class="table table-hover " id="table-trustee">
				<thead>
					<tr>
						<th class="fit">Bil.</th>
						<th>Nama</th>
						<th class="fit">No KPPN / No Passpot</th>
						<th class="fit">Tarikh Dilantik</th>
						<th class="fit">Tarikh Lahir</th>
						<th class="fit">Tindakan</th>
					</tr>
				</thead>
			</table>
			<div class="card-title p-t-10">
				<button onclick="addTrustee()" class="btn btn-primary btn-cons" type="button"><i class="fa fa-plus m-r-5"></i> Pemegang Amanah</button>
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
<!-- Modal -->
<div class="modal fade" id="modal-add-trustee" tabindex="-1" role="dialog" aria-hidden="false">
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
					<form id="form-add-trustee" role="form" method="post" action="{{ route('pbp2.d1.trustee', request()->id) }}">
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
										'name' => 'identification_no',
										'label' => 'No. KPPN / No. Passpot',
										'mode' => 'required',
									])
								</div>
							</div>
							<div class="row clearfix">
								<div class="col-md-6">
									@include('components.date', [
										'name' => 'appointed_date',
										'label' => 'Tarikh Dilantik',
										'mode' => 'required',
									])
								</div>
								<div class="col-md-6">
									@include('components.date', [
										'name' => 'birth_date',
										'label' => 'Tarikh Lahir',
										'mode' => 'required',
									])
								</div>
							</div>
						</div>
					</form>
					<div class="row">
						<div class="col-md-12 p-t-10">
							<button type="button" class="btn btn-info m-t-5 pull-right" onclick="submitForm('form-add-trustee')"><i class="fa fa-check mr-1"></i> Simpan</button>
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

	var table2 = $('#table-trustee');

	var settings2 = {
	    "processing": true,
	    "serverSide": true,
	    "deferRender": true,
	    "ajax": "{{ route('pbp2.d1.trustee', request()->id) }}",
	    "columns": [
	        { data: 'index', defaultContent: '', orderable: false, searchable: false, render: function (data, type, row, meta) {
	            return meta.row + meta.settings._iDisplayStart + 1;
	        }},
	        { data: "name", name: "name", searchable: true},
	        { data: "identification_no", name: "identification_no", searchable: true},
	        { data: "appointed_at", name: "appointed_at", searchable: true},
	        { data: "date_of_birth", name: "date_of_birth", searchable: true},
	        { data: "action", name: "action", orderable: false, searchable: false},
	    ],
	    "columnDefs": [
	        { className: "nowrap", "targets": [ 5 ] }
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

	table2.dataTable(settings2);

	// search box for table
	$('#search-table-trustee').keyup(function() {
	    table2.fnFilter($(this).val());
	});

	function addTrustee() {
	    $('#modal-add-trustee').modal('show');
	    $('.modal form').trigger("reset");
	    $('.modal form').validate();
	}

	function editTrustee(id) {
		$("#modal-div").load("{{ route('pbp2.d1.trustee', request()->id) }}/"+id);
	}

	$("#form-add-trustee").submit(function(e) {
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
	            $("#modal-add-trustee").modal("hide");
	            table2.api().ajax.reload(null, false);
	        }
	    });
	});

	function removeTrustee(id) {
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
	                url: '{{ route('pbp2.d1.trustee', request()->id) }}/'+id,
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