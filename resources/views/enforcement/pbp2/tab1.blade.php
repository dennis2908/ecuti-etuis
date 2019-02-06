<!-- START CONTAINER FLUID -->
<div class=" container-fluid container-fixed-lg bg-white">
	<!-- START card -->
	<div class="card card-transparent">
		<div class="card-block">
			<form id="form-tab1" class="form-horizontal" role="form" autocomplete="off" method="post" action="#">
				<!--Syarat: Berdasarkan pilihan radio button kesatuan/cawangan pada sesi pemeriksaan-->
				@component('components.bs.label', [
					'label' => 'Jenis Kesatuan',
				])
				Cawangan
				@endcomponent
				<!-- end syarat-->

				<div class="form-group row">
					<label for="province_office_id" class="col-md-3 control-label">JHEKS Wilayah / Negeri
						<!-- <span style="color:red;">*</span> -->
					</label>
					<div class="col-md-9">
						<select id="province_office_id" name="province_office_id" class="full-width" data-init-plugin="select2">
							<option value="" disabled="" selected="">Pilih satu..</option>
							@foreach($province_offices as $office)
							<option value="{{ $office->id }}">{{ $office->name }}</option>
							@endforeach
						</select>          
					</div>
				</div>

				@include('components.bs.date', [
					'name' => 'investigation_date',
					'label' => 'Tarikh Pemeriksaan',
					'mode' => 'required',
					'value' => $enforcement->pbp2->investigation_date ? date('d/m/Y', strtotime($enforcement->pbp2->investigation_date)) : ''
				])

				@include('components.bs.date', [
					'name' => 'old_investigation_date',
					'label' => 'Tarikh Pemeriksaan Dahulu',
					'info' => 'Jika Ada',
					'value' => $enforcement->pbp2->old_investigation_date ? date('d/m/Y', strtotime($enforcement->pbp2->old_investigation_date)) : ''
				])

				@include('components.bs.input', [
					'name' => 'location',
					'label' => 'Tempat Pemeriksaan',
					'mode' => 'required',
					'value' => $enforcement->pbp2->location
				])

				<div class="form-group row">
					<label class="col-md-3 control-label">Tujuan Pemeriksaan  <span style="color:red;">*</span></label>
					<div class="col-md-9">
						<div class="checkbox check-success">
							<input value="{{ $enforcement->pbp2->is_administration_record }}" name="is_administration_record" id="is_administration_record" type="checkbox" class="hidden">
							<label for="is_administration_record">(a)	Pemeriksaan Rekod Pentadbiran</label>
						</div>
						<div class="checkbox check-success">
							<input value="{{ $enforcement->pbp2->is_finance_record }}" name="is_finance_record" id="is_finance_record" type="checkbox" class="hidden">
							<label for="is_finance_record">(b)	Pemeriksaan Rekod Kewangan</label>
						</div>
						<div class="checkbox check-success">
							<input value="{{ $enforcement->pbp2->is_complaint_investigation }}" name="is_complaint_investigation" id="is_complaint_investigation" type="checkbox" class="hidden">
							<label for="is_complaint_investigation">(c)	Penyiasatan Aduan</label><br>
							<input class="form-control m-t-10" id="complaint_reference_no" name="complaint_reference_no" type="text" value="{{ $enforcement->pbp2->complaint_reference_no }}" placeholder="No. rujukan aduan" required="">
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<ul class="pager wizard no-style">
							<li class="next">
								<button class="btn btn-success btn-cons btn-animated from-left pull-right fa fa-angle-right" type="button">
									<span>Seterusnya</span>
								</button>
							</li>
							<li>
								<a type="button" class="btn btn-default mr-1" href="{{ route('enforcement.form', ['id' => $enforcement->id]) }}"><i class="fa fa-angle-left mr-1"></i> Kembali</a>
							</li>
						</ul>
					</div>
				</div>
			</form>
		</div>
	</div>
	<!-- END card -->
</div>
<!-- END CONTAINER FLUID -->


@push('js')
<script type="text/javascript">
	$('#form-tab1').validate();

	@if($enforcement->pbp2->province_office_id)
    $("#province_office_id").val( {{ $enforcement->pbp2->province_office_id }} ).trigger('change');
    @endif

	@if($enforcement->pbp2->is_administration_record == 1)
		$("#is_administration_record").prop('checked', true).trigger('change');
	@endif
	@if($enforcement->pbp2->is_finance_record == 1)
		$("#is_finance_record").prop('checked', true).trigger('change');
	@endif
	@if($enforcement->pbp2->is_complaint_investigation == 1)
		$("#is_complaint_investigation").prop('checked', true).trigger('change');
		$('#complaint_reference_no').show();
	@else		
		$('#complaint_reference_no').hide();
	@endif
    

</script>
@endpush