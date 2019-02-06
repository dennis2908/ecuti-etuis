@extends('layouts.app')
@include('plugins.datatables')

@section('content')
<!-- START JUMBOTRON -->
<div class="jumbotron" data-pages="parallax">
    <div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
        <div class="inner">
            <!-- START BREADCRUMB -->
            {{ Breadcrumbs::render('enforcement') }}
            <!-- END BREADCRUMB -->
            <div class="row">
                <div class="col-xl-12 col-lg-12 ">
                    <!-- START card -->
                    <div class="card card-transparent">
                        <div class="card-block p-t-0">
                            <h3 class='m-t-0'>Senarai Pemeriksaan Berkanun</h3>
                            <p class="small hint-text m-t-5">
                               Pengurusan permohonan Pemeriksaan Berkanun boleh dilakukan melalui jadual di bawah.
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
            	@if(auth()->user()->hasRole('ppw'))
                <button onclick="add()" id="" href="javascript:;" class="btn btn-success btn-cons text-capitalize"><i class="fa fa-plus m-r-5"></i> Sesi Pemeriksaan</button>
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
                        <th>Kesatuan</th>
                        <th>Tarikh</th>
                        <th>Tempat</th>
                        <th>Status</th>
                        <th>Surat / Lampiran</th>
                        <th>Daerah</th>
                        <th>Negeri</th>
                        <th class="fit">Tindakan</th>
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
<div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog ">
        <div class="modal-content-wrapper">
            <div class="modal-content">
                <div class="modal-header clearfix text-left">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                    </button>
                    <h5>Maklumat <span class="semi-bold">Sesi Pemeriksaan</span></h5>
                    <p class="p-b-10">Maklumat sesi pemeriksaan berkanun.</p>
                </div>
                <div class="modal-body">
                    <form id='form-add' role="form" method="post" action="{{ route('enforcement') }}">
                        <div class="form-group-attached">
                            {{--
                                <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group form-group-default form-group-default-custom form-group-default-select2 required">
                                        <label><span>Jenis Kesatuan</span></label>
                                        <select id="user_type_id" name="user_type_id" class="full-width autoscroll" data-init-plugin="select2" required="">
                                            <option value="" selected="" disabled="">Pilih satu..</option>
                                            @foreach($types as $index => $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group form-group-default form-group-default-custom form-group-default-select2 required">
                                        <label><span>Kesatuan</span></label>
                                        <select id="user_id" name="user_id" class="full-width autoscroll" data-init-plugin="select2" required="">
                                            <option value="" selected="" disabled="">Pilih satu..</option>
                                            @foreach($users as $index => $user)
                                            <option value="{{ $user->id }}">{{ $user->entity->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-md-6">
                                    @include('components.date', [
                                    'name' => 'start_at',
                                    'label' => 'Tarikh Mula',
                                    'mode' => 'required',
                                    'value' => date('d/m/Y'),
                                    ])
                                </div>
                                <div class="col-md-6">
                                    @include('components.date', [
                                    'name' => 'end_at',
                                    'label' => 'Tarikh Akhir',
                                    'mode' => 'required',
                                    'value' => date('d/m/Y'),
                                    ])
                                </div>
                            </div>
                            <div class="row clearfix address">
                                <div class="col-md-6">
                                    <div class="form-group form-group-default form-group-default-custom form-group-default-select2 required">
                                        <label><span>Negeri</span></label>
                                        <select id="state_id" name="state_id" class="full-width state autoscroll" data-init-plugin="select2" required="">
                                            <option value="" selected="" disabled="">Pilih satu..</option>
                                            @foreach($states as $index => $state)
                                            <option value="{{ $state->id }}">{{ $state->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-default form-group-default-custom form-group-default-select2 required">
                                        <label><span>Daerah</span></label>
                                        <select id="district_id" name="district_id" class="full-width autoscroll district" data-init-plugin="select2" required="">
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" onclick="submitForm('form-add')"><i class="fa fa-check m-r-5"></i> Hantar</button>
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
    "ajax": "{{ fullUrl() }}",
    "columns": [
        { data: 'index', defaultContent: '', orderable: false, searchable: false, render: function (data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
        }},
        { data: "entity.name", name: "entity.name"},
        { data: "start_date", name: "start_date"},
        { data: "location", name: "location", searchable:false},
        { data: "status.name", name: "status.name", render: function(data, type, row){
            return $("<div/>").html(data).text();
        }},
        { data: "letter", name: "letter", searchable: false, render: function(data, type, row){
            return $("<div/>").html(data).text();
        }},
        { data: "district.name", name: "district.name", visible:false},
        { data: "state.name", name: "state.name", visible:false},
        { data: "action", name: "action", orderable: false, searchable: false},
    ],
    "columnDefs": [
        { className: "nowrap", "targets": [ 8 ] }
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

$('.datepicker').datepicker({
    language: 'ms',
	format: 'dd/mm/yyyy',
    endDate: '+0d',
    autoclose: true,
    onClose: function() {
        $(this).valid();
    },
}).on('changeDate', function(){
    $(this).trigger('change');
});

function process(id) {
    $("#modal-div").load("{{ route('enforcement') }}/"+id+"/process/result");
}

function process_pw(id) {
    $("#modal-div").load("{{ route('enforcement') }}/"+id+"/process/result-pw");
}

function receive(id) {
    $("#modal-div").load("{{ route('enforcement') }}/"+id+"/process/document-receive");
}

function query(id) {
    $("#modal-div").load("{{ route('enforcement') }}/"+id+"/process/query");
}

function recommend(id) {
    $("#modal-div").load("{{ route('enforcement') }}/"+id+"/process/recommend");
}

function status(id) {
    $("#modal-div").load("{{ route('enforcement') }}/"+id+"/process/status");
}

</script>
@endpush
