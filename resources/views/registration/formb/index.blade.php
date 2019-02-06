@extends('layouts.app')

@section('content')
<!-- START JUMBOTRON -->
<div class="jumbotron" data-pages="parallax">
    <div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
        <div class="inner">
            <!-- START BREADCRUMB -->
            {{ Breadcrumbs::render('registration.formb') }}
            <!-- END BREADCRUMB -->
            <div class="row">
                <div class="col-xl-12 col-lg-12 ">
                    <!-- START card -->
                    <div class="card card-transparent">
                        <div class="card-block p-t-0">
                            <h3 class='m-t-0'>Pendaftaran <span class="semi-bold">Kesatuan Sekerja</span></h3>
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

<div class="main container-fluid container-fixed-lg">
    <div class="row justify-content-center">

        <div class="col-lg-12">
            @component('components.block', [
                    'percentage' => (12 - $errors_b2)/12*100,
                    'title' => 'Borang B2',
                    'description' => '- Permohonan Pendaftaran Kesatuan Sekerja',
                ])
                <div class="btn-group-custom">
                    <a href="{{ route('formb.b2', ['id' => $formb->id]) }}" class="btn btn-primary pull-right btn-input"><i class="fa fa-edit mr-1"></i> Isi Borang</a>
                    @if(!$errors_b2)
                    <a href="{{ route('download.formb' , ['id' => $formb->id]) }}" target="_blank" class="btn btn-default mr-2 pull-right btn-lock"><i class="fa fa-print mr-1"></i> Cetak</a>
                    <a href="javascript:;" class="btn btn-master mr-2 pull-right btn-unlock"><i class="fa fa-lock"></i></a>
                    @endif
                </div>
            @endcomponent
        </div>

        @if($formb)
            @if($formb->has_branch == '0')
            <div class="col-lg-12">
                @component('components.block', [
                        'percentage' => (10 - $errors_b3)/10*100,
                        'title' => 'Borang B3',
                        'description' => '- Perlembagaan Tanpa Cawangan',
                    ])
                    <div class="btn-group-custom">
                        <a href="{{ route('formb.b3', ['id' => $formb->id]) }}" class="btn btn-primary pull-right btn-input"><i class="fa fa-edit mr-1"></i> Isi Borang</a>
                        @if(!$errors_b3)
                        <a href="{{ route('download.formb3' , ['id' => $formb->id]) }}" target="_blank" class="btn btn-default mr-2 pull-right btn-lock"><i class="fa fa-print mr-1"></i> Cetak</a>
                        <a href="javascript:;" class="btn btn-master mr-2 pull-right btn-unlock"><i class="fa fa-lock"></i></a>
                        @endif
                    </div>
                @endcomponent
            </div>
            @elseif($formb->has_branch == '1')
            <div class="col-lg-12">
                @component('components.block', [
                        'percentage' => (21 - $errors_b4)/21*100,
                        'title' => 'Borang B4',
                        'description' => '- Perlembagaan Bercawangan',
                    ])
                    <div class="btn-group-custom">
                        <a href="{{ route('formb.b4', ['id' => $formb->id]) }}" class="btn btn-primary pull-right btn-input"><i class="fa fa-edit mr-1"></i> Isi Borang</a>
                        @if(!$errors_b4)
                        <a href="{{ route('download.formb4' , ['id' => $formb->id]) }}" target="_blank" class="btn btn-default mr-2 pull-right btn-lock"><i class="fa fa-print mr-1"></i> Cetak</a>
                        <a href="javascript:;" class="btn btn-master mr-2 pull-right btn-unlock"><i class="fa fa-lock"></i></a>
                        @endif
                    </div>
                @endcomponent
            </div>
            @endif
        @endif

        <div class="col-lg-12">
            @component('components.block', [
                    'title' => 'Borang Praecipe',
                    'disabled' => true
                ])
                <div class="btn-group-custom">
                    <a href="{{ route('formb.praecipe') }}" target="_blank" class="btn btn-default mr-2 pull-right"><i class="fa fa-print mr-1"></i> Cetak</a>
                </div>
            @endcomponent
        </div>

        <div class="col-lg-12">
            @component('components.block', [
                    'title' => 'Senarai Semak',
                    'disabled' => true
                ])
                <div class="btn-group-custom">
                    <a href="{{ url('files/checklist/formb.pdf') }}" target="_blank" class="btn btn-default mr-2 pull-right"><i class="fa fa-print mr-1"></i> Cetak</a>
                </div>
                <hr>
                <ul>
                    <li><label>Borang B (3 salinan asal)</label></li>
                    <li><label>Buku Perlembagaan Tanpa Cawangan / Buku Perlembagaan Bercawangan (4 salinan asal)</label></li>
                    <li><label>Minit mesyuarat penubuhan</label></li>
                    <li><label>SSM</label></li>
                    <li><label>Salinan Kad Pengenalan pemohon</label></li>
                    <li><label>Surat kebenaran guna alamat majikan (jika berkenaan)</label></li>
                    <li><label>Bukti penggajian pemohon &amp; pegawai penaja</label></li>
                    <li><label>Surat pengesahan majikan / surat tawaran</label></li>
                    <li><label>Borang Praecipe</label></li>
                </ul>
            @endcomponent
        </div>
        @if($formb->created_by_user_id == auth()->id())
        <div class="col-lg-12 mb-3">
            <button onclick="submit()" class="btn btn-info pull-right btn-send"><i class="fa fa-check mr-1"></i> Hantar</button>
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

    function submit() {

        if(printed != 2) {
            swal('Harap Maaf!', 'Sila cetak dokumen-dokumen di atas terlebih dahulu.', 'error');
            return;
        }

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
                    url: '{{ route("formb.submit", ["id" => $formb->id]) }}',
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
                                    location.href="{{ route('home') }}";
                                }
                            });
                        }
                    }
                });
            }
        });
    }
</script>
@endpush
