<!-- START CONTAINER FLUID -->
<div class=" container-fluid container-fixed-lg bg-white">
	<!-- START card -->
	<div class="card card-transparent">
		<div class="card-block">
			<form id="form-tab5" class="form-horizontal" role="form" autocomplete="off" method="post" action="#">

				<div class="card card-transparent mt-3 mb-2">
					<div class="card-block p-t-0">
						<h5 class='m-t-5'><span class="semi-bold">:: Mesyuarat Agung</span> /Persidangan Perwakilan</h5> 
						<hr>
					</div>
				</div>

				<div class="form-group row">
					<label for="checklist36" class="col-md-4 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="0" id="checklist36" type="checkbox" class="hidden">
							<label for="checklist36">a) Diadakan mengikut Perlembagaan Kesatuan.
								<i style="cursor: help; color: #48B0F7;" class="fa fa-question-circle" data-html="true" data-toggle="tooltip" title="Peraturan 9 (1) Peraturan-Peraturan Kesatuan"></i>
							</label>
						</div>
					</label>
					<div class="col-md-8">
						<div class="radio radio-success">
							<input type="radio" checked="checked" value="1" name="meeting_duration_id" id="meeting_duration1">
							<label for="meeting_duration1">Tahunan</label>
						</div>
						<div class="radio radio-success">
							<input type="radio" value="2" name="meeting_duration_id" id="meeting_duration2">
							<label for="meeting_duration2">Dwi Tahunan</label>
						</div>
						<div class="radio radio-success">
							<input type="radio" value="3" name="meeting_duration_id" id="meeting_duration3">
							<label for="meeting_duration3">Tiga Tahunan</label>
						</div>
					</div>
				</div>

				<div class="form-group row">
					<label for="is_agenda_meeting" class="col-md-12 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="{{ $enforcement->pbp2->is_agenda_meeting }}" id="is_agenda_meeting" type="checkbox" class="hidden">
							<label for="is_agenda_meeting">b) Mesyuarat berjalan mengikut agenda	</label>
						</div>
					</label>
				</div>

				<div class="form-group row">
					<label for="is_enough_corum" class="col-md-12 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="{{ $enforcement->pbp2->is_enough_corum }}" id="is_enough_corum" type="checkbox" class="hidden">
							<label for="is_enough_corum">c) Cukup korum</label>
						</div>
					</label>
				</div>

				<div class="form-group row">
					<label for="is_minutes_prepared" class="col-md-12 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="{{ $enforcement->pbp2->is_minutes_prepared }}" name="is_minutes_prepared" id="is_minutes_prepared" type="checkbox" class="hidden">
							<label for="is_minutes_prepared">d) Minit telah disediakan</label>
						</div>
					</label>
				</div>

				<div class="form-group row">
					<label for="is_ammendment_approved" class="col-md-12 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="{{ $enforcement->pbp2->is_ammendment_approved }}" name="is_ammendment_approved" id="is_ammendment_approved" type="checkbox" class="hidden">
							<label for="is_ammendment_approved">e) Ada usul pindaan diluluskan</label>
						</div>
					</label>
				</div>

				<div class="form-group row">
					<label for="is_complaint" class="col-md-12 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="{{ $enforcement->pbp2->is_complaint }}" name="is_complaint" id="is_complaint" type="checkbox" class="hidden">
							<label for="is_complaint">f) Ada aduan diterima mengenai perjalanan Mesyuarat Agungn</label>
						</div>
					</label>
				</div> 

				<div class="form-group row">
					<label class="col-md-4 control-label">g) Nyatakan tarikh Mesyuarat Agung terakhir </label>
					<div class="col-md-8">
						<div id="datepicker-component" class="input-group date p-l-0">
		                    <input type="text" class="form-control" name="last_meeting_at" value="{{ $enforcement->pbp2->last_meeting_at ? date('d/m/Y', strtotime($enforcement->pbp2->last_meeting_at)) : '' }}" >
		                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
		                </div>
					</div>
				</div>

				<div class="form-group row">
					<label for="checklist38" class="col-md-4 control-label">h) Nyatakan penggal</label>
					<div class="col-md-8">
						<div class="row">
							<input type="text" name="tenure_start" class="form-control col-md-5" placeholder="20XX" value="{{ $enforcement->pbp2->tenure_start }}">
							<span class="col-md-2 text-center">Hingga</span>
							<input type="text" name="tenure_end" class="form-control col-md-5" placeholder="20XX" value="{{ $enforcement->pbp2->tenure_end }}">
						</div>
					</div>
				</div>

				<div class="card card-transparent mt-3 mb-2">
					<div class="card-block p-t-0">
						<h5 class='m-t-5'><span class="semi-bold">::Pemilihan </span> Pegawai</h5> 
						<hr>
					</div>
				</div>

				<div class="form-group row">
					<label for="checklist37" class="col-md-4 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="0" id="checklist37" type="checkbox" class="hidden">
							<label for="checklist37">a) Pemilihan pegawai bagi penggal .............. diadakan mengikut tempoh seperti diperuntukkan di bawah Perlembagaan Kesatuan.
								<i style="cursor: help; color: #48B0F7;" class="fa fa-question-circle" data-html="true" data-toggle="tooltip" title="Sila semak Borang L &amp; U"></i>
							</label>
						</div>
					</label>
					<div class="col-md-8">
						<div class="row">
							<input type="text" name="tenure_officer_start" class="form-control col-md-5" placeholder="20XX" value="{{ $enforcement->pbp2->tenure_officer_start }}">
							<span class="col-md-2 text-center">Hingga</span>
							<input type="text" name="tenure_officer_end" class="form-control col-md-5" placeholder="20XX" value="{{ $enforcement->pbp2->tenure_officer_end }}">
						</div>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-md-4 control-label">
						Tempoh pemilihan
						<i style="cursor: help; color: #48B0F7;" class="fa fa-question-circle" data-html="true" data-toggle="tooltip" title="Sila semak dengan Minit Mesyuarat"></i>	
					</label>
					<div class="col-md-8">
						Rujuk 4.1(a)
					</div>
				</div>

				<div class="form-group row">
					<label class="col-md-4 control-label">Tarikh pemilihan terakhir</label>
					<div class="col-md-8">
						<div id="datepicker-component" class="input-group date p-l-0">
		                    <input type="text" class="form-control" name="last_election_at" value="{{ $enforcement->pbp2->last_election_at ? date('d/m/Y', strtotime($enforcement->pbp2->last_election_at)) : '' }}" >
		                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
		                </div>
					</div>
				</div>


				<div class="form-group row">
					<label for="checklist38" class="col-md-4 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="0" id="checklist38" type="checkbox" class="hidden">
							<label for="checklist38">Notis pertukaran pegawai yang terkini telah dikemukakan
							</label>
						</div>
					</label>
					<div class="col-md-8">
						<div class="form-group row p-t-0">
							<label for="forml_at" class="col-md-4 control-label">Tarikh Borang L </label>
							<div class="col-md-8">
								<div id="datepicker-component" class="input-group date p-l-0">
				                    <input type="text" class="form-control" name="forml_at" value="{{ $enforcement->pbp2->forml_at ? date('d/m/Y', strtotime($enforcement->pbp2->forml_at)) : '' }}" >
				                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				                </div>
							</div>
						</div>
						<div class="form-group row p-t-0">
							<label for="submitted_at" class="col-md-4 control-label">Tarikh Serahan </label>
							<div class="col-md-8">
								<div id="datepicker-component" class="input-group date p-l-0">
				                    <input type="text" class="form-control" name="submitted_at" value="{{ $enforcement->pbp2->submitted_at ? date('d/m/Y', strtotime($enforcement->pbp2->submitted_at)) : '' }}" >
				                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				                </div>
							</div>
						</div>
					</div>
				</div>

				@include('enforcement.pbp2.notice.index')
				
				<div class="form-group row">
					<label for="checklist40" class="col-md-4 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="1" id="checklist40" type="checkbox" class="hidden">
							<label for="checklist40">Pengecualian penjawat awam Kumpulan Pengurusan dan Profesional (P&amp;P) menganggotai Kesatuan Sekerja oleh KSN dibawah seksyen 27 Akta Kesatuan Sekerja 1959
							</label>
						</div>
					</label>
					<div class="col-md-8">
						Jika ya, isi Tarikh Pengecualian
						<div id="datepicker-component" class="input-group date p-l-0">
		                    <input type="text" class="form-control" name="exception_civil_at" value="{{ $enforcement->pbp2->exception_civil_at ? date('d/m/Y', strtotime($enforcement->pbp2->exception_civil_at)) : '' }}" >
		                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
		                </div>
					</div>
				</div>

				<div class="form-group row">
					<label for="checklist41" class="col-md-4 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="0" id="checklist41" type="checkbox" class="hidden">
							<label for="checklist41">Pengecualian Menteri dibawah seksyen 30 Akta Kesatuan Sekerja 1959
							</label>
						</div>
					</label>
					<div class="col-md-8">
						Jika ya, isi Tarikh Pengecualian
						<div id="datepicker-component" class="input-group date p-l-0">
		                    <input type="text" class="form-control" name="exception_minister_at" value="{{ $enforcement->pbp2->exception_minister_at ? date('d/m/Y', strtotime($enforcement->pbp2->exception_minister_at)) : ''}}" >
		                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
		                </div>
					</div>
				</div>

				<div class="card card-transparent mt-3 mb-2">
					<div class="card-block p-t-0">
						<h5 class='m-t-5'><span class="semi-bold">:: Perubahan</span> Pegawai</h5> 
						<hr>
					</div>
				</div>

				<div class="form-group row">
					<label for="is_officer_changed" class="col-md-12 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="{{ $enforcement->pbp2->is_officer_changed }}" name="is_officer_changed" id="is_officer_changed" type="checkbox" class="hidden">
							<label for="is_officer_changed">Ada perubahan pegawai selepas pemilihan terakhir
							</label>
						</div>
					</label>
				</div>

				<div class="form-group row">
					<label for="is_changes_approved" class="col-md-12 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="{{ $enforcement->pbp2->is_changes_approved }}" name="is_changes_approved" id="is_changes_approved" type="checkbox" class="hidden">
							<label for="is_changes_approved">Lulus dalam mesyuarat
							</label>
						</div>
					</label>
				</div>

				<div class="form-group row">
					<label for="is_notice_submitted" class="col-md-12 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="{{ $enforcement->pbp2->is_notice_submitted }}" name="is_notice_submitted" id="is_notice_submitted" type="checkbox" class="hidden">
							<label for="is_notice_submitted">Notis perubahan telah dikemukakan ke Jabatan
							</label>
						</div>
					</label>
				</div>

				<div class="card card-transparent mt-3 mb-2">
					<div class="card-block p-t-0">
						<h5 class='m-t-5'><span class="semi-bold">:: Perubahan</span> Pekerja</h5> 
						<hr>
					</div>
				</div>

				<div class="form-group row">
					<label for="is_worker_appointed" class="col-md-12 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="{{ $enforcement->pbp2->is_worker_appointed }}" name="is_worker_appointed" id="is_worker_appointed" type="checkbox" class="hidden">
							<label for="is_worker_appointed">Perlantikan pekerja mengikut Perlembagaan Kesatuan 
							</label>
						</div>
					</label>
				</div>

				<div class="form-group row">
					<label for="is_appointment_approved" class="col-md-12 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="{{ $enforcement->pbp2->is_appointment_approved }}" name="is_appointment_approved" id="is_appointment_approved" type="checkbox" class="hidden">
							<label for="is_appointment_approved">Perlantikan pekerja diluluskan dalam mesyuarat
							</label>
						</div>
					</label>
				</div>

				<div class="form-group row">
					<label for="is_worker_changes" class="col-md-12 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="{{ $enforcement->pbp2->is_worker_changes }}" name="is_worker_changes" id="is_worker_changes" type="checkbox" class="hidden">
							<label for="is_worker_changes">Ada perubahan pekerja 
							</label>
						</div>
					</label>
				</div>

				<div class="form-group row">
					<label for="is_worker_notice_submitted" class="col-md-12 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="{{ $enforcement->pbp2->is_worker_notice_submitted }}" name="is_worker_notice_submitted" id="is_worker_notice_submitted" type="checkbox" class="hidden">
							<label for="is_worker_notice_submitted">Notis perubahan pekerja telah dikemukakan ke Jabatan
							</label>
						</div>
					</label>
				</div>

				<div class="card card-transparent mt-3 mb-2">
					<div class="card-block p-t-0">
						<h5 class='m-t-5'><span class="semi-bold">:: Mesyuarat</span> Jawatankuasa Kerja</h5> 
						<hr>
					</div>
				</div>

				<div class="form-group row">
					<label for="is_committee_meeting" class="col-md-12 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="{{ $enforcement->pbp2->is_committee_meeting }}" name="is_committee_meeting" id="is_committee_meeting" type="checkbox" class="hidden">
							<label for="is_committee_meeting">Mesyuarat dijalankan mengikut Perlembagaan Kesatuan
							</label>
						</div>
					</label>
				</div>

				<div class="form-group row">
					<label for="is_committee_verified" class="col-md-12 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="{{ $enforcement->pbp2->is_committee_verified }}" name="is_committee_verified" id="is_committee_verified" type="checkbox" class="hidden">
							<label for="is_committee_verified">Minit mesyuarat terakhir telah disediakan dan disemak
							</label>
						</div>
					</label>
				</div>

				<div class="form-group row">
					<label for="is_committee_enough" class="col-md-12 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="{{ $enforcement->pbp2->is_committee_enough }}" name="is_committee_enough" id="is_committee_enough" type="checkbox" class="hidden">
							<label for="is_committee_enough">Cukup korum
							</label>
						</div>
					</label>
				</div>

				<div class="form-group row">
					<label for="checklist42" class="col-md-4 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="1" id="checklist42" type="checkbox" class="hidden">
							<label for="checklist42">Tarikh mesyuarat terakhir diadakan</label>
						</div>
					</label>
					<div class="col-md-8">
						<div id="datepicker-component" class="input-group date p-l-0">
		                    <input type="text" class="form-control" name="last_committee_at" value="{{ $enforcement->pbp2->last_committee_at ? date('d/m/Y', strtotime($enforcement->pbp2->last_committee_at)) : '' }}" >
		                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
		                </div>
					</div>
				</div>

				@include('enforcement.pbp2.meeting.index')

				<div class="card card-transparent mt-3 mb-2">
					<div class="card-block p-t-0">
						<h5 class='m-t-5'><span class="semi-bold">:: Pemeriksa</span> Undi Kesatuan</h5> 
						<hr>
					</div>
				</div>

				<div class="form-group row">
					<label for="total_examiner" class="col-md-4 control-label">Bilangan pemeriksa undi dilantik pada penggal semasa</label>
					<div class="col-md-8">
						<input type="text" name="total_examiner" value="{{ $enforcement->pbp2->total_examiner }}" class="form-control numeric">
					</div>
				</div>

				<div class="form-group row">
					<label for="checklist44" class="col-md-12 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="0" id="checklist44" type="checkbox" class="hidden">
							<label for="checklist44">Nama pemeriksa undi seperti dinyatakan dalam 

								<a id="" href="{{ route('pbp2.d1', $enforcement->id) }}" target="_blank" class="btn btn-primary btn-cons text-capitalize btn-sm"><i class="fa fa-plus m-r-5"></i> Lampiran D1</a>
							</label>
						</div>
					</label>
				</div>

				<div class="card card-transparent mt-3 mb-2">
					<div class="card-block p-t-0">
						<h5 class='m-t-5'><span class="semi-bold">:: Pemegang</span> Amanah Kesatuan</h5> 
						<hr>
					</div>
				</div>

				<div class="form-group row">
					<label for="checklist44" class="col-md-12 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="{{ $enforcement->pbp2->is_d1_obey }}" name="is_d1_obey" id="is_d1_obey" type="checkbox" class="hidden">
							<label for="checklist44">Pelantikan pemegang amanah adalah selaras dengan seksyen 43 Akta Kesatuan Sekerja 1959 dan  Perlembagaan Kesatuan seperti dinyatakan dalam <span class="bold">Lampiran D1</span>								
							</label>
						</div>
					</label>
				</div>

				<div class="card card-transparent mt-3 mb-2">
					<div class="card-block p-t-0">
						<h5 class='m-t-5'><span class="semi-bold">:: Penimbangtara</span> Kesatuan</h5> 
						<hr>
					</div>
				</div>

				<div class="form-group row">
					<label for="is_arbitrator_appointed" class="col-md-12 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="{{ $enforcement->pbp2->is_arbitrator_appointed }}" name="is_arbitrator_appointed" id="is_arbitrator_appointed" type="checkbox" class="hidden">
							<label for="is_arbitrator_appointed">Bilangan penimbangtara yang dilantik adalah mengikut Perlembagaan Kesatuan seperti dinyatakan dalam <span class="bold">Lampiran D1</span>
							</label>
						</div>
					</label>
				</div>

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
	$('#form-tab5').validate();

	$("#meeting_duration{{ $enforcement->pbp2->meeting_duration_id }}").prop('checked', true).trigger('change');

	@if($enforcement->pbp2->meeting_duration_id)
		$("#checklist36").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->is_agenda_meeting == 1)
		$("#is_agenda_meeting").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->is_enough_corum == 1)
		$("#is_enough_corum").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->is_minutes_prepared == 1)
		$("#is_minutes_prepared").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->is_ammendment_approved == 1)
		$("#is_ammendment_approved").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->is_complaint == 1)
		$("#is_complaint").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->tenure_officer_start || $enforcement->pbp2->tenure_officer_end)
		$("#checklist37").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->forml_at || $enforcement->pbp2->submitted_at)
		$("#checklist38").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->notices->count() != 0)
		$("#checklist39").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->exception_civil_at)
		$("#checklist40").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->exception_minister_at)
		$("#checklist41").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->is_officer_changed == 1)
		$("#is_officer_changed").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->is_changes_approved == 1)
		$("#is_changes_approved").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->is_notice_submitted == 1)
		$("#is_notice_submitted").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->is_worker_appointed == 1)
		$("#is_worker_appointed").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->is_appointment_approved == 1)
		$("#is_appointment_approved").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->is_worker_changes == 1)
		$("#is_worker_changes").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->is_worker_notice_submitted == 1)
		$("#is_worker_notice_submitted").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->is_committee_meeting == 1)
		$("#is_committee_meeting").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->is_committee_verified == 1)
		$("#is_committee_verified").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->is_committee_enough == 1)
		$("#is_committee_enough").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->last_committee_at)
		$("#checklist42").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->meetings->count() != 0)
		$("#checklist43").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->d1->count() != 0)
		$("#checklist44").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->is_d1_obey == 1)
		$("#is_d1_obey").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->is_arbitrator_appointed == 1)
		$("#is_arbitrator_appointed").prop('checked', true).trigger('change');
	@endif
</script>
@endpush