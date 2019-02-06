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

	</style>
</head>

<body class="letter">
   	<div class="center">
	    <span class='uppercase bold'>BORANG G</span><br><br>
		<span><span class="italic">AKTA KESATUAN SEKERJA, 1959</span><br>(Seksyen 34(1) dan Peraturan 12(1))</span><br><br>
		<span>NOTIS PERTUKARAN NAMA</span><br><br>
	</div>

	<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
		<span class="a">Nama kesatuan sekerja berdaftar</span>  {{ $formg->tenure->entity->name }}
	</div>
	<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
		<span class="a">No. Pendaftaran </span>  {{ $formg->tenure->entity->registration_no }}
	</div>
	<div class="dotted line" style="padding-bottom: 5px; text-align: left;margin-bottom: 5px;">
		<span class="a">Alamat ibu pejabat berdaftar</span> 
		@if($formg->address)
			{{ $formg->address->address1 ? $formg->address->address1.',' : '' }}
			{{ $formg->address->address2 ? $formg->address->address2.',' : '' }}
			{{ $formg->address->address3 ? $formg->address->address3.',' : '' }}
			{{ $formg->address->postcode ? $formg->address->postcode : '' }}
			{{ $formg->address->district ? $formg->address->district->name.',' : '' }}
			{{ $formg->address->state ? $formg->address->state->name.'.' : '' }}
		@endif
	</div>
	<div class="dotted line" style="padding-bottom: 5px; text-align: left; margin-top: 25px">
		<span class="a">Bertarikh pada <span class="dotted">{{ strftime('%e', strtotime($formg->applied_at)) }}</span> haribulan </span> {{ strftime('%B', strtotime($formg->applied_at)).' '.strftime('%Y', strtotime($formg->applied_at)) }}
	</div>
	<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
		<span class="a">Kepada Penolong Pengarah Kesatuan Sekerja* </span>
	</div>
	<div>
		<table>
		    <tr>
		  		<td colspan="2">
		  			<div style="text-indent: 90px">Notis dengan ini diberikan mengikut syarat-syarat seksyen 34(1) Akta Kesatuan Sekerja 1959, bahawa nama kesatuan sekerja yang disebut di atas telah ditukar kepada <span class="dotted">{{ $formg->name }}</span>.</div>
		  		</td>
		  	</tr>
		  	<tr>
		  		<td colspan="2">
		  			<div style="text-indent: 90px">Persetujuan ahli-ahli telah diperoleh melalui+ <span class="dotted"> {{ $formg->meeting_type ? $formg->meeting_type->name : '' }} </span>.</div>
		  		</td>
		  	</tr>
		  	<tr>
		  		<td colspan="2">
		  			<div style="text-indent: 90px">No. Perakuan Pendaftaran <span class="dotted"> {{ $formg->certification_no }} </span>telah dilampirkan bersama bagi pindaan yang perlu.</div>
		  		</td>
		  	</tr>
		  	<tr>
		  		<td colspan="2">
					<table>
						<tr>
							<td></td>
							<td class="italic center"></td>
							<td class="italic center">Nama dalam huruf besar</td>
						</tr>
						<tr>
							<td style="width: 25%">Tandatangan Setiausaha :</td>
							<td width="25%">
								<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
									<span class="a">1. &nbsp; </span>  
								</div>					
							</td>
							<td>
								<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
									{{ $formg->tenure->entity->user->name }}
								</div>				
							</td>
						</tr>
						<tr>
							<td>Tandatangan Ahli-ahli:</td>
							<td>
								@foreach($formg->members as $index => $member)
								<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
									<span class="a">{{ $index+2 }}. &nbsp; </span>  
								</div>	
								@endforeach					
							</td>
							<td>
								@foreach($formg->members as $index => $member)
								<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
									{{ $member->name }}
								</div>		
								@endforeach		
							</td>
						</tr>
					</table>
				</td>
		  	</tr>
		</table>
		<hr style="border:1px solid">
		<p>
		  	<small>
		  		*Notis mestilah dialamatkan kepada Penolong Pengarah kawasan di mana ibu pejabat kesatuan itu terletak<br>
		  		+ia itu melalui referendum, ketetapan sesuatu mesyuarat agung, dsb., jika prosedur yang diikuti dirangkumi oleh nombor kaedah yang dinyatakan bagi kaedah itu.
		  	</small>
		</p>
	</div>

</body>
