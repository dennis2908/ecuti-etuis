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
			{{ Breadcrumbs::render('registration.formbb') }}
			<div class="row">
				<div class="col-xl-12 col-lg-12 ">
					<!-- START card -->
					<div class="card card-transparent">
						<div class="card-block p-t-0">
							<h3 class='m-t-0'>Borang BB3 - Perlembagaan Persekutuan</h3>
							<p class="small hint-text m-t-5">
								MPPKS 2013

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
				<div class="card-block" id="bb3">
					<div class="form-group form-group-default required">
						<label id=""><i class="info-box fa fa-info-circle mr-1 clickable" data-html="true" data-toggle="tooltip" title="Peraturan 6(1)"></i> Yuran Masuk</label>
						<input id="entrance_fee" name="entrance_fee" placeholder="" class="form-control autoscroll currency_format numeric" value="{{ $formbb3->entrance_fee }}" required type="text">
					</div>
					<div class="form-group form-group-default required">
						<label id=""><i class="info-box fa fa-info-circle mr-1 clickable" data-html="true" data-toggle="tooltip" title="Peraturan 6(1)"></i>Yuran Tahunan</label>
						<input id="yearly_fee" name="yearly_fee" placeholder="" class="form-control autoscroll currency_format numeric" value="{{ $formbb3->yearly_fee }}" required type="text">
					</div>
					<div class="form-group form-group-default form-group-default-select2 form-group-default-custom required">
						<label id=""><i class="info-box fa fa-info-circle mr-1 clickable" data-html="true" data-toggle="tooltip" title="Peraturan 8(1), 8(7), 8(10), 8(13), 8(14), 9(4), 9(5), 10(1), 10(2), 14(1), 18(2)"></i>Konvensyen ..... Tahunan</label>
						<select id="convention_yearly" name="convention_yearly" class="full-width autoscroll" data-init-plugin="select2" required>
							<option disabled hidden selected>Pilih satu</option>
							<option value="1">Satu</option>
							<option value="2">Dua</option>
							<option value="3">Tiga</option>
						</select>
					</div>
					<div class="form-group form-group-default required">
						<label id=""><i class="info-box fa fa-info-circle mr-1 clickable" data-html="true" data-toggle="tooltip" title="Peraturan 8(4)"></i>Dua orang wakil bagi ..... ratus anggota pertama</label>
						<input id="first_member" name="first_member" placeholder="" class="form-control autoscroll numeric" value="{{ $formbb3->first_member }}" required type="text">
					</div>
					<div class="form-group form-group-default required">
						<label id=""><i class="info-box fa fa-info-circle mr-1 clickable" data-html="true" data-toggle="tooltip" title="Peraturan 8(4)"></i> Seorang wakil bagi tiap-tiap ......... ratus orang anggota</label>
						<input id="next_member" name="next_member" placeholder="" class="form-control autoscroll numeric" value="{{ $formbb3->next_member }}" required type="text">
					</div>
					<div class="form-group form-group-default required">
						<label id=""><i class="info-box fa fa-info-circle mr-1 clickable" data-html="true" data-toggle="tooltip" title="Peraturan 15(5)"></i> Jumlah simpanan wang tunai tertinggi yang dibenarkan (Ringgit)</label>
						<input id="max_savings" name="max_savings" placeholder="" class="form-control autoscroll currency numeric" value="{{ $formbb3->max_savings }}" required type="text">
					</div>
					<div class="form-group form-group-default required">
						<label id=""><i class="info-box fa fa-info-circle mr-1 clickable" data-html="true" data-toggle="tooltip" title="Peraturan 15(5)"></i> Jumlah perbelanjaan tertinggi sesuatu masa (Ringgit)</label>
						<input id="max_expenses" name="max_expenses" placeholder="" class="form-control autoscroll currency numeric" value="{{ $formbb3->max_expenses }}" required type="text">
					</div>
					<button type="button" class="btn btn-default mr-1" onclick="location.href='{{ route('formbb', ['id' => $formbb->id]) }}'"><i class="fa fa-angle-left mr-1"></i> Kembali</button>
					<button type="button" class="btn btn-info pull-right" onclick="save()" data-dismiss="modal">Simpan</button>
				</div>
			</div>
			<!-- END card -->
		</div>
		<div id="preview" class="col-md-8 order-md-1" style="max-height: 650px;overflow-y: auto; overflow-x: hidden;">
			<!-- START card -->
			<div class="card card-transparent">
				<div class="card-header ">
				</div>
				<div class="card-block" style="">
					@include('registration.formbb.bb3.document')
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
            location.href="{{ route('formbb', ['id' => $formbb->id]) }}";
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
		else if( $(this).hasClass('currency_format') )
			$("."+id).html( parseFloat(Math.round($(this).val() * 100) / 100).toFixed(2) );
		else if( $(this).hasClass('ajk') )
			$("."+id).html(toWords($(this).val())+" ("+$(this).val()+")");
		else
			$("."+id).html( $(this).val() );
	}
}).on("change", function() {
	var id = $(this).attr('id');

	if(id == "meeting_yearly") {
		if( $(this).val() == "2" || $(this).val() == "3" ) {
			$("#rep_yearly").val( $(this).val() ).trigger('change');
			$("#rep_yearly").parents('.form-group').hide();

			$("#ajk_yearly").val( $(this).val() ).trigger('change');
			$("#ajk_yearly").parents('.form-group').hide();

		} else {
			$("#rep_yearly").parents('.form-group').show();
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

	$('#bb3 input, #bb3 select, #bb3 textarea').on('change', function() {
		socket.emit('formbb3', {
			id: {{ $formbb3->id }},
        	name: $(this).attr('name'),
			value: $(this).attr('type') == 'checkbox' ? ($(this).prop('checked') ? 1 : 0) : $(this).val(),
			user: '{{ Cookie::get('api_token') }}'
		});
		console.log('changed');
	});

	$("#convention_yearly").val('{{ $formbb3->convention_yearly }}').trigger('change');

});

</script>
@endpush
