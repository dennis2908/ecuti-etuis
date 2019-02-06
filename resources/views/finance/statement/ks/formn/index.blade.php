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
<!-- START JUMBOTRON -->
<div class="jumbotron m-b-0" data-pages="parallax">
	<div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
		<div class="inner">
			<!-- START BREADCRUMB -->
			{{ Breadcrumbs::render('statement.ks') }}
			<div class="row">
				<div class="col-xl-12 col-lg-12 ">
					<!-- START card -->
					<div class="card card-transparent">
						<div class="card-block p-t-0">
							<h3 class='m-t-0'>Borang N - Penyata Tahunan </h3>
							<p class="small hint-text m-t-5">
								Akta Kesatuan Sekerja, 1959 (Seksyen 56(1) dan Peraturan 28)
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
			<a class="active" data-toggle="tab" href="#" data-target="#tab1" role="tab"><i class="fa fa-times tab-icon text-danger"></i> <span>Penyata Tahunan</span></a>
		</li>
		<li class="nav-item">
			<a class="" data-toggle="tab" href="#" data-target="#tab2" role="tab"><i class="fa fa-times tab-icon text-danger"></i> <span>Anggota</span></a>
		</li>
		<li class="nav-item">
			<a class="" data-toggle="tab" href="#" data-target="#tab3" role="tab"><i class="fa fa-times tab-icon text-danger"></i> <span>Penyata "1"</span></a>
		</li>
		<li class="nav-item">
			<a class="" data-toggle="tab" href="#" data-target="#tab4" role="tab"><i class="fa fa-check tab-icon text-success"></i> <span>Penyata "2" (i)</span></a>
		</li>
		<li class="nav-item">
			<a class="" data-toggle="tab" href="#" data-target="#tab5" role="tab"><i class="fa fa-check tab-icon text-success"></i> <span>Penyata "2" (ii)</span></a>
		</li>
		<li class="nav-item">
			<a class="" data-toggle="tab" href="#" data-target="#tab6" role="tab"><i class="fa fa-check tab-icon text-success"></i> <span>Sekuriti</span></a>
		</li>
		<li class="nav-item">
			<a class="" data-toggle="tab" href="#" data-target="#tab7" role="tab"><i class="fa fa-times tab-icon text-danger"></i> <span>Pengesahan</span></a>
		</li>
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
		<div class="tab-pane active slide-right" id="tab1">
			@include('finance.statement.ks.formn.tab1')
		</div>
		<div class="tab-pane slide-right" id="tab2">
			@include('finance.statement.ks.formn.tab2')
		</div>
		<div class="tab-pane slide-right" id="tab3">
			@include('finance.statement.ks.formn.tab3')
		</div>
		<div class="tab-pane slide-right" id="tab4">
			@include('finance.statement.ks.formn.tab4.index')
		</div>
		<div class="tab-pane slide-right" id="tab5">
			@include('finance.statement.ks.formn.tab5.index')
		</div>
		<div class="tab-pane slide-right" id="tab6">
			@include('finance.statement.ks.formn.tab6.index')
		</div>
		<div class="tab-pane slide-right" id="tab7">
			@include('finance.statement.ks.formn.tab7')
		</div>
	</div>
</div>
@endsection

@push('js')
<script src="{{ asset('assets/plugins/bootstrap-form-wizard/js/jquery.bootstrap.wizard.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/form_wizard.js') }}" type="text/javascript"></script>

<script type="text/javascript">

$('.date input').datepicker({ 
    language: 'ms',
	format: 'dd/mm/yyyy',
    endDate: '+0d',
    autoclose: true,
    onClose: function() {
        $(this).valid();
    },
}).on('changeDate', function(){
    $(this).trigger('change');
});

$('.input-daterange input').datepicker({ 
    language: 'ms',
	format: 'dd/mm/yyyy',
    endDate: '+0d',
    autoclose: true,
    onClose: function() {
        $(this).valid();
    },
}).on('changeDate', function(){
    $(this).trigger('change');
});

//////////////////////////////////////////////////////////////////////////////
var required1 = {
	'year': '{{ isset($statement->year) ? 1 : 0 }}',
	'certification_no': '{{ isset($statement->certification_no) ? 1 : 0 }}',
	'total_member_start': '{{ isset($statement->total_member_start) ? 1 : 0 }}',
	'total_member_accepted': '{{ isset($statement->total_member_accepted) ? 1 : 0 }}',
	'total_member_leave': '{{ isset($statement->total_member_leave) ? 1 : 0 }}',
	'total_member_end': '{{ isset($statement->total_member_end) ? 1 : 0 }}',
	'total_male': '{{ isset($statement->total_male) ? 1 : 0 }}',
	'total_female': '{{ isset($statement->total_female) ? 1 : 0 }}',
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
		if($(this).val() !== null && $(this).val() !== '') {
			required1[key] = '1';
			checkTab1();
		}
		else {
			required1[key] = '0';
			checkTab1();
		}
	});
});
//////////////////////////////////////////////////////////////////////////////////////////

