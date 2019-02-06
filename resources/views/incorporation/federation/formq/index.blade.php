@extends('layouts.app')
@include('plugins.datatables')

@section('content')
<!-- START JUMBOTRON -->
<div class="jumbotron" data-pages="parallax">
    <div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
        <div class="inner">
            <!-- START BREADCRUMB -->
            {{ Breadcrumbs::render('formq') }}
            <!-- END BREADCRUMB -->
            <div class="row">
                <div class="col-xl-12 col-lg-12 ">
                    <!-- START card -->
                    <div class="card card-transparent">
                        <div class="card-block p-t-0">
                            <h3 class='m-t-0'>Borang Q - Notis Ketetapan Untuk Bersatu Dengan Sesuatu Persekutuan Kesatuan-Kesatuan Sekerja</h3>
                            <p class="small hint-text m-t-5">
                                Sila lengkapkan semua maklumat berikut mengikut turutan dan arahan yang dipaparkan.
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
<div class=" container-fluid container-fixed-lg bg-white" style="z-index: 1;">
    <!-- START card -->
    <div class="card card-transparent">
        <div class="card-block">
            <div>
                <form id="form-formq" class="form-horizontal" role="form" autocomplete="off" method="post" action="#">
                    @component('components.bs.label', [
                        'label' => 'Nama Kesatuan Sekerja',
                    ])
                    {{ $formq->formpq->tenure->entity->name }}
                    @endcomponent

                    @component('components.bs.label', [
                        'label' => 'No. Sijil Pendaftaran',
                    ])
                    {{ $formq->formpq->tenure->entity->registration_no }}
                    @endcomponent

                    @component('components.bs.label', [
                        'label' => 'Alamat Ibu Pejabat',
                    ])
                    {!! $formq->address->address1.
                    ($formq->address->address2 ? ',<br>'.$formq->address->address2 : '').
                    ($formq->address->address3 ? ',<br>'.$formq->address->address3 : '').
                    ',<br>'.
                    $formq->address->postcode.' '.
                    ($formq->address->district ? $formq->address->district->name : '').', '.
                    ($formq->address->state ? $formq->address->state->name : '') !!}
                    @endcomponent

                    <div class="form-group row">
                        <label for="fname" class="col-md-3 control-label">Persekutuan Yang Ingin Bergabung
                            <span style="color:red;">*</span>
                        </label>
                        <div class="col-md-9">
                            <select class="full-width" data-init-plugin="select2" name="user_federation_id" id="user_federation_id">
                                <option value="" selected="" disabled="">Pilih Satu...</option>
                                @foreach($federations as $federation)
                                <option value="{{ $federation->id }}">{{ $federation->name }}</option>
                                @endforeach
                            </select>          
                        </div>
                    </div>          

                    @include('components.bs.date', [
                        'name' => 'resolved_at',
                        'label' => 'Tarikh Diputuskan',
                        'mode' => 'required',
                        'value' => $formq->resolved_at ? date('d/m/Y', strtotime($formq->resolved_at)) : ''
                    ])

                    <div class="form-group row">
                        <label for="" class="col-md-3 control-label">
                            Melalui (Jenis Mesyuarat)<span style="color:red;">*</span>
                        </label>
                        <div class="col-md-9">
                            <div class="radio radio-primary">
                                @foreach($meeting_types as $meeting_type)
                                    <input name="meeting_type_id" value="{{ $meeting_type->id }}" id="meeting_type_{{ $meeting_type->id }}" type="radio" class="hidden" required>
                                    <label for="meeting_type_{{ $meeting_type->id }}">{{ $meeting_type->name }}</label>
                                @endforeach
                            </div>
                        </div>
                    </div>  

                    @component('components.bs.label', [
                        'name' => 'secretary',
                        'label' => 'Nama Setiausaha ',
                    ])
                    {{ $formq->secretary->name }}
                    @endcomponent

                    @include('components.bs.date', [
                        'name' => 'applied_at',
                        'label' => 'Tarikh Permohonan',
                        'mode' => 'required',
                        'value' =>  $formq->applied_at ? date('d/m/Y', strtotime($formq->applied_at)) : date('d/m/Y'),
                    ])
                </form>

                <div class="form-group row">
					<label for="fname" class="col-md-3 control-label">Nama tujuh orang anggota (tidak semestinya pegawai) <span style="color:red;">*</span></label>
					<div class="col-md-9">
						<table class="table table-hover " id="table">
                            <thead>
                                <tr>
                                    <th class="fit">Bil.</th>
                                    <th>Nama</th>
                                    <th class="fit">Tindakan</th>
                                </tr>
                            </thead>
                        </table>
                        <div class="card-title p-t-10">
                            <button onclick="add()" class="btn btn-primary btn-cons" type="button"><i class="fa fa-plus m-r-5"></i> Tambah Anggota</button>
                        </div>
					</div>
				</div>
                <br>
                <div class="form-group">
                    <button onclick="location.href='{{ route('federation.form', request()->id) }}'" type="button" class="btn btn-default mr-1" ><i class="fa fa-angle-left mr-1"></i> Kembali</button>
                    <button type="button" class="btn btn-info pull-right" onclick="save()"><i class="fa fa-check mr-1"></i> Simpan</button>
                </div>

            </div>
        </div>
    </div>
    <!-- END card -->
