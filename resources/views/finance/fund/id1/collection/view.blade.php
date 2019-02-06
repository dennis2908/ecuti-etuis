<div class="modal fade" id="modal-viewCollection" tabindex="-1" role="dialog" aria-hidden="false">
	<div class="modal-dialog ">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="modal-header clearfix text-left">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
					</button>
					<h5>Maklumat <span class="semi-bold">Kutipan Dana Tahun {{ date('Y', strtotime($collection->start_date)) }}</span></h5>
                    <p class="p-b-10">Sila semak maklumat pada ruangan di bawah.</p>
				</div>
				<div class="modal-body">
					<div class="form-group-attached">
						<div class="row">
							<div class="col-md-12">
								@component('components.label', [
									'label' => 'Cawangan',
								])
    								@foreach($collection->branches as $branch)
                                        $branch->name
                                        @if(!$branch == end($collection->branches))
                                            ,
                                        @endif
                                    @endforeach
								@endcomponent
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								@component('components.label', [
									'label' => 'Tujuan Kutipan',
								])
								{{ $collection->objective }}
								@endcomponent
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								@component('components.label', [
									'label' => 'Jumlah sasaran wang yang dirancang',
								])
								RM {{ $collection->target_amount }}.00
								@endcomponent
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								@component('components.label', [
									'label' => 'Jumlah anggaran perbelanjaan aktiviti yang dirancang',
								])
								RM {{ $collection->estimated_expenses }}.00
								@endcomponent
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								@component('components.label', [
									'label' => 'Tempoh kutipan wang yang akan dilakukan',
								])
								{{ date('d/m/Y', strtotime($collection->start_date)) }} - {{ date('d/m/Y', strtotime($collection->end_date)) }}
								@endcomponent
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								@component('components.label', [
									'label' => 'Kelulusan melalui',
								])
								{{ $collection->meeting_type->name }}
								@endcomponent
							</div>
							<div class="col-md-6">
								@component('components.label', [
									'label' => 'Tarikh diluluskan',
								])
								{{ date('d/m/Y', strtotime($collection->resolved_at)) }}
								@endcomponent
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
</div>

<script src="{{ asset('js/global.js') }}"></script>
<script type="text/javascript">

    $('#modal-viewCollection').modal('show');

</script>
