@extends('layouts.app')
@include('plugins.dropzone')

@section('content')
<!-- START JUMBOTRON -->
<div class="jumbotron" data-pages="parallax">
	<div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
		<div class="inner">
			<!-- START BREADCRUMB -->
			{{ Breadcrumbs::render('statement.audit') }}
			<div class="row">
				<div class="col-xl-12 col-lg-12 ">
					<!-- START card -->
					<div class="card card-transparent">
						<div class="card-block p-t-0">
							<h3 class='m-t-0'>Penyata Kewangan <span class="semi-bold"> - Juru Audit Luar</span></h3>
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
                    'percentage' => (8 - $errors_jl1)/8*100,
                    'title' => 'Borang JL 1',
                    'description' => '- Permohonan Kelulusan Juru Audit Luar',
                ])
                <div class="btn-group-custom">
                    <a href="{{ route('formjl1', $auditor->id ) }}" class="btn btn-primary pull-right btn-input"><i class="fa fa-edit mr-1"></i> Isi Borang</a>
                    @if(!$errors_jl1)
                    <a href="{{ route('download.formjl1', $auditor->id) }}" target="_blank" class="btn btn-default mr-2 pull-right btn-lock"><i class="fa fa-print mr-1"></i> Cetak</a>
                    <a href="javascript:;" class="btn btn-master mr-2 pull-right btn-unlock"><i class="fa fa-lock"></i></a>
                    @endif
                </div>
            @endcomponent
        </div>
		<div class="col-lg-12">
            @component('components.block', [
                    'title' => 'Senarai Semak Pelantikan Juru Audit Bertauliah',
                    'disabled' => true
                ])
                <div class="btn-group-custom">
                    <a href="{{ url('files/checklist/audit1.pdf') }}" target="_blank" class="btn btn-default mr-2 pull-right"><i class="fa fa-print mr-1"></i> Cetak</a>
                </div>
                <hr>
                <ul>
                    <li><label>Memastikan Juruaudit dilantik tidak melebihi tiga (3) kali lantikan berturut-turut</label></li>
                    <li><label>Surat kelayakan Akauntan yang dikeluarkan oleh Malaysian Institute of Chartered Accountant. </label></li>
                    <li><label>Surat beri kuasa (written authority) oleh Menteri Kewangan sebagai Juruaudit.</label></li>
                    <li><label>Salinan Kad Nama (Business Card) Juruaudit.</label></li>
                </ul>
            @endcomponent
        </div>

        <div class="col-lg-12">
            @component('components.block', [
                    'title' => 'Senarai Semak Pelantikan Juru Audit Tidak Bertauliah',
                    'disabled' => true
                ])
                <div class="btn-group-custom">
                    <a href="{{ url('files/checklist/audit2.pdf') }}" target="_blank" class="btn btn-default mr-2 pull-right"><i class="fa fa-print mr-1"></i> Cetak</a>
                </div>
                <hr>
                <ul>
                    <li><label>Salinan Penyata Bank Kesatuan yang terkini.</label></li>
                    <li><label>Salinan sijil kelulusan akademik Juruaudit</label></li>
                    <li><label>Salinan Kad Pengenalan Juruaudit</label></li>
                    <li><label>Salinan surat sokongan berkenaan dengan pengalaman sebagai Juruaudit</label></li>
                </ul>
            @endcomponent
        </div>
        @if($auditor->created_by_user_id == auth()->id())
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
        window.history.pushState('statement.audit', 'Juruaudit', '{{ fullUrl() }}/{{ $auditor->id }}');
    @endif

    function submit() {

        if(printed < 1) {
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
                    url: '{{ route("statement.audit.form", $auditor->id) }}',
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
                                    location.href="{{ route('statement.audit.list') }}";
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