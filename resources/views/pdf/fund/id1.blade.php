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
	<div style="text-align: right;" class="bold uppercase">LAMPIRAN ID1</div>
	<br>
	<table style="width: 100%;">
		<tr class="center">
			<td colspan="2">
				<img src="https://vectorise.net/vectorworks/logos/Malaysia%20&%20Negeri/download/Lambang%20Malaysia%20Black.png" height="80px" width="100px;">
				<br><br>
				<div class="main">
					JABATAN HAL EHWAL KESATUAN SEKERJA
					<div class="title" style="padding-top: 10px;">
						BORANG KUTIPAN DANA
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<ol style="list-style-type: decimal;">
					<li>Nama Kesatuan : {{ $fund->tenure->entity->name }}</li>
					<li>Alamat berdaftar kesatuan sekerja :  {{ $fund->tenure->entity->name }}

					</li>
					<li>
						Nama dan alamat cawangan kesatuan :<br>
						(Jika kutipan ini dibuat bagi maksud sesuatu cawangan sahaja)
					</li>
					<li>Tujuan Kutipan :  {{ $fund->objective }}</li>
					<li>Jumlah sasaran pungutan wang yang dirancang : RM {{ $fund->target_amount }}</li>
					<li>Jumlah anggaran perbelanjaan aktiviti yang dirancang : RM {{ $fund->estimate_expenses }}</li>
					<li>
						Tempoh kutipan wang itu akan dilakukan : Dari tarikh <span style="border-bottom: 1px solid"> {{ date('d/m/Y', strtotime($fund->start_date)) }} </span> Sehingga tarikh <span style="border-bottom: 1px solid"> {{ date('d/m/Y', strtotime($fund->end_date)) }} </span><br>
						**Tempoh kutipan tidak melebihi 6bulan
					</li>
					<li>Tarikh kelulusan kutipan wang Persidangan Perwakilan/Mesyuarat Agung : {{ date('d/m/Y', strtotime($fund->resolved_at)) }} </li>
					<li>Kuorum Mesyurat Agung/Perwakilan : {{ $fund->quorum }}</li>
					<li>Sebutkan cara dana/wang dipungut (misalnya derma, jualan iklan/meja, jualan tiket dan lain-lain.) : {{ $fund->method }}</li>
					<li>Adakah seseorang yang bukan ahli kesatuan ataupun dari agensi luar terlibat dalam organisasi pungutan wang itu? Nyatakan nama dan butir-butir orang ataupun agensi berkenaan yang membuat pungutan jika ada.</li>
					<li>Senaraikan nama dan nombor kad pengenalan ahli-ahli kesatuan yang  diberi kuasa untuk melakukan pungutan wang itu mengikut Lampiran ID1.1.</li>
					<li>Nyatakan kelulusan kutipan dana terdahulu yang pernah dibuat oleh kesatuan mengikut tahun.
					</li>
					<li>Baki Bank Terkini : RM </li>
				</ol>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<span class="justify">
					Saya <span style="border-bottom: 1px solid"> {{ $fund->tenure->entity->user->name }} </span> kad pengenalan <span style="border-bottom: 1px solid"> {{ $fund->tenure->entity->user->identification_no }} </span> mengesahkan bahawa keputusan untuk melancarkan kutipan tersebut telah diluluskan dalam Mesyuarat Majlis Jawatankuasa yang diadakan pada <span style="border-bottom: 1px solid"> </span> (cabutan minit mesyuarat berkenaan yang disahkan betul oleh Presiden Kesatuan adalah dikemukakan bersama-sama ini.)
				</span>
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

	<div style="text-align: right; page-break-before: always;" class="bold uppercase">LAMPIRAN ID1.1</div>
	<br>
	<table style="width: 100%;">
		<tr class="center">
			<td colspan="2">
				<img src="https://vectorise.net/vectorworks/logos/Malaysia%20&%20Negeri/download/Lambang%20Malaysia%20Black.png" height="80px" width="100px;">
				<br><br>
				<div class="main">
					JABATAN HAL EHWAL KESATUAN SEKERJA
					<div class="title" style="padding-top: 10px;">
						SENARAI AHLI-AHLI DIBERI KUASA UNTUK MELAKUKAN KUTIPAN WANG
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<table class="data">
					<tr class="data">
						<th>BIL</th>
						<th>NAMA</th>
						<th>JAWATAN<br>DALAM KESATUAN</th>
						<th>NO. KAD<br>PENGENALAN</th>
						<th>NO. TEL<br>BIMBIT/PEJABAT</th>
					</tr>
					@foreach($fund->participants as $participant)
					<tr class="data">
						<th>{{ $index+1 }}</th>
						<th>{{ $participant->name }}</th>
						<th>{{ $participant->designation ? $participant->designation->name : '' }}</th>
						<th>{{ $participant->identification_no }}</th>
						<th>{{ $participant->phone_no }}</th>
					</tr>
					@endforeach
				</table>
			</td>
		</tr>
	</table>

</body>
