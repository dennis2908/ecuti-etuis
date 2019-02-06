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
	@foreach($formk->formu as $formu)
	<div class="justify">
		NOTA-Keputusan ini mestilah dikemukakan dalam tiga salinan kepada Pengarah/Penolong Pengarah kawasan di mana ibu pejabat kesatuan sekerja berdaftar atau cawangan kesatuan, mengikut mana yang berkenaan, terletak oleh setiausaha kesatuan sekerja dalam empat belas hari selepas mengambil undian sulit
	</div>
	<br>
   	<div class="center">
	    <span class='uppercase'>BORANG U</span><br><br>
		<span class='uppercase italic'>AKTA KESATUAN SEKERJA, 1959</span><br>
		<span>(Seksyen 40 dan Peraturan 26)</span><br><br>
	</div>

	<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
		<span class="a">Nama kesatuan sekerja berdaftar</span> {{ $formk->tenure->entity->name }}
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
	<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
		<span class="a">Nama dan alamat cawangan (jika terpakai) </span> 
	</div>
	<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
		<span class="a"></span> 
	</div>
	<table>
	    <tr>
	  		<td colspan="4">
	  			<div class="center uppercase" style="padding-top: 0px">PENYATA KEPUTUSAN UNDI</div>
	  		</td>
	  	</tr>
	  	<tr class="top">
	  		<td width="10%">Ketetapan</td>
	  		<td  colspan="3" class="justify">
	  			<span class="dotted">{{ $formu->setting }}</span>
	  		</td>
	  	</tr>
	  	<tr>
	  		<td colspan="4" class="justify"> 
	  			<div style="text-indent: 90px">Kami mengesahkan bahawa suatu undi sulit telah diambil dengan sempurna pada ketetapan di atas/pemilihan pegawai-pegawai* pada <span class="dotted">{{ strftime('%e', strtotime($formu->voted_at)) }}</span> haribulan <span class="dotted">{{ strftime('%B', strtotime($formu->voted_at)).' '.strftime('%Y', strtotime($formu->voted_at)) }}</span>.Keputusan adalah seperti berikut.</div>
	  		</td>
	  	</tr>
	  	<tr>
			<td></td>
			<td colspan="4">
				Jumlah bilangan anggota-anggota yang berhak untuk mengundi <span class="dotted" style="width: 100px">{{ $formu->total_voters }}</span> <br>
				Jumlah bilangan kertas undi yang dikeluarkan <span class="dotted" style="width: 100px">{{ $formu->total_voters }}</span>  <br>
				Jumlah bilangan kertas undi yang dipulangkan <span class="dotted" style="width: 100px">{{ $formu->total_slips }}</span>  <br>
			</td>
		</tr>
		<tr>
			<td style="vertical-align: top;"><br> * </td>
			<td colspan="3">
				Undi-undi yang ditolak (seperti dalam jadual)** <br>
				Dalam hal ketetapan: <br><br>
				Undi-undi menyokong <span class="dotted" style="width: 100px">{{ $formu->total_supporting }}</span> <br>
				Undi-undi menentang <span class="dotted" style="width: 100px">{{ $formu->total_against }}</span>
			</td>
		</tr>
		<tr>
			<td colspan="2" width="25%">Peratusan undi-undi : </td>
			<td width="25%" class="center">
				Undi-undi menyokong
				<hr style="border: 1px solid grey;">
				Jumlah bilangan anggota-anggota<br>yang berhak untuk mengundi
			</td>
			<td class="left"> % </td>
		</tr>
		<tr>
			<td colspan="2">Maka ketetapan adalah : </td>
			<td class="center" >
				Menang *
				<hr style="border: 1px solid grey;">
				Kalah
			</td>
			<td></td>
		</tr>
		<tr>
			<td style="vertical-align: top;">* </td>
			<td colspan="3">
				Dalam hal pemilihan pegawai-pegawai:
			</td>
		</tr>
		<tr>
			<td colspan="4">
				<p style="text-indent: 80px;">
					Suatu penyata dilampirkan menunjukkan nama-nama kesemua calon dan undi-undi yang telah diambil berkenaan dengan setiap orang bertentang dengan namanya.
				</p>
				<table>
					<tr class="center">
						<td></td>
						<td width="50%">Nama</td>
						<td width="25%">Tandatangan</td>
					</tr>
					<tr>
						<td>
							Pemeriksa-pemeriksa
						</td>
						<td>
							@foreach($formu->examiners as $index => $examiner)
							<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
								<span class="a">{{ $index+1 }}. &nbsp;</span> {{ $examiner->name }}
							</div>
							@endforeach	
						</td>
						<td>
							@foreach($formu->examiners as $index => $examiner)
							<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
								<span class="a"></span>  
							</div>
							@endforeach
						</td>
					</tr>
					<tr>
						<td>
							<div class="line" style="padding-bottom: 5px; text-align: left;">
								<span class="a">Presiden</span>  
							</div>
							<div class="line" style="padding-bottom: 5px; text-align: left;">
								<span class="a">Setiausaha</span>  
							</div>
							<div class="line" style="padding-bottom: 5px; text-align: left;">
								<span class="a">Bendahari</span>  
							</div>
						</td>
						<td>
							<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
								<span class="a"></span>  
							</div>
							<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
								<span class="a"></span>  
							</div>
							<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
								<span class="a"></span>  
							</div>	
						</td>
						<td>
							<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
								<span class="a"></span>  
							</div>
							<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
								<span class="a"></span>  
							</div>
							<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
								<span class="a"></span>  
							</div>	
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="4">Tarikh <span class="dotted">{{ date('d/m/Y')  }}</span>.</td>
		</tr>
	</table>

	<div class="center" style="page-break-after: always;">
		<hr style="border: 0.5px solid black;">
		<span class="italic left">
			<small>
				* Potong yang mana tidak diperlukan<br>
				** Jika mana-mana undi ditolak, suatu jadual mestilah dilampirkan oleh pemerhati-pemerhati, menyatakan sebab-sebab undi-undi masing-masing telah ditolak dan bilangan undi-undi yang ditolak bagi setiap sebab-sebab tersebut.
			</small>
		</span>

	</div>
	@endforeach

</body>
