@extends('layouts.app')
@include('plugins.datatables')

@push('css')
<style>
.form-horizontal .form-group {
    border-bottom: unset !important;
}

span.clickable { cursor: pointer; }
</style>
@endpush

@section('content')
@include('components.msg-disconnected')
<!-- START BREADCRUMB -->
<div class="jumbotron" data-pages="parallax">
	<div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
		<div class="inner" style="transform: translateY(0px); opacity: 1;">
			{{ Breadcrumbs::render('pp30') }}
			<!-- END BREADCRUMB -->
			<div class="row">
				<div class="col-xl-12 col-lg-12 ">
					<!-- START card -->
					<div class="card card-transparent">
						<div class="card-block p-t-0">
							<h3 class='m-t-0'>Pengecualian Seksyen 30(b)</h3>
							<p class="small hint-text m-t-5">
								Sila lengkapkan semua maklumat berikut mengikut turutan dan arahan yang dipaparkan.
							</p>
						</div>
					</div>
					<!-- END card -->
				</div>
			</div>
		</div>
	</div>
</div>
<!-- END BREADCRUMB -->

<!-- START CONTAINER FLUID -->
@include('components.msg-connecting')
<div class=" container-fluid container-fixed-lg bg-white">
	<!-- START card -->
	<div class="card card-transparent">
		<div class="card-block">
			<div>
                <form id="form-pp30" class="form-horizontal" role="form" autocomplete="off" method="post" action="#">

    				@component('components.bs.label', [
    					'label' => 'Nama Kesatuan Sekerja',
    				])
                    {{ $exception->tenure->entity->name }}
    				@endcomponent

    				@component('components.bs.label', [
    					'label' => 'No Sijil Pendaftaran',
    				])
                    {{ $exception->tenure->entity->registration_no }}
    				@endcomponent

                    @component('components.bs.label', [
                        'label' => 'Alamat Ibu Pejabat',
                    ])
                    {!! $exception->address->address1.
                    ($exception->address->address2 ? ',<br>'.$exception->address->address2 : '').
                    ($exception->address->address3 ? ',<br>'.$exception->address->address3 : '').
                    ',<br>'.
                    $exception->address->postcode.' '.
                    ($exception->address->district ? $exception->address->district->name : '').', '.
                    ($exception->address->state ? $exception->address->state->name : '') !!}
                    @endcomponent

    				@include('components.bs.date', [
    					'name' => 'requested_at',
    					'label' => 'Tarikh Pemilihan',
    					'mode' => 'required',
                        'value' =>  $exception->requested_at ? date('d/m/Y', strtotime($exception->requested_at)) : '',
    				])

    				<div class="form-group row">
    					<label for="fname" class="col-md-3 control-label">
    						Penggal Pemilihan Yang Dipohon
    					</label>
    					<div class="row col-md-9">
                            <select id="requested_tenure_id" name="requested_tenure_id" class="full-width autoscroll" data-init-plugin="select2" required>
                                <option disabled hidden selected>Pilih satu</option>
                                @foreach($tenures as $tenure)
                                <option value="{{ $tenure->id }}">{{ $tenure->start_year }} - {{ $tenure->end_year }}</option>
                                @endforeach
                            </select>
    					</div>
    				</div>

    				<div class="form-group row">
    					<label for="fname" class="col-md-3 control-label">Bilangan Majlis Jawatankuasa Kerja Mengikut Kewarganegaraan <span style="color:red;">*</span></label>
    					<div class="col-md-9">
    						<div class="row">
    							<div class="col-md-3">Warganegara</div>
    							<div class="col-md-9">
    								<select id="total_citizen" name="total_citizen" data-placeholder="" class="full-width autoscroll" data-init-plugin="select2">
    									<option disabled hidden selected>Pilih satu</option>
    									@foreach(range(1,20) as $index)
    									<option value="{{ $index }}">{{ $index }}</option>
    									@endforeach
    								</select>
    							</div>
    						</div>
    						<div class="row mt-1">
    							<div class="col-md-3">Bukan Warganegara</div>
    							<div class="col-md-9">
    								<select id="total_non_citizen" name="total_non_citizen" data-placeholder="" class="full-width autoscroll" data-init-plugin="select2">
    									<option disabled hidden selected>Pilih satu</option>
    									@foreach(range(1,20) as $index)
    									<option value="{{ $index }}">{{ $index }}</option>
    									@endforeach
    								</select>
    							</div>
    						</div>
    					</div>
    				</div>
                </form>

				<div class="form-group row">
					<label for="fname" class="col-md-3 control-label">Maklumat Pegawai Yang Memohon Pengecualian<span style="color:red;">*</span></label>
					<div class="col-md-9">
						<div class="input-group">
                            <select id="officer_id" name="officer_id" class="full-width autoscroll" data-init-plugin="select2" required="">
                                <option value="" selected="" disabled="">Pilih satu..</option>
                                @foreach($officers as $officer)
                                <option value="{{ $officer->id }}" designation="{{ $officer->designation->name }}">{{ $officer->name }}</option>
                                @endforeach
                            </select>
	                      	<span class="input-group-addon success clickable" style="background-color: #10CFBD !important" onclick="addOfficer()"><i class="fa fa-plus"></i></span>
	                    </div>
						<table>
							<table class="table table-hover" id="table-officer">
								<thead>
									<tr>
                                        <th class="fit">Bil.</th>
										<th>Nama Pegawai</th>
										<th>No. KP / No. Passpot</th>
										<th>Kewarganegaraan</th>
										<th>Jawatan</th>
										<th class="fit">Tindakan</th>
									</tr>
								</thead>
							</table>
						</table>
					</div>
				</div>

				<br>
				<div class="form-group">
					<button type="button" class="btn btn-default mr-1" onclick="location.href='{{ route('pp30.item', $exception->id) }}'"><i class="fa fa-angle-left mr-1"></i> Kembali</button>
					<button type="button" class="btn btn-info pull-right btn-send" onclick="save()" data-dismiss="modal"><i class="fa fa-check mr-1"></i> Simpan</button>
				</div>

			</div>
		</div>
	</div>
	<!-- END card -->