</div>
@endsection
@push('modal')
<div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog">
        <div class="modal-content-wrapper">
            <div class="modal-content">
                <div class="modal-header clearfix text-left">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                    </button>
                    <h5>Maklumat <span class="bold">Pegawai</span></h5>
                    <p class="p-b-10">Maklumat pegawai yang membuat permohonan.</p>
                </div>
                <div class="modal-body">
                    <form id="form-add" role="form" method="post" action="{{ route('formq.member', request()->id ) }}">
                        <div class="row">
                            <div class="col-md-12">
                                @include('components.input', [
                                    'name' => 'name',
                                    'label' => 'Nama',
                                    'mode' => 'required',
                                ])
                            </div>
                        </div>
                    </form>
                </div>  
                <div class="modal-footer">
                    <button type="button" class="btn btn-info m-t-5 pull-right submit" onclick="submitForm('form-add')"><i class="fa fa-check m-r-5"></i> Hantar</button>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>
@endpush
@push('js')
<script type="text/javascript">

$("#form-formq").validate();

function save() {
    swal({
        title: "Berjaya!",
        text: "Data yang telah disimpan.",
        icon: "success",
        button: "OK",
    })
    .then((confirm) => {
        if (confirm) {
            location.href="{{ route('federation.form', request()->id) }}";
        }
    });
}

var table = $('#table');

var settings = {
    "processing": true,
    "serverSide": true,
    "deferRender": true,
    "ajax": "{{ route('formq.member', request()->id ) }}",
    "columns": [
        { data: 'index', defaultContent: '', orderable: false, searchable: false, render: function (data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
        }},
        { data: "name", name: "name"},
        { data: "action", name: "action", orderable: false, searchable: false},
    ],
    "columnDefs": [
        { className: "nowrap", "targets": [ 2 ] }
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

function edit(id) {
    $("#modal-div").load("{{ route('formq.member', request()->id) }}/"+id);
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
                url: '{{ route('formq.member', request()->id) }}/'+id,
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

$(document).ready(function() {
    var socket = io('{{ env('SOCKET_HOST', '127.0.0.1') }}:{{ env('SOCKET_PORT', 3000) }}');
    socket.on('connect', function() {
        $(".msg-disconnected").slideUp();
        $(".msg-connecting").slideUp();
    });
    socket.on('disconnect', function() {
        $(".msg-disconnected").slideDown();
        $("html, body").animate({ scrollTop: 0 }, 500);
    });

    $('input, select, textarea').on('change', function() {
        socket.emit('formq', {
            id: {{ $formq->id }},
            name: $(this).attr('name'),
            value: $(this).attr('type') == 'checkbox' ? ($(this).prop('checked') ? 1 : 0) : $(this).val(),
            user: '{{ Cookie::get('api_token') }}'
        });
        console.log('changed');
    });

    $("#meeting_type_{{ $formq->meeting_type_id }}").prop('checked', true).trigger('change');

    @if($formq->user_federation_id)
    $("#user_federation_id").val( {{ $formq->user_federation_id }} ).trigger('change');
    @endif
});

</script>
@endpush
