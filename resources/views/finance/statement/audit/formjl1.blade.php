@extends('layouts.app')
@include('plugins.datatables')

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
			{{ Breadcrumbs::render('statement.audit') }}
			<!-- END BREADCRUMB -->
			<div class="row">
				<div class="col-xl-12 col-lg-12 ">
					<!-- START card -->
					<div class="card card-transparent">
						<div class="card-block p-t-0">
							<h3 class='m-t-0'>Permohonan Kelulusan Juru Audit Luar (Borang JL1) </h3>
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
@include('components.msg-connecting')
<!-- START CONTAINER FLUID -->
<!-- START CONTAINER FLUID -->
<div class=" container-fluid container-fixed-lg bg-white">
	<!-- START card -->
	<div class="card card-transparent">
		<div class="card-block">
			<form id="form-auditor" class="form-horizontal" role="form" autocomplete="off" method="post" action="#">

				@component('components.bs.label', [
					'name' => 'uname',
					'label' => 'Nama Kesatuan',
				])
				{{ $auditor->tenure->entity->name }}
				@endcomponent

				@component('components.bs.label', [
					'label' => 'No Pendaftaran Kesatuan',
				])
				{{ $auditor->tenure->entity->registration_no }}
				@endcomponent

				@include('components.bs.input', [
					'name' => 'firm_name',
					'label' => 'Nama Penuh Firma',
					'mode' => 'required',
					'value' => $auditor->firm_name
				])

				@include('components.bs.input', [
					'name' => 'firm_registration_no',
					'label' => 'No Pendaftaran Firma',
					'mode' => 'required',
					'value' => $auditor->firm_registration_no
				])

				@include('components.bs.input', [
					'name' => 'auditor_name',
					'label' => 'Nama Penuh Juruaudit',
					'mode' => 'required',
					'value' => $auditor->auditor_name
				])

				@include('components.bs.input', [
					'name' => 'auditor_identification_no',
					'label' => 'No Kad Pengenalan',
					'mode' => 'required',
                    'options' => 'maxlength=12 minlength=12',
                    'class' => 'numeric',
					'info' => 'No KP yang sama boleh 3 tahun berturut-turut sahaja',
					'value' => $auditor->auditor_identification_no
				])

				<div class="form-group row">
					<label class="col-md-3 control-label">
						Alamat Firma <span style="color:red;">*</span>
					</label>
					<div class="col-md-9">
						<input class="form-control m-t-5" name="address1" type="text" value="{{ $auditor->firm_address->address1 or '' }}" required>
						<input class="form-control m-t-5" name="address2" type="text" value="{{ $auditor->firm_address->address2 or '' }}">
						<input class="form-control m-t-5" name="address3" type="text" value="{{ $auditor->firm_address->address3 or '' }}">
						<div class="row address">
							<div class="col-md-2 m-t-5">
								<input class="form-control numeric postcode" name="postcode" aria-required="true" type="text" value="{{ $auditor->firm_address->postcode or '' }}" required placeholder="Poskod" minlength="5" maxlength="5">
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
			</form>

			@include('finance.statement.audit.year.index')

			<br>

			<div class="form-group">
				<button type="button" class="btn btn-default mr-1" onclick="location.href='{{ route('statement.audit.form', $auditor->id) }}'"><i class="fa fa-angle-left mr-1"></i> Kembali</button>
				<button type="button" class="btn btn-info pull-right" onclick="save()"><i class="fa fa-check mr-1"></i> Simpan</button>
			</div>

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
            location.href="{{ route('statement.audit.form', $auditor->id) }}";
        }
    });
}

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

    $('#form-auditor input, #form-auditor select, #form-auditor textarea').on('change', function() {
        socket.emit('formjl1', {
            id: {{ $auditor->id }},
            name: $(this).attr('name'),
            value: $(this).attr('type') == 'checkbox' ? ($(this).prop('checked') ? 1 : 0) : $(this).val(),
            user: '{{ Cookie::get('api_token') }}'
        });
        console.log('changed');
    });

    @if($auditor->firm_address->state_id)
		$("#state_id").val({{ $auditor->firm_address->state_id }}).trigger('change');
	@endif

	@if($auditor->firm_address->district_id)
		setTimeout(function() {
			$("#district_id").val({{ $auditor->firm_address->district_id }}).trigger('change');
		}, 1000);
	@endif

});

	
</script>
@endpush