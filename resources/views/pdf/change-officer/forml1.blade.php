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
	    <span class='uppercase bold'>BORANG L1</span><br><br>
		<span class="italic">AKTA KESATUAN SEKERJA , 1959</span><br><br>

		<span class="bold">NOTIS PERUBAHAN PEKERJA-PEKERJA SESUATU KESATUAN SEKERJA</span><br><br>

	</div>

	<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
		<span class="a">Nama kesatuan sekerja berdaftar</span>  {{ $forml1->tenure->entity->name }}
	</div>
	<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
		<span class="a">No Pendaftaran </span>  {{ $forml1->tenure->entity->registration_no }}
	</div>
	<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
		<span class="a">Alamat ibu pejabat berdaftar </span> 
		@if($forml1->address)
			{{ $forml1->address->address1 ? $forml1->address->address1.',' : '' }}
			{{ $forml1->address->address2 ? $forml1->address->address2.',' : '' }}
			{{ $forml1->address->address3 ? $forml1->address->address3.',' : '' }}
			{{ $forml1->address->postcode ? $forml1->address->postcode : '' }}
			{{ $forml1->address->district ? $forml1->address->district->name.',' : '' }}
			{{ $forml1->address->state ? $forml1->address->state->name.'.' : '' }}
		@endif
	</div>
	<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
		<span class="a">Nama dan alamat cawangan (jika terpakai) </span> 
		@if($forml1->branch)
		<strong>{{ $forml1->branch->name }} </strong>
		@if($forml1->branch->address)
			{{ $forml1->branch->address->address1 ? $forml1->branch->address->address1.',' : '' }}
			{{ $forml1->branch->address->address2 ? $forml1->branch->address->address2.',' : '' }}
			{{ $forml1->branch->address->address3 ? $forml1->branch->address->address3.',' : '' }}
			{{ $forml1->branch->address->postcode ? $forml1->branch->address->postcode : '' }}
			{{ $forml1->branch->address->district ? $forml1->branch->address->district->name.',' : '' }}
			{{ $forml1->branch->address->state ? $forml1->branch->address->state->name.'.' : '' }}
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
	<div class="center">PEKERJA-PEKERJA YANG MENINGGALKAN PERLANTIKAN</div>
	<table style="border: 1px solid; border-collapse: collapse;">
		<tr style="border: 1px solid; border-collapse: collapse;" class="center">
			<td class="border" width="40%">Nama</td>
			<td class="border" width="30%">Pelantikan</td>
			<td class="border">Tarikh Peninggalan</td>
		</tr>
		@foreach($forml1->resigns as $index => $resign)
		<tr>
			<td class="border">{{ $resign->name }}</td>
			<td class="center border">{{ $resign->worker ? $resign->worker->appointement : '' }}</td>
			<td class="center border">{{ date('d/m/Y', strtotime($resign->left_at)) }}</td>
		</tr>
		@endforeach
	</table>

	<div class="center" style="margin-top: 10px">PEKERJA-PEKERJA YANG DILANTIK</div>
	<table style="border: 1px solid; border-collapse: collapse;">
		<tr style="border: 1px solid; border-collapse: collapse;" class="center">
			<td class="border">Pelantikan</td>
			<td class="border">Nama</td>
			<td class="border">No K/P</td>
			<td class="border">Tarikh Lahir</td>
			<td class="border">Alamat<br>Rumah</td>
			<td class="border">Pekerjaan</td>
			<td class="border">Tarikh Pelantikan</td>
		</tr>
		@foreach($forml1->appointed as $index => $appointed)
		<tr>
			<td class="border">{{ $appointed->appointment }}</td>
			<td class="border">{{ $appointed->name }}</td>
			<td class="border">{{ $appointed->identification_no }}</td>
			<td class="border">{{ date('d/m/Y', strtotime($appointed->date_of_birth)) }}</td>
			<td class="border">
				@if($appointed->address)
					{{ $appointed->address->address1 ? $appointed->address->address1.',' : '' }}
					{{ $appointed->address->address2 ? $appointed->address->address2.',' : '' }}
					{{ $appointed->address->address3 ? $appointed->address->address3.',' : '' }}
					{{ $appointed->address->postcode ? $appointed->address->postcode : '' }}
					{{ $appointed->address->district ? $appointed->address->district->name.',' : '' }}
					{{ $appointed->address->state ? $appointed->address->state->name.'.' : '' }}
				@endif
			</td>
			<td class="border">{{ $appointed->occupation }}</td>
			<td class="border">{{ date('d/m/Y', strtotime($appointed->appointed_at)) }}</td>
		</tr>
		@endforeach
	</table>

	<table>
		<tr class="justify">
			<td>
				<span>
					2. &nbsp;&nbsp;&nbsp;Saya telah diberi kuasa dengan sewajarnya oleh kesatuan sekerja {{ $forml->tenure->entity->name }} untuk mengemukakan notis ini bagi pihaknya,pemberian kuasa tersebut terdiri daripada suatu ketetapan yang diluluskan dalam {{ $forml1->meeting_type ? $forml1->meeting_type->name : '' }} pada <span class="dotted"> {{ strftime('%e' , $forml1->meeting_at) }} </span> haribulan <span class="dotted"> {{ strftime('%B', $forml1->meeting_at).' '.strftime('%Y', $forml1->meeting_at) }} </span><br><br>
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
