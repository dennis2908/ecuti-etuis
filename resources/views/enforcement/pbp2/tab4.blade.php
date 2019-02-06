<!-- START CONTAINER FLUID -->
<div class=" container-fluid container-fixed-lg bg-white">
	<!-- START card -->
	<div class="card card-transparent">
		<div class="card-block">
			<form id="form-tab4" class="form-horizontal" role="form" autocomplete="off" method="post" action="#">

				<div class="card card-transparent mt-3 mb-2">
					<div class="card-block p-t-0">
						<h5 class='m-t-5'><span class="semi-bold">:: Anggaran</span> Belanjawan</h5> 
						<hr>
					</div>
				</div>
				<div class="form-group row">
					<label for="checklist25" class="col-md-4 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="0" id="checklist25" type="checkbox" class="hidden">
							<label for="checklist25">Anggaran Belanjawan disediakan dan dibentangkan semasa ...
								<i style="cursor: help; color: #48B0F7;" class="fa fa-question-circle" data-html="true" data-toggle="tooltip" title="Peraturan 19(6) Peraturan-Peraturan Kesatuan Sekerja 1959"></i>
							</label>
						</div>
					</label>
					<div class="col-md-8">
						<div class="radio radio-primary">
							<!-- Mesyuarat agung, mesyuarat agung luar biasa, persidangan perwakilan-->
							@foreach($meeting_types as $meeting_type)
							<input name="budget_meeting_type_id" value="{{ $meeting_type->id }}" id="budget_meeting_type_{{ $meeting_type->id }}" type="radio" class="hidden">
							<label for="budget_meeting_type_{{ $meeting_type->id }}">{{ $meeting_type->name }}</label>
							@endforeach
						</div>
					</div>
				</div>

				<div class="card card-transparent mt-3 mb-2">
					<div class="card-block p-t-0">
						<h5 class='m-t-5'><span class="semi-bold">:: Penyata Penerimaan</span> dan Pembayaran</h5> 
						<hr>
					</div>
				</div>

				<div class="form-group row">
					<label for="checklist26" class="col-md-4 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="1" id="checklist26" type="checkbox" class="hidden">
							<label for="checklist26">Penyata Penerimaan/ Pembayaran bagi tempoh .......... hingga ............ seperti dinyatakan dalam 
								<a id="" href="{{ route('pbp2.c1', $enforcement->id) }}" target="_blank" class="btn btn-primary btn-cons text-capitalize btn-sm"><i class="fa fa-plus m-r-5"></i> Lampiran C1</a>
							</label>
						</div>
					</label>
					<div class="col-md-8">
						<div class="input-daterange date input-group" id="datepicker-range">
		                    <input type="text" class="input-sm form-control" name="statement_start_at" value="{{ $enforcement->pbp2->statement_start_at ? date('d/m/Y', strtotime($enforcement->pbp2->statement_start_at)) : '' }}" />
		                    <div class="input-group-addon">Hingga</div>
		                    <input type="text" class="input-sm form-control" name="statement_end_at" value="{{ $enforcement->pbp2->statement_end_at ? date('d/m/Y', strtotime($enforcement->pbp2->statement_end_at)) : '' }}" />
		                </div>
					</div>
				</div>

				<div class="card card-transparent mt-3 mb-2">
					<div class="card-block p-t-0">
						<h5 class='m-t-5'><span class="semi-bold">:: Pemeriksaan</span> Juruaudit Dalam</h5> 
						<hr>
					</div>
				</div>

				@include('enforcement.pbp2.auditor.index')

				<div class="form-group row">
					<label for="checklist28" class="col-md-4 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="1" id="checklist28" type="checkbox" class="hidden">
							<label for="checklist28">Pengauditan perlu dijalankan pada penghujung tiap-tiap tiga (3) bulan mengikut  Perlembagaan Kesatuan dan tarikh pemeriksaan terakhir dijalankan:
							</label>
						</div>
					</label>
					<div class="col-md-8">
						<div id="datepicker-component" class="input-group date p-l-0">
		                    <input type="text" class="form-control" name="audited_at" value="{{ $enforcement->pbp2->audited_at ? date('d/m/Y', strtotime($enforcement->pbp2->audited_at)) : '' }}" >
		                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
		                </div>
					</div>
				</div>

				@include('enforcement.pbp2.record.index')

				<div class="card card-transparent mt-3 mb-2">
					<div class="card-block p-t-0">
						<h5 class='m-t-5'><span class="semi-bold">:: Maklumat</span> Akaun Bank</h5> 
						<hr>
					</div>
				</div>

				@include('enforcement.pbp2.account.index')

				@include('enforcement.pbp2.fixed-deposit-account.index')

				<!-- Syarat: Jika Kesatuan Induk sahaja-->
				<div class="card card-transparent mt-3 mb-2">
					<div class="card-block p-t-0">
						<h5 class='m-t-5'><span class="semi-bold">:: Borang N</span> (Induk)(Seksyen 56(1))</h5> 
						<hr>
					</div>
				</div>

				<div class="form-group row">
					<label for="checklist32" class="col-md-4 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="0" id="checklist32" type="checkbox" class="hidden">
							<label for="checklist32">Borang N yang terakhir dikemukakan: Tahun Kewangan</label>
						</div>
					</label>
					<div class="col-md-8">
						<input type="text" placeholder="20XX" name="latest_formn_year" value="{{ $enforcement->pbp2->latest_formn_year }}" class="form-control">
					</div>
				</div>

				<div class="form-group row">
					<label for="checklist33" class="col-md-4 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="0" id="checklist33" type="checkbox" class="hidden">
							<label for="checklist33">Borang N yang belum dikemukakan: Tahun Kewangan</label>
						</div>
					</label>
					<div class="col-md-8">
						<input type="text" placeholder="20XX" name="missed_formn_year" value="{{ $enforcement->pbp2->missed_formn_year }}" class="form-control">
					</div>
				</div>

				<div class="form-group row">
					<label for="checklist34" class="col-md-4 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="0" id="checklist34" type="checkbox" class="hidden">
							<label for="checklist34">Alasan tidak mengemukakan</label>
						</div>
					</label>
					<div class="col-md-8">
						<textarea style="height: 100px;" placeholder="" name="justification_notsubmit" class="form-control">{{ $enforcement->pbp2->justification_notsubmit }}</textarea>
					</div>
				</div>

				<div class="form-group row">
					<label for="checklist35" class="col-md-4 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="0" id="checklist35" type="checkbox" class="hidden">
							<label for="checklist35">Pelantikan Juruaudit luar.
								<i style="cursor: help; color: #48B0F7;" class="fa fa-question-circle" data-html="true" data-toggle="tooltip" title="Juruaudit hendaklah dilantik tidak lebih 3 tahun berturut-turut"></i>
							</label>
						</div>
					</label>
					<div class="col-md-8">
						Sekiranya tiada Juruaudit Luar dilantik, nyatakan alasan Kesatuan
						<textarea style="height: 100px;" placeholder="" class="form-control" name="non_external_auditor">{{ $enforcement->pbp2->non_external_auditor }}</textarea>
					</div>
				</div>
				<!-- End syarat-->
				
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
	<!-- END card -->
</div>

@push('js')
<script type="text/javascript">
	$('#form-tab4').validate();

    $("#budget_meeting_type_{{ $enforcement->pbp2->budget_meeting_type_id }}").prop('checked', true).trigger('change');

    @if($enforcement->pbp2->budget_meeting_type_id)
		$("#checklist25").prop('checked', true).trigger('change');
	@endif

    @if($enforcement->pbp2->statement_start_at || $enforcement->pbp2->statment_end_date)
		$("#checklist26").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->auditors->count() != 0)
		$("#checklist27").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->audited_at)
		$("#checklist28").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->records->count() != 0)
		$("#checklist29").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->accounts->count() != 0)
		$("#checklist30").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->fd_accounts->count() != 0)
		$("#checklist31").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->latest_formn_year)
		$("#checklist32").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->missed_formn_year)
		$("#checklist33").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->justification_notsubmit)
		$("#checklist34").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->non_external_auditor)
		$("#checklist35").prop('checked', true).trigger('change');
	@endif
</script>
@endpush