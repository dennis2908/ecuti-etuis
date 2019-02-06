@extends('layouts.app')
@include('plugins.dropzone')

@section('content')
@include('components.msg-disconnected')
<!-- START BREADCRUMB -->
<div class="jumbotron" data-pages="parallax">
	<div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
		<div class="inner" style="transform: translateY(0px); opacity: 1;">
			<!-- START BREADCRUMB -->
			{{ Breadcrumbs::render('formk.k1') }}
			<!-- END BREADCRUMB -->
			<div class="row">
				<div class="col-xl-12 col-lg-12 ">
					<!-- START card -->
					<div class="card card-transparent">
						<div class="card-block p-t-0">
							<h3 class='m-t-0'>Borang K - Permohonan Bagi Pendaftaran Peraturan Baru Atau Perubahan Peraturan</h3>
							<p class="small hint-text m-t-5">
								AKTA KESATUAN SEKERJA, 1959 (Seksyen 38 (3) dan Peraturan 16)
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
				<form id="form-formk" class="form-horizontal" role="form" autocomplete="off" method="post" action="#">
					@component('components.bs.label', [
						'label' => 'Nama Kesatuan Sekerja',
					])
					{{ $formk->tenure->entity->name }}
					@endcomponent

					@component('components.bs.label', [
						'label' => 'No. Sijil Pendaftaran',
					])
					{{ $formk->tenure->entity->registration_no }}
					@endcomponent

					@component('components.bs.label', [
						'label' => 'Alamat Ibu Pejabat',
					])
					{!! $formk->address->address1.
					($formk->address->address2 ? ',<br>'.$formk->address->address2 : '').
					($formk->address->address3 ? ',<br>'.$formk->address->address3 : '').
					',<br>'.
					$formk->address->postcode.' '.
					($formk->address->district ? $formk->address->district->name : '').', '.
					($formk->address->state ? $formk->address->state->name : '') !!}
					@endcomponent

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
						'value' =>  $formk->resolved_at ? date('d/m/Y', strtotime($formk->resolved_at)) : '',
					])

					@include('components.bs.date', [
						'name' => 'concluded_at',
						'label' => 'Tarikh Kelulusan Keputusan Undi',
						'mode' => 'required',
						'value' =>  $formk->concluded_at ? date('d/m/Y', strtotime($formk->concluded_at)) : '',
					])

					@include('components.bs.date', [
						'name' => 'applied_at',
						'label' => 'Tarikh Permohonan',
						'mode' => 'required',
						'value' =>  $formk->applied_at ? date('d/m/Y', strtotime($formk->applied_at)) : date('d/m/Y'),
					])

					<div class="form-group">
						<button type="button" class="btn btn-default mr-1" onclick="location.href='{{ route('formk.form', $formk->id) }}'"><i class="fa fa-angle-left mr-1"></i> Kembali</button>
						<button type="button" class="btn btn-info pull-right" onclick="save()"><i class="fa fa-check mr-1"></i> Simpan</button>
					</div>
				</form>
			</div>
    	</div>
    </div>
</div>
@endsection

@push('js')
<script type="text/javascript">

$("#form-formk").validate();

function save() {
    swal({
        title: "Berjaya!",
        text: "Data yang telah disimpan.",
        icon: "success",
        button: "OK",
    })
    .then((confirm) => {
        if (confirm) {
            location.href="{{ route('formk.form', $formk->id) }}";
        }
    });
}

$(document).ready(function(){
	$("#meeting_type_{{ $formk->meeting_type_id }}").prop('checked', true).trigger('change');

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
        socket.emit('formk', {
            id: {{ $formk->id }},
            name: $(this).attr('name'),
            value: $(this).attr('type') == 'checkbox' ? ($(this).prop('checked') ? 1 : 0) : $(this).val(),
            user: '{{ Cookie::get('api_token') }}'
        });
        console.log('changed');
    });
});

</script>
@endpush
