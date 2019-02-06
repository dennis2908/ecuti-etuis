@extends('layouts.app')
@include('plugins.timepicker')

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
							<h3 class='m-t-0'>Borang Pengesahan Penerimaan - Perlantikan IO</h3>
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
				<form id="form-pdw02" class="form-horizontal" role="form" autocomplete="off" method="post" action="#">

					@include('components.bs.date', [
						'name' => 'applied_at',
						'label' => 'Tarikh Permohonan',
						'mode' => 'required',
						'value' => $pdw02->applied_at ? date('d/m/Y', strtotime($pdw02->applied_at)) : '',
					])

					<div class="form-group row">
                        <label for="fname" class="col-md-3 control-label">Pegawai Penyiasat yang dilantik
                            <span style="color:red;">*</span>
                        </label>
                        <div class="col-md-9">
							<select id="io_user_id" name="io_user_id" class="full-width autoscroll state" data-init-plugin="select2" required>
								<option value="" selected="" disabled="">Pilih satu..</option>
								@foreach($investigators as $investigator)
								<option value="{{ $investigator->id }}">{{ $investigator->name }}</option>
								@endforeach
							</select>
                        </div>
                    </div>

				</form>

				<br>
				<div class="form-group">
					<button type="button" class="btn btn-default mr-1" onclick="location.href='{{ route('prosecution.form', $prosecution->id) }}'"><i class="fa fa-angle-left mr-1"></i> Kembali</button>
					<button type="button" class="btn btn-info pull-right" onclick="submit()"><i class="fa fa-check mr-1"></i> Hantar</button>
				</div>
			</div>
    	</div>
    </div>
</div>
@endsection

@push('js')
<script>

$("#form-pdw02").validate();

// function save() {
// 	swal({
// 		title: "Berjaya!",
// 		text: "Data yang telah disimpan.",
// 		icon: "success",
// 		button: "OK",
// 	})
// 	.then((confirm) => {
// 		if (confirm) {
// 			location.href="{{ route('prosecution.form', $prosecution->id) }}";
// 		}
// 	});
// }

function submit() {
    swal({
        title: "Teruskan?",
        text: "Adakah anda pasti untuk menghantar borang ini?",
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
                url: '{{ route("prosecution.pdw02.form", $prosecution->id) }}',
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
                                location.href="{{ route('prosecution.form', $prosecution->id) }}";
                            }
                        });
                    }
                }
            });
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

	$('#form-pdw02 input, #form-pdw02 select, #form-pdw02 textarea').on('change', function() {
		socket.emit('pdw02', {
			id: {{ $pdw02->id }},
			name: $(this).attr('name'),
			value: $(this).attr('type') == 'checkbox' ? ($(this).prop('checked') ? 1 : 0) : $(this).val(),
			user: '{{ Cookie::get('api_token') }}'
		});
		console.log('changed');
	});
	
	@if($pdw02->io_user_id)
	$("#io_user_id").val( {{ $pdw02->io_user_id }} ).trigger('change');
	@endif
});
</script>
@endpush
