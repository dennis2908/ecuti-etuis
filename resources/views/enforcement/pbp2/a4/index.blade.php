@extends('layouts.app')
@include('plugins.datatables')

@push('css')
<style type="text/css">
.modal-open .select2-container {
        z-index: unset !important;
    }
</style>
@endpush

@section('content')
@include('components.msg-disconnected')
<!-- START BREADCRUMB -->
<div class="jumbotron" data-pages="parallax">
	<div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
		<div class="inner" style="transform: translateY(0px); opacity: 1;">
			{{ Breadcrumbs::render('enforcement.pbp2') }}
			<!-- END BREADCRUMB -->
			<div class="row">
				<div class="col-xl-12 col-lg-12 ">
					<!-- START card -->
					<div class="card card-transparent">
						<div class="card-block p-t-0">
							<h5>Maklumat <span class="semi-bold">Pekerja Kesatuan</span></h5>
							<p class="small hint-text m-t-5">
								Lampiran A4
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
<div class=" container-fluid container-fixed-lg bg-white">
	<!-- START card -->
	<div class="card card-transparent">
		<div class="card-block">
			<form id="form-a4" class="form-horizontal" role="form" autocomplete="off" method="post" action="#">
				@include('components.bs.input', [
					'name' => 'name',
					'label' => 'Nama',
					'mode' => 'required',
					'value' => $a4->name
				])
				<div class="form-group row">
					<label for="" class="col-md-3 control-label">
						Jawatan <span style="color:red;">*</span>
					</label>
					<div class="col-md-9">
						<select class="full-width" data-init-plugin="select2" name="designation_id" id="designation_id">
							<option value="" selected="" disabled="">Pilih Satu...</option>
							@foreach($designations as $designation)
							<option value="{{ $designation->id }}">{{ $designation->name }}</option>
							@endforeach
						</select>
					</div>
				</div>
				
				@include('components.bs.date', [
					'name' => 'appointed_date',
					'label' => 'Tarikh Pelantikan',
					'mode' => 'required',
					'value' => $a4->appointed_at ? date('d/m/Y', strtotime($a4->appointed_at)) : date('d/m/Y')
				])
			</form>
			@include('enforcement.pbp2.a4.allowance.index')
			@include('enforcement.pbp2.a4.incentive.index')
			<br>

			<div class="form-group">
				<button type="button" class="btn btn-default mr-1" ><i class="fa fa-angle-left mr-1"></i> Kembali</button>
				<button type="button" class="btn btn-info pull-right" onclick="saveData()" data-dismiss="modal"><i class="fa fa-check mr-1"></i> Simpan</button>
			</div>
    	</div>
    </div>
</div>

@endsection

@push('js')
<script type="text/javascript">

$("#form-a4").validate();

function save() {
    swal({
        title: "Berjaya!",
        text: "Data yang telah disimpan.",
        icon: "success",
        button: "OK",
    })
    .then((confirm) => {
        if (confirm) {
            location.href="{{ route('pbp2.a4', request()->id) }}";
        }
    });
}

@if(!request()->id)
    window.history.pushState('a4', 'Lampiran A4', '{{ fullUrl() }}/{{ $a4->id }}');
@endif

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

	$('input[type=text], input[type=email], input[type=radio], input[type=checkbox], select, textarea').on('change', function() {
		socket.emit('enforcement_a4', {
			id: {{ $a4->id }},
        	name: $(this).attr('name'),
			value: $(this).attr('type') == 'checkbox' ? ($(this).prop('checked') ? 1 : 0) : $(this).val(),
			user: '{{ Cookie::get('api_token') }}'
		});
		console.log('changed');
	});

	@if($a4->designation_id)
	$("#designation_id").val( {{ $a4->designation_id }} ).trigger('change');
	@endif

});

</script>
@endpush