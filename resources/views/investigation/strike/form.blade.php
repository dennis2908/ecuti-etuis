@extends('layouts.app')
@include('plugins.datatables')

@push('css')
<style>
.form-horizontal .form-group {
    border-bottom: unset !important;
}
</style>
@endpush

@push('css')
<style type="text/css">
.modal-open .select2-container {
    z-index: 1039 !important;
}
</style>
@endpush

@section('content')
@include('components.msg-disconnected')
<!-- START BREADCRUMB -->
<div class="jumbotron" data-pages="parallax">
	<div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
		<div class="inner" style="transform: translateY(0px); opacity: 1;">
			{{ Breadcrumbs::render('strike') }}
			<!-- END BREADCRUMB -->
			<div class="row">
				<div class="col-xl-12 col-lg-12 ">
					<!-- START card -->
					<div class="card card-transparent">
						<div class="card-block p-t-0">
							<h3 class='m-t-0'>Mogok</h3>
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

<!-- START CONTAINER FLUID -->
@include('components.msg-connecting')
<div class=" container-fluid container-fixed-lg bg-white">
	<!-- START card -->
	<div class="card card-transparent">
		<div class="card-block">
			<div>
				<form id="form-strike" class="form-horizontal" role="form" autocomplete="off" method="post" action="#">

					@component('components.bs.label', [
    					'label' => 'Nama Kesatuan',
    				])
    				{{ $strike->tenure->entity->name }}
    				@endcomponent

					@component('components.bs.label', [
						'label' => 'Alamat Kesatuan Sekerja',
					])
					{!! $strike->address->address1.
					($strike->address->address2 ? ',<br>'.$strike->address->address2 : '').
					($strike->address->address3 ? ',<br>'.$strike->address->address3 : '').
					',<br>'.
					$strike->address->postcode.' '.
					($strike->address->district ? $strike->address->district->name : '').', '.
					($strike->address->state ? $strike->address->state->name : '') !!}
					@endcomponent

					@include('components.bs.input', [
						'name' => 'employer',
						'label' => 'Nama Majikan',
						'mode' => 'required',
						'value' => $strike->employer
					])

					<div class="form-group row">
						<label class="col-md-3 control-label">
							Alamat Majikan <span style="color:red;">*</span>
						</label>
						<div class="col-md-9">
							<input class="form-control m-t-5" name="address1" type="text" value="{{ $strike->employer_address->address1 }}" required>
							<input class="form-control m-t-5" name="address2" type="text" value="{{ $strike->employer_address->address2 }}">
							<input class="form-control m-t-5" name="address3" type="text" value="{{ $strike->employer_address->address3 }}">
							<div class="row address">
								<div class="col-md-2 m-t-5">
									<input class="form-control numeric postcode" name="postcode" aria-required="true" type="text" value="{{ $strike->employer_address->postcode }}" required placeholder="Poskod" minlength="5" maxlength="5">
								</div>
								<div class="col-md-5 m-t-5">
									<select id="state_id" name="state_id" class="full-width autoscroll state" data-init-plugin="select2" required="">
	                                    <option value="" selected="" disabled="">Pilih Negeri</option>
	                                    @foreach($states as $index => $state)
	                                    <option value="{{ $state->id }}">{{ $state->name }}</option>
	                                    @endforeach
	                                </select>
								</div>
								<div class="col-md-5 m-t-5">
									<select id="district_id" name="district_id" class="full-width autoscroll district" data-init-plugin="select2" required="">
	                                </select>
								</div>
							</div>
						</div>
					</div>

					@include('components.bs.textarea', [
						'name' => 'address_strike',
						'label' => 'Alamat dimana Mogok diadakan',
						'mode' => 'required',
						'value' => $strike->address_strike,
					])

	        		@include('investigation.strike.period.index')

					<div class="form-group row">
						<label for="fname" class="col-md-3 control-label">
								Senarai pegawai KS yang boleh dihubungi <span style="color:red;">*</span>
						</label>
						<div class="col-md-9">
							<div class="form-group row p-t-0">
								<label for="fname" class="col-md-2 control-label">Presiden</label>
								<div class="input-group col-md-10">
			                      	<span class="input-group-addon default">
			                          	Nama
			                      	</span>
									<input type="text" class="form-control" value="{{ $strike->tenure->officers()->where('designation_id', 1)->firstOrFail()->name }}" readonly>
									<br>
									<span class="input-group-addon default">
			                          	No. Tel.
			                      	</span>
									<input name="phone_president" type="text" class="form-control" value="{{ $strike->phone_president }}" required>
								</div>
							</div>
							<div class="form-group row">
								<label for="fname" class="col-md-2 control-label">Setiausaha</label>
								<div class="input-group col-md-10">
			                      	<span class="input-group-addon default">
			                          	Nama
			                      	</span>
									<input type="text" class="form-control" value="{{ $strike->tenure->officers()->where('designation_id', 3)->firstOrFail()->name }}" readonly>
									<br>
									<span class="input-group-addon default">
			                          	No. Tel.
			                      	</span>
									<input name="phone_secretary" type="text" class="form-control" value="{{ $strike->phone_secretary }}" required>
								</div>
							</div>
							<div class="form-group row">
								<label for="fname" class="col-md-2 control-label">Bendahari</label>
								<div class="input-group col-md-10">
			                      	<span class="input-group-addon default">
			                          	Nama
			                      	</span>
									<input type="text" class="form-control" value="{{ $strike->tenure->officers()->where('designation_id', 5)->firstOrFail()->name }}" readonly>
									<br>
									<span class="input-group-addon default">
			                          	No. Tel.
			                      	</span>
									<input name="phone_treasurer" type="text" class="form-control" value="{{ $strike->phone_treasurer }}" required>
								</div>
							</div>
						</div>
					</div>

					<br>
					<div class="form-group">
						<button type="button" class="btn btn-default mr-1" onclick="location.href='{{ route('strike.form', $strike->id) }}'"><i class="fa fa-angle-left mr-1"></i> Kembali</button>
						<button type="button" class="btn btn-info pull-right" onclick="save()"><i class="fa fa-check mr-1"></i> Simpan</button>
					</div>
				</form>
			</div>
    	</div>
    </div>
