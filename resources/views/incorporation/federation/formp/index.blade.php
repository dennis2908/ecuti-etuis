@extends('layouts.app')

@section('content')
@include('components.msg-disconnected')
<!-- START JUMBOTRON -->
<div class="jumbotron" data-pages="parallax">
    <div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
        <div class="inner">
            <!-- START BREADCRUMB -->
            {{ Breadcrumbs::render('formp') }}
            <!-- END BREADCRUMB -->
            <div class="row">
                <div class="col-xl-12 col-lg-12 ">
                    <!-- START card -->
                    <div class="card card-transparent">
                        <div class="card-block p-t-0">
                            <h3 class='m-t-0'>Borang P - Notis Mengenai Niat Untuk Bergabung Dengan Suatu Persekutuan Kesatuan Sekerja</h3>
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
                <form id="form-formp" class="form-horizontal" role="form" autocomplete="off" method="post" action="#">
                    @component('components.bs.label', [
                        'label' => 'Nama Kesatuan Sekerja',
                    ])
                    {{ $formp->formpq->tenure->entity->name }}
    				@endcomponent

                    @component('components.bs.label', [
                        'label' => 'No. Sijil Pendaftaran',
                    ])
                    {{ $formp->formpq->tenure->entity->registration_no }}
                    @endcomponent

                    @component('components.bs.label', [
                        'label' => 'Alamat Ibu Pejabat',
                    ])
                    {!! $formp->address->address1.
                    ($formp->address->address2 ? ',<br>'.$formp->address->address2 : '').
                    ($formp->address->address3 ? ',<br>'.$formp->address->address3 : '').
                    ',<br>'.
                    $formp->address->postcode.' '.
                    ($formp->address->district ? $formp->address->district->name : '').', '.
                    ($formp->address->state ? $formp->address->state->name : '') !!}
                    @endcomponent

                    <div class="form-group row">
                        <label for="fname" class="col-md-3 control-label">Persekutuan Yang Ingin Bergabung
                            <span style="color:red;">*</span>
                        </label>
                        <div class="col-md-9">
                            <select class="full-width" data-init-plugin="select2" name="user_federation_id" id="user_federation_id">
                                <option value="" selected="" disabled="">Pilih Satu...</option>
                                @foreach($federations as $federation)
                                <option value="{{ $federation->id }}">{{ $federation->name }}</option>
                                @endforeach
                            </select>          
                        </div>
                    </div>

                    @include('components.bs.date', [
                        'name' => 'resolved_at',
                        'label' => 'Tarikh Diputuskan',
                        'mode' => 'required',
                        'value' => $formp->resolved_at ? date('d/m/Y', strtotime($formp->resolved_at)) : ''
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

                    @component('components.bs.label', [
                        'name' => 'secretary',
                        'label' => 'Nama Setiausaha ',
                    ])
                    {{ $formp->secretary->name }}
                    @endcomponent

                    @include('components.bs.date', [
                        'name' => 'applied_at',
                        'label' => 'Tarikh Permohonan',
                        'mode' => 'required',
                        'value' =>  $formp->created_at ? date('d/m/Y', strtotime($formp->created_at)) : date('d/m/Y'),
                    ])
                </form>

                <br>
                <div class="form-group">
                    <button onclick="location.href='{{ route('federation.form', request()->id) }}'" type="button" class="btn btn-default mr-1" ><i class="fa fa-angle-left mr-1"></i> Kembali</button>
                    <button type="button" class="btn btn-info pull-right" onclick="save()"><i class="fa fa-check mr-1"></i> Simpan</button>
                </div>

            </div>
        </div>
    </div>
    <!-- END card -->
</div>
@endsection

@push('js')
<script type="text/javascript">

$("#form-formp").validate();

function save() {
    swal({
        title: "Berjaya!",
        text: "Data yang telah disimpan.",
        icon: "success",
        button: "OK",
    })
    .then((confirm) => {
        if (confirm) {
            location.href="{{ route('federation.form', request()->id) }}";
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

    $('input, select, textarea').on('change', function() {
        socket.emit('formp', {
            id: {{ $formp->id }},
            name: $(this).attr('name'),
            value: $(this).attr('type') == 'checkbox' ? ($(this).prop('checked') ? 1 : 0) : $(this).val(),
            user: '{{ Cookie::get('api_token') }}'
        });
        console.log('changed');
    });

    $("#meeting_type_{{ $formp->meeting_type_id }}").prop('checked', true).trigger('change');

    @if($formp->user_federation_id)
    $("#user_federation_id").val( {{ $formp->user_federation_id }} ).trigger('change');
    @endif
});
</script>
@endpush