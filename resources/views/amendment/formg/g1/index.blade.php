@extends('layouts.app')
@include('plugins.datatables')

@section('content')
@include('components.msg-disconnected')
<!-- START JUMBOTRON -->
<div class="jumbotron" data-pages="parallax">
	<div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
		<div class="inner" style="transform: translateY(0px); opacity: 1;">
			<!-- START BREADCRUMB -->
			{{ Breadcrumbs::render('formg.g1') }}
			<!-- END BREADCRUMB -->
			<div class="row">
				<div class="col-xl-12 col-lg-12 ">
					<!-- START card -->
					<div class="card card-transparent">
						<div class="card-block p-t-0">
							<h3 class='m-t-0'>Borang G - Notis Pertukaran Nama</h3>
							<p class="small hint-text m-t-5">
								AKTA KESATUAN SEKERJA, 1959 (Seksyen 34 (1) dan Peraturan 12(1))
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
@include('components.msg-connecting')
<div class=" container-fluid container-fixed-lg bg-white">
	<!-- START card -->
	<div class="card card-transparent">
		<div class="card-block">
			<div>
				<form id="form-formg" class="form-horizontal" role="form" autocomplete="off" method="post" action="#">
					@component('components.bs.label', [
						'label' => 'Nama Kesatuan Sekerja',
					])
					{{ $formg->tenure->entity->name }}
					@endcomponent

					@component('components.bs.label', [
						'label' => 'No. Sijil Pendaftaran',
					])
					{{ $formg->tenure->entity->registration_no }}
					@endcomponent

					@component('components.bs.label', [
						'label' => 'Alamat Ibu Pejabat',
					])
					{!! $formg->address->address1.
					($formg->address->address2 ? ',<br>'.$formg->address->address2 : '').
					($formg->address->address3 ? ',<br>'.$formg->address->address3 : '').
					',<br>'.
					$formg->address->postcode.' '.
					($formg->address->district ? $formg->address->district->name : '').', '.
					($formg->address->state ? $formg->address->state->name : '') !!}
					@endcomponent

					@include('components.bs.input', [
						'name' => 'name',
						'label' => 'Nama Baru Kesatuan Sekerja',
						'mode' => 'required',
						'value' => $formg->name,
					])

					@include('components.bs.textarea', [
						'name' => 'justification',
						'label' => 'Justifikasi',
						'mode' => 'required',
						'value' => $formg->justification,
					])

					<div class="form-group row">
						<label for="" class="col-md-3 control-label">
							Melalui (Jenis Mesyuarat)<span style="color:red;">*</span>
						</label>
						<div class="col-md-9">
							<div class="radio radio-primary">
								@foreach($meeting_types as $meeting_type)
									<input name="meeting_type_id" value="{{ $meeting_type->id }}" id="meeting_type_{{ $meeting_type->id }}" type="radio" class="hidden" required>
									<label for="meeting_type_{{ $meeting_type->id }}">{{ $meeting_type->name }}</label>
								@endforeach
							</div>
						</div>
					</div>

					@include('components.bs.date', [
						'name' => 'resolved_at',
						'label' => 'Tarikh Diputuskan',
						'mode' => 'required',
						'value' =>  $formg->resolved_at ? date('d/m/Y', strtotime($formg->resolved_at)) : '',
					])

					@include('components.bs.input', [
						'name' => 'certification_no',
						'label' => 'No. Perakuan Pendaftaran',
						'mode' => 'required',
						'value' => $formg->certification_no,
					])

					@component('components.bs.label', [
						'name' => 'secretary',
						'label' => 'Nama Setiausaha ',
					])
					{{ $formg->secretary->name }}
					@endcomponent

					<div class="form-group row">
						<label for="fname" class="col-md-3 control-label">Nama Ahli-Ahli (Wajib 7 orang ahli) <span style="color:red;">*</span></label>
						<div class="col-md-9">
							<table class="table table-hover" id="table-member">
								<thead>
									<tr>
										<th class="fit">Bil.</th>
										<th>Nama Ahli</th>
										<th style="width:10%"></th>
									</tr>
								</thead>
							</table>
							<div class="card-title p-t-10">
	                            <button onclick="addMember()" class="btn btn-primary btn-cons" type="button"><i class="fa fa-plus m-r-5"></i> Tambah Ahli</button>
	                        </div>
						</div>
					</div>

					@include('components.bs.date', [
						'name' => 'applied_at',
						'label' => 'Tarikh Permohonan',
						'mode' => 'required',
						'value' =>  $formg->applied_at ? date('d/m/Y', strtotime($formg->applied_at)) : date('d/m/Y'),
					])

					<div class="form-group">
						<button type="button" class="btn btn-default mr-1" onclick="location.href='{{ route('formg.form', $formg->id) }}'"><i class="fa fa-angle-left mr-1"></i> Kembali</button>
						<button type="button" class="btn btn-info pull-right" onclick="save()"><i class="fa fa-check mr-1"></i> Simpan</button>
					</div>
				</form>
			</div>
    	</div>
    </div>
