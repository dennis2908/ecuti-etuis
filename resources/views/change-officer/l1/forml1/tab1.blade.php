<!-- START CONTAINER FLUID -->
<div class=" container-fluid container-fixed-lg bg-white">
	<!-- START card -->
	<div class="card card-transparent">
		<div class="card-block">
			<form class="form-horizontal" role="form" autocomplete="off" method="post" action="#">

				@component('components.bs.label', [
					'name' => 'uname',
					'label' => 'Nama Kesatuan',
				])
				{{ $forml1->tenure->entity->name }}
				@endcomponent

				@component('components.bs.label', [
					'name' => 'uaddress',
					'label' => 'Alamat Ibu Pejabat',
					'mode' => 'required',
				])
				{!! $forml1->address->address1.
                ($forml1->address->address2 ? ',<br>'.$forml1->address->address2 : '').
                ($forml1->address->address3 ? ',<br>'.$forml1->address->address3 : '').
                ',<br>'.
                $forml1->address->postcode.' '.
                ($forml1->address->district ? $forml1->address->district->name : '').', '.
                ($forml1->address->state ? $forml1->address->state->name : '') !!}
				@endcomponent

				@if($forml1->branch_id)
					@component('components.bs.label', [
						'name' => 'baddress',
						'label' => 'Cawangan',
						'mode' => 'required',
					])
					<span id="branch_name">
						{{ $forml1->branch->name }}
					</span>
					@endcomponent

					@component('components.bs.label', [
						'name' => 'baddress',
						'label' => 'Alamat Cawangan',
						'mode' => 'required',
					])
					<span id="branch_address">
					@if($forml1->branch->address)
						{!! $forml1->branch->address->address1.
	                    ($forml1->branch->address->address2 ? ',<br>'.$forml1->branch->address->address2 : '').
	                    ($forml1->branch->address->address3 ? ',<br>'.$forml1->branch->address->address3 : '').
	                    ',<br>'.
	                    $forml1->branch->address->postcode.' '.
	                    ($forml1->branch->address->district ? $forml1->branch->address->district->name : '').', '.
	                    ($forml1->branch->address->state ? $forml1->branch->address->state->name : '') !!}
	                @endif
					</span>
					@endcomponent
				@endif

				@include('components.bs.date', [
					'name' => 'resolved_at',
					'label' => 'Tarikh Mesyuarat',
					'mode' => 'required',
					'value' => $forml1->resolved_at ? date('d/mY', strtotime($forml1->resolved_at)) : '',
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
								<button type="button" class="btn btn-default mr-1" onclick="location.href='{{ route('forml1.item', $forml1->id) }}'"><i class="fa fa-angle-left mr-1"></i> Kembali</button>
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

