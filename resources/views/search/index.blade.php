@extends('layouts.app')
@include('plugins.datatables')

@push('css')
<style type="text/css">
	.form-group-default.input-group .input-group-addon {
		height: 100% !important;
	}
</style>
@endpush

@section('content')
<!-- START JUMBOTRON -->
<div class="jumbotron" data-pages="parallax">
	<div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
		<div class="inner" style="transform: translateY(0px); opacity: 1;">
			{{ Breadcrumbs::render('search') }}
			<!-- END BREADCRUMB -->
			<div class="row">
				<div class="col-xl-12 col-lg-12 ">
					<!-- START card -->
					<div class="card card-transparent">
						<div class="card-block p-t-0">
							<h3 class='m-t-0'>Carian</h3>
							<p class="small hint-text m-t-5">
								Sila tapis maklumat permohonan yang ingin dipaparkan.
							</p>
							<form class="p-t-10" id="form-search" role="form" autocomplete="off" method="post" action="{{ route('search.list') }}" novalidate>
								<div class="form-group-attached">
									<div class="row clearfix">
										<div class="col-md-5">
											@include('components.input', [
												'name' => 'reference_no',
												'label' => 'Kata Kunci',
												'placeholder' => 'Nombor Rujukan'
											])
										</div>
										<div class="col-md-7">
											<div class="form-group form-group-default form-group-default-select2 form-group-default-custom">
                                                <label>Kesatuan / Persekutuan</label>
                                                <select  id="user_id" name="user_id" class="full-width autoscroll select-modal" data-init-plugin="select2" >
                                                    <option value="" selected>Pilih satu</option>
                                                    @foreach($users as $user)
                                                        <option value="{{ $user->id }}"
                                                            >{{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
										</div>
									</div>
									<div class="row clearfix">
										<div class="col-md-6">
											<div class="form-group form-group-default form-group-default-select2 form-group-default-custom">
                                                <label>Jenis Modul</label>
                                                <select  id="module_id" name="module_id" class="full-width autoscroll select-modal" data-init-plugin="select2" >
                                                    <option value="" selected>Pilih satu</option>
                                                    @foreach($modules as $module)
                                                        <option value="{{ $module->id }}"
                                                            >{{ $module->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
										</div>
										<div class="col-md-3">
											@include('components.date', [
												'name' => 'start_date',
												'label' => 'Tarikh Mula',
											])
										</div>
										<div class="col-md-3">
											@include('components.date', [
												'name' => 'end_date',
												'label' => 'Tarikh Akhir',
											])
										</div>
									</div>
								</div>
								<div class="pull-right p-t-10 p-b-10">
									<a class="btn btn-default" onclick="reset()">Reset</a>
									<button class="btn btn-info" type="button" onclick="submitForm('form-search')"><i class="fa fa-check m-r-5"></i> Hantar</button>
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
<!-- END JUMBOTRON -->
<!-- START CONTAINER FLUID -->
<div class=" container-fluid container-fixed-lg bg-white" style="display: none" id="table-result">
    <!-- START card -->
    <div class="card card-transparent">
        <div class="card-block">
            <table class="table table-hover" id="table" >
                <thead>
                    <tr>
                        <th class="fit">Bil.</th>
                        <!-- <th>Nama Kesatuan</th> -->
                        <th>Nombor Rujukan</th>
						<th>Kesatuan / Persekutuan</th>
                        <th>Tarikh Permohonan</th>
                        <th>Status</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <!-- END card -->
</div>
<!-- END CONTAINER FLUID -->
@endsection

@push('js')
<script>

$("#form-search").submit(function(e) {
	e.preventDefault();
	var form = $(this);

	$("#table-result").slideDown();

	var table = $('#table');

	var settings = {
		"processing": true,
		"serverSide": true,
		"deferRender": true,
		"ajax" : form.attr('action')+"?"+form.serialize(),
		"columns": [
			{ data: 'index', defaultContent: '', orderable: false, searchable: false, render: function (data, type, row, meta) {
				return meta.row + meta.settings._iDisplayStart + 1;
			}},
			{ data: "reference_no", name: "reference_no"},
			{ data: "filing.tenure.entity.name", name: "filing.tenure.entity.namename"},
			{ data: "filing.created_at", name: "filing.created_at"},
			{ data: "filing.status.name", name: "filing.status.name", render: function(data, type, row){
			    return $("<div/>").html(data).text();
			}},
			{ data: "action", name: "action", orderable: false, searchable: false},
		],
		"columnDefs": [
			{ className: "nowrap", "targets": [ 5 ] }
		],
		"sDom": "<t><'row'<p i>>",
		"destroy": true,
		"scrollCollapse": true,
		"oLanguage": {
			"sEmptyTable":      "Tiada data",
			"sInfo":            "Paparan dari _START_ hingga _END_ dari _TOTAL_ rekod",
			"sInfoEmpty":       "Paparan 0 hingga 0 dari 0 rekod",
			"sInfoFiltered":    "(Ditapis dari jumlah _MAX_ rekod)",
			"sInfoPostFix":     "",
			"sInfoThousands":   ",",
			"sLengthMenu":      "Papar _MENU_ rekod",
			"sLoadingRecords":  "Diproses...",
			"sProcessing":      "Sedang diproses...",
			"sSearch":          "Carian:",
		   "sZeroRecords":      "Tiada padanan rekod yang dijumpai.",
		   "oPaginate": {
			   "sFirst":        "Pertama",
			   "sPrevious":     "Sebelum",
			   "sNext":         "Kemudian",
			   "sLast":         "Akhir"
		   },
		   "oAria": {
			   "sSortAscending":  ": diaktifkan kepada susunan lajur menaik",
			   "sSortDescending": ": diaktifkan kepada susunan lajur menurun"
		   }
		},
		"iDisplayLength": 10
	};

	table.dataTable(settings);

});

function reset() {
	$("#table-result").slideUp();
	$("#form-search").trigger("reset");
	$("#user_id").val("").trigger("change");
	$("#module_id").val("").trigger("change");
}

function viewData(id) {
	$("#modal-div").load("{{ route('search') }}/"+id);
}
</script>
@endpush
