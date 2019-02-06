@extends('layouts.app')

@section('content')
@include('components.msg-disconnected')

<!-- START JUMBOTRON -->
<div class="jumbotron" data-pages="parallax">
    <div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
        <div class="inner">
            <!-- START BREADCRUMB -->
            {{ Breadcrumbs::render('registration.formo') }}
            <!-- END BREADCRUMB -->
            <div class="row">
                <div class="col-xl-12 col-lg-12 ">
                    <!-- START card -->
                    <div class="card card-transparent">
                        <div class="card-block p-t-0">
                            <h3 class='m-t-0'>Notis Niat Menubuhkan <span class="semi-bold">Persekutuan Kesatuan Sekerja</span></h3>
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

<!-- START CONTAINER FLUID -->
<div class=" container-fluid container-fixed-lg bg-white">
    <!-- START card -->
    <div class="card card-transparent">
        <div class="card-block">
            <div>
                <form id="form-formo" class="form-horizontal" role="form" autocomplete="off" method="post" action="#">

                    @component('components.bs.label', [
                        'name' => 'name',
                        'label' => 'Nama Kesatuan Sekerja',
                    ])
                    {{ $formo->union->name }}
                    @endcomponent

                    <div class="form-group row">
    					<label class="col-md-3 control-label">
    						Alamat Ibu Pejabat
    					</label>
    					<div class="col-md-9">
    						{!! $formo->address->address1.
                            ($formo->address->address2 ? ',<br>'.$formo->address->address2 : '').
                            ($formo->address->address3 ? ',<br>'.$formo->address->address3 : '').
                            ',<br>'.
                            $formo->address->postcode.' '.
                            ($formo->address->district ? $formo->address->district->name : '').', '.
                            ($formo->address->state ? $formo->address->state->name : '') !!}
    					</div>
    				</div>

                    <div class="form-group row">
                        <label for="union" class="col-md-3 control-label">Kesatuan Yang Ingin Bergabung<span style="color:red;">*</span></label>
                        <div class="col-md-9">
                            <select id="unions" name="unions" class="full-width autoscroll" data-init-plugin="select2" required="" multiple="">
                                @foreach($unions as $index => $union)
                                <option id="union_{{ $union->id }}" value="{{ $union->id }}">{{ $union->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    @include('components.bs.input', [
                        'name' => 'federation_name',
                        'label' => 'Nama Persekutuan Sekerja yang Dicadangkan',
                        'mode' => 'required',
                        'value' => $formo->federation_name
                    ])

                    @include('components.bs.date', [
                        'name' => 'resolved_at',
                        'label' => 'Tarikh Diputuskan',
                        'mode' => 'required',
                        'value' => $formo->resolved_at ? date('d/m/Y', strtotime($formo->resolved_at)) : ''
                    ])

                    <div class="form-group row">
                        <label for="" class="col-md-3 control-label">
                            Melalui
                        </label>
                        <div class="col-md-9">
                            <div class="radio radio-primary">
                                @foreach($meeting_types as $index => $type)
                                <input name="meeting_type_id" value="{{ $type->id }}" id="meeting_type_{{ $type->id }}" type="radio" class="hidden" required>
                                <label for="meeting_type_{{ $type->id }}">{{ $type->name }}</label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </form>

                <br>
                <div class="form-group">
                    <button type="button" class="btn btn-default mr-1" onclick="location.href='{{ route('formo.list') }}'"><i class="fa fa-angle-left mr-1"></i> Kembali</button>
                    @if($formo->created_by_user_id == auth()->id())
                    <button type="button" class="btn btn-info pull-right" onclick="submit()" data-dismiss="modal"><i class="fa fa-check mr-1"></i> Hantar</button>
                    @endif
                    <button type="button" class="btn btn-default pull-right mr-1" onclick="save()" data-dismiss="modal"><i class="fa fa-save mr-1"></i> Simpan</button>
                    <!-- <button type="button" class="btn btn-default pull-right m-r-5" data-dismiss="modal"><i class="fa fa-print mr-1"></i> Cetak</button> -->
                </div>

            </div>
        </div>
    </div>
    <!-- END card -->
</div>
<!-- END CONTAINER FLUID -->
@endsection

@push('js')
<script type="text/javascript">

$("#form-formo").validate();

function submit() {
    swal({
        title: "Teruskan?",
        text: "Adakah anda pasti untuk menghantar notis ini?",
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
                url: '{{ route("formo.form", $formo->id) }}',
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
                                location.href="{{ route('formo.list') }}";
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
            location.href="{{ route('formo.list') }}";
        }
    });
}

@if(!request()->id)
    // location.replace("{{ fullUrl() }}/{{ $formo->id }}");
    window.history.pushState('formo', 'Borang O', '{{ fullUrl() }}/{{ $formo->id }}');
@endif

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

	$('input, select, textarea').on('change', function() {
		socket.emit('formo', {
			id: {{ $formo->id }},
        	name: $(this).attr('name'),
			value: $(this).attr('type') == 'checkbox' ? ($(this).prop('checked') ? 1 : 0) : $(this).val(),
			user: '{{ Cookie::get('api_token') }}'
		});
		console.log('changed');
	});

    $("#meeting_type_{{ $formo->meeting_type_id }}").prop('checked', true).trigger('change');

    @foreach($formo->unions as $union)
    $("#union_{{ $union->user_union_id }}").prop('selected', true).trigger('change');
    @endforeach
});

</script>
@endpush
