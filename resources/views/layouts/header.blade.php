<!-- START HEADER -->
<div class="header">
	<!-- START MOBILE SIDEBAR TOGGLE -->
	<a class="btn-link toggle-sidebar d-lg-none pg pg-menu" data-toggle="sidebar" href="#"></a> <!-- END MOBILE SIDEBAR TOGGLE -->
	<div class="p-l-40">
		<h1><b>e</b>-Cuti</h1>
	</div>
	<div class="d-flex align-items-center">
		<!-- START User Info-->
		<div class="pull-left p-r-10 fs-14 font-heading d-lg-block d-none text-right">
			<span class="bold">{{ auth()->user()->name }}</span>
			@if(auth()->user()->hasRole('ks'))
			<br><small class="font-italic text-primary">{{ auth()->user()->entity->name }}</small>
			@elseif(auth()->user()->hasRole('staff'))
			<br><small class="font-italic text-primary">{{ auth()->user()->entity->role->description }}, {{ auth()->user()->entity->province_office->name }}</small>
			@endif
		</div>
		<div class="dropdown pull-right d-lg-block d-none">
			<button aria-expanded="false" aria-haspopup="true" class="profile-dropdown-toggle clickable" data-toggle="dropdown" type="button">
				<span class="thumbnail-wrapper d32 circular inline">
					<img alt=""   @if(auth()->user()->picture_url)data-src="{{ route('profile.picture', 'avatar.jpg') }}" data-src-retina="{{ route('profile.picture', 'avatar.jpg') }}" src="{{ route('profile.picture', 'avatar.jpg') }}" @else data-src="{{ asset('images/icon/user.png') }}" data-src-retina="{{ asset('images/icon/user.png') }}" src="{{ asset('images/icon/user.png') }}" @endif height="32" width="32">
				</span>
			</button>
			<div class="dropdown-menu dropdown-menu-right profile-dropdown" role="menu">
				<a class="dropdown-item" href="javascript:;" onclick="profileData()">
					<i class="fa fa-user"></i> Kemaskini Profil
				</a>
				<a class="dropdown-item" href="javascript:;" onclick="passwordData(1)">
					<i class="fa fa-lock"></i> Kemaskini Kata Laluan
				</a>
				<a class="dropdown-item" href="{{ route('inbox') }}">
					<i class="fa fa-envelope"></i> Inbox Notifikasi
				</a>
				<a class="clearfix bg-master-lighter dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
					<span class="pull-left">Log Keluar</span> 
					<span class="pull-right"><i class="pg-power"></i></span>
				</a>
				<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
			</div>
		</div><!-- END User Info-->
	</div>
</div>
<!-- END HEADER