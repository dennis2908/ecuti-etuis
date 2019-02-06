@extends('layouts.app')
@include('plugins.datatables')

@section('content')
<!-- START JUMBOTRON -->
<div class="jumbotron" data-pages="parallax">
    <div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
        <div class="inner">
            <!-- START BREADCRUMB -->
            {{ Breadcrumbs::render('cancellation') }}
            <!-- END BREADCRUMB -->
            <div class="row">
                <div class="col-xl-12 col-lg-12 ">
                    <!-- START card -->
                    <div class="card card-transparent">
                        <div class="card-block p-t-0">
                            <h3 class='m-t-0'>Senarai <span class="semi-bold">Pembatalan Kesatuan Sekerja</span></h3>
                            <p class="small hint-text m-t-5">
                                Pengurusan permohonan Pembatalan Kesatuan Sekerja boleh dilakukan melalui jadual di bawah.
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
<div class=" container-fluid container-fixed-lg bg-white">
    <!-- START card -->
    <div class="card card-transparent">
        <div class="card-header px-0">
            <div class="card-title">
                @if(auth()->user()->hasRole('pw'))
                <button onclick="location.href='{{ route('cancellation') }}'" class="btn btn-success btn-cons"><i class="fa fa-plus m-r-5"></i> Laporan Pembatalan</button>
                @endif
            </div>
            <div class="pull-right">
                <div class="col-xs-12">
                    <input type="text" id="search-table" class="form-control search-table pull-right" placeholder="Carian">
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="card-block table-responsive">
            <table class="table table-hover" id="table">
                <thead>
                    <tr>
                        <th class="fit">Bil.</th>
                        <!-- <th>Nama Kesatuan</th> -->
                        <th>Nama Kesatuan</th>
                        <th>Jenis Entiti</th>
                        <th>Tarikh Notis</th>
                        <th>Status</th>
                        <th>Surat / Lampiran</th>
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
@push('modal')

<div class="modal fade slide-up show" id="modal-view" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content-wrapper">
            <div class="modal-content">
                <div class="modal-header clearfix text-left" style="background-color: #f3f3f3;">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                    </button>
                    <h5>Maklumat <span class="semi-bold">Permohonan Kesatuan Sekerja</span></h5>
                    <p class="p-b-10">Semua maklumat berkenaan Pendaftaran tersebut telah dipaparkan dalam bentuk kronologi dibawah</p>

                    <div class="pb-3">
                        Nama Kesatuan: <a onclick="openModalKS()" href="javascript:;" class="text-complete bold">Kesatuan Unijaya</a ></span><br>
                        Tarikh Penubuhan: <strong>19/01/2018</strong><br>
                        Nama Setiausaha: <strong>Adlan Arif Zakaria</strong>
                    </div>
                </div>
                <div class="modal-body pt-3">
                    @include('sample.timeline.b')
                </div>
                <div class="modal-footer" style="background-color: #f3f3f3;">
                    <button type="button" class="btn btn-secondary mt-4" data-dismiss="modal">Tutup</button>
                     @if(auth()->user()->hasAnyRole(['ptw','pthq']))
                    <button onclick="acceptData(1)" class="btn btn-info mt-4"><i class="fa fa-check mr-1"></i> Terima Dokumen Fizikal</button>
                    @endif
                    @if(auth()->user()->hasAnyRole(['pphq', 'pkpg', 'pkpp','kpks']))
                    <button onclick="queryData(1)" class="btn btn-warning mt-4"><i class="fa fa-question mr-1"></i> Kuiri</button>
                    @endif
                    @if(auth()->user()->hasAnyRole(['pphq', 'pkpp','pkpp','pkpg']))
                    <button onclick="commentData(1)" class="btn btn-warning mt-4"><i class="fa fa-comment mr-1"></i> Ulasan/Syor</button>
                    @endif
                    @if(auth()->user()->hasRole('kpks'))
                    <button onclick="processData(1)" class="btn btn-success mt-4"><i class="fa fa-spinner mr-1"></i> Proses</button>
                    @endif
                    @if(auth()->user()->hasRole('pthq'))
                    <button onclick="respondData(1)" class="btn btn-success mt-4"><i class="fa fa-spinner mr-1"></i> Kemaskini Maklumbalas</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endpush

@push('js')
<script>
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
        { data: "entity.name", name: "entity.name"},
        { data: "entity.type", name: "entity.type"},
        { data: "applied_at", name: "applied_at"},
        { data: "status.name", name: "status.name", render: function(data, type, row){
            return $("<div/>").html(data).text();
        }},
        { data: "letter", name: "letter", searchable: false, render: function(data, type, row){
            return $("<div/>").html(data).text();
        }},
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
    "iDisplayLength": -1
};

table.dataTable(settings);

// search box for table
$('#search-table').keyup(function() {
    table.fnFilter($(this).val());
});

function viewData(id) {
	$("#modal-view").modal("show");
}

function process(id) {
    $("#modal-div").load("{{ route('cancellation') }}/"+id+"/process/result");
}

function response(id) {
    $("#modal-div").load("{{ route('cancellation') }}/"+id+"/process/response-receive");
}

function receive(id) {
    $("#modal-div").load("{{ route('cancellation') }}/"+id+"/process/document-receive");
}

function query(id) {
    $("#modal-div").load("{{ route('cancellation') }}/"+id+"/process/query");
}

function recommend(id) {
    $("#modal-div").load("{{ route('cancellation') }}/"+id+"/process/recommend");
}

</script>
@endpush
