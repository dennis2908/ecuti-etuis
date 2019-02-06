@extends('layouts.app')
@include('plugins.dropzone')

@section('content')
<!-- START BREADCRUMB -->
<div class="jumbotron" data-pages="parallax">
	<div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
		<div class="inner" style="transform: translateY(0px); opacity: 1;">
			{{ Breadcrumbs::render('complaint') }}
			<!-- END BREADCRUMB -->
			<div class="row">
				<div class="col-xl-12 col-lg-12 ">
					<!-- START card -->
					<div class="card card-transparent">
						<div class="card-block p-t-0">
							<h3 class='m-t-0'>Pengendalian Aduan</h3>
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
<!-- END BREADCRUMB -->
<div class="main container-fluid container-fixed-lg">
    <div class="row justify-content-center">

        <div class="col-lg-12">
            @component('components.block', [
                    'percentage' => (9 - $errors_complaint)/9*100,
                    'title' => 'Pendaftaran Aduan',
                    'description' => '',
                ])
                <div class="btn-group-custom">
                    <a href="{{ route('investigation.complaint.item.form', $complaint->id) }}" class="btn btn-primary pull-right btn-input"><i class="fa fa-edit mr-1"></i> Isi Borang</a>
                    @if(!$errors_complaint)
                    <a href="{{ route('download.complaint', $complaint->id) }}" target="_blank" class="btn btn-default mr-2 pull-right btn-lock"><i class="fa fa-print mr-1"></i> Cetak</a>
                    <a href="javascript:;" class="btn btn-master mr-2 pull-right btn-unlock"><i class="fa fa-lock"></i></a>
                    @endif
                </div>
            @endcomponent
        </div>

        <div class="col-lg-12">
			<div class="card card-transparent mb-0">
				<div class="card-block no-padding">
					<div id="card-circular-minimal" class="card card-default">
						<div class="card-block">
							<h5>
								<i class='fa fa-info-circle text-default mr-2'></i>
								<span class="semi-bold">Muat Naik</span> - Dokumen-Dokumen Berkaitan
							</h5>
							<hr>
							<form action="/file-upload" class="dropzone no-margin">
								<div class="fallback">
									<input name="file" type="file" multiple/>
								</div>
							</form>
						</div>
						<div class="progress ">
							<div class="progress-bar progress-bar-default" style="width:100%"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
        @if($complaint->created_by_user_id == auth()->id())
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
        window.history.pushState('complaint', 'Pengendalian Aduan', '{{ fullUrl() }}/{{ $complaint->id }}');
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
                    url: '{{ route("investigation.complaint.item", $complaint->id) }}',
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
                                    location.href="{{ route('investigation.complaint.list') }}";
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
