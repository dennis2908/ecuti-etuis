@extends('layouts.app')
@include('plugins.dropzone')

@section('content')
@include('components.msg-disconnected')

<!-- START BREADCRUMB -->
<div class="jumbotron" data-pages="parallax">
	<div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
		<div class="inner" style="transform: translateY(0px); opacity: 1;">
			{{ Breadcrumbs::render('ectr4u') }}
			<!-- END BREADCRUMB -->
			<div class="row">
				<div class="col-xl-12 col-lg-12 ">
					<!-- START card -->
					<div class="card card-transparent">
						<div class="card-block p-t-0">
							<h3 class='m-t-0'>Perakuan Cuti Tanpa Rekod Kesatuan Sekerja</h3>
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
<!-- END JUMBOTRON -->
@include('components.msg-connecting')
<!-- START CONTAINER FLUID -->
<!-- START CONTAINER FLUID -->
<div class=" container-fluid container-fixed-lg bg-white">
	<!-- START card -->
	<div class="card card-transparent">
		<div class="card-block">
			<div>
				<form id="form-ectr4u" class="form-horizontal" role="form" autocomplete="off" method="post" action="#">
	        		<div class="form-group row">
						<label for="" class="col-md-3 control-label">
							Sektor <span style="color:red;">*</span>
						</label>
						<div class="col-md-9">
							<div class="radio radio-primary">
								@foreach($sectors as $sector)
								<input name="sector_id" value="{{ $sector->id }}" id="sector_{{ $sector->id }}" type="radio" class="hidden" required>
								<label for="sector_{{ $sector->id }}">{{ $sector->name }}</label>
								@endforeach
							</div>
						</div>
					</div>

					<div class="form-group row">
						<label for="" class="col-md-3 control-label">
							Malaysia/Luar Negara <span style="color:red;">*</span>
						</label>
						<div class="col-md-9">
							<div class="radio radio-primary">
								<input name="is_abroad" value="0" id="is_abroad_yes" type="radio" class="hidden" required>
								<label for="is_abroad_yes">Malaysia</label>
								<input name="is_abroad" value="1" id="is_abroad_no" type="radio" class="hidden" required>
								<label for="is_abroad_no">Luar Negara</label>
							</div>
						</div>
					</div>

					@include('components.bs.input', [
						'name' => 'name',
						'label' => 'Nama Program',
						'mode' => 'required',
						'value' => $ectr4u->name
					])

					<div class="form-group row">
						<label for="fname" class="col-md-3 control-label">Jenis Program
							<span style="color:red;">*</span>
						</label>
						<div class="col-md-9">
							<select class="full-width" data-init-plugin="select2" name="programme_type_id" id="programme_type_id">
								<option value="" selected="" disabled="">Pilih Satu...</option>
								@foreach($types as $ptype)
								<option value="{{ $ptype->id }}">{{ $ptype->name }}</option>
								@endforeach
							</select>          
						</div>
					</div>

					@include('components.bs.textarea', [
						'name' => 'objective',
						'label' => 'Objektif Program',
						'mode' => 'required',
						'value' => $ectr4u->objective
					])

					@include('components.bs.textarea', [
						'name' => 'location',
						'label' => 'Tempat Program',
						'mode' => 'required',
						'value' => $ectr4u->location
					])

					<div class="form-group row">
						<label for="fname" class="col-md-3 control-label">Tempoh Program</label>
						<div class="col-md-9">
							<div class="input-daterange input-group" id="datepicker-range">
		                      	<input type="text" class="input-sm form-control" name="start_date" value="{{ $ectr4u->start_date ? date('d/m/Y', strtotime($ectr4u->start_date)) : '' }}" />
		                      	<div class="input-group-addon pl-3 pr-3"> hingga </div>
		                      	<input type="text" class="input-sm form-control" name="end_date" value="{{ $ectr4u->end_date ? date('d/m/Y', strtotime($ectr4u->end_date)) : '' }}" />
	                    	</div>
						</div>
					</div>

					@include('components.bs.input', [
						'name' => 'organizer',
						'label' => 'Penganjur',
						'mode' => 'required',
						'value' => $ectr4u->organizer
					])

					@include('components.bs.input', [
						'name' => 'organizer_name',
						'label' => 'Nama Penganjur',
						'mode' => 'required',
						'value' => $ectr4u->organizer_name
					])

					<!-- Refer Attachment 2 for list of Union-->
					<div class="form-group row">
						<label for="fname" class="col-md-3 control-label">Bergabung dengan Persekutuan
							<!-- <span style="color:red;">*</span> -->
						</label>
						<div class="col-md-9">
							<select id="multi" name="federations" class="full-width" data-init-plugin="select2" multiple>
								@foreach($federations as $federation)
								<option 
								@if($ectr4u->federations->where('user_federation_id', $federation->id)->count() > 0)
									selected
								@endif
								value="{{ $federation->id }}">{{ $federation->name }}</option>
								@endforeach
							</select>          
						</div>
					</div>

					@include('components.bs.input', [
						'name' => 'total_participant',
						'label' => 'Bilangan Peserta',
						'mode' => 'required',
						'class' => 'numeric',
						'value' => $ectr4u->total_participant
					])

				</form>

				<div class="form-group row">
					<label for="fname" class="col-md-3 control-label">Muat Naik Dokumen Sokongan
						<!-- <span style="color:red;">*</span> -->
						<br>
						<ul class="p-l-20">
							<li>Aturcara Program</li>
							<li>Senarai Peserta 
								<a href="{{ url('files/ctr/sample.pdf') }}" class="btn btn-default btn-xs mb-1"><i class="fa fa-download mr-1"></i> Contoh Format </a>
							</li>
							<li>Senarai Penceramah</li>
						</ul>
					</label>
					<div class="col-md-9">
						<form action="{{ route('ectr4u.form.attachment', $ectr4u->id) }}" enctype="multipart/form-data" class="attachment dropzone no-margin">
							<div class="fallback">
								<input name="file" type="file" multiple/>
							</div>
						</form>
					</div>
				</div>

				<br>

				<div class="form-group">
					<button type="button" class="btn btn-default mr-1" onclick="location.href='{{ route('ectr4u.list') }}'"><i class="fa fa-angle-left mr-1"></i> Kembali</button>
					<!-- If mode update form change button label to Kemaskini-->
					@if($ectr4u->created_by_user_id == auth()->id())
					<button type="button" class="btn btn-info pull-right" onclick="submit()" data-dismiss="modal"><i class="fa fa-check mr-1"></i> Hantar</button>
					@endif
                    <button type="button" class="btn btn-default pull-right mr-1" onclick="save()" data-dismiss="modal"><i class="fa fa-save mr-1"></i> Simpan</button>
				</div>

			</div>
    	</div>
    </div>
