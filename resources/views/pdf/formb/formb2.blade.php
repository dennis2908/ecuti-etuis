<?php
setlocale(LC_TIME, "ms", "my_MS", "ms_MY");
?>

<head>
	<style>

		.letter {
			font-family: Times, Times New Roman, Georgia, serif !important;
			padding-top: 30px !important;
			font-size: 25px;
		}
		.letter div {
			font-size: 25px;
			margin-left: 25px;
			font-family: Times, Times New Roman, Georgia, serif !important;	
		}

		.letter table {
			width: 100%;
			margin-top: 18px;
		}
		.letter td, th {
			font-family: Times, Times New Roman, Georgia, serif !important;
			padding: 5px;
			font-size: 24px;
			line-height: 1.5em;
		}

		.letter span, a, p, h1, h2 {
			font-family: Times, Times New Roman, Georgia, serif !important;
		}

		.letter span, a, p {
			font-size: 24px;
			line-height: 1.5em;
		}
		.letter .justify {
			text-align: justify;
		}
		.letter .head{
			font-size: 24px;
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
		    margin-right: 20px;
		    margin-bottom: 20px;
		    margin-top: 20px;
		   
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
	    <span class='uppercase bold'>BORANG B</span><br><br>
		<span class="italic">[Seksyen 10(1) dan Peraturan 18]</span><br>
		<span>AKTA KESATUAN SEKERJA , 1959</span><br><br>

		<span class="bold">PERMOHONAN PENDAFTARAN KESATUAN SEKERJA</span><br><br>
	</div>
	<div>Kepada Pendaftar Kesatuan Sekerja, Kuala Lumpur.</div>
	<div class="dotted line" style="padding-bottom: 7px; text-align: left;">
		<span class="a">Nama kesatuan sekerja </span>  {{ $formb->union->name }}
	</div>
	<div class="dotted line" style="padding-bottom: 7px; text-align: left;">
		<span class="a">Alamat ibu pejabat berdaftar </span> 
		@if($formb->address)
			{{ $formb->address->address1 ? $formb->address->address1.',' : '' }}
			{{ $formb->address->address2 ? $formb->address->address2.',' : '' }}
			{{ $formb->address->address3 ? $formb->address->address3.',' : '' }}
			{{ $formb->address->postcode ? $formb->address->postcode : '' }}
			{{ $formb->address->district ? $formb->address->district->name.',' : '' }}
			{{ $formb->address->state ? $formb->address->state->name.'.' : '' }}
		@endif
	</div>
	<div style="padding-top: 15px;">
		<table>
			<tr>
				<td>
					<span style="padding-top: 15px">
						1. &nbsp;&nbsp;&nbsp;Permohonan ini dibuat oleh orang-orang yang namanya ditulis di bawah ini.<br><br>

						2. &nbsp;&nbsp;&nbsp;Kesatuan <span class="dotted">{{ $formb->union->name }}</span> ini telah ditubuhkan pada <span class="dotted">{{ date('d/m/Y', strtotime($formb->union->registered_at)) }}</span> haribulan  <span class="dotted"></span><br><br>

						3. &nbsp;&nbsp;&nbsp;Kesatuan itu ialah suatu Kesatuan 
				  			@if($formb->union_type_id)
				  				@if($formb->union_type_id == 1)
				  					majikan
				  				@else
				  					pekerja 
				  				@endif
				  			@endif
				  			yang bertugas dalam <span class="dotted"></span> atau (perjawatan) <span class="dotted"></span> dan mempunyai <span class="dotted"> {{ $formb->total_member or '' }}</span> orang ahli.<br><br>

				  		4. &nbsp;&nbsp;&nbsp;Kenyataan butir-butir yang dikehendaki oleh seksyen 10(2) Akta itu adalah diberi dalam Jadual 1 yang dilampirkan kepada permohonan ini.<br><br>

				  		5. &nbsp;&nbsp;&nbsp;Suatu salinan kaedah-kaedah yang bercetak bagi Kesatuan ini adalah dilampirkan kepada permohonan ini.<br><br>

				  		6. &nbsp;&nbsp;&nbsp;Butir-butir yang diberi dalam Jadual III adalah menunjukkan peruntukan yang dibuat dalam kaedah-kaedah bagi perkara-perkara yang tersebut dalam seksyen 38(1) Akta itu.<br><br>

				  		7. &nbsp;&nbsp;&nbsp;Kami telah diberi kuasa dengan sempurnanya oleh kesatuan sekerja ini untuk membuat permohonan ini bagi pihaknya, pemberiankuasa tersebut ialah melalui* <span class="dotted"> {{ $formb->meeting_type ? $formb->meeting_type->name : '' }} </span> .<br><br>

					</span>
				</td>
			</tr>
		</table>

		<span style="margin-left: 10px">Bertarikh pada <span class="dotted"> {{ strftime('%e' , strtotime($formb->resolved_at)) }} </span> haribulan <span class="dotted"> {{ strftime('%B', strtotime($formb->resolved_at)).' '.strftime('%Y', strtotime($formb->resolved_at)) }} </span></span><br>

		<table>
			@foreach($formb->requesters as $index => $requester)
			<tr>
				<td width="25%">{{ $index+1 < 2 ? 'Tandatangan pemohon :' : '' }}</td>
				<td style="padding-top: 0px">
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						<span class="a">{{ $index+1 }} </span> <span class="uppercase">{{ $requester->name }}</span>
					</div>
				</td>
			</tr>
			@endforeach
		</table>
		<hr style="border: 1px solid">
	</div>
	<div class="italic"><small>*Nyatakan di sini sama ada kuasa membuat permohonan ini telah diberi oleh suatu "ketetapan mesyuarat agung kesatuan sekerja itu" atau jika tidak, dengan apakah jalan lain ia telah diberi.</small></div> 

	<!-- /////////////////////////////// SECOND PAGE /////////////////////////////////////////////////////-->
	<div style="page-break-before: always;">

		<div class="center">
			<span><small>JADUAL I</small></span><br>
			<span class="bold">KENYATAAN BUTIR-BUTIR YANG TERSEBUT DALAM SEKSYEN 10(2)</span><br>
		</div>
		<ol style="list-style-type: lower-alpha; font-style: italic;">
			<li>
				<span style="font-style: normal;">Nama, pekerjaan, dan alamat ahli-ahli yang membuat permohonan itu adalah seperti berikut:-</span>
				<br>

				<table border="1px solid black" style="border-collapse: collapse;">
					<tr class="center top">
						<td></td>
						<td width="35%"><small>Nama<br>(alias, jika ada, dan bagi orang Cina dengan tulisan Cina) </small></td>
						<td width="20%"><small>Pekerjaan</small></td>
						<td width="35%"><small>Alamat</small></td>
					</tr>
					@foreach($formb->requesters as $index => $requester)
					<tr class="top">
						<td width="13%" class="right"><small>{{ $index+1 < 2 ? 'Ditandatangani : '.($index+1).'.' : ($index+1).'.' }} </small></td>
						<td class="uppercase">{{ $requester->name }}</td>
						<td class="uppercase">{{ $requester->occupation }}</td>
						<td class="uppercase">
							@if($requester->address)
								{{ $requester->address->address1 ? $requester->address->address1.',' : '' }}
								{{ $requester->address->address2 ? $requester->address->address2.',' : '' }}
								{{ $requester->address->address3 ? $requester->address->address3.',' : '' }}
								{{ $requester->address->postcode ? $requester->address->postcode : '' }}
								{{ $requester->address->district ? $requester->address->district->name.',' : '' }}
								{{ $requester->address->state ? $requester->address->state->name.'.' : '' }}
							@endif
						</td>
					</tr>
					@endforeach
				</table>
				<br><br>

			</li>
			<li>
				<span style="font-style: normal;">(1) Nama yang dicadangkan untuk didaftarkan bagi kesatuan sekerja yang bagi pihaknya permohonan ini dibuat ialah <span class="dotted">{{ $formb->union->name }}</span> .</span>
				<br><br>
				<span style="font-style: normal;">(2) Alamat ibu pejabat kesatuan ke mana semua perhubungan dan notis boleh dihantar ialah <span class="dotted">
				@if($formb->address)
					{{ $formb->address->address1 ? $formb->address->address1.',' : '' }}
					{{ $formb->address->address2 ? $formb->address->address2.',' : '' }}
					{{ $formb->address->address3 ? $formb->address->address3.',' : '' }}
					{{ $formb->address->postcode ? $formb->address->postcode : '' }}
					{{ $formb->address->district ? $formb->address->district->name.',' : '' }}
					{{ $formb->address->state ? $formb->address->state->name.'.' : '' }}
				@endif
				</span>.</span>
			</li>
		</ol>
	</div>

	<!-- /////////////////////////////// THIRD PAGE /////////////////////////////////////////////////////-->
	<div style="page-break-before: always;">

		<div class="center">
			<span><small>JADUAL II<br>(Untuk diisi oleh tiap-tiap pegawai)</small></span><br>
		</div>
		<ol style="list-style-type: lower-alpha; font-style: italic;">
			<li>
				<span style="font-style: normal;">Nama, pekerjaan, dan alamat ahli-ahli yang membuat permohonan itu adalah seperti berikut:-</span>
				<br>

				<table border="1px solid black" style="border-collapse: collapse;">
					<tr class="center top">
						<td width="10%"><small>Nama<br>Jawatan</small></td>
						<td><small>(a) Nama<br>K.P.P.N. No. </small></td>
						<td><small>Umur</small></td>
						<td><small>Kewarganegaraan<br>Persekutuan No</small></td>
						<td><small>Alamat</small></td>
						<td><small>Pekerjaan<br>Sekarang</small></td>
						<td><small>(b) Butir-butir<br>mengenai jawatan<br>dahulu yang<br>dipegang dalam<br>kesatuan sekerja</small></td>
						<td><small>(c) Butir-butir<br>mengenai apa-apa<br>thabitan di<br>mana-mana Mahkamah</small></td>
						<td><small>Tandatangan<br>Pegawai</small></td>
					</tr>
					@foreach($formb->tenure->officers as $index => $officer)
					<tr class="top uppercase">
						<td>{{ $officer->designation->name }}</td>
						<td>{{ $officer->name }} <br> {{ $officer->identification_no }}</td>
						<td>{{ $officer->age }}</td>
						<td>{{ $officer->nationality ? $officer->nationality->name : '' }}</td>
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
						<td>{{ $officer->previous_designation ? $officer->previous_designation->name : '' }}</td>
						<td>{{ $officer->conviction }}</td>
						<td></td>
					</tr>
					@endforeach
				</table>
				<br>
				<table>
					<tr class="top">
						<td width="10%"><span style="font-style: italic;">(a)</td>
						<td>Bagi orang Cina, namanya dalam tulisan Cina hendaklah dicatitkan.</td>
					</tr>
					<tr class="top">
						<td><span style="font-style: italic;">(b)</span></td>
						<td> Di sini mestilah dimasukkan butir-butir yang cukup untuk membuktikan dengan memuaskan hati Pendaftar bahawa pegawai itu telah bekerja selama tiga tahun dalam tred, perusahaan, atau pekerjaan yang dengannya kesatuan itu berhubung</td>
					</tr>
					<tr class="top">
						<td><span style="font-style: italic;">(c)</span></td>
						<td>Semua jawatan yang dipegang dalam Kesatuan Sekerja serta nama kesatuan itu dan tarikh yang berkaitan mestilah dinyatakan.</td>
					</tr>
					<tr class="top">
						<td><span style="font-style: italic;">(d)</span></td>
						<td>Jenis pertuduhan, tarikh pembicaraan, nama Mahkamah dan hukuman termasuk pelepasan menurut peruntukan-peruntukan Kanun Acara Jenayah mestilah dinyatakan.</td>
					</tr>

				</table>

			</li>
			
		</ol>
	</div>

	<!-- /////////////////////////////// FORTH PAGE /////////////////////////////////////////////////////-->
	<div style="page-break-before: always;">

		<div class="center">
			<span><small>JADUAL III<br>(Seksyen 38)</small></span><br><br>
			<span class="bold">RUJUKAN KEPADA KAEDAH-KAEDAH</span><br><br>
		</div>
		<span>Nombor-nombor kaidah yang membuat peruntukan bagi perkara yang masing-masing dibutirkan dalam ruang 1 adalah diberi dalam ruang 2 di bawah:</span>
		<table>
			<tr class="center">
				<td width="5%"></td>
				<td colspan="2"><small>1<br>Perkara</small></td>
				<td width="20%"><small>2<br>Nombor Kaedah</small></td>
			</tr>
			<tr>
				<td class="top">1.</td>
				<td class="top" colspan="2">Nama kesatuan sekerja dan tempat mesyuarat bagi urusan kesatuan sekerja</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						1
					</div>
				</td>
			</tr>
			<tr>
				<td class="top">2.</td>
				<td class="top" colspan="2">Kesemua tujuan-tujuan yang kerananya kesatuan sekerja itu hendak ditubuhkan, maksud-maksud kumpulanwangnya hendak digunakan, syarat-syarat bagaimana seseorang ahlinya boleh menjadi berhak kepada apa-apa faedah yang dijamin, dan denda dan lucutan hak yang hendak dikenakan ke atas mana-mana ahlinya
				</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						2,3
					</div>
				</td>
			</tr>
			<tr>
				<td class="top">3.</td>
				<td class="top" colspan="2">Cara-cara membuat, mengubah, meminda dan membatalkan kaidah-kaidah</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						24
					</div>
				</td>
			</tr>
			<tr>
				<td class="top">4.</td>
				<td class="top" width="5%">(a)</td>
				<td class="top">Pemilihan ahli-ahli majlis kerja bagi kesatuan sekerja itu menurut kaedah-kaedah kesatuan itu</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						12
					</div>
				</td>
			</tr>
			<tr>
				<td></td>
				<td class="top">(b)</td>
				<td class="top">Tertakluk kepada peruntukan-peruntukan perenggan (a), penamaan, perlantikan atau pemilihan dan pemecatan seseorang pegawai, pemegang-pemegang amanah, setiausaha-setiausaha, bendahari-bendahari dan pekerja-pekerja kesatuan sekerja itu</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						11,12,14
					</div>
				</td>
			</tr>
			<tr>
				<td></td>
				<td class="top">(c)</td>
				<td class="top">Larangan ke atas semua pegawai-pegawai dan pekerja-pekerja kesatuan sekerja itu bekerja dengan mana-mana kesatuan sekerja yang lain</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						11
					</div>
				</td>
			</tr>
			<tr>
				<td class="top">5.</td>
				<td class="top" colspan="2">Penyimpanan dan pelaburan kumpulan wang kesatuan sekerja itu, nama jawatan orang-orang yang bertanggungjawab atasnya, dan pengauditan akaunnya tiap-tiap tahun atau dari suatu tempoh ke suatu tempoh</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						15,16,19
					</div>
				</td>
			</tr>
			<tr>
				<td class="top">6.</td>
				<td class="top" colspan="2">Pemeriksaan buku-buku dan nama-nama ahli kesatuan sekerja itu oleh mana-mana orang yang ada mempunyai kepentingan dalam kumpulan wang kesatuan sekerja itu</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						20
					</div>
				</td>
			</tr>
			<tr>
				<td class="top">7.</td>
				<td class="top" colspan="2">Cara pembubaran kesatuan sekerja itu dan pelupusan kumpulan wangnya yang ada pada masa pembubaran tersebut</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						28
					</div>
				</td>
			</tr>
			<tr>
				<td class="top">8.</td>
				<td class="top" colspan="2">Cara menubuh dan membubarkan mana-mana cawangan kesatuan sekerja itu dan cara bagaimana cawangan tersebut dan akaunnya akan ditadbirkan</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						-
					</div>
				</td>
			</tr>
			<tr>
				<td class="top">9.</td>
				<td class="top" colspan="2">Membuat keputusan dengan jalan undi sulit atas perkara-perkara yang berikut:-</td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td class="top">(a)</td>
				<td class="top">pemilihan wakil-wakil ke mesyuarat agung, jika kaedah-kaedah kesatuan itu membuat peruntukan bagi mesyuarat perwakilan, atau ke Persekutuan Kesatuan-kesatuan Sekerja</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						25(1)(B)
					</div>
				</td>
			</tr>
			<tr>
				<td></td>
				<td class="top">(b)</td>
				<td class="top">pemilihan pegawai (lain daripada pemegang amanah) oleh ahli-ahli menurut kaedah-kaedah kesatuan itu</td>
				<td>
					<div class="dotted line" style="padding-bottom: 15px; text-align: left;">
						25(1)(A)
					</div>
				</td>
			</tr>
			<tr>
				<td></td>
				<td class="top">(c)</td>
				<td class="top">segala perkara berhubung dengan mogok atau tutup pintu</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						25(1)(C)
					</div>
				</td>
			</tr>
			<tr>
				<td></td>
				<td class="top">(d)</td>
				<td class="top">mengenakan sesuatu levi</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						25(1)(D)
					</div>
				</td>
			</tr>
			<tr>
				<td></td>
				<td class="top">(e)</td>
				<td class="top">pembubaran kesatuan sekerja atau persekutuan kesatuan-kesatuan sekerja</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						25(1)(G)
					</div>
				</td>
			</tr>
			<tr>
				<td></td>
				<td class="top">(f)</td>
				<td class="top">pindaan bagi kaidah-kaidah jika pindaan tersebut menambah tanggungan ahli-ahli untuk mencarum atau mengurangkan faedah-faedah yang kepadanya ahli-ahli berhak</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						25(1)(E)
					</div>
				</td>
			</tr>
			<tr>
				<td></td>
				<td class="top">(g)</td>
				<td class="top">penyatuan dengan suatu kesatuan sekerja yang lain atau pemindahan urusan-urusan kepada suatu kesatuan sekerja yang lain</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						25(1)(F)
					</div>
				</td>
			</tr>
			<tr>
				<td></td>
				<td class="top">(h)</td>
				<td class="top">memasuki atau membentuk suatu persekutuan kesatuan-kesatuan sekerja</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						-
					</div>
				</td>
			</tr>
			<tr>
				<td class="top">10.</td>
				<td class="top" colspan="2">Cara menjalankan undi, jaminan merahsiakan undi sulit dan penyimpanan kertas-kertas undi selama tempoh yang ditetapkan</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						25(2),KEMBARAN
					</div>
				</td>
			</tr>
			<tr>
				<td class="top">11.</td>
				<td class="top" colspan="2">Cara bagaimana pertikaian-pertikaian yang tersebut dalam Bahagian VI Ordinan Kesatuan Sekerja, 1959, hendak diputuskan</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						27
					</div>
				</td>
			</tr>
		</table>
	</div>
</body>
