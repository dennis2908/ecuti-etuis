@extends('layouts.app')
@include('plugins.datatables')

@section('content')
<!-- START BREADCRUMB -->
<div class="jumbotron" data-pages="parallax">
	<div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
		<div class="inner" style="transform: translateY(0px); opacity: 1;">
			{{ Breadcrumbs::render('enforcement.pbp2') }}
			<!-- END BREADCRUMB -->
			<div class="row">
				<div class="col-xl-12 col-lg-12 ">
					<!-- START card -->
					<div class="card card-transparent">
						<div class="card-block p-t-0">
							<h3 class='m-t-0'> Senarai Harta / Aset Kesatuan</h3>
							<p class="small hint-text m-t-5">
								Lampiran B1
							</p>
						</div>
					</div>
					<!-- END card -->
				</div>
			</div>
		</div>
	</div>
</div>
<!-- END BREADCRUMB -->
<!-- END JUMBOTRON -->
<!-- START CONTAINER FLUID -->

<!-- START CONTAINER FLUID -->
<div class=" container-fluid container-fixed-lg bg-white">
    <!-- START card -->
    <div class="card card-transparent">
        <div class="card-header px-0">
            <div class="card-title">
            	<button onclick="add()" class="btn btn-primary btn-cons" type="button"><i class="fa fa-plus m-r-5"></i> Tambah Aset</button>
            </div>
            <div class="pull-right">
                <div class="col-xs-12">
                    <input type="text" id="search-table" class="form-control search-table pull-right" placeholder="Carian">
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="card-block">
            <table class="table table-hover" id="table">
                <thead>
                    <tr>
                        <th class="fit">Bil.</th> 
                        <!-- If majikan, Nama Kesatuan-->
                        <th>Jenis Harta / Aset</th>
                        <th>Tahun Diperoleh</th>
                        <th>Nilai Semasa (RM)</th>
                        <th>Lokasi</th>
                        <th class="fit">Tindakan</th>
                    </tr>
                </thead>
            </table>
            <br>
            <div class="form-group">
				<!-- If mode update form change button label to Kemaskini-->
				<button type="button" class="btn btn-info pull-right" onclick="saveData()" data-dismiss="modal"><i class="fa fa-check mr-1"></i> Simpan</button>
			</div>
        </div>
    </div>
    <!-- END card -->
</div>
<!-- END CONTAINER FLUID -->
@endsection
@push('modal')
<div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-hidden="false">
	<div class="modal-dialog ">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="modal-header clearfix text-left">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
					</button>
					<h5>Maklumat <span class="semi-bold">Aset / Harta</span></h5>
				</div>
				<div class="modal-body">
					<form id="form-add" role="form" method="post" action="{{ route('pbp2.b1', request()->id) }}">
						<div class="form-group-attached">
							<div class="row">
								<div class="col-md-12">
									@include('components.input', [
										'name' => 'asset_type',
										'label' => 'Jenis Aset / Harta',
										'mode' => 'required',
									])
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									@include('components.input', [
										'name' => 'year_obtained',
										'label' => 'Tahun Diperoleh',
										'mode' => 'required',
									])
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									@include('components.input', [
										'name' => 'current_value',
										'label' => 'Nilai Semasa',
                                        'class' => 'decimal',
										'mode' => 'required',
									])
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									@include('components.textarea', [
										'name' => 'location',
										'label' => 'Lokasi',
										'mode' => 'required',
									])
								</div>
							</div>
						</div>
					</form>
					<div class="row">
						<div class="col-md-12 p-t-10">
							<button type="button" class="btn btn-info m-t-5 pull-right" onclick="submitForm('form-add')"><i class="fa fa-check mr-1"></i> Simpan</button>
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

    var table = $('#table');

    var settings = {
        "processing": true,
        "serverSide": true,
        "deferRender": true,
        "ajax": "{{ route('pbp2.b1', request()->id) }}",
        "columns": [
            { data: 'index', defaultContent: '', orderable: false, searchable: false, render: function (data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
            }},
            { data: "asset_type", name: "asset_type", searchable: true},
            { data: "year_obtained", name: "year_obtained", searchable: true},
            { data: "current_value", name: "current_value", searchable: true},
            { data: "location", name: "location", searchable: true},
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
        $("#modal-div").load("{{ route('pbp2.b1', request()->id) }}/"+id);
    }

    $("#form-add").submit(function(e) {
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
                    url: '{{ route('pbp2.b1', request()->id) }}/'+id,
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