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
	
	@stack('css')
</head>
<body class="fixed-header menu-pin menu-behind">
	
	@include('layouts.sidebar')

	<!-- START PAGE-CONTAINER -->
	<div class="page-container">
		<!-- START PAGE CONTENT WRAPPER -->
		<div class="page-content-wrapper">

			@include('layouts.header')

			<!-- START PAGE CONTENT -->
			<div class="content">
				
				@yield('content')

			</div>
			<!-- END PAGE CONTENT -->
			
			@include('layouts.footer')

		</div>
		<!-- END PAGE CONTENT WRAPPER -->
	</div>
	<!-- END PAGE CONTAINER -->

	@stack('modal')

	<!-- Modal -->
	<div class="modal fade" id="modal-query" tabindex="-1" role="dialog" aria-labelledby="addModalTitle" aria-hidden="true">
	    <div class="modal-dialog modal-lg" role="document">
	        <div class="modal-content">
	            <div class="modal-header">
	                <h5 class="modal-title" id="addModalTitle">Maklumat <span class="bold">Kuiri</span></h5>
	                <small class="text-muted">Sila isi ulasan kuiri pada ruangan di bawah.</small>
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                    <span aria-hidden="true">&times;</span>
	                </button>
	            </div>
	            <div class="modal-body m-t-20">
	                @include('components.textarea', [
	                    'name' => 'description',
	                    'label' => 'Ulasan',
	                    'mode' => 'required',
	                    'value' => ''
	                ])

	                <button class="btn btn-warning"><i class="fa fa-angle-down m-r-5"></i> Simpan Kuiri</button>

	                <table class="table table-hover " id="table">
						<thead>
							<tr>
								<th class="fit">Bil.</th>
								<th class="">Ulasan</th>
								<th class="fit">Tindakan</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>1.</td>
								<td>Permohonan tidak ditandatangan oleh setiausaha penaja.</td>
								<td class="nowrap">
									<a href="javascript:;" class="btn btn-success btn-xs" data-toggle="tooltip" title="Kemaskini"><i class="fa fa-edit"></i></a>
									<a href="javascript:;" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Padam"><i class="fa fa-trash"></i></a>
								</td>
							</tr>
						</tbody>
					</table>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
	                <button type="button" class="btn btn-info" onclick="submitQuery()"><i class="fa fa-check m-r-5"></i> Hantar</button>
	            </div>
	        </div>
	    </div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="modal-rejected" tabindex="-1" role="dialog" aria-labelledby="addModalTitle" aria-hidden="true">
	    <div class="modal-dialog modal-lg" role="document">
	        <div class="modal-content">
	            <div class="modal-header">
	                <h5 class="modal-title" id="addModalTitle">Buku Peraturan <span class="bold">Tidak Lengkap</span></h5>
	                <small class="text-muted">Sila isi ulasan pada ruangan di bawah.</small>
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                    <span aria-hidden="true">&times;</span>
	                </button>
	            </div>
	            <div class="modal-body m-t-20">
	                @include('components.textarea', [
	                    'name' => 'description',
	                    'label' => 'Ulasan',
	                    'mode' => 'required',
	                    'value' => ''
	                ])

	                <button class="btn btn-warning"><i class="fa fa-angle-down m-r-5"></i> Simpan Ulasan</button>

	                <table class="table table-hover " id="table">
						<thead>
							<tr>
								<th class="fit">Bil.</th>
								<th class="">Ulasan</th>
								<th class="fit">Tindakan</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>1.</td>
								<td>Permohonan tidak ditandatangan oleh setiausaha penaja.</td>
								<td class="nowrap">
									<a href="javascript:;" class="btn btn-success btn-xs" data-toggle="tooltip" title="Kemaskini"><i class="fa fa-edit"></i></a>
									<a href="javascript:;" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Padam"><i class="fa fa-trash"></i></a>
								</td>
							</tr>
						</tbody>
					</table>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
	                <button type="button" class="btn btn-info" onclick="submitResult()"><i class="fa fa-check m-r-5"></i> Hantar</button>
	            </div>
	        </div>
	    </div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="modal-password" tabindex="-1" role="dialog" aria-labelledby="addModalTitle" aria-hidden="true">
	    <div class="modal-dialog" role="document">
	        <div class="modal-content">
	            <div class="modal-header">
	                <h5 class="modal-title" id="addModalTitle">Kemaskini <span class="bold">Kata Laluan</span></h5>
	                <small class="text-muted">Sila isi maklumat pada ruangan di bawah.</small>
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                    <span aria-hidden="true">&times;</span>
	                </button>
	            </div>
	            <div class="modal-body m-t-20">
	            	<form id='form-password' role="form" method="post" action="{{ route('profile.password') }}">
	            	@include('components.input', [
	                    'name' => 'old_password',
	                    'label' => 'Kata Laluan Lama',
	                    'mode' => 'required',
	                    'type' => 'password',
	                    'options' => 'minlength=8',
	                    'value' => '',
	                ])

	                @include('components.input', [
	                    'name' => 'password',
	                    'label' => 'Kata Laluan Baru',
	                    'mode' => 'required',
	                    'type' => 'password',
	                    'options' => 'minlength=8',
	                    'value' => '',
	                ])

	                @include('components.input', [
	                    'name' => 'password_confirmation',
	                    'label' => 'Pengesahan Kata Laluan Baru',
	                    'mode' => 'required',
	                    'type' => 'password',
	                    'options' => 'minlength=8',
	                    'value' => '',
	                ])
		            </form>
	            </div>
	            <div class="modal-footer">
	                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
	                <button type="button" class="btn btn-info" onclick="submitForm('form-password')"><i class="fa fa-check m-r-5"></i> Hantar</button>
	            </div>
	        </div>
	    </div>
	</div>

	<div id="modal-div"></div>

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
	<script src="{{ asset('assets/plugins/select2/js/i18n/ms.js') }}" type="text/javascript"></script> 
	<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}" type="text/javascript"></script> 
	<script src="{{ asset('assets/plugins/classie/classie.js') }}" type="text/javascript"></script> 
	<script src="{{ asset('assets/plugins/switchery/js/switchery.min.js') }}" type="text/javascript"></script> 
	<script src="{{ asset('assets/plugins/jquery-validation/js/jquery.validate.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/bootstrap-datepicker/js/locales/bootstrap-datepicker.ms.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/socketio/socket.io.js') }}" type="text/javascript"></script>
	<!-- END VENDOR JS -->

	<!-- BEGIN CORE TEMPLATE JS -->
	<script src="{{ asset('pages/js/pages.min.js') }}"></script>
	<!-- END CORE TEMPLATE JS -->

	<!-- BEGIN PAGE LEVEL JS -->
    <script src="{{ asset('assets/js/scripts.js') }}" type="text/javascript"></script>
    <!-- END PAGE LEVEL JS -->
	
	<script src="{{ asset('js/global.js') }}"></script>

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
	</script>

	@stack('js')

	<script type="text/javascript">

		$("#form-password").validate();

		function queryData(id) {
			$("#modal-query").modal("show");
		}

		function profileData() {
			location.href="{{ route('profile') }}";
		}

		function rejectBook() {
			$("#modal-rejected").modal("show");
		}

		$("#form-password").submit(function(e) {
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
		            $("#modal-password").modal("hide");
		        }
		    });
		});

		function viewFiling(filing_type, filing_id) {
			var data = $.param({
				filing_type: filing_type,
				filing_id: filing_id
			}, true);

			$("#modal-div").load("{{ route('general.getFilingDetails') }}?" + data);
		}
	</script>

	@include('components.ajax.address')
	
</body>
</html>