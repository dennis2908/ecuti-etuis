<!-- START CONTAINER FLUID -->
<div class=" container-fluid container-fixed-lg bg-white">
	<!-- START card -->
	<div class="card card-transparent">
		<div class="card-block">
			<form id="form-tab3" class="form-horizontal" role="form" autocomplete="off" method="post" action="#">
				<div class="card card-transparent mt-3 mb-2">
					<div class="card-block p-t-0">
						<h5 class='m-t-5'><span class="semi-bold">:: Daftar Yuran</span> (AP.3)</h5> 
						<hr>
					</div>
				</div>

				<div class="form-group row">
					<label for="fname" class="col-md-12 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="{{ $enforcement->pbp2->is_fee_registration }}" name="is_fee_registration" id="is_fee_registration" type="checkbox" class="hidden">
							<label for="is_fee_registration">(a) Daftar yuran disediakan mengikut Peraturan 54(e), Peraturan-Peraturan Kesatuan Sekerja 1959</label>
						</div>
					</label>
				</div>

				<div class="form-group row">
					<label for="dashboard" class="col-md-4 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="0" id="checklist9" type="checkbox" class="hidden">
							<label for="checklist9">(b) Kesatuan mendapat pengecualian di bawah Peraturan 68, Peraturan-Peraturan Kesatuan Sekerja 1959
								<span style="color:red;">*</span>
								<i style="cursor: help; color: #48B0F7;" class="fa fa-question-circle" data-html="true" data-toggle="tooltip" title="Cth: Seksyen 38(2) Akta Kesatuan Sekerja 1959"></i>
							</label>
						</div>
					</label>
					<div class="col-md-8">
						*Tarikh kelulusan KPKS<br>
						<div id="datepicker-component" class="input-group date p-l-0">
		                      <input type="text" class="form-control" name="kpks_approved_at" value="{{ $enforcement->pbp2->kpks_approved_at ?  date('d/m/Y', strtotime( $enforcement->pbp2->kpks_approved_at)) : date('d/m/Y') }}" >
		                      <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
		                </div>
					</div>
				</div>

				<div class="form-group row">
					<label for="checklist10" class="col-md-4 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="0" id="checklist10" type="checkbox" class="hidden">
							<label for="checklist10">(c) Maklumat Yuran
								<i style="cursor: help; color: #48B0F7;" class="fa fa-question-circle" data-html="true" data-toggle="tooltip" title="Cth: Yuran masuk RMXX.XX, Yuran Bulanan RMXX.XX dan Yuran Kebajikan RMXX.XX dibayar melalui potongan gaji/kutipan."></i>
							</label>
						</div>
					</label>
					<div class="col-md-8">
						<input type="text" name="fee_details" class="form-control" value="{{ $enforcement->pbp2->fee_details }}">
					</div>
				</div>

				<div class="form-group row">
					<label for="fname" class="col-md-4 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="0" id="checklist11" type="checkbox" class="hidden">
							<label for="checklist11">(d) Jumlah ahli pada tarikh pemeriksaan
								<i style="cursor: help; color: #48B0F7;" class="fa fa-question-circle" data-html="true" data-toggle="tooltip" title="Bagi Kesatuan sekerja pekerja"></i>
							</label>
						</div>
					</label>
					<div class="col-md-8">
						<table class="table table-hover m-t-0" id="table-employee">
							<thead>
								<tr>
									<th class="fit">Jantina</th>
									<th>Berdaftar</th>
									<th>Berhak</th>
									<th>Bersekutu</th>
									<th>Pekerja Asing</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Lelaki</td>
									<td><input type="text" class="form-control numeric" name="registered_male" value="{{ $enforcement->pbp2->registered_male }}"></td>
									<td><input type="text" class="form-control numeric" name="rightful_male" value="{{ $enforcement->pbp2->rightful_male }}"></td>
									<td><input type="text" class="form-control numeric" name="union_male" value="{{ $enforcement->pbp2->union_male }}"></td>
									<td><input type="text" class="form-control numeric" name="foreign_male" value="{{ $enforcement->pbp2->foreign_male }}"></td>
								</tr>
								<tr>
									<td>Perempuan</td>
									<td><input type="text" class="form-control" name="registered_female" value="{{ $enforcement->pbp2->registered_female }}"></td>
									<td><input type="text" class="form-control" name="rightful_female" value="{{ $enforcement->pbp2->rightful_female }}"></td>
									<td><input type="text" class="form-control" name="union_female" value="{{ $enforcement->pbp2->union_female }}"></td>
									<td><input type="text" class="form-control" name="foreign_female" value="{{ $enforcement->pbp2->foreign_female }}"></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>

				<div class="form-group row">
					<label for="fname" class="col-md-4 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="1" id="checklist12" type="checkbox" class="hidden">
							<label for="checklist12">(e) Jumlah ahli pada tarikh pemeriksaan
								<i style="cursor: help; color: #48B0F7;" class="fa fa-question-circle" data-html="true" data-toggle="tooltip" title="Bagi Kesatuan sekerja majikan"></i>
							</label>
						</div>
					</label>
					<div class="col-md-8">
						<table class="table table-hover m-t-0" id="table-employer">
							<thead>
								<tr>
									<th>Jantina</th>
									<th>Berdaftar</th>
									<th>Berhak</th>
									<th>Bersekutu</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Lelaki</td>
									<td><input type="text" class="form-control numeric" name="registered_male" value="{{ $enforcement->pbp2->registered_male }}"></td>
									<td><input type="text" class="form-control numeric" name="rightful_male" value="{{ $enforcement->pbp2->rightful_male }}"></td>
									<td><input type="text" class="form-control numeric" name="union_male" value="{{ $enforcement->pbp2->union_male }}"></td>
								</tr>
								<tr>
									<td>Perempuan</td>
									<td><input type="text" class="form-control numeric" name="registered_female" value="{{ $enforcement->pbp2->registered_female }}"></td>
									<td><input type="text" class="form-control numeric" name="rightful_female" value="{{ $enforcement->pbp2->rightful_female }}"></td>
									<td><input type="text" class="form-control numeric" name="union_female" value="{{ $enforcement->pbp2->union_female }}"></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>

				<div class="card card-transparent mt-3 mb-2">
					<div class="card-block p-t-0">
						<h5 class='m-t-5'><span class="semi-bold">:: Buku Tunai</span> dan Penyelarasan Bank</h5> 
						<hr>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-md-12 control-label p-l-20 bold" style="background-color: #E6E6E6"> 2.2.1 Buku Tunai (AP.1)</label>
				</div>

				<div class="form-group row">
					<label for="checklist13" class="col-md-4 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="1" id="checklist13" type="checkbox" class="hidden">
							<label for="checklist13">(a) Buku Tunai disediakan mengikut format AP1.
								<i style="cursor: help; color: #48B0F7;" class="fa fa-question-circle" data-html="true" data-toggle="tooltip" title="Peraturan 54(a), Peraturan-Peraturan Kesatuan Sekerja 1959"></i>
							</label>
						</div>
					</label>
					<div class="col-md-8">
						Sekiranya tidak, penjelasan Kesatuan adalah
						<textarea name="justification_nonformat" class="form-control" style="height: 150px;">{{ $enforcement->pbp2->justification_nonformat }}</textarea>
					</div>
				</div>

				<div class="form-group row">
					<label for="fname" class="col-md-12 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="{{ $enforcement->pbp2->is_exampted }}" name="is_exampted" id="is_exampted" type="checkbox" class="hidden">
							<label for="is_exampted">(b) Adakah Kesatuan dikecualikan dari pada selenggarakan Buku Tunai secara berkomputer / manual?
								<i style="cursor: help; color: #48B0F7;" class="fa fa-question-circle" data-html="true" data-toggle="tooltip" title="Peraturan 68, Peraturan-Peraturan Kesatuan Sekerja 1959"></i>
							</label>
						</div>
					</label>
				</div>

				<div class="form-group row">
					<label for="fname" class="col-md-12 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="{{ $enforcement->pbp2->is_accepted }}" name="is_accepted" id="is_accepted" type="checkbox" class="hidden">
							<label for="is_accepted">(c) Penerimaan dan pembayaran dan resit/baucar direkod dengan teratur dalam buku tunai.
								<i style="cursor: help; color: #48B0F7;" class="fa fa-question-circle" data-html="true" data-toggle="tooltip" title="Peraturan 59 (1) Peraturan-Peraturan Kesatuan Sekerja 1969"></i>
							</label>
						</div>
					</label>
				</div>

				<div class="form-group row">
					<label for="fname" class="col-md-4 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="0" id="checklist14" type="checkbox" class="hidden">
							<label for="checklist14">(d) Buku tunai dikemaskini sehingga ..... 
								<i style="cursor: help; color: #48B0F7;" class="fa fa-question-circle" data-html="true" data-toggle="tooltip" title="Peraturan 59 (4) Peraturan-Peraturan Kesatuan Sekerja 1969"></i>
							</label>
						</div>
					</label>
					<div class="col-md-8">
						<div id="datepicker-component" class="input-group date p-l-0">
		                      <input type="text" class="form-control" name="cash_book_update_at" value="{{ $enforcement->pbp2->cash_book_update_at ? date('d/m/Y', strtotime($enforcement->pbp2->cash_book_update_at)) : date('d/m/Y') }}" >
		                      <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
		                </div>
					</div>
				</div>

				<div class="form-group row">
					<label for="fname" class="col-md-12 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="{{ $enforcement->pbp2->is_account_balanced_monthly }}" name="is_account_balanced_monthly" id="is_account_balanced_monthly" type="checkbox" class="hidden">
							<label for="is_account_balanced_monthly">(e) Akaun diseimbangkan pada setiap akhir bulan
								<i style="cursor: help; color: #48B0F7;" class="fa fa-question-circle" data-html="true" data-toggle="tooltip" title="Peraturan 60 Peraturan-Peraturan Kesatuan Sekerja 1959"></i>
							</label>
						</div>
					</label>
				</div>

				<div class="form-group row">
					<label for="fname" class="col-md-4 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="0" id="checklist15" type="checkbox" class="hidden">
							<label for="checklist15">(f) Perbelanjaan mengikut Seksyen 50 (1) Akta Kesatuan Sekerja 1959
							</label>
						</div>
					</label>
					<div class="col-md-8">
						Sekiranya lebih had tunai, penjelasan Kesatuan adalah
						<textarea name="justification_exceed_limit" class="form-control" style="height: 150px;">{{ $enforcement->pbp2->justification_exceed_limit }}</textarea>
					</div>
				</div>

				<div class="form-group row">
					<label for="fname" class="col-md-4 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="0" id="checklist16" type="checkbox" class="hidden">
							<label for="checklist16">(g) Had tunai ditangan menurut Peraturan 19(5) Peraturan Kesatuan (RM) (nyatakan)</label>
						</div>
					</label>
					<div class="col-md-8">
						<div class="input-group">
	                      	<span class="input-group-addon default">
	                          	RM 
	                      	</span>
							<input type="text" name="cash_limit" value="{{ $enforcement->pbp2->cash_limit }}" class="decimal form-control">
						</div>
					</div>
				</div>

				<div class="form-group row">
					<label for="fname" class="col-md-4 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="0" id="checklist17" type="checkbox" class="hidden">
							<label for="checklist17">(h) Baki akhir dalam buku tunai sama seperti dalam Penyata Bank. </label>
						</div>
					</label>
					<div class="col-md-8">						
						Baki akhir pada <br>
						<div id="datepicker-component" class="input-group date p-l-0">
		                    <input type="text" class="form-control" name="balance_at" value="{{ $enforcement->pbp2->balance_at ? date('d/m/Y', strtotime($enforcement->pbp2->balance_at)) : date('d/m/Y') }}" >
		                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
		                </div>
					</div>
				</div>

				<div class="form-group row">
					<label for="fname" class="col-md-4 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="0" id="checklist18" type="checkbox" class="hidden">
							<label for="checklist18">Tabung Am</label>
						</div>
					</label>
					<div class="col-md-8">
						<div class="form-group row p-t-0">
							<label for="saving_cash" class="col-md-4 control-label">Buku Tunai</label>
							<div class="input-group col-md-8">
		                      	<span class="input-group-addon default">
		                          	RM
		                      	</span>
								<input type="text" name="saving_cash" value="{{ $enforcement->pbp2->saving_cash }}" class="decimal form-control">
							</div>
						</div>
						<div class="form-group row">
							<label for="saving_bank" class="col-md-4 control-label">Bank</label>
							<div class="input-group col-md-8">
		                      	<span class="input-group-addon default">
		                          	RM
		                      	</span>
								<input type="text" name="saving_bank" value="{{ $enforcement->pbp2->saving_bank }}" class="decimal form-control">
							</div>
						</div>
						<div class="form-group row">
							<label for="saving_at_hand" class="col-md-4 control-label">Di tangan</label>
							<div class="input-group col-md-8">
		                      	<span class="input-group-addon default">
		                          	RM
		                      	</span>
								<input type="text" name="saving_at_hand" value="{{ $enforcement->pbp2->saving_at_hand}}" class="decimal form-control">
							</div>
						</div>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-md-12 control-label p-l-20 bold" style="background-color: #E6E6E6"> 2.2.2 Penyata Penyelarasan Bank (AP.7)</label>
				</div>

				<div class="form-group row">
					<label class="col-md-4 control-label">(a) Penyata Penyelarasan Bank <span style="color:red;">*</span></label>
					<div class="col-md-8">
						<div class="radio radio-success">
							<input type="radio" value="1" name="is_monthly_maintained" id="is_monthly_maintained1" class="hidden">
							<label for="is_monthly_maintained1">Penyata Penyelarasan Bank disediakan mengikut format AP7
								<i style="cursor: help; color: #48B0F7;" class="fa fa-question-circle" data-html="true" data-toggle="tooltip" title="Peraturan 60 Peraturan-Peraturan Kesatuan Sekerja 1959"></i>
							</label>
							<input type="radio" value="2" name="is_monthly_maintained" id="is_monthly_maintained2" class="hidden">
							<label for="is_monthly_maintained2">Diselenggara setiap bulan</label>
						</div>
					</div>
				</div>

				<div class="form-group row">
					<label for="fname" class="col-md-12 control-label p-l-20 bold" style="background-color: #E6E6E6">2.2.3 Rekod Stok dan Pengeluaran Buku Resit (AP.4)</label>
				</div>

				<div class="form-group row">
					<label class="col-md-1 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="1" id="checklist19" type="checkbox" class="hidden">
							<label for="checklist19"></label>
						</div>
					</label>
					<div class="col-md-11">
						<table class="table table-hover " id="table-stock">
							<thead>
								<tr>
									<th class="fit">Bil</th>
									<th>Perkara</th>
									<th>Jumlah Buku</th>
									<th>Nombor Buku</th>
									<th>Nombor Siri</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>1</td>
									<td>Bilangan buku resit dalam simpanan</td>
									<td><input type="text" class="form-control numeric" name="total_book_saved" value="{{ $enforcement->pbp2->total_book_saved }}"></td>
									<td><input type="text" class="form-control" name="num_book_saved" value="{{ $enforcement->pbp2->num_book_saved }}"></td>
									<td><input type="text" class="form-control" name="series_book_saved" value="{{ $enforcement->pbp2->series_book_saved }}"></td>
								</tr>
								<tr>
									<td>2</td>
									<td>Buku resit yang sedang digunakan</td>
									<td><input type="text" class="form-control numeric" name="total_book_used" value="{{ $enforcement->pbp2->total_book_used }}"></td>
									<td><input type="text" class="form-control" name="num_book_used" value="{{ $enforcement->pbp2->num_book_used }}"></td>
									<td><input type="text" class="form-control" name="series_book_used" value="{{ $enforcement->pbp2->series_book_used }}"></td>
								</tr>
								<tr>
									<td>3</td>
									<td>Baki buku resit yang belum digunakan</td>
									<td><input type="text" class="form-control numeric" name="total_book_unused" value="{{ $enforcement->pbp2->total_book_unused }}"></td>
									<td><input type="text" class="form-control" name="num_book_unused" value="{{ $enforcement->pbp2->num_book_unused }}"></td>
									<td><input type="text" class="form-control" name="series_book_unused" value="{{ $enforcement->pbp2->series_book_unused }}"></td>
								</tr>
							</tbody>
						</table>					
					</div>
				</div>

				<div class="form-group row">
					<label class="col-md-12 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="{{ $enforcement->pbp2->is_stock_maintained }}" name="is_stock_maintained" id="is_stock_maintained" type="checkbox" class="hidden">
							<label for="is_stock_maintained">(a) Rekod Stok dan pengeluaran Buku Resit diselenggarakan mengikut format AP. 4
								<i style="cursor: help; color: #48B0F7;" class="fa fa-question-circle" data-html="true" data-toggle="tooltip" title="Peraturan 54(f) Peraturan-Peraturan Kesatuan Sekerja 1959"></i>
							</label>
						</div>
					</label>
				</div>

				<div class="form-group row">
					<label for="is_cash_updated" class="col-md-12 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="{{ $enforcement->pbp2->is_cash_updated }}" name="is_cash_updated" id="is_cash_updated" type="checkbox" class="hidden">
							<label for="is_cash_updated">(b) Dikemaskini</label>
						</div>
					</label>
				</div>

				<div class="form-group row">
					<label class="col-md-12 control-label p-l-20 bold" style="background-color: #E6E6E6">       
					2.2.4 Buku Resit (AP.5) </label>
				</div>

				<div class="form-group row">
					<label for="is_receipt_printed" class="col-md-12 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="{{ $enforcement->pbp2->is_receipt_printed }}" name="is_receipt_printed" id="is_receipt_printed" type="checkbox" class="hidden">
							<label for="is_receipt_printed">(a) Buku Resit dicetak mengikut format AP.5
								<i style="cursor: help; color: #48B0F7;" class="fa fa-question-circle" data-html="true" data-toggle="tooltip" title="Peraturan 56(2) dan (3) Peraturan-Peraturan Kesatuan Sekerja 1959"></i>
							</label>
						</div>
					</label>
				</div>

				<div class="form-group row">
					<label for="is_receipt_issued" class="col-md-12 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="{{ $enforcement->pbp2->is_receipt_issued }}" name="is_receipt_issued" id="is_receipt_issued" type="checkbox" class="hidden">
							<label for="is_receipt_issued">(b) Resit dikeluarkan bagi setiap wang yang diterima<i style="cursor: help; color: #48B0F7;" class="fa fa-question-circle" data-html="true" data-toggle="tooltip" title="Peraturan 56(2) dan (3) Peraturan-Peraturan Kesatuan Sekerja 1959"></i>
							</label>
						</div>
					</label>
				</div>

				<div class="form-group row">
					<label for="is_receipt_given" class="col-md-12 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="{{ $enforcement->pbp2->is_receipt_given }}" name="is_receipt_given" id="is_receipt_given" type="checkbox" class="hidden">
							<label for="is_receipt_given">(c) Resit dikeluarkan kepada ahli yang bayar yuran secara manual setiap bulan<i style="cursor: help; color: #48B0F7;" class="fa fa-question-circle" data-html="true" data-toggle="tooltip" title="Peraturan 56(1) Peraturan-Peraturan Kesatuan Sekerja 1959"></i>
							</label>
						</div>
					</label>
				</div>

				<div class="form-group row">
					<label for="is_receipt_duplicated" class="col-md-12 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="{{ $enforcement->pbp2->is_receipt_duplicated }}" name="is_receipt_duplicated" id="is_receipt_duplicated" type="checkbox" class="hidden">
							<label for="is_receipt_duplicated">(d) Buku resit disediakan dalam dua salinan dan dinomborkan mengikut siri<i style="cursor: help; color: #48B0F7;" class="fa fa-question-circle" data-html="true" data-toggle="tooltip" title="Peraturan 56(3) Peraturan-Peraturan Kesatuan Sekerja 1959"></i>
							</label>
						</div>
					</label>
				</div>

				<div class="form-group row">
					<label for="checklist20" class="col-md-4 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="0" id="checklist20" type="checkbox" class="hidden">
							<label for="checklist20">(e) Resit yang terakhir bernombor ....... bertarikh ....... bagi tujuan penerimaan  ....... berjumlah  ........</label>
						</div>
					</label>
					<div class="col-md-8">
						<div class="form-group row p-t-0">
							<label for="receipt_no" class="col-md-4 control-label">Nombor resit</label>
							<div class="col-md-8">
								<input type="text" name="receipt_no" value="{{ $enforcement->pbp2->receipt_no }}" class="form-control"">
							</div>
						</div>
						<div class="form-group row">
							<label for="receipt_at" class="col-md-4 control-label">Tarikh resit</label>
							<div class="col-md-8">
								<div id="datepicker-component" class="input-group date p-l-0" >
				                      <input type="text" class="form-control" name="receipt_at" value="{{ $enforcement->pbp2->receipt_at ? date('d/m/Y', strtotime($enforcement->pbp2->receipt_at)) : '' }}" >
				                      <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				                </div>
							</div>
						</div>
						<div class="form-group row">
							<label for="fnreceipt_purposeame" class="col-md-4 control-label">Tujuan Penerimaan</label>
							<div class="col-md-8">
								<input type="text" name="receipt_purpose" value="{{ $enforcement->pbp2->receipt_purpose }}" class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<label for="total_receipt" class="col-md-4 control-label">Jumlah</label>
							<div class="input-group col-md-8">
		                      	<span class="input-group-addon default">
		                          	RM
		                      	</span>
								<input type="text" name="total_receipt" value="{{ $enforcement->pbp2->total_receipt }}" class="decimal form-control">
							</div>
						</div>
					</div>
				</div>

				<div class="form-group row">
					<label for="is_receipt_verified" class="col-md-12 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="{{ $enforcement->pbp2->is_receipt_verified }}" name="is_receipt_verified" id="is_receipt_verified" type="checkbox" class="hidden">
							<label for="is_receipt_verified">(f) Buku Resit yang dikeluarkan telah disemak oleh Setiausaha
								<i style="cursor: help; color: #48B0F7;" class="fa fa-question-circle" data-html="true" data-toggle="tooltip" title="Peraturan 56(4) Peraturan-Peraturan Kesatuan Sekerja 1959"></i>
							</label>
						</div>
					</label>
				</div>

				<div class="form-group row">
					<label class="col-md-12 control-label p-l-20 bold" style="background-color: #E6E6E6"> 
					2.2.5 Jurnal</label>
				</div>

				<div class="form-group row">
					<label for="fname" class="col-md-12 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="{{ $enforcement->pbp2->is_journal_maintained }}" name="is_journal_maintained" id="is_journal_maintained" type="checkbox" class="hidden">
							<label for="is_journal_maintained">(a) Adakah Kesatuan selenggara Jurnal?
								<i style="cursor: help; color: #48B0F7;" class="fa fa-question-circle" data-html="true" data-toggle="tooltip" title="Peraturan 54(b) Peraturan-Peraturan Kesatuan Sekerja 1959"></i>
							</label>
						</div>
					</label>
				</div>

				<div class="form-group row">
					<label for="is_journal_updated" class="col-md-12 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="{{ $enforcement->pbp2->is_journal_updated }}" name="is_journal_updated" id="is_journal_updated" type="checkbox" class="hidden">
							<label for="is_journal_updated">(b) Dikemaskini</label>
						</div>
					</label>
				</div>

				<div class="form-group row">
					<label class="col-md-12 control-label p-l-20 bold" style="background-color: #E6E6E6">      
					2.2.6 Lejar</label>
				</div>

				<div class="form-group row">
					<label for="is_ledger_maintained" class="col-md-12 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="{{ $enforcement->pbp2->is_ledger_maintained }}" name="is_ledger_maintained" id="is_ledger_maintained" type="checkbox" class="hidden">
							<label for="is_ledger_maintained">(a) Adakah Kesatuan selenggara Lejar
								<i style="cursor: help; color: #48B0F7;" class="fa fa-question-circle" data-html="true" data-toggle="tooltip" title="Peraturan 54(c) Peraturan-Peraturan Kesatuan Sekerja 1959"></i>
							</label>
						</div>
					</label>
				</div>

				<div class="form-group row">
					<label for="is_payment_recorded" class="col-md-12 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="{{ $enforcement->pbp2->is_payment_recorded }}" name="is_payment_recorded" id="is_payment_recorded" type="checkbox" class="hidden">
							<label for="is_payment_recorded">(b) Setiap penerimaan/pembayaran direkodkan di dalam folio-folio yang ditetapkan</label>
						</div>
					</label>
				</div>

				<div class="form-group row">
					<label for="is_ledger_recorded" class="col-md-12 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="{{ $enforcement->pbp2->is_ledger_recorded }}" name="is_ledger_recorded" id="is_ledger_recorded" type="checkbox" class="hidden">
							<label for="is_ledger_recorded">(c) Folio Lejar dicatatkan dalam Buku Tunai</label>
						</div>
					</label>
				</div>

				<div class="form-group row">
					<label for="is_ledger_updated" class="col-md-12 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="{{ $enforcement->pbp2->is_ledger_updated }}" name="is_ledger_updated" id="is_ledger_updated" type="checkbox" class="hidden">
							<label for="is_ledger_updated">(e) Dikemaskini</label>
						</div>
					</label>
				</div>

				<div class="form-group row">
					<label class="col-md-12 control-label p-l-20 bold" style="background-color: #E6E6E6">      
					2.2.7 Baucer Pembayaran Dalaman (AP. 6)</label>
				</div>

				<div class="form-group row">
					<label for="is_voucher_maintained" class="col-md-12 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="{{ $enforcement->pbp2->is_voucher_maintained }}" name="is_voucher_maintained" id="is_voucher_maintained" type="checkbox" class="hidden">
							<label for="is_voucher_maintained">(a) Baucer Pembayaran Dalaman diselenggarakan mengikut format AP.6.
								<i style="cursor: help; color: #48B0F7;" class="fa fa-question-circle" data-html="true" data-toggle="tooltip" title="Peraturan 57 Peraturan-Peraturan Kesatuan Sekerja 1959"></i>
							</label>
						</div>
					</label>
				</div>

				<div class="form-group row">
					<label for="is_voucher_issued" class="col-md-12 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="{{ $enforcement->pbp2->is_voucher_issued }}" name="is_voucher_issued" id="is_voucher_issued" type="checkbox" class="hidden">
							<label for="is_voucher_issued">(b) Baucer dikeluarkan bagi setiap pembayaran yang dibuat
						</div>
					</label>
				</div>

				<div class="form-group row">
					<label for="is_voucher_signed" class="col-md-12 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="{{ $enforcement->pbp2->is_voucher_signed }}" name="is_voucher_signed" id="is_voucher_signed" type="checkbox" class="hidden">
							<label for="is_voucher_signed">(c) Setiap baucer yang dikeluarkan ditandatangani oleh ketiga-tiga pegawai Kesatuan dan penerima
							</label>
						</div>
					</label>
				</div>

				<div class="form-group row">
					<label for="is_voucher_attached" class="col-md-12 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="{{ $enforcement->pbp2->is_voucher_attached }}" name="is_voucher_attached" id="is_voucher_attached" type="checkbox" class="hidden">
							<label for="is_voucher_attached">(d) Baucer disertakan dengan dokumen sokongan
							</label>
						</div>
					</label>
				</div>

				<div class="form-group row">
					<label for="is_voucher_arranged" class="col-md-12 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="{{ $enforcement->pbp2->is_voucher_arranged }}" name="is_voucher_arranged" id="is_voucher_arranged" type="checkbox" class="hidden">
							<label for="is_voucher_arranged">(e) Baucer dinomborkan dan disusun mengikut turutan dan tarikh
							</label>
						</div>
					</label>
				</div>

				<div class="form-group row">
					<label for="checklist21" class="col-md-4 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="0" id="checklist21" type="checkbox" class="hidden">
							<label for="checklist21">(f) Baucer yang terakhir bernombor ....... bertarikh ....... bagi tujuan penerimaan  ....... berjumlah  ........</label>
						</div>
					</label>
					<div class="col-md-8">
						<div class="form-group row p-t-0">
							<label for="voucher_no" class="col-md-4 control-label">Nombor baucer</label>
							<div class="col-md-8">
								<input type="text" name="voucher_no" value="{{ $enforcement->pbp2->voucher_no }}" class="form-control"">
							</div>
						</div>
						<div class="form-group row">
							<label for="voucher_at" class="col-md-4 control-label">Tarikh baucer</label>
							<div class="col-md-8">
								<div id="datepicker-component" class="input-group date p-l-0">
				                      <input type="text" class="form-control" name="voucher_at" value="{{ $enforcement->pbp2->voucher_at ? date('d/m/Y', strtotime($enforcement->pbp2->voucher_at)) : '' }}" >
				                      <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				                </div>
							</div>
						</div>
						<div class="form-group row">
							<label for="voucher_at" class="col-md-4 control-label">Tujuan Penerimaan</label>
							<div class="col-md-8">
								<input type="text"  name="voucher_purpose" value="{{ $enforcement->pbp2->voucher_purpose }}"  class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<label for="total_voucher" class="col-md-4 control-label">Jumlah</label>
							<div class="input-group col-md-8">
		                      	<span class="input-group-addon default">
		                          	RM
		                      	</span>
								<input type="text"  name="total_voucher" value="{{ $enforcement->pbp2->total_voucher }}"  class="decimal form-control">
							</div>
						</div>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-md-12 control-label p-l-20 bold" style="background-color: #E6E6E6">2.2.8 Daftar Harta (AP.2)</label>
				</div>

				<div class="form-group row">
					<label for="is_asset_registered" class="col-md-12 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="{{ $enforcement->pbp2->is_asset_registered }}" name="is_asset_registered" id="is_asset_registered" type="checkbox" class="hidden">
							<label for="is_asset_registered">(a) Daftar Harta disediakan mengikut format AP.2
								<i style="cursor: help; color: #48B0F7;" class="fa fa-question-circle" data-html="true" data-toggle="tooltip" title="Peraturan 54(d) Peraturan-Peraturan Kesatuan Sekerja 1959"></i>
							</label>
						</div>
					</label>
				</div>

				<div class="form-group row">
					<label for="checklist22" class="col-md-4 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="0" id="checklist22" type="checkbox" class="hidden">
							<label for="checklist22">(b) Semua harta milik Kesatuan telah didaftarkan</label>
						</div>
					</label>										
					<div class="col-md-8">
						Sekiranya ada harta tidak didaftarkan, nyatakan alasan Kesatuan:<br>
						<textarea style="height: 100px;" placeholder="" name="justification_unregistered" class="form-control">{{ $enforcement->pbp2->justification_unregistered }}</textarea>
					</div>
				</div>

				<div class="form-group row">
					<label for="fname" class="col-md-4 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="1" id="checklist23" type="checkbox" class="hidden">
							<label for="checklist23">
								(c) Pembelian harta/ aset telah diluluskan mesyuarat dan senarai harta/aset adalah seperti dinyatakan dalam 
								<a id="" href="{{ route('pbp2.b1', $enforcement->id) }}" target="_blank" class="btn btn-primary btn-cons text-capitalize btn-sm"><i class="fa fa-plus m-r-5"></i> Lampiran B1</a>
								<i style="cursor: help; color: #48B0F7;" class="fa fa-question-circle" data-html="true" data-toggle="tooltip" title="Semak dengan minit mesyuarat berkaitan."></i>
							</label>
						</div>
					</label>
					<div class="col-md-8">
						Catatan
						<textarea style="height: 100px;" placeholder="" name="asset_purchased_notes" class="form-control">{{ $enforcement->pbp2->asset_purchased_notes }}</textarea>
					</div>
				</div>

				<div class="form-group row">
					<label for="checklist24" class="col-md-4 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="0" id="checklist24" type="checkbox" class="hidden">
							<label for="checklist24">(d) Kadar susut nilai telah diluluskan mesyuarat
								<i style="cursor: help; color: #48B0F7;" class="fa fa-question-circle" data-html="true" data-toggle="tooltip" title="Semak dengan minit mesyuarat berkaitan."></i>
							</label>
						</div>
					</label>
					<div class="col-md-8">
						Catatan
						<textarea style="height: 100px;" placeholder="" name="depreciation_approved_notes" class="form-control">{{ $enforcement->pbp2->depreciation_approved_notes}}</textarea>
					</div>
				</div>

				<div class="form-group row">
					<label for="is_copy_saved" class="col-md-12 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="{{ $enforcement->pbp2->is_copy_saved }}" name="is_copy_saved" id="is_copy_saved" type="checkbox" class="hidden">
							<label for="is_copy_saved">(e) Salinan senarai harta/geran/SNP disimpan oleh pemegang amanah
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
	<!-- END card -->
