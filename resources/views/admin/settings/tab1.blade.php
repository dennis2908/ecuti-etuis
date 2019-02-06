<!-- START CONTAINER FLUID -->
<div class=" container-fluid container-fixed-lg bg-white">
	<!-- START card -->
	<div class="card card-transparent">
		<div class="card-block">
			<form class="form-horizontal" role="form" autocomplete="off" method="post" action="{{ route('admin.settings') }}">

				@include('components.bs.input', [
					'name' => 'APP_NAME',
					'label' => 'Nama Aplikasi Web',
					'mode' => 'required',
					'value' => env('APP_NAME')
				])

				@include('components.bs.radio', [
					'name' => 'APP_ENV',
					'label' => 'Jenis Aplikasi',
					'info' => 'Sila guna mod PRODUCTION jika sistem sedang LIVE dan digunakan oleh pengguna luar. Mod DEVELOPMENT hanya boleh digunakan semasa menyelenggara sistem sahaja.',
					'mode' => 'required',
					'data' => [
						'local' => 'Development', 
						'production' => 'Production',
					],
					'selected' => env('APP_ENV')
				])

				@include('components.bs.radio', [
					'name' => 'APP_DEBUG',
					'label' => 'Mod Debug',
					'info' => 'Mod DEBUG akan membenarkan pentadbir/administrator untuk melihat log masalah yang sedang dihadapi dengan lebih terperinci.',
					'mode' => 'required',
					'data' => [
						'true' => 'Aktif', 
						'false' => 'Tidak Aktif',
					],
					'selected' => env('APP_ENV') ? 'true' : 'false'
				])

				@include('components.bs.input', [
					'name' => 'APP_URL',
					'label' => 'URL',
					'mode' => 'required',
					'class' => 'text-lowercase',
					'value' => env('APP_URL')
				])



				<div class="row">
					<div class="col-md-12">
						<button class="btn btn-info pull-right" type="submit">
							<i class="fa fa-check m-r-5"></i> Simpan
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<!-- END card -->
</div>
<!-- END CONTAINER FLUID -->

