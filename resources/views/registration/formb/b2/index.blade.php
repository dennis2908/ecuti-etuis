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
			{{ Breadcrumbs::render('registration.formb') }}
			<div class="row">
				<div class="col-xl-12 col-lg-12 ">
					<!-- START card -->
					<div class="card card-transparent">
						<div class="card-block p-t-0">
							<h3 class='m-t-0'>Borang B2 - Permohonan Pendaftaran Kesatuan Sekerja </h3>
							<p class="small hint-text m-t-5">
								Akta Kesatuan Sekerja 1959 (Seksyen 10 (1) dan Peraturan 4)
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
			<a class="active" data-toggle="tab" href="#" data-target="#tab1" role="tab"><i class="fa fa-check tab-icon text-success"></i> <span>Maklumat Kesatuan Sekerja</span></a>
		</li>
		<li class="nav-item">
			<a class="" data-toggle="tab" href="#" data-target="#tab2" role="tab"><i class="fa tab-icon {{ $formb->requesters->count() < 7 ? 'fa-times text-danger' : 'fa-check text-success'}}"></i> <span>Butiran Pemohon</span></a>
		</li>
		<li class="nav-item">
			<a class="" data-toggle="tab" href="#" data-target="#tab3" role="tab"><i class="fa tab-icon {{ $formb->tenure->officers->count() < 7 ? 'fa-times text-danger' : 'fa-check text-success'}}"></i> <span>Butiran Pegawai</span></a>
		</li>
		<li class="nav-item">
			<a class="" data-toggle="tab" href="#" data-target="#tab4" role="tab"><i class="fa fa-check tab-icon text-success"></i> <span>Nombor Peraturan</span></a>
		</li>
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
		<div class="tab-pane active slide-right" id="tab1">
			@include('registration.formb.b2.tab1')
		</div>
		<div class="tab-pane slide-right" id="tab2">
			@include('registration.formb.b2.tab2.index')
		</div>
		<div class="tab-pane slide-right" id="tab3">
			@include('registration.formb.b2.tab3.index')
		</div>
		<div class="tab-pane slide-right" id="tab4">
			@include('registration.formb.b2.tab4')
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
            location.href="{{ route('formb', ['id' => $formb->id]) }}";
        }
    });
}

///////////////////////////////////////////////////////////////////////////////////
var required = {
	'has_branch': '{{ $formb->has_branch ? 1 : 0 }}',
	'union_type_id': '{{ $formb->union_type_id ? 1 : 0 }}',
	'sector_id': '{{ $formb->sector_id ? 1 : 0 }}',
	'total_member': '{{ $formb->total_member ? 1 : 0 }}',
	'resolved_at': '{{ $formb->tenure->meeting_at ? 1 : 0 }}',
	'meeting_type_id': '{{ $formb->tenure->meeting_type_id ? 1 : 0 }}',
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

	$('#tab1 input, #tab1 select, #tab1 textarea').on('change', function() {
		socket.emit('formb', {
			id: {{ $formb->id }},
        	name: $(this).attr('name'),
			value: $(this).attr('type') == 'checkbox' ? ($(this).prop('checked') ? 1 : 0) : $(this).val(),
			user: '{{ Cookie::get('api_token') }}'
		});
		console.log('changed');
	});

	$("#has_branch_{{ isset($formb->has_branch) ? $formb->has_branch ? 'yes' : 'no' : '' }}").prop('checked', true).trigger('change');;

	$("#union_type_{{ $formb->union_type_id ? $formb->union_type_id : '' }}").prop('checked', true).trigger('change');;

	$("#sector_{{ $formb->sector_id ? $formb->sector_id : '' }}").prop('checked', true).trigger('change');;

	$("#meeting_type_{{ $formb->meeting_type_id ? $formb->meeting_type_id : '' }}").prop('checked', true).trigger('change');;

	@if($formb->address->state_id)
		$("#state_id").val({{ $formb->address->state_id }}).trigger('change');
	@endif

	@if($formb->address->district_id)
		setTimeout(function() {
			$("#district_id").val({{ $formb->address->district_id }}).trigger('change');
		}, 1000);
	@endif
});

</script>
@endpush
