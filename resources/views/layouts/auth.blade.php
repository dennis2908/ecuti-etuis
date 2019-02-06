<!DOCTYPE html>
<html>
<head>
	<meta content="text/html; charset=utf-8" http-equiv="content-type">
	<meta charset="utf-8">
	<title>{{ env('APP_NAME', 'e-Cuti') }}</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no" name="viewport">
	<!-- <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}"> -->
	<meta content="yes" name="apple-mobile-web-app-capable">
	<meta content="yes" name="apple-touch-fullscreen">
	<meta content="default" name="apple-mobile-web-app-status-bar-style">
	<meta content="{{ env('APP_DESC') }}" name="description">
	<meta content="{{ env('APP_AUTHOR') }}" name="author">

	<!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

	<link href="{{ asset('assets/plugins/pace/pace-theme-flash.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/plugins/font-awesome/css/font-awesome.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/plugins/jquery-scrollbar/jquery.scrollbar.css') }}" media="screen" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" media="screen" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/plugins/switchery/css/switchery.min.css') }}" media="screen" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/plugins/bootstrap-datepicker/css/datepicker3.css') }}" rel="stylesheet" type="text/css" media="screen">
	<link href="{{ asset('pages/css/pages-icons.css') }}" rel="stylesheet" type="text/css">
	<link class="main-stylesheet" href="{{ asset('pages/css/themes/corporate.css') }}" rel="stylesheet" type="text/css">

	<link href="{{ asset('css/global.css') }}" rel="stylesheet" type="text/css">

	<script type="text/javascript">
	   window.onload = function()
	   {
	     // fix for windows 8
	     if (navigator.appVersion.indexOf("Windows NT 6.2") != -1)
	       document.head.innerHTML += '<link rel="stylesheet" type="text/css" href="{{ asset("pages/css/windows.chrome.fix.css") }}" />'
	   }
	</script>

	<style type="text/css">
		body {
			background-image: url('{{ asset('images/bg_login2.jpg') }}');
			background-size: cover;
			background-position: center;
			background-attachment: fixed;
		}
		.register-container {
		    width: 768px;
		    max-width: 100%;
		}
		.logo {
			/*padding-left: 25%;*/
			margin-top: 50px;
			display: block;
			text-align: center;
		}
		.logo > img {
			width: 60%;
			height: 100%;
		}
		.content {
			background-color: white;
			border-top: 5px solid #1e5377;
			border-radius: 3px;
		}

		#div-announcement {
			border-left: 1px solid #f0f0f0;
			border-top: unset;
		}

		@media (max-width: 767.98px) {
			.logo {
				padding-left: 0;
				margin-top: 10px;
			}
			.logo > img {
				width: 100%;
			}

			#div-announcement {
				border-top: 1px solid #f0f0f0;
				border-left: unset;
				margin-top: 20px;
			}
		}

		.btn-box {
		    height: 50px;
		    margin: 10px 0px;
		    cursor: pointer !important;
		}
	</style>

	@stack('css')

