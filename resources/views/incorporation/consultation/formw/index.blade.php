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
			{{ Breadcrumbs::render('formw') }}
			<div class="row">
				<div class="col-xl-12 col-lg-12 ">
					<!-- START card -->
					<div class="card card-transparent">
						<div class="card-block p-t-0">
							<h3 class='m-t-0'>Borang W - Pemberitahuan penggabungan Kesatuan Sekerja dengan Badan Perunding luar Malaysia</h3>
							<p class="small hint-text m-t-5">
								Akta Kesatuan Sekerja 1959, Seksyen 76B (1) and Peraturan 30B
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

@include('components.msg-connecting')
<div id="rootwizard">
	<!-- Nav tabs -->
	<ul class="nav nav-tabs nav-tabs-linetriangle nav-tabs-separator nav-stack-sm" role="tablist" {{-- data-init-reponsive-tabs="dropdownfx" --}} >
		<li class="nav-item ml-md-3">
			<a class="active" data-toggle="tab" href="#" data-target="#tab1" role="tab"><i class="fa fa-check tab-icon text-success"></i> <span>Maklumat Permohonan</span></a>
		</li>
		<li class="nav-item">
			<a class="" data-toggle="tab" href="#" data-target="#tab2" role="tab"><i class="fa tab-icon {{ $formw->officers->count() < 5 ? 'fa-times text-danger' : 'fa-check text-success' }}"></i> <span>Butiran Pegawai</span></a>
		</li>
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
		<div class="tab-pane active slide-right" id="tab1">
			@include('incorporation.consultation.formw.tab1')
		</div>
		<div class="tab-pane slide-right" id="tab2">
			@include('incorporation.consultation.formw.tab2.index')
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
            location.href="{{ route('formw.list') }}";
        }
    });
}

///////////////////////////////////////////////////////////////////////////////////
var required = {
	'consultant_name': '{{ $formw->consultant_name ? 1 : 0 }}',
	'consultant_address': '{{ $formw->consultant_address ? 1 : 0 }}',
	'consultant_phone': '{{ $formw->consultant_phone ? 1 : 0 }}',
	'consultant_fax': '{{ $formw->consultant_fax ? 1 : 0 }}',
	'consultant_email': '{{ $formw->consultant_email ? 1 : 0 }}',
	'resolved_at': '{{ $formw->resolved_at ? 1 : 0 }}',
	'meeting_type_id': '{{ $formw->meeting_type_id ? 1 : 0 }}',
	'applied_at': '{{ $formw->applied_at ? 1 : 0 }}',
}

function checkTab1() {
	$.each(required, function(key, value) {
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

$.each(required, function(key, value) {
	$("input[name="+key+"]").on('change', function() {
		if($(this).val() !== null && $(this).val().length !== 0) {
			required[key] = '1';
			checkTab1();
		}
		else {
			required[key] = '0';
			checkTab1();
		}
	});
});
///////////////////////////////////////////////////////////////////////////////////

$(document).ready(function() {
    var socket = io('{{ env('SOCKET_HOST', '127.0.0.1') }}:{{ env('SOCKET_PORT', 3000) }}');
    socket.on('connect', function() {
	    $(".msg-disconnected").slideUp();
	    $(".msg-connecting").slideUp();
	});
	socket.on('disconnect', function() {
	    $(".msg-disconnected").slideDown();
	    $("html, body").animate({ scrollTop: 0 }, 500);
	});

	$('#tab1 input, #tab1 select, #tab1 textarea').on('change', function() {
		socket.emit('formw', {
			id: {{ $formw->id }},
        	name: $(this).attr('name'),
			value: $(this).attr('type') == 'checkbox' ? ($(this).prop('checked') ? 1 : 0) : $(this).val(),
			user: '{{ Cookie::get('api_token') }}'
		});
		console.log('changed');
	});

    $("#meeting_type_{{ $formw->meeting_type_id }}").prop('checked', true).trigger('change');

});
</script>
@endpush
