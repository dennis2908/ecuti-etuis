<!-- START CONTAINER FLUID -->
<div class=" container-fluid container-fixed-lg bg-white">
	<!-- START card -->
	<div class="card card-transparent">
		<div class="card-block">
			<form class="form-horizontal" role="form" autocomplete="off" method="post" action="{{ route('admin.settings') }}">

				@include('components.bs.radio', [
					'name' => 'APP_MAINTENANCE',
					'label' => 'Mod Penyelenggaraan',
					'mode' => 'required',
					'data' => [
						'true' => 'Aktif', 
						'false' => 'Tidak Aktif',
					],
					'selected' => env('APP_MAINTENANCE') ? 'true' : 'false'
				])

				<div class="alert alert-info">
			        <strong>Makluman:</strong>
			        Apabila mod penyelenggaraan diaktifkan, paparan "Sistem sedang diselenggara" akan dipaparkan kepada pengguna luar. Akses kepada log masuk juga akan ditutup kepada semua pengguna (selain Pentadbir/Administrator).
			    </div>
				

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