</head>
<body class="fixed-header menu-pin menu-behind">
	<div class="register-container full-height sm-p-t-30">
		<div class="d-flex flex-column full-height">

			<div class="logo row">
				<h1 style="color: white;font-size: 44px;"><b>e</b>-Cuti</h1>
			</div>

			<div class="content padding-20 p-b-40" style="">

				@yield('content')

			</div>

			<div style="width: 100%; text-align: center; margin-top: 10px;">
	            <img class="btn-box" src="{{ asset('images/btn_newuser.png') }}" onclick="modalFirstTime()">
	            <img class="btn-box" src="{{ asset('images/btn_complaint.png') }}" onclick="modalComplaint()">
	        </div>

			<div class="row m-t-5 p-b-30">
				<div class="col-md-12 text-center text-muted" style="width: 100%;">
					<small>2018 © Unijaya Resources Sdn Bhd</small>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade disable-scroll" id="modal-firsttime" tabindex="-1" role="dialog" aria-hidden="false">
	    <div class="modal-dialog modal-lg" style="border: 10px solid rgba(0,0,0,0.2); border-radius: 5px;">
	        <div class="modal-content-wrapper">
	            <div class="modal-content">
	                <div class="modal-body" style="padding: 0px;">
	                    <img style="width: 100%;" src="{{ asset('images/info.jpg') }}">
	                </div>
	            </div>
	        </div>
	        <!-- /.modal-content -->
	    </div>
	</div>
	<div class="modal fade disable-scroll" id="modal-complaint" tabindex="-1" role="dialog" aria-hidden="false">
	    <div class="modal-dialog modal-lg">
	        <div class="modal-content-wrapper">
	            <div class="modal-content">
	                <div class="modal-header clearfix text-left">
	                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
	                    </button>
	                    <h5>Aduan <span class="semi-bold">Kesatuan Sekerja</span></h5>
	                    <p class="p-b-10">Sila isi ruangan pada borang aduan di bawah.</p>
	                </div>
	                <form role="form" id="form-complaint" method="post" action="{{ route('complaint') }}">
	                	<div class="modal-body">
	                		<div class="form-group form-group-default required">
	                			<label>Nama Penuh</label>
	                			<input name="name" placeholder="" class="form-control" value="" required="" type="text">
	                		</div>
	                		<div class="form-group form-group-default required">
	                			<label>Alamat Emel</label>
	                			<input name="email" placeholder="" class="form-control" value="" required="" type="email">
	                		</div>
	                		<div class="form-group form-group-default required">
	                			<label>Ulasan Aduan</label>
	                			<textarea style="height: 150px;" name="complaint" placeholder="" class="form-control" required></textarea>
	                		</div>
	                		{!! app('captcha')->display() !!}
	                	</div>
	                	<div class="modal-footer">
	                		<button type="submit" class="btn btn-info"><i class="fa fa-check m-r-5"></i> Hantar</button>
	                	</div>
	                </form>
	            </div>
	        </div>
	        <!-- /.modal-content -->
	    </div>
	</div>
	
	<div id="modal-div"></div>

	@stack('modal')

	<!-- BEGIN VENDOR JS -->
	<script src="{{ asset('assets/plugins/pace/pace.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/plugins/jquery/jquery-1.11.1.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/plugins/modernizr.custom.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/plugins/popper/umd/popper.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/plugins/jquery/jquery-easy.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/plugins/jquery-unveil/jquery.unveil.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/plugins/jquery-ios-list/jquery.ioslist.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/plugins/jquery-actual/jquery.actual.min.js') }}"></script>
	<script src="{{ asset('assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
	<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/plugins/classie/classie.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/plugins/switchery/js/switchery.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/plugins/jquery-validation/js/jquery.validate.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}" type="text/javascript"></script>
	<!-- END VENDOR JS -->

	<!-- BEGIN CORE TEMPLATE JS -->
	<script src="{{ asset('pages/js/pages.min.js') }}"></script>
	<!-- END CORE TEMPLATE JS -->

	<!-- BEGIN PAGE LEVEL JS -->
    <script src="{{ asset('assets/js/scripts.js') }}" type="text/javascript"></script>
    <!-- END PAGE LEVEL JS -->

	<script src="{{ asset('js/global.js') }}"></script>

	<script src='https://www.google.com/recaptcha/api.js'></script>

	<script type="text/javascript">
		@if(session('status'))
			<?php
				$status_list = ['success', 'error', 'warning', 'info'];
				$swal_title = session('title') ? session('title') : '';
				$swal_message = session('message') ? session('message') : session('status');

				if(!in_array(strtolower(session('status')), $status_list)) {
					$swal_status = "info";
				} else {
					$swal_status = session('status');
				}
			?>
			swal("{{ $swal_title }}","{!! $swal_message !!}","{{ $swal_status }}");
		@elseif(count($errors) > 0)
			swal("Ralat!","{!! $errors->first() !!}","error");
		@endif

		function modalComplaint() {
	        $("#modal-complaint").modal('show');
   			$('#form-complaint').trigger("reset");
	        $("#form-complaint").validate();
	    }

	    function modalFirstTime() {
	        $("#modal-firsttime").modal('show');
	    }

		$("#form-complaint").submit(function(e) {
		    e.preventDefault();
		    var form = $(this);

		    if(!form.valid())
		       return;

		    $.ajax({
		        url: form.attr('action'),
		        method: form.attr('method'),
		        data: new FormData(form[0]),
		        dataType: 'json',
		        async: true,
		        contentType: false,
		        processData: false,
		        success: function(data) {
		            swal(data.title, data.message, data.status);
		            $("#modal-complaint").modal("hide");
		        }
		    });
		});
	</script>

	@stack('js')

</body>
</html>
