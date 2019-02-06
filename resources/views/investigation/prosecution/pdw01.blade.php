@extends('layouts.app')

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
			{{ Breadcrumbs::render('prosecution') }}
			<!-- END BREADCRUMB -->
			<div class="row">
				<div class="col-xl-12 col-lg-12 ">
					<!-- START card -->
					<div class="card card-transparent">
						<div class="card-block p-t-0">
							<h3 class='m-t-0'>Memo Arahan Buka Kertas Siasatan</h3>
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
			<form id="form-pdw01" class="form-horizontal" role="form" autocomplete="off" method="post" action="">

        		@include('components.bs.input', [
					'name' => 'subject',
					'label' => 'Siasatan Terhadap',
					'mode' => 'required',
					'value' => $pdw01->subject,
				])

				<div class="form-group row">
                    <label for="fname" class="col-md-3 control-label">Kepada Pengarah Wilayah
                        <span style="color:red;">*</span>
                    </label>
                    <div class="col-md-9">
                        <select id="province_office_id" name="province_office_id" class="full-width autoscroll" data-init-plugin="select2" required>
							<option value="" selected="" disabled="">Pilih satu..</option>
							@foreach($provinces as $index => $province)
							<option value="{{ $province->id }}">{{ $province->name }}</option>
							@endforeach
						</select>
                    </div>
                </div>

				@component('components.bs.label', [
					'label' => 'Daripada',
				])
				 <div class="m-t-5">Pengarah Kanan Perundangan dan Penguatkuasaan</div>
				@endcomponent

				@include('components.bs.input', [
					'name' => 'report_reference_no',
					'label' => 'No. Rujukan Laporan Aduan',
					'mode' => 'required',
					'value' => $pdw01->report_reference_no,
				])

				@include('components.bs.date', [
					'name' => 'report_date',
					'label' => 'Tarikh Laporan Aduan',
					'mode' => 'required',
					'value' => $pdw01->report_date ? date('d/m/Y', strtotime($pdw01->report_date)) : date('d/m/Y')
				])

				@include('components.bs.textarea', [
					'name' => 'fault',
					'label' => 'Salahlaku / Pelanggaran',
					'mode' => 'required',
					'value' => $pdw01->fault,
				])

			</form>

			<br>
			<div class="form-group">
				<button type="button" class="btn btn-default mr-1" onclick="location.href='{{ route('prosecution.list') }}'"><i class="fa fa-angle-left mr-1"></i> Kembali</button>
				<button type="button" class="btn btn-info pull-right" onclick="submit()" data-dismiss="modal"><i class="fa fa-check mr-1"></i> Hantar</button>
            	<button type="button" class="btn btn-default pull-right mr-1" onclick="save()" data-dismiss="modal"><i class="fa fa-save mr-1"></i> Simpan</button>
			</div>
    	</div>
    </div>
</div>
@endsection
@push('js')
<script>
$("#form-pdw01").validate();

function save() {
	swal({
		title: "Berjaya!",
		text: "Data yang telah disimpan.",
		icon: "success",
		button: "OK",
	})
	.then((confirm) => {
		if (confirm) {
			location.href="{{ route('prosecution.list') }}";
		}
	});
}

function submit() {
    swal({
        title: "Teruskan?",
        text: "Adakah anda pasti untuk menghantar memo ini?",
        icon: "warning",
        buttons: {
            cancel: "Batal",
            confirm: {
                text: "Teruskan",
                value: "confirm",
                closeModal: false,
                className: "btn-info",
            },
        },
        dangerMode: true,
    })
    .then((confirm) => {
        if (confirm) {
            $.ajax({
                url: '{{ route("prosecution.pdw01.form", $prosecution->id) }}',
                method: 'POST',
                dataType: 'json',
                async: true,
                contentType: false,
                processData: false,
                success: function(data) {
                    if(data.status == 'error') {
                        swal(data.title, data.message, data.status);
                        $("html, body").animate({ scrollTop: 0 }, "slow");
                    }
                    else {
                        swal({
                            title: data.title,
                            text: data.message,
                            icon: data.status,
                            button: "OK",
                        })
                        .then((confirm) => {
                            if (confirm) {
                                location.href="{{ route('prosecution.list') }}";
                            }
                        });
                    }
                }
            });
        }
    });
}

@if(!request()->id)
    window.history.pushState('prosecution', 'Kertas Siasatan (Pendakwaan)', '{{ fullUrl() }}/{{ $prosecution->id }}/pdw01');
@endif

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

	$('#form-pdw01 input, #form-pdw01 select, #form-pdw01 textarea').on('change', function() {
		socket.emit('pdw01', {
			id: {{ $prosecution->id }},
			name: $(this).attr('name'),
			value: $(this).attr('type') == 'checkbox' ? ($(this).prop('checked') ? 1 : 0) : $(this).val(),
			user: '{{ Cookie::get('api_token') }}'
		});
		console.log('changed');
	});

	@if($pdw01->province_office_id)
	$("#province_office_id").val( {{ $pdw01->province_office_id }} ).trigger('change');
	@endif
});

</script>
@endpush
