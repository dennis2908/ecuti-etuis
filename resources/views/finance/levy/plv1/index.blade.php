@extends('layouts.app')
@include('plugins.dropzone')

@section('content')
@include('components.msg-disconnected')
<!-- START BREADCRUMB -->
<div class="jumbotron" data-pages="parallax">
	<div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
		<div class="inner" style="transform: translateY(0px); opacity: 1;">
			<!-- START BREADCRUMB -->
			{{ Breadcrumbs::render('levy') }}
			<!-- END BREADCRUMB -->
			<div class="row">
				<div class="col-xl-12 col-lg-12 ">
					<!-- START card -->
					<div class="card card-transparent">
						<div class="card-block p-t-0">
							<h3 class='m-t-0'>Borang Permohonan Pengenaan Levi (PLV 1)</h3>
							<p class="small hint-text m-t-5">
								Sila lengkapkan borang permohonan ini
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
				<form id="form-levy" class="form-horizontal" role="form" autocomplete="off" method="post" action="#">
	        		@component('components.bs.label', [
						'name' => 'uname',
						'label' => 'Nama Kesatuan',
					])
					{{ $levy->tenure->entity->name }}
					@endcomponent

					@component('components.bs.label', [
						'label' => 'Alamat Ibu Pejabat',
					])
					{!! $levy->address->address1.
					($levy->address->address2 ? ',<br>'.$levy->address->address2 : '').
					($levy->address->address3 ? ',<br>'.$levy->address->address3 : '').
					',<br>'.
					$levy->address->postcode.' '.
					($levy->address->district ? $levy->address->district->name : '').', '.
					($levy->address->state ? $levy->address->state->name : '') !!}
					@endcomponent

					<div class="form-group row">
						<label for="fname" class="col-md-3 control-label">Cawangan
							<span style="color:red;">*</span>
							@include('components.info', [
								'text' => 'Jika permohonan levi ini dibuat bagi maksud sesuatu cawangan sahaja',
							])
						</label>
						<div class="col-md-9">
							<select id="branch_id" name="branch_id" class="full-width autoscroll" data-init-plugin="select2" required>
								<option value="-1" selected>Induk - {{ $levy->tenure->entity->name }}</option>
								@foreach($levy->tenure->entity->branches as $branch)
								<option value="{{ $branch->id }}">{{ $branch->name }}</option>
								@endforeach
							</select>
						</div>
					</div>

					@include('components.bs.textarea', [
						'name' => 'objective',
						'label' => 'Ketetapan Pengenaan Levi',
						'mode' => 'required',
						'value' => $levy->objective,
					])

					<div class="form-group row">
						<label for="fname" class="col-md-3 control-label">
							Anggaran Kutipan Levi
							<span style="color:red;">*</span>
						</label>
						<div class="col-md-9">
							<div class="input-group">
		                      	<span class="input-group-addon default">
		                          	RM
		                      	</span>
								<input type="text" name="estimate" data-a-dec="." data-a-sep="," class="autonumeric form-control decimal" value="{{ $levy->estimate }}">
							</div>
						</div>
					</div>

					@include('components.bs.date', [
						'name' => 'applied_at',
						'label' => 'Tarikh Permohonan',
						'mode' => 'required',
						'value' =>  $levy->applied_at ? date('d/m/Y', strtotime($levy->applied_at)) : date('d/m/Y'),
					])

					<br>

					<div class="form-group">
						<button type="button" class="btn btn-default mr-1" onclick="location.href='{{ route('levy.form', $levy->id) }}'"><i class="fa fa-angle-left mr-1"></i> Kembali</button>
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
$("#form-levy").validate();

function save() {
    swal({
        title: "Berjaya!",
        text: "Data yang telah disimpan.",
        icon: "success",
        button: "OK",
    })
    .then((confirm) => {
        if (confirm) {
            location.href="{{ route('levy.form', $levy->id) }}";
        }
    });
}

$(document).ready(function(){
	$("#branch_id").val('{{ $levy->branch_id ? $levy->branch_id : '-1' }}').trigger('change');

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
        socket.emit('levy', {
            id: {{ $levy->id }},
            name: $(this).attr('name'),
            value: $(this).attr('type') == 'checkbox' ? ($(this).prop('checked') ? 1 : 0) : $(this).val(),
            user: '{{ Cookie::get('api_token') }}'
        });
        console.log('changed');
    });
});
</script>
@endpush
