<!-- START CONTAINER FLUID -->
<div class=" container-fluid container-fixed-lg bg-white">
	<!-- START card -->
	<div class="card card-transparent">
		<div class="card-block">
			<form id="form-tab7" class="form-horizontal" role="form" autocomplete="off" method="post" action="#">

				@include('components.bs.textarea', [
					'name' => 'comment',
					'label' => 'Ulasan',
					'mode' => 'required',
					'value' => $enforcement->pbp2->comment
				])
				
				<div class="row mt-5">
					<div class="col-md-12">
						<ul class="pager wizard no-style">
							<li class="submit">
								<button class="btn btn-info btn-cons btn-animated from-left pull-right fa fa-check" onclick="save()" type="button">
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
			</form>
		</div>
	</div>
</div>

@push('js')
<script type="text/javascript">
	$('#form-tab7').validate();
</script>
@endpush