@extends('layouts.app')
@include('plugins.dropzone')
@include('plugins.datatables')

@section('content')
@include('components.msg-disconnected')
<!-- START JUMBOTRON -->
<div class="jumbotron" data-pages="parallax">
    <div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
        <div class="inner">
            <!-- START BREADCRUMB -->
            {{ Breadcrumbs::render('affidavit') }}
            <!-- END BREADCRUMB -->
            <div class="row">
                <div class="col-xl-12 col-lg-12 ">
                    <!-- START card -->
                    <div class="card card-transparent">
                        <div class="card-block p-t-0">
                            <h3 class='m-t-0'>Surat Iringan</h3>
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

@include('components.msg-connecting')
<div class=" container-fluid container-fixed-lg bg-white">
    <!-- START card -->
    <div class="card card-transparent">
        <div class="card-block">
            <div>
                <form id="form-affidavit" class="form-horizontal" role="form" autocomplete="off" method="post" action="#">

                    <div class="form-group row">
                        <label for="fname" class="col-md-3 control-label">Alamat Peguam
                            <span style="color:red;">*</span>
                        </label>
                        <div class="col-md-9">
                            <select id="attorney_id" name="attorney_id" class="full-width autoscroll" data-init-plugin="select2" required>
                                <option value="-1" selected>Pilih Satu...</option>
                                @foreach($attorneys as $attorney)
                                <option value="{{ $attorney->id }}">{{ $attorney->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fname" class="col-md-3 control-label">Mahkamah Tinggi
                            <span style="color:red;">*</span>
                        </label>
                        <div class="col-md-9">
                            <select id="court_id" name="court_id" class="full-width autoscroll" data-init-plugin="select2" required>
                                <option value="-1" selected>Pilih Satu...</option>
                                @foreach($courts as $court)
                                <option value="{{ $court->id }}">{{ $court->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="participant" class="col-md-3 control-label">
                            Tuan/Puan
                            <span style="color:red;">*</span>
                        </label>
                        <div class="col-md-9">
                            <div class="radio radio-primary">
                                <input name="is_sir" value="1" id="is_sir_yes" type="radio" class="hidden">
                                <label for="is_sir_yes">Tuan</label>

                                <input name="is_sir" value="0" id="is_sir_no" type="radio" class="hidden">
                                <label for="is_sir_no">Puan</label>
                            </div>
                        </div>
                    </div>

                    @include('components.bs.input', [
                        'name' => 'up',
                        'label' => 'U.P ..........',
                        'mode' => 'required',
                        'value' => $affidavit->report->up,
                    ])

                    @include('components.bs.input', [
                        'name' => 'judicial_no',
                        'label' => 'No. Semakan Kehakiman',
                        'mode' => 'required',
                        'value' => $affidavit->report->judicial_no,
                    ])

                    @component('components.bs.label', [
                        'label' => 'Nama Pemohon',
                    ])
                    {{ $affidavit->applicant }}
                    @endcomponent

                    @component('components.bs.label', [
                        'label' => 'Nama Responden',
                    ])
                    <ol class="p-l-15">
                        @foreach($affidavit->respondents as $respondent)
                            <li>{{ $respondent->respondent }}</li>
                        @endforeach
                    </ol>
                    @endcomponent

                    @include('affidavit.report.index')
                </form>

                <div class="form-group row">
                    <label for="fname" class="col-md-3 control-label">Muat Naik Dokumen
                    </label>
                    <div class="col-md-9">
                        <form action="{{ route('affidavit.form.report.attachment', $affidavit->report->id) }}" enctype="multipart/form-data" class="attachment dropzone no-margin">
                            <div class="fallback">
                                <input name="file" type="file" multiple/>
                            </div>
                        </form>
                    </div>
                </div>

                <br>
                <div class="form-group">
                    <button type="button" class="btn btn-default mr-1" onclick="location.href='{{ route('affidavit.list') }}'"><i class="fa fa-angle-left mr-1"></i> Kembali</button>
                    <button type="button" class="btn btn-info pull-right" onclick="submit()" data-dismiss="modal"><i class="fa fa-check mr-1"></i> Hantar</button>
                    <button type="button" class="btn btn-default pull-right mr-1" onclick="save()" data-dismiss="modal"><i class="fa fa-save mr-1"></i> Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <!-- END card -->
</div>
@endsection

@push('js')
<script>

$("#form-affidavit").validate();

function save() {
    swal({
        title: "Berjaya!",
        text: "Data yang telah disimpan.",
        icon: "success",
        button: "OK",
    })
    .then((confirm) => {
        if (confirm) {
            location.href="{{ route('affidavit.list') }}";
        }
    });
}

function submit() {
    swal({
        title: "Teruskan?",
        text: "Adakah anda pasti untuk menghantar laporan kes ini?",
        icon: "warning",
        buttons: {
            cancel: "Batal",
            confirm: {
                text: "Teruskan",
                value: "confirm",
                closeModal: false,
                className: "btn-info",
            },
        },
        dangerMode: true,
    })
    .then((confirm) => {
        if (confirm) {
            $.ajax({
                url: '{{ route("affidavit.form.report", $affidavit->id) }}',
                method: 'POST',
                dataType: 'json',
                async: true,
                contentType: false,
                processData: false,
                success: function(data) {
                    if(data.status == 'error') {
                        swal(data.title, data.message, data.status);
                        $("html, body").animate({ scrollTop: 0 }, "slow");
                    }
                    else {
                        swal({
                            title: data.title,
                            text: data.message,
                            icon: data.status,
                            button: "OK",
                        })
                        .then((confirm) => {
                            if (confirm) {
                                location.href="{{ route('affidavit.list') }}";
                            }
                        });
                    }
                }
            });
        }
    });
}

$(".attachment").dropzone({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: "{{ route('affidavit.form.report.attachment', $affidavit->report->id) }}",
    addRemoveLinks : true,
    dictRemoveFile: "Padam Fail",
    init: function () {
        var myDropzone = this;

        $.ajax({
            url: '{{ route('affidavit.form.report.attachment', $affidavit->report->id) }}/',
            method: 'get',
            dataType: 'json',
            async: true,
            contentType: false,
            processData: false,
            success: function(data) {
                $.each(data, function(key,value){
                    var mockFile = { name: value.name, size: value.size, id: value.id };
                    myDropzone.emit("addedfile", mockFile);
                    myDropzone.emit("thumbnail", mockFile);

                    $(mockFile.previewElement).prop('id', value.id);
                });
            }
        });

        myDropzone.on("addedfile", function (file) {
            if(file.id) {
                file._downloadLink = Dropzone.createElement("<a class=\"btn btn-default btn-xs\" id=\"bt-down\" style=\"margin-top:5px;\" href=\"{{ url('general/attachment') }}/"+file.id+"/"+file.name+"\" title=\"Muat Turun\" data-dz-download><i class=\"fa fa-download m-r-5\"></i> Muat Turun</a>");
                file.previewElement.appendChild(file._downloadLink);
            }
        });

        $(".dz-remove").addClass('btn', 'btn-danger', 'btn-xs');
        
    },
    success: function(file, response) {
        file.previewElement.id = response.id;
        file._downloadLink = Dropzone.createElement("<a class=\"btn btn-default btn-xs\" id=\"bt-down\" style=\"margin-top:5px;\" href=\"{{ url('general/attachment') }}/"+response.id+"/"+file.name+"\" title=\"Muat Turun\" data-dz-download><i class=\"fa fa-download m-r-5\"></i> Muat Turun</a>");
        file.previewElement.appendChild(file._downloadLink);
        return file.previewElement.classList.add("dz-success");
    },
    removedfile: function(file) {
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
                    url: '{{ route('affidavit.form.report.attachment', $affidavit->report->id) }}/'+file.previewElement.id,
                    method: 'delete',
                    dataType: 'json',
                    async: true,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        swal(data.title, data.message, data.status);
                        if(data.status == "success")
                            file.previewElement.remove();
                    }
                });
            }
        });
    },
});

