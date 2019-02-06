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
							<h3 class='m-t-0'>Maklumat <span class="semi-bold">Elaun dan Insentif Pegawai Kesatuan</span></h3>
							<p class="small hint-text m-t-5">
								Lampiran A5(i)
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
			<form id="form-a3" class="form-horizontal" role="form" autocomplete="off" method="post" action="#">
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
			</form>
			
			@include('enforcement.pbp2.a3.allowance.index')
			@include('enforcement.pbp2.a3.incentive.index')

			<br>

			<div class="form-group">
				<button type="button" class="btn btn-default mr-1" ><i class="fa fa-angle-left mr-1"></i> Kembali</button>
				<button type="button" class="btn btn-info pull-right" onclick="save()"><i class="fa fa-check mr-1"></i> Simpan</button>
			</div>
    	</div>
    </div>
</div>

@endsection

@push('js')
<script type="text/javascript">

$("#form-a3").validate();

function save() {
    swal({
        title: "Berjaya!",
        text: "Data yang telah disimpan.",
        icon: "success",
        button: "OK",
    })
    .then((confirm) => {
        if (confirm) {
            location.href="{{ route('pbp2.a3.list', request()->id) }}";
        }
    });
}

@if(!request()->id)
    window.history.pushState('a3', 'Lampiran 3', '{{ fullUrl() }}/{{ $a3->id }}');
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
		socket.emit('enforcement_a3', {
			id: {{ $a3->id }},
        	name: $(this).attr('name'),
			value: $(this).attr('type') == 'checkbox' ? ($(this).prop('checked') ? 1 : 0) : $(this).val(),
        	user: '{{ Cookie::get('api_token') }}'
		});
		console.log('changed');
	});

	@if($a3->designation_id)
	$("#designation_id").val( {{ $a3->designation_id }} ).trigger('change');
	@endif

});

</script>
@endpush