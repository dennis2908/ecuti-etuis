<div class="notification-panel no-border">
	<div class="notification-body">

		@component('components.timeline.item', [
			'title' => 'Permohonan Pendaftaran Sistem',
			'date' => '19 Januari 2018'
		])
		@endcomponent


		@component('components.timeline.item', [
			'title' => 'Pendaftaran Ditolak Oleh Sistem',
			'date' => '19 Januari 2018',
			'type' => 'danger'
		])
			@component('components.timeline.content', ['title' => 'Ulasan'])
				Pendaftaran telah melebihi 30 hari dari tarikh penubuhan Kesatuan. Kesatuan Sekerja boleh memfailkan rayuan dalam tempoh 14 hari jika masih berminat untuk mendaftaran.
			@endcomponent
		@endcomponent


		@component('components.timeline.item', [
			'title' => 'Permohonan Rayuan',
			'date' => '19 Januari 2018'
		])
			@component('components.timeline.content', ['title' => 'Justifikasi'])
				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer pharetra tristique cursus. Maecenas viverra risus eget neque pulvinar, sit amet tristique massa sagittis. Phasellus et elementum odio, ut molestie elit. Mauris id sem et odio finibus feugiat vitae et enim. Aliquam et rutrum quam. Quisque consequat suscipit enim, non laoreet neque malesuada sed. In hac habitasse platea dictumst. Donec sed magna non dui pretium porta. Vestibulum posuere orci vitae semper rutrum. Quisque ultrices, magna non pellentesque volutpat, dui sem dictum libero, eu pellentesque nisi lectus at tortor. Donec at sapien vehicula, mollis quam eu, aliquet sapien. Morbi urna ex, sodales a ultricies vitae, pellentesque et neque. Sed ac leo in justo volutpat rutrum id in enim.
				<br><br>
				In faucibus sodales justo ac sagittis. Morbi vitae pellentesque mi, ac rutrum lorem. Curabitur vitae suscipit ipsum, eu accumsan tortor. Aenean et dui massa. Pellentesque vestibulum, elit eget convallis blandit, ex lacus auctor risus, at facilisis metus metus sit amet elit. Curabitur neque lacus, consectetur at ante ac, ullamcorper convallis arcu. Nam ornare nunc nec mauris vestibulum dictum.
			@endcomponent
			@component('components.timeline.content', ['title' => 'Lampiran'])
				<ul>
					<li><a class="btn btn-default btn-xs" href="#"><i class="mr-1 fa fa-external-link"></i> Borang B1</a></li>
				</ul>
			@endcomponent
		@endcomponent


		@component('components.timeline.item', [
			'title' => 'Rayuan Diterima',
			'date' => '19 Januari 2018'
		])
		@endcomponent


		@component('components.timeline.item', [
			'title' => 'Pendaftaran Selesai',
			'date' => '19 Januari 2018'
		])
		@endcomponent

	</div>
</div>