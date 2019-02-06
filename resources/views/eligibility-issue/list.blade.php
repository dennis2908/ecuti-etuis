@extends('layouts.app')
@include('plugins.dropzone')
@include('plugins.datatables')

@section('content')
<!-- START JUMBOTRON -->
<div class="jumbotron" data-pages="parallax">
    <div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
        <div class="inner">
            <!-- START BREADCRUMB -->
            {{ Breadcrumbs::render('eligibility-issue') }}
            <!-- END BREADCRUMB -->
            <div class="row">
                <div class="col-xl-12 col-lg-12 ">
                    <!-- START card -->
                    <div class="card card-transparent">
                        <div class="card-block p-t-0">
                            <h3 class='m-t-0'>Siasatan Isu Kelayakan Tuntutan Pengiktirafan</h3>
                            <p class="small hint-text m-t-5">
                                Pengurusan permohonan Siasatan Isu Kelayakan Tuntutan Pengiktirafan boleh dilakukan melalui jadual di bawah.
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
            	@if(auth()->user()->hasRole('pthq'))
                <button onclick="location.href='{{ route('eligibility-issue') }}'" class="btn btn-success btn-cons"><i class="fa fa-plus m-r-5"></i> Daftar Siasatan</button>
                @endif
            </div>
            <div class="pull-right">
                <div class="col-xs-12">
                    <input type="text" id="search-table" class="form-control search-table pull-right" placeholder="Carian">
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="card-block table-responsive">
            <table class="table table-hover" id="table">
                <thead>
                    <tr>
                        <th class="fit">Bil.</th>
                        <th>Nama Kesatuan</th>
                        <th>Jenis Entiti</th>
                        <th>Tarikh Siasatan</th>
                        <th>Status</th>
                        <th>Surat / Lampiran</th>
                        <th class="fit">Tindakan</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <!-- END card -->
</div>
<!-- END CONTAINER FLUID -->
@endsection
@push('modal')
<div class="modal fade slide-up show" id="modal-view" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content-wrapper">
            <div class="modal-content">
                <div class="modal-header clearfix text-left" style="background-color: #f3f3f3;">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                    </button>
                    <h5>Maklumat <span class="semi-bold">Permohonan Kesatuan Sekerja</span></h5>
                    <p class="p-b-10">Semua maklumat berkenaan Pendaftaran tersebut telah dipaparkan dalam bentuk kronologi dibawah</p>

                    <div class="pb-3">
                        Nama Kesatuan: <a onclick="openModalKS()" href="javascript:;" class="text-complete bold">Kesatuan Unijaya</a ></span><br>
                        Tarikh Penubuhan: <strong>19/01/2018</strong><br>
                        Nama Setiausaha: <strong>Adlan Arif Zakaria</strong>
                    </div>
                </div>
                <div class="modal-body pt-3">
                    @include('sample.timeline.b')
                </div>
                <div class="modal-footer" style="background-color: #f3f3f3;">
                    <button type="button" class="btn btn-secondary mt-4" data-dismiss="modal">Tutup</button>
                    @if(auth()->user()->hasAnyRole(['ks']))
                    <button onclick="retractData(1)" class="btn btn-danger mt-4"><i class="fa fa-check mr-1"></i> Tarik Balik</button>
                    @endif
                    @if(auth()->user()->hasAnyRole(['ptw','pthq']))
                    <button onclick="acceptData(1)" class="btn btn-info mt-4"><i class="fa fa-check mr-1"></i> Terima Dokumen Fizikal</button>
                    @endif
                    @if(auth()->user()->hasAnyRole(['ks','ppw','pthq']))
                    <a href="{{ route('eligibility-issue') }}" class="btn btn-primary mt-4"><i class="fa fa-edit mr-1 text-capitalize"></i> Kemaskini Borang</a>
                    @endif
                    @if(auth()->user()->hasAnyRole(['pw', 'pkpg', 'kpks']))
                    <button onclick="queryData(1)" class="btn btn-warning mt-4"><i class="fa fa-question mr-1"></i> Kuiri</button>
                    @endif
                    @if(auth()->user()->hasAnyRole(['pphq', 'pkpg']))
                    <button onclick="commentData(1)" class="btn btn-warning mt-4"><i class="fa fa-comment mr-1"></i> Ulasan/Syor</button>
                    @endif
                    @if(auth()->user()->hasAnyRole(['ppw', 'pw']))
                    <button onclick="reportData(1)" class="btn btn-info mt-4"><i class="fa fa-spinner mr-1"></i> Hantar Laporan</button>
                    @endif
                    @if(auth()->user()->hasRole('kpks'))
                    <button onclick="processData(1)" class="btn btn-success mt-4"><i class="fa fa-spinner mr-1"></i> Proses</button>
                    @endif
                    @if(auth()->user()->hasRole('pthq'))
                    <button onclick="jppmData(1)" class="btn btn-success mt-4"><i class="fa fa-spinner mr-1"></i> Syor JPPM</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade disable-scroll" id="modal-report" tabindex="-1" role="dialog" aria-hidden="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="modal-header clearfix text-left">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
					</button>
					<h5>Laporan <span class="semi-bold"></span></h5>
					<p class="p-b-10">Sila isikan ruangan di bawah untuk laporan.</p>
				</div>
				<div class="modal-body">
					<form role="form" id="form-newpermission" method="post" action="">
						<div class="form-group-attached">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group form-group-default required">
										<label>Tarikh</label>
		                      			<input type="text" class="form-control datepicker" name="filing_date_fa" value="{{ date('d/m/Y') }}" >
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group form-group-default required">
										<label>Keputusan</label>
										<div class="radio radio-primary" style="padding-left: 0px !important;">
											<input name="type" value="1" id="radio1" type="radio" class="hidden">
											<label for="radio1">Termasuk</label>

											<input name="type" value="2" id="radio2" type="radio" class="hidden">
											<label for="radio2">Tidak Termasuk</label>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group form-group-default required">
										<label>Ulasan</label>
										<textarea style="height: 150px;" placeholder="" class="form-control" required></textarea>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
					<button type="button" class="btn btn-info" onclick="submitAdd()" data-dismiss="modal">Hantar</button>
				</div>
			</div>
		</div>
	</div>
