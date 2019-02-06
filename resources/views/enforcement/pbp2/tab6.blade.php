<!-- START CONTAINER FLUID -->
<div class=" container-fluid container-fixed-lg bg-white">
	<!-- START card -->
	<div class="card card-transparent">
		<div class="card-block">
			<form id="form-tab6" class="form-horizontal" role="form" autocomplete="off" method="post" action="#">
				<div class="card card-transparent mt-3 mb-2">
					<div class="card-block p-t-0">
						<h5 class='m-t-5'><span class="semi-bold">::Penggabungan</span> Dengan Persekutuan Kesatuan Sekerja</h5> 
						<hr>
					</div>
				</div>

				<div class="form-group row">
					<label for="checklist45" class="col-md-4 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="0" id="checklist45" type="checkbox" class="hidden">
							<label for="checklist45">Kesatuan bergabung dengan mana-mana persekutuan Kesatuan Sekerja</label>
						</div>
					</label>
					<div class="col-md-8">
						<select id="multi" name="federations" class="full-width" data-init-plugin="select2" multiple>
							@foreach($federations as $federation)
							<option 
							@if($enforcement->federations->where('user_federation_id', $federation->id)->count() > 0)
								selected
							@endif
							value="{{ $federation->id }}">{{ $federation->name }}</option>
							@endforeach
						</select>    
					</div>
				</div>

				<div class="card card-transparent mt-3 mb-2">
					<div class="card-block p-t-0">
						<h5 class='m-t-5'><span class="semi-bold">::Penggabungan</span> Dengan Badan Perunding Dalam Negeri</h5> 
						<hr>
					</div>
				</div>

				@include('enforcement.pbp2.internal-consultant.index')

				<div class="card card-transparent mt-3 mb-2">
					<div class="card-block p-t-0">
						<h5 class='m-t-5'><span class="semi-bold">::Penggabungan</span> Dengan Badan Perunding Luar Negeri</h5> 
						<hr>
					</div>
				</div>

				@include('enforcement.pbp2.external-consultant.index')

				<div class="row mt-5">
					<div class="col-md-12">
						<ul class="pager wizard no-style">
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
			</form>
		</div>
	</div>
</div>

@push('js')
<script type="text/javascript">
	$('#form-tab6').validate();

	@if($enforcement->federations->count() != 0)
		$("#checklist45").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->internal_consultants->count() != 0)
		$("#checklist46").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->external_consultants->count() != 0)
		$("#checklist47").prop('checked', true).trigger('change');
	@endif
</script>
@endpush