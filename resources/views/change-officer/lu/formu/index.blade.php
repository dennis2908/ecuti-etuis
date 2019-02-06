@extends('layouts.app')
@include('plugins.datatables')

@section('content')
@include('components.msg-disconnected')
<!-- START BREADCRUMB -->
<div class="jumbotron" data-pages="parallax">
	<div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
		<div class="inner" style="transform: translateY(0px); opacity: 1;">
			{{ Breadcrumbs::render('formlu') }}
			<!-- END BREADCRUMB -->
			<div class="row">
				<div class="col-xl-12 col-lg-12 ">
					<!-- START card -->
					<div class="card card-transparent">
						<div class="card-block p-t-0">
							<h3 class='m-t-0'>Borang U - Penyata Keputusan Undi</h3>
							<p class="small hint-text m-t-5">
								Akta Kesatuan Sekerja, 1959 (Seksyen 40 dan Peraturan 26)
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
			<div class="form-horizontal" role="form" autocomplete="off" method="post" action="#">

        		@component('components.bs.label', [
					'name' => 'uname',
					'label' => 'Nama Kesatuan',
				])
				{{ $formu->tenure->entity->name }}
				@endcomponent

				@component('components.bs.label', [
					'name' => 'uaddress',
					'label' => 'Alamat Ibu Pejabat',
					'mode' => 'required',
				])
				@if($formu->tenure->entity->addresses->last()->address)
					{{ $formu->tenure->entity->addresses->last()->address->address1.',' }}<br>
					{{ $formu->tenure->entity->addresses->last()->address->address2.',' }}<br>
					{{ $formu->tenure->entity->addresses->last()->address->address3.',' }}<br>
					{{ $formu->tenure->entity->addresses->last()->address->postcode.' ' }}
					{{ $formu->tenure->entity->addresses->last()->address->district ? $formu->tenure->entity->addresses->last()->address->district->name.', ' : ''}}
					{{ $formu->tenure->entity->addresses->last()->address->state ? $formu->tenure->entity->addresses->last()->address->state->name.'.' : '' }}
				@endif
				@endcomponent

				@if($formlu->formu->branch_id)
					@component('components.bs.label', [
						'name' => 'baddress',
						'label' => 'Cawangan',
						'mode' => 'required',
					])
					<span id="branch_name">
						{{ $formlu->formu->branch->name }}
					</span>
					@endcomponent
				@endif

				@include('components.bs.textarea', [
					'name' => 'setting',
					'label' => 'Ketetapan',
					'mode' => 'required',
					'value' => $formlu->formu->setting
				])

				@include('components.bs.date', [
					'name' => 'voted_at',
					'label' => 'Tarikh Undi Sulit',
					'mode' => 'required',
					'value' => $formlu->formu->voted_at ? date('d/m/Y', strtotime($formlu->formu->voted_at)) : '',
				])

				@include('components.bs.input', [
					'name' => 'total_voters',
					'label' => 'Jumlah Bilangan Anggota-anggota yang Berhak Untuk Mengundi',
					'mode' => 'required',
					'class' => 'numeric',
					'value' => $formlu->formu->total_voters
				])

				@include('components.bs.input', [
					'name' => 'total_slips',
					'label' => 'Jumlah Bilangan Kertas Undi yang Dipulangkan',
					'mode' => 'required',
					'class' => 'numeric',
					'value' => $formlu->formu->total_slips
				])

                @include('change-officer.lu.formu.examiner.index')
                @include('change-officer.lu.formu.arbitrator.index')
                @include('change-officer.lu.formu.trustee.index')

				<div class="form-group">
					<button onclick="location.href='{{ route('formlu.form', $formlu->id) }}'" type="button" class="btn btn-default mr-1" ><i class="fa fa-angle-left mr-1"></i> Kembali</button>
                    <button type="button" class="btn btn-info pull-right" onclick="save()"><i class="fa fa-check mr-1"></i> Simpan</button>
				</div>

			</div>
    	</div>
    </div>
</div>

@endsection


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
            location.href="{{ route('formlu.form', $formlu->id) }}";
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
		socket.emit('formu', {
			id: {{ $formlu->formu->id }},
        	name: $(this).attr('name'),
			value: $(this).attr('type') == 'checkbox' ? ($(this).prop('checked') ? 1 : 0) : $(this).val(),
			user: '{{ Cookie::get('api_token') }}'
		});
		console.log('changed');
	});
});
</script>
@endpush
