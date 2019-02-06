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
	    <span class='uppercase bold'>BORANG L</span><br><br>
		<span class="bold">NOTIS PERUBAHAN PEGAWAI-PEGAWAI ATAU TITEL PEGAWAI-PEGAWAI</span><br><br>

	</div>

	<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
		<span class="a">Nama kesatuan sekerja berdaftar</span>  {{ $forml->tenure->entity->name }}
	</div>
	<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
		<span class="a">No Pendaftaran </span>  {{ $forml->tenure->entity->registration_no }}
	</div>
	<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
		<span class="a">Alamat ibu pejabat berdaftar </span> 
		@if($forml->address)
			{{ $forml->address->address1 ? $forml->address->address1.',' : '' }}
			{{ $forml->address->address2 ? $forml->address->address2.',' : '' }}
			{{ $forml->address->address3 ? $forml->address->address3.',' : '' }}
			{{ $forml->address->postcode ? $forml->address->postcode : '' }}
			{{ $forml->address->district ? $forml->address->district->name.',' : '' }}
			{{ $forml->address->state ? $forml->address->state->name.'.' : '' }}
		@endif
	</div>
	<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
		<span class="a">Nama dan alamat cawangan (jika terpakai) </span> 
		@if($forml->branch)
		<strong>{{ $forml->branch->name }} </strong>
		@if($forml->branch->address)
			{{ $forml->branch->address->address1 ? $forml->branch->address->address1.',' : '' }}
			{{ $forml->branch->address->address2 ? $forml->branch->address->address2.',' : '' }}
			{{ $forml->branch->address->address3 ? $forml->branch->address->address3.',' : '' }}
			{{ $forml->branch->address->postcode ? $forml->branch->address->postcode : '' }}
			{{ $forml->branch->address->district ? $forml->branch->address->district->name.',' : '' }}
			{{ $forml->branch->address->state ? $forml->branch->address->state->name.'.' : '' }}
		@endif
		@endif
	</div>
	<table>
	  	<tr>
	  		<td colspan="2">Kepada Pengarah / Penolong Pengarah *</td>
	  	</tr>
	    <tr>
	  		<td colspan="2">
	  			<div style="text-indent: 90px">Notis dengan ini diberikan bahawa perubahan pekerja-pekerja yang berikut telah berlaku dalam Kesatuan/Cawangan* yang disebutkan di atas.</div>
	  		</td>
	  	</tr>
	</table>
	<div class="center" style="margin-top: 10px">PEGAWAI-PEGAWAI YANG MENINGGALKAN JAWATAN</div>
	<table style="border: 1px solid; border-collapse: collapse;">
		<tr class="center" style="border: 1px solid; border-collapse: collapse;">
			<td class="border">Nama</td>
			<td class="border">Titel Jawatan</td>
			<td class="border">Tarikh Meninggalkan Jawatan</td>
		</tr>
		@foreach($forml->leaving as $index => $leaving)
		<tr>
			<td class="border">{{ $leaving->officer->name }}</td>
			<td class="center border">{{ $leaving->officer ? $leaving->officer->designation->name : '' }}</td>
			<td class="center border">{{ date('d/m/Y', strtotime($leaving->left_at)) }}</td>
		</tr>
		@endforeach
	</table>

	<div class="center">PEGAWAI-PEGAWAI YANG MEMEGANG JAWATAN</div>
	<table style="border: 1px solid; border-collapse: collapse;">
		<tr class="center" style="border: 1px solid; border-collapse: collapse;">
			<td class="border">Titel<br>Jawatan</td>
			<td class="border">Nama</td>
			<td class="border">No K/P</td>
			<td class="border">Tarikh<br>Lahir</td>
			<td class="border">Alamat<br>Rumah</td>
			<td class="border">Pekerjaan</td>
			<td class="border">Tarikh<br>Memegang<br>Jawatan</td>
		</tr>
		@foreach($forml->officers as $index => $officer)
		<tr>
			<td class="border">{{ $officer->designation ? $officer->designation->name : '' }}</td>
			<td class="border">{{ $officer->name }}</td>
			<td class="border">{{ $officer->identification_no }}</td>
			<td class="border">{{ date('d/m/Y', strtotime($officer->date_of_birth)) }}</td>
			<td class="border">
				@if($officer->address)
					{{ $officer->address->address1 ? $officer->address->address1.',' : '' }}
					{{ $officer->address->address2 ? $officer->address->address2.',' : '' }}
					{{ $officer->address->address3 ? $officer->address->address3.',' : '' }}
					{{ $officer->address->postcode ? $officer->address->postcode : '' }}
					{{ $officer->address->district ? $officer->address->district->name.',' : '' }}
					{{ $officer->address->state ? $officer->address->state->name.'.' : '' }}
				@endif
			</td>
			<td class="border">{{ $officer->occupation }}</td>
			<td class="border">{{ date('d/m/Y', strtotime($officer->held_at)) }}</td>
		</tr>
		@endforeach
	</table>

	<table>
		<tr class="justify">
			<td>
				<span>
					2. &nbsp;&nbsp;&nbsp;Saya telah diberi kuasa dengan sewajarnya oleh kesatuan sekerja {{ $forml->tenure->entity->name }} untuk mengemukakan notis ini bagi pihaknya,pemberian kuasa tersebut terdiri daripada suatu ketetapan yang diluluskan dalam {{ $forml->meeting_type ? $forml->meeting_type->name : '' }} pada <span class="dotted"> {{ strftime('%e' , $forml->meeting_at) }} </span> haribulan <span class="dotted"> {{ strftime('%B', $forml->meeting_at).' '.strftime('%Y', $forml->meeting_at) }} </span><br><br>
				</span>
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

	<!-- /////////////////////////////////////////////////////////////////////////////////////////////// -->
	
	<div style="page-break-before: always;">
		<div class="center">PERAKUAN</div><br>
		<div style="text-indent: 90px">Kami mengaku bahawa pekerja-pekerja yang dilantik di atas adalah berhak untuk memegang jawatan di bawah seksyen 29 Akta Kesatuan Sekerja 1959.</div>
		<table>
			<tr style="vertical-align: middle;">
				<td>
					(METERAI KESATUAN)
				</td>
				<td>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						<span class="a">Presiden </span>
					</div>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						<span class="a">Setiausaha </span>
					</div>
					<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
						<span class="a">Bendahari </span>
					</div>
				</td>
			</tr>
		</table>

		<p>Bertarikh pada <span class="dotted"> {{ strftime('%e') }} </span> haribulan <span class="dotted"> {{ strftime('%B').' '.strftime('%Y') }} </span></p><br>

		<hr style="border: 1px solid">
		<div class="italic" style="font-size: 15px;">
			+ Jika pekerja seorang warganegara mengikut kuatkuasa undang-undang,nyatakan demikian.<br> 
			* Potong perkataan-perkataan yang tidak perlu.
		</div> 
	</div>

</body>
