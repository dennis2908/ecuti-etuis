@extends('layouts.app')
@include('plugins.dropzone')

@section('content')
@include('components.msg-disconnected')
<!-- START JUMBOTRON -->
<div class="jumbotron" data-pages="parallax">
    <div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
        <div class="inner">
            <!-- START BREADCRUMB -->
            {{ Breadcrumbs::render('prosecution') }}
            <!-- END BREADCRUMB -->
            <div class="row">
                <div class="col-xl-12 col-lg-12 ">
                    <!-- START card -->
                    <div class="card card-transparent">
                        <div class="card-block p-t-0">
                            <h3 class='m-t-0'>Pendaftaran Kertas Siasatan <span class="semi-bold">(Pendakwaan)</span></h3>
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

<div class="main container-fluid container-fixed-lg">
    <div class="row justify-content-center">

        <div class="col-lg-12">
            @component('components.block', [
                    'percentage' => '100',
                    'title' => 'Memo',
                    'description' => '- Arahan Menjalankan Siasatan',
                ])
                <div class="btn-group-custom">
                    <a href="{{ route('download.pdw01', $prosecution->id) }}" target="_blank" class="btn btn-default mr-2 pull-right"><i class="fa fa-print mr-1"></i> Cetak</a>
                    <!-- <a href="javascript:;" class="btn btn-master mr-2 pull-right btn-unlock"><i class="fa fa-lock"></i></a> -->
                </div>
                <hr>
                <div class="col-md-12">
                    <form action="{{ route('prosecution.pdw01.form.attachment', $prosecution->id) }}" enctype="multipart/form-data" class="attachment dropzone no-margin">
                        <div class="fallback">
                            <input name="file" type="file" multiple/>
                        </div>
                    </form>
                </div>

            @endcomponent
        </div>

        @if( $prosecution->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pw'); })->where('assigned_to_user_id', auth()->id())->first() || !count($error_list['pdw02']) )
        <div class="col-lg-12">
            @component('components.block', [
                    'percentage' => (2 - count($error_list['pdw02']))/2*100,
                    'title' => 'Pengesahan Penerimaan - Perlantikan IO',
                    'description' => '- Pegawai Penyiasat (IO)',
                ])
                <div class="btn-group-custom">
                    @if( $prosecution->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'pw'); })->where('assigned_to_user_id', auth()->id())->first() )
                    <a href="{{ route('prosecution.pdw02.form', $prosecution->id) }}" class="btn btn-primary pull-right btn-input"><i class="fa fa-edit mr-1"></i> Isi Borang</a>
                    @endif
                    @if(!count($error_list['pdw02']))
                    <a href="{{ route('download.pdw02', $prosecution->id) }}" target="_blank" class="btn btn-default mr-2 pull-right"><i class="fa fa-print mr-1"></i> Cetak</a>
                    <!-- <a href="javascript:;" class="btn btn-master mr-2 pull-right btn-unlock"><i class="fa fa-lock"></i></a> -->
                    @endif
                </div>
            @endcomponent
        </div>
        @endif

        <div class="col-lg-12">
            @component('components.block', [
                    'title' => ' Senarai Semak + Dokumen Sokongan',
                    'disabled' => true
                ])
                <div class="btn-group-custom">
                    <a href="{{ url('#') }}" target="_blank" class="btn btn-default mr-2 pull-right"><i class="fa fa-print mr-1"></i> Cetak</a>
                </div>
                <hr>
                <ul>
                    <li><a href="{{ url('files/investigation/pdw/3.pdf') }}" class="btn btn-default btn-xs"><i class="fa fa-download m-r-5"></i> Saman Hadir (Borang V)</a></li>
                    <li><a href="{{ url('files/investigation/pdw/4.pdf') }}" class="btn btn-default btn-xs"><i class="fa fa-download m-r-5"></i> Waran Geledah</a></li>
                    <li><a href="{{ url('files/investigation/pdw/5.pdf') }}" class="btn btn-default btn-xs"><i class="fa fa-download m-r-5"></i> Borang Kehadiran</a></li>
                    <li><a href="{{ url('files/investigation/pdw/6.pdf') }}" class="btn btn-default btn-xs"><i class="fa fa-download m-r-5"></i> Rakaman Percakapan</a></li>
                    <li><a href="{{ url('files/investigation/pdw/7.pdf') }}" class="btn btn-default btn-xs"><i class="fa fa-download m-r-5"></i> Catatan Diari Siasatan</a></li>
                    <li><a href="{{ url('files/investigation/pdw/8.pdf') }}" class="btn btn-default btn-xs"><i class="fa fa-download m-r-5"></i> Borang Ambil Milik</a></li>
                    <li><a href="{{ url('files/investigation/pdw/9.pdf') }}" class="btn btn-default btn-xs"><i class="fa fa-download m-r-5"></i> Penyempurnaan Geledahan</a></li>
                    <li><a href="{{ url('files/investigation/pdw/10.pdf') }}" class="btn btn-default btn-xs"><i class="fa fa-download m-r-5"></i> Rigkasan Kes</a></li>
                    <li><a href="{{ url('files/investigation/pdw/11.pdf') }}" class="btn btn-default btn-xs"><i class="fa fa-download m-r-5"></i> Folio-folio</a></li>
                </ul>
            @endcomponent
        </div>

        @if(($prosecution->pdw02 ? $prosecution->pdw02->io_user_id == auth()->id() : false) || !count($error_list['pdw13']) )
        <div class="col-lg-12">
            @component('components.block', [
                    'percentage' => (3 - count($error_list['pdw13']))/3*100,
                    'title' => 'Fakta Kes',
                    'description' => '- Pegawai Penyiasat (IO)',
                ])
                <div class="btn-group-custom">
                    @if($prosecution->pdw02 ? $prosecution->pdw02->io_user_id == auth()->id() : false )
                    <a href="{{ route('prosecution.pdw13.form', $prosecution->id) }}" class="btn btn-primary pull-right btn-input"><i class="fa fa-edit mr-1"></i> Isi Borang</a>
                    @endif
                    @if(!count($error_list['pdw13']))
                    <a href="{{ route('download.pdw13', $prosecution->id) }}" target="_blank" class="btn btn-default mr-2 pull-right"><i class="fa fa-print mr-1"></i> Cetak</a>
                    <!-- <a href="javascript:;" class="btn btn-master mr-2 pull-right btn-unlock"><i class="fa fa-lock"></i></a> -->
                    @endif
                </div>
            @endcomponent
        </div>
        @endif

        @if(($prosecution->pdw02 ? $prosecution->pdw02->io_user_id == auth()->id() : false) || $prosecution->subpoena_approved_at )
        <div class="col-lg-12">
            @component('components.block', [
                    'title' => 'Tarikh Kelulusan Sapina Oleh Majistret',
                    'disabled' => true
                ])
                <hr>
                @if($prosecution->pdw02 ? $prosecution->pdw02->io_user_id == auth()->id() : false)
                <form>
                    <div id="datepicker-component" class="input-group date p-l-0" required>
                        <input type="text" class="form-control" name="subpoena_approved_at" value="{{ $prosecution->subpoena_approved_at ? date('d/m/Y', strtotime($prosecution->subpoena_approved_at)) : '' }}" required>
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    </div>
                </form>
                @else
                <p>{{ $prosecution->subpoena_approved_at ? date('d/m/Y', strtotime($prosecution->subpoena_approved_at)) : '' }}</p>
                @endif
            @endcomponent
        </div>
        @endif

        <div class="col-lg-12">
            @component('components.block', [
                    'percentage' => (2 - count($error_list['pdw14']))/2*100,
                    'title' => ' Surat Perlantikan',
                    'description' => '- Pegawai Pendakwa (PO)',
                ])
                <div class="btn-group-custom">
                    <a href="{{ route('prosecution.pdw14.form', $prosecution->id) }}" class="btn btn-primary pull-right btn-input"><i class="fa fa-edit mr-1"></i> Isi Borang</a>
                    @if(!count($error_list['pdw14']))
                    <a href="{{ route('download.pdw14', $prosecution->id) }}" target="_blank" class="btn btn-default mr-2 pull-right btn-lock"><i class="fa fa-print mr-1"></i> Cetak</a>
                    <a href="javascript:;" class="btn btn-master mr-2 pull-right btn-unlock"><i class="fa fa-lock"></i></a>
                    @endif
                </div>
            @endcomponent
        </div>

        {{--
        <div class="col-lg-12">
            @component('components.block', [
                    'title' => 'Maklumat Keputusan Mahkamah',
                    'disabled' => true
                ])
                <a href="#" class="btn btn-default mr-2 pull-right"><i class="fa fa-print mr-1"></i> Cetak</a>
                <hr>
                
            @endcomponent
        </div>
        --}}

        @if(($prosecution->pdw02 ? $prosecution->pdw02->io_user_id == auth()->id() : false) || $prosecution->io_notes)
        <div class="col-lg-12">
            @component('components.block', [
                    'title' => 'Catatan Pegawai Penyiasat (IO)',
                    'disabled' => true
                ])
                <hr>
                @if($prosecution->pdw02 ? $prosecution->pdw02->io_user_id == auth()->id() : false )
                <form>
                    <textarea name="io_notes" style="height: 150px;" placeholder="" class="form-control" required>{{ $prosecution->io_notes }}</textarea>
                </form>
                @else
                <p>{{ $prosecution->io_notes }}</p>
                @endif
            @endcomponent
        </div>
        @endif

        @if(($prosecution->pdw14 ? $prosecution->pdw14->po_user_id == auth()->id() : false) || $prosecution->po_notes)
        <div class="col-lg-12">
            @component('components.block', [
                    'title' => 'Catatan Pegawai Pendakwa (PO)',
                    'disabled' => true
                ])
                <hr>
                @if($prosecution->pdw14 ? $prosecution->pdw14->io_user_id == auth()->id() : false )
                <form>
                    <textarea name="po_notes" style="height: 150px;" placeholder="" class="form-control" required>{{ $prosecution->po_notes }}</textarea>
                </form>
                @else
                <p>{{ $prosecution->po_notes }}</p>
                @endif
            @endcomponent
        </div>
        @endif

        @if($prosecution->pdw02 ? $prosecution->pdw02->io_user_id == auth()->id() : false)
        <div class="col-lg-12 mb-3">
            <button class="btn btn-info pull-right btn-send" onclick="submit()"><i class="fa fa-check mr-1"></i> Hantar</button>
        </div>
        @endif
    </div>
