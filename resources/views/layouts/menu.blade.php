<li class="m-t-30 {{ request()->is('home*') ? 'active' : '' }}">
	<a class="" href="{{ route('home') }}">
		<span class="title">Paparan Utama</span>
	</a>
	<span class="icon-thumbnail"><i class="pg-home"></i></span>
</li>

<li class="{{ request()->is('inbox*') ? 'active' : '' }}">
	<a class="{{--detailed--}}" href="{{ route('inbox') }}">
		<span class="title">Inbox Notifikasi</span>
		<!-- <span class="entity">3 Notifikasi Baru</span> -->
	</a>
	<span class="icon-thumbnail"><i class="pg-mail"></i></span>
</li>

@if(auth()->user()->hasRole('admin'))
<li class="{{ request()->is('admin/settings*') ? 'active' : '' }}">
	<a href="{{ route('admin.settings') }}">
		<span class="title">Konfigurasi Sistem</span>
	</a>
	<span class="icon-thumbnail"><i class="fa fa-gear"></i></span>
</li>
<li class="{{ request()->is('admin/user*') ? 'open active' : '' }}">
	<a href="javascript:;">
		<span class="title">Pengurusan Pengguna</span>
		<span class="arrow {{ request()->is('admin/user*') ? 'open active' : '' }}"></span>
	</a>
	<span class="icon-thumbnail"><i class="fa fa-users"></i></span>
	<ul class="sub-menu">
		<li class="menu-inner-custom {{ request()->is('admin/user/internal*') ? 'active' : '' }}">
			<a href="{{ route('admin.user.internal') }}">Pengguna Dalaman</a>
		</li>
		<li class="menu-inner-custom {{ request()->is('admin/user/external*') ? 'active' : '' }}">
			<a href="{{ route('admin.user.external') }}">Pengguna Luaran</a>
		</li>
	</ul>
</li>
<li class="{{ request()->is('admin/role*') ? 'active' : '' }}">
	<a href="{{ route('admin.role') }}">
		<span class="title">Pengurusan Peranan</span>
	</a>
	<span class="icon-thumbnail">Pp</span>
</li>
<li class="{{ request()->is('admin/permission*') ? 'active' : '' }}">
	<a href="{{ route('admin.permission') }}">
		<span class="title">Pengurusan Keizinan</span>
	</a>
	<span class="icon-thumbnail">Pk</span>
</li>
<li class="{{ request()->is('admin/backup*') ? 'active' : '' }}">
	<a href="{{ route('admin.backup') }}">
		<span class="title">Pengurusan Simpanan</span>
	</a>
	<span class="icon-thumbnail"><i class="fa fa-database"></i></span>
</li>
<li class="{{ request()->is('admin/notification*') ? 'active' : '' }}">
	<a href="{{ route('admin.notification') }}">
		<span class="title">Pengurusan Notifikasi</span>
	</a>
	<span class="icon-thumbnail"><i class="fa fa-bell"></i></span>
</li>
<li class="{{ request()->is('admin/letter*') ? 'active' : '' }}">
	<a href="{{ route('admin.letter') }}">
		<span class="title">Pengurusan Paparan Surat</span>
	</a>
	<span class="icon-thumbnail"><i class="fa fa-envelope"></i></span>
</li>
<li class="{{ request()->is('admin/holiday*') ? 'active' : '' }}">
	<a href="{{ route('admin.holiday') }}">
		<span class="title">Pengurusan Cuti</span>
	</a>
	<span class="icon-thumbnail"><i class="fa fa-calendar"></i></span>
</li>
<li class="{{ request()->is('admin/holiday-type*') ? 'active' : '' }}">
	<a href="{{ route('admin.master.holiday-type') }}">
		<span class="title">Libur Cuti</span>
	</a>
	<span class="icon-thumbnail"><i class="fa fa-calendar"></i></span>
</li>
<li class="{{ request()->is('admin/log*') ? 'active' : '' }}">
	<a href="{{ route('admin.log') }}">
		<span class="title">Jejak Audit / Log Sistem</span>
	</a>
	<span class="icon-thumbnail"><i class="fa fa-list-alt"></i></span>
