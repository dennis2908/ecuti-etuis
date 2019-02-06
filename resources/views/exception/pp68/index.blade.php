@extends('layouts.app')

@section('content')
<!-- START JUMBOTRON -->
<div class="jumbotron" data-pages="parallax">
    <div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
        <div class="inner">
            <!-- START BREADCRUMB -->
            {{ Breadcrumbs::render('pp68') }}
            <!-- END BREADCRUMB -->
            <div class="row">
                <div class="col-xl-12 col-lg-12 ">
                    <!-- START card -->
                    <div class="card card-transparent">
                        <div class="card-block p-t-0">
                            <h3 class='m-t-0'>Pengecualian <span class="semi-bold"> Peraturan 68, Peraturan-Peraturan Kesatuan Sekerja 1959</span></h3>
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
                    'percentage' => (2 - $errors_exception)/2*100,
                    'title' => 'Permohonan Pengecualian Peraturan 68, Peraturan-Peraturan Kesatuan Sekerja 1959',
                ])
                <div class="btn-group-custom">
                    <a href="{{ route('pp68.form', $exception->id) }}" class="btn btn-primary pull-right btn-input"><i class="fa fa-edit mr-1"></i> Isi Borang</a>
                    @if(!$errors_exception)
                    <a href="{{ route('download.exception_pp68', $exception->id) }}" target="_blank" class="btn btn-default mr-2 pull-right btn-lock"><i class="fa fa-print mr-1"></i> Cetak</a>
                    <a href="javascript:;" class="btn btn-master mr-2 pull-right btn-unlock"><i class="fa fa-lock"></i></a>
                    @endif
                </div>
            @endcomponent
        </div>

        <div class="col-lg-12">
            @component('components.block', [
                    'title' => 'Senarai Semak + Dokumen Sokongan',
                    'disabled' => true
                ])
                <div class="btn-group-custom">
                    <a href="{{ url('files/checklist/pp68.pdf') }}" target="_blank" class="btn btn-default mr-2 pull-right"><i class="fa fa-print mr-1"></i> Cetak</a>
                </div>
                <hr>
                <ul>
                    <li><label>Salinan Penyata Gaji Terkini 3 Orang Ahli</label></li>
                    <li><label>Salinan Senarai Potongan Gaji</label></li>
                    <li><label>Salinan 'Hard Copy' Buku Tunai Mengikut Format AP.1 Yang Terkini Dan Dikemaskini</label></li>
                    <li><label>Salinan 'Hard Copy' Sistem Perakaunan Yang Terkini</label></li>
                </ul>
            @endcomponent
        </div>
        @if($exception->created_by_user_id == auth()->id())
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
        window.history.pushState('pp68', 'Pengecualian Peraturan 68', '{{ fullUrl() }}/{{ $exception->id }}');
    @endif

    function submit() {

        if(printed != 1) {
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
                    url: '{{ route("pp68.item", $exception->id) }}',
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
                                    location.href="{{ route('pp68.list') }}";
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
