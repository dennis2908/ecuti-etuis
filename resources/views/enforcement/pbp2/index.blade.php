@extends('layouts.app')
@include('plugins.datatables')
@include('plugins.wizard')

@section('content')
@include('components.msg-disconnected')
<!-- START JUMBOTRON -->
<div class="jumbotron m-b-0" data-pages="parallax">
	<div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
		<div class="inner">
			<!-- START BREADCRUMB -->
			{{ Breadcrumbs::render('enforcement') }}
			<div class="row">
				<div class="col-xl-12 col-lg-12 ">
					<!-- START card -->
					<div class="card card-transparent">
						<div class="card-block p-t-0">
							<h3 class='m-t-0'>Laporan Pemeriksaan Penguatkuasaan</h3> 
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

<div id="rootwizard">
	@include('components.msg-connecting')
	<!-- Nav tabs -->
	<ul class="nav nav-tabs nav-tabs-linetriangle nav-tabs-separator nav-stack-sm" role="tablist" {{-- data-init-reponsive-tabs="dropdownfx" --}} >
		<li class="nav-item ml-md-3">
			<a class="active" data-toggle="tab" href="#" data-target="#tab1" role="tab"><i class="fa fa-check tab-icon text-danger"></i> <span>Laporan </span></a>
		</li>
		<li class="nav-item">
			<a class="" data-toggle="tab" href="#" data-target="#tab2" role="tab"><i class="fa fa-check tab-icon text-danger"></i> <span>Maklumat Asas </span></a>
		</li>
		<li class="nav-item">
			<a class="" data-toggle="tab" href="#" data-target="#tab3" role="tab"><i class="fa fa-check tab-icon text-success"></i> <span>Dokumen </span></a>
		</li>
		<li class="nav-item ml-md-3">
			<a class="" data-toggle="tab" href="#" data-target="#tab4" role="tab"><i class="fa fa-check tab-icon text-success"></i> <span>Kewangan</span></a>
		</li>
		<li class="nav-item">
			<a class="" data-toggle="tab" href="#" data-target="#tab5" role="tab"><i class="fa fa-check tab-icon text-danger"></i> <span>Pentadbiran </span></a>
		</li>
		<!-- Syarat: Hanya jika Kesatuan Induk-->
		<li class="nav-item">
			<a class="" data-toggle="tab" href="#" data-target="#tab6" role="tab"><i class="fa fa-check tab-icon text-success"></i> <span>Penggabungan </span></a>
		</li>
		<!-- End Syarat-->
		<li class="nav-item">
			<a class="" data-toggle="tab" href="#" data-target="#tab7" role="tab"><i class="fa fa-times tab-icon text-danger"></i> <span>Ulasan  </span></a>
		</li>
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
		<div class="tab-pane active slide-right" id="tab1">
			@include('enforcement.pbp2.tab1')
		</div>
		<div class="tab-pane slide-right" id="tab2">
			@include('enforcement.pbp2.tab2')
		</div>
		<div class="tab-pane slide-right" id="tab3">
			@include('enforcement.pbp2.tab3')
		</div>
		<div class="tab-pane slide-right" id="tab4">
			@include('enforcement.pbp2.tab4')
		</div>
		<div class="tab-pane slide-right" id="tab5">
			@include('enforcement.pbp2.tab5')
		</div>
		<div class="tab-pane slide-right" id="tab6">
			@include('enforcement.pbp2.tab6')
		</div>
		<div class="tab-pane slide-right" id="tab7">
			@include('enforcement.pbp2.tab7')
		</div>
	</div>
</div>
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
            location.href="{{ route('enforcement.form', request()->id) }}";
        }
    });
}

$(".data-true input[type=checkbox]").parents('.form-group').children('div').css('visibility', 'hidden');
$(".data-true input[type=checkbox]:checked").parents('.form-group').children('div').css('visibility', 'visible');

$(".data-true input[type=checkbox]").on('change', function() {
	if( $(this).prop('checked') )
		$(this).parents('.form-group').children('div').css('visibility', 'visible');
	else
		$(this).parents('.form-group').children('div').css('visibility', 'hidden');
});

//////////////////////////////////////////////////////////////////////////////
var required1 = {
	'province_office_id': '{{ $enforcement->pbp2->province_office_id ? 1 : 0 }}',
	'investigation_date': '{{ $enforcement->pbp2->investigation_date ? 1 : 0 }}',
	'location': '{{ $enforcement->pbp2->location ? 1 : 0 }}',
	'complaint_reference_no': '{{ $enforcement->pbp2->is_complaint_investigation == 1 ? ($enforcement->pbp2->is_complaint_investigation ? 1 : 0) : 1 }}',
}

function checkTab1() {
	$.each(required1, function(key, value) {
		if(value == "0") {
			$("a[data-target='#tab1'] i").removeClass('text-success');
			$("a[data-target='#tab1'] i").removeClass('fa-check');
			$("a[data-target='#tab1'] i").addClass('text-danger');
			$("a[data-target='#tab1'] i").addClass('fa-times');
			return false;
		}
		else {
			$("a[data-target='#tab1'] i").removeClass('text-danger');
			$("a[data-target='#tab1'] i").removeClass('fa-times');
			$("a[data-target='#tab1'] i").addClass('text-success');
			$("a[data-target='#tab1'] i").addClass('fa-check');
		}
	});
}

checkTab1();

$.each(required1, function(key, value) {
	$("input[name="+key+"]").on('change', function() {
		if($(this).val() !== null && $(this).val().length !== 0) {
			required1[key] = '1';
			checkTab1();
		}
		else {
			required1[key] = '0';
			checkTab1();
		}
	});
});

