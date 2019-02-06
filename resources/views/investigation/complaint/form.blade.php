@extends('layouts.app')
@include('plugins.dropzone')
@include('plugins.datepicker')
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
			{{ Breadcrumbs::render('complaint') }}
			<!-- END BREADCRUMB -->
			<div class="row">
				<div class="col-xl-12 col-lg-12 ">
					<!-- START card -->
					<div class="card card-transparent">
						<div class="card-block p-t-0">
							<h3 class='m-t-0'>Pendaftaran Aduan</h3>
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
                <form  id="form-complaint" class="form-horizontal" role="form" autocomplete="off" method="post" action="#">
                    <div class="form-group row">
                        <label for="" class="col-md-3 control-label">
                            Kalsifikasi Aduan<span style="color:red;">*</span>
                        </label>
                        <div class="col-md-9">
                            <div class="radio radio-primary">
                                @foreach($classifications as $classification)
                                    <input name="complaint_classification_id" value="{{ $classification->id }}" id="classification_{{ $classification->id }}" type="radio" class="hidden" required>
                                    <label for="classification_{{ $classification->id }}">{{ $classification->name }}</label>
                                @endforeach
                            </div>
                        </div>
                    </div>

    				@include('components.bs.input', [
    					'name' => 'complaint_by',
    					'label' => 'Nama Pengadu',
    					'mode' => 'required',
                        'value' => $complaint->complaint_by,
    				])

    				@include('components.bs.textarea', [
    					'name' => 'address',
    					'label' => 'Alamat Pengadu',
    					'mode' => 'required',
                        'value' => $complaint->address,
    				])

    				@include('components.bs.input', [
    					'name' => 'phone',
    					'label' => 'No Telefon',
    					'mode' => 'required',
                        'value' => $complaint->phone,
    				])

    				@include('components.bs.input', [
    					'name' => 'email',
    					'label' => 'Alamat Emel',
    					'mode' => 'required',
                        'type' => 'email',
                        'value' => $complaint->email,
    				])

                    <div class="form-group row">
                        <label for="is_member" class="col-md-3 control-label">
                            Ahli Kesatuan
                            <span style="color:red;">*</span>
                        </label>
                        <div class="col-md-9">
                            <div class="radio radio-primary">
                                <input name="is_member" value="1" id="is_member_yes" type="radio" class="hidden" required>
                                <label for="is_member_yes">Ya</label>

                                <input name="is_member" value="0" id="is_member_no" type="radio" class="hidden" required>
                                <label for="is_member_no">Tidak</label>
                            </div>
                        </div>
                    </div>

    				@include('components.bs.input', [
    					'name' => 'title',
    					'label' => 'Tajuk surat aduan',
    					'mode' => 'required',
                        'value' => $complaint->title,
    				])

    				@include('components.bs.input', [
    					'name' => 'complaint_against',
    					'label' => 'Pihak yang Diadu',
    					'mode' => 'required',
                        'value' => $complaint->complaint_against,
    				])

    				@include('components.bs.date', [
    					'name' => 'received_at',
    					'label' => 'Tarikh Aduan diterima',
    					'mode' => 'required',
                        'value' =>  $complaint->received_at ? date('d/m/Y', strtotime($complaint->received_at)) : date('d/m/Y'),
    				])

    				<br>
    				<div class="form-group">
    					<button type="button" class="btn btn-default mr-1" ><i class="fa fa-angle-left mr-1" onclick="location.href='{{ route('investigation.complaint.item', $complaint->id) }}'"></i> Kembali</button>
    					<button type="button" class="btn btn-info pull-right btn-send" onclick="save()"><i class="fa fa-check mr-1"></i> Simpan</button>
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

	$("#form-complaint").validate();

	function save() {
		swal({
			title: "Berjaya!",
			text: "Data yang telah disimpan.",
			icon: "success",
			button: "OK",
		})
		.then((confirm) => {
			if (confirm) {
				location.href="{{ route('investigation.complaint.item', $complaint->id) }}";
			}
		});
	}

	$(document).ready(function() {

        $("#classification_{{ $complaint->complaint_classification_id }}").prop('checked', true).trigger('change');

		$("#is_member_{{ $complaint->is_member == 1 ? 'yes' : 'no' }}").prop('checked', true).trigger('change');

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
	        socket.emit('complaint', {
	            id: {{ $complaint->id }},
	            name: $(this).attr('name'),
	            value: $(this).attr('type') == 'checkbox' ? ($(this).prop('checked') ? 1 : 0) : $(this).val(),
                user: '{{ Cookie::get('api_token') }}'
	        });
	        console.log('changed');
	    });
	});

</script>
@endpush
