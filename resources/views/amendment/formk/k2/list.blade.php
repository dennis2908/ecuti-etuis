@extends('layouts.app')
@include('plugins.datatables')

@section('content')
<!-- START JUMBOTRON -->
<div class="jumbotron" data-pages="parallax">
	<div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
		<div class="inner">
			<!-- START BREADCRUMB -->
			{{ Breadcrumbs::render('formk.k2') }}
			<div class="row">
				<div class="col-xl-12 col-lg-12 ">
					<!-- START card -->
					<div class="card card-transparent">
						<div class="card-block p-t-0">
							<h3 class='m-t-0'>Borang U - Penyata Keputusan Undi</h3>
							<p class="small hint-text m-t-5">
								AKTA KESATUAN SEKERJA, 1959 (Seksyen 40 dan Peraturan 26)
							</p>
						</div>
					</div>
					<!-- END card -->
				</div>
			</div>
		</div>
	</div>
</div>
<!-- END JUMBOTRON -->

<!-- START CONTAINER FLUID -->
<div class=" container-fluid container-fixed-lg bg-white">
	<!-- START card -->
	<div class="card card-transparent">
		<div class="card-header px-0">
			<div class="card-title">
				<a href="{{ route('formk.k2', $formk->id) }}" class="btn btn-primary pull-right btn-input text-capitalize"><i class="fa fa-edit mr-1"></i>  Tambah Undi</a>
			</div>
			<div class="pull-right">
				<div class="col-xs-12">
					<input type="text" id="search-table" class="form-control search-table pull-right" placeholder="Carian">
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="card-block table-responsive">
			<table class="table table-hover " id="table-appeals">
				<thead>
					<tr>
						<th class="fit">Bil.</th>
						<th>Ketetapan</th>
						<th>Tarikh Undi Sulit</th>
						<th>Status</th>
						<th class="fit">Tindakan</th>
					</tr>
				</thead>
			</table>
            <br>
            <button type="button" class="btn btn-default m-b-20" onclick="location.href='{{ route('formk.form', $formk->id) }}'"><i class="fa fa-angle-left mr-1"></i> Kembali</button>
		</div>
	</div>
	<!-- END card -->
</div>
<!-- END CONTAINER FLUID -->
@endsection

@push('js')
<script>
var table = $('#table-appeals');

var settings = {
    "processing": true,
    "serverSide": true,
    "deferRender": true,
    "ajax": "{{ fullUrl() }}",
    "columns": [
        { data: 'index', defaultContent: '', orderable: false, searchable: false, render: function (data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
        }},
        { data: "setting", name: "setting"},
		{ data: "voted_at", name: "voted_at"},
		{ data: "is_supported", name: "is_supported", render: function(data, type, row){
            return $("<div/>").html(data).text();
        }},
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
    "iDisplayLength": -1
};

table.dataTable(settings);

// search box for table
$('#search-table').keyup(function() {
    table.fnFilter($(this).val());
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
                url: '{{ route('formk.k2', $formk->id) }}/'+id,
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
