@extends('layouts.app')
@include('plugins.datatables')
@include('plugins.wizard')

@section('content')
<!-- START JUMBOTRON -->
<div class="jumbotron m-b-0" data-pages="parallax">
    <div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
        <div class="inner">
            <!-- START BREADCRUMB -->
            {{ Breadcrumbs::render('staff.holiday_approved') }}
            <!-- END BREADCRUMB -->
            <div class="row">
                <div class="col-xl-12 col-lg-12 ">
                    <!-- START card -->
                    <div class="card card-transparent">
                        <div class="card-block p-t-0">
                            <h3 class='m-t-0'>Approved Cuti</h3>
                            <p class="small hint-text m-t-5">
                                Approved Cuti
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


	<!-- Tab panes -->
	<div class="tab-content">
		<div class="tab-pane active slide-right" id="tab1">
			@include('staff.holiday_approved.tab1.index')
		</div>

		</div>
</div>
@endsection