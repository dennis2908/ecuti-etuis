@extends('layouts.app')
@include('plugins.datatables')
@include('plugins.moment')

@section('content')
<!-- START JUMBOTRON -->
<div class="jumbotron" data-pages="parallax">
    <div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
        <div class="inner">
            <!-- START BREADCRUMB -->
            {{ Breadcrumbs::render('admin.backup') }}
            <!-- END BREADCRUMB -->
            <div class="row">
                <div class="col-xl-12 col-lg-12 ">
                    <!-- START card -->
                    <div class="card card-transparent">
                        <div class="card-block p-t-0">
                            <h3 class='m-t-0'>Pengurusan Simpanan</h3>
                            <p class="small hint-text m-t-5">
                                <!-- You can manage the data storage and backup following table. -->
                            </p>

                            <form role="form" id="form-newbackup" method="post" action="{{ route('admin.backup') }}">
                                <div class="row m-t-20">
                                	<div class="col-md-6">
                                        @include('components.input', [
                                            'name' => 'filename',
                                            'label' => 'Nama Fail',
                                            'mode' => 'required',
                                            'options' => 'onkeydown="generateName()"',
                                        ])
                                		<div class="checkbox check-info">
                                			<button type="submit" class="btn btn-info btn-cons"><i class="fa fa-check m-r-5"></i> Simpan</button>
                                			<input value="1" onchange="generateName()" id="check-database" type="checkbox" class="hidden" name="types[]" checked>
                                            <label for="check-database">Database</label>

                                            <input value="2" onchange="generateName()" id="check-filesystem" type="checkbox" class="hidden" name="types[]" checked>
                                            <label for="check-filesystem">Sistem Fail</label>
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
        <div class="card-header px-0 search-on-button"><!-- 
            <div class="card-title">
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
                        <th>Nama Fail</th>
                        <th>Saiz</th>
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
$("#form-newbackup").validate();

function generateName() {

    var filename = "";

    if( $("#check-database").prop("checked") )
        filename += "DB-";

    if( $("#check-filesystem").prop("checked") )
        filename += "FS-";

    filename += moment().format('YYYYMMDDHHmm');

    $("input[name=filename]").val(filename);
}

generateName();

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
        { data: "filename", name: "filename"},
        { data: "size", name: "size"},
        { data: "created_at", name: "created_at"},
        { data: "action", name: "action", orderable: false, searchable: false},
    ],
    "columnDefs": [
        { className: "nowrap", "targets": [ 3 ] }
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
    "iDisplayLength": -1
};

table.dataTable(settings);

// search box for table
$('#search-table').keyup(function() {
    table.fnFilter($(this).val());
});

$("#form-newbackup").submit(function(e) {
    e.preventDefault();
    var form = $(this);

    if(!form.valid())
        return;

    swal({
        title: "Mulakan Simpanan?",
        text: "Proses ini akan mengambil masa seketika.",
        icon: "warning",
        buttons: ["Batal", { text: "Teruskan", closeModal: false }]
    })
    .then((confirm) => {
        if (confirm) {

            swal({
                title: "Dalam Proses..",
                text: "Proses simpanan sedang berjalan. Anda boleh tinggalkan paparan ini jika perlu.",
                type: "info"
            });

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
                    table.api().ajax.reload(null, false);
                    $('#form-newbackup')[0].reset();
                    generateName();
                }
            });
        }
    });
});

function remove(filename) {

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
                url: "{{ route('admin.backup') }}/"+filename,
                method: 'delete',
                data: { filename: filename },
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