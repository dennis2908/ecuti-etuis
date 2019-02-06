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

	.letter ol,li {
		padding-left: 15px;
		line-height: 1.5em;
		font-size: 18px;
	}
	.letter .title {
		font-size: 24px;
		font-weight: bold;
	}
	.letter .main {
		background-color: grey;
		font-size: 28px;
		font-weight: bold;
		padding: 15px 0;
	}

	.letter table.data {
        width: 100%;
        margin-top: 20px;
        border-collapse: collapse;
    }

    .letter tr.data > td,th  {
        font-family: serif !important;
        font-size: 18px;
        line-height: 20px;
        border: 1px solid black;
        padding: 5px;
    }

</style>
</head>

<body class="letter">
	<div style="text-align: right;" class="bold uppercase">LAMPIRAN PLV1</div>
	<br>
	<table style="width: 100%;">
		<tr class="center">
			<td colspan="2">
				<img src="https://vectorise.net/vectorworks/logos/Malaysia%20&%20Negeri/download/Lambang%20Malaysia%20Black.png" height="80px" width="100px;">
				<br><br>
				<div class="main">
					JABATAN HAL EHWAL KESATUAN SEKERJA
					<div class="title" style="padding-top: 10px;">
						BORANG PERMOHONAN PENGENAAN LEVI
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<ol style="list-style-type: decimal;">
					<li>Nama Kesatuan : {{ $insurance->tenure->entity->name }}</li>
					<li>No. Pendaftaran : {{ $insurance->tenure->entity->registration_no }}</li>
					<li>Alamat berdaftar kesatuan sekerja : 
						@if($insurance->address)
							{{ $insurance->address->address1 ? $insurance->address->address1.',' : '' }}
							{{ $insurance->address->address2 ? $insurance->address->address2.',' : '' }}
							{{ $insurance->address->address3 ? $insurance->address->address3.',' : '' }}
							{{ $insurance->address->postcode ? $insurance->address->postcode : '' }}
							{{ $insurance->address->district ? $insurance->address->district->name.',' : '' }}
							{{ $insurance->address->state ? $insurance->address->state->name.'.' : '' }}
						@endif
					</li>
					<li>
						Nama dan alamat cawangan yang terlibat :<br>
						(jika permohonan Levi ini dibuat bagi maksud sesuatu cawangan sahaja)
						<span class="bold">{{ $insurance->branch->name }}</span>
						@if($insurance->branch->address)
							{{ $insurance->branch->address->address1 ? $insurance->branch->address->address1.',' : '' }}
							{{ $insurance->branch->address->address2 ? $insurance->branch->address->address2.',' : '' }}
							{{ $insurance->branch->address->address3 ? $insurance->branch->address->address3.',' : '' }}
							{{ $insurance->branch->address->postcode ? $insurance->branch->address->postcode : '' }}
							{{ $insurance->branch->address->district ? $insurance->branch->address->district->name.',' : '' }}
							{{ $insurance->branch->address->state ? $insurance->branch->address->state->name.'.' : '' }}
						@endif
					</li>
					<li>Tujuan pengenaan Levi : {{ $levy->objective }}</li>
					<li>Anggaran kutipan Levi : RM {{ $levy->estimate }}</li>
					<li>Mesyuarat yang meluluskan usul Levi/tarikh mesyuarat : </li>
					<li>Undi rahsia : 
						<ol style="list-style-type: lower-alpha;">
							<li>Tarikh Pengedaran</li>
							<li>Cara Pengedaran</li>
							<li>Tarikh Pengundian ditutup</li>
							<li>Tarikh Pengiraan</li>
							<li>Senarai nama Pemeriksa Kertas Undi</li>
							<li>Keputusan Undi
								<ol style="list-style-type: lower-roman;">
									<li>Jumlah Ahli yang berhak Mengundi :</li>
									<li>Jumlah Kertas Undi Rahsia Yang Dikeluarkan :</li>
									<li>Jumlah Kertas Undi Dikembalikan :</li>
									<li>Jumlah Kertas Undi Rosak :</li>
									<li>Jumlah Ahli Yang Menyokong :</li>
									<li>Jumlah Ahli Yang Menentang :</li>
									<li>Peratusan undi yang Menyokong :</li>
								</ol>
							</li>
						</ol>

					</li>
				</ol>
			</td>
		</tr>
		<tr>
			<td>Bertarikh pada :  </td>
			<td class="center">
				.......................................<br>
				Tandatangan Setiausaha
			</td>
		</tr>
	</table>

</body>
