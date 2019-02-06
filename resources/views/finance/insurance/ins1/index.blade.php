@extends('layouts.app')
@include('plugins.moment')
@include('plugins.daterangepicker')

@section('content')
@include('components.msg-disconnected')
<!-- START BREADCRUMB -->
<div class="jumbotron" data-pages="parallax">
	<div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
		<div class="inner" style="transform: translateY(0px); opacity: 1;">
			{{ Breadcrumbs::render('insurance') }}
			<!-- END BREADCRUMB -->
			<div class="row">
				<div class="col-xl-12 col-lg-12 ">
					<!-- START card -->
					<div class="card card-transparent">
						<div class="card-block p-t-0">
							<h3 class='m-t-0'>Borang INS1 - Permohonan Pembayaran Premium Insuran</h3>
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
<!-- END BREADCRUMB -->
<!-- END JUMBOTRON -->
<!-- START CONTAINER FLUID -->
<!-- START CONTAINER FLUID -->
@include('components.msg-connecting')
<div class=" container-fluid container-fixed-lg bg-white">
	<!-- START card -->
	<div class="card card-transparent">
		<div class="card-block">
			<div>
				<form id="form-insurance" class="form-horizontal" role="form" autocomplete="off" method="post" action="#">
	        		@component('components.bs.label', [
						'label' => 'Nama Kesatuan Sekerja',
					])
					{{ $insurance->tenure->entity->name }}
					@endcomponent

					@component('components.bs.label', [
						'label' => 'Alamat Ibu Pejabat',
					])
					{!! $insurance->address->address1.
					($insurance->address->address2 ? ',<br>'.$insurance->address->address2 : '').
					($insurance->address->address3 ? ',<br>'.$insurance->address->address3 : '').
					',<br>'.
					$insurance->address->postcode.' '.
					($insurance->address->district ? $insurance->address->district->name : '').', '.
					($insurance->address->state ? $insurance->address->state->name : '') !!}
					@endcomponent

					<div class="form-group row">
	                    <label for="fname" class="col-md-3 control-label">Cawangan
	                        <span style="color:red;">*</span>
	                    </label>
	                    <div class="col-md-9">
	                        <select id="branch_id" name="branch_id" class="full-width autoscroll" data-init-plugin="select2" required>
								<option value="-1" selected>Induk - {{ $insurance->tenure->entity->name }}</option>
								@foreach($insurance->tenure->entity->branches as $branch)
								<option value="{{ $branch->id }}">{{ $branch->name }}</option>
								@endforeach
							</select>
	                    </div>
	                </div>

					<div class="form-group row">
						<label for="" class="col-md-3 control-label">
							Melalui (Jenis Mesyuarat)<span style="color:red;">*</span>
						</label>
						<div class="col-md-9">
							<div class="radio radio-primary">
								@foreach($meeting_types as $meeting_type)
									<input name="meeting_type_id" value="{{ $meeting_type->id }}" id="meeting_type_{{ $meeting_type->id }}" type="radio" class="hidden" required>
									<label for="meeting_type_{{ $meeting_type->id }}">{{ $meeting_type->name }}</label>
								@endforeach
							</div>
						</div>
					</div>

					@include('components.bs.date', [
						'name' => 'resolved_at',
						'label' => 'Tarikh Mesyuarat',
						'mode' => 'required',
						'value' =>  $insurance->resolved_at ? date('d/m/Y', strtotime($insurance->resolved_at)) : '',
					])

					<!-- if pilih jenis Mesyuarat Agung letak AHLI. If Persidangan Perwakilan letak WAKIL-->
					@include('components.bs.input', [
						'name' => 'total_attendant',
						'label' => 'Jumlah kehadiran Ahli/Wakil',
						'mode' => 'required',
						'class' => 'numeric',
						'value' => $insurance->total_attendant
					])

					@include('components.bs.input', [
						'name' => 'total_covered',
						'label' => 'Bilangan ahli yang dilindungi',
						'mode' => 'required',
						'class' => 'numeric',
						'value' => $insurance->total_covered
					])

					@include('components.bs.input', [
						'name' => 'insurance_type',
						'label' => 'Jenis Insuran',
						'mode' => 'required',
						'value' => $insurance->insurance_type
					])

					@include('components.bs.input', [
						'name' => 'insurance_name',
						'label' => 'Nama Syarikat Insuran',
						'mode' => 'required',
						'value' => $insurance->insurance_name
					])

					<div class="form-group row">
						<label for="fname" class="col-md-3 control-label">Tempoh Perlindungan Insuran
							<i style="cursor: help; color: #48B0F7;" class="fa fa-question-circle" data-html="true" data-toggle="tooltip" title="Tidak melebihi 6 bulan"></i>
						</label>
						<div class="col-md-9">
							<div class="input-prepend input-group">
		                      	<span class="add-on input-group-addon">
		                      		<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
		                      	</span>
		                      	<input type="hidden" name="start_date" value="{{ $insurance->start_date ? date('d/m/Y', strtotime($insurance->start_date)) : '' }}">
		                      	<input type="hidden" name="end_date" value="{{ $insurance->end_date ? date('d/m/Y', strtotime($insurance->end_date)) : '' }}">
		                      	<input type="text" style="width: 100%" name="daterange" class="form-control" value="{{ $insurance->start_date && $insurance->end_date ? date('d/m/Y', strtotime($insurance->start_date)).' - '.date('d/m/Y', strtotime($insurance->end_date)) : '' }}" />
		                    </div>
						</div>
					</div>

					@include('components.bs.date', [
						'name' => 'last_approved_at',
						'label' => 'Tarikh Kelulusan Permohonan yang Terakhir',
						'mode' => 'required',
						'value' => $insurance->last_approved_at ? date('d/m/Y', strtotime($insurance->last_approved_at)) : '',
					])

					<div class="form-group row">
						<label for="fname" class="col-md-3 control-label">
							Jumlah bayaran tahunan
							<span style="color:red;">*</span>
						</label>
						<div class="col-md-9">
							<div class="input-group">
		                      	<span class="input-group-addon default">
		                          	RM
		                      	</span>
								<input type="text" name="annual_fee" data-a-dec="." data-a-sep="," class="autonumeric form-control decimal" value="{{ $insurance->annual_fee }}" required>
							</div>
						</div>
					</div>

					<div class="form-group row">
						<label for="fname" class="col-md-3 control-label">
							Jumlah bayaran tahunan setiap ahli
							<span style="color:red;">*</span>
						</label>
						<div class="col-md-9">
							<div class="input-group">
		                      	<span class="input-group-addon default">
		                          	RM
		                      	</span>
								<input type="text" name="annual_member_fee" data-a-dec="." data-a-sep="," class="autonumeric form-control decimal" value="{{ $insurance->annual_member_fee }}" required>
							</div>
						</div>
					</div>

					@include('components.bs.date', [
						'name' => 'formn_applied_at',
						'label' => 'Tarikh Borang N Terkini',
						'mode' => 'required',
						'value' => $insurance->formn_applied_at ? date('d/m/Y', strtotime($insurance->formn_applied_at)) : '',
					])

					@component('components.bs.label', [
						'name' => 'lu_latest',
						'label' => 'Borang LU penggal terkini',
					])
					{{ $insurance->tenure->formlu ? date('d/m/Y', strtotime($insurance->tenure->formlu->applied_at)) : '' }}
					@endcomponent
					<br>

					<div class="form-group">
						<button type="button" class="btn btn-default mr-1" onclick="location.href='{{ route('insurance.form', $insurance->id) }}'"><i class="fa fa-angle-left mr-1"></i> Kembali</button>
						<button type="button" class="btn btn-info pull-right" onclick="save()" data-dismiss="modal"><i class="fa fa-check mr-1"></i> Simpan</button>
					</div>
				</form>
			</div>
    	</div>
    </div>
</div>

@endsection
@push('js')
<script>
$("#form-insurance").validate();

function save() {
    swal({
        title: "Berjaya!",
        text: "Data yang telah disimpan.",
        icon: "success",
        button: "OK",
    })
    .then((confirm) => {
        if (confirm) {
            location.href="{{ route('insurance.form', $insurance->id) }}";
        }
    });
}

$(document).ready(function(){

	$('input[name=daterange]').daterangepicker({
        format: 'DD/MM/YYYY',
        language: 'ms',
    });

    $('input[name=daterange]').on('apply.daterangepicker', function() {
    	var dates = $(this).val().split(" - ");

    	$('input[name=start_date]').val(dates[0]).trigger('change');
    	$('input[name=end_date]').val(dates[1]).trigger('change');
    });

	$("#meeting_type_{{ $insurance->meeting_type_id }}").prop('checked', true).trigger('change');

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
        socket.emit('insurance', {
            id: {{ $insurance->id }},
            name: $(this).attr('name'),
            value: $(this).attr('type') == 'checkbox' ? ($(this).prop('checked') ? 1 : 0) : $(this).val(),
            user: '{{ Cookie::get('api_token') }}'
        });
        console.log('changed');
    });
});
</script>
@endpush
