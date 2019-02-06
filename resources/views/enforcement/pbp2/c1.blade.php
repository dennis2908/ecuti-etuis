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
							<h3 class='m-t-0'> Penyata Penerimaan dan Bayaran</h3>
							<p class="small hint-text m-t-5">
								Lampiran C1
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
<!-- START CONTAINER FLUID -->
@include('components.msg-connecting')
<!-- START CONTAINER FLUID -->
<div class=" container-fluid container-fixed-lg bg-white">
    <!-- START card -->
    <div class="card card-transparent">
        <div class="card-header px-0">
            <div class="alert alert-info bordered" role="alert">
        		
        		<!-- <button class="close pull-right" data-dismiss="alert"></button> -->
        		<p>
        			<strong>Perhatian:</strong>
        			<ol>
        				<li>Borang ini hendaklah disempurnakan dan jumlah-jumlah penerimaan dan bayaran mestilah seimbang;</li>
        				<li>Sila serahkan borang ini kepada pegawai yang membuat lawatan ke kesatuan tuan; dan</li>
        				<li>Sekiranya butir-butir penerimaan, harap pinda dengan sewajarnya dan membuat penambahan dimana perlu</li>
        			</ol>
        		</p>
        		<div class="clearfix"></div>
        	</div>
            <div class="clearfix"></div>
        </div>
        <div class="card-block">

        	<div class="form-group row text-center mb-5" style="vertical-align: middle;">
				<label for="fname" class="col-md-2 control-label bold">Bagi tempoh</label>
				<div class="col-md-6">
					<div class="row">
						<input type="text" class="form-control col-md-5" name="start_year" value="{{ $c1->start_year }}" placeholder="20XX">
						<span class="col-md-2 text-center ">HINGGA</span>
						<input type="text" class="form-control col-md-5" name="end_year" value="{{ $c1->end_year }}" placeholder="20XX">
					</div>
				</div>
			</div>

            <table class="table table-hover" id="table">
                <thead>
                    <tr>
                        <th>Perkara</th> 
                        <th>RM</th>
                        <th>Perkara</th>
                        <th>RM</th>
                    </tr>
                </thead>
                <tbody id="data">
                    <tr>
                        <td>Tunai ditangan</td> 
                        <td><input type="text" class="input-sm form-control income" name="cash_at_hand" value="{{ $c1->cash_at_hand }}"/></td>
                        <td>Elaun / imbuhan pegawai-pegawai </td>
                        <td><input type="text" class="input-sm form-control liability" name="officer_allowance" value="{{ $c1->officer_allowance }}"/></td>
                    </tr>
                    <tr>
                        <td>Tunai di Bank</td> 
                        <td><input type="text" class="input-sm form-control income" name="cash_at_bank" value="{{ $c1->cash_at_bank }}" /></td>
                        <td>Belanja Pos/Telegram </td>
                        <td><input type="text" class="input-sm form-control liability" name="post_shipping" value="{{ $c1->post_shipping }}"/></td>
                    </tr>
                    <tr>
                        <td>Yuran Masuk</td> 
                        <td><input type="text" class="input-sm form-control income" name="entrance_fee" value="{{ $c1->entrance_fee }}" /></td>
                        <td>Telefon</td>
                        <td><input type="text" class="input-sm form-control liability" name="phone" value="{{ $c1->phone }}"/></td>
                    </tr>
                    <tr>
                        <td>Yuran Bulanan</td> 
                        <td><input type="text" class="input-sm form-control income" name="monthly_fee" value="{{ $c1->monthly_fee }}"/></td>
                        <td>Alat tulis</td>
                        <td><input type="text" class="input-sm form-control liability" name="stationary" value="{{ $c1->stationary }}"/></td>
                    </tr>
                    <tr>
                        <td>Dari Ibu Pejabat Kesatuan</td> 
                        <td><input type="text" class="input-sm form-control income" name="union_office" value="{{ $c1->union_office }}"/></td>
                        <td>Upah </td>
                        <td><input type="text" class="input-sm form-control liability" name="wage" value="{{ $c1->wage }}" /></td>
                    </tr>
                    <tr>
                        <td rowspan="5"></td> 
                        <td rowspan="5"></td>
                        <td>Belanja Mesyuarat</td>
                        <td><input type="text" class="input-sm form-control liability" name="meeting_expense" value="{{ $c1->meeting_expense }}"/></td>
                    </tr>
                    <tr>
                        <td>Bayaran Balik Pendahuluan</td>
                        <td><input type="text" class="input-sm form-control liability" name="deposit_payment" value="{{ $c1->deposit_payment }}"/></td>
                    </tr>
                    <tr>
                        <td>Belanja Sosial/pelajaran </td>
                        <td><input type="text" class="input-sm form-control liability" name="social_payment" value="{{ $c1->social_payment }}"/></td>
                    </tr>
                    <tr>
                        <td>Tambang Menambang</td>
                        <td><input type="text" class="input-sm form-control liability" name="fare" value="{{ $c1->fare }}"/></td>
                    </tr>
                    <tr>
                        <td>Kadar/cukai/faedah</td>
                        <td><input type="text" class="input-sm form-control liability" name="tax" value="{{ $c1->tax }}"/></td>
                    </tr>
                    <tr>
                    	<td>Derma Sukarela</td>
                        <td><input type="text" class="input-sm form-control income" name="volunteer_fund" value="{{ $c1->volunteer_fund }}"/></td>
                        <td>Sewa pejabat/faedah </td>
                        <td><input type="text" class="input-sm form-control liability" name="rental" value="{{ $c1->rental }}"/></td>
                    </tr>
                    <tr>
                    	<td>Kutipan Khas</td>
                        <td><input type="text" class="input-sm form-control income" name="special_collection" value="{{ $c1->special_collection }}"/></td>
                        <td>Bil-bil letrik/air</td>
                        <td><input type="text" class="input-sm form-control liability" name="electric_bill" value="{{ $c1->electric_bill }}"/></td>
                    </tr>
                    <tr>
                    	<td>Faedah Bank</td>
                        <td><input type="text" class="input-sm form-control income" name="bank_interest" value="{{ $c1->bank_interest }}"/></td>
                        <td>Bantuan Kebajikan</td>
                        <td><input type="text" class="input-sm form-control liability" name="welfare_aid" value="{{ $c1->welfare_aid }}"/></td>
                    </tr>
                    <tr>
                    	<td rowspan="4"></td>
                        <td rowspan="4"></td>
                        <td>Bayaran Gabungan</td>
                        <td><input type="text" class="input-sm form-control liability" name="union_payment" value="{{ $c1->union_payment }}"/></td>
                    </tr>
                    <tr>
                        <td>Seminar / Kursus</td>
                        <td><input type="text" class="input-sm form-control liability" name="seminar_course" value="{{ $c1->seminar_course }}"/></td>
                    </tr>
                    <tr>
                        <td>Tunai dalam tangan pada
                        	<div id="datepicker-component" class="input-group date p-l-0" required>
			                    <input type="text" class="form-control" name="cash_at" value="{{ $c1->cash_at ? date('d/m/Y', strtotime($c1->cash_at)) : date('d/m/Y') }}" >
			                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
		                	</div>
                        </td>
                        <td><input type="text" class="input-sm form-control liability" name="total_at_hand" value="{{ $c1->total_at_hand }}"/></td>
                    </tr>
                    <tr>
                        <td>Tunai dalam bank pada
                        	<div id="datepicker-component" class="input-group date p-l-0" required>
			                    <input type="text" class="form-control" name="bank_at" value="{{ $c1->bank_at ? date('d/m/Y', strtotime($c1->bank_at)) : date('d/m/Y') }}" >
			                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
		                	</div>
                        </td>
                        <td><input type="text" class="input-sm form-control liability" name="total_at_bank" value="{{ $c1->total_at_bank }}"/></td>
                    </tr>
                    <tr>
                    	<td><span class="bold">Jumlah</span></td>
                        <td><span class="bold">RM <span class="total_income"  value="{{ $c1->total_income}}" name="total_income"></span></span></td>
                        <td><span class="bold">Jumlah</span></td>
                        <td><span class="bold">RM <span class="total_liability" value="{{ $c1->total_liability}}"  name="total_liability"></span> </span></td>
                    </tr>
                </tbody>
            </table>
            <br>
            <div class="form-group">
                <!-- If mode update form change button label to Kemaskini-->
                <button type="button" class="btn btn-info pull-right" onclick="saveData()" data-dismiss="modal"><i class="fa fa-check mr-1"></i> Simpan</button>
            </div>
        </div>
    </div>
    <!-- END card -->
</div>
<!-- END CONTAINER FLUID -->
@endsection
@push('js')
<script type="text/javascript">
$(document).ready( function() {
    $('#data').on('keyup', 'input', function() {
        var iSum = 0;
        $('.income').each( function() {
           iSum = iSum + parseFloat($(this).val());
        });
           console.log(iSum);
        $('.total_income').html(iSum);

        var lSum = 0;
        $('.liability').each( function() {
           lSum = lSum + parseFloat($(this).val());
        });
           console.log(lSum);
        $('.total_liability').html(lSum);
    });
});
</script>
@endpush

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
        socket.emit('enforcement_c1', {
            id: {{ $c1->enforcement_id }},
            name: $(this).attr('name'),
            value: $(this).attr('type') == 'checkbox' ? ($(this).prop('checked') ? 1 : 0) : $(this).val(),
            user: '{{ Cookie::get('api_token') }}'
        });
        console.log('changed');
    });
});
</script>
@endpush