</div>
<!-- END CONTAINER FLUID -->

@push('js')
<script type="text/javascript">
	$('#form-tab3').validate();

	$("#is_monthly_maintained{{ $enforcement->pbp2->is_monthly_maintained }}").prop('checked', true).trigger('change');

	@if($enforcement->pbp2->is_fee_registration == 1)
		$("#is_fee_registration").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->kpks_approved_at)
		$("#checklist9").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->fee_details)
		$("#checklist10").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->entity->formb)
		@if($enforcement->entity->formb->union_type_id == 2)
			$("#checklist11").prop('checked', true).trigger('change');
		@endif

		@if($enforcement->entity->formb->union_type_id == 1)
			$("#checklist12").prop('checked', true).trigger('change');
		@endif
	@endif

	@if($enforcement->pbp2->justification_nonformat)
		$("#checklist13").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->is_exampted == 1)
		$("#is_exampted").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->is_accepted == 1)
		$("#is_accepted").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->cash_book_update_at)
		$("#checklist14").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->is_account_balanced_monthly== 1)
		$("#is_account_balanced_monthly").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->justification_exceed_limit)
		$("#checklist15").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->cash_limit)
		$("#checklist16").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->balance_at)
		$("#checklist17").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->saving_cash || $enforcement->pbp2->saving_bank || $enforcement->pbp2->saving_at_hand)
		$("#checklist18").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->total_book_saved || $enforcement->pbp2->total_book_used || $enforcement->pbp2->total_book_unused)
		$("#checklist19").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->is_stock_maintained == 1)
		$("#is_stock_maintained").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->is_cash_updated == 1)
		$("#is_cash_updated").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->is_receipt_printed == 1)
		$("#is_receipt_printed").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->is_receipt_issued == 1)
		$("#is_receipt_issued").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->is_receipt_given == 1)
		$("#is_receipt_given").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->is_receipt_duplicated == 1)
		$("#is_receipt_duplicated").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->receipt_no)
		$("#checklist20").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->is_receipt_verified == 1)
		$("#is_receipt_verified").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->is_journal_maintained == 1)
		$("#is_journal_maintained").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->is_journal_updated == 1)
		$("#is_journal_updated").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->is_ledger_maintained == 1)
		$("#is_ledger_maintained").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->is_payment_recorded == 1)
		$("#is_payment_recorded").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->is_ledger_recorded == 1)
		$("#is_ledger_recorded").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->is_ledger_updated == 1)
		$("#is_ledger_updated").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->is_voucher_maintained == 1)
		$("#is_voucher_maintained").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->is_voucher_issued == 1)
		$("#is_voucher_issued").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->is_voucher_signed == 1)
		$("#is_voucher_signed").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->is_voucher_attached == 1)
		$("#is_voucher_attached").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->is_voucher_arranged == 1)
		$("#is_voucher_arranged").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->voucher_no)
		$("#checklist21").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->voucher_no)
		$("#checklist21").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->is_asset_registered == 1)
		$("#is_asset_registered").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->justification_unregistered)
		$("#checklist22").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->b1->count() != 0)
		$("#checklist23").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->depreciation_approved_notes)
		$("#checklist24").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->is_copy_saved == 1)
		$("#is_copy_saved").prop('checked', true).trigger('change');
	@endif
</script>
@endpush