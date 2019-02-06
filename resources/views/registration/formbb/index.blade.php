@extends('layouts.app')

@section('content')
<!-- START JUMBOTRON -->
<div class="jumbotron" data-pages="parallax">
    <div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
        <div class="inner">
            <!-- START BREADCRUMB -->
            {{ Breadcrumbs::render('registration.formbb') }}
            <!-- END BREADCRUMB -->
            <div class="row">
                <div class="col-xl-12 col-lg-12 ">
                    <!-- START card -->
                    <div class="card card-transparent">
                        <div class="card-block p-t-0">
                            <h3 class='m-t-0'>Pendaftaran <span class="semi-bold">Persekutuan Kesatuan Sekerja</span></h3>
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
                    'percentage' => (9 - $errors_bb2)/9*100,
                    'title' => 'Borang BB2',
                    'description' => '- Permohonan Pendaftaran Persekutuan Kesatuan Sekerja',
                ])
                <div class="btn-group-custom">
                    <a href="{{ route('formbb.bb2', ['id' => $formbb->id]) }}" class="btn btn-primary pull-right btn-input"><i class="fa fa-edit mr-1"></i> Isi Borang</a>
                    @if(!$errors_bb2)
                    <a  href="{{ route('download.formbb' , ['id' => $formbb->id]) }}" target="_blank" class="btn btn-default mr-2 pull-right btn-lock"><i class="fa fa-print mr-1"></i> Cetak</a>
                    <a href="javascript:;" class="btn btn-master mr-2 pull-right btn-unlock"><i class="fa fa-lock"></i></a>
                    @endif
                </div>
            @endcomponent
        </div>

        @if($formbb)
        <div class="col-lg-12">
            @component('components.block', [
                    'percentage' => (7 - $errors_bb3)/7*100,
                    'title' => 'Borang BB3',
                    'description' => '- Perlembagaan Persekutuan',
                ])
                <div class="btn-group-custom">
                    <a href="{{ route('formbb.bb3', ['id' => $formbb->id]) }}" class="btn btn-primary pull-right btn-input"><i class="fa fa-edit mr-1"></i> Isi Borang</a>
                    @if(!$errors_bb3)
                    <a  href="{{ route('download.formbb3' , ['id' => $formbb->id]) }}" target="_blank" class="btn btn-default mr-2 pull-right btn-lock"><i class="fa fa-print mr-1"></i> Cetak</a>
                    <a href="javascript:;" class="btn btn-master mr-2 pull-right btn-unlock"><i class="fa fa-lock"></i></a>
                    @endif
                </div>
            @endcomponent
        </div>
        @endif

        <div class="col-lg-12">
            @component('components.block', [
                    'title' => 'Borang Praecipe',
                    'disabled' => true
                ])
                <div class="btn-group-custom">
                    <a href="{{ route('formbb.praecipe') }}" target="_blank" class="btn btn-default mr-2 pull-right"><i class="fa fa-print mr-1"></i> Cetak</a>
                </div>
            @endcomponent
        </div>

        <div class="col-lg-12">
            @component('components.block', [
                    'title' => 'Senarai Semak',
                    'disabled' => true
                ])
                <div class="btn-group-custom">
                    <a href="{{ url('files/checklist/formbb.pdf') }}" target="_blank" class="btn btn-default mr-2 pull-right"><i class="fa fa-print mr-1"></i> Cetak</a>
                </div>
                <hr>
                <ul>
                    <li><label>Borang BB (3 salinan asal)</label></li>
                    <li><label>Buku Perlembagaan Persekutuan (4 salinan asal)</label></li>
                    <li><label>Minit mesyuarat penubuhan</label></li>
                    <li><label>Salinan Kad Pengenalan pemohon</label></li>
                    <li><label>Surat kebenaran guna alamat majikan (jika berkenaan)</label></li>
                    <li><label>Bukti penggajian pemohon &amp; pegawai penaja</label></li>
                    <li><label>Borang Praecipe</label></li>
                </ul>
            @endcomponent
        </div>
        @if($formbb->created_by_user_id == auth()->id())
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
                    url: '{{ route("formbb.submit", ["id" => $formbb->id]) }}',
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
