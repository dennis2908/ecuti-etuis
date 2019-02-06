@extends('layouts.app')
@include('plugins.chartjs')

@section('content')
<!-- START BREADCRUMB -->
<div class="jumbotron m-b-0" data-pages="parallax">
	<div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
		<div class="inner" style="transform: translateY(0px); opacity: 1;">
			{{ Breadcrumbs::render('report') }}
			<!-- END BREADCRUMB -->
			<div class="row">
				<div class="col-xl-12 col-lg-12 ">
					<!-- START card -->
					<div class="card card-transparent">
						<div class="card-block p-t-0">
							<h3 class='m-t-0'>Pilihan <span class="semi-bold">Laporan</span></h3>
							<p class="small hint-text m-t-5">
								Sila tapis maklumat laporan yang ingin dipaparkan.
							</p>
							<form class="p-t-10" id="form-report" role="form" autocomplete="off">
								<div class="form-group-attached">
									<div class="form-group form-group-default form-group-default-select2">
										<label>Jenis Laporan</label>
										<select name="report_id" id="report_id" class="full-width" data-placeholder="Pilih Laporan" data-init-plugin="select2" required>
											<option value="" selected disabled hidden>Pilih Laporan</option>
											@foreach($reports as $report)
											<option value="{{ $report->id }}">{{ $report->name }}</option>
											@endforeach
										</select>
									</div>
									<div class="row clearfix">
										<div class="col-md-5">
											<div class="form-group form-group-default form-group-default-select2">
												<label>Mengikut Industri</label>
												<select name="industry_type_id" id="industry_type_id" class="full-width" data-init-plugin="select2">
													<option value="">-- Semua Industri --</option>
													@foreach($industries as $industry)
													<option value="{{ $industry->id }}">{{ $industry->name }}</option>
													@endforeach
												</select>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group form-group-default form-group-default-select2">
												<label>Mengikut Sektor</label>
												<select name="sector_id" class="full-width" data-init-plugin="select2">
													<option value="">-- Semua Sektor --</option>
													@foreach($sectors as $sector)
													<option value="{{ $sector->id }}">{{ $sector->name }}</option>
													@endforeach
												</select>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group form-group-default form-group-default-select2">
												<label>Mengikut Pecahan Etoi</label>
												<select name="sector_category_id" class="full-width" data-init-plugin="select2">
													<option value="">-- Semua Etoi --</option>
													@foreach($categories as $category)
													<option value="{{ $category->id }}">{{ $category->name }}</option>
													@endforeach
												</select>
											</div>
										</div>
									</div>
									<div class="row clearfix">
										<div class="col-md-6">
											<div class="form-group form-group-default form-group-default-select2">
												<label>Mengikut Pejabat Wilayah</label>
												<select name="province_office_id" class="full-width" data-init-plugin="select2">
													<option value="">-- Semua Pejabat --</option>
													@foreach($offices as $office)
													<option value="{{ $office->id }}">{{ $office->name }}</option>
													@endforeach
												</select>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group form-group-default form-group-default-select2">
												<label>Dari Tahun</label>
												<select name="start_year" class="full-width year" data-placeholder="Pilih Tahun" data-init-plugin="select2">
													@foreach($years as $year)
													<option value="{{ $year }}">{{ $year }}</option>
													@endforeach
												</select>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group form-group-default form-group-default-select2">
												<label>Sehingga Tahun</label>
												<select name="end_year" class="full-width year" data-placeholder="Pilih Tahun" data-init-plugin="select2">
													@foreach($years as $year)
													<option value="{{ $year }}">{{ $year }}</option>
													@endforeach
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="pull-right p-t-10 p-b-10">
									<a class="btn btn-default" onclick="reset()">Reset</a>
									<button class="btn btn-info" type="submit"><i class="fa fa-check m-r-5"></i> Jana Laporan</button>
								</div>
								<br>
							</form>
						</div>
					</div>
					<!-- END card -->
				</div>
			</div>
		</div>
	</div>
</div>

<!-- END BREADCRUMB -->
<div id="rootwizard">
	<!-- Nav tabs -->
	<ul class="nav nav-tabs nav-tabs-linetriangle nav-tabs-separator nav-stack-sm" role="tablist" {{-- data-init-reponsive-tabs="dropdownfx" --}} >
		<li class="nav-item ml-md-3">
			<a class="active" data-toggle="tab" href="#" data-target="#tab1" role="tab"><i class="fa fa-check tab-icon text-success"></i> <span>Perwakilan Graf</span></a>
		</li>
		<li class="nav-item">
			<a class="" data-toggle="tab" href="#" data-target="#tab2" role="tab"><i class="fa fa-check tab-icon text-success"></i> <span>Tabulasi Data</span></a>
		</li>
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
		{{--
		<div class="tab-pane active slide-right" id="tab1">
			@include('report.tab1')
		</div>
		<div class="tab-pane slide-right" id="tab2">
			@include('report.tab2')
		</div>
		--}}
	</div>

</div>
@endsection

@push('js')
<script type="text/javascript">

	function reset() {
		$("select").val("").trigger("change");
	}

	$("#form-report").submit(function(e) {
		e.preventDefault();
		var form = $(this);
		$(".tab-content").load("{{ route('report.item') }}"+"?"+form.serialize());
		$('.nav-tabs a:first').tab('show');
	});
</script>
@endpush