</li>
<li class="{{ request()->is('admin/master*') ? 'open active' : '' }}">
	<a href="javascript:;">
		<span class="title">Data Induk</span>
		<span class="arrow {{ request()->is('admin/master*') ? 'open active' : '' }}"></span>
	</a>
	<span class="icon-thumbnail">Di</span>
	<ul class="sub-menu">
		<li class="menu-inner-custom {{ request()->is('admin/master/designation*') ? 'active' : '' }}">
			<a href="{{ route('admin.master.designation') }}">Jawatan</a>
		</li>
		<li class="menu-inner-custom {{ request()->is('admin/master/union-type*') ? 'active' : '' }}">
			<a href="{{ route('admin.master.union-type') }}">Jenis Kesatuan</a>
		</li>
		<li class="menu-inner-custom {{ request()->is('admin/master/meeting-type*') ? 'active' : '' }}">
			<a href="{{ route('admin.master.meeting-type') }}">Jenis Mesyuarat</a>
		</li>
		<li class="menu-inner-custom {{ request()->is('admin/master/announcement-type*') ? 'active' : '' }}">
			<a href="{{ route('admin.master.announcement-type') }}">Jenis Pengumuman</a>
		</li>
		<li class="menu-inner-custom {{ request()->is('admin/master/federation-type*') ? 'active' : '' }}">
			<a href="{{ route('admin.master.federation-type') }}">Jenis Persekutuan</a>
		</li>
		<li class="menu-inner-custom {{ request()->is('admin/master/programme-type*') ? 'active' : '' }}">
			<a href="{{ route('admin.master.programme-type') }}">Jenis Program</a>
		</li>
		<li class="menu-inner-custom {{ request()->is('admin/master/holiday-type*') ? 'active' : '' }}">
			<a href="{{ route('admin.master.holiday-type') }}">Jenis Cuti</a>
		</li>
		<li class="menu-inner-custom {{ request()->is('admin/master/region*') ? 'active' : '' }}">
			<a href="{{ route('admin.master.region') }}">Kawasan</a>
		</li>
		<li class="menu-inner-custom {{ request()->is('admin/master/court*') ? 'active' : '' }}">
			<a href="{{ route('admin.master.court') }}">Mahkamah</a>
		</li>
		<li class="menu-inner-custom {{ request()->is('admin/master/sector-category*') ? 'active' : '' }}">
			<a href="{{ route('admin.master.sector-category') }}">Kategori Sektor</a>
		</li>
		<li class="menu-inner-custom {{ request()->is('admin/master/complaint-classification*') ? 'active' : '' }}">
			<a href="{{ route('admin.master.complaint-classification') }}">Klasifikasi Aduan</a>
		</li>
		<li class="menu-inner-custom {{ request()->is('admin/master/province-office*') ? 'active' : '' }}">
			<a href="{{ route('admin.master.province-office') }}">Pejabat Wilayah</a>
		</li>
		<li class="menu-inner-custom {{ request()->is('admin/master/attorney*') ? 'active' : '' }}">
			<a href="{{ route('admin.master.attorney') }}">Pejabat Peguam</a>
		</li>
		<li class="menu-inner-custom {{ request()->is('admin/master/sector') ? 'active' : '' }}">
			<a href="{{ route('admin.master.sector') }}">Sektor</a>
		</li>
	</ul>
</li>
@endif

@if(auth()->user()->hasRole('staff'))
<li class="{{ request()->is('staff/settings*') ? 'active' : '' }}">
	<a href="{{ route('staff.settings') }}">
		<span class="title">Konfigurasi Sistem</span>
	</a>
	<span class="icon-thumbnail"><i class="fa fa-gear"></i></span>
</li>
<li class="{{ request()->is('staff/holiday*') ? 'active' : '' }}">
	<a href="{{ route('staff.holiday') }}">
		<span class="title">Pengurusan Cuti</span>
	</a>
	<span class="icon-thumbnail"><i class="fa fa-calendar"></i></span>
</li>

<li class="{{ request()->is('staff/holiday_approved*') ? 'active' : '' }}">
	<a href="{{ route('staff.holiday_approved') }}">
		<span class="title">Approved Cuti</span>
	</a>
	<span class="icon-thumbnail"><i class="fa fa-calendar"></i></span>
</li>

	</ul>
</li>
@endif
