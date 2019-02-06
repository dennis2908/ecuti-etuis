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
	    <span class='uppercase bold'>BORANG F</span><br><br>
		<span class="italic">AKTA KESATUAN SEKERJA, 1959</span><br>
		<span>(Seksyen 15(2A) dan Peraturan 10)</span><br><br>
	</div>
	<span>Pejabat Pengarah Kesatuan Sekerja<br><span class="dotted"></span></span>
	<div class="center">
	    <h1>NOTIS SEBELUM PEMBATALAN SIJIL PENDAFTARAN DI<br> BAWAH SEKSYEN 15(1)(b) AKTA<br>KESATUAN SEKERJA</h1><br><br>
	</div>
	<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
		<span class="a">Nama kesatuan sekerja </span> {{ $formf->tenure->entity->name }}
	</div>
	<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
		<span class="a">No Pendaftaran</span>  {{ $formf->tenure->entity->registration_no }}
	</div>
	<table>
		<tr>
			<td class="justify">
				<div style="text-indent: 90px">Dengan ini notis adalah diberikan di bawah seksyen 15(2A) Akta Kesatuan Sekerja 1959, kepada kesatuan sekerja yang disebutkan di atas bahawa ia adalah tujuan Ketua Pengarah untuk meneruskan pada <span class="dotted"> {{ strftime('%e' , strtotime($formf->resolved_at)) }} </span> haribulan <span class="dotted"> {{ strftime('%B', strtotime($formf->resolved_at)).' '.strftime('%Y', strtotime($formf->resolved_at)) }} </span> untuk membatalkan sijil pendaftaran kesatuan sekerja melainkan dibuktikan sebab yang sebaliknya sebelumnya, di bawah peruntukan seksyen 15(1)(b)( )/ 15(2)(a) bahawa:<br><br>
				Alasan pembatalan yang dicadangkan adalah : †
				</div>

				<div style="text-indent: 90px">Alasan-alasan bagi Ketua Pengarah mencadangkan untuk bertindak mengikut sebagaimana yang disebutkan terdahulu adalah:
				</div>
			</td>
		</tr>
	</table>
	<br>
	<table>
		<tr>
			<td></td>
			<td width="30%" class="center">
				.....................................<br>
				<i>Ketua Pengarah Kesatuan Sekerja</i>
			</td>
		</tr>
	</table>
	<br>
	<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
		<span class="a">Setiausaha </span>  
	</div>
	<div class="center"><small>({{ $formf->tenure->entity->name }})</small></div>
	<div>Alamat ibu pejabat Kesatuan yang didaftarkan 
		<span class="dotted">
		@if($formf->address)
			{{ $formf->address->address1 ? $formf->address->address1.',' : '' }}
			{{ $formf->address->address2 ? $formf->address->address2.',' : '' }}
			{{ $formf->address->address3 ? $formf->address->address3.',' : '' }}
			{{ $formf->address->postcode ? $formf->address->postcode : '' }}
			{{ $formf->address->district ? $formf->address->district->name.',' : '' }}
			{{ $formf->address->state ? $formf->address->state->name.'.' : '' }}
		@endif
		</span>
	</div>
	<br>
	<small>
		* Tarikh yang dimasukkan ke dalamnya tidak boleh kurang daripada tiga puluh hari dari tarikh notis.<br>
		+Fakta-fakta patut dinyatakan secara ringkas, jika praktik
	</small>
</body>
