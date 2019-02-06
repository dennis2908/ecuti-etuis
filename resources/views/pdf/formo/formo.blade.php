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
			margin-left: 20px;
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
	    <span class='uppercase'>BORANG O</span><br><br>
		<span class='uppercase italic'>AKTA KESATUAN SEKERJA, 1959</span><br>
		<span>(Seksyen 72 dan Peraturan 18)</span><br><br>
		<span>NOTIS MENGENAI NIAT UNTUK MENUBUHKAN SUATU PERSEKUTUAN KESATUAN<br>SEKERJA</span><br><br>
	</div>

	<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
		<span class="a">Nama kesatuan sekerja </span>  {{ $formo->union->name }}
	</div>
	<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
		<span class="a">No sijil pendaftaran </span> {{ $formo->union->registration_no }}
	</div>
	<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
		<span class="a">Alamat ibu pejabat berdaftar </span> 
		@if($formo->address)
			{{ $formo->address->address1 ? $formo->address->address1.',' : '' }}
			{{ $formo->address->address2 ? $formo->address->address2.',' : '' }}
			{{ $formo->address->address3 ? $formo->address->address3.',' : '' }}
			{{ $formo->address->postcode ? $formo->address->postcode : '' }}
			{{ $formo->address->district ? $formo->address->district->name.',' : '' }}
			{{ $formo->address->state ? $formo->address->state->name.'.' : '' }}
		@endif
	</div>
	<br>
	<div style="padding-top: 15px;">
		<table>
		  	<tr>
		  		<td colspan="2">Kepada:</td>
		  	</tr>
		  	<tr>
		  		<td width="10%"></td>
		  		<td style="padding-top: 0px">
		  			Ketua Pengarah Kesatuan Sekerja,<br>
		    		Kuala Lumpur.<br>
		  		</td>
		  	</tr>
		    <tr>
		  		<td colspan="2">
		  			<div style="text-indent: 90px">Notis dengan ini diberikan bahawa adalah niat kesatuan sekerja disebutkan di atas untuk bergabung dengan</div>
		  		</td>
		  	</tr>
		  	@foreach($formo->unions as $index => $union)
		  	<tr class="top">
		  		<td style="text-align: right;">{{ $index+1 }}. </td>
		  		<td>
		  			<div class="dotted" style="padding-top: 0px;text-align: left;">
						{{ $union->union->name }}
					</div>
		  		</td>
		  	</tr> 
		  	@endforeach 
		  	<tr>
		  		<td colspan="2">untuk menubuhkan suatu persekutuan kesatuan sekerja.</td>
		  	</tr>
		  	<tr class="top">
		  		<td style="text-align: right;">2. </td>
		  		<td>
		  			Nama persekutuan kesatuan sekerja yang dicadangkan ialah <span class="dotted">{{ $formo->federation_name }}</span>
		  		</td>
		  	</tr>
		  	<tr class="top">
		  		<td style="text-align: right;">3. </td>
		  		<td>
		  			Suatu undi anggota-anggota kesatuan akan diambil di suatu* <span class="dotted">{{ $formo->meeting_type ? $formo->meeting_type->name : ''}}</span> pada <span class="dotted">{{ date('d/m/Y', strtotime($formo->resolved_at)) }}</span>
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
		<p>Bertarikh pada <span class="dotted"> {{ strftime('%e') }} </span> haribulan <span class="dotted"> {{ strftime('%B').' '.strftime('%Y') }} </span></p><br>
	
		<hr style="border: 1px solid">
	</div>
	<div class="center italic" style="font-size: 15px;">*Potong yang mana saja tidak sesuai</div> 

</body>
