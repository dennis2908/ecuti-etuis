<!-- START CONTAINER FLUID -->
<div class=" container-fluid container-fixed-lg bg-white">
	<!-- START card -->
	<div class="card card-transparent">
		<div class="card-block">
			<form class="form-horizontal" role="form" autocomplete="off" method="post" action="{{ route('admin.settings') }}">

				@include('components.bs.select', [
					'name' => 'MAIL_DRIVER',
					'label' => 'Jenis Emel',
					'mode' => 'required',
					'data' => [
						'smtp' => 'smtp', 
						'mail' => 'mail',
						'sendmail' => 'sendmail',
					],
					'selected' => env('MAIL_DRIVER')
				])

				@include('components.bs.input', [
					'name' => 'MAIL_HOST',
					'label' => 'Hos / Alamat IP',
					'mode' => 'required',
					'class' => 'text-lowercase',
					'value' => env('MAIL_HOST')
				])

				@include('components.bs.input', [
					'name' => 'MAIL_PORT',
					'label' => 'Nombor Port',
					'mode' => 'required',
					'value' => env('MAIL_PORT')
				])

				@include('components.bs.input', [
					'name' => 'MAIL_FROM_NAME',
					'label' => 'Nama Penghantar',
					'mode' => 'required',
					'class' => 'text-capitalize',
					'value' => env('MAIL_FROM_NAME')
				])

				@include('components.bs.input', [
					'name' => 'MAIL_FROM_ADDRESS',
					'label' => 'Alamat Emel Penghantar',
					'mode' => 'required',
					'class' => 'text-lowercase',
					'value' => env('MAIL_FROM_ADDRESS')
				])

				@include('components.bs.input', [
					'name' => 'MAIL_USERNAME',
					'label' => 'ID Pengguna',
					'mode' => 'required',
					'class' => 'text-lowercase',
					'value' => env('MAIL_USERNAME')
				])

				@include('components.bs.input', [
					'name' => 'MAIL_PASSWORD',
					'label' => 'Kata Laluan',
					'type' => 'password',
					'mode' => 'required',
					'class' => 'text-lowercase',
					'value' => env('MAIL_PASSWORD')
				])

				@include('components.bs.radio', [
					'name' => 'MAIL_ENCRYPTION',
					'label' => 'Enkripsi',
					'mode' => 'required',
					'data' => [
						'tls' => 'tls', 
						'ssl' => 'ssl',
						'' => 'None',
					],
					'selected' => env('MAIL_ENCRYPTION')
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

