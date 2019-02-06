@extends('layouts.app')
@include('plugins.dropzone')
@include('plugins.daterangepicker')

@push('css')
<style>
.form-horizontal .form-group {
    border-bottom: unset !important;
}

span.clickable { cursor: pointer; }
</style>
@endpush

@section('content')
@include('components.msg-disconnected')
<!-- START BREADCRUMB -->
<div class="jumbotron" data-pages="parallax">
	<div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
		<div class="inner" style="transform: translateY(0px); opacity: 1;">
			{{ Breadcrumbs::render('pp68') }}
			<!-- END BREADCRUMB -->
			<div class="row">
				<div class="col-xl-12 col-lg-12 ">
					<!-- START card -->
					<div class="card card-transparent">
						<div class="card-block p-t-0">
							<h3 class='m-t-0'>Pengecualian Peraturan 68, Peraturan-Peraturan Kesatuan Sekerja 1959</h3>
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
				<form id="form-pp68" class="form-horizontal" role="form" autocomplete="off" method="post" action="#">
	        		@component('components.bs.label', [
						'label' => 'Nama Kesatuan Sekerja',
					])
					{{ $exception->tenure->entity->name }}
					@endcomponent

					@component('components.bs.label', [
						'label' => 'No Sijil Pendaftaran',
					])
					{{ $exception->tenure->entity->registration_no }}
					@endcomponent

					@component('components.bs.label', [
                        'label' => 'Alamat Ibu Pejabat',
                    ])
                    {!! $exception->address->address1.
                    ($exception->address->address2 ? ',<br>'.$exception->address->address2 : '').
                    ($exception->address->address3 ? ',<br>'.$exception->address->address3 : '').
                    ',<br>'.
                    $exception->address->postcode.' '.
                    ($exception->address->district ? $exception->address->district->name : '').', '.
                    ($exception->address->state ? $exception->address->state->name : '') !!}
                    @endcomponent

					<div class="form-group row">
						<label for="fname" class="col-md-3 control-label">
							<div class="checkbox check-success mt-0">
								<input value="1" id="is_fee_excepted" name="is_fee_excepted" type="checkbox" class="hidden">
								<label for="is_fee_excepted">Pengecualian daripada menyelenggarakan Buku Daftar Yuran mengikut format AP 3</label>
							</div>
						</label>
						<div class="col-md-9">
							Dokumen Sokongan:
							<ul>
								<li>Salinan penyata gaji terkini untuk tiga (3) orang ahli</li>
								<li>Salinan senarai potongan gaji</li>
							</ul>
							Justifikasi:
							<textarea id="justification_fee" name="justification_fee" style="height: 150px;" placeholder="" class="form-control" required>{{ $exception->justification_fee }}</textarea>
						</div>
					</div>

					<div class="form-group row">
						<label for="fname" class="col-md-3 control-label">
							<div class="checkbox check-success mt-0">
								<input value="1" id="is_receipt_excepted" name="is_receipt_excepted" type="checkbox" class="hidden">
								<label for="is_receipt_excepted">Pengecualian mengeluarkan resit rasmi kepada ahli yang membayar yuran bulanan melalui potongan gaji</label>
							</div>
						</label>
						<div class="col-md-9">
							Dokumen Sokongan:
							<ul>
								<li>Salinan penyata gaji terkini untuk tiga (3) orang ahli</li>
								<li>Salinan senarai potongan gaji</li>
							</ul>
							Justifikasi:
							<textarea id="justification_receipt" name="justification_receipt" style="height: 150px;" placeholder="" class="form-control" required>{{ $exception->justification_receipt }}</textarea>
						</div>
					</div>

					<div class="form-group row">
						<label for="fname" class="col-md-3 control-label">
							<div class="checkbox check-success mt-0">
								<input value="1" id="is_computer_excepted" name="is_computer_excepted" type="checkbox" class="hidden">
								<label for="is_computer_excepted">Pengecualian daripada menyelenggarakan Buku Tunai mengikut format AP.1 secara manual kepada berkomputer</label>
							</div>
						</label>
						<div class="col-md-9">
							Dokumen Sokongan:
							<ul>
								<li>Salinan cetakan Buku Tunai mengikut format AP.1 yang terkini dan dikemaskini</li>
							</ul>
							Justifikasi:
							<textarea id="justification_computer" name="justification_computer" style="height: 150px;" placeholder="" class="form-control" required>{{ $exception->justification_computer }}</textarea>
						</div>
					</div>

					<div class="form-group row">
						<label for="fname" class="col-md-3 control-label">
							<div class="checkbox check-success mt-0">
								<input value="1" id="is_system_excepted" name="is_system_excepted" type="checkbox" class="hidden">
								<label for="is_system_excepted">Pengecualian daripada menyelenggarakan Buku Tunai mengikut format AP.1 digantikan dengan sistem perakaunan</label>
							</div>
						</label>
						<div class="col-md-9">
							Dokumen Sokongan:
							<ul>
								<li>Salinan cetakan sistem perakaunan yang terkini</li>
							</ul>
							Justifikasi:
							<textarea id="justification_system" name="justification_system" style="height: 150px;" placeholder="" class="form-control" required>{{ $exception->justification_system }}</textarea>
						</div>
					</div>
				</form>
				<br>

				<div class="form-group">
					<button type="button" class="btn btn-default mr-1" onclick="location.href='{{ route('pp68.item', $exception->id) }}'"><i class="fa fa-angle-left mr-1"></i> Kembali</button>
					<button type="button" class="btn btn-info pull-right" onclick="save()"><i class="fa fa-check mr-1"></i> Simpan</button>
				</div>

			</div>
    	</div>
    </div>
</div>
@endsection

@push('js')
<script>
$("#form-pp68").validate();

$('input').on('click', function(){
    if(this.checked)
    	$(this).val(1).trigger('change');
    else
    	$(this).val(0).trigger('change');
});

function save() {
	swal({
		title: "Berjaya!",
		text: "Data yang telah disimpan.",
		icon: "success",
		button: "OK",
	})
	.then((confirm) => {
		if (confirm) {
			location.href="{{ route('pp68.item', $exception->id) }}";
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

	$('input, select, textarea').on('change', function() {
		socket.emit('pp68', {
			id: {{ $exception->id }},
			name: $(this).attr('name'),
			value: $(this).attr('type') == 'checkbox' ? ($(this).prop('checked') ? 1 : 0) : $(this).val(),
			user: '{{ Cookie::get('api_token') }}'
		});
		console.log('changed');
	});

    @if($exception->is_fee_excepted == 1)
        $("#is_fee_excepted").prop('checked', true).trigger('change');
    @endif

	@if($exception->is_receipt_excepted == 1)
        $("#is_receipt_excepted").prop('checked', true).trigger('change');
    @endif

	@if($exception->is_computer_excepted == 1)
		$("#is_computer_excepted").prop('checked', true).trigger('change');
	@endif

	@if($exception->is_system_excepted == 1)
		$("#is_system_excepted").prop('checked', true).trigger('change');
	@endif
});
</script>
@endpush
