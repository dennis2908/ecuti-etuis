<head>
	<style>

		.letter {
			font-family: Tahoma !important;
			margin-left: 50px;
			padding-top: 50px;
		}
		.letter div {
			font-size: 18px;
			font-family: Tahoma !important;
			margin: 20px;
		}

		.letter table {
			width: 100%;
			margin-top: 20px;
		}
		.letter td, th {
			font-family: Tahoma !important;
			padding: 10px;
			font-size: 18px;
			line-height: 1.5em;
		}

		.letter span, a, p, h1, h2 {
			font-family: Tahoma !important;
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
		.letter .line {
		    height:1.5em;
		}
		.letter .left{
		    text-align: left;
		}
		.letter .dotted{
		    border-bottom: 2px dotted black;
		    margin-bottom:3px;
		}
		.letter .box {
			width:30px;
			height:20px;
			border:1px solid #000;
		}
	</style>
</head>

<body class="letter">
	<div class="center">
		<span class='head letter'>BORANG PRAECIPE</span><br>
		<span class='head letter'>PERATURAN-PERATURAN KESATUAN SEKERJA 1959</span><br>
		<span class='head letter'>PERATURAN 36</span><br><br>
	</div>

	<table>
		<tr>
			<td class="top" style="width: 3%">*</td>
			<td class="top" style="width: 50%">Permohonan untuk pendaftaran Kesatuan Sekerja atau Persekutuan Kesatuan Sekerja</td>
			<td class="top" style="width: 20%">RM30.00</td>
		</tr>
		<tr style="vertical-align: top">
			<td>*</td>
			<td>Permohonan untuk pendaftaran pindaan peraturan-peraturan atau peraturan baru</td>
			<td>RM10.00</td>			
			<td rowspan="8"  style="width: 20%; vertical-align: center !important">
				<div class="center border" style="padding: 10px">
					Lekatkan setem hasil disini
				</div>
			</td>
		</tr>
		<tr style="vertical-align: top">
			<td>*</td>
			<td>Mengemukakan notis pertukaran pegawai-pegawai atau pekerja-pekerja yang digajikan</td>
			<td>RM1.00</td>
		</tr>
		<tr style="vertical-align: top">
			<td>*</td>
			<td>Mengemukakan notis pertukaran alamat berdaftar kesatuan</td>
			<td>RM5.00</td>
		</tr>
		<tr class="bold" style="vertical-align: top">
			<td>*</td>
			<td>Mengemukakan notis pertukaran nama Kesatuan Sekerja</td>
			<td>RM5.00</td>
		</tr>
		<tr style="vertical-align: top">
			<td>*</td>
			<td>Pemeriksaan Daftar oleh seseorang </td>
			<td>RM10.00</td>
		</tr>
		<tr style="vertical-align: top">
			<td>*</td>
			<td>Pemeriksaan oleh seseorang ke atas dokumen-dokumen di dalam simpanan Ketua Pengarah</td>
			<td>RM2.00<br>satu dokumen</td>
		</tr>
		<tr style="vertical-align: top">
			<td>*</td>
			<td>Permintaan untuk salinan atau cabutan dari dokumen di dalam simpanan Ketua Pengarah</td>
			<td>RM5.00<br> satu dokumen</td>
		</tr>
	</table>

	<div class="left">Yuran dibayar dengan setem yang belum dibatalkan <strong>RM 5.00</strong></div>
	<div class="left">Nama Kesatuan Sekerja <strong>{{ $formg->tenure->entity->name }}</strong></div><br><br><br>
	<table>
		<tr>
			<td></td>
			<td style="width: 30%" class="center">
				..................................................<br>
				Tandatangan Setiausaha 
			</td>
		</tr>
	</table>

</body>