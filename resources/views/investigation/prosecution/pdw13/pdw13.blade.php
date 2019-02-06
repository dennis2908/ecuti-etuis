@extends('layouts.app')
@include('plugins.datatables')

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
			{{ Breadcrumbs::render('prosecution') }}
			<!-- END BREADCRUMB -->
			<div class="row">
				<div class="col-xl-12 col-lg-12 ">
					<!-- START card -->
					<div class="card card-transparent">
						<div class="card-block p-t-0">
							<h3 class='m-t-0'>Fakta Kes</h3>
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
<form id="form-pdw13" class="form-horizontal" role="form" autocomplete="off" method="post" action="#">
@include('components.msg-connecting')
<div class=" container-fluid container-fixed-lg bg-white">
	<!-- START card -->
	<div class="card card-transparent">
		<div class="card-block">
			<div>
				@include('investigation.prosecution.pdw13.accused.index')

				<form id="form-pdw13" class="form-horizontal" role="form" autocomplete="off" method="post" action="#">

					@include('components.bs.date', [
						'name' => 'applied_at',
						'label' => 'Tarikh Permohonan',
						'mode' => 'required',
						'value' => $pdw13->applied_at ? date('d/m/Y', strtotime($pdw13->applied_at)) : '',
					])

					@include('components.bs.textarea', [
						'name' => 'facts',
						'label' => 'Fakta Kes',
						'mode' => 'required',
						'value' => $pdw13->facts,
					])
				</form>

				<br>
				<div class="form-group">
					<button type="button" class="btn btn-default mr-1" onclick="location.href='{{ route('prosecution.form', $prosecution->id) }}'"><i class="fa fa-angle-left mr-1"></i> Kembali</button>
					<button type="button" class="btn btn-info pull-right" onclick="submit()" data-dismiss="modal"><i class="fa fa-check mr-1"></i> Hantar</button>
				</div>
			</div>
    	</div>
    </div>
</div>
@endsection

@push('js')
<script>
$("#form-pdw13").validate();

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
        text: "Adakah anda pasti untuk menghantar Fakta Kes ini?",
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
                url: '{{ route("prosecution.pdw13.form", $prosecution->id) }}',
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

	$('#form-pdw13 input, #form-pdw13 select, #form-pdw13 textarea').on('change', function() {
		socket.emit('pdw13', {
			id: {{ $pdw13->id }},
			name: $(this).attr('name'),
			value: $(this).attr('type') == 'checkbox' ? ($(this).prop('checked') ? 1 : 0) : $(this).val(),
			user: '{{ Cookie::get('api_token') }}'
		});
		console.log('changed');
	});

});

</script>
@endpush
