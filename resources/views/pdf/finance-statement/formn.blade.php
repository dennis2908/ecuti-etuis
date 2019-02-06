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

		.letter .border-grey {
			border: 1px solid grey;
		}

	</style>
</head>
<body class="letter">
   	<div class="center">
	    <span class='uppercase'>BORANG N</span><br><br>	    
		<span class="italic">AKTA KESATUAN SEKERJA , 1959</span><br>
		<span>(Seksyen 56(1) dan Peraturan 28)</span><br><br>
		<span>PENYATA TAHUNAN YANG DITETAPKAN DI BAWAH SEKSYEN 56(1) AKTA KESATUAN<br>SEKERJA DAN PERATURAN 28 BAGI TAHUN BERAKHIR 31HB MAC, 19.....</span><br><br>
	</div>
	<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
		<span class="a">Nama kesatuan sekerja berdaftar</span>  
	</div>
	<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
		<span class="a">Alamat ibu pejabat berdaftar </span> 
		@if($formn->address)
			{{ $formn->address->address1 ? $formn->address->address1.',' : '' }}
			{{ $formn->address->address2 ? $formn->address->address2.',' : '' }}
			{{ $formn->address->address3 ? $formn->address->address3.',' : '' }}
			{{ $formn->address->postcode ? $formn->address->postcode : '' }}
			{{ $formn->address->district ? $formn->address->district->name.',' : '' }}
			{{ $formn->address->state ? $formn->address->state->name.'.' : '' }}
		@endif
	</div>
	<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
		<span class="a">No perakuan pendaftaran</span>  
	</div>
	<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
		<span class="a">Tahun bagi mana penyata dikemukakan</span>  
	</div>
	<table>
		<tr>
			<td width="5%">1.</td>
			<td width="50%">Bilangan anggota-anggota dalam buku pada awal tahun</td>
			<td>
				<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
					<span class="a"></span>  
				</div>
			</td>
		</tr>
		<tr>
			<td></td>
			<td>Bilangan anggota-anggota dalam diterima masuk sepanjang tahun</td>
			<td>
				<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
					<span class="a"></span>  
				</div>
			</td>
		</tr>
		<tr>
			<td></td>
			<td>Bilangan anggota-anggota yang meninggalkan kesatuan sepanjang tahun</td>
			<td>
				<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
					<span class="a"></span>  
				</div>
			</td>
		</tr>
		<tr>
			<td></td>
			<td>Bilangan anggota-anggota dalam buku pada akhir tahun</td>
			<td>
				<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
					<span class="a"></span>  
				</div>
			</td>
		</tr>
		<tr>
			<td></td>
			<td class="right">Lelaki</td>
			<td>
				<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
					<span class="a"></span>  
				</div>
			</td>
		</tr>
		<tr>
			<td></td>
			<td class="right">Perempuan</td>
			<td>
				<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
					<span class="a"></span>  
				</div>
			</td>
		</tr>
	</table>

	<!-- /////////////////////////////// SECOND PAGE /////////////////////////////////////////////////////-->
	<div style="page-break-before: always;">

		<div class="center">
			<span class="uppercase">KLASIFIKASI ANGGOTA-ANGGOTA MENGIKUT FAEDAH<br>MELALUI BANGSA DAN JANTINA</span><br>
		</div>

		<table>
			<tr class="italic center">
				<td></td>
				<td>Melayu</td>
				<td>Cina</td>
				<td>India</td>
				<td>Lain-lain</td>
				<td>Jumlah</td>
			</tr>
			<tr>
				<td>Lelaki</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						<span class="a"></span>  
					</div>
				</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						<span class="a"></span>  
					</div>
				</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						<span class="a"></span>  
					</div>
				</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						<span class="a"></span>  
					</div>
				</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						<span class="a"></span>  
					</div>
				</td>
			</tr>
			<tr>
				<td>Perempuan</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						<span class="a"></span>  
					</div>
				</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						<span class="a"></span>  
					</div>
				</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						<span class="a"></span>  
					</div>
				</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						<span class="a"></span>  
					</div>
				</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						<span class="a"></span>  
					</div>
				</td>
			</tr>
		</table>
		<table>
			<tr class="top">
				<td width="5%">2.</td>
				<td>
					<span>Suatu penyata am yang diaudit mengikut cara yang ditetapkan bagi segala penerimaan dan pembayaran sepanjang tempoh 12 bulan berakhir pada <span class="dotted"></span> dan aset-aset dan liabiliti-liabiliti kesatuan sekerja seperti pada tarikh itu, bersama-sama dengan laporan auditor dilampirkan sebagai Penyata I.</span>
				</td>
			</tr>
			<tr class="top">
				<td>3.</td>
				<td>
					<span>Suatu salinan kaedah-kaedah Kesatuan Sekerja yang dibetulkan sehingga tarikh penyerahan penyata ini dilampirkan bersama dengan suatu salinan segala pengubahan atau pindaan kaedah-kaedah dan kesemua kaedah-kaedah baru yang telah diluluskan oleh kesatuan sekerja sepanjang masa tahun itu.</span>
				</td>
			</tr>
			<tr class="top">
				<td>4.</td>
				<td>
					<span>Suatu penyata bagi segala pertukaran pegawai-pegawai sepanjang masa tahun itu disertakan sebagai Penyata 2.</span>
				</td>
			</tr>
		</table>
		<table>
		<table>
			<tr style="vertical-align: top">
				<td style="width: 60%"><p>Bertarikh pada <span class="dotted"> {{ strftime('%e').' '.strftime('%B').' '.strftime('%Y') }} </span></p>
				</td>
				<td style="text-align: center;">
					<span>...............................................<br>
					Tandatangan Setiausaha</span>
				</td>
			</tr>
		</table>
	</div>

	<!-- /////////////////////////////// THIRD PAGE /////////////////////////////////////////////////////-->
	<div style="page-break-before: always;">

		<div class="center">
			<span>PENYATA "1"<br>(I) PENYATA PENERIMAAN DAN PEMBAYARAN</span><br>
		</div>
		<table width="100%">
			<tr>
				<td colspan="3" class="italic" style="border-bottom: 1px solid grey; border-top: 1px solid grey">Penerimaan</td>
				<td colspan="2" class="italic" style="border-bottom: 1px solid grey; border-top: 1px solid grey">Pembayaran</td>
			</tr>
			<tr>
				<td width="35%"></td>
				<td width="15%" class="center">RM sen</td>
				<td width="5%"></td>
				<td></td>
				<td width="15%" class="center">RM sen</td>
			</tr>
			<tr>
				<td>Baki pada awal tahun</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						<span class="a"></span>  
					</div>
				</td>
				<td></td>
				<td>
					Gaji,elaun-elaun dan perbelanjaan pegawai-pegawai.
				</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						<span class="a"></span>  
					</div>
				</td>
			</tr>
			<tr>
				<td>Fee kemasukan</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						<span class="a"></span>  
					</div>
				</td>
				<td></td>
				<td>Gaji,elaun-elaun dan perbelanjaan pertubuhan.</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						<span class="a"></span>  
					</div>
				</td>
			</tr>
			<tr>
				<td>Yuran daripada anggota-anggota</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						<span class="a"></span>  
					</div>
				</td>
				<td></td>
				<td>Fee-fee auditor</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						<span class="a"></span>  
					</div>
				</td>
			</tr>
			<tr>
				<td>Derma-derma</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						<span class="a"></span>  
					</div>
				</td>
				<td></td>
				<td>Perbelanjaan guaman</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						<span class="a"></span>  
					</div>
				</td>
			</tr>
			<tr>
				<td>Jualan majalah-majalah,buku-buku, kaedah-kaedah, dll.</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						<span class="a"></span>  
					</div>
				</td>
				<td></td>
				<td>Perbelanjaan dalam menjalankan pertikaian tred.</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						<span class="a"></span>  
					</div>
				</td>
			</tr>
			<tr>
				<td>Bunga atas pelaburan</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						<span class="a"></span>  
					</div>
				</td>
				<td></td>
				<td>Pampasan yang dibayar kepada ahli-ahli bagi kerugian yang berbangkit akibat pertikaian tred.</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						<span class="a"></span>  
					</div>
				</td>
			</tr>
			<tr>
				<td rowspan="3">Pendapatan daripada pelbagai sumber(nyatakan) </td>
				<td rowspan="3">
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						<span class="a"></span>  
					</div>
				</td>
				<td></td>
				<td>Faedah-faedah pengkebumian, hari tua, kesakitan,faedah kerana tiada berpekerjaan, dll. Faedah pelajaran, sosial dan keagamaan.</td>
				<td> 
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						<span class="a"></span>  
					</div>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>Kos menerbitkan majalah-majalah.</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						<span class="a"></span>  
					</div>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>Sewaan, kadaran dan cukai-cukai</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						<span class="a"></span>  
					</div>
				</td>
			</tr>
			<tr>
				<td colspan="3" class="italic" style="border-bottom: 1px solid grey">Penerimaan</td>
				<td colspan="2" class="italic" style="border-bottom: 1px solid grey">Pembayaran</td>
			</tr>
			<tr>
				<td></td>
				<td class="center">RM sen</td>
				<td></td>
				<td></td>
				<td class="center">RM sen</td>
			</tr>
			<tr>
				<td rowspan="3"></td>
				<td rowspan="3"></td>
				<td></td>
				<td>Alat tulis, cetakan dan bayaran pos.</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						<span class="a"></span>  
					</div>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>Perbelanjaan lain(nyatakan)</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						<span class="a"></span>  
					</div>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>Baki pada akhir tahun</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						<span class="a"></span>  
					</div>
				</td>
			</tr>
			<tr>
				<td colspan="2" class="right">
					Jumlah <span class="dotted"> RM </span>
				</td>
				<td></td>
				<td colspan="2" class="right">
					Jumlah <span class="dotted"> RM </span>
				</td>
			</tr>
		</table>
		<hr style="border: 1px solid grey">
		<table>
			<tr>
				<td width="70%"></td>
				<td class="center">
					.....................................<br>
					<i>Tandatangan Bendahari</i>
				</td>
			</tr>
		</table>
	</div>

	<!-- /////////////////////////////// FORTH PAGE /////////////////////////////////////////////////////-->
	<div style="page-break-before: always;">

		<div class="center">
			<span>(II)PENYATA ASET-ASET DAN LIABILITI-LIABILITI PADA<br>31HB MAC 19..........</span><br>
		</div>
		<table>
			<tr>
				<td colspan="3" class="italic" style="border-bottom: 1px solid grey; border-top: 1px solid grey">Liabiliti-liabiliti</td>
				<td colspan="2" class="italic" style="border-bottom: 1px solid grey; border-top: 1px solid grey">Aset-aset</td>
			</tr>
			<tr>
				<td width="35%"></td>
				<td width="15%" class="center">RM sen</td>
				<td></td>
				<td width="35%"></td>
				<td width="15%" class="center">RM sen</td>
			</tr>
			<tr>
				<td>Amaun am</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						<span class="a"></span>  
					</div>
				</td>
				<td></td>
				<td>Tunai:</td>
				<td></td>
			</tr>
			<tr>
				<td>Pinjaman daripada</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						<span class="a"></span>  
					</div>
				</td>
				<td></td>
				<td>Dalam tangan Bendahari</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						<span class="a"></span>  
					</div>
				</td>
			</tr>
			<tr>
				<td>Hutang terakru kepada</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						<span class="a"></span>  
					</div>
				</td>
				<td></td>
				<td>Dalam tangan Setiausaha</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						<span class="a"></span>  
					</div>
				</td>
			</tr>
			<tr>
				<td rowspan="6">Liabiliti-liabiliti lain(nyatakan)</td>
				<td rowspan="6">
				</td>
				<td></td>
				<td>Dalam tangan</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						<span class="a"></span>  
					</div>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>Dalam bank</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						<span class="a"></span>  
					</div>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>Sekuriti-sekuriti seperti senarai dibawah(dilekatkan) yuran terakru yang belum dibayar</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						<span class="a"></span>  
					</div>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>Pinjaman kepada</td>
				<td> 
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						<span class="a"></span>  
					</div>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>Harta tak alih</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						<span class="a"></span>  
					</div>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>Barang-barang dan perkakas rumah</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						<span class="a"></span>  
					</div>
				</td>
			</tr>
			<tr>
				<td colspan="2" class="right"><span class="dotted"></span></td>
				<td></td>
				<td>Aset-aset lain(nyatakan)</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						<span class="a"></span>  
					</div>
				</td>
			</tr>
			<tr>
				<td>Jumlah liabiliti-liabiliti</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						<span class="a"></span>  
					</div>
				</td>
				<td></td>
				<td>Jumlah aset-aset</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						<span class="a"></span>  
					</div>
				</td>
			</tr>
		</table>
	</div>

	<!-- /////////////////////////////// FIFTH PAGE /////////////////////////////////////////////////////-->
	<div style="page-break-before: always;">
		<div class="center">
			<span>
				PENYATA "2"<br>PERTUKARAN PEGAWAI-PEGAWAI YANG DIBUAT SEPANJANG TAHUN<br><br>
				(I) PEGAWAI-PEGAWAI YANG MENINGGALKAN JAWATAN
			</span><br>
		</div>
		<table class="border-grey" style="border-collapse: collapse;">
			<tr class="center border-grey" style="border-collapse: collapse;">
				<td class="border-grey">Nama</td>
				<td class="border-grey">Jawatan</td>
				<td class="border-grey">Tarikh meninggalkan jawatan</td>
			</tr>
		</table>
		<br>
		<div class="center"><span>(II) PEGAWAI-PEGAWAI YANG DILANTIK</span><br></div>
		<table class="border-grey" style="border-collapse: collapse;">
			<tr class="center border-grey" style="border-collapse: collapse;">
				<td class="border-grey">1<br>Nama</td>
				<td class="border-grey">2<br>Tarikh Lahir</td>
				<td class="border-grey">3<br>Alamat persendirian</td>
				<td class="border-grey">4<br>Pekerjaan Peribadi</td>
				<td class="border-grey">5<br>Jawatan yang dipegang dalam kesatuan</td>
				<td class="border-grey">6<br>Jawatan yang dipegang dalam kesatuan</td>
			</tr>
		</table>
		<table>
			<tr>
				<td width="70%"></td>
				<td class="center">
					.....................................<br>
					<i>Tandatangan Setiausaha</i>
				</td>
			</tr>
		</table>
	</div>

	<!-- /////////////////////////////// SIXTH PAGE /////////////////////////////////////////////////////-->
	<div style="page-break-before: always;">
		<div class="center">
			<span class="italic">PENGISYTIHARAN AUDITOR</span><br>
		</div>
		<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
			<span class="a">Nama kesatuan sekerja berdaftar</span>  
		</div>
		<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
			<span class="a">No pendaftaran</span>  
		</div>
		<table>
			<tr class="justify">
				<td colspan="2">
					<div style="text-indent: 90px">Auditor-auditor yang menandatangani di bawah telah mempunyai akses kepada kesemua bukubuku dan akaun-akaun kesatuan sekerja, dan telah memeriksa penyata-penyata yang disebut terdahulu dan mengesahkan buku-buku dan elaun-elaun itu bersama-sama dengan baucer akaun-akaun yang berhubungan dengannya, sekarang yang menandatangan buku-buku dan akaun-akaun itu sebagaimana didapati betul, dibaucer dengan sewajarnnya menurut undang-undang tertakluk kepada pemerhatian-pemerhatian berikut.*
					</div>
				</td>
			</tr>
			<tr>
				<td></td>
				<td width="30%" class="center">
					.....................................<br>
					<i>Tandatangan Auditor</i>
				</td>
			</tr>
		</table>
		<div class="center">
			<span class="italic">SENARAI SEKURITI-SEKURITI</span><br>
		</div>
		<table class="border-grey" style="border-collapse: collapse;">
			<tr class="center border-grey" style="border-collapse: collapse;">
				<td class="border-grey">Butir-butir</td>
				<td class="border-grey">Nilai zahir</td>
				<td class="border-grey">Harga kos</td>
				<td class="border-grey">Nilai pasaran pada tarikh akun-akaun itu dibuat</td>
				<td class="border-grey">Dalam tangan</td>
			</tr>
		</table>
		<table>
			<tr>
				<td>Saya .........................................................</td>
				<td width="50%" class="center">
					Bendahari
					<hr style="color: grey">
					Pegawai yang bertanggungjawab bagi Akaun
				</td>
			</tr>
			<tr class="justify">
				<td colspan="2">
					<span>Kesatuan Sekerja dengan ini mengesahkan secara sesungguhnya bahawa penyata akaun-akaun kesatuan di atas adalah benar dan betul mengikut pengetahuan dan kepercayaan saya sebaik-baiknya, dan saya membuat pengisytiharan ini dengan sesungguh hati mempercayai bahawa penyata akaun-akaun adalah benar dan menurut peruntukan-peruntukan Akta Pengisytiharan Statutori 1960.</span><br>
				</td>
			</tr>
			<tr class="justify">
				<td colspan="2">
					<span>Ditandatangani dan diisytiharkan sesungguhnya oleh ........................ yang dinamakan di atas di ....................................................... di dalam Negeri ......................... pada ................................. haribulan ..................................19..................</span>
				</td>
			</tr>
			<tr>
				<td></td>
				<td class="center">
					Di hadapan saya,<br>
					..........................................<br>
					Majistret
				</td>
			</tr>
		</table>
	</div>
</body>