</div>

@endsection
@push('js')
<script type="text/javascript">

$("#form-ectr4u").validate();

function submit() {
    swal({
        title: "Teruskan?",
        text: "Adakah anda pasti untuk menghantar permohonan ini?",
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
                url: '{{ route("ectr4u.form", $ectr4u->id) }}',
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
                                location.href="{{ route('ectr4u.list') }}";
                            }
                        });
                    }
                }
            });
        }
    });
}

function save() {
    swal({
        title: "Berjaya!",
        text: "Data yang telah disimpan.",
        icon: "success",
        button: "OK",
    })
    .then((confirm) => {
        if (confirm) {
            location.href="{{ route('ectr4u.list') }}";
        }
    });
}

$(".attachment").dropzone({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: "{{ route('ectr4u.form.attachment', $ectr4u->id) }}",
    addRemoveLinks : true,
    dictRemoveFile: "Padam Fail",
    init: function () {
    	var myDropzone = this;

    	$.ajax({
            url: '{{ route('ectr4u.form.attachment', $ectr4u->id) }}/',
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
	                url: '{{ route('ectr4u.form.attachment', $ectr4u->id) }}/'+file.previewElement.id,
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

$('#dz-entity').on('click', function() {
	console.log("filename :",$('#dz-filename').value());
});

$('.input-daterange input').datepicker({ 
    language: 'ms',
	format: 'dd/mm/yyyy',
    startDate: '+14d',
    autoclose: true,
    onClose: function() {
        $(this).valid();
    },
}).on('changeDate', function(){
    $(this).trigger('change');
});

@if(!request()->id)
    window.history.pushState('ectr4u', 'Cuti Tanpa Rekod', '{{ fullUrl() }}/{{ $ectr4u->id }}');
@endif

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

	$('input[type=text], input[type=email], input[type=radio], input[type=checkbox], select, textarea').on('change', function() {
		socket.emit('ectr4u', {
			id: {{ $ectr4u->id }},
        	name: $(this).attr('name'),
			value: $(this).attr('type') == 'checkbox' ? ($(this).prop('checked') ? 1 : 0) : $(this).val(),
			user: '{{ Cookie::get('api_token') }}'
		});
		console.log('changed');
	});

	$("#sector_{{ $ectr4u->sector_id }}").prop('checked', true).trigger('change');

	$("#is_abroad_{{ isset($ectr4u->is_abroad) ? $ectr4u->is_abroad ? 'yes' : 'no' : '' }}").prop('checked', true);

	@if($ectr4u->programme_type_id)
	$("#programme_type_id").val( {{ $ectr4u->programme_type_id }} ).trigger('change');
	@endif

});
</script>
@endpush