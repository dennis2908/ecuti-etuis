<div class="notification-panel no-border">
	<div class="notification-body">

		@component('components.timeline.item', [
			'title' => 'Permohonan Penyata Kewangan',
			'date' => '19 Januari 2018'
		])
			@component('components.timeline.content', ['title' => 'Lampiran'])
				<ul>
					<li><a class="btn btn-default btn-xs" href="#"><i class="mr-1 fa fa-external-link"></i> Borang N</a></li>
					<li><a class="btn btn-default btn-xs" href="#"><i class="mr-1 fa fa-external-link"></i> Borang Praecipe</a></li>
					<li><a class="btn btn-default btn-xs" href="#"><i class="mr-1 fa fa-external-link"></i> Senarai Semak</a></li>
				</ul>
			@endcomponent
		@endcomponent


		@component('components.timeline.item', [
			'title' => 'Dokumen Fizikal Diterima',
			'subtitle' => 'Oleh PTW',
			'date' => '19 Januari 2018'
		])
		@endcomponent


		@component('components.timeline.item', [
			'title' => 'Kuiri Permohonan',
			'subtitle' => 'Oleh PTW',
			'date' => '19 Januari 2018',
			'type' => 'warning'
		])
			@component('components.timeline.content', ['title' => 'Kuiri'])
				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer pharetra tristique cursus. Maecenas viverra risus eget neque pulvinar, sit amet tristique massa sagittis. Phasellus et elementum odio, ut molestie elit. Mauris id sem et odio finibus feugiat vitae et enim. Aliquam et rutrum quam. Quisque consequat suscipit enim, non laoreet neque malesuada sed. In hac habitasse platea dictumst. Donec sed magna non dui pretium porta. Vestibulum posuere orci vitae semper rutrum. Quisque ultrices, magna non pellentesque volutpat, dui sem dictum libero, eu pellentesque nisi lectus at tortor. Donec at sapien vehicula, mollis quam eu, aliquet sapien. Morbi urna ex, sodales a ultricies vitae, pellentesque et neque. Sed ac leo in justo volutpat rutrum id in enim.
				<br><br>
				In faucibus sodales justo ac sagittis. Morbi vitae pellentesque mi, ac rutrum lorem. Curabitur vitae suscipit ipsum, eu accumsan tortor. Aenean et dui massa. Pellentesque vestibulum, elit eget convallis blandit, ex lacus auctor risus, at facilisis metus metus sit amet elit. Curabitur neque lacus, consectetur at ante ac, ullamcorper convallis arcu. Nam ornare nunc nec mauris vestibulum dictum.
			@endcomponent
		@endcomponent

		@component('components.timeline.item', [
			'title' => 'Dokumen Diserah Ke HQ',
			'subtitle' => 'Oleh PTW',
			'date' => '19 Januari 2018'
		])
		@endcomponent

		@component('components.timeline.item', [
			'title' => 'Dokumen Fizikal Diterima',
			'subtitle' => 'Oleh PTHQ',
			'date' => '19 Januari 2018'
		])
		@endcomponent

		@component('components.timeline.item', [
			'title' => 'Syor / Ulasan',
			'subtitle' => 'Oleh PPHQ',
			'date' => '19 Januari 2018',
			'type' => 'warning'
		])
			@component('components.timeline.content')
				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer pharetra tristique cursus. Maecenas viverra risus eget neque pulvinar, sit amet tristique massa sagittis. Phasellus et elementum odio, ut molestie elit. Mauris id sem et odio finibus feugiat vitae et enim. Aliquam et rutrum quam. Quisque consequat suscipit enim, non laoreet neque malesuada sed. In hac habitasse platea dictumst. Donec sed magna non dui pretium porta. Vestibulum posuere orci vitae semper rutrum. Quisque ultrices, magna non pellentesque volutpat, dui sem dictum libero, eu pellentesque nisi lectus at tortor. Donec at sapien vehicula, mollis quam eu, aliquet sapien. Morbi urna ex, sodales a ultricies vitae, pellentesque et neque. Sed ac leo in justo volutpat rutrum id in enim.
				<br><br>
				In faucibus sodales justo ac sagittis. Morbi vitae pellentesque mi, ac rutrum lorem. Curabitur vitae suscipit ipsum, eu accumsan tortor. Aenean et dui massa. Pellentesque vestibulum, elit eget convallis blandit, ex lacus auctor risus, at facilisis metus metus sit amet elit. Curabitur neque lacus, consectetur at ante ac, ullamcorper convallis arcu. Nam ornare nunc nec mauris vestibulum dictum.
			@endcomponent
		@endcomponent

		@component('components.timeline.item', [
			'title' => 'Pendaftaran KS Diluluskan',
			'subtitle' => 'Oleh KPKS',
			'date' => '19 Januari 2018',
			'type' => 'success'
		])
			@component('components.timeline.content', ['title' => 'Lampiran'])
				<ul>
					<li><a class="btn btn-default btn-xs" href="#"><i class="mr-1 fa fa-external-link"></i> Surat Kelulusan</a></li>
					<li><a class="btn btn-default btn-xs" href="#"><i class="mr-1 fa fa-external-link"></i> Perakuan Pendaftaran (Borang D)</a></li>
				</ul>
			@endcomponent
		@endcomponent


		@component('components.timeline.item', [
			'title' => 'Pendaftaran Selesai',
			'date' => '19 Januari 2018',
			'type' => 'success'
		])
		@endcomponent

	</div>
</div>