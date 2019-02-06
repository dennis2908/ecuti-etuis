@extends('layouts.app')
@include('plugins.datatables')
@include('plugins.jsonpresenter')

@section('content')
<!-- START JUMBOTRON -->
<div class="jumbotron" data-pages="parallax">
    <div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
        <div class="inner">
            <!-- START BREADCRUMB -->
            {{ Breadcrumbs::render('admin.log') }}
            <!-- END BREADCRUMB -->
            <div class="row">
                <div class="col-xl-12 col-lg-12 ">
                    <!-- START card -->
                    <div class="card card-transparent">
                        <div class="card-block p-t-0">
                            <h3 class='m-t-0'>Jejak Audit / Log Sistem</h3>
                            <p class="small hint-text m-t-5">
                                Jejaki semua aktiviti dalam sistem oleh semua pengguna melalui jadual di bawah.
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
        <div class="card-header px-0 search-on-button">
            <div class="card-title">
               
            </div>
            <div class="pull-right">
                <div class="col-xs-12">
                    <input type="text" id="search-table" class="form-control pull-right" placeholder="Carian...">
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="card-block">
            <table class="table table-hover" id="table">
                <thead>
                    <tr>
                        <th class="fit">Bil.</th>
                        <th>Aktiviti</th>
                        <th>Modul</th>
                        <th>Butiran</th>
                        <th class="fit">URL</th>
                        <th>Pengguna</th>
                        <th>Alamat IP</th>
                        <th>Tarikh & Masa</th>
                        <th>Butiran</th>
                        <th>Data Lama</th>
                        <th>Data Baru</th>
                        <th>Kaedah</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <!-- END card -->
</div>
<!-- END CONTAINER FLUID -->
@endsection
@push('js')
<script type="text/javascript">

var table = $('#table');

var settings = {
    "processing": true,
    "serverSide": true,
    "deferRender": true,
    "ajax": "{{ fullUrl() }}",
    "columns": [
        { data: 'index', defaultContent: '', orderable: false, searchable: false, render: function (data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
        }},        
        { data: "activity_type.name", name: "activity_type.name", render: function(data, type, row){
            return $("<div/>").html(data).text();
        }},
        { data: "module.name", name: "module.name"}, 
        { data: "description", name: "description"},        
        { data: "url", name: "url", visible: false},        
        { data: "created_by.name", name: "created_by.name"},        
        { data: "ip_address", name: "ip_address"},        
        { data: "created_at", name: "created_at"},
        { data: "description", name: "description", visible: false},
        { data: "data_old", name: "data_old", visible: false},
        { data: "data_new", name: "data_new", visible: false},
        { data: "method", name: "method", visible: false},
        { data: "action", name: "action", orderable: false, searchable: false},
    ],
    "columnDefs": [
        { className: "nowrap", "targets": [ 6 ] }
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
    "iDisplayLength": 20
};

table.dataTable(settings);

// search box for table
$('#search-table').keyup(function() {
    table.fnFilter($(this).val());
});

function view(id) {
    $("#modal-div").load("{{ route('admin.log') }}/"+id);
}

</script>
@endpush