</div>
<!-- END CONTAINER FLUID -->
@endsection

@push('js')
<script>
$("#form-pp30").validate();

var table = $('#table-officer');

var settings = {
    "processing": true,
    "serverSide": true,
    "deferRender": true,
    "ajax": "{{ route('pp30.officer', $exception->id) }}",
    "columns": [
        { data: 'index', defaultContent: '', orderable: false, searchable: false, render: function (data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
        }},
        { data: "officer.name", name: "officer.name"},
        { data: "officer.identification_no", name: "officer.identification_no"},
        { data: "officer.country.name", name: "officer.country.name"},
        { data: "officer.designation.name", name: "officer.designation.name"},
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
    "iDisplayLength": -1
};

table.dataTable(settings);

// search box for table
$('#search-table').keyup(function() {
    table.fnFilter($(this).val());
});

function save() {
	swal({
		title: "Berjaya!",
		text: "Data yang telah disimpan.",
		icon: "success",
		button: "OK",
	})
	.then((confirm) => {
		if (confirm) {
			location.href="{{ route('pp30.item', $exception->id) }}";
		}
	});
}

function addOfficer() {

	if($('#officer_id option:selected').val() == '') {
		swal('Harap Maaf!', 'Sila isi ruangan terlebih dahulu.', 'error');
		return;
	}

	$.ajax({
		url: '{{ route('pp30.officer', $exception->id) }}',
		method: 'POST',
		data: {
			officer_id: $('#officer_id option:selected').val()
		},
		dataType: 'json',
		async: true,
		success: function(data) {
			table.api().ajax.reload(null, false);
			$('#officer_id').val('').trigger('change');
		},
		error: function(xhr, ajaxOptions, thrownError){
	        swal('Harap Maaf!', 'Pemohon ini sudah dipilih.', 'error');
		}
	});
}

function removeOfficer(id) {

	$.ajax({
		url: '{{ route('pp30.officer', $exception->id) }}/'+id,
		method: 'delete',
		dataType: 'json',
		async: true,
		contentType: false,
		processData: false,
		success: function(data) {
			table.api().ajax.reload(null, false);
			$('#officer_id').val('').trigger('change');
		}
	});
}

$(document).ready(function() {
    var socket = io('{{ env('SOCKET_HOST', '127.0.0.1') }}:{{ env('SOCKET_PORT', 3000) }}');

    socket.on('connect', function() {
        $(".msg-disconnected").slideUp();
        $(".msg-connecting").slideUp();
    });

    socket.on('disconnect', function() {
        $(".msg-disconnected").slideDown();
        $("html, body").animate({ scrollTop: 0 }, 500);
    });

    $('#form-pp30 input, #form-pp30 select, #form-pp30 textarea').on('change', function() {
        socket.emit('pp30', {
            id: {{ $exception->id }},
            name: $(this).attr('name'),
            value: $(this).attr('type') == 'checkbox' ? ($(this).prop('checked') ? 1 : 0) : $(this).val(),
            user: '{{ Cookie::get('api_token') }}'
        });
        console.log('changed');
    });

    @if($exception->requested_tenure_id)
        $("#requested_tenure_id").val({{ $exception->requested_tenure_id }}).trigger('change');
    @endif

    @if($exception->total_citizen)
        $("#total_citizen").val({{ $exception->total_citizen }}).trigger('change');
    @endif

    @if($exception->total_non_citizen)
        $("#total_non_citizen").val({{ $exception->total_non_citizen }}).trigger('change');
    @endif
});
</script>
@endpush
