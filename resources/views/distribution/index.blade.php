@extends('layouts.app')
@include('plugins.datatables')

@section('content')
<!-- START JUMBOTRON -->
<div class="jumbotron" data-pages="parallax">
    <div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
        <div class="inner">
            <!-- START BREADCRUMB -->
            {{ Breadcrumbs::render('distribution') }}
            <!-- END BREADCRUMB -->
            <div class="row">
                <div class="col-xl-12 col-lg-12 ">
                    <!-- START card -->
                    <div class="card card-transparent">
                        <div class="card-block p-t-0">
                            <h3 class='m-t-0'>Pengurusan Agihan</h3>
                            <p class="small hint-text m-t-5">
                                Pengurusan agihan boleh dilakukan melalui jadual di bawah.
                            </p>
                            <form class="p-t-10" id="form-project" role="form" autocomplete="off" method="post" action="{{ route('distribution') }}" novalidate>
                                <div class="form-group-attached">
                                    <div class="row clearfix">
                                        <div class="col-md-6">
                                            <div class="form-group form-group-default required form-group-default-select2 form-group-default-custom required">
                                                <label>Jenis Modul</label>
                                                <select  id="module_id" name="module_id" class="full-width autoscroll select-modal" data-init-plugin="select2" required >
                                                    <option disabled hidden selected>Pilih satu</option>
                                                    <option value="-1">-- Semua Jenis --</option>
                                                    @foreach($modules as $module)
                                                        <option value="{{ $module->id }}"
                                                            >{{ $module->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            @include('components.input', [
                                                'name' => 'reference_no',
                                                'label' => 'No. Rujukan',
                                            ])
                                        </div>
                                        <div class="col-md-3">
                                            @include('components.input', [
                                                'name' => 'assigned_to',
                                                'label' => 'Agihan Kepada',
                                            ])
                                        </div>
                                    </div>
                                </div>
                            </form>
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
            <!-- <div class="card-title">
                <button id="" class="btn btn-default btn-sm" type="button">
                    <i class="fa fa-print m-r-5"></i> Cetak
                </button>
                <button id="" class="btn btn-default btn-sm" type="button">
                    <i class="fa fa-download m-r-5"></i> Excel
                </button>
                <button id="" class="btn btn-default btn-sm" type="button">
                    <i class="fa fa-download m-r-5"></i> PDF
                </button>
            </div> -->
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
                        <th>Borang / Modul</th>
                        <th>No. Rujukan</th>
                        <th>Agihan Kepada</th>
                        <th>Peranan</th>
                        <th>Tarikh</th>
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
    "ajax": "{{ route('distribution') }}",
    "columns": [
        { data: 'index', defaultContent: '', orderable: false, searchable: false, render: function (data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
        }},
        { data: "module", name: "module", searchable: false},
        { data: "filing.reference_no", name: "filing.reference_no", searchable: false, render: function(data, type, row){
            return $("<div/>").html(data).text();
        }},
        { data: "assigned_to.name", name: "assigned_to.name"},
        { data: "assigned_to.entity.role.name", name: "assigned_to.entity.role.name", render: function(data, type, row){
            return $("<div/>").html(data).text();
        }},
        { data: "created_at", name: "created_at"},
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
    "iDisplayLength": 10
};

table.dataTable(settings);

$("select, input").on('change', function() {
    var form = $("#form-project");

    settings = {
        "processing": true,
        "serverSide": true,
        "deferRender": true,
        "ajax": form.attr('action')+"?"+form.serialize(),
        "columns": [
            { data: 'index', defaultContent: '', orderable: false, searchable: false, render: function (data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
            }},
            { data: "module", name: "module", searchable: false},
            { data: "filing.reference_no", name: "filing.reference_no", searchable: false, render: function(data, type, row){
                return $("<div/>").html(data).text();
            }},
            { data: "assigned_to.name", name: "assigned_to.name"},
            { data: "assigned_to.entity.role.name", name: "assigned_to.entity.role.name", render: function(data, type, row){
                return $("<div/>").html(data).text();
            }},
            { data: "created_at", name: "created_at"},
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
        "iDisplayLength": 10
    };

    table.dataTable(settings);
});

// search box for table
$('#search-table').keyup(function() {
    table.fnFilter($(this).val());
});

function edit(id) {
    $("#modal-div").load("{{ route('distribution') }}/"+id);
}
</script>
@endpush
