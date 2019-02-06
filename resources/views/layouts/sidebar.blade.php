<!-- BEGIN SIDEBPANEL-->
<nav class="page-sidebar" data-pages="sidebar">
	<!-- BEGIN SIDEBAR MENU HEADER-->
	<div class="sidebar-header">
		<img alt="logo" class="brand" data-src="{{ asset('images/logo_etuis.png') }}" data-src-retina="{{ asset('images/logo_etuis.png') }}" src="{{ asset('images/logo_etuis.png') }}" width="100">
	</div><!-- END SIDEBAR MENU HEADER-->
	<!-- START SIDEBAR MENU -->
	<div class="sidebar-menu">
		<!-- BEGIN SIDEBAR MENU ITEMS-->
		<ul class="menu-items">

			@include('layouts.menu')
			
		</ul>
		<div class="clearfix"></div>
	</div><!-- END SIDEBAR MENU -->
</nav><!-- END SIDEBAR -->
<!-- END SIDEBPANEL-->