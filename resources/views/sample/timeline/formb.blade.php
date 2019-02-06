@component('components.timeline_section', ['title' => 'Kesatuan Sekerja'])
	@component('components.timeline_event', ['date' => '19 Januari 2018'])
		@slot('title')
			<strong>Permohonan Pendaftaran Kesatuan Sekerja</strong>
		@endslot
		<strong>Lampiran</strong>
		<ul>
			<li><a href="#"><i class="mr-1 fa fa-external-link"></i> Borang B2</a></li>
			<li><a href="#"><i class="mr-1 fa fa-external-link"></i> Borang B3</a></li>
			<li><a href="#"><i class="mr-1 fa fa-external-link"></i> Borang Praecipe</a></li>
			<li><a href="#"><i class="mr-1 fa fa-external-link"></i> Senarai Semak</a></li>
		</ul>
	@endcomponent
@endcomponent

@component('components.timeline_section', ['title' => 'Pejabat Wilayah Negeri'])
	@component('components.timeline_event', ['date' => '19 Januari 2018'])
		@slot('title')
			<strong class="">Dokumen Fizikal Diterima</strong> <small>Oleh Pegawai Tadbir Wilayah</small>
		@endslot
	@endcomponent

	@component('components.timeline_event', ['date' => '19 Januari 2018'])
		@slot('title')
			<strong class="text-warning">Kuiri Permohonan</strong> <small>Oleh Pegawai Tadbir Wilayah</small>
		@endslot
		<strong>Kuiri</strong>
		<p class="pb-0">
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer pharetra tristique cursus. Maecenas viverra risus eget neque pulvinar, sit amet tristique massa sagittis. Phasellus et elementum odio, ut molestie elit. Mauris id sem et odio finibus feugiat vitae et enim. Aliquam et rutrum quam. Quisque consequat suscipit enim, non laoreet neque malesuada sed. In hac habitasse platea dictumst. Donec sed magna non dui pretium porta. Vestibulum posuere orci vitae semper rutrum. Quisque ultrices, magna non pellentesque volutpat, dui sem dictum libero, eu pellentesque nisi lectus at tortor. Donec at sapien vehicula, mollis quam eu, aliquet sapien. Morbi urna ex, sodales a ultricies vitae, pellentesque et neque. Sed ac leo in justo volutpat rutrum id in enim.
			<br><br>
			In faucibus sodales justo ac sagittis. Morbi vitae pellentesque mi, ac rutrum lorem. Curabitur vitae suscipit ipsum, eu accumsan tortor. Aenean et dui massa. Pellentesque vestibulum, elit eget convallis blandit, ex lacus auctor risus, at facilisis metus metus sit amet elit. Curabitur neque lacus, consectetur at ante ac, ullamcorper convallis arcu. Nam ornare nunc nec mauris vestibulum dictum. 
		</p>
	@endcomponent

	@component('components.timeline_event', ['date' => '19 Januari 2018'])
		@slot('title')
			<strong class="">Dokumen Fizikal Diserahkan Ke Ibu Pejabat (HQ)</strong> <small>Oleh Pegawai Tadbir Wilayah</small>
		@endslot
	@endcomponent
@endcomponent

@component('components.timeline_section', ['title' => 'Ibu Pejabat (HQ)'])
	@component('components.timeline_event', ['date' => '19 Januari 2018'])
		@slot('title')
			<strong class="">Dokumen Fizikal Diterima</strong> <small>Oleh Pegawai Tadbir HQ</small>
		@endslot
	@endcomponent

	@component('components.timeline_event', ['date' => '19 Januari 2018'])
		@slot('title')
			<strong class="text-warning">Kuiri Permohonan</strong> <small>Oleh Penolong Pegawai HQ</small>
		@endslot
		<strong>Kuiri</strong>
		<p class="pb-0">
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer pharetra tristique cursus. Maecenas viverra risus eget neque pulvinar, sit amet tristique massa sagittis. Phasellus et elementum odio, ut molestie elit. Mauris id sem et odio finibus feugiat vitae et enim. Aliquam et rutrum quam. Quisque consequat suscipit enim, non laoreet neque malesuada sed. In hac habitasse platea dictumst. Donec sed magna non dui pretium porta. Vestibulum posuere orci vitae semper rutrum. Quisque ultrices, magna non pellentesque volutpat, dui sem dictum libero, eu pellentesque nisi lectus at tortor. Donec at sapien vehicula, mollis quam eu, aliquet sapien. Morbi urna ex, sodales a ultricies vitae, pellentesque et neque. Sed ac leo in justo volutpat rutrum id in enim.
			<br><br>
			In faucibus sodales justo ac sagittis. Morbi vitae pellentesque mi, ac rutrum lorem. Curabitur vitae suscipit ipsum, eu accumsan tortor. Aenean et dui massa. Pellentesque vestibulum, elit eget convallis blandit, ex lacus auctor risus, at facilisis metus metus sit amet elit. Curabitur neque lacus, consectetur at ante ac, ullamcorper convallis arcu. Nam ornare nunc nec mauris vestibulum dictum. 
		</p>
	@endcomponent

	@component('components.timeline_event', ['date' => '19 Januari 2018'])
		@slot('title')
			<strong class="text-green">Pendaftaran Kesatuan Sekerja Diluluskan</strong> <small>Oleh Ketua Pengarah Kesatuan Sekerja</small>
		@endslot
		<strong>Lampiran</strong>
		<ul>
			<li><a href="#"><i class="mr-1 fa fa-external-link"></i> Surat Kelulusan</a></li>
			<li><a href="#"><i class="mr-1 fa fa-external-link"></i> Perakuan Pendaftaran (Borang D)</a></li>
		</ul>
	@endcomponent
@endcomponent

@component('components.timeline_section', ['title' => 'Kesatuan Sekerja'])
	@component('components.timeline_event', ['date' => '19 Januari 2018'])
		@slot('title')
			<strong class="text-green">Pendaftaran Selesai</strong>
		@endslot
	@endcomponent
@endcomponent