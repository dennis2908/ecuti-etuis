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
			margin-left: 20px;
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
	    <span class='uppercase bold'>BORANG BB</span><br><br>
		<span class="italic">
			AKTA KESATUAN SEKERJA, 1959<br>
			(Seksyen 73 dan Peraturan 19)
		</span><br><br>

		<span>PERMOHONAN BAGI PENDAFTARAN PERSEKTUAN KESATUAN SEKERJA</span><br><br>

	</div>

	<div style="margin-left: 20px">Kepada Ketua Pengarah Kesatuan Sekerja, Kuala Lumpur.</div>

	<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
		<span class="a">Nama persekutuan kesatuan sekerja </span>  {{ $formbb->federation->name }}
	</div>
	<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
		<span class="a">Alamat ibu pejabat </span>
		@if($formbb->address)
			{{ $formbb->address->address1 ? $formbb->address->address1.',' : '' }}
			{{ $formbb->address->address2 ? $formbb->address->address2.',' : '' }}
			{{ $formbb->address->address3 ? $formbb->address->address3.',' : '' }}
			{{ $formbb->address->postcode ? $formbb->address->postcode : '' }}
			{{ $formbb->address->district ? $formbb->address->district->name.',' : '' }}
			{{ $formbb->address->state ? $formbb->address->state->name.'.' : '' }}
		@endif
	</div>
	<div style="padding-top: 15px">
		<table>
			<tr class="top">
				<td width="5%">1.</td>
				<td>Permohonan ini dibuat oleh Setiausaha dan tujuh ahli kesatuan yang nama-nama mereka ditandatangani di bawah.</td>
			</tr>
			<tr class="top">
				<td width="5%">2.</td>
				<td><span>Kesatuan <span class="dotted">{{ $formbb->federation->name }}</span> ini telah mulai diwujudkan pada <span class="dotted">{{ date('d/m/Y', strtotime($formbb->federation->registered_at)) }}</span> haribulan  <span class="dotted"></span></span></td>
			</tr>
			<tr class="top">
				<td width="5%">3.</td>
				<td>Persekutuan kesatuan sekerja adalah suatu persekutuan
					@if($formbb->federation_type_id)
		  				@if($formbb->federation_type_id == 1)
		  					majikan
		  				@else
		  					pekerja
		  				@endif
		  			@endif
		  			yang menjalankan {{ $formbb->category ? $formbb->category->name : '' }} <span class="dotted"> {{ $formbb->category }} </span> (pertubuhan).
		  		</td>
			</tr>
			<tr class="top">
				<td width="5%">4.</td>
				<td>Satu salinan kaedah-kaedah persekutuan disertakan bersama-sama permohonan ini.
		  		</td>
			</tr>
			<tr class="top">
				<td width="5%">5.</td>
				<td>Nama pegawai-pegawai persekutuan, titel jawatan mereka, umur, pekerjaan dan alamat adalah diberikan di dalam Jadual I.
		  		</td>
			</tr>
			<tr class="top justify">
				<td width="5%">6.</td>
				<td>Kami telah diberi kuasa dengan sewajarnya oleh kesatuan-kesatuan sekerja yang bersetuju untuk membentuk persekutuan ini untuk membuat permohonan ini bagi pihak mereka pemberian kuasa tersebut yang mengandungi ketetapan yang telah diluluskan mengikut seksyen 72 Akta Kesatuan Sekerja 1959. (Satu salinan minit-minit prosiding berkenaan dengan ketetapan yang diluluskan oleh tiap-tiap kesatuan dikembarkan bersama permohonan ini.)<br><br>

					<span style="margin-left: 10px">Bertarikh pada <span class="dotted"> {{ strftime('%e' , $formbb->resolved_at) }} </span> haribulan <span class="dotted"> {{ strftime('%B', $formbb->resolved_at).' '.strftime('%Y', $formbb->resolved_at) }} </span></span><br>

					<span style="margin-left: 10px">
						Nama kesatuan :
						@foreach($formbb->federation->unions as $index => $union)
							({{ $index+1 }})<span class="dotted">{{ $union->union->name }}</span>
						@endforeach

						<br><br>

						Tandatangan pemohon-pemohon
					</span>

					<table style="margin-left: 8px;margin-top: 0px">
						<tr>
							<td width="20%">Setiausaha</td>
							<td style="padding-top: 0px">
								<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
									{{ $formbb->created_by->name }}
								</div>
							</td>
						</tr>
						@foreach($formbb->officers as $index => $officer)
						<tr>
							<td width="28%">{{ $index+1 }}</td>
							<td style="padding-top: 0px">
								<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
									<span class="a">{{ $index+1 }} </span>  {{ $officer->name }}
								</div>
							</td>
						</tr>
						@endforeach
					</table>
		  		</td>
			</tr>
		</table>
	</div>


	<!-- /////////////////////////////// SECOND PAGE /////////////////////////////////////////////////////-->
	<div style="page-break-before: always;">

		<div class="center">
			<span>JADUAL I<br>SENARAI PEGAWAI-PEGAWAI PERSEKUTUAN</span><br>
		</div>
		<table border="1px solid black" style="border-collapse: collapse;">
			<tr class="center top">
				<td><small>Jawatan yang dipegang dalam kesatuan</small></td>
				<td><small>Nama<br>(nama lain,jika ada,dan dalam hal orang Cina namanya yg bersamaan dalam Bahasa Cina</small></td>
				<td><small>No Kad Pengenalan</small></td>
				<td><small>Umur</small></td>
				<td><small>Alamat</small></td>
				<td><small>Pekerjaan</small></td>
			</tr>
			@foreach($formbb->officers as $index => $officer)
			<tr class="top">
				<td>{{ $officer->designation ? $officer->designation->name : '' }}</td>
				<td>{{ $officer->name }}</td>
				<td>{{ $officer->identification_no }}</td>
				<td>{{ $officer->age }}</td>
				<td>
					@if($officer->address)
						{{ $officer->address->address1 ? $officer->address->address1.',' : '' }}
						{{ $officer->address->address2 ? $officer->address->address2.',' : '' }}
						{{ $officer->address->address3 ? $officer->address->address3.',' : '' }}
						{{ $officer->address->postcode ? $officer->address->postcode : '' }}
						{{ $officer->address->district ? $officer->address->district->name.',' : '' }}
						{{ $officer->address->state ? $officer->address->state->name.'.' : '' }}
					@endif
				</td>
				<td>{{ $officer->occupation }}</td>
			</tr>
			@endforeach
		</table>
	</div>

	<!-- /////////////////////////////// FORTH PAGE /////////////////////////////////////////////////////-->
	<div style="page-break-before: always;">

		<div class="center">
			<span>JADUAL II</span><br><br>
			<span class="bold">RUJUKAN KEPADA KAEDAH-KAEDAH</span><br><br>
		</div>
		<table>
			<tr class="center">
				<td width="5%"></td>
				<td colspan="2"><small>1<br><span class="italic">Perkara</span></small></td>
				<td width="25%"><small>2<br><span class="italic">Nombor Kaedah</span></small></td>
			</tr>
			<tr>
				<td class="top">1.</td>
				<td class="top" colspan="2"> Nama persekutuan kesatuan sekerja dan tempat mesyuarat bagi urusan persekutuan</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						1
					</div>
				</td>
			</tr>
			<tr>
				<td class="top">2.</td>
				<td class="top" colspan="2">Keseluruhan objek-objek bagi mana persekutuan akan ditubuhkan, tujuan-tujuan yang kumpulan wang itu hendaklah terpakai syaratsyarat yang mana-mana ahlinya boleh menjadi berhak kepada apa-apa faedah yang dijamin, dan denda-denda dan perlucuthakan yang akan dikenakan ke atas  ana-mana anggota
				</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						2,3
					</div>
				</td>
			</tr>
			<tr>
				<td class="top">3.</td>
				<td class="top" colspan="2">Cara-cara membuat, mengubah, meminda danmembatalkan kaedah-kaedah</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						25
					</div>
				</td>
			</tr>
			<tr>
				<td class="top">4.</td>
				<td class="top" width="5%">(a)</td>
				<td class="top">Pemilihan ahli-ahli eksekutif persekutuan menurut kaedah-kaedah persekutuan</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						10
					</div>
				</td>
			</tr>
			<tr>
				<td></td>
				<td class="top">(b)</td>
				<td class="top">Tertakluk kepada peruntukan perenggan (a), penamaan, perlantikan atau pemilihan atau pembuangan seseorang pegawai dan pemegang amanah, setiausaha, bendahari dan pekerja-pekerja kesatuan sekerja</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						10,12,20
					</div>
				</td>
			</tr>
			<tr>
				<td class="top">5.</td>
				<td class="top" colspan="2">Kawalan dan pelaburan wang persekutuan, jawatan orang-orang yang bertanggungjawab baginya, dan pengauditan akaunnya secara tahunan atau secara berkala</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						15,16,17
					</div>
				</td>
			</tr>
			<tr>
				<td class="top">6.</td>
				<td class="top" colspan="2">Pemeriksaan buku-buku dan nama-nama ahli persekutuan oleh manamana orang yang mempunyai sesuatu kepentingan dalam kumpulan wang persekutuan</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						19
					</div>
				</td>
			</tr>
			<tr>
				<td class="top">7.</td>
				<td class="top" colspan="2">Cara pembubaran persekutuan dan pelupusan kumpulan wang yang ada pada masa pembubaran tersebut</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						27
					</div>
				</td>
			</tr>
			<tr>
				<td class="top">8.</td>
				<td class="top" colspan="2">Pengambilan keputusan-keputusan melalui undi rahsia bagi perkaraperkara yang berikut :</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">

					</div>
				</td>
			</tr>
			<tr>
				<td></td>
				<td class="top">(a)</td>
				<td class="top"> pemilihan pegawai-pegawai (selain daripada pemegang-pemegang amanah) oleh persekutuan kesatuan sekerja menurut kaedah-kaedah persekutuan</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						-
					</div>
				</td>
			</tr>
			<tr>
				<td></td>
				<td class="top">(b)</td>
				<td class="top">segala perkara-perkara yang berhubungan dengan pertikaian-pertikaian atau tutup-pintu</td>
				<td>
					<div class="dotted line" style="padding-bottom: 15px; text-align: left;">
						-
					</div>
				</td>
			</tr>
			<tr>
				<td></td>
				<td class="top">(c)</td>
				<td class="top">pengenaan levi</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						26.1(A)
					</div>
				</td>
			</tr>
			<tr>
				<td></td>
				<td class="top">(d)</td>
				<td class="top">pembubaran persekutuan kesatuan sekerja</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						26.1(B)
					</div>
				</td>
			</tr>
			<tr>
				<td></td>
				<td class="top">(e)</td>
				<td class="top">pindaan kaedah-kaedah jika pindaan tersebut menyebabkan pertambahan liabiliti persekutuan kesatuan sekerja untuk menyumbang atau mengurangkan faedah-faedah kepada persekutuan kesatuan sekerja yang berhak</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						26.1(C)
					</div>
				</td>
			</tr>
			<tr>
				<td class="top">9.</td>
				<td class="top" colspan="2">Prosedur bagi mengadakan undi, menjamin kerahsiaan undi-undi rahsia dan penyimpanan kertas-kertas undi untuk tempoh yang ditetapkan</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						KEMBARAN A
					</div>
				</td>
			</tr>
			<tr>
				<td class="top">10.</td>
				<td class="top" colspan="2"> Cara pertikaian disebut dalam Bahagian VI Akta Kesatuan Sekerja 1959, hendaklah diputuskan</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						24
					</div>
				</td>
			</tr>
		</table>
	</div>
</body>
