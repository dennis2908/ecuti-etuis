<div class=" container-fluid container-fixed-lg bg-white">
	<!-- START card -->
	<div class="card card-transparent">
		<div class="card-block">
			<form id="form-tab7" class="form-horizontal" role="form" autocomplete="off" method="post" action="#">

				@component('components.bs.label', [
					'label' => 'Nama Penuh Firma',
				])
				{{ $statement->tenure->formjl1->count() > 0 ? $statement->tenure->formjl1->last()->firm_name : '' }}
				@endcomponent

				@component('components.bs.label', [
					'label' => 'No Pendaftaran Firma',
				])
				{{ $statement->tenure->formjl1->count() > 0  ? $statement->tenure->formjl1->last()->firm_registration_no : '' }}
				@endcomponent

				@component('components.bs.label', [
					'label' => 'Bendahari / Pegawai yang bertanggungjawab bagi akaun',
				])
				{{ $statement->tenure->officers()->where('designation_id', 5)->first()->name }}
				@endcomponent

				@component('components.bs.label', [
					'name' => 'signed_by',
					'label' => 'Ditandatangani dan diisytiharkan oleh',
					'mode' => 'required',
				])
				{{ $statement->tenure->officers()->where('designation_id', 5)->first()->name }}
				@endcomponent

				<div class="address">
					<div class="form-group row">
						<label for="" class="col-md-3 control-label">
							Ditandatangani dan diisytiharkan di negeri<span style="color:red;">*</span>
						</label>
						<div class="col-md-9">
							<select class="full-width state" data-init-plugin="select2" name="signed_state_id" id="signed_state_id">
								<option selected disabled hidden>Pilih satu..</option>
								@foreach($states as $index => $state)
								<option value="{{ $state->id }}">{{ $state->name }}</option>
								@endforeach
							</select>
						</div>
					</div>

					<div class="form-group row">
						<label for="" class="col-md-3 control-label">
							Ditandatangani dan diisytiharkan di daerah<span style="color:red;">*</span>
						</label>
						<div class="col-md-9">
							<select class="full-width district" data-init-plugin="select2" name="signed_district_id" id="signed_district_id">
								<option selected disabled hidden>Pilih satu..</option>
							</select>
						</div>
					</div>
				</div>
				
				@include('components.bs.date', [
					'name' => 'signed_at',
					'label' => 'pada......... haribulan.......... 20...',
					'mode' => 'required',
					'value' => $statement->signed_at ? date('d/m/Y', strtotime($statement->signed_at)) : '',
				])
			</form>

			<br>

			<div class="row mt-5">
				<div class="col-md-12">
					<ul class="pager wizard no-style">
						<li class="submit">
							<button onclick="save()" class="btn btn-info btn-cons btn-animated from-left pull-right fa fa-check" type="button">
								<span>Simpan</span>
							</button>
						</li>
						<li class="next">
							<button class="btn btn-success btn-cons btn-animated from-left pull-right fa fa-angle-right" type="button">
								<span>Seterusnya</span>
							</button>
						</li>
						<li class="previous">
							<button class="btn btn-default btn-cons btn-animated from-left fa fa-angle-left" type="button">
								<span>Kembali</span>
							</button>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<!-- END card -->
</div>

@push('js')
<script type="text/javascript">
	$('#form-tab7').validate();
</script>
@endpush