</div>
@endsection

@push('modal')
<div class="modal fade" id="modal-addMember" tabindex="-1" role="dialog" aria-hidden="false">
	<div class="modal-dialog">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="modal-header clearfix text-left">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
					</button>
					<h5>Maklumat <span class="semi-bold">Ahli</span></h5>
					<p class="p-b-10">Sila lengkapkan ruangan di bawah.</p>
				</div>
				<div class="modal-body">
					<form id="form-add-member" role="form" method="post" action="{{ route('formg.g1.form.member', $formg->id) }}">
						<div class="form-group-attached">
							<div class="row">
								<div class="col-md-12">
                                    @include('components.input', [
										'name' => 'member',
										'label' => 'Nama Ahli',
										'mode' => 'required',
									])
                                </div>
							</div>
						</div>
					</form>
					<div class="row">
						<div class="col-md-12 p-t-10">
							<button type="button" class="btn btn-info m-t-5 pull-right submit" onclick="submitForm('form-add-member')"><i class="fa fa-check" ></i> Simpan</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
</div>
@endpush

@push('js')
<script type="text/javascript">

var table = $('#table-member');

var settings = {
	"processing": true,
	"serverSide": true,
	"deferRender": true,
	"ajax": "{{ route('formg.g1.form.member', $formg->id) }}",
	"columns": [
		{ data: 'index', defaultContent: '', orderable: false, searchable: false, render: function (data, type, row, meta) {
			return meta.row + meta.settings._iDisplayStart + 1;
		}},
		{ data: "name", name: "name"},
		{ data: "action", name: "action", orderable: false, searchable: false},
	],
	"columnDefs": [
		{ className: "nowrap", "targets": [ 2 ] }
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
	"iDisplayLength": 7
};

table.dataTable(settings);

$("#form-formg").validate();

function save() {
    swal({
        title: "Berjaya!",
        text: "Data yang telah disimpan.",
        icon: "success",
        button: "OK",
    })
    .then((confirm) => {
        if (confirm) {
            location.href="{{ route('formg.form', $formg->id) }}";
        }
    });
}

function addMember() {
	$('#modal-addMember').modal('show');
	$('.modal form').trigger("reset");
	$('.modal form').validate();
}

$("#form-add-member").submit(function(e) {
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
			$("#modal-addMember").modal("hide");
			table.api().ajax.reload(null, false);
		}
	});
});

function editMember(id) {
	$("#modal-div").load("{{ route('formg.g1.form.member', $formg->id) }}/"+id);
}

function removeMember(id) {
	$.ajax({
		url: '{{ route('formg.g1.form.member', $formg->id) }}/'+id,
		method: 'delete',
		dataType: 'json',
		async: true,
		contentType: false,
		processData: false,
		success: function(data) {
			table.api().ajax.reload(null, false);
		}
	});
}

$(document).ready(function(){
	$("#meeting_type_{{ $formg->meeting_type_id }}").prop('checked', true).trigger('change');

    var socket = io('{{ env('SOCKET_HOST', '127.0.0.1') }}:{{ env('SOCKET_PORT', 3000) }}');

    socket.on('connect', function() {
        $(".msg-disconnected").slideUp();
        $(".msg-connecting").slideUp();
    });

    socket.on('disconnect', function() {
        $(".msg-disconnected").slideDown();
        $("html, body").animate({ scrollTop: 0 }, 500);
    });

    $('input, select, textarea').on('change', function() {
        socket.emit('formg', {
            id: {{ $formg->id }},
            name: $(this).attr('name'),
            value: $(this).attr('type') == 'checkbox' ? ($(this).prop('checked') ? 1 : 0) : $(this).val(),
            user: '{{ Cookie::get('api_token') }}'
        });
        console.log('changed');
    });
});

</script>
@endpush
