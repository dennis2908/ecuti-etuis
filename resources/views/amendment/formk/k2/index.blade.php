@extends('layouts.app')
@include('plugins.datatables')

@push('css')
<style>
.form-horizontal .form-group {
    border-bottom: unset !important;
}
</style>
@endpush

@section('content')
@include('components.msg-disconnected')
<!-- START JUMBOTRON -->
<div class="jumbotron m-b-0" data-pages="parallax">
	<div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
		<div class="inner">
			<!-- START BREADCRUMB -->
			{{ Breadcrumbs::render('formk.k2') }}
			<div class="row">
				<div class="col-xl-12 col-lg-12 ">
					<!-- START card -->
					<div class="card card-transparent">
						<div class="card-block p-t-0">
							<h3 class='m-t-0'>Borang U - Penyata Keputusan Undi</h3>
							<p class="small hint-text m-t-5">
								AKTA KESATUAN SEKERJA, 1959 (Seksyen 40 dan Peraturan 26)
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
                <form id="form-formu" class="form-horizontal" role="form" autocomplete="off" method="post" action="#">
                    <div class="form-group row">
                        <label for="fname" class="col-md-3 control-label">Cawangan
                            <span style="color:red;">*</span>
                        </label>
                        <div class="col-md-9">
                            <select id="branch_id" name="branch_id" class="full-width autoscroll" data-init-plugin="select2" required>
								<option value="-1" selected>Induk - {{ $formu->tenure->entity->name }}</option>
								@foreach($formu->tenure->entity->branches as $branch)
								<option value="{{ $branch->id }}">{{ $branch->name }}</option>
								@endforeach
							</select>
                        </div>
                    </div>

    				@include('components.bs.textarea', [
    					'name' => 'setting',
    					'label' => 'Ketetapan',
    					'mode' => 'required',
                        'value' => $formu->setting,
    				])

    				@include('components.bs.date', [
                        'name' => 'voted_at',
                        'label' => 'Tarikh Undi Sulit',
                        'mode' => 'required',
                        'value' => $formu->voted_at ? date('d/m/Y', strtotime($formu->voted_at)) : '',
                    ])

    				@include('components.bs.input', [
    					'name' => 'total_voters',
    					'label' => 'Jumlah Bilangan Anggota-Anggota Yang Berhak Untuk Mengundi',
    					'mode' => 'required',
                        'class' => 'numeric',
                        'value' => $formu->total_voters,
    				])

    				@include('components.bs.input', [
    					'name' => 'total_slips',
    					'label' => 'Jumlah Bilangan Kertas Undi Yang Dipulangkan',
    					'mode' => 'required',
    					'class' => 'numeric',
                        'value' => $formu->total_slips,
    				])

    				@include('components.bs.input', [
    					'name' => 'total_supporting',
    					'label' => 'Undi Yang Menyokong',
    					'mode' => 'required',
    					'class' => 'numeric',
    					'options' => 'onkeyup=calc()',
                        'value' => $formu->total_supporting,
    				])

                    @include('components.bs.input', [
    					'name' => 'total_against',
    					'label' => 'Undi Yang Menentang',
    					'mode' => 'required',
    					'class' => 'numeric',
    					'options' => 'onkeyup=calc()',
                        'value' => $formu->total_against,
    				])

                    <input type="hidden" value="" name="is_supported">

    				@component('components.bs.label', ['name' => 'percentage', 'label' => 'Peratusan Undi-Undi'])
    				<span id="percentage"></span>
    				@endcomponent

    				@component('components.bs.label', ['name' => 'result', 'label' => 'Maka Ketetapan Adalah'])
    				<span id="result"></span>
    				@endcomponent

                    @include('amendment.formk.k2.examiner.index')

    				<br>
    				<div class="form-group">
    					<button type="button" class="btn btn-default mr-1" onclick="location.href='{{ route('formk.k2.list', [$formk->id]) }}'"><i class="fa fa-angle-left mr-1"></i> Kembali</button>
    					<button type="button" class="btn btn-info pull-right" onclick="save()" data-dismiss="modal"><i class="fa fa-check mr-1"></i> Simpan</button>
    				</div>
                </form>
			</div>
		</div>
	</div>
	<!-- END card -->
</div>
<!-- END CONTAINER FLUID -->
@endsection

@push('js')
<script type="text/javascript">
function calc() {
    if($("input[name=total_supporting]").val() == "" || $("input[name=total_against]").val() == "") {
        $("#percentage").html('');
        return;
    }
    
    var supporting = parseInt($("input[name=total_supporting]").val());
    var against =  parseInt($("input[name=total_against]").val());

	$("#percentage").html( ((supporting/(supporting+against))*100).toFixed(2) + "%" );
	$("#result").html( (supporting/(supporting+against))*100 >= 50 ? "<span class='badge badge-success'>Menang</span>" : "<span class='badge badge-danger'>Kalah</span>" );

    if((supporting/(supporting+against))*100 >= 50)
        $("input[name=is_supported]").val('1').trigger('change');
    else
        $("input[name=is_supported]").val('0').trigger('change');
}

calc();

function save() {
    swal({
        title: "Berjaya!",
        text: "Data yang telah disimpan.",
        icon: "success",
        button: "OK",
    })
    .then((confirm) => {
        if (confirm) {
            location.href="{{ route('formk.k2.list', [$formk->id]) }}";
        }
    });
}

@if(!request()->formu_id)
    window.history.pushState('formu', 'Borang U', '{{ fullUrl() }}/{{ $formu->id }}');
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

    $('input, select, textarea').on('change', function() {
        socket.emit('formu', {
            id: {{ $formu->id }},
            name: $(this).attr('name'),
            value: $(this).attr('type') == 'checkbox' ? ($(this).prop('checked') ? 1 : 0) : $(this).val(),
            user: '{{ Cookie::get('api_token') }}'
        });
        console.log('changed');
    });

    @if($formu->branch_id)
    $("#branch_id").val( {{ $formu->branch_id }} ).trigger('change');
    @endif
});
</script>
@endpush
