@extends('layouts.app')
@include('plugins.moment')
@include('plugins.daterangepicker')
@include('plugins.datatables')

@section('content')
@include('components.msg-disconnected')
<!-- START BREADCRUMB -->
<div class="jumbotron" data-pages="parallax">
	<div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
		<div class="inner" style="transform: translateY(0px); opacity: 1;">
			{{ Breadcrumbs::render('fund') }}
			<!-- END BREADCRUMB -->
			<div class="row">
				<div class="col-xl-12 col-lg-12 ">
					<!-- START card -->
					<div class="card card-transparent">
						<div class="card-block p-t-0">
							<h3 class='m-t-0'> Borang Permohonan Kutipan Dana dan Wang di Bawah Seksyen 50 A Akta Kesatuan Sekerja 1959</h3>
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

<!-- START CONTAINER FLUID -->
@include('components.msg-connecting')
<div class=" container-fluid container-fixed-lg bg-white">
	<!-- START card -->
	<div class="card card-transparent">
		<div class="card-block">
			<div class="form-horizontal" role="form" autocomplete="off" method="post" action="#">
				<form id="form-fund" class="form-horizontal" role="form" autocomplete="off" method="post" action="#">
	        		@component('components.bs.label', [
						'name' => 'uname',
						'label' => 'Nama Kesatuan',
					])
					{{ $fund->tenure->entity->name }}
					@endcomponent

					@component('components.bs.label', [
						'label' => 'Alamat Ibu Pejabat',
					])
					{!! $fund->address->address1.
					($fund->address->address2 ? ',<br>'.$fund->address->address2 : '').
					($fund->address->address3 ? ',<br>'.$fund->address->address3 : '').
					',<br>'.
					$fund->address->postcode.' '.
					($fund->address->district ? $fund->address->district->name : '').', '.
					($fund->address->state ? $fund->address->state->name : '') !!}
					@endcomponent

					<div class="form-group row">
						<label for="fname" class="col-md-3 control-label">Cawangan
							<span style="color:red;">*</span>
						</label>
						<div class="col-md-9">
							<select id="multi" name="branches" class="full-width autoscroll" data-init-plugin="select2" required multiple>
								<option 
								@if($fund->branches()->whereNull('branch_id')->count() > 0)
									selected
								@endif
								value="-1" >Induk - {{ $fund->tenure->entity->name }}</option>
								@foreach($fund->tenure->entity->branches as $branch)
								<option
								@if($fund->branches->where('branch_id', $branch->id)->count() > 0)
									selected
								@endif
								value="{{ $branch->id }}">{{ $branch->name }}</option>
								@endforeach
							</select>
						</div>
					</div>

					@include('components.bs.textarea', [
						'name' => 'objective',
						'label' => 'Tujuan Kutipan',
						'mode' => 'required',
						'value' => $fund->objective,
					])

					<div class="form-group row">
						<label for="target_amount" class="col-md-3 control-label">
							Jumlah sasaran wang yang dirancang
							<span style="color:red;">*</span>
						</label>
						<div class="col-md-9">
							<div class="input-group">
		                      	<span class="input-group-addon default">
		                          	RM
		                      	</span>
								<input type="text" data-a-dec="." data-a-sep="," class="autonumeric form-control decimal" name="target_amount" value="{{ $fund->target_amount }}" required>
							</div>
						</div>
					</div>

					<div class="form-group row">
						<label for="estimated_expenses" class="col-md-3 control-label">
							Jumlah anggaran perbelanjaan aktiviti yang dirancang
							<span style="color:red;">*</span>
						</label>
						<div class="col-md-9">
							<div class="input-group">
		                      	<span class="input-group-addon default">
		                          	RM
		                      	</span>
								<input name="estimated_expenses" type="text" data-a-dec="." data-a-sep="," class="autonumeric form-control decimal" value="{{ $fund->estimated_expenses }}" required>
							</div>
						</div>
					</div>

					<div class="form-group row">
						<label for="fname" class="col-md-3 control-label">Tempoh Kutipan Wang yang akan dilakukan
							<i style="cursor: help; color: #48B0F7;" class="fa fa-question-circle" data-html="true" data-toggle="tooltip" title="Tidak melebihi 6 bulan"></i>
						</label>
						<div class="col-md-9">
							<div class="input-prepend input-group">
		                      	<span class="add-on input-group-addon">
		                      		<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
		                      	</span>
		                      	<input type="hidden" name="start_date" value="{{ $fund->start_date ? date('d/m/Y', strtotime($fund->start_date)) : '' }}">
		                      	<input type="hidden" name="end_date" value="{{ $fund->end_date ? date('d/m/Y', strtotime($fund->end_date)) : '' }}">
		                      	<input type="text" style="width: 100%" name="daterange" class="form-control" value="{{ $fund->start_date && $fund->end_date ? date('d/m/Y', strtotime($fund->start_date)).' - '.date('d/m/Y', strtotime($fund->end_date)) : '' }}" />
		                    </div>
						</div>
					</div>

					<div class="form-group row">
						<label for="" class="col-md-3 control-label">
							Kelulusan kutipan wang melalui<span style="color:red;">*</span>
						</label>
						<div class="col-md-9">
							<div class="radio radio-primary">
								@foreach($meeting_types as $meeting_type)
									<input name="meeting_type_id" value="{{ $meeting_type->id }}" id="meeting_type_{{ $meeting_type->id }}" type="radio" class="hidden" onchange="meetingType({{ $meeting_type->id }})" required>
									<label for="meeting_type_{{ $meeting_type->id }}">{{ $meeting_type->name }}</label>
								@endforeach
							</div>
						</div>
					</div>

					@include('components.bs.date', [
						'name' => 'resolved_at',
						'label' => 'Tarikh Mesyuarat',
						'mode' => 'required',
						'value' =>  $fund->resolved_at ? date('d/m/Y', strtotime($fund->resolved_at)) : '',
					])

					<!-- if pilih jenis Mesyuarat Agung letak AHLI. If Persidangan Perwakilan letak WAKIL-->
					@include('components.bs.input', [
						'name' => 'quorum',
						'label' => 'Jumlah kehadiran Ahli/Wakil',
						'mode' => 'required',
						'class' => 'numeric',
						'value' => $fund->quorum,
					])

					@include('components.bs.textarea', [
						'name' => 'method',
						'label' => 'Cara dana/wang dipungut',
						'mode' => 'required',
						'info' => 'Contoh: Derma, jualan iklan/meja, jualan tiket dan lain-lain',
						'value' => $fund->method,
					])

				</form>

				<div class="form-group row">
					<label for="participant" class="col-md-3 control-label">
						Adakah seseorang yang bukan ahli kesatuan ataupun dari agensi luar terlibat dalam organisasi pungutan wang itu?
						<span style="color:red;">*</span>
					</label>
					<div class="col-md-9">
						<div class="radio radio-primary">
							<input name="participant" value="1" id="participant_yes" type="radio" class="hidden" onchange="participantCheck()">
							<label for="participant_yes">Ya</label>

							<input name="participant" value="2" id="participant_no" type="radio" class="hidden" onchange="participantCheck()">
							<label for="participant_no">Tidak</label>
						</div>
						<br>
						@include('finance.fund.id1.participant.index')
					</div>
				</div>

				@include('finance.fund.id1.collection.index')

				@include('finance.fund.id1.bank.index')

				<br>

				<div class="form-group">
					<button type="button" class="btn btn-default mr-1" onclick="location.href='{{ route('fund.form', $fund->id) }}'"><i class="fa fa-angle-left mr-1"></i> Kembali</button>
					<button type="button" class="btn btn-info pull-right" onclick="save()" data-dismiss="modal"><i class="fa fa-check mr-1"></i> Simpan</button>
				</div>

			</div>
    	</div>
    </div>
