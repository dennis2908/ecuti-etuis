<!-- START CONTAINER FLUID -->
<div class=" container-fluid container-fixed-lg bg-white">
	<!-- START card -->
	<div class="card card-transparent">
		<div class="card-block">
			<div class="col-md-12 text-center p-t-20">
				<span class="bold">KLASIFIKASI ANGGOTA MENGIKUT FAEDAH MELALUI BANGSA DAN JANTINA</span>
			</div>
			<form id="form-tab2" class="form-horizontal" role="form" autocomplete="off" method="post" action="">
				<div class="form-group row">
					<label for="fname" class="col-md-3 control-label">Lelaki<span style="color:red;">*</span></label>
					<div class="col-md-9">
						<div class="row">
							<div class="input-group col-md-3">
		                      	<span class="input-group-addon default">
		                          	Melayu
		                      	</span>
								<input type="text" name="male_malay" value="{{ $statement->male_malay }}" class="autonumeric numeric form-control">
							</div>
							<div class="input-group col-md-3">
		                      	<span class="input-group-addon default">
		                          	Cina
		                      	</span>
								<input type="text" name="male_chinese" value="{{ $statement->male_chinese }}" class="autonumeric numeric form-control">
							</div>
							<div class="input-group col-md-3">
		                      	<span class="input-group-addon default">
		                          	India
		                      	</span>
								<input type="text" name="male_indian" value="{{ $statement->male_indian }}" class="autonumeric numeric form-control">
							</div>
							<div class="input-group col-md-3">
		                      	<span class="input-group-addon default">
		                          	Lain-lain
		                      	</span>
								<input type="text" name="male_others" value="{{ $statement->male_others }}" class="autonumeric numeric form-control">
							</div>
						</div>
					</div>
				</div>

				<div class="form-group row">
					<label for="fname" class="col-md-3 control-label">Perempuan<span style="color:red;">*</span></label>
					<div class="col-md-9">
						<div class="row">
							<div class="input-group col-md-3">
		                      	<span class="input-group-addon default">
		                          	Melayu
		                      	</span>
								<input type="text" name="female_malay" value="{{ $statement->female_malay }}" class="autonumeric numeric form-control">
							</div>
							<div class="input-group col-md-3">
		                      	<span class="input-group-addon default">
		                          	Cina
		                      	</span> 
								<input type="text" name="female_chinese" value="{{ $statement->female_chinese }}" class="autonumeric numeric form-control">
							</div>
							<div class="input-group col-md-3">
		                      	<span class="input-group-addon default">
		                          	India
		                      	</span>
								<input type="text" name="female_indian" value="{{ $statement->female_others }}" class="autonumeric numeric form-control">
							</div>
							<div class="input-group col-md-3">
		                      	<span class="input-group-addon default">
		                          	Lain-lain
		                      	</span>
								<input type="text" name="female_others" value="{{ $statement->female_others }}" class="autonumeric numeric form-control">
							</div>
						</div>
					</div>
				</div>

				@include('components.bs.input', [
					'name' => 'duration',
					'label' => 'sepanjang tempoh',
					'mode' => 'required',
					'value' => $statement->duration
				])
			</form>
			
			<br>
			
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
		</div>
	</div>
	<!-- END card -->
</div>
<!-- END CONTAINER FLUID -->
@push('js')
<script type="text/javascript">
	$('#form-tab2').validate();
</script>
@endpush