@extends('layouts.app')

@section('content')
<!-- START JUMBOTRON -->
<div class="jumbotron" data-pages="parallax">
	<div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
		<div class="inner">
			<!-- START BREADCRUMB -->
			{{ Breadcrumbs::render('formk.query') }}
			<div class="row">
				<div class="col-xl-12 col-lg-12 ">
					<!-- START card -->
					<div class="card card-transparent">
						<div class="card-block p-t-0">
							<h3 class='m-t-0'>Kuiri Borang K</h3>
							<p class="small hint-text m-t-5">
								Sila isi ruangan di bawah untuk ulasan kuiri.
							</p>
						</div>
					</div>
					<!-- END card -->
				</div>
			</div>
		</div>
	</div>
</div>
<!-- END JUMBOTRON -->

<!-- START CONTAINER FLUID -->
<div class=" container-fluid container-fixed-lg bg-white">
	<!-- START card -->
	<div class="card card-transparent">
		<div class="card-header px-0">
			<div class="card-title">
				<a href="javascript:;" onclick="submitQuery()" class="btn btn-info pull-right btn-input text-capitalize"><i class="fa fa-check mr-1"></i> Hantar Kuiri</a>
			</div>
			<div class="pull-right">
				<div class="col-xs-12">
					<input type="text" id="search-table" class="form-control search-table pull-right" placeholder="Carian">
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="card-block table-reponsive">
			<table class="table table-hover " id="table-appeals">
				<thead>
					<tr>
						<th class="fit">Bil.</th>
						<th>Peraturan Lama</th>
						<th>Peraturan Baru</th>
						<th>Ulasan Kuiri</th>
					</tr>
				</thead>
				<tbody>
					@foreach(range(1,5) as $index)
					<tr>
						<td>{{ $index }}.</td>
						<td>Vivamus efficitur accumsan ligula et ultrices. Quisque ultricies imperdiet est, non fringilla lorem luctus nec. Maecenas condimentum sem et massa vulputate, nec iaculis libero rhoncus.</td>
						<td>Vivamus efficitur accumsan ligula et ultrices. Quisque ultricies imperdiet est, non fringilla lorem luctus nec. Maecenas condimentum sem et massa vulputate, nec iaculis libero rhoncus.</td>
						<td>
							<textarea class="form-control" style="min-height: 100px; min-width: 300px;"></textarea>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			<br>
			<div class="form-group">
				<button type="button" class="btn btn-default mr-1" ><i class="fa fa-angle-left mr-1"></i> Kembali</button>
				<button type="button" class="btn btn-info pull-right" onclick="submitQuery()"><i class="fa fa-check mr-1"></i> Hantar Kuiri</button>
			</div>
		</div>
	</div>
	<!-- END card -->
</div>
<!-- END CONTAINER FLUID -->

@endsection
