<!-- START CONTAINER FLUID -->
<div class=" container-fluid container-fixed-lg bg-white">
	<!-- START card -->
	<div class="card card-transparent">
		<div class="card-block">
			<form id="form-tab3" class="form-horizontal" role="form" autocomplete="off" method="post" action="">
				<div class="row">
					<div class="col-md-12 text-center p-t-20">
						<span class="bold">(i) PENYATA PENERIMAAN DAN PEMBAYARAN</span>
					</div>
					<div class="col-md-5">
						<div class="form-group row">
							<label for="fname" class="col-md-8 control-label bold" style="background-color: #E6E6E6">Penerimaan</label>
							<div class="col-md-4 text-center" style="background-color: #E6E6E6; padding-top: 5px">RM sen</div>
						</div>
						
						<div class="form-group row">
							<label for="fname" class="col-md-8 control-label">Baki pada awal tahun</label>
							<div class="col-md-4 pull-right">
								<input class="form-control decimal" name="accept_balance_start" aria-required="true" type="text" value="{{ $statement->accept_balance_start }}" required>
							</div>
						</div>

						<div class="form-group row">
							<label for="fname" class="col-md-8 control-label">Yuran Masuk</label>
							<div class="col-md-4 pull-right">
								<input class="form-control decimal" name="accept_entrance_fee" aria-required="true" type="text" value="{{ $statement->accept_entrance_fee }}" required>
							</div>
						</div>
						
						<div class="form-group row">
							<label for="fname" class="col-md-8 control-label">Yuran Anggota</label>
							<div class="col-md-4 pull-right">
								<input class="form-control decimal" name="accept_membership_fee" aria-required="true" type="text" value="{{ $statement->accept_membership_fee }}" required>
							</div>
						</div>

						<div class="form-group row">
							<label for="fname" class="col-md-8 control-label">Derma-derma</label>
							<div class="col-md-4 pull-right">
								<input class="form-control decimal" name="accept_sponsorship" aria-required="true" type="text" value="{{ $statement->accept_sponsorship }}" required>
							</div>
						</div>

						<div class="form-group row">
							<label for="fname" class="col-md-8 control-label">Jualan majalah-majalan, buku-buku, kaedah-kaedah, dll</label>
							<div class="col-md-4 pull-right">
								<input class="form-control decimal" name="accept_sales" aria-required="true" type="text" value="{{ $statement->accept_sales }}" required>
							</div>
						</div>
						
						<div class="form-group row">
							<label for="fname" class="col-md-8 control-label">Bunga atas pelaburan</label>
							<div class="col-md-4 pull-right">
								<input class="form-control decimal" name="accept_interest" aria-required="true" type="text" value="{{ $statement->accept_interest }}" required>
							</div>
						</div>

						@include('finance.statement.ks.formn.salary.index')
						
					</div>

					<div class="col-md-1"></div>

					<div class="col-md-6">
						<div class="form-group row" >
							<label for="fname" class="col-md-8 control-label bold" style="background-color: #E6E6E6">Pembayaran</label>
							<div class="col-md-4 text-center" style="background-color: #E6E6E6; padding-top: 5px">RM sen</div>
						</div>
						<div class="form-group row">
							<label for="fname" class="col-md-8 control-label">Gaji, elaun-elaun dan perbelanjaan pegawai-pegawai</label>
							<div class="col-md-4 pull-right">
								<input class="form-control decimal" name="pay_officer_salary" aria-required="true" type="text" value="{{ $statement->pay_officer_salary }}" required>
							</div>
						</div>

						<div class="form-group row">
							<label for="fname" class="col-md-8 control-label">Gaji, elaun-elaun dan perbelanjaan pertubuhan.</label>
							<div class="col-md-4 pull-right">
								<input class="form-control decimal" name="pay_organization_salary" aria-required="true" type="text" value="{{ $statement->pay_organization_salary }}" required>
							</div>
						</div>
						
						<div class="form-group row">
							<label for="fname" class="col-md-8 control-label">Fee-fee auditor</label>
							<div class="col-md-4 pull-right">
								<input class="form-control decimal" name="pay_auditor_fee" aria-required="true" type="text" value="{{ $statement->pay_auditor_fee }}" required>
							</div>
						</div>

						<div class="form-group row">
							<label for="fname" class="col-md-8 control-label">Perbelanjaan guaman</label>
							<div class="col-md-4 pull-right">
								<input class="form-control decimal" name="pay_attorney_expenditure" aria-required="true" type="text" value="{{ $statement->pay_attorney_expenditure }}" required>
							</div>
						</div>

						<div class="form-group row">
							<label for="fname" class="col-md-8 control-label">Perbelanjaan dalam menjalankan pertikaian tred</label>
							<div class="col-md-4 pull-right">
								<input class="form-control decimal" name="pay_tred_expenditure" aria-required="true" type="text" value="{{ $statement->pay_tred_expenditure }}" required>
							</div>
						</div>
						
						<div class="form-group row">
							<label for="fname" class="col-md-8 control-label">Pampasan yang dibayar kepada ahli-ahli bagi kerugian yang berbangkit akibat pertikaian tred</label>
							<div class="col-md-4 pull-right">
								<input class="form-control decimal" name="pay_compensation" aria-required="true" type="text" value="{{ $statement->pay_compensation }}" required>
							</div>
						</div>

						<div class="form-group row">
							<label for="fname" class="col-md-8 control-label">Faedah-faedah pengkebumian, hari tua, kesakitan, faedah kerana tiada berkeperjaan, dll.</label>
							<div class="col-md-4 pull-right">
								<input class="form-control decimal" name="pay_sick_benefit" aria-required="true" type="text" value="{{ $statement->pay_sick_benefit }}" required>
							</div>
						</div>

						<div class="form-group row">
							<label for="fname" class="col-md-8 control-label">Faedah pelajaran, sosial dan keagamaan</label>
							<div class="col-md-4 pull-right">
								<input class="form-control decimal" name="pay_study_benefit" aria-required="true" type="text" value="{{ $statement->pay_study_benefit }}" required>
							</div>
						</div>

						<div class="form-group row">
							<label for="fname" class="col-md-8 control-label">Kos menerbitkan majalah-majalah</label>
							<div class="col-md-4 pull-right">
								<input class="form-control decimal" name="pay_publication_cost" aria-required="true" type="text" value="{{ $statement->pay_publication_cost }}" required>
							</div>
						</div>
						
						<div class="form-group row">
							<label for="fname" class="col-md-8 control-label">Sewaan, kadaran dan cukai-cukai</label>
							<div class="col-md-4 pull-right">
								<input class="form-control decimal" name="pay_rental" aria-required="true" type="text" value="{{ $statement->pay_rental }}" required>
							</div>
						</div>

						<div class="form-group row">
							<label for="fname" class="col-md-8 control-label">Alat tulis, cetakan dan bayaran pos</label>
							<div class="col-md-4 pull-right">
								<input class="form-control decimal" name="pay_stationary" aria-required="true" type="text" value="{{ $statement->pay_stationary }}" required>
							</div>
						</div>
						
						@include('finance.statement.ks.formn.expenditure.index')

						<div class="form-group row">
							<label for="fname" class="col-md-8 control-label">Baki pada tahun akhir</label>
							<div class="col-md-4 pull-right">
								<input class="form-control decimal" name="pay_balance_end" aria-required="true" type="text" value="{{ $statement->pay_balance_end }}">
							</div>
						</div>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-md-12 text-center p-t-20">
						<span class="bold">(ii) Penyata Aset-aset dan liabiliti-liabiliti pada <br>31HB MAC XXXX</span>
					</div>
					<div class="col-md-5">
						<div class="form-group row">
							<label for="fname" class="col-md-8 control-label bold" style="background-color: #E6E6E6">Liabiliti-liability</label>
							<div class="col-md-4 text-center" style="background-color: #E6E6E6; padding-top: 5px">RM sen</div>
						</div>
						
						<div class="form-group row">
							<label for="fname" class="col-md-8 control-label">Kumpulan Wang Am</label>
							<div class="col-md-4 pull-right">
								<input class="form-control decimal" name="liability_fund" aria-required="true" type="text" value="{{ $statement->liability_fund }}" required>
							</div>
						</div>

						@include('finance.statement.ks.formn.loan.index')

						@include('finance.statement.ks.formn.debt.index')

						@include('finance.statement.ks.formn.liability.index')

					</div>

					<div class="col-md-1"></div>

					<div class="col-md-6">
						<div class="form-group row" >
							<label for="fname" class="col-md-8 control-label bold" style="background-color: #E6E6E6">Aset-aset</label>
							<div class="col-md-4 text-center" style="background-color: #E6E6E6; padding-top: 5px">RM sen</div>
						</div>
						<div class="form-group row">
							<label for="fname" class="col-md-8 control-label"><b>Tunai:</b></label>
						</div>

						@include('finance.statement.ks.formn.cash.index')

						@include('finance.statement.ks.formn.bank.index')
						
						<div class="form-group row">
							<label for="fname" class="col-md-8 control-label">Sekuriti-sekuriti seperti dalam senarai dibawah (dilekatkan) yuran teraku yang belum dibayar</label>
							<div class="col-md-4 pull-right">
								<input class="form-control decimal" name="asset_security" aria-required="true" type="text" value="{{ $statement->asset_security }}" required>
							</div>
						</div>

						@include('finance.statement.ks.formn.lent.index')

						<div class="form-group row">
							<label for="fname" class="col-md-8 control-label">Harta tak alih
								<br>
								<input class="form-control" name="asset_property" aria-required="true" type="text" value="{{ $statement->asset_property }}" required>
							</label>
							<div class="col-md-4 pull-right">
								<input class="form-control decimal" name="asset_property_total" aria-required="true" type="text" value="{{ $statement->asset_property_total }}" required>
							</div>
						</div>
						
						<div class="form-group row">
							<label for="fname" class="col-md-8 control-label">Barang-barang dan perabot</label>
							<div class="col-md-4 pull-right">
								<input class="form-control decimal" name="asset_furniture" aria-required="true" type="text" value="{{ $statement->asset_furniture }}" required>
							</div>
						</div>

						<div class="form-group row">
							<label for="fname" class="col-md-8 control-label">Aset-aset lain (nyatakan)
								<br>
								<input class="form-control" name="other_asset" aria-required="true" type="text" value="{{ $statement->other_asset }}" required>
							</label>
							<div class="col-md-4 pull-right">
								<input class="form-control decimal" name="other_asset_total" aria-required="true" type="text" value="{{ $statement->other_asset_total }}" required>
							</div>
						</div>
						
					</div>
				</div>
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

			</form>
		</div>
	</div>
	<!-- END card -->
</div>
<!-- END CONTAINER FLUID -->

@push('js')
<script type="text/javascript">
	$('#form-tab3').validate();
</script>
@endpush