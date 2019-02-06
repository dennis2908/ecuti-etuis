@extends('layouts.app')
@include('plugins.wizard')
@include('plugins.datatables')

@push('css')
<style>
@media (max-width: 991px) {
	.tab-content {
		padding-top: 0px !important;
	}
}

.form-horizontal .form-group {
    border-bottom: unset !important;
}
</style>
@endpush

@section('content')
@include('components.msg-disconnected')
<!-- START JUMBOTRON -->
<div class="jumbotron m-b-0" data-pages="parallax">
    <div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
        <div class="inner">
            <!-- START BREADCRUMB -->
            {{ Breadcrumbs::render('formi') }}
            <!-- END BREADCRUMB -->
            <div class="row">
                <div class="col-xl-12 col-lg-12 ">
                    <!-- START card -->
                    <div class="card card-transparent">
                        <div class="card-block p-t-0">
                            <h3 class='m-t-0'>Borang I - Notis Pembubaran Kesatuan</h3>
                            <p class="small hint-text m-t-5">
                                AKTA KESATUAN SEKERJA, 1959 ( Seksyen 42 dan Peraturan 1(1) )
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
			<a class="" data-toggle="tab" href="#" data-target="#tab2" role="tab"><i class="fa tab-icon {{ $formi->members->count() < 7 ? 'fa-times text-danger' : 'fa-check text-success' }}"></i> <span>Butiran Ahli</span></a>
		</li>
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
		<div class="tab-pane active slide-right" id="tab1">
			@include('dissolution-cancellation.dissolution.formi.tab1')
		</div>
		<div class="tab-pane slide-right" id="tab2">
			@include('dissolution-cancellation.dissolution.formi.tab2.index')
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
            location.href="{{ route('dissolution.form', $dissolution->id) }}";
        }
    });
}

///////////////////////////////////////////////////////////////////////////////////
var required = {
	'applied_at': '{{ $formi->applied_at ? 1 : 0 }}',
	'concluded_at': '{{ $formi->concluded_at ? 1 : 0 }}',
	'meeting_type_id': '{{ $formi->meeting_type_id ? 1 : 0 }}',
	'resolved_at': '{{ $formi->resolved_at ? 1 : 0 }}',
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
		socket.emit('formi', {
			id: {{ $formi->id }},
        	name: $(this).attr('name'),
			value: $(this).attr('type') == 'checkbox' ? ($(this).prop('checked') ? 1 : 0) : $(this).val(),
			user: '{{ Cookie::get('api_token') }}'
		});
		console.log('changed');
	});

	$("#meeting_type_{{ $formi->meeting_type_id ? $formi->meeting_type_id : '' }}").prop('checked', true).trigger('change');;

});

</script>
@endpush
