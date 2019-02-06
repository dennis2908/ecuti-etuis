@extends('layouts.app')
@include('plugins.wizard')
@include('plugins.dropzone')

@section('content')
@include('components.msg-disconnected')
<!-- START JUMBOTRON -->
<div class="jumbotron m-b-0" data-pages="parallax">
    <div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
        <div class="inner">
            <!-- START BREADCRUMB -->
            {{ Breadcrumbs::render('eligibility-issue') }}
            <div class="row">
                <div class="col-xl-12 col-lg-12 ">
                    <!-- START card -->
                    <div class="card card-transparent">
                        <div class="card-block p-t-0">
                            <h3 class='m-t-0'>Borang A (Notis Tuntutan Pengiktirafan) APP 1967 dan Memo Siasatan</h3> 
                            <p class="small hint-text m-t-5">
                                Sila lengkapkan maklumat pada ruangan di bawah.
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

<!-- START CONTAINER FLUID -->
<div class=" container-fluid container-fixed-lg bg-white">
    <!-- START card -->
    <div class="card card-transparent">
        <div class="card-block">
            <form class="form-horizontal" role="form" autocomplete="off" method="post" action="#">

                <div class="form-group row">
                    <label for="" class="col-md-3 control-label">Nama Kesatuan
                        <span style="color:red;">*</span>
                    </label>
                    <div class="col-md-9">
                        <select class="full-width" data-init-plugin="select2" name="user_id" id="user_id">
                            <option value="" selected="" disabled="">Pilih Satu...</option>
                            @foreach($users as $user)
                            <option id="user_id_{{ $user->id }}" value="{{ $user->id }}">{{ $user->entity->name }}</option>
                            @endforeach
                        </select>          
                    </div>
                </div>

                @include('components.bs.input', [
                    'name' => 'company_name',
                    'label' => 'Nama Syarikat',
                    'mode' => 'required',
                    'value' => $eligibility->forma->company_name
                ])

                <div class="form-group row">
                    <label class="col-md-3 control-label">
                        Alamat Syarikat <span style="color:red;">*</span>
                    </label>
                    <div class="col-md-9">
                        <input class="form-control m-t-5" name="address1" type="text" value="{{ $eligibility->forma->company_address->address1 or '' }}" required>
                        <input class="form-control m-t-5" name="address2" type="text" value="{{ $eligibility->forma->company_address->address2 or '' }}">
                        <input class="form-control m-t-5" name="address3" type="text" value="{{ $eligibility->forma->company_address->address3 or '' }}">
                        <div class="row address">
                            <div class="col-md-2 m-t-5">
                                <input class="form-control numeric postcode" name="postcode" aria-required="true" type="text" value="{{ $eligibility->forma->company_address->postcode or '' }}" required placeholder="Poskod" minlength="5" maxlength="5">
                            </div>
                            <div class="col-md-5 m-t-5">
                                <select id="state_id" name="state_id" class="full-width autoscroll state" data-init-plugin="select2" required="">
                                    <option value="" selected="" disabled="">Pilih Negeri</option>
                                    @foreach($states as $index => $state)
                                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-5 m-t-5">
                                <select id="district_id" name="district_id" class="full-width autoscroll district" data-init-plugin="select2" required="">
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                @include('components.bs.date', [
                    'name' => 'applied_at',
                    'label' => 'Tarikh Borang A',
                    'mode' => 'required',
                    'value' => $eligibility->forma->applied_at ? date('d/m/Y', strtotime($eligibility->forma->applied_at)) : date('d/m/Y'),
                ])


                @include('components.bs.date', [
                    'name' => 'received_at',
                    'label' => 'Tarikh Terima Borang A',
                    'mode' => 'required',
                    'value' => $eligibility->forma->received_at ? date('d/m/Y', strtotime($eligibility->forma->received_at)) : '',
                ])
            </form>

            <div class="form-group row">
                <label for="fname" class="col-md-3 control-label">Muat Naik Borang A <span style="color:red;">*</span>
                </label>
                <div class="col-md-9">
                    <form action="{{ route('eligibility-issue.forma.attachment', $eligibility->id) }}" enctype="multipart/form-data" class="attachment dropzone no-margin">
                        <div class="fallback">
                            <input name="file" type="file" multiple/>
                        </div>
                    </form>
                </div>
            </div>

            <div class="form-group">
                <button type="button" class="btn btn-default mr-1" onclick="location.href='{{ route('eligibility-issue.form', $eligibility->id) }}'"><i class="fa fa-angle-left mr-1"></i> Kembali</button>
                <!-- If mode update form change button label to Kemaskini-->
                <button type="button" class="btn btn-info pull-right" onclick="save()"><i class="fa fa-check mr-1"></i> Simpan</button>
            </div>
        </div>
    </div>
    <!-- END card -->
</div>
<!-- END CONTAINER FLUID -->
@endsection

@push('js')
<script type="text/javascript">
$(".attachment").dropzone({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: "{{ route('eligibility-issue.forma.attachment', $eligibility->id) }}",
    addRemoveLinks : true,
    dictRemoveFile: "Padam Fail",
    init: function () {
        var myDropzone = this;

        $.ajax({
            url: '{{ route('eligibility-issue.forma.attachment', $eligibility->id) }}/',
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
                    url: '{{ route('eligibility-issue.forma.attachment', $eligibility->id) }}/'+file.previewElement.id,
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

@push('js')
<script type="text/javascript">
function save() {
    swal({
        title: "Berjaya!",
        text: "Data yang telah disimpan.",
        icon: "success",
        button: "OK",
    })
    .then((confirm) => {
        if (confirm) {
            location.href="{{ route('eligibility-issue.form', $eligibility->id) }}";
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

    $('.form-horizontal input, .form-horizontal select, .form-horizontal textarea').on('change', function() {
        socket.emit('eligibility_issue', {
            id: {{ $eligibility->id }},
            name: $(this).attr('name'),
            value: $(this).attr('type') == 'checkbox' ? ($(this).prop('checked') ? 1 : 0) : $(this).val(),
            user: '{{ Cookie::get('api_token') }}'
        });
        console.log('changed');
    });

    @if($eligibility->entity)
    $("#user_id_{{ $eligibility->entity->user->id }}").prop('selected', true).trigger('change');
    @endif

    @if($eligibility->forma->company_address->state_id)
    $("#state_id").val({{ $eligibility->forma->company_address->state_id }}).trigger('change');
    @endif

    @if($eligibility->forma->company_address->district_id)
    $("#district_id").val({{ $eligibility->forma->company_address->district_id }}).trigger('change');
    @endif
});
</script>
@endpush