//////////////////////////////////////////////////////////////////////////////
var required2 = {
	'address_type_id': '{{ $enforcement->pbp2->address_type_id ? 1 : 0 }}',	
}

function checkTab2() {
	$.each(required2, function(key, value) {
		if(value == "0") {
			$("a[data-target='#tab2'] i").removeClass('text-success');
			$("a[data-target='#tab2'] i").removeClass('fa-check');
			$("a[data-target='#tab2'] i").addClass('text-danger');
			$("a[data-target='#tab2'] i").addClass('fa-times');
			return false;
		}
		else {
			$("a[data-target='#tab2'] i").removeClass('text-danger');
			$("a[data-target='#tab2'] i").removeClass('fa-times');
			$("a[data-target='#tab2'] i").addClass('text-success');
			$("a[data-target='#tab2'] i").addClass('fa-check');
		}
	});
}

checkTab2();

$.each(required2, function(key, value) {
	$("input[name="+key+"]").on('change', function() {
		if($(this).val() !== null && $(this).val().length !== 0) {
			required2[key] = '1';
			checkTab2();
		}
		else {
			required2[key] = '0';
			checkTab2();
		}
	});
});
//////////////////////////////////////////////////////////////////////////////
var required3 = {
	'is_monthly_maintained': '{{ $enforcement->pbp2->is_monthly_maintained ? 1 : 0 }}',
}

function checkTab3() {
	$.each(required3, function(key, value) {
		if(value == "0") {
			$("a[data-target='#tab3'] i").removeClass('text-success');
			$("a[data-target='#tab3'] i").removeClass('fa-check');
			$("a[data-target='#tab3'] i").addClass('text-danger');
			$("a[data-target='#tab3'] i").addClass('fa-times');
			return false;
		}
		else {
			$("a[data-target='#tab3'] i").removeClass('text-danger');
			$("a[data-target='#tab3'] i").removeClass('fa-times');
			$("a[data-target='#tab3'] i").addClass('text-success');
			$("a[data-target='#tab3'] i").addClass('fa-check');
		}
	});
}

checkTab3();

$.each(required3, function(key, value) {
	$("input[name="+key+"]").on('change', function() {
		if($(this).val() !== null && $(this).val().length !== 0) {
			required3[key] = '1';
			checkTab3();
		}
		else {
			required3[key] = '0';
			checkTab3();
		}
	});
});

//////////////////////////////////////////////////////////////////////////////

var required5 = {
	'tenure_start': '{{ $enforcement->pbp2->tenure_start ? 1 : 0 }}',
	'tenure_end': '{{ $enforcement->pbp2->tenure_end ? 1 : 0 }}',
	'last_meeting_at': '{{ $enforcement->pbp2->last_meeting_at ? 1 : 0 }}',
	'last_election_at': '{{ $enforcement->pbp2->last_election_at ? 1 : 0 }}',
	'total_examiner': '{{ $enforcement->pbp2->total_examiner ? 1 : 0 }}',
}

function checkTab5() {
	$.each(required5, function(key, value) {
		if(value == "0") {
			$("a[data-target='#tab5'] i").removeClass('text-success');
			$("a[data-target='#tab5'] i").removeClass('fa-check');
			$("a[data-target='#tab5'] i").addClass('text-danger');
			$("a[data-target='#tab5'] i").addClass('fa-times');
			return false;
		}
		else {
			$("a[data-target='#tab5'] i").removeClass('text-danger');
			$("a[data-target='#tab5'] i").removeClass('fa-times');
			$("a[data-target='#tab5'] i").addClass('text-success');
			$("a[data-target='#tab5'] i").addClass('fa-check');
		}
	});
}

checkTab5();

$.each(required5, function(key, value) {
	$("input[name="+key+"]").on('change', function() {
		if($(this).val() !== null && $(this).val().length !== 0) {
			required5[key] = '1';
			checkTab5();
		}
		else {
			required5[key] = '0';
			checkTab5();
		}
	});
});

///////////////////////////////////////////////////////////////////
var required7 = {
	'comment': '{{ $enforcement->pbp2->comment ? 1 : 0 }}',
}

function checkTab7() {
	$.each(required7, function(key, value) {
		if(value == "0") {
			$("a[data-target='#tab7'] i").removeClass('text-success');
			$("a[data-target='#tab7'] i").removeClass('fa-check');
			$("a[data-target='#tab7'] i").addClass('text-danger');
			$("a[data-target='#tab7'] i").addClass('fa-times');
			return false;
		}
		else {
			$("a[data-target='#tab7'] i").removeClass('text-danger');
			$("a[data-target='#tab7'] i").removeClass('fa-times');
			$("a[data-target='#tab7'] i").addClass('text-success');
			$("a[data-target='#tab7'] i").addClass('fa-check');
		}
	});
}

checkTab7();

$.each(required7, function(key, value) {
	$("input[name="+key+"]").on('change', function() {
		if($(this).val() !== null && $(this).val().length !== 0) {
			required7[key] = '1';
			checkTab7();
		}
		else {
			required7[key] = '0';
			checkTab7();
		}
	});
});

///////////////////////////////////////////////////////////////////////////
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
	
	$('input, select, textarea').on('change', function() {
		socket.emit('enforcement_pbp2', {
			id: {{ $enforcement->id }},
        	name: $(this).attr('name'),
			value: $(this).attr('type') == 'checkbox' ? ($(this).prop('checked') ? 1 : 0) : $(this).val(),
			user: '{{ Cookie::get('api_token') }}'
		});
		console.log('changed');
	});
});
</script>
@endpush

