@extends('layouts.app')
@include('plugins.datatables')
@include('plugins.wizard')

@section('content')
<!-- START JUMBOTRON -->
<div class="jumbotron m-b-0" data-pages="parallax">
	<div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
		<div class="inner">
			<!-- START BREADCRUMB -->
			{{ Breadcrumbs::render('enforcement.pbp2') }}
			<div class="row">
				<div class="col-xl-12 col-lg-12 ">
					<!-- START card -->
					<div class="card card-transparent">
						<div class="card-block p-t-0">
							<h3 class='m-t-0'>Maklumat Mengenai Pemeriksa Undi, Pemegang Amanah dan Penimbangtara Kesatuan</h3> 
							<p class="small hint-text m-t-5">
								Lampiran D1
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

<div id="rootwizard">
	<ul class="nav nav-tabs nav-tabs-linetriangle nav-tabs-separator nav-stack-sm" role="tablist" {{-- data-init-reponsive-tabs="dropdownfx" --}} >
		<li class="nav-item ml-md-3">
			<a class="active" data-toggle="tab" href="#" data-target="#tab1" role="tab"><i class="fa fa-check tab-icon text-success"></i> <span>Pemeriksa Undi</span></a>
		</li>
		<li class="nav-item">
			<a class="" data-toggle="tab" href="#" data-target="#tab2" role="tab"><i class="fa fa-check tab-icon text-success"></i> <span>Pemegang Amanah</span></a>
		</li>
		<li class="nav-item">
			<a class="" data-toggle="tab" href="#" data-target="#tab3" role="tab"><i class="fa fa-check tab-icon text-success"></i> <span>Jemaah Penimbangtara</span></a>
		</li>
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
		<div class="tab-pane active slide-right" id="tab1">
			@include('enforcement.pbp2.d1.tab1.index')
		</div>
		<div class="tab-pane slide-right" id="tab2">
			@include('enforcement.pbp2.d1.tab2.index')
		</div>
		<div class="tab-pane slide-right" id="tab3">
			@include('enforcement.pbp2.d1.tab3.index')
		</div>
	</div>
</div>
@endsection