$(document).ready(function(){

    var socket = io('{{ env('SOCKET_HOST', '127.0.0.1') }}:{{ env('SOCKET_PORT', 3000) }}');

    socket.on('connect', function() {
        $(".msg-disconnected").slideUp();
        $(".msg-connecting").slideUp();
    });

    socket.on('disconnect', function() {
        $(".msg-disconnected").slideDown();
        $("html, body").animate({ scrollTop: 0 }, 500);
    });

    $('#form-affidavit input, #form-affidavit select, #form-affidavit textarea').on('change', function() {
        socket.emit('affidavit_report', {
            id: {{ $affidavit->report->id }},
            name: $(this).attr('name'),
            value: $(this).attr('type') == 'checkbox' ? ($(this).prop('checked') ? 1 : 0) : $(this).val(),
            user: '{{ Cookie::get('api_token') }}'
        });
        console.log('changed');
    });

    @if($affidavit->report->attorney_id)
        $('#attorney_id').val( {{ $affidavit->report->attorney_id }} ).trigger('change');
    @endif

    @if($affidavit->report->court_id)
        $('#court_id').val( {{ $affidavit->report->court_id }} ).trigger('change');
    @endif

    @if($affidavit->report->is_sir)
        $("#is_sir_{{ $affidavit->report->is_sir == 1 ? 'yes' : 'no' }}").prop('checked', true).trigger('change');
    @endif
});

</script>
@endpush
