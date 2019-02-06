@extends('layouts.app')
@include('plugins.datepicker')

@section('content')
@include('components.msg-disconnected')
<!-- START BREADCRUMB -->
<div class="jumbotron" data-pages="parallax">
	<div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
		<div class="inner" style="transform: translateY(0px); opacity: 1;">
			{{ Breadcrumbs::render('enforcement.pbp2') }}
			<!-- END BREADCRUMB -->
			<div class="row">
				<div class="col-xl-12 col-lg-12 ">
					<!-- START card -->
					<div class="card card-transparent">
						<div class="card-block p-t-0">
							<h3 class='m-t-0'>Kesatuan Induk Bercawangan</h3>
							<p class="small hint-text m-t-5">
								Lampiran A5(i)
							</p>
						</div>
					</div>
					<!-- END card -->
				</div>
			</div>
		</div>
	</div>
</div>
<!-- END BREADCRUMB -->
<!-- END JUMBOTRON -->
@include('components.msg-connecting')
<!-- START CONTAINER FLUID -->
<!-- START CONTAINER FLUID -->
<div class=" container-fluid container-fixed-lg bg-white">
	<!-- START card -->
	<div class="card card-transparent">
		<div class="card-block">
			<div class="form-horizontal" role="form" autocomplete="off" method="post" action="#">
        		@component('components.bs.label', [
					'label' => 'Nama Kesatuan Cawangan',
				])
				<div class="m-t-5">
					<span class="bold">{{ $a5->branch ? $a5->branch->name : $a5->enforcement->entity->name }}</span>
				</div>
				@endcomponent

				<div class="form-group row">
					<label for="fname" class="col-md-12 control-label p-l-20 bold" style="background-color: #E6E6E6"> :: Kedudukan Keahlian</label>
				</div>

				@include('components.bs.date', [
					'name' => 'membership_at',
					'label' => 'Pada',
					'mode' => 'required',
					'value' => $a5->membership_at ? date('d/m/Y', strtotime($a5->membership_at)) : date('d/m/Y')
				])

				<div class="form-group row p-r-0">
					<label for="fname" class="col-md-3 control-label">Berdafftar</label>
					<div class="row col-md-9">
						<div class="input-group col-md-6">
	                      	<span class="input-group-addon default">
	                          	Lelaki
	                      	</span>
							<input type="text" name="total_registered_male" value="{{ $a5->total_registered_male }}" class="form-control">
						</div>
						<div class="input-group col-md-6">
	                      	<span class="input-group-addon default">
	                          	Perempuan
	                      	</span>
							<input type="text" name="total_registered_female" value="{{ $a5->total_registered_female }}" class="form-control">
						</div>
					</div>
				</div>

				<div class="form-group row p-r-0">
					<label for="fname" class="col-md-3 control-label">Berhak</label>
					<div class="row col-md-9">
						<div class="input-group col-md-6">
	                      	<span class="input-group-addon default">
	                          	Lelaki
	                      	</span>
							<input type="text" name="total_rightful_male" value="{{ $a5->total_rightful_male }}" class="form-control">
						</div>
						<div class="input-group col-md-6">
	                      	<span class="input-group-addon default">
	                          	Perempuan
	                      	</span>
							<input type="text" name="total_rightful_female" value="{{ $a5->total_rightful_female }}" class="form-control">
						</div>
					</div>
				</div>

				<div class="form-group row">
					<label for="fname" class="col-md-12 control-label p-l-20 bold" style="background-color: #E6E6E6"> :: Kedudukan Ahli Jawatankuasa Cawangan</label>
				</div>

				<div class="form-group row p-r-0">
					<label for="fname" class="col-md-3 control-label">Pengerusi</label>
					<div class="row col-md-9">
						<div class="input-group col-md-6">
	                      	<span class="input-group-addon default">
	                          	Lelaki
	                      	</span>
							<input type="text" name="total_chairman_male" value="{{ $a5->total_chairman_male }}" class="form-control">
						</div>
						<div class="input-group col-md-6">
	                      	<span class="input-group-addon default">
	                          	Perempuan
	                      	</span>
							<input type="text" name="total_chairman_female" value="{{ $a5->total_chairman_female }}" class="form-control">
						</div>
					</div>
				</div>

				<div class="form-group row p-r-0">
					<label for="fname" class="col-md-3 control-label">Naib Pengerusi</label>
					<div class="row col-md-9">
						<div class="input-group col-md-6">
	                      	<span class="input-group-addon default">
	                          	Lelaki
	                      	</span>
							<input type="text" name="total_vice_chairman_male" value="{{ $a5->total_vice_chairman_male }}" class="form-control">
						</div>
						<div class="input-group col-md-6">
	                      	<span class="input-group-addon default">
	                          	Perempuan
	                      	</span>
							<input type="text" name="total_vice_chaiRman_female" value="{{ $a5->total_vice_chairman_female }}" class="form-control">
						</div>
					</div>
				</div>

				<div class="form-group row p-r-0">
					<label for="fname" class="col-md-3 control-label">Setiausaha</label>
					<div class="row col-md-9">
						<div class="input-group col-md-6">
	                      	<span class="input-group-addon default">
	                          	Lelaki
	                      	</span>
							<input type="text" name="total_secretary_male" value="{{ $a5->total_secretary_male }}" class="form-control">
						</div>
						<div class="input-group col-md-6">
	                      	<span class="input-group-addon default">
	                          	Perempuan
	                      	</span>
							<input type="text" name="total_secretary_female" value="{{ $a5->total_secretary_female }}" class="form-control">
						</div>
					</div>
				</div>

				<div class="form-group row p-r-0">
					<label for="fname" class="col-md-3 control-label">Penolong Setiausaha</label>
					<div class="row col-md-9">
						<div class="input-group col-md-6">
	                      	<span class="input-group-addon default">
	                          	Lelaki
	                      	</span>
							<input type="text" name="total_asst_secretary_male" value="{{ $a5->total_asst_secretary_male }}" class="form-control">
						</div>
						<div class="input-group col-md-6">
	                      	<span class="input-group-addon default">
	                          	Perempuan
	                      	</span>
							<input type="text" name="total_asst_secretary_female" value="{{ $a5->total_asst_secretary_female }}" class="form-control">
						</div>
					</div>
				</div>

				<div class="form-group row p-r-0">
					<label for="fname" class="col-md-3 control-label">Bendahari</label>
					<div class="row col-md-9">
						<div class="input-group col-md-6">
	                      	<span class="input-group-addon default">
	                          	Lelaki
	                      	</span>
							<input type="text" name="total_treasurer_male" value="{{ $a5->total_treasurer_male }}" class="form-control">
						</div>
						<div class="input-group col-md-6">
	                      	<span class="input-group-addon default">
	                          	Perempuan
	                      	</span>
							<input type="text" name="total_treasurer_female" value="{{ $a5->total_treasurer_female }}" class="form-control">
						</div>
					</div>
				</div>

				<div class="form-group row p-r-0">
					<label for="fname" class="col-md-3 control-label">Ahli Jawatankuasa</label>
					<div class="row col-md-9">
						<div class="input-group col-md-6">
	                      	<span class="input-group-addon default">
	                          	Lelaki
	                      	</span>
							<input type="text" name="total_committee_male" value="{{ $a5->total_committee_male }}" class="form-control">
						</div>
						<div class="input-group col-md-6">
	                      	<span class="input-group-addon default">
	                          	Perempuan
	                      	</span>
							<input type="text" name="total_committee_female" value="{{ $a5->total_committee_female }}" class="form-control">
						</div>
					</div>
				</div>

				<div class="form-group row">
					<label for="fname" class="col-md-12 control-label p-l-20 bold" style="background-color: #E6E6E6"> :: Bilangan Keahlian mengikut Kaum dan Jantina</label>
				</div>

				<div class="form-group row p-r-0">
					<label for="fname" class="col-md-3 control-label">Melayu</label>
					<div class="row col-md-9">
						<div class="input-group col-md-6">
	                      	<span class="input-group-addon default">
	                          	Lelaki
	                      	</span>
							<input type="text" name="total_race_malay_male" value="{{ $a5->total_race_malay_male }}" class="form-control">
						</div>
						<div class="input-group col-md-6">
	                      	<span class="input-group-addon default">
	                          	Perempuan
	                      	</span>
							<input type="text" name="total_race_malay_female" value="{{ $a5->total_race_malay_female }}" class="form-control">
						</div>
					</div>
				</div>

				<div class="form-group row p-r-0">
					<label for="fname" class="col-md-3 control-label">Cina</label>
					<div class="row col-md-9">
						<div class="input-group col-md-6">
	                      	<span class="input-group-addon default">
	                          	Lelaki
	                      	</span>
							<input type="text" name="total_race_chinese_male" value="{{ $a5->total_race_chinese_male }}" class="form-control">
						</div>
						<div class="input-group col-md-6">
	                      	<span class="input-group-addon default">
	                          	Perempuan
	                      	</span>
							<input type="text" name="total_race_chinese_female" value="{{ $a5->total_race_chinese_female }}" class="form-control">
						</div>
					</div>
				</div>

				<div class="form-group row p-r-0">
					<label for="fname" class="col-md-3 control-label">India</label>
					<div class="row col-md-9">
						<div class="input-group col-md-6">
	                      	<span class="input-group-addon default">
	                          	Lelaki
	                      	</span>
							<input type="text" name="total_race_indian_male" value="{{ $a5->total_race_indian_male}}" class="form-control">
						</div>
						<div class="input-group col-md-6">
	                      	<span class="input-group-addon default">
	                          	Perempuan
	                      	</span>
							<input type="text" name="total_race_indian_female" value="{{ $a5->total_race_indian_female}}" class="form-control">
						</div>
					</div>
				</div>

				<div class="form-group row p-r-0">
					<label for="fname" class="col-md-3 control-label">Bumiputera (Sabah/Sarawak)</label>
					<div class="row col-md-9">
						<div class="input-group col-md-6">
	                      	<span class="input-group-addon default">
	                          	Lelaki
	                      	</span>
							<input type="text" name="total_race_bumiputera_male" value="{{ $a5->total_race_bumiputera_male }}" class="form-control">
						</div>
						<div class="input-group col-md-6">
	                      	<span class="input-group-addon default">
	                          	Perempuan
	                      	</span>
							<input type="text" name="total_race_bumiputera_female" value="{{ $a5->total_race_bumiputera_female }}" class="form-control">
						</div>
					</div>
				</div>

				<div class="form-group row p-r-0">
					<label for="fname" class="col-md-3 control-label">Lain-lain</label>
					<div class="row col-md-9">
						<div class="input-group col-md-6">
	                      	<span class="input-group-addon default">
	                          	Lelaki
	                      	</span>
							<input type="text" name="total_race_others_male" value="{{ $a5->total_race_others_male }}" class="form-control">
						</div>
						<div class="input-group col-md-6">
	                      	<span class="input-group-addon default">
	                          	Perempuan
	                      	</span>
							<input type="text" name="total_race_others_female" value="{{ $a5->total_race_others_female }}" class="form-control">
						</div>
					</div>
				</div>

				<div class="form-group row">
					<label for="fname" class="col-md-12 control-label p-l-20 bold" style="background-color: #E6E6E6"> :: Bilangan Keahlian Bersekutu</label>
				</div>

				<div class="form-group row p-r-0">
					<label for="fname" class="col-md-3 control-label">Melayu</label>
					<div class="row col-md-9">
						<div class="input-group col-md-6">
	                      	<span class="input-group-addon default">
	                          	Lelaki
	                      	</span>
							<input type="text" name="total_allied_malay_male" value="{{ $a5->total_allied_malay_male }}" class="form-control">
						</div>
						<div class="input-group col-md-6">
	                      	<span class="input-group-addon default">
	                          	Perempuan
	                      	</span>
							<input type="text" name="total_allied_malay_female" value="{{ $a5->total_allied_malay_female }}" class="form-control">
						</div>
					</div>
				</div>

				<div class="form-group row p-r-0">
					<label for="fname" class="col-md-3 control-label">Cina</label>
					<div class="row col-md-9">
						<div class="input-group col-md-6">
	                      	<span class="input-group-addon default">
	                          	Lelaki
	                      	</span>
							<input type="text" name="total_allied_chinese_male" value="{{ $a5->total_allied_chinese_male }}" class="form-control">
						</div>
						<div class="input-group col-md-6">
	                      	<span class="input-group-addon default">
	                          	Perempuan
	                      	</span>
							<input type="text" name="total_allied_chinese_female" value="{{ $a5->total_allied_chinese_female }}" class="form-control">
						</div>
					</div>
				</div>

				<div class="form-group row p-r-0">
					<label for="fname" class="col-md-3 control-label">India</label>
					<div class="row col-md-9">
						<div class="input-group col-md-6">
	                      	<span class="input-group-addon default">
	                          	Lelaki
	                      	</span>
							<input type="text" name="total_allied_indian_male" value="{{ $a5->total_allied_indian_male }}" class="form-control">
						</div>
						<div class="input-group col-md-6">
	                      	<span class="input-group-addon default">
	                          	Perempuan
	                      	</span>
							<input type="text" name="total_allied_indian_female" value="{{ $a5->total_allied_indian_female }}" class="form-control">
						</div>
					</div>
				</div>

				<div class="form-group row p-r-0">
					<label for="fname" class="col-md-3 control-label">Bumiputera (Sabah/Sarawak)</label>
					<div class="row col-md-9">
						<div class="input-group col-md-6">
	                      	<span class="input-group-addon default">
	                          	Lelaki
	                      	</span>
							<input type="text" name="total_allied_bumiputera_male" value="{{ $a5->total_allied_bumiputera_male }}" class="form-control">
						</div>
						<div class="input-group col-md-6">
	                      	<span class="input-group-addon default">
	                          	Perempuan
	                      	</span>
							<input type="text" name="total_allied_bumiputera_female" value="{{ $a5->total_allied_bumiputera_female }}" class="form-control">
						</div>
					</div>
				</div>

				<div class="form-group row p-r-0">
					<label for="fname" class="col-md-3 control-label">Lain-lain</label>
					<div class="row col-md-9">
						<div class="input-group col-md-6">
	                      	<span class="input-group-addon default">
	                          	Lelaki
	                      	</span>
							<input type="text" name="total_allied_others_female" value="{{ $a5->total_allied_others_female }}" class="form-control">
						</div>
						<div class="input-group col-md-6">
	                      	<span class="input-group-addon default">
	                          	Perempuan
	                      	</span>
							<input type="text" name="total_allied_others_female" value="{{ $a5->total_allied_others_female }}" class="form-control">
						</div>
					</div>
				</div>

				<div class="form-group row">
					<label for="fname" class="col-md-12 control-label p-l-20 bold" style="background-color: #E6E6E6"> :: Bilangan ahli pekerja asing pada tarikh pemeriksaan dijalankan</label>
				</div>

				<div class="form-group row p-r-0">
					<label for="fname" class="col-md-3 control-label">Indonesia</label>
					<div class="row col-md-9">
						<div class="input-group col-md-6">
	                      	<span class="input-group-addon default">
	                          	Lelaki
	                      	</span>
							<input type="text" name="total_indonesian_male" value="{{ $a5->total_indonesian_male }}" class="form-control">
						</div>
						<div class="input-group col-md-6">
	                      	<span class="input-group-addon default">
	                          	Perempuan
	                      	</span>
							<input type="text" name="total_indonesian_female" value="{{ $a5->total_indonesian_female }}" class="form-control">
						</div>
					</div>
				</div>

				<div class="form-group row p-r-0">
					<label for="fname" class="col-md-3 control-label">Vietnam</label>
					<div class="row col-md-9">
						<div class="input-group col-md-6">
	                      	<span class="input-group-addon default">
	                          	Lelaki
	                      	</span>
							<input type="text" name="total_vietnamese_male" value="{{ $a5->total_viatnamese_male }}" class="form-control">
						</div>
						<div class="input-group col-md-6">
	                      	<span class="input-group-addon default">
	                          	Perempuan
	                      	</span>
							<input type="text" name="total_vietnamese_female" value="{{ $a5->total_viatnamese_female }}" class="form-control">
						</div>
					</div>
				</div>

				<div class="form-group row p-r-0">
					<label for="fname" class="col-md-3 control-label">Filipina</label>
					<div class="row col-md-9">
						<div class="input-group col-md-6">
	                      	<span class="input-group-addon default">
	                          	Lelaki
	                      	</span>
							<input type="text" name="total_philiphine_male" value="{{ $a5->total_philippines_male }}" class="form-control">
						</div>
						<div class="input-group col-md-6">
	                      	<span class="input-group-addon default">
	                          	Perempuan
	                      	</span>
							<input type="text" name="total_philiphine_female" value="{{ $a5->total_philippines_female }}" class="form-control">
						</div>
					</div>
				</div>

				<div class="form-group row p-r-0">
					<label for="fname" class="col-md-3 control-label">Myanmar</label>
					<div class="row col-md-9">
						<div class="input-group col-md-6">
	                      	<span class="input-group-addon default">
	                          	Lelaki
	                      	</span>
							<input type="text" name="total_mynmar_male" value="{{ $a5->total_myanmar_male }}" class="form-control">
						</div>
						<div class="input-group col-md-6">
	                      	<span class="input-group-addon default">
	                          	Perempuan
	                      	</span>
							<input type="text" name="total_mynmar_female" value="{{ $a5->total_myanmar_female }}" class="form-control">
						</div>
					</div>
				</div>

				<div class="form-group row p-r-0">
					<label for="fname" class="col-md-3 control-label">Kemboja</label>
					<div class="row col-md-9">
						<div class="input-group col-md-6">
	                      	<span class="input-group-addon default">
	                          	Lelaki
	                      	</span>
							<input type="text" name="total_kemboja_male" value="{{ $a5->total_cambodia_male }}" class="form-control">
						</div>
						<div class="input-group col-md-6">
	                      	<span class="input-group-addon default">
	                          	Perempuan
	                      	</span>
							<input type="text" name="total_kemboja_female" value="{{ $a5->total_cambodia_female }}" class="form-control">
						</div>
					</div>
				</div>

				<div class="form-group row p-r-0">
					<label for="fname" class="col-md-3 control-label">Bangladesh</label>
					<div class="row col-md-9">
						<div class="input-group col-md-6">
	                      	<span class="input-group-addon default">
	                          	Lelaki
	                      	</span>
							<input type="text" name="total_bangladesh_male" value="{{ $a5->total_bangladesh_male }}" class="form-control">
						</div>
						<div class="input-group col-md-6">
	                      	<span class="input-group-addon default">
	                          	Perempuan
	                      	</span>
							<input type="text" name="total_bangladesh_female" value="{{ $a5->total_bangladesh_female }}" class="form-control">
						</div>
					</div>
				</div>

				<div class="form-group row p-r-0">
					<label for="fname" class="col-md-3 control-label">India</label>
					<div class="row col-md-9">
						<div class="input-group col-md-6">
	                      	<span class="input-group-addon default">
	                          	Lelaki
	                      	</span>
							<input type="text" name="total_india_male" value="{{ $a5->total_india_male }}" class="form-control">
						</div>
						<div class="input-group col-md-6">
	                      	<span class="input-group-addon default">
	                          	Perempuan
	                      	</span>
							<input type="text" name="total_india_female" value="{{ $a5->total_india_female }}" class="form-control">
						</div>
					</div>
				</div>

				<div class="form-group row p-r-0">
					<label for="fname" class="col-md-3 control-label">Nepal</label>
					<div class="row col-md-9">
						<div class="input-group col-md-6">
	                      	<span class="input-group-addon default">
	                          	Lelaki
	                      	</span>
							<input type="text" name="total_nepal_male" value="{{ $a5->total_nepal_male }}" class="form-control">
						</div>
						<div class="input-group col-md-6">
	                      	<span class="input-group-addon default">
	                          	Perempuan
	                      	</span>
							<input type="text" name="total_nepal_female" value="{{ $a5->total_nepal_female }}" class="form-control">
						</div>
					</div>
				</div>

				<div class="form-group row p-r-0">
					<label for="fname" class="col-md-3 control-label">Lain-lain Negara</label>
					<div class="row col-md-9">
						<div class="input-group col-md-6">
	                      	<span class="input-group-addon default">
	                          	Lelaki
	                      	</span>
							<input type="text" name="total_others_male" value="{{ $a5->total_others_male }}" class="form-control">
						</div>
						<div class="input-group col-md-6">
	                      	<span class="input-group-addon default">
	                          	Perempuan
	                      	</span>
							<input type="text" name="total_others_female" value="{{ $a5->total_others_female }}" class="form-control">
						</div>
					</div>
				</div>

				<br>

				<div class="form-group">
					<button type="button" class="btn btn-info pull-right" onclick="saveData()" data-dismiss="modal"><i class="fa fa-check mr-1"></i> Simpan</button>
				</div>

			</div>
    	</div>
    </div>
</div>

@endsection

@push('js')
<script type="text/javascript">
$(document).ready(function(){
	var socket = io('{{ env('SOCKET_HOST', '127.0.0.1') }}:{{ env('SOCKET_PORT', 3000) }}');

	socket.on('connect', function() {
	    $(".msg-disconnected").slideUp();
	    $(".msg-connecting").slideUp();
	});

	socket.on('disconnect', function() {
	    $(".msg-disconnected").slideDown();
	    $("html, body").animate({ scrollTop: 0 }, 500);
	});
	
	$('input, select, textarea').on('change', function() {
		socket.emit('enforcement_a5', {
			id: {{ $a5->id }},
        	name: $(this).attr('name'),
			value: $(this).attr('type') == 'checkbox' ? ($(this).prop('checked') ? 1 : 0) : $(this).val(),
			user: '{{ Cookie::get('api_token') }}'
		});
		console.log('changed');
	});
});
</script>
@endpush