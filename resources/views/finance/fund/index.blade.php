@extends('layouts.app')

@section('content')
<!-- START JUMBOTRON -->
<div class="jumbotron" data-pages="parallax">
	<div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
		<div class="inner">
			<!-- START BREADCRUMB -->
			{{ Breadcrumbs::render('fund') }}
			<div class="row">
				<div class="col-xl-12 col-lg-12 ">
					<!-- START card -->
					<div class="card card-transparent">
						<div class="card-block p-t-0">
							<h3 class='m-t-0'>Kutipan<span class="semi-bold"> Dana dan Wang Kesatuan Sekerja</span></h3>
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

	<div class="row">
		<div class="col-lg-12">
            @component('components.block', [
                    'percentage' => (11 - $errors_fund)/11*100,
                    'title' => 'Borang ID 1',
                    'description' => '- Borang Iklan Derma',
                ])
                <div class="btn-group-custom">
                    <a href="{{ route('fund.id1', $fund->id) }}" class="btn btn-primary pull-right btn-input"><i class="fa fa-edit mr-1"></i> Isi Borang</a>
                    @if(!$errors_fund)
                    <a href="{{ route('download.fund', $fund->id) }}" target="_blank" class="btn btn-default mr-2 pull-right btn-lock"><i class="fa fa-print mr-1"></i> Cetak</a>
                    <a href="javascript:;" class="btn btn-master mr-2 pull-right btn-unlock"><i class="fa fa-lock"></i></a>
                    @endif
                </div>
            @endcomponent
        </div>
		<div class="col-lg-12">
            @component('components.block', [
                    'title' => 'Senarai Semak (Borang ID 2)',
                    'disabled' => true
                ])
                <div class="btn-group-custom">
                    <a href="{{ url('files/checklist/fund.pdf') }}" target="_blank" class="btn btn-default mr-2 pull-right"><i class="fa fa-print mr-1"></i> Cetak</a>
                </div>
                <hr>
                <ul>
                    <li><label>Permohonan bagi Kutipan Dana dan Wang Kesatuan Sekerja</label></li>
                    <li><label>Borang Kutipan Dana</label></li>
                    <li><label>Minit Mesyuarat Agung/ Persidangan Perwakilan  yang mengandungi Usul Kutipan Derma </label></li>
                    <li><label>Minit Mesyuarat Jwatankuasa Kerja / Agung - *Usul Pembaharuan Kesatuan</label></li>
                    <li><label>Minit Mesyuarat Jawatankuasa Kerja meluluskan perlantikan wakil yang membuat kutipan</label></li>
                    <li><label>Anggaran Perbelanjaan Aktiviti</label></li>
                    <li><label>Surat Kebenaran Ketua Jabatan / Kementerian Berkenaan (Sektor Kerajaan) mengenai permohonan kutipan dana dan wang</label></li>
                    <li><label>Surat Kebenaran Permit Penerbitan di Bawah Akta Mesin Cetak dan Penerbitan (AMCP) 1984. (Pindaan 2012), jika melibatkan penerbitan</label></li>
                    <li><label>Salinan Perjanjian di antara Kesatuan dengan pihak ketiga untuk membuat kutipan</label></li>
                    <li><label>Kebenaran Permit Polis (Jika ada door to door collection melibatkan orang ramai)</label></li>
                    <li><label>Salinan No Kad Pengenalan (Untuk pengutip individu luar) / Salinan Sijil Pendaftaran Syarikat (SSM) (Untuk pengutip agensi/syarikat luar)</label></li>
                    <li><label>Salinan Terma Kutipan Dana Antara Kesatuan dan Ahli (Jika ada)</label></li>
                    <li><label>Salinan Penyata Bank Terkini</label></li>
                </ul>
            @endcomponent
        </div>
        @if($fund->created_by_user_id == auth()->id())
		<div class="col-lg-12 mb-3">
			<button class="btn btn-info pull-right btn-send-custom" onclick="submit()"><i class="fa fa-check mr-1"></i> Hantar</button>
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
        window.history.pushState('fund', 'Kutipan Dana', '{{ fullUrl() }}/{{ $fund->id }}');
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
                    url: '{{ route("fund.form", $fund->id) }}',
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
                                    location.href="{{ route('fund.list') }}";
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