</div>
@endpush

@push('js')
<script type="text/javascript">

var table = $('#table');

var settings = {
    "processing": true,
    "serverSide": true,
    "deferRender": true,
    "ajax": "{{ fullUrl() }}",
    "columns": [
        { data: 'index', defaultContent: '', orderable: false, searchable: false, render: function (data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
        }},
        { data: "entity.name", name: "entity.name", defaultContent: '-'},
        { data: "entity_type", name: "entity_type"},
        { data: "investigation_date", name: "investigation_date"},
        { data: "status.name", name: "status.name", render: function(data, type, row){
            return $("<div/>").html(data).text();
        }},
        { data: "letter", name: "letter", searchable: false, render: function(data, type, row){
            return $("<div/>").html(data).text();
        }},
        { data: "action", name: "action", orderable: false, searchable: false},
    ],
    "columnDefs": [
        { className: "nowrap", "targets": [ 6 ] }
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
    "iDisplayLength": -1
};

table.dataTable(settings);

// search box for table
$('#search-table').keyup(function() {
    table.fnFilter($(this).val());
});

function viewData(id) {
	$("#modal-view").modal("show");
}

function retractData(id) {
	swal({
		title: "Tarik Balik Permohonan",
		text: "Permohonan Tuntutan Pengiktirafan ditarik balik",
		icon: "info",
		buttons: ["Tutup", { text: "Hantar", closeModal: false, className: "btn-info" }],

	})
	.then((data) => {
		console.log(data);
		if (data !== null)
			swal("Berjaya", "PWN dan HQ akan dimaklumkan melalui emel.", "success");
	});
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////

function report(id) {
    $("#modal-div").load("{{ route('eligibility-issue') }}/"+id+"/process/report");
}

function process(id) {
    $("#modal-div").load("{{ route('eligibility-issue') }}/"+id+"/process/result");
}

function receive(id) {
    $("#modal-div").load("{{ route('eligibility-issue') }}/"+id+"/process/document-receive");
}

function query(id) {
    $("#modal-div").load("{{ route('eligibility-issue') }}/"+id+"/process/query");
}

function recommend(id) {
    $("#modal-div").load("{{ route('eligibility-issue') }}/"+id+"/process/recommend");
}

</script>
@endpush
