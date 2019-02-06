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
			line-height: 1.5em;
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
	    <span class='uppercase bold'>BORANG PERMOHONAN KELULUSAN JURUAUDIT LUAR</span><br><br>
	</div>

	<table class="border" style="border-collapse: collapse;">
	  	<tr><td class="border center bold" colspan="2">BUTIRAN KESATUAN</td></tr>
	  	<tr>
	  		<td width="40%" class="border uppercase">Nama Kesatuan</td>
	  		<td class="border uppercase">{{ $formjl1->tenure->entity->name }}</td>
	  	</tr>
	  	<tr>
	  		<td class="border uppercase">No Pendaftaran Kesatuan</td>
	  		<td class="border uppercase">{{ $formjl1->tenure->entity->registration_no }}</td>
	  	</tr>
	</table>
	<br>
	<table class="border" style="border-collapse: collapse;">
	  	<tr><td class="border center bold" colspan="2">BUTIRAN JURUAUDIT LUAR</td></tr>
	  	<tr>
	  		<td width="40%" class="border uppercase">Nama Penuh Firma</td>
	  		<td class="border uppercase">{{ $formjl1->firm_name }}</td>
	  	</tr>
	  	<tr>
	  		<td class="border uppercase">No Pendaftaran Firma</td>
	  		<td class="border uppercase">{{ $formjl1->firm_registration_no }}</td>
	  	</tr>
	  	<tr>
	  		<td class="border uppercase">Nama Penuh Juruaudit</td>
	  		<td class="border uppercase">{{ $formjl1->auditor_name }}</td>
	  	</tr>
	  	<tr>
	  		<td class="border uppercase">No Kad Pengenalan</td>
	  		<td class="border uppercase">{{ $formjl1->auditor_identification_no }}<td>
	  	</tr>
	  	<tr>
	  		<td class="border uppercase">Alamat Firma</td>
	  		<td class="border uppercase">
	  			@if($formjl1->firm_address)
					{{ $formjl1->firm_address->address1 ? $formjl1->firm_address->address1.',' : '' }}
					{{ $formjl1->firm_address->address2 ? $formjl1->firm_address->address2.',' : '' }}
					{{ $formjl1->firm_address->address3 ? $formjl1->firm_address->address3.',' : '' }}
					{{ $formjl1->firm_address->postcode ? $formjl1->firm_address->postcode : '' }}
					{{ $formjl1->firm_address->district ? $formjl1->firm_address->district->name.',' : '' }}
					{{ $formjl1->firm_address->state ? $formjl1->firm_address->state->name.'.' : '' }}
				@endif
	  		</td>
	  	</tr>
	  	<tr>
	  		<td class="border uppercase">Tahun Audit</td>
	  		<td class="border">
	  			@foreach($formjl1_formn as $formn)
	  			{{ $formn->year }},
	  			@endforeach
	  		</td>
	  	</tr>
	</table>

</body>
