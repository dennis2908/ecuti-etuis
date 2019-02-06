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

		#customers {
		    font-family: serif !important;
		    border-collapse: collapse;
		    font-size: 16px;
		    width: 100%;
		}

		#customers td, #customers th {
		    border: 1px solid #000;
		    padding: 8px;
		}

		#customers th {
		    padding-top: 12px;
		    padding-bottom: 12px;
		    text-align: center;
		    font-size: 16px;
		    background-color: #D5D3D2;
		    color: black;
		}

	</style>
</head>

<body class="letter center">
   	<div style="text-align: right;" class="bold uppercase">LAMPIRAN G3</div>
   	<div class="center bold uppercase">   		
		<span>PINDAAN PERATURAN/PENDAFTARAN PERATURAN BARU (BORANG G)</span><br>
		<span>NAMA KESATUAN:  {{ $formg->tenure->entity->name }} </span><br><br>
   	</div>


	<table id="customers">
		<tr>
			<th style="width: 3%">BIL</th>
			<th>NAMA ASAL</th>
			<th>PINDAAN NAMA</th>
			<th>JUSTIFIKASI KESATUAN</th>
		</tr>
		<tr>
			<td>1.</td>
			<td>{{ $formg->tenure->entity->name }}</td>
			<td>{{ $formg->name }}</td>
			<td>{{ $formg->justification }}</td>
		</tr>
		<tr>
			<td colspan="4">
				Tandatangan :<br>
				Nama Setiausaha Kesatuan Sekerja : {{ $formg->tenure->entity->user->name }}<br>
				Tarikh	: {{ date('d/m/Y', strtotime($formg->applied_at)) }}
			</td>
		</tr>
	</table>

</body>
