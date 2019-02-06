@extends('layouts.app')
@include('plugins.datatables')

@section('content')
@include('components.msg-disconnected')
<!-- START BREADCRUMB -->
<div class="jumbotron" data-pages="parallax">
	<div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
		<div class="inner" style="transform: translateY(0px); opacity: 1;">
			<!-- START BREADCRUMB -->
			{{ Breadcrumbs::render('formj.j1') }}
			<!-- END BREADCRUMB -->
			<div class="row">
				<div class="col-xl-12 col-lg-12 ">
					<!-- START card -->
					<div class="card card-transparent">
						<div class="card-block p-t-0">
							<h3 class='m-t-0'>Borang J - Notis Pertukaran Pejabat Suatu Kesatuan Sekerja Yang Didaftarkan</h3>
							<p class="small hint-text m-t-5">
								AKTA KESATUAN SEKERJA, 1959 (Seksyen 37(2) dan Peraturan 15)
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
			<div>
				<form id="form-formj" class="form-horizontal" role="form" autocomplete="off" method="post" action="#">
					@component('components.bs.label', [
						'label' => 'Nama Kesatuan Sekerja',
					])
					{{ $formj->tenure->entity->name }}
					@endcomponent

					@component('components.bs.label', [
						'label' => 'No. Sijil Pendaftaran',
					])
					{{ $formj->tenure->entity->registration_no }}
					@endcomponent

					@component('components.bs.label', [
						'label' => 'Alamat Ibu Pejabat',
					])
					{!! $formj->address->address1.
					($formj->address->address2 ? ',<br>'.$formj->address->address2 : '').
					($formj->address->address3 ? ',<br>'.$formj->address->address3 : '').
					',<br>'.
					$formj->address->postcode.' '.
					($formj->address->district ? $formj->address->district->name : '').', '.
					($formj->address->state ? $formj->address->state->name : '') !!}
					@endcomponent

					<div class="form-group row">
						<label class="col-md-3 control-label">
							Alamat Baru <span style="color:red;">*</span>
						</label>
						<div class="col-md-9">
							<input class="form-control m-t-5" name="address1" type="text" value="{{ $formj->new_address->address1 }}" required>
							<input class="form-control m-t-5" name="address2" type="text" value="{{ $formj->new_address->address2 }}">
							<input class="form-control m-t-5" name="address3" type="text" value="{{ $formj->new_address->address3 }}">
							<div class="row address">
								<div class="col-md-2 m-t-5">
									<input class="form-control numeric postcode" name="postcode" aria-required="true" type="text" value="{{ $formj->new_address->postcode }}" required placeholder="Poskod" minlength="5" maxlength="5">
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

					<div class="form-group row">
						<label class="col-md-3 control-label">
							Alamat Pejabat JHEKS Negeri / Wilayah<span style="color:red;">*</span>
						</label>
						<div class="col-md-9">
							<select id="province_office_id" name="province_office_id" class="full-width autoscroll state" data-init-plugin="select2" required="">
	                            <option value="" selected="" disabled="">Pilih Negeri</option>
	                            @foreach($offices as $index => $office)
	                            <option value="{{ $office->id }}">{{ $office->name }}</option>
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
						'value' =>  $formj->resolved_at ? date('d/m/Y', strtotime($formj->resolved_at)) : '',
					])

					<div class="form-group row">
	                    <label for="fname" class="col-md-3 control-label">Justifikasi
	                        <span style="color:red;">*</span>
	                    </label>
	                    <div class="col-md-9">
	                        <select class="full-width" data-init-plugin="select2" name="justification_id" id="justification_id">
	                            <option value="" selected="" disabled="">Pilih Satu...</option>
	                            @foreach($justifications as $justification)
	                            <option value="{{ $justification->id }}">{{ $justification->name }}</option>
	                            @endforeach
	                        </select>
	                    </div>
	                </div>

	                <div class="form-group row p-t-0">
						<label class="col-md-3 control-label"></label>
						<div class="col-md-9">
							<small><i>Jika justifikasi lain-lain, sila nyatakan:</i></small>
							<textarea id="justification_description" class="form-control m-t-10" name="justification_description" placeholder="" style="height: 100px;">{{ $formj->justification_description }}</textarea>
						</div>
					</div>

					@include('components.bs.date', [
						'name' => 'moved_at',
						'label' => 'Tarikh Pejabat Berpindah Ke Alamat Baru',
						'mode' => 'required',
						'value' =>  $formj->moved_at ? date('d/m/Y', strtotime($formj->moved_at)) : '',
					])

					<div class="form-group row">
						<label for="" class="col-md-3 control-label">
							Alamat Kesatuan Berdaftar<span style="color:red;">*</span>
						</label>
						<div class="col-md-9">
							<div class="radio radio-primary">
								@foreach($address_types as $address_type)
									<input name="address_type_id" value="{{ $address_type->id }}" id="address_type_{{ $address_type->id }}" type="radio" class="hidden" required>
									<label for="address_type_{{ $address_type->id }}">{{ $address_type->name }}</label>
								@endforeach
							</div>
						</div>
					</div>

					@include('components.bs.date', [
						'name' => 'applied_at',
						'label' => 'Tarikh Permohonan',
						'mode' => 'required',
						'value' =>  $formj->applied_at ? date('d/m/Y', strtotime($formj->applied_at)) : date('d/m/Y'),
					])

					<div class="form-group">
						<button type="button" class="btn btn-default mr-1" onclick="location.href='{{ route('formj.form', $formj->id) }}'"><i class="fa fa-angle-left mr-1"></i> Kembali</button>
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
$("#form-formj").validate();

function save() {
    swal({
        title: "Berjaya!",
        text: "Data yang telah disimpan.",
        icon: "success",
        button: "OK",
    })
    .then((confirm) => {
        if (confirm) {
            location.href="{{ route('formj.form', $formj->id) }}";
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

    $('input, select, textarea').on('change', function() {
        socket.emit('formj', {
            id: {{ $formj->id }},
            name: $(this).attr('name'),
            value: $(this).attr('type') == 'checkbox' ? ($(this).prop('checked') ? 1 : 0) : $(this).val(),
            user: '{{ Cookie::get('api_token') }}'
        });
        console.log('changed');
    });

    @if($formj->new_address->state)
	$("#state_id").val( {{ $formj->new_address->state_id }} ).trigger('change');
	@endif

	@if($formj->new_address->district)
	setTimeout(function() {
		$("#district_id").val( {{ $formj->new_address->district_id }} ).trigger('change');
	}, 1000);
	@endif

	@if($formj->province_office_id)
	$("#province_office_id").val( {{ $formj->province_office_id }} ).trigger('change');
	@endif

	$("#meeting_type_{{ $formj->meeting_type_id }}").prop('checked', true).trigger('change');

	@if($formj->justification_id)
	$("#justification_id").val( {{ $formj->justification_id }} ).trigger('change');
	@endif

	$("#address_type_{{ $formj->address_type_id }}").prop('checked', true).trigger('change');
});

</script>
@endpush
