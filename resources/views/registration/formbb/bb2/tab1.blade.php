<!-- START CONTAINER FLUID -->
<div class=" container-fluid container-fixed-lg bg-white">
	<!-- START card -->
	<div class="card card-transparent">
		<div class="card-block">
			<form id="form-tab1" class="form-horizontal" role="form" autocomplete="off" method="post" action="#">

				@include('components.bs.input', [
					'name' => 'federation_name',
					'label' => 'Nama Persekutuan Kesatuan Sekerja',
					'mode' => 'required',
					'value' => $formbb->federation->name
				])

				<div class="form-group row">
					<label class="col-md-3 control-label">
						Alamat Ibu Pejabat
					</label>
					<div class="col-md-9">
						<input class="form-control m-t-5" name="address1" type="text" value="{{ $formbb->address->address1 or '' }}" required>
						<input class="form-control m-t-5" name="address2" type="text" value="{{ $formbb->address->address2 or '' }}">
						<input class="form-control m-t-5" name="address3" type="text" value="{{ $formbb->address->address3 or '' }}">
						<div class="row address">
							<div class="col-md-2 m-t-5">
								<input class="form-control numeric postcode" name="postcode" aria-required="true" type="text" value="{{ $formbb->address->postcode or '' }}" required placeholder="Poskod" minlength="5" maxlength="5">
							</div>
							<div class="col-md-5 m-t-5">
								<select id="state_id" name="state_id" class="full-width autoscroll state" data-init-plugin="select2" required="">
                                    <option value="" selected="" disabled="">Pilih Negeri</option>
                                    @foreach($states as $index => $state)
                                    <option value="{{ $state->id }}"
                                    	@if($formbb->address)
                                    		@if($formbb->address->state_id == $state->id)
                                    			selected
                                    		@endif
                                    	@endif
                                    	>{{ $state->name }}
                                    </option>
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

				@component('components.bs.label', [
					'name' => 'established_at',
					'label' => 'Tarikh Penubuhan',
				])
				{{ date('d/m/Y' , strtotime($formbb->federation->registered_at)) }}
				@endcomponent

				<div class="form-group row">
					<label for="" class="col-md-3 control-label">
						Jenis Persekutuan <span style="color:red;">*</span>
					</label>
					<div class="col-md-9">
						<div class="radio radio-primary">
							@foreach($federation_type as $index => $type)
							<input name="federation_type_id" value="{{ $type->id }}" id="federation_type_{{ $type->id }}" type="radio" class="hidden" required>
							<label for="federation_type_{{ $type->id }}">{{ $type->name }}</label>
							@endforeach
						</div>
					</div>
				</div>

				<div class="form-group row">
					<label for="" class="col-md-3 control-label">
						Sektor <span style="color:red;">*</span>
					</label>
					<div class="col-md-9">
						<div class="radio radio-primary">
							@foreach($sectors as $index => $sector)
							<input name="sector_id" value="{{ $sector->id }}" id="sector_{{ $sector->id }}" type="radio" class="hidden" required>
							<label for="sector_{{ $sector->id }}">{{ $sector->name }}</label>
							@endforeach
						</div>
					</div>
				</div>

				@include('components.bs.date', [
					'name' => 'resolved_at',
					'label' => 'Tarikh Diputuskan',
					'value' => $formbb->resolved_at ? date('d/m/Y', strtotime($formbb->resolved_at)) : ''
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
					'name' => 'union_name',
					'label' => 'Nama Kesatuan ',
				])
				<ul class="pl-3">
					@foreach($formbb->federation->unions as $union)
					<li>{{ $union->name }}</li>
					@endforeach
				</ul>
				@endcomponent

				@component('components.bs.label', [
					'name' => 'secretary',
					'label' => 'Nama Setiausaha Penaja ',
				])
				{{ $formbb->created_by->name }}
				@endcomponent

				<div class="row">
					<div class="col-md-12">
						<ul class="pager wizard no-style">
							<li class="next">
								<button class="btn btn-success btn-cons btn-animated from-left pull-right fa fa-angle-right" type="button">
									<span>Seterusnya</span>
								</button>
							</li>
							<li>
								<button type="button" class="btn btn-default mr-1" onclick="location.href='{{ route('formbb', ['id' => $formbb->id]) }}'"><i class="fa fa-angle-left mr-1"></i> Kembali</button>
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
</script>
@endpush
