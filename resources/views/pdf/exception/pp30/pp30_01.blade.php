<?php
setlocale(LC_TIME, "ms", "my_MS", "ms_MY");
?>

<head>
	<style>

		.letter {
			font-family: Times, Times New Roman, Georgia, serif !important;
			margin: 20px;
			padding-top: 30px;
		}
		.letter div {
			font-size: 18px;
			margin-left: 20px;
			font-family: Times, Times New Roman, Georgia, serif !important;	
		}

		.letter table {
			width: 100%;
			margin-top: 18px;
		}
		.letter td, th {
			font-family: Times, Times New Roman, Georgia, serif !important;
			font-size: 18px;
			padding: 5px;
			padding-left: 0px !important;
			line-height: 1.3em;
		}

		.letter span, a, p, h1, h2 {
			font-family: Times, Times New Roman, Georgia, serif !important;
		}

		.letter span, a, p {
			font-size: 18px;
			line-height: 1.5em;
		}
		.letter .justify {
			text-align: justify;
		}
		.letter .head{
			font-size: 18px;
			line-height: 1.5em;
			text-transform: uppercase;
		}
		.letter .bold {
			font-weight: bold;
		}
		.letter .border {
			border: 1px solid black;
		}
		.letter .uppercase {
			text-transform: uppercase;
		}
		.letter .lowercase {
			text-transform: lowercase;
		}
		.letter .italic {
			font-style: italic;
		}
		.letter .camelcase {
			text-transform: capitalize;
		}
		.letter .left {
			text-align: left;
		}
		.letter .center {
			text-align: center;
		}
		.letter .right {
			text-align: right;
		}
		.letter .break {
			page-break-before: always;
			margin-top: 25px;
		}
		.letter .divider {
			width: 5px;
			vertical-align: top;
		}
		.letter .no-padding {
			padding: 0px;
		}
		.letter .fit {
			max-width:100%;
			white-space:nowrap;
		}
		.letter .absolute-center {
			margin: auto;
			position: absolute;
			top: 0; left: 0; bottom: 0; right: 0;
		}
		.letter .top {
			vertical-align: top;
		}
		.letter .bottom {
			vertical-align: bottom;
		}
		.letter .line {
		    height:0.9em;
		    margin: 20px;
		   
		}
		.letter .left{
		   	float:left;
		    clear:both;
		}
		.letter .dotted{
		    border-bottom: 2px dotted black;
		}

		.letter p{
		    display: inline;
		}

		.left,.right{
		    /*padding:3px;*/
		    background:#fff;
		    float:right;
		    margin: 0px;
		}
		.letter .box {
			width:30px;
			height:20px;
			border:1px solid #000;
		}

		.letter .white {
			background-color: white;
		}

		.letter span.a {
		    display: inline; 
		    height: 50px; 
		    background-color: white;
		    border: 1px black; 
		    text-align: left;
		}

		.letter .num {
			width: 10%; 
			text-align: right; 
		}

		.letter .federation {
			vertical-align: bottom;
		}

		.letter .border {
			border: 1px solid black;
		}

	</style>
</head>

<body class="letter">
   	<div style="margin-top: 70px;">
	    <span>{{ $pp30->tenure->entity->name }}</span><br>
		<span>
			@if($pp30->address)
				{{ $pp30->address->address1 ? $pp30->address->address1.',<br>' : '' }}
				{{ $pp30->address->address2 ? $pp30->address->address2.',<br>' : '' }}
				{{ $pp30->address->address3 ? $pp30->address->address3.',<br>' : '' }}
				{{ $pp30->address->postcode ? $pp30->address->postcode : '' }}
				{{ $pp30->address->district ? $pp30->address->district->name.',' : '' }}
				{{ $pp30->address->state ? $pp30->address->state->name.'.' : '' }}
			@endif
		</span><br><br>
	</div>
	<hr>

	<div>
		<span>Kepada: </span>
		<table>
			<tr>
				<td>
					YB Menteri Sumber Manusia Tarikh :<br>
					Block D3 & D4, Complex D,<br>
					62502, PUTRAJAYA
				</td>
				<td style="text-align: right;">Tarikh: {{ date('d/m/Y', strtotime($pp30->applied_at)) }}</td>
			</tr>
			<tr>
				<td colspan="2">
					<br>
					Yang Berhormat,<br><br>
					<span class="bold uppercase">PERMOHONAN PENGECUALIAN DARIPADA SEKSYEN 28(1)(a) DI BAWAH SEKSYEN 30(b) AKTA KESATUAN SEKERJA 1959</span><br><br>
					Dengan hormatnya merujuk kepada perkara di atas.<br><br>

					2. &nbsp;&nbsp;&nbsp;Adalah dengan ini, Kesatuan <span class="dotted">{{ $pp30->tenure->entity->name }}</span> ingin memohon Pengecualian di bawah Seksyen 30(b) Akta Kesatuan Sekerja 1959.<br><br>

					3. &nbsp;&nbsp;&nbsp;Berikut adalah butiran-butiran permohonan :
			  			<br><br>
			  			<div style="padding-left: 15px;">
			  				Nama Kesatuan : {{ $pp30->tenure->entity->name }}<br>
			  				Tarikh Pemilihan : {{ $pp30->tenure->entity->name }}<br>
			  				Tempoh/Penggal Pemilihan Yang Dipohon :{{ $pp30->requested_tenure->start_year }} - {{ $pp30->requested_tenure->end_year }}<br>
			  				Bilangan Majlis Jawatankuasa Kerja mengikut kewarganegaraan :
			  				<table>
			  					<tr>
			  						<td width="30%">i) Warganegara</td>
			  						<td width="5%"><div class="box center">{{ $pp30->total_citizen }}</div></td>
			  						<td> orang</td>
			  					</tr>
			  					<tr>
			  						<td>ii) Bukan Warganegara</td>
			  						<td><div class="box center">{{ $pp30->total_non_citizen }}</div></td>
			  						<td> orang</td>
			  					</tr>
			  				</table>
			  			</div>
			  			<br><br>

			  		4. &nbsp;&nbsp;&nbsp;Maklumat Pegawai Yang Memohon Pengecualian :
			  		<table>
			  			<tr class="bold top">
			  				<td width="40%">Nama Pegawai</td>
			  				<td>Nombor Passport /<br>Negara Asal /<br>Kad Pengenalan (PR)</td>
			  				<td width="30%">Jawatan</td>
			  			</tr>
			  			@foreach($pp30->officers as $index => $officer)
			  			<tr>
			  				<td>{{ $officer->officer->name }}</td>
			  				<td>{{ $officer->officer->identification_no }}</td>
			  				<td>{{ $officer->officer->designation ? $officer->officer->designation->name : '' }}</td>
			  			</tr>
			  			@endforeach
			  		</table>
			  		<br><br>

			  		5. &nbsp;&nbsp;&nbsp;Saya dengan ini menyokong dan memperakukan permohonan ini.<br><br>
			  		Sekian, terima kasih.<br><br><br>

			  		Yang benar,<br><br><br>
			  		(.....................................................)<br>
			  		Presiden/ Yang Dipertua Kesatuan

				</td>
			</tr>
		</table>
	</div>
</body>
