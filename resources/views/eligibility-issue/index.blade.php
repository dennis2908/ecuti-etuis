@extends('layouts.app')

@section('content')

<!-- START JUMBOTRON -->
<div class="jumbotron" data-pages="parallax">
    <div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
        <div class="inner">
            <!-- START BREADCRUMB -->
            {{ Breadcrumbs::render('eligibility-issue') }}
            <!-- END BREADCRUMB -->
            <div class="row">
                <div class="col-xl-12 col-lg-12 ">
                    <!-- START card -->
                    <div class="card card-transparent">
                        <div class="card-block p-t-0">
                            <h3 class='m-t-0'>Siasatan Isu Kelayakan <span class="semi-bold">Tuntutan Pengiktirafan </span></h3>
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
                    'percentage' => (8 - count($error_list['forma']))/8*100,
                    'title' => 'Borang A',
                    'description' => '- Notis Tuntutan Pengiktirafan APP 1967', 
                ])
                <div class="btn-group-custom">
                    <a href="{{ route('eligibility-issue.forma', $eligibility->id) }}" class="btn btn-primary pull-right btn-input"><i class="fa fa-edit mr-1"></i> Isi Borang</a>
                </div>
            @endcomponent
        </div>
        @if($eligibility->entity_type && $eligibility->entity_id && $eligibility->forma->company_name)
        <div class="col-lg-12">
            @component('components.block', [
                    'percentage' => (1 - count($error_list['memo']))/1*100,
                    'title' => 'Memo Siasatan',
                    'description' => '', 
                ])
                <div class="btn-group-custom">
                    <a href="{{ route('letter.item', $eligibility->letters()->where('letter_type_id', 64)->first()->id) }}" class="btn btn-primary pull-right btn-input"><i class="fa fa-edit mr-1"></i> Isi Borang</a>
                    @if(count($error_list['memo']) == 0)
                    <a href="{{ route('general.getAttachment', [$eligibility->letters()->where('letter_type_id', 64)->first()->attachment->id, $eligibility->letters()->where('letter_type_id', 64)->first()->attachment->name] ) }}" target="_blank" class="btn btn-default mr-2 pull-right btn-lock"><i class="fa fa-print mr-1"></i> Cetak Memo</a>
                    <a href="javascript:;" class="btn btn-master mr-2 pull-right btn-unlock"><i class="fa fa-lock"></i></a>
                    @endif
                </div>
            @endcomponent
        </div>
        @endif
        @if($eligibility->created_by_user_id == auth()->id())
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


    @if(!request()->id)
        window.history.pushState('eligibility_issues', 'Isu Kelayakan', '{{ fullUrl() }}/{{ $eligibility->id }}');
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
                    url: '{{ route("eligibility-issue.form", $eligibility->id) }}',
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
                                    location.href="{{ route('eligibility-issue.list') }}";
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
 