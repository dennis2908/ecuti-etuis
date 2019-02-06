@extends('layouts.app')
@include('plugins.datatables')
@include('plugins.wizard')

@section('content')
<!-- START JUMBOTRON -->
<div class="jumbotron m-b-0" data-pages="parallax">
    <div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
        <div class="inner">
            <!-- START BREADCRUMB -->
            {{ Breadcrumbs::render('admin.holiday') }}
            <!-- END BREADCRUMB -->
            <div class="row">
                <div class="col-xl-12 col-lg-12 ">
                    <!-- START card -->
                    <div class="card card-transparent">
                        <div class="card-block p-t-0">
                            <h3 class='m-t-0'>Pengurusan Cuti</h3>
                            <p class="small hint-text m-t-5">
                                Pengurusan cuti boleh dilakukan melalui jaduan di bawah.
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
	<!-- Nav tabs -->
	<ul class="nav nav-tabs nav-tabs-linetriangle nav-tabs-separator nav-stack-sm" role="tablist" {{-- data-init-reponsive-tabs="dropdownfx" --}} >
		<li class="nav-item ml-md-3">
			<a class="active" data-toggle="tab" href="#" data-target="#tab1" role="tab"><i class="fa fa-check tab-icon text-success"></i> <span>Cuti Persekutuan / Umum (Seluruh Negara)</span></a>
		</li>
		<li class="nav-item">
			<a class="" data-toggle="tab" href="#" data-target="#tab2" role="tab"><i class="fa fa-check tab-icon text-success"></i> <span>Cuti Negeri / Khas</span></a>
		</li>
		<li class="nav-item">
			<a class="" data-toggle="tab" href="#" data-target="#tab3" role="tab"><i class="fa fa-check tab-icon text-success"></i> <span>Cuti Minggu</span></a>
		</li>
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
		<div class="tab-pane active slide-right" id="tab1">
			@include('admin.holiday.tab1.index')
		</div>
		<div class="tab-pane slide-right" id="tab2">
			@include('admin.holiday.tab2.index')
		</div>
		<div class="tab-pane slide-right" id="tab3">
			@include('admin.holiday.tab3')
		</div>
	</div>
</div>
@endsection
