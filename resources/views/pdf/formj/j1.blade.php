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
			margin-left: 25px;
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
	    <span class='uppercase bold'>BORANG J</span><br><br>
		<span><span class="italic">AKTA KESATUAN SEKERJA, 1959</span><br>(Seksyen 37(2) dan Peraturan 15)</span><br><br>
		<span class="italic">NOTIS PERTUKARAN PEJABAT SUATU KESATUAN SEKERJA<br>YANG DIDAFTARKAN</span><br><br>
	</div>

	<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
		<span class="a">Nama kesatuan sekerja berdaftar</span>  {{ $formj->tenure->entity->name }}
	</div>
	<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
		<span class="a">No. Pendaftaran </span>  {{ $formj->tenure->entity->registration_no }}
	</div>
	<div class="dotted line" style="padding-bottom: 5px; text-align: left;margin-bottom: 5px;">
		<span class="a">Alamat ibu pejabat berdaftar</span> 
		@if($formj->address)
			{{ $formj->address->address1 ? $formj->address->address1.',' : '' }}
			{{ $formj->address->address2 ? $formj->address->address2.',' : '' }}
			{{ $formj->address->address3 ? $formj->address->address3.',' : '' }}
			{{ $formj->address->postcode ? $formj->address->postcode : '' }}
			{{ $formj->address->district ? $formj->address->district->name.',' : '' }}
			{{ $formj->address->state ? $formj->address->state->name.'.' : '' }}
		@endif
	</div>
	<div class="dotted line" style="padding-bottom: 5px; padding-top: 15px; text-align: left;">
		<span class="a">Bertarikh pada <span class="dotted">{{ strftime('%e', strtotime($formj->applied_at)) }}</span> haribulan </span> {{ strftime('%B', strtotime($formj->applied_at)).' '.strftime('%Y', strtotime($formj->applied_at)) }}
	</div>
	<div class=" line" style="padding-bottom: 5px; text-align: left;">
		<span class="a">Kepada Penolong Pengarah Kesatuan Sekerja* </span> {{ $formj->province_office ? $formj->province_office->name : '' }}
	</div>
	<div>
		<table>
		    <tr>
		  		<td colspan="2">
		  			<div style="text-indent: 90px">Notis dengan ini diberi bahawa ibu pejabat kesatuan sekerja yang disebutkan di atas telah dipindahkan dari <span class="dotted">
		  				@if($formj->address)
							{{ $formj->address->address1 ? $formj->address->address1.',' : '' }}
							{{ $formj->address->address2 ? $formj->address->address2.',' : '' }}
							{{ $formj->address->address3 ? $formj->address->address3.',' : '' }}
							{{ $formj->address->postcode ? $formj->address->postcode : '' }}
							{{ $formj->address->district ? $formj->address->district->name.',' : '' }}
							{{ $formj->address->state ? $formj->address->state->name : '' }}
						@endif
		  			</span> dan sekarang terletak di <span class="dotted">
		  				@if($formj->new_address)
							{{ $formj->new_address->address1 ? $formj->new_address->address1.',' : '' }}
							{{ $formj->new_address->address2 ? $formj->new_address->address2.',' : '' }}
							{{ $formj->new_address->address3 ? $formj->new_address->address3.',' : '' }}
							{{ $formj->new_address->postcode ? $formj->new_address->postcode : '' }}
							{{ $formj->new_address->district ? $formj->new_address->district->name.',' : '' }}
							{{ $formj->new_address->state ? $formj->new_address->state->name : '' }}
						@endif
		  			</span>.</div>
		  		</td>
		  	</tr>
		  	<tr>
		  		<td colspan="2">
		  			<div style="text-indent: 90px">Persetujuan Eksekutif telah diperoleh pada suatu <span class="dotted"> {{ $formj->meeting_type ? $formj->meeting_type->name : '' }}</span> yang diadakan pada <span class="dotted">{{ date('d/m/Y', strtotime($formj->resolved_at)) }}</span>.</div>
		  		</td>
		  	</tr>
		</table>

	  	<table>
	  		<tr>
	  			<td class="center">
	  				...........................................<br>
	  				<span class="italic">Presiden</span>
	  			</td>
	  			<td class="center">
	  				...........................................<br>
	  				<span class="italic">Bendahari</span>
	  			</td>
	  			<td class="center">
	  				...........................................<br>
	  				<span class="italic">Tandatangan Setiausaha</span>
	  			</td>
	  		</tr>
	  		<tr>
	  			<td colspan="3">
	  				<hr style="border:1px solid">
				  	<p>
				  		Diterima pada <span class="dotted">{{ strftime('%e', strtotime($formj->applied_at)) }}</span> haribulan <span class="dotted">{{ strftime('%B', strtotime($formj->applied_at)).' '.strftime('%Y', strtotime($formj->applied_at)) }}</span> notis pemindahan pejabat berdaftar kesatuan  <span class="dotted">{{ $formj->tenure->entity->name }}</span> No. Pendaftaran  <span class="dotted">{{ $formj->tenure->entity->registration_no }}</span> kepada <span class="dotted">{{ $formj->tenure->entity->name }}</span>
				  	</p>
	  			</td>
	  		</tr>
	  		<tr>
	  			<td colspan="2"></td>
	  			<td class="center" style="padding-top: 15px;">
	  				...........................................<br>
	  				<span class="italic">Tandatangan Ketua Pengarah Kesatuan<br>Sekerja</span>
	  			</td>
	  		</tr>
	  	</table>

		<hr style="border:1px solid">
	  	<p class="italic">
	  		<small>
	  			*Notis ini mestilah dialamatkan kepada Penolong Pengarah kawasan di mana ibu pejabat kesatuan itu terletak<br>
				NOTA - Permohonan ini mestilah dihantar kepada Pengarah/Penolong Pengarah kawasan di mana ibu pejabat kesatuan sekerja terletak oleh setiausaha kesatuan dalam 30 hari selepas membuat kaedah-kaedah baru atau pengubahan kaedah-kaedah.
	  		</small>
	  	</p>
	  </div>

</body>
