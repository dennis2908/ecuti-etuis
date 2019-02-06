<!-- START CONTAINER FLUID -->
<div class=" container-fluid container-fixed-lg bg-white">
	<!-- START card -->
	<div class="card card-transparent">
		<div class="card-block">
			<form id="form-forml" class="form-horizontal" role="form" autocomplete="off" method="post" action="#">

				@component('components.bs.label', [
					'name' => 'uname',
					'label' => 'Nama Kesatuan',
				])
				Kesatuan Unijaya
				@endcomponent

				@component('components.bs.label', [
					'name' => 'address',
					'label' => 'Alamat Ibu Pejabat',
					'mode' => 'required',
				])
				@if($formlu->tenure->entity->addresses->last()->address)
					{{ $formlu->tenure->entity->addresses->last()->address->address1.',' }}<br>
					{{ $formlu->tenure->entity->addresses->last()->address->address2.',' }}<br>
					{{ $formlu->tenure->entity->addresses->last()->address->address3.',' }}<br>
					{{ $formlu->tenure->entity->addresses->last()->address->postcode.' ' }}
					{{ $formlu->tenure->entity->addresses->last()->address->district ? $formlu->tenure->entity->addresses->last()->address->district->name.', ' : ''}}
					{{ $formlu->tenure->entity->addresses->last()->address->state ? $formlu->tenure->entity->addresses->last()->address->state->name.'.' : '' }}
				@endif
				@endcomponent

				@if($formlu->branch_id)
				@component('components.bs.label', [
					'name' => 'baddress',
					'label' => 'Cawangan',
					'mode' => 'required',
				])
				<span id="branch_name">
					{{ $formlu->branch->name }}
				</span>
				@endcomponent

				@component('components.bs.label', [
					'name' => 'baddress',
					'label' => 'Alamat Cawangan',
					'mode' => 'required',
				])
				<span id="branch_address">
					@if($formlu->branch->address)
						{{ $formlu->branch->address->address1.',' }}<br>
						{{ $formlu->branch->address->address2.',' }}<br>
						{{ $formlu->branch->address->address3.',' }}<br>
						{{ $formlu->branch->address->postcode.' ' }}
						{{ $formlu->branch->address->district ? $formlu->branch->address->district->name.', ' : ''}}
						{{ $formlu->branch->address->state ? $formlu->branch->address->state->name.'.' : '' }}
					@endif
				</span>
				@endcomponent
				@endif

				@include('components.bs.date', [
					'name' => 'resolved_at',
					'label' => 'Tarikh Mesyuarat',
					'mode' => 'required',
					'value' => $formlu->resolved_at ? date('d/mY', strtotime($formlu->resolved_at)) : '',
				])

				<div class="form-group row">
					<label for="" class="col-md-3 control-label">
						Melalui (Jenis Mesyuarat)<span style="color:red;">*</span>
					</label>
					<div class="col-md-9">
						<div class="radio radio-primary">
							@foreach($meeting_type as $type)
								<input name="meeting_type_id" value="{{ $type->id }}" id="meeting_type_{{ $type->id }}" type="radio" class="hidden" required>
								<label for="meeting_type_{{ $type->id }}">{{ $type->name }}</label>
							@endforeach
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
								<button type="button" class="btn btn-default mr-1" onclick="location.href='{{ route('formlu.form', $formlu->id) }}'"><i class="fa fa-angle-left mr-1"></i> Kembali</button>
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
$('#form-forml').validate();

</script>
@endpush