var required2 = {
	'duration': '{{ isset($statement->duration) ? 1 : 0 }}',	
	'male_malay': '{{ isset($statement->male_malay) ? 1 : 0 }}',	
	'male_chinese': '{{ isset($statement->male_chinese) ? 1 : 0 }}',	
	'male_indian': '{{ isset($statement->male_indian) ? 1 : 0 }}',	
	'male_others': '{{ isset($statement->male_others) ? 1 : 0 }}',
	'female_malay': '{{ isset($statement->female_malay) ? 1 : 0 }}',	
	'female_chinese': '{{ isset($statement->female_chinese) ? 1 : 0 }}',	
	'female_indian': '{{ isset($statement->female_indian) ? 1 : 0 }}',	
	'female_others': '{{ isset($statement->female_others) ? 1 : 0 }}',
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
		if($(this).val() !== null && $(this).val() !== '') {
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
	'accept_balance_start': '{{ isset($statement->accept_balance_start) ? 1 : 0 }}',
	'accept_entrance_fee': '{{ isset($statement->accept_entrance_fee) ? 1 : 0 }}',
	'accept_membership_fee': '{{ isset($statement->accept_membership_fee) ? 1 : 0 }}',
	'accept_sponsorship': '{{ isset($statement->accept_sponsorship) ? 1 : 0 }}',
	'accept_sales': '{{ isset($statement->accept_sales) ? 1 : 0 }}',
	'accept_interest': '{{ isset($statement->accept_interest) ? 1 : 0 }}',
	'pay_officer_salary': '{{ isset($statement->pay_officer_salary) ? 1 : 0 }}',
	'pay_organization_salary': '{{ isset($statement->pay_organization_salary) ? 1 : 0 }}',
	'pay_auditor_fee': '{{ isset($statement->pay_auditor_fee) ? 1 : 0 }}',
	'pay_attorney_expenditure': '{{ isset($statement->pay_attorney_expenditure) ? 1 : 0 }}',
	'pay_tred_expenditure': '{{ isset($statement->pay_tred_expenditure) ? 1 : 0 }}',
	'pay_compensation': '{{ isset($statement->pay_compensation) ? 1 : 0 }}',
	'pay_sick_benefit': '{{ isset($statement->pay_sick_benefit) ? 1 : 0 }}',
	'pay_study_benefit': '{{ isset($statement->pay_study_benefit) ? 1 : 0 }}',
	'pay_publication_cost': '{{ isset($statement->pay_publication_cost) ? 1 : 0 }}',
	'pay_rental': '{{ isset($statement->pay_rental) ? 1 : 0 }}',
	'pay_stationary': '{{ isset($statement->pay_stationary) ? 1 : 0 }}',
	'pay_balance_end': '{{ isset($statement->pay_balance_end) ? 1 : 0 }}',
	'liability_fund': '{{ isset($statement->liability_fund) ? 1 : 0 }}',
	'asset_security': '{{ isset($statement->asset_security) ? 1 : 0 }}',
	'asset_furniture': '{{ isset($statement->asset_furniture) ? 1 : 0 }}',
	'other_asset_total': '{{ isset($statement->other_asset_total) ? 1 : 0 }}',
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
		if($(this).val() !== null && $(this).val() !== '') {
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
var required7 = {
	'signed_state_id': '{{ isset($statement->signed_state_id) ? 1 : 0 }}',
	'signed_district_id': '{{ isset($statement->signed_district_id) ? 1 : 0 }}',
	'signed_at': '{{ isset($statement->signed_at) ? 1 : 0 }}',
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
		if($(this).val() !== null && $(this).val() !== '') {
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

function save() {
	swal({
        title: "Berjaya!",
        text: "Data yang telah disimpan.",
        icon: "success",
        button: "OK",
    })
    .then((confirm) => {
        if (confirm) {
            location.href="{{ route('statement.ks.form', $statement->id) }}";
        }
    });
}

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

	$('.form-horizontal input, .form-horizontal select, .form-horizontal textarea').on('change', function() {
		socket.emit('formn', {
			id: {{ $statement->id }},
        	name: $(this).attr('name'),
			value: $(this).attr('type') == 'checkbox' ? ($(this).prop('checked') ? 1 : 0) : $(this).val(),
			user: '{{ Cookie::get('api_token') }}'
		});
		console.log('changed');
	});

	@if($statement->address->state_id)
		$("#state_id").val({{ $statement->address->state_id }}).trigger('change');
	@endif

	@if($statement->signed_state_id)
		$("#signed_state_id").val({{ $statement->signed_state_id }}).trigger('change');
	@endif

	@if($statement->signed_district_id)
		setTimeout(function() {
			$("#signed_district_id").val({{ $statement->signed_district_id }}).trigger('change');
		}, 1000);
	@endif

});
</script>

@endpush
