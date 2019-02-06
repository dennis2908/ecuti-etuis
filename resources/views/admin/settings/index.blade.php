@extends('layouts.app')
@include('plugins.wizard')

@section('content')
<!-- START JUMBOTRON -->
<div class="jumbotron m-b-0" data-pages="parallax">
    <div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
        <div class="inner">
            <!-- START BREADCRUMB -->
            {{ Breadcrumbs::render('admin.settings') }}
            <!-- END BREADCRUMB -->
            <div class="row">
                <div class="col-xl-12 col-lg-12 ">
                    <!-- START card -->
                    <div class="card card-transparent">
                        <div class="card-block p-t-0">
                            <h3 class='m-t-0'>Konfigurasi Sistem</h3>
                            <p class="small hint-text m-t-5">
                                Sistem e-TUIS boleh dikonfigurasi melalui ruangan di bawah.
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
			<a class="active" data-toggle="tab" href="#" data-target="#tab1" role="tab"><i class="fa fa-check tab-icon text-success"></i> <span>Sistem</span></a>
		</li>
		<li class="nav-item">
			<a class="" data-toggle="tab" href="#" data-target="#tab2" role="tab"><i class="fa fa-check tab-icon text-success"></i> <span>Database</span></a>
		</li>
		<li class="nav-item">
			<a class="" data-toggle="tab" href="#" data-target="#tab3" role="tab"><i class="fa fa-check tab-icon text-success"></i> <span>Emel</span></a>
		</li>
		<li class="nav-item">
			<a class="" data-toggle="tab" href="#" data-target="#tab4" role="tab"><i class="fa fa-check tab-icon text-success"></i> <span>Penyelenggaraan</span></a>
		</li>
		<li class="nav-item">
			<a class="" data-toggle="tab" href="#" data-target="#tab5" role="tab"><i class="fa fa-check tab-icon text-success"></i> <span>Umum</span></a>
		</li>
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
		<div class="tab-pane active slide-right" id="tab1">
			@include('admin.settings.tab1')
		</div>
		<div class="tab-pane slide-right" id="tab2">
			@include('admin.settings.tab2')
		</div>
		<div class="tab-pane slide-right" id="tab3">
			@include('admin.settings.tab3')
		</div>
		<div class="tab-pane slide-right" id="tab4">
			@include('admin.settings.tab4')
		</div>
		<div class="tab-pane slide-right" id="tab5">
			@include('admin.settings.tab5')
		</div>
	</div>
</div>
@endsection

@push('js')
<script type="text/javascript">
$("form").submit(function(e) {
    e.preventDefault();
    var form = $(this);

    if(!form.valid())
      return;

    $.ajax({
        url: form.attr('action'),
        method: form.attr('method'),
        data: new FormData(form[0]),
        dataType: 'json',
        async: true,
        contentType: false,
        processData: false,
        success: function(data) {
          swal(data.title, data.message, data.status);
        }
    });
});
</script>
@endpush