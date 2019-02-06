@extends('layouts.app')
@include('plugins.dropzone')

@section('content')
<!-- START BREADCRUMB -->
<div class="jumbotron" data-pages="parallax">
	<div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
		<div class="inner" style="transform: translateY(0px); opacity: 1;">
			{{ Breadcrumbs::render('lockout') }}
			<!-- END BREADCRUMB -->
			<div class="row">
				<div class="col-xl-12 col-lg-12 ">
					<!-- START card -->
					<div class="card card-transparent">
						<div class="card-block p-t-0">
							<h3 class='m-t-0'>Pengendalian Tutup Pintu</h3>
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
<div class="main container-fluid container-fixed-lg">
    <div class="row justify-content-center">

        <div class="col-lg-12">
            @component('components.block', [
                    'percentage' => (11 - $errors_lockout)/11*100,
                    'title' => 'Permohonan Tutup Pintu',
                    'description' => '',
                ])
                <div class="btn-group-custom">
                    <a href="{{ route('lockout.index', $lockout->id) }}" class="btn btn-primary pull-right btn-input"><i class="fa fa-edit mr-1"></i> Isi Borang</a>
                    @if(!$errors_lockout)
                    <a href="{{ route('download.lockout', $lockout->id) }}" target="_blank" class="btn btn-default mr-2 pull-right btn-lock"><i class="fa fa-print mr-1"></i> Cetak</a>
                    <a href="javascript:;" class="btn btn-master mr-2 pull-right btn-unlock"><i class="fa fa-lock"></i></a>
                    @endif
                </div>
            @endcomponent
        </div>

        <div class="col-lg-12">
            <div class="alert alert-warning" role="alert">
                <strong>Peringatan!</strong> Borang U hanya sah dalam masa 14 hari dari tarikh undi sulit dicabut.
            </div>
        </div>

        <div class="col-lg-12">
            @component('components.block', [
                    'percentage' => (7 - $errors_u)/7*100,
                    'title' => 'Borang U',
                    'description' => ' - Penyata Keputusan Undi',
                ])
                <div class="btn-group-custom">
                    <a href="{{ route('lockout.formu', $lockout->id) }}" class="btn btn-primary pull-right btn-input"><i class="fa fa-edit mr-1"></i> Isi Borang</a>
                </div>
                @if(!$errors_u)
                <a href="{{ route('download.lockout.formu', $lockout->id) }}" target="_blank" class="btn btn-default mr-2 pull-right btn-lock"><i class="fa fa-print mr-1"></i> Cetak</a>
                <a href="javascript:;" class="btn btn-master mr-2 pull-right btn-unlock"><i class="fa fa-lock"></i></a>
                @endif
            @endcomponent
        </div>

        <div class="col-lg-12">
            @component('components.block', [
                    'title' => 'Senarai Semak + Dokumen Sokongan',
                    'disabled' => true
                ])
                <div class="btn-group-custom">
                    <a href="{{ url('files/checklist/lockout.pdf') }}" target="_blank" class="btn btn-default mr-2 pull-right"><i class="fa fa-print mr-1"></i> Cetak</a>
                </div>
                <hr>
                <ul>
                    <li><label>Surat Pemberitahuan Tutup Pintu (2 salinan)</label></li>
                    <li><label>Buku Perlembagaan Tanpa Cawangan / Buku Perlembagaan Bercawangan (4 Salinan Asal)</label></li>
                    <li><label>Usul Dan Minit Mesyuarat Keputusan Mengadakan Tutup Pintu (2 salinan)</label></li>
                    <li><label>Senarai Kehadiran Semasa Undi Sulit Dijalankan (2 salinan)</label></li>
                    <li><label>Borang U (3 salinan) (2/3 dari undian majoriti)</label></li>
                    <li><label>Kertas Undi (1 salinan)</label></li>
                </ul>
            @endcomponent
        </div>

        <div class="col-lg-12">
            @component('components.block', [
                    'title' => 'Dokumen-Dokumen Berkaitan',
                    'disabled' => true
                ])
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{ route('lockout.form.attachment', $lockout->id) }}" enctype="multipart/form-data" class="attachment dropzone no-margin">
                            <div class="fallback">
                                <input name="file" type="file" multiple/>
                            </div>
                        </form>
                    </div>
                </div>
                @endcomponent
            </div>
        </div>

        @if($lockout->created_by_user_id == auth()->id())
        <div class="col-lg-12 mb-3">
            <button class="btn btn-info pull-right btn-send" onclick="submit()"><i class="fa fa-check mr-1"></i> Hantar</button>
        </div>
        @endif
    </div>
</div>
@endsection

@push('js')
<script type="text/javascript">

    printed = 0;

    $('.btn-lock').on('click', function() {
        printed++;
    });

    $('.btn-unlock').on('click', function() {
        printed--;
    });

    @if(!request()->id)
        window.history.pushState('lockout', 'Pengendalian Tutup Pintu', '{{ fullUrl() }}/{{ $lockout->id }}');
    @endif

    function submit() {

        if(printed != 2) {
            swal('Harap Maaf!', 'Sila cetak dokumen-dokumen di atas terlebih dahulu.', 'error');
            return;
        }

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
                    url: '{{ route("lockout.form", $lockout->id) }}',
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
                                    location.href="{{ route('lockout.list') }}";
                                }
                            });
                        }
                    }
                });
            }
        });
    }

    $(".attachment").dropzone({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "{{ route('lockout.form.attachment', $lockout->id) }}",
        addRemoveLinks : true,
        dictRemoveFile: "Padam Fail",
        init: function () {
            var myDropzone = this;

            $.ajax({
                url: '{{ route('lockout.form.attachment', $lockout->id) }}/',
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
                        url: '{{ route('lockout.form.attachment', $lockout->id) }}/'+file.previewElement.id,
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

</script>
@endpush
