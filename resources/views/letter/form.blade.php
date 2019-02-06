@extends('layouts.app')
@include('plugins.dropzone')

@section('content')
<!-- START BREADCRUMB -->
<div class="jumbotron" data-pages="parallax">
	<div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
		<div class="inner" style="transform: translateY(0px); opacity: 1;">
			{{ Breadcrumbs::render('letter') }}
			<!-- END BREADCRUMB -->
			<div class="row">
				<div class="col-xl-12 col-lg-12 ">
					<!-- START card -->
					<div class="card card-transparent">
						<div class="card-block p-t-0">
							<h3 class='m-t-0'>Maklumat Surat</h3>
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
<!-- START CONTAINER FLUID -->
<div class=" container-fluid container-fixed-lg bg-white">
	<!-- START card -->
	<div class="card card-transparent">
		<div class="card-block">
			
			<div class="row">
				<div class="col-md-6">
					<form id="form-letter" class="form-horizontal" role="form" autocomplete="off" method="post" action="{{ route('letter.item', $letter->id) }}">
						@include('letter.template.'.$letter->type->template_name)
					</form>
				</div>
				<div class="col-md-6">
					<h6 class="bold">Muat Naik Dokumen</h6>
					<p class="small hint-text m-t-5">
						Dokumen yang telah ditandatangani boleh dimuat naik semula bagi tujuan simpanan rekod.
					</p>
					<form action="{{ route('letter.item.attachment', $letter->id) }}" enctype="multipart/form-data" class="attachment dropzone no-margin">
						<div class="fallback">
							<input name="file" type="file" multiple/>
						</div>
					</form>
				</div>
			</div>

			<br>

			<div class="form-group">
				<button type="button" onclick="location.href='{{ previousUrl() }}'" class="btn btn-default mr-1" ><i class="fa fa-angle-left mr-1"></i> Kembali</button>
				<button type="button" class="btn btn-info pull-right m-l-5" onclick="submitForm('form-letter')" data-dismiss="modal"><i class="fa fa-check mr-1"></i> Kemaskini</button>
				@if($letter->data && $letter->letter_type_id <> 78)
				<button type="button" class="btn btn-default pull-right m-l-5" onclick="location.href='{{ route('letter.'.$letter->type->template_name, ['id' => $letter->id, 'format' => 'pdf']) }}'" data-dismiss="modal"><i class="fa fa-print mr-1"></i> PDF</button>
				<button type="button" class="btn btn-default pull-right m-l-5" onclick="location.href='{{ route('letter.'.$letter->type->template_name, $letter->id) }}'" data-dismiss="modal"><i class="fa fa-print mr-1"></i> DOCX</button>
				@endif
			</div>
    	</div>
    </div>
</div>

@endsection


@push('js')
<script type="text/javascript">
$(".attachment").dropzone({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: "{{ route('letter.item.attachment', $letter->id) }}",
    addRemoveLinks : true,
    dictRemoveFile: "Padam Fail",
    init: function () {
    	var myDropzone = this;

    	$.ajax({
            url: '{{ route('letter.item.attachment', $letter->id) }}/',
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
	                url: '{{ route('letter.item.attachment', $letter->id) }}/'+file.previewElement.id,
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

$("#form-letter").submit(function(e) {
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
        	swal({
		        title: data.title,
		        text: data.message,
		        icon: data.status,
		        button: "OK",
		    })
		    .then((confirm) => {
		        if (confirm) {
		            location.reload();
		        }
		    });
        }
    });
});
</script>
@endpush