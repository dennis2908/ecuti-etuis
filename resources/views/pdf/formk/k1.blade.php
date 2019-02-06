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
			font-size: 20px;
			font-family: Times, Times New Roman, Georgia, serif !important;
			
		}

		.letter table {
			width: 100%;
			margin-top: 20px;
		}
		.letter td, th {
			font-family: Times, Times New Roman, Georgia, serif !important;
			padding: 10px;
			font-size: 20px;
			line-height: 1.5em;
		}

		.letter span, a, p, h1, h2 {
			font-family: Times, Times New Roman, Georgia, serif !important;
		}

		.letter span, a, p {
			font-size: 20px;
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
	</style>
</head>

<body class="letter">
   	<div class="center">
	    <span class='uppercase'>BORANG K</span><br><br>
		<span class='uppercase italic'>AKTA KESATUAN SEKERJA, 1959</span><br>
		<span>(Seksyen 38(3) dan Peraturan 16)</span><br><br>
	</div>

	<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
		<span class="a">Nama kesatuan sekerja berdaftar</span>   {{ $formk->tenure->entity->name }}
	</div>
	<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
		<span class="a">No. Pendaftaran </span>  {{ $formk->tenure->entity->registration_no }}
	</div>
	<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
		<span class="a">Alamat ibu pejabat berdaftar </span> 
		@if($formk->address)
			{{ $formk->address->address1 ? $formk->address->address1.',' : '' }}
			{{ $formk->address->address2 ? $formk->address->address2.',' : '' }}
			{{ $formk->address->address3 ? $formk->address->address3.',' : '' }}
			{{ $formk->address->postcode ? $formk->address->postcode : '' }}
			{{ $formk->address->district ? $formk->address->district->name.',' : '' }}
			{{ $formk->address->state ? $formk->address->state->name.'.' : '' }}
		@endif
	</div>
	<div class="dotted line" style="padding-bottom: 5px; padding-top: 15px; text-align: left;">
		<span class="a">Kepada Pengarah / Penolong Pengarah* Kesatuan </span> {{ $formk->tenure->entity->province_office->name }}
	</div>
	<table>
	    <tr>
	  		<td colspan="2">
	  			<div class="center uppercase" style="padding-top: 0px">PERMOHONAN BAGI PENDAFTARAN KAEDAH-KAEDAH BARU ATAU <br>PERUBAHAN KAEDAH-KAEDAH</div>
	  		</td>
	  	</tr>
	  	<tr>
	  		<td colspan="2" class="justify">
	  			Saya <span class="dotted">{{ $formk->tenure->entity->user->name }}</span>, yang bertandatangan di bawah, Setiausaha kesatuan sekerja yang disebut di atas memohon untuk pendaftaran kaedah/kaedah-kaedah baru/ pengubahan* kaedah-kaedah kesatuan, tiga salinannya dilampirkan bersama ini.
	  		</td>
	  	</tr>
	  	<tr>
	  		<td colspan="2" class="justify"> 
	  			<span>2. &nbsp;&nbsp; Saya juga melampirkan satu salinan bercetak kaedah-kaedah berdaftar yang bertanda untuk menunjukkan di mana dan dalam cara mana kaedah-kaedah itu diubah.
	  		</td>
	  	</tr>
	  	<tr>
	  		<td colspan="2" class="justify"> 
	  			<span>3. &nbsp;&nbsp; Saya telah diberi kuasa dengan sewajarnya oleh kesatuan sekerja untuk membuat permohonan ini bagi pihaknya, pemberian kuasa itu terdiri daripada suatu ketetapan* yang telah diambil secara undi sulit (Suatu keputusan undi berkenaan dengan ketetapan yang telah diluluskan adalah dikembarkan)/* yang telah diluluskan di suatu {{ $formk->meeting_type ? $formk->meeting_type->name : '' }} pada <span class="dotted">{{ strftime('%e', strtotime($formk->resolved_at)) }}</span> haribulan <span class="dotted">{{ strftime('%B', strtotime($formk->resolved_at)).' '.strftime('%Y', strtotime($formk->resolved_at)) }}</span>.</span>
	  		</td>
	  	</tr>
	  	<tr>
	  		<td colspan="2" class="justify"> 
	  			<span>4. &nbsp;&nbsp; Saya mengaku bahawa dalam membuat pindaan-pindaan, kaedah-kaedah kesatuan yang sedia ada telah dipatuhi.</span>
	  		</td>
	  	</tr>
	</table>


	<table>
		<tr style="vertical-align: top">
			<td style="width: 60%; text-align: right;"></td>
			<td style="text-align: center;">
				...............................................<br>
				<i>Tandatangan Setiausaha</i>
			</td>
		</tr>
	</table>
	<p>Bertarikh pada <span class="dotted"> {{ strftime('%e') }} </span> haribulan <span class="dotted"> {{ strftime('%B').' '.strftime('%Y') }} </span></p><br>
	
	<hr style="border: 1px solid">
	<div class="center italic" style="font-size: 15px;">*Potong yang mana saja tidak sesuai</div> 

</body>