</div>
@endsection

@push('js')
<script type="text/javascript">

	$("#form-fund").validate();

	function save() {
		swal({
			title: "Berjaya!",
			text: "Data yang telah disimpan.",
			icon: "success",
			button: "OK",
		})
		.then((confirm) => {
			if (confirm) {
				location.href="{{ route('fund.form', $fund->id) }}";
			}
		});
	}

	function participantCheck() {
		var participant = $('input[name="participant"]:checked').val();

		if(participant == 1) {
            $(".agency").slideDown();
		 }

		 else if(participant == 2) {
            $(".agency").slideUp();
		 }
	}

	function meetingType(id) {
		if(id == 2)
			$("#label_quorum").html("Jumlah kehadiran Ahli");
		else {
			$("#label_quorum").html("Jumlah kehadiran Wakil");
		}
	}

	$(document).ready(function() {
		$('input[name=daterange]').daterangepicker({
	        format: 'DD/MM/YYYY',
	        language: 'ms',
	    });

	    $('input[name=daterange]').on('apply.daterangepicker', function() {
	    	var dates = $(this).val().split(" - ");

	    	$('input[name=start_date]').val(dates[0]).trigger('change');
	    	$('input[name=end_date]').val(dates[1]).trigger('change');
	    });

		$("#meeting_type_{{ $fund->meeting_type_id }}").prop('checked', true).trigger('change');

		$("#participant_{{ $fund->participants ? 'yes' : 'no' }}").prop('checked', true).trigger('change');

		@if($fund->participants->count() > 0)
			$("#participant_yes").prop('checked', true).trigger('change');
		@else
			$("#participant_no").prop('checked', true).trigger('change');
		@endif

	    var socket = io('{{ env('SOCKET_HOST', '127.0.0.1') }}:{{ env('SOCKET_PORT', 3000) }}');

	    socket.on('connect', function() {
	        $(".msg-disconnected").slideUp();
	        $(".msg-connecting").slideUp();
	    });

	    socket.on('disconnect', function() {
	        $(".msg-disconnected").slideDown();
	        $("html, body").animate({ scrollTop: 0 }, 500);
	    });

	    $('#form-fund input, #form-fund select, #form-fund textarea').on('change', function() {
	        socket.emit('fund', {
	            id: {{ $fund->id }},
	            name: $(this).attr('name'),
	            value: $(this).attr('type') == 'checkbox' ? ($(this).prop('checked') ? 1 : 0) : $(this).val(),
            	user: '{{ Cookie::get('api_token') }}'
	        });
	        console.log('changed');
	    });
	});

</script>
@endpush
