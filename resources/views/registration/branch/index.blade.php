@extends('layouts.app')
@include('plugins.datatables')

@section('content')
<!-- START JUMBOTRON -->
<div class="jumbotron" data-pages="parallax">
    <div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
        <div class="inner">
            <!-- START BREADCRUMB -->
            {{ Breadcrumbs::render('registration.branch') }}
            <!-- END BREADCRUMB -->
            <div class="row">
                <div class="col-xl-12 col-lg-12 ">
                    <!-- START card -->
                    <div class="card card-transparent">
                        <div class="card-block p-t-0">
                            <h3 class='m-t-0'>Senarai <span class="semi-bold">Cawangan</span></h3>
                            <p class="small hint-text m-t-5">
                                Pengurusan cawangan boleh dilakukan melalui jadual di bawah.
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
                <button onclick="add()" class="btn btn-success btn-cons"><i class="fa fa-plus m-r-5"></i> Cawangan</button>
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
                        <th>Nama Cawangan</th>
                        <th>Alamat</th>
                        <th>Alamat 1</th>
                        <th>Alamat 2</th>
                        <th>Alamat 3</th>
                        <th>Poskod</th>
                        <th>Negeri</th>
                        <th>Daerah</th>
                        <th>Tarikh Ditubuhkan</th>
                        <th>Tarikh Mesyuarat</th>
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
                <h5 class="modal-title" id="addModalTitle">Tambah <span class="bold">Cawangan</span></h5>
                <small class="text-muted">Sila isi maklumat pada ruangan di bawah.</small>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body m-t-20">
                <form id='form-add' role="form" method="post" action="{{ route('branch') }}">
                    @include('components.input', [
                        'name' => 'name',
                        'label' => 'Nama',
                        'mode' => 'required',
                    ])

                    @include('components.input', [
                        'name' => 'user_union_id',
                        'label' => 'Kesatuan',
                        'mode' => 'hidden',
                        'value' => auth()->user()->entity->id
                    ])

                    <div class="form-group-attached m-b-10">
                        @include('components.input', [
                            'name' => 'address1',
                            'mode' => 'required',
                            'label' => 'Alamat 1',
                        ])

                        @include('components.input', [
                            'name' => 'address2',
                            'label' => 'Alamat 2',
                        ])

                        @include('components.input', [
                            'name' => 'address3',
                            'label' => 'Alamat 3',
                        ])

                        <div class="row clearfix address">
                            <div class="col-md-4">
                                @include('components.input', [
                                    'name' => 'postcode',
                                    'label' => 'Poskod',
                                    'mode' => 'required',
                                    'class' => 'postcode numeric',
                                    'options' => 'minlength="5" maxlength="5"'
                                ])
                            </div>
                            <div class="col-md-4">
                                <div class="form-group form-group-default form-group-default-custom form-group-default-select2">
                                    <label><span>Negeri</span></label>
                                    <select id="state_id" name="state_id" class="full-width autoscroll state" data-init-plugin="select2" required="">
                                        <option value="" selected="" disabled="">Pilih satu..</option>
                                        @foreach($states as $index => $state)
                                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group form-group-default form-group-default-custom form-group-default-select2">
                                    <label><span>Daerah</span></label>
                                    <select id="district_id" name="district_id" class="full-width autoscroll district" data-init-plugin="select2" required="">
                                        <option value="" selected="" disabled="">Pilih satu..</option>
                                        @foreach($districts as $index => $district)
                                        <option value="{{ $district->id }}">{{ $district->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    @include('components.input', [
                        'name' => 'secretary_name',
                        'label' => 'Nama Setiausaha',
                        'mode' => 'required',
                    ])

                    @include('components.input', [
                        'name' => 'secretary_email',
                        'label' => 'Emel Setiausaha',
                        'type' => 'email',
                    ])

                    @include('components.input', [
                        'name' => 'secretary_phone',
                        'label' => 'No Telefon Setiausaha',
                    ])

                    @include('components.input', [
                        'name' => 'total_member',
                        'label' => 'Bilangan Ahli',
                    ])

                    @include('components.date', [
                        'name' => 'established_at',
                        'label' => 'Tarikh Penubuhan',
                        'mode' => 'required',
                    ])

                    @include('components.date', [
                        'name' => 'meeting_at',
                        'label' => 'Tarikh Mesyuarat Agung',
                        'mode' => 'required',
                    ])
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
        { data: "name", name: "name"},
        { data: "full_address", name: "full_address", searchable: false, render: function(data, type, row){
            return $("<div/>").html(data).text();
        }},
        { data: "address.address1", name: "address.address1", visible: false},
        { data: "address.address2", name: "address.address2", visible: false},
        { data: "address.address3", name: "address.address3", visible: false},
        { data: "address.postcode", name: "address.postcode", visible: false},
        { data: "address.district.name", name: "address.district.name", visible: false},
        { data: "address.state.name", name: "address.state.name", visible: false},
        { data: "established_at", name: "established_at"},
        { data: "meeting_at", name: "meeting_at"},
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

function edit(id) {
    $("#modal-div").load("{{ route('branch') }}/"+id);
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
                url: '{{ route('branch') }}/'+id,
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
