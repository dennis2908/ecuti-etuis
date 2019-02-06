<!-- START CONTAINER FLUID -->
<div class=" container-fluid container-fixed-lg bg-white">
	<!-- START card -->
	<div class="card card-transparent">
		<div class="col-md-12 text-center p-t-20">
			<span class="bold">SENARAI SEKURITI-SEKURITI</span>
		</div>
		<div class="card-header px-0">
			<div class="card-title">
				
			</div>
			<div class="pull-right">
				<div class="col-xs-12">
					<input type="text" id="security-search-table" class="form-control search-table pull-right" placeholder="Carian">
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="card-block">
			<table class="table table-hover table-responsive-block" id="table-security">
				<thead>
					<tr>
						<th class="fit">Bil.</th>
						<th>Butir-butir</th>
						<th class="fit">Nilai Zahir</th>
						<th class="fit">Nilai Kos</th>
						<th class="fit">Nilai pasaran</th>
						<th class="fit">Dalam Tangan</th>
						<th class="fit">Tindakan</th>
					</tr>
				</thead>
			</table>
			<button id="" class="btn btn-primary btn-cons" type="button" onclick="addSecurity()"><i class="fa fa-plus m-r-5"></i> Tambah Sekuriti</button>
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

@push('modal')
<div class="modal fade" id="modal-addSecurity" tabindex="-1" role="dialog" aria-hidden="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="modal-header clearfix text-left">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
					</button>
					<h5>Maklumat <span class="semi-bold">Sekuriti</span></h5>
					<!-- <p class="p-b-10">Maklumat w.</p> -->
				</div>
				<div class="modal-body">
					<form id="form-add-security" role="form" method="post" action="{{ route('formn.security', $statement->id) }}">
						<div class="form-group-attached">
							
							<div class="row">
								<div class="col-md-12">
									<div class="form-group form-group-default required">
										<label>Butir-butir</label>
										<textarea style="height: 100px;" name="description" placeholder="" class="form-control" required></textarea>
									</div>
								</div>
							</div>
							<div class="form-group-attached">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group form-group-default required">
											<label>Nilai Zahir</label>
											<input type="text" class="form-control decimal" name="external_value">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group form-group-default required">
											<label>Nilai Kos</label>
											<input type="text" class="form-control decimal" name="cost_value">
										</div>
									</div>
								</div>								
							</div>
							<div class="form-group-attached">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group form-group-default required">
											<label>Nilai pasaran pada tarikh akaun-akaun itu dibuat</label>
											<input type="text" class="form-control" name="market_value">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group form-group-default required">
											<label>Dalam Tangan</label>
											<input type="text" class="form-control" name="cash">
										</div>
									</div>
								</div>								
							</div>
						</div>
					</form>
					<div class="row">
						<div class="col-md-12 p-t-10">
							<button type="button" class="btn btn-info m-t-5 pull-right" onclick="submitForm('form-add-security')"><i class="fa fa-check mr-1"></i> Simpan</button>
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
	
	var table11 = $('#table-security');

	var settings11 = {
	    "processing": true,
	    "serverSide": true,
	    "deferRender": true,
	    "ajax": "{{ route('formn.security', $statement->id) }}",
	    "columns": [
	        { data: 'index', defaultContent: '', orderable: false, searchable: false, render: function (data, type, row, meta) {
	            return meta.row + meta.settings._iDisplayStart + 1;
	        }},	        
	        { data: "description", name: "description"},
	        { data: "external_value", name: "external_value"},
	        { data: "cost_value", name: "cost_value"},
	        { data: "market_value", name: "market_value"},
	        { data: "cash", name: "cash"},
	        { data: "action", name: "action", orderable: false, searchable: false},
	    ],
	    "columnDefs": [
	        { className: "nowrap", "targets": [ 6 ] }
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

	table11.dataTable(settings11);

	// search box for table
	$('#security-search-table').keyup(function() {
	    table11.fnFilter($(this).val());
	});

	function addSecurity() {
	    $('#modal-addSecurity').modal('show');
	    $('.modal form').trigger("reset");
	    $('.modal form').validate();
	}

	function editSecurity(id) {
		$("#modal-div").load("{{ route('formn.security', $statement->id) }}/"+id);
	}

	$("#form-add-security").submit(function(e) {
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
	            $("#modal-addSecurity").modal("hide");
	            table11.api().ajax.reload(null, false);
	        }
	    });
	});

	function removeSecurity(id) {
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
	                url: '{{ route('formn.security', $statement->id) }}/'+id,
	                method: 'delete',
	                dataType: 'json',
	                async: true,
	                contentType: false,
	                processData: false,
	                success: function(data) {
	                    swal(data.title, data.message, data.status);
	                    table11.api().ajax.reload(null, false);
	                }
	            });
	        }
	    });
	}

</script>
@endpush