@extends('layouts.app')
@include('plugins.dropzone')
@include('plugins.datatables')

@section('content')
@include('components.msg-disconnected')
<!-- START JUMBOTRON -->
<div class="jumbotron" data-pages="parallax">
    <div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
        <div class="inner">
            <!-- START BREADCRUMB -->
            {{ Breadcrumbs::render('affidavit') }}
            <!-- END BREADCRUMB -->
            <div class="row">
                <div class="col-xl-12 col-lg-12 ">
                    <!-- START card -->
                    <div class="card card-transparent">
                        <div class="card-block p-t-0">
                            <h3 class='m-t-0'>Daftar Kes</h3>
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
<!-- END JUMBOTRON -->

@include('components.msg-connecting')
<div class=" container-fluid container-fixed-lg bg-white">
    <!-- START card -->
    <div class="card card-transparent">
        <div class="card-block">
            <div>
                <form id="form-affidavit" class="form-horizontal" role="form" autocomplete="off" method="post" action="#">

                    @include('components.bs.input', [
                        'name' => 'applicant',
                        'label' => 'Nama Pemohon',
                        'mode' => 'required',
                        'value' => $affidavit->applicant,
                    ])

                    @include('components.bs.input', [
                        'name' => 'court_registration_no',
                        'label' => 'No. Daftar Mahkamah Tinggi',
                        'mode' => 'required',
                        'value' => $affidavit->court_registration_no,
                    ])

                </form>

                <div class="form-group row">
					<label for="fname" class="col-md-3 control-label">Nama Responden <span style="color:red;">*</span></label>
					<div class="col-md-9">
						<div class="input-group">
	                      	<input type="text" class="form-control" placeholder="Nama" name="respondent" id="respondent">
	                      	<span class="input-group-addon primary clickable" onclick="addRespondent()" style="background-color: #6d5eac !important"><i class="fa fa-plus"></i></span>
	                    </div>
						<table>
							<table class="table table-hover" id="table-respondent">
								<thead>
									<tr>
										<th class="fit">Bil.</th>
										<th>Nama</th>
										<th style="width:10%"></th>
									</tr>
								</thead>
							</table>
						</table>
					</div>
				</div>

                <div class="form-group row">
                    <label for="fname" class="col-md-3 control-label">Muat Naik Dokumen
                    </label>
                    <div class="col-md-9">
                        <form action="{{ route('affidavit.form.attachment', $affidavit->id) }}" enctype="multipart/form-data" class="attachment dropzone no-margin">
                            <div class="fallback">
                                <input name="file" type="file" multiple/>
                            </div>
                        </form>
                    </div>
                </div>

                <br>

                <div class="form-group">
                    <button type="button" class="btn btn-default mr-1" onclick="location.href='{{ route('affidavit.list') }}'"><i class="fa fa-angle-left mr-1"></i> Kembali</button>
                    <!-- If mode update form change button label to Kemaskini-->
                    @if($affidavit->created_by_user_id == auth()->id())
                    <button type="button" class="btn btn-info pull-right" onclick="submit()" data-dismiss="modal"><i class="fa fa-check mr-1"></i> Hantar</button>
                    @endif
                    <button type="button" class="btn btn-default pull-right mr-1" onclick="save()" data-dismiss="modal"><i class="fa fa-save mr-1"></i> Simpan</button>
                </div>


            </div>
        </div>
    </div>
    <!-- END card -->
</div>
@endsection

@push('js')
<script type="text/javascript">

$("#form-affidavit").validate();

// Table for respondents
var table = $('#table-respondent');

var settings = {
	"processing": true,
	"serverSide": true,
	"deferRender": true,
	"ajax": "{{ route('affidavit.form.respondent', $affidavit->id) }}",
	"columns": [
		{ data: 'index', defaultContent: '', orderable: false, searchable: false, render: function (data, type, row, meta) {
			return meta.row + meta.settings._iDisplayStart + 1;
		}},
		{ data: "respondent", name: "respondent"},
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
	"iDisplayLength": 5
};

table.dataTable(settings);

function save() {
    swal({
        title: "Berjaya!",
        text: "Data yang telah disimpan.",
        icon: "success",
        button: "OK",
    })
    .then((confirm) => {
        if (confirm) {
            location.href="{{ route('affidavit.list') }}";
        }
    });
}

@if(!request()->id)
    window.history.pushState('affidavit', 'Affidavit - Daftar Kes', '{{ fullUrl() }}/{{ $affidavit->id }}');
@endif

function addRespondent() {

	if($('#respondent').val() == '') {
		swal('Harap Maaf!', 'Sila isi ruangan terlebih dahulu.', 'error');
		return;
	}

	$.ajax({
		url: '{{ route('affidavit.form.respondent', $affidavit->id) }}',
		method: 'POST',
		data: {
			respondent: $('#respondent').val()
		},
		dataType: 'json',
		async: true,
		success: function(data) {
			$('#respondent').val("");
			table.api().ajax.reload(null, false);
		}
	});
}

function removeRespondent(id) {
	$.ajax({
		url: '{{ route('affidavit.form.respondent', $affidavit->id) }}/'+id,
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

$(".attachment").dropzone({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: "{{ route('affidavit.form.attachment', $affidavit->id) }}",
    addRemoveLinks : true,
    dictRemoveFile: "Padam Fail",
    init: function () {
        var myDropzone = this;

        $.ajax({
            url: '{{ route('affidavit.form.attachment', $affidavit->id) }}/',
            method: 'get',
            dataType: 'json',
            async: true,
            contentType: false,
            processData: false,
            success: function(data) {
                $.each(data, function(key,value){
                    var mockFile = { name: value.name, size: value.size, id: value.id };
                    myDropzone.emit("addedfile", mockFile);
                    myDropzone.emit("thumbnail", mockFile);

                    $(mockFile.previewElement).prop('id', value.id);
                });
            }
        });

        myDropzone.on("addedfile", function (file) {
            if(file.id) {
                file._downloadLink = Dropzone.createElement("<a class=\"btn btn-default btn-xs\" id=\"bt-down\" style=\"margin-top:5px;\" href=\"{{ url('general/attachment') }}/"+file.id+"/"+file.name+"\" title=\"Muat Turun\" data-dz-download><i class=\"fa fa-download m-r-5\"></i> Muat Turun</a>");
                file.previewElement.appendChild(file._downloadLink);
            }
        });

        $(".dz-remove").addClass('btn', 'btn-danger', 'btn-xs');
        
    },
    success: function(file, response) {
        file.previewElement.id = response.id;
        file._downloadLink = Dropzone.createElement("<a class=\"btn btn-default btn-xs\" id=\"bt-down\" style=\"margin-top:5px;\" href=\"{{ url('general/attachment') }}/"+response.id+"/"+file.name+"\" title=\"Muat Turun\" data-dz-download><i class=\"fa fa-download m-r-5\"></i> Muat Turun</a>");
        file.previewElement.appendChild(file._downloadLink);
        return file.previewElement.classList.add("dz-success");
    },
    removedfile: function(file) {
        swal({
            title: "Padam Data",
            text: "Data yang telah dipadam tidak boleh dikembalikan. Teruskan?",
            icon: "warning",
            buttons: ["Batal", { text: "Padam", closeModal: false }],
            dangerMode: true,
        })
        .then((confirm) => {
            if (confirm) {
                $.ajax({
                    url: '{{ route('affidavit.form.attachment', $affidavit->id) }}/'+file.previewElement.id,
                    method: 'delete',
                    dataType: 'json',
                    async: true,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        swal(data.title, data.message, data.status);
                        if(data.status == "success")
                            file.previewElement.remove();
                    }
                });
            }
        });
    },
});

function submit() {
    swal({
        title: "Teruskan?",
        text: "Adakah anda pasti untuk mendaftar kes ini?",
        icon: "warning",
        buttons: {
            cancel: "Batal",
            confirm: {
                text: "Teruskan",
                value: "confirm",
                closeModal: false,
                className: "btn-info",
            },
        },
        dangerMode: true,
    })
    .then((confirm) => {
        if (confirm) {
            $.ajax({
                url: '{{ route("affidavit.form", $affidavit->id) }}',
                method: 'POST',
                dataType: 'json',
                async: true,
                contentType: false,
                processData: false,
                success: function(data) {
                    if(data.status == 'error') {
                        swal(data.title, data.message, data.status);
                        $("html, body").animate({ scrollTop: 0 }, "slow");
                    }
                    else {
                        swal({
                            title: data.title,
                            text: data.message,
                            icon: data.status,
                            button: "OK",
                        })
                        .then((confirm) => {
                            if (confirm) {
                                location.href="{{ route('affidavit.list') }}";
                            }
                        });
                    }
                }
            });
        }
    });
}

$(document).ready(function(){

    var socket = io('{{ env('SOCKET_HOST', '127.0.0.1') }}:{{ env('SOCKET_PORT', 3000) }}');

    socket.on('connect', function() {
        $(".msg-disconnected").slideUp();
        $(".msg-connecting").slideUp();
    });

    socket.on('disconnect', function() {
        $(".msg-disconnected").slideDown();
        $("html, body").animate({ scrollTop: 0 }, 500);
    });

    $('#form-affidavit input, #form-affidavit select, #form-affidavit textarea').on('change', function() {
        socket.emit('affidavit', {
            id: {{ $affidavit->id }},
            name: $(this).attr('name'),
            value: $(this).attr('type') == 'checkbox' ? ($(this).prop('checked') ? 1 : 0) : $(this).val(),
            user: '{{ Cookie::get('api_token') }}'
        });
        console.log('changed');
    });
});

</script>
@endpush
