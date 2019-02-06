@extends('layouts.app')

@section('content')
<!-- START JUMBOTRON -->
<div class="jumbotron" data-pages="parallax">
    <div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
        <div class="inner">
            <!-- START BREADCRUMB -->
            {{ Breadcrumbs::render('levy') }}
            <!-- END BREADCRUMB -->
            <div class="row">
				<div class="col-xl-12 col-lg-12 ">
					<!-- START card -->
					<div class="card card-transparent">
						<div class="card-block p-t-0">
							<h3 class='m-t-0'>Pengenaan<span class="semi-bold"> Levi</span></h3>
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
                    'percentage' => (3 - $errors_levy)/3*100,
                    'title' => 'Borang PLV 1',
                    'description' => '-  Permohonan Pengenaan Levi',
                ])
                <div class="btn-group-custom">
                    <a href="{{ route('levy.plv1', $levy->id) }}" class="btn btn-primary pull-right btn-input"><i class="fa fa-edit mr-1"></i> Isi Borang</a>
                    @if(!$errors_levy)
                    <a href="{{ route('download.levy', $levy->id) }}" target="_blank" class="btn btn-default mr-2 pull-right btn-lock"><i class="fa fa-print mr-1"></i> Cetak</a>
                    <a href="javascript:;" class="btn btn-master mr-2 pull-right btn-unlock"><i class="fa fa-lock"></i></a>
                    @endif
                </div>
            @endcomponent
        </div>

        <div class="col-lg-12">
            @component('components.block', [
                    'percentage' => (7 - $errors_u)/7*100,
                    'title' => 'Borang U',
                    'description' => '- Penyata Keputusan Undi',
                ])
                <div class="btn-group-custom">
                    <a href="{{ route('levy.formu', $levy->id) }}" class="btn btn-primary pull-right btn-input"><i class="fa fa-edit mr-1"></i> Isi Borang</a>
                    @if(!$errors_u)
                    <a href="{{ route('download.levy.formu', $levy->id) }}" target="_blank" class="btn btn-default mr-2 pull-right btn-lock"><i class="fa fa-print mr-1"></i> Cetak</a>
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
                    <a href="{{ url('files/checklist/levy.pdf') }}" target="_blank" class="btn btn-default mr-2 pull-right"><i class="fa fa-print mr-1"></i> Cetak</a>
                </div>
                <hr>
                <ul>
                	<li><label>Borang PLV 1</label></li>
                    <li><label>Borang U</label></li>
                    <li><label>Minit Mesyuarat yang meluluskan usul pengenaan Levi</label></li>
                    <li><label>Contoh Kertas Undi</label></li>
                </ul>
            @endcomponent
        </div>
        @if($levy->created_by_user_id == auth()->id())
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
        console.log(printed);
    });

    $('.btn-unlock').on('click', function() {
        printed--;
        console.log(printed);
    });

    @if(!request()->id)
        window.history.pushState('levy', 'Levi', '{{ fullUrl() }}/{{ $levy->id }}');
    @endif

    function submit() {

        console.log(printed);

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
                    url: '{{ route("levy.form", $levy->id) }}',
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
                                    location.href="{{ route('levy.list') }}";
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
