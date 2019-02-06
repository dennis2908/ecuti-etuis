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
			padding: 10px;
			font-size: 18px;
			line-height: 1em;
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
			font-size: 20px;
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

		.letter .union {
			vertical-align: bottom;
		}

		.letter .border {
			border: 1px solid black;
		}

	</style>
</head>

<body class="letter">
   	<div class="center">
	    <span class='uppercase bold'>BORANG E</span><br><br>
		<span class="italic">AKTA KESATUAN SEKERJA, 1959</span><br>
		<span>(Seksyen 15 dan Peraturan 8)</span><br><br>
		<span class="bold">PERMOHONAN UNTUK MEMBATALKAN SIJIL PENDAFTARAN</span><br><br>
	</div>
	<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
		<span class="a">Nama kesatuan sekerja berdaftar</span> {{ $formieu->forme->tenure->entity->name }}
	</div>
	<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
		<span class="a">No Pendaftaran</span>  {{ $formieu->forme->tenure->entity->registration_no }}
	</div>
	<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
		<span class="a">Alamat ibu pejabat berdaftar </span> 
		@if($formieu->forme->address)
			{{ $formieu->forme->address->address1 ? $formieu->forme->address->address1.',' : '' }}
			{{ $formieu->forme->address->address2 ? $formieu->forme->address->address2.',' : '' }}
			{{ $formieu->forme->address->address3 ? $formieu->forme->address->address3.',' : '' }}
			{{ $formieu->forme->address->postcode ? $formieu->forme->address->postcode : '' }}
			{{ $formieu->forme->address->district ? $formieu->forme->address->district->name.',' : '' }}
			{{ $formieu->forme->address->state ? $formieu->forme->address->state->name.'.' : '' }}
		@endif
	</div>
	<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
		<span class="a">Bertarikh pada <span class="dotted"></span> haribulan </span>  
	</div>
	<div class="line" style="padding-bottom: 5px; text-align: left;">
		<span class="a">Kepada Penolong Pengarah Kesatuan Sekerja *</span>  
	</div>
	<table>
		<tr>
			<td class="justify">
				<div style="text-indent: 90px">Kesatuan Sekerja yang disebutkan di atas dalam satu mesyuarat agung+ yang diadakan pada <span style="border-bottom: 1px solid"></span> haribulan <span style="border-bottom: 1px solid"></span>.
				</div>

				<div style="text-indent: 90px">Kami dengan itu memohon agar sijil pendaftarannya dibawah Akta Kesatuan Sekerja 1959, boleh dibatalkan.
				</div>

				<div style="text-indent: 90px">No perakuan pendaftaran <span style="border-bottom: 1px solid">{{ $formieu->forme->tenure->entity->registration_no }}</span> dilampirkan bersama.
				</div>

				<div style="text-indent: 90px">Kami mengesahkan bahawa kenyataan-kenyataan yang terkandung dalam permohonan ini adalah benar mengikut pengetahuan dan kepercayaan yang sebaik-baiknya.
				</div>
			</td>
		</tr>
	</table>
	<br>
	<table>
		<tr>
			<td colspan="2"></td>
			<td style="padding-top: 0px" class="center">Nama dan Alamat <br><i>(didalam huruf besar)</i></td>
		</tr>
		<tr>
			<td width="28%">Tandatangan Setiausaha: </td>
			<td width="15%" style="padding-top: 0px">
				<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
					<span class="a">1. </span>
				</div>
			</td>
			<td style="padding-top: 0px">
				<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
					<span class="a"></span>  {{ $formieu->forme->tenure->entity->user->name }}
				</div>
			</td>
		</tr>
		@foreach($formieu->forme->members as $index => $member)
		<tr>
			<td>Tandatangan Ahli-ahli: </td>
			<td style="padding-top: 0px">
				<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
					<span class="a">{{ $index+1 }}. </span>
				</div>
			</td>
			<td>
				<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
					<span class="a"></span> {{ $member->name }}
				</div>
			</td>
		</tr>
		@endforeach
	</table>
	<p>
		<small>
			* Permohonan mestilah dialamatkan kepada Penolong Pengarah kawasan yang mana bu pejabat kesatuan terletak<br>
			+ Jika tidak dalam satu mesyuarat agung, nyatakan dalam cara apakah permohonan itu ditentukan<br>
			+ Disini berikan salinan ketetapan yang sebenar.
		</small>
	</p>
</body>