</div>
@endsection

@push('js')
<script>
$("#form-strike").validate();

function save() {
	swal({
		title: "Berjaya!",
		text: "Data yang telah disimpan.",
		icon: "success",
		button: "OK",
	})
	.then((confirm) => {
		if (confirm) {
			location.href="{{ route('strike.form', $strike->id) }}";
		}
	});
}

$(document).ready(function() {
	$('.input-daterange input').datepicker({
		language: 'ms',
		format: 'dd/mm/yyyy',
		autoclose: true,
		onClose: function() {
			$(this).valid();
		},
	}).on('changeDate', function(){
		$(this).trigger('change');
	});

	var socket = io('{{ env('SOCKET_HOST', '127.0.0.1') }}:{{ env('SOCKET_PORT', 3000) }}');

	socket.on('connect', function() {
		$(".msg-disconnected").slideUp();
		$(".msg-connecting").slideUp();
	});

	socket.on('disconnect', function() {
		$(".msg-disconnected").slideDown();
        $("html, body").animate({ scrollTop: 0 }, 500);
	});

	$('#form-strike input, #form-strike select, #form-strike textarea').on('change', function() {
		socket.emit('strike', {
			id: {{ $strike->id }},
			name: $(this).attr('name'),
			value: $(this).attr('type') == 'checkbox' ? ($(this).prop('checked') ? 1 : 0) : $(this).val(),
			user: '{{ Cookie::get('api_token') }}'
		});
		console.log('changed');
	});

	@if($strike->employer_address->state)
	$("#state_id").val( {{ $strike->employer_address->state_id }} ).trigger('change');
	@endif

	@if($strike->employer_address->district)
	setTimeout(function() {
		$("#district_id").val( {{ $strike->employer_address->district_id }} ).trigger('change');
	}, 1000);
	@endif
});

</script>
@endpush
