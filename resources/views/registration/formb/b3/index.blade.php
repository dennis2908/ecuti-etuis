@extends('layouts.app')

@push('css')
<style>
@media (max-width: 991px) {
	.main .card .card-block,
	.main .card .card-header {
		margin-left: 20px !important;
		margin-right: 20px !important;
	}
}

.highlight {
	background-color: #FFFF00 !important;
}
.highlight-green {
	background-color: #9FFF00 !important
}

.form-group-default-select2.form-group-default-custom label {
	position: inherit !important;
}
.form-group-default-select2.form-group-default-custom .select2-selection--single {
	padding-top: unset !important;
	height: 35px !important;
}
.info-box {
	position: absolute;
	right: 0;
	background-color: #19a9e0;
	padding: 5px;
	color: white;
	z-index: 10;
	margin-top: -7px;
	margin-right: 0px !important;
}
</style>
@endpush

@section('content')
@include('components.msg-disconnected')
<!-- START JUMBOTRON -->
<div class="jumbotron" data-pages="parallax">
	<div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
		<div class="inner">
			<!-- START BREADCRUMB -->
			{{ Breadcrumbs::render('registration.formb') }}
			<div class="row">
				<div class="col-xl-12 col-lg-12 ">
					<!-- START card -->
					<div class="card card-transparent">
						<div class="card-block p-t-0">
							<h3 class='m-t-0'>Borang B3 - Perlembagaan Tanpa Cawangan</h3>
							<p class="small hint-text m-t-5">
								MPKS (TC) 2012

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