</div>
@endsection
@push('js')
<script type="text/javascript">

printed = 0;

$('.btn-lock').on('click', function() {
    printed++;
});

$('.btn-unlock').on('click', function() {
    printed--;
});

@if(!request()->id)
    window.history.pushState('prosecution', 'Kertas Siasatan', '{{ fullUrl() }}/{{ $prosecution->id }}');
@endif

function submit() {

    // if(printed != 3) {
    //     swal('Harap Maaf!', 'Sila cetak dokumen-dokumen di atas terlebih dahulu.', 'error');
    //     return;
    // }

    swal({
        title: "Teruskan?",
        text: "Adakah anda pasti untuk menghantar permohonan ini?",
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
                url: '{{ route("prosecution.form", $prosecution->id) }}',
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
                                location.href="{{ route('prosecution.list') }}";
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
    url: "{{ route('prosecution.pdw01.form.attachment', $prosecution->id) }}",
    addRemoveLinks : true,
    dictRemoveFile: "Padam Fail",
    init: function () {
        var myDropzone = this;

        $.ajax({
            url: '{{ route('prosecution.pdw01.form.attachment', $prosecution->id) }}/',
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
                    url: '{{ route('prosecution.pdw01.form.attachment', $prosecution->id) }}/'+file.previewElement.id,
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

    $('input[type=text], select, textarea').on('change', function() {
        socket.emit('prosecution', {
            id: {{ $prosecution->id }},
            name: $(this).attr('name'),
            value: $(this).attr('type') == 'checkbox' ? ($(this).prop('checked') ? 1 : 0) : $(this).val(),
            user: '{{ Cookie::get('api_token') }}'
        });
        console.log('changed');
    });
});
</script>
@endpush
