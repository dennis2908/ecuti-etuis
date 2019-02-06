@extends('layouts.app')

@section('content')
<!-- START BREADCRUMB -->
<div class="jumbotron" data-pages="parallax">
    <div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
        <div class="inner" style="transform: translateY(0px); opacity: 1;">
            {{ Breadcrumbs::render('enforcement') }}
            <!-- END BREADCRUMB -->
            <div class="row">
                <div class="col-xl-12 col-lg-12 ">
                    <!-- START card -->
                    <div class="card card-transparent">
                        <div class="card-block p-t-0">
                            <h3 class='m-t-0'>Pemeriksaan Penguatkuasaan</h3>
                            <p class="small hint-text m-t-5">
                                Sila lengkapkan semua maklumat berikut mengikut turutan dan arahan yang dipaparkan.
                            </p>
                            <div class="row-fluid p-t-15">
                                <span class="label label-inverse"><i class="fa fa-user tab-icon"></i> {{ $enforcement->entity->name }}</span>
                                <span class="label label-inverse"><i class="fa fa-calendar tab-icon"></i> {{ date('d/m/Y', strtotime($enforcement->start_date)) }}</span>
                                <span class="label label-inverse"><i class="fa fa-map-marker tab-icon"></i> {{ $enforcement->district->name.', '.$enforcement->state->name }}</span>
                                <br>
                            </div>
                        </div>
                    </div>
                    <!-- END card -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END BREADCRUMB -->

<!-- START CONTAINER FLUID -->
<div class="main container-fluid container-fixed-lg">
    <div class="row justify-content-center">

        <div class="col-lg-12">
            @component('components.block', [
                    'percentage' => (12 - count($error_list['enforcement']))/12*100,
                    'title' => 'Borang PBP2',
                    'description' => ' - Laporan Pemeriksaan Penguatkuasaan',
                ])
                <div class="btn-group-custom">
                    <a href="{{ route('pbp2', $enforcement->id) }}" class="btn btn-primary pull-right btn-input"><i class="fa fa-edit mr-1"></i> Isi Borang</a>
                    <a href="{{ route('download.pbp2', $enforcement->id) }}" target="_blank" class="btn btn-default mr-2 pull-right btn-lock"><i class="fa fa-print mr-1"></i> Cetak</a>
                    <a href="javascript:;" class="btn btn-master mr-2 pull-right btn-unlock"><i class="fa fa-lock"></i></a>
                </div>
            @endcomponent
        </div>
        @if(!count($error_list['enforcement']))
        <div class="col-lg-12">
            @component('components.block', [
                    'title' => 'Lampiran Laporan',
                    'disabled' => true
                ])
                <hr>
                @if($enforcement->a1->count() != 0)
                <a href="{{ route('download.pbp2.a1', $enforcement->id) }}" target="_blank" class="btn btn-default mr-2 mb-1 btn-lock"><i class="fa fa-print mr-1"></i> Cetak Lampiran A1</a><br>
                @endif
                @if($enforcement->a2->count() != 0)
                <a href="{{ route('download.pbp2.a2', $enforcement->id) }}" target="_blank" class="btn btn-default mr-2 mb-1 btn-lock"><i class="fa fa-print mr-1"></i> Cetak Lampiran A2</a><br>
                @endif
                @if($enforcement->a3->count() != 0)
                <a href="{{ route('download.pbp2.a3', $enforcement->id) }}" target="_blank" class="btn btn-default mr-2 mb-1 btn-lock"><i class="fa fa-print mr-1"></i> Cetak Lampiran A3</a><br>
                @endif
                @if($enforcement->a4->count() != 0)
                <a href="{{ route('download.pbp2.a4', $enforcement->id) }}" target="_blank" class="btn btn-default mr-2 mb-1 btn-lock"><i class="fa fa-print mr-1"></i> Cetak Lampiran A4</a><br>
                @endif
                @if($enforcement->a5->count() != 0)
                    @foreach($enforcement->a5 as $a5)
                    <a href="{{ route('download.pbp2.a5', [$enforcement->id, $a5->branch_id]) }}" target="_blank" class="btn btn-default mr-2 mb-1 btn-lock"><i class="fa fa-print mr-1"></i> Cetak Lampiran A5 [ {{ $a5->branch->name }} ]</a><br>
                    @endforeach
                @endif
                @if($enforcement->a6->count() != 0)
                <a href="{{ route('download.pbp2.a6', $enforcement->id) }}" target="_blank" class="btn btn-default mr-2 mb-1 btn-lock"><i class="fa fa-print mr-1"></i> Cetak Lampiran A6</a><br>
                @endif
                @if($enforcement->b1->count() != 0)
                <a href="{{ route('download.pbp2.b1', $enforcement->id) }}" target="_blank" class="btn btn-default mr-2 mb-1 btn-lock"><i class="fa fa-print mr-1"></i> Cetak Lampiran B1</a><br>
                @endif
                @if($enforcement->c1)
                <a href="{{ route('download.pbp2.c1', $enforcement->id) }}" target="_blank" class="btn btn-default mr-2 mb-1 btn-lock"><i class="fa fa-print mr-1"></i> Cetak Lampiran C1</a><br>
                @endif
                @if($enforcement->d1->count() != 0)
                <a href="{{ route('download.pbp2.d1', $enforcement->id) }}" target="_blank" class="btn btn-default mr-2 mb-1 btn-lock"><i class="fa fa-print mr-1"></i> Cetak Lampiran D1</a><br>
                @endif
            @endcomponent
        </div>
        @endif
        @if($enforcement->created_by_user_id == auth()->id())
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
    window.history.pushState('enforcement', 'Pemeriksaan Berkanun', '{{ fullUrl() }}/{{ $enforcement->id }}');
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
                url: '{{ route("enforcement.form", $enforcement->id) }}',
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
                                location.href="{{ route('enforcement') }}";
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