<!-- START CONTAINER FLUID -->
<div class=" container-fluid container-fixed-lg bg-white">
	<!-- START card -->
	<div class="card card-transparent">
		<div class="card-block">
			<div class="col-md-12 text-center p-t-20">
				<span class="bold">PENYATA TAHUNAN YANG DITETAPKAN DI BAWAH SEKSYEN 56(1) AKTA KESATUAN SEKERJA DAN PERATURAN 28 <br>BAGI TAHUN BERAKHIR 31 HB MAC</span>
			</div>
			<form id="form-tab1" class="form-horizontal" role="form" autocomplete="off" method="post" action="#">

				<div class="form-group row">
					<label for="" class="col-md-3 control-label">
						Tahun <span style="color:red;">*</span>
					</label>
					<div class="col-md-9">
						<select class="full-width" data-init-plugin="select2" name="year" id="year">
							<option selected disabled hidden>Sila pilih..</option>
							@foreach(range(date('Y'), 2005) as $year)
							<option id="year_{{ $year }}" value="{{ $year }}">{{ $year }}</option>
							@endforeach
						</select>
					</div>
				</div>

				@component('components.bs.label', [
                    'name' => 'name',
                    'label' => 'Nama Kesatuan Sekerja',
                ])
                {{ $statement->tenure->entity->name }}
                @endcomponent

                <div class="form-group row">
					<label class="col-md-3 control-label">
						Alamat Ibu Pejabat
					</label>
					<div class="col-md-9">
						{!! $statement->address->address1.
                        ($statement->address->address2 ? ',<br>'.$statement->address->address2 : '').
                        ($statement->address->address3 ? ',<br>'.$statement->address->address3 : '').
                        ',<br>'.
                        $statement->address->postcode.' '.
                        ($statement->address->district ? $statement->address->district->name : '').', '.
                        ($statement->address->state ? $statement->address->state->name : '') !!}
					</div>
				</div>

				@include('components.bs.input', [
					'name' => 'certification_no',
					'label' => 'No. Perakuan Pendaftaran',
					'value' => $statement->certification_no,
					'mode' => 'required'
				])

				@include('components.bs.input', [
					'name' => 'total_member_start',
					'label' => 'Bilangan anggota-anggota dalam buku pada awal tahun',
					'mode' => 'required',
					'value' => $statement->total_member_start,
					'class' => 'numeric',
				])

				@include('components.bs.input', [
					'name' => 'total_member_accepted',
					'label' => 'Bilangan anggota-anggota yang diterima masuk sepanjang tahun',
					'mode' => 'required',
					'value' => $statement->total_member_accepted,
					'class' => 'numeric',
				])

				@include('components.bs.input', [
					'name' => 'total_member_leave',
					'label' => 'Bilangan anggota-anggota yang keluar sepanjang tahun (termasuk kematian)',
					'mode' => 'required',
					'value' => $statement->total_member_leave,
					'class' => 'numeric',
				])

				@include('components.bs.input', [
					'name' => 'total_member_end',
					'label' => 'Jumlah bilangan anggota-anggota dalam buku pada akhir tahun',
					'mode' => 'required',
					'value' => $statement->total_member_end,
					'class' => 'numeric',
				])

				@include('components.bs.input', [
					'name' => 'total_male',
					'label' => 'Bilangan anggota-anggota lelaki',
					'mode' => 'required',
					'info' => 'Bilangan anggota-anggota dalam buku pada akhir tahun',
					'value' => $statement->total_male,
					'class' => 'numeric',
				])

				@include('components.bs.input', [
					'name' => 'total_female',
					'label' => 'Bilangan anggota-anggota perempuan',
					'mode' => 'required',
					'info' => 'Bilangan anggota-anggota dalam buku pada akhir tahun',
					'value' => $statement->total_female,
					'class' => 'numeric',
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
						<li>
							<button type="button" class="btn btn-default mr-1" onclick="location.href='{{ route('statement.ks.form', $statement->id) }}'"><i class="fa fa-angle-left mr-1"></i> Kembali</button>
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
	$('#form-tab1').validate();

	$("#year_{{ $statement->year }}").prop('selected', true).trigger('change');
</script>
@endpush