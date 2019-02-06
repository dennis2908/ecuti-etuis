@extends('layouts.app')
@include('plugins.datatables')

@section('content')
<!-- START JUMBOTRON -->
<div class="jumbotron" data-pages="parallax">
    <div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
        <div class="inner">
            <!-- START BREADCRUMB -->
            {{ Breadcrumbs::render('announcement') }}
            <!-- END BREADCRUMB -->
            <div class="row">
                <div class="col-xl-12 col-lg-12 ">
                    <!-- START card -->
                    <div class="card card-transparent">
                        <div class="card-block p-t-0">
                            <h3 class='m-t-0'>Pengurusan Pengumuman</h3>
                            <p class="small hint-text m-t-5">
                                Pengurusan pengumuman boleh dilakukan melalui jadual di bawah.
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
            <!-- <div class="card-title">
                <button onclick="addData()" class="btn btn-success btn-cons"><i class="fa fa-plus m-r-5"></i> Pengumuman</button>
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
                        <th class="fit">Tajuk Pengumuman</th>
                        <th class="fit">Butiran</th>
                        <th class="fit">Jenis</th>
                        <th class="fit">Dibuat Oleh</th>
                        <th class="fit">Tarikh Dibuat</th>
                        <th class="fit">Tarikh Mula</th>
                        <th class="fit">Tarikh Akhir</th>
                        <th>Jenis</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <!-- END card -->
</div>
<!-- END CONTAINER FLUID -->
<!-- Modal -->
<div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="addModalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalTitle">Tambah <span class="bold">Pengumuman</span></h5>
                <small class="text-muted">Sila isi maklumat pada ruangan di bawah.</small>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body m-t-20">
                <form id='form-add' role="form" method="post" action="{{ route('announcement') }}">
                    @include('components.input', [
                        'name' => 'created_by_user_id',
                        'label' => 'Dibuat Oleh',
                        'mode' => 'hidden',
                        'value' => auth()->user()->id
                    ])

                    @include('components.input', [
                        'name' => 'title',
                        'label' => 'Tajuk Pengumuman',
                        'mode' => 'required',
                    ])

                    @include('components.textarea', [
                        'name' => 'description',
                        'label' =>'Pengumuman',
                        'mode' => 'required',
                    ])

                    <div class="form-group form-group-default form-group-default-custom form-group-default-select2">
                        <label><span>Jenis Pengumuman</span></label>
                        <select id="announcement_type_id" name="announcement_type_id" class="full-width autoscroll" data-init-plugin="select2" required="" required="">
                            <option value="" selected="" disabled="">Pilih satu..</option>
                            @foreach($types as $index => $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group form-group-default form-group-default-custom form-group-default-select2">
                        <label><span>Papar Kepada</span></label>
                        <select id="target_roles" name="target_roles[]" class="full-width autoscroll" data-init-plugin="select2" required="" multiple required="">
                            @foreach($roles as $index => $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group-attached">
                        <div class="row clearfix">
                            <div class="col-md-6">
                                @include('components.date', [
                                    'name' => 'date_start',
                                    'label' => 'Tarikh Mula',
                                    'mode' => 'required',
                                ])
                            </div>
                            <div class="col-md-6">
                                @include('components.date', [
                                    'name' => 'date_end',
                                    'label' => 'Tarikh Tamat',
                                    'mode' => 'required',
                                ])
                            </div>
                        </div>
                    </div>
                </form>

            </div>

            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                <button type="button" class="btn btn-info" onclick="submitForm('form-add')"><i class="fa fa-check m-r-5"></i> Hantar</button>
            </div>
        </div>
    </div>
</div>
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
        { data: "title", name: "title"},
        { data: "announcement_type", name: "announcement_type", searchable: false, render: function(data, type, row){
            return $("<div/>").html(data).text();
        }},
        { data: "description", name: "description"},
        { data: "created_by.name", name: "created_by.name", visible: false, defaultContent: "-" },
        { data: "created_at", name: "created_at" },
        { data: "date_start", name: "date_start" },
        { data: "date_end", name: "date_end" },
        { data: "type.name", name: "type.name", visible: false, defaultContent: "-" },        
        { data: "action", name: "action", orderable: false, searchable: false},
    ],
    "columnDefs": [
        { className: "nowrap", "targets": [ 6 ] }
    ],
    "sDom": "B<t><'row'<p i>>",
    "buttons": [
        {
            text: '<i class="fa fa-plus m-r-5"></i> Pengumuman',
            className: 'btn btn-success btn-cons',
            action: function ( e, dt, node, config ) {
                add();
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
    "iDisplayLength": -1
};

table.dataTable(settings);

// search box for table
$('#search-table').keyup(function() {
    table.fnFilter($(this).val());
});

function edit(id) {
    $("#modal-div").load("{{ route('announcement') }}/"+id);
}

function add() {
    $('#modal-add').modal('show');
    $('.modal form').trigger("reset");
    $('.modal form').validate();
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
                url: '{{ route('announcement') }}/'+id,
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
