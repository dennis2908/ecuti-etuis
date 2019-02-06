<!-- START CONTAINER FLUID -->
<div class=" container-fluid container-fixed-lg bg-white">
	<!-- START card -->
	<div class="card card-transparent">
		<div class="card-block">
			<form class="form-horizontal" role="form" autocomplete="off" method="post" action="{{ route('admin.settings') }}">

				@include('components.bs.input', [
					'name' => 'cache',
					'info' => 'Dalam kiraan minit.',
					'label' => 'Sesi Tamat (session)',
					'mode' => 'required',
					'class' => 'text-lowercase',
					'value' => env("SESSION_LIFETIME")
				])

				@include('components.bs.input', [
					'name' => 'INBOX_LIMIT',
					'info' => 'Jumlah notifikasi dalam inbox.',
					'label' => 'Had Inbox Pengguna',
					'mode' => 'required',
					'class' => 'text-lowercase',
					'value' => env("INBOX_LIMIT")
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

