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
   	<div class="center">
		<span class="uppercase">BORANG WW<br>PEMBERITAHUAN PENGGABUNGAN KESATUAN SEKERJA DENGAN<br>BADAN PERUNDING DALAM MALAYSIA</span><br><br>
		<table>
		  	<tr class="top">
		  		<td width="30%">NAMA KESATUAN SEKERJA</td>
		  		<td>:</td>
		  		<td> {{ $formww->tenure->entity->name }}</td>
		  	</tr>
		  	<tr class="top">
		  		<td>NO PENDAFTARAN</td>
		  		<td>:</td>
		  		<td> {{ $formww->tenure->entity->registration_no }}</td>
		  	</tr>
		  	<tr class="top">
		  		<td>ALAMAT IBU PEJABAT</td>
		  		<td>:</td>
		  		<td> 
		  			@if($formww->address)
						{{ $formww->address->address1 ? $formww->address->address1.',' : '' }}
						{{ $formww->address->address2 ? $formww->address->address2.',' : '' }}
						{{ $formww->address->address3 ? $formww->address->address3.',' : '' }}
						{{ $formww->address->postcode ? $formww->address->postcode : '' }}
						{{ $formww->address->district ? $formww->address->district->name.',' : '' }}
						{{ $formww->address->state ? $formww->address->state->name.'.' : '' }}
					@endif
		  		</td>
		  	</tr>
		</table>
		<br>
		<span>NAMA BADAN PERUNDING</span><br>
		<span class="dotted">{{ $formww->consultation_name }}</span><br>
		<span>ALAMAT IBU PEJABAT</span><br>
		<span class="dotted">{{ $formww->consultation_address }}</span><br>
		<span>TUJUAN PENUBUHAN BADAN PERUNDING</span><br>
		<div style="text-align: left;"> 
		@foreach($formww->purposes as $index => $purpose)
			{{ $index+1 }} . <span class="dotted">{{ $purpose->purpose }}</span><br>
		@endforeach
		</div>
		<br><br>
		<span style="text-decoration: underline;">JADUAL</span><br>
		<span>MAKLUMAT PEGAWAI UTAMA BADAN PERUNDING</span><br>
		<table class="border" style="border-collapse: collapse;">
		  	<tr class="border" style="border-collapse: collapse;">
				<td class="center border">Jawatan</td>
				<td class="center border">Nama</td>
				<td class="center border">Tarikh<br>Lahir</td>
				<td class="center border">Alamat</td>
				<td class="center border">Pekerjaan</td>
			</tr>
			@foreach($formww->officers as $index => $officer)
			<tr class="border" style="border-collapse: collapse;">
				<td class="border">{{ $officer->designation ? $officer->designation->name : '' }}</td>
				<td class="border">{{ $officer->name }}</td>
				<td class="border">{{ date('d/m/Y', strtotime($officer->date_of_birth)) }}</td>
				<td class="border">
					@if($officer->address)
						{{ $officer->address->address1 ? $officer->address->address1.',' : '' }}
						{{ $officer->address->address2 ? $officer->address->address2.',' : '' }}
						{{ $officer->address->address3 ? $officer->address->address3.',' : '' }}
						{{ $officer->address->postcode ? $officer->address->postcode : '' }}
						{{ $officer->address->district ? $officer->address->district->name.',' : '' }}
						{{ $officer->address->state ? $officer->address->state->name.'.' : '' }}
					@endif
				</td>
				<td class="border">{{ $officer->occupation }}</td>
			</tr>
			@endforeach
		</table>
	</div>
</body>