<!-- START CONTAINER FLUID -->
@include('components.msg-connecting')
<div class="main container-fluid container-fixed-lg bg-white">
	<div class="row">
		<div class="col-md-4 order-md-2" style="background: #dadada;">
			<!-- START card -->
			<div class="card card-transparent">
				<div class="card-header ">
				</div>
				<div class="card-block" id="b3">
					<div class="form-group form-group-default required">
						<label id=""><i class="info-box fa fa-info-circle mr-1 clickable" data-html="true" data-toggle="tooltip" title="Peraturan 3(1)"></i> Keanggotaan terbuka kepada</label>
						<input id="membership_target" name="membership_target" placeholder="" class="form-control autoscroll" value="{{ $formb3->membership_target }}" required type="text">
					</div>
					<div class="form-group form-group-default required">
						<label id=""><i class="info-box fa fa-info-circle mr-1 clickable" data-html="true" data-toggle="tooltip" title="Peraturan 3(1)"></i> Digaji oleh</label>
						<input id="paid_by" name="paid_by" placeholder="" class="form-control autoscroll" value="{{ $formb3->paid_by }}" required type="text">
					</div>
					<div class="form-group form-group-default required">
						<label id=""><i class="info-box fa fa-info-circle mr-1 clickable" data-html="true" data-toggle="tooltip" title="Peraturan 4(1)"></i> Yuran Masuk</label>
						<input id="entrance_fee" name="entrance_fee" placeholder="" class="form-control autoscroll currency_format numeric" value="{{ $formb3->entrance_fee }}" required type="text">
					</div>
					<div class="form-group form-group-default required">
						<label id=""><i class="info-box fa fa-info-circle mr-1 clickable" data-html="true" data-toggle="tooltip" title="Peraturan 4(1)"></i> Yuran Bulanan</label>
						<input id="monthly_fee" name="monthly_fee" placeholder="" class="form-control autoscroll currency_format numeric" value="{{ $formb3->monthly_fee }}" required type="text">
					</div>
					<div class="form-group form-group-default form-group-default-select2 form-group-default-custom required">
						<label id=""><i class="info-box fa fa-info-circle mr-1 clickable" data-html="true" data-toggle="tooltip" title="Peraturan 3(1)"></i> Kerjanya di .....</label>
						<select id="workplace" name="workplace" class="full-width autoscroll" data-init-plugin="select2" required>
							<option disabled hidden selected>Pilih satu</option>
							<option value="Semenanjung Malayia">Semenanjung Malaysia</option>
							<option value="Sabah">Sabah</option>
							<option value="Sarawak">Sarawak</option>
						</select>
					</div>
					<div class="form-group form-group-default form-group-default-select2 form-group-default-custom required">
						<label id=""><i class="info-box fa fa-info-circle mr-1 clickable" data-html="true" data-toggle="tooltip" title="Peraturan 9(1), 9(2), 9(3), 9(6), 9(7), 9(9), 9(10), 10, 12(7), 12(8), 16(6), 17(1), 17(2), 17(3), 18(1), 18(2), 18(3), 19(6)"></i> Mesyuarat Agung ..... Tahunan</label>
						<select id="meeting_yearly" name="meeting_yearly" class="full-width autoscroll" data-init-plugin="select2" required>
							<option disabled hidden selected>Pilih satu</option>
							<option value="1">Satu</option>
							<option value="2">Dua</option>
							<option value="3">Tiga</option>
						</select>
					</div>
					<div class="form-group form-group-default required">
						<label id=""><i class="info-box fa fa-info-circle mr-1 clickable" data-html="true" data-toggle="tooltip" title="Peraturan 12(2)"></i> Jumlah Ahli Jawatankuasa (AJK)</label>
						<input id="total_ajk" name="total_ajk" placeholder="" class="form-control autoscroll ajk numeric" value="{{ $formb3->total_ajk }}" required type="text">
					</div>
					<div class="form-group form-group-default form-group-default-select2 form-group-default-custom required">
						<label id=""><i class="info-box fa fa-info-circle mr-1 clickable" data-html="true" data-toggle="tooltip" title="Peraturan 12(3)"></i> AJK Dipilih Setiap ..... Tahun</label>
						<select id="ajk_yearly" name="ajk_yearly" class="full-width autoscroll" data-init-plugin="select2" required>
							<option disabled hidden selected>Pilih satu</option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
						</select>
					</div>
					<div class="form-group form-group-default form-group-default-select2 form-group-default-custom required">
						<label id=""><i class="info-box fa fa-info-circle mr-1 clickable" data-html="true" data-toggle="tooltip" title="Peraturan 19(5)"></i> Jumlah simpanan wang tunai tertinggi yang dibenarkan (Ratus Ringgit)</label>
						<select id="max_savings" name="max_savings" class="full-width autoscroll currency" data-init-plugin="select2" required>
							<option disabled hidden selected>Pilih satu</option>
							<option value="100">1</option>
							<option value="200">2</option>
							<option value="300">3</option>
							<option value="400">4</option>
							<option value="500">5</option>
							<option value="600">6</option>
							<option value="700">7</option>
							<option value="800">8</option>
							<option value="900">9</option>
						</select>
					</div>
					<div class="form-group form-group-default form-group-default-select2 form-group-default-custom required">
						<label id=""><i class="info-box fa fa-info-circle mr-1 clickable" data-html="true" data-toggle="tooltip" title="Peraturan 19(5)"></i> Jumlah perbelanjaan tertinggi sesuatu masa (Ratus Ringgit)</label>
						<select id="max_expenses" name="max_expenses" class="full-width autoscroll currency" data-init-plugin="select2" required>
							<option disabled hidden selected>Pilih satu</option>
							<option value="100">1</option>
							<option value="200">2</option>
							<option value="300">3</option>
							<option value="400">4</option>
							<option value="500">5</option>
							<option value="600">6</option>
							<option value="700">7</option>
							<option value="800">8</option>
							<option value="900">9</option>
						</select>
					</div>
					<button type="button" class="btn btn-default mr-1" onclick="location.href='{{ route('formb', ['id' => $formb->id]) }}'"><i class="fa fa-angle-left mr-1"></i> Kembali</button>
					<button type="button" class="btn btn-info pull-right btn-send" onclick="save()" data-dismiss="modal"><i class="fa fa-check mr-1"></i> Simpan</button>
				</div>
			</div>
			<!-- END card -->
		</div>
		<div id="preview" class="col-md-8 order-md-1" style="max-height: 750px;overflow-y: auto;">
			<!-- START card -->
			<div class="card card-transparent">
				<div class="card-header ">
				</div>
				<div class="card-block" style="">
					@include('registration.formb.b3.document')
				</div>
			</div>
			<!-- END card -->
		</div>
	</div>
</div>
<!-- END CONTAINER FLUID -->
@endsection

@push('js')
<script type="text/javascript">

function save() {
	swal({
        title: "Berjaya!",
        text: "Data yang telah disimpan.",
        icon: "success",
        button: "OK",
    })
    .then((confirm) => {
        if (confirm) {
            location.href="{{ route('formb', ['id' => $formb->id]) }}";
        }
    });
}

$(".autoscroll").on("focus select2:open", function() {
	var id = $(this).attr('id');
	$("."+id).removeClass('highlight-green');
	$("."+id).addClass('highlight');

	var offset = $("."+id).first().offset();
	var $main = $('#preview');
	$('#preview').animate({
		scrollTop: offset.top - ($main.offset().top - $main.scrollTop()) - 150 - $(document).scrollTop()
	}, 500);
}).on("blur select2:close", function() {
	var id = $(this).attr('id');
	$("."+id).removeClass('highlight');

	if($(this).val() == "")
		$("."+id).removeClass('highlight-green');
	else
		$("."+id).addClass('highlight-green');
}).on("keyup", function() {
	var id = $(this).attr('id');

	if($(this).val() == "") {
		$("."+id).html("......");
	}
	else {
		if( $(this).hasClass('currency') )
			$("."+id).html(toRinggit($(this).val())+" (RM"+number_format($(this).val())+")");
		else if( $(this).hasClass('ajk') )
			$("."+id).html(toWords($(this).val())+" ("+$(this).val()+")");
		else
			$("."+id).html( $(this).val() );
	}
}).on("change", function() {
	var id = $(this).attr('id');

	if(id == "meeting_yearly") {
		if( $(this).val() == "2" || $(this).val() == "3" ) {
			$("#ajk_yearly").val( $(this).val() ).trigger('change');
			$("#ajk_yearly").parents('.form-group').hide();
		} else {
			$("#ajk_yearly").parents('.form-group').show();
		}
	}

	if($(this).val() == ""){
		$("."+id).html("......");
		$("."+id).removeClass('highlight-green');
	}
	else {
		if( $(this).hasClass('currency') )
			$("."+id).html(toRinggit($(this).val())+" (RM"+number_format($(this).val())+")");
		else if( $(this).hasClass('currency_format') )
			$("."+id).html( parseFloat(Math.round($(this).val() * 100) / 100).toFixed(2) );
		else if(id == "meeting_yearly" || id == "convention_yearly" || id == "conference_yearly") {
			if($(this).val() == "1")
				$("."+id).html("");
			else if($(this).val() == "2")
				$("."+id).html("Dwi");
			else if($(this).val() == "3")
				$("."+id).html("Tiga");
		}
		else
			$("."+id).html( $(this).val() );

		$("."+id).addClass('highlight-green');
	}
});

$(".autoscroll").trigger('change');

$(document).ready(function(){
	var socket = io('{{ env('SOCKET_HOST', '127.0.0.1') }}:{{ env('SOCKET_PORT', 3000) }}');

	socket.on('connect', function() {
	    $(".msg-disconnected").slideUp();
	    $(".msg-connecting").slideUp();
	});

	socket.on('disconnect', function() {
	    $(".msg-disconnected").slideDown();
	    $("html, body").animate({ scrollTop: 0 }, 500);
	});

	$('#b3 input, #b3 select, #b3 textarea').on('change', function() {
		socket.emit('formb3', {
			id: {{ $formb3->id }},
        	name: $(this).attr('name'),
			value: $(this).attr('type') == 'checkbox' ? ($(this).prop('checked') ? 1 : 0) : $(this).val(),
			user: '{{ Cookie::get('api_token') }}'
		});
		console.log('changed');
	});

	$("#workplace").val("{{ $formb3->workplace }}").trigger('change');

	$("#meeting_yearly").val('{{ $formb3->meeting_yearly }}').trigger('change');

	$("#ajk_yearly").val('{{ $formb3->ajk_yearly }}').trigger('change');

	$("#max_savings").val('{{ $formb3->max_savings }}').trigger('change');

	$("#max_expenses").val('{{ $formb3->max_expenses }}').trigger('change');

});

</script>
@endpush
