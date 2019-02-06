<?php
setlocale(LC_TIME, "ms", "my_MS", "ms_MY");
?>

<head>
	<style>

		.letter {
			font-family: Times, Times New Roman, Georgia, serif !important;
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
	    <span class='uppercase bold'>BORANG Q</span><br><br>
		<span><span class="italic">AKTA KESATUAN SEKERJA, 1959</span><br>(Seksyen 74(2) dan Peraturan 22)</span><br><br>
		<span>NOTIS KETETAPAN UNTUK BERSATU DENGAN SESUATU PERSEKUTUAN<br>KESATUAN-KESATUAN SEKERJA</span><br><br>
	</div>

	<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
		<span class="a">Nama kesatuan sekerja berdaftar </span>  {{ $formpq->tenure->entity->name }}
	</div>
	<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
		<span class="a">No. Pendaftaran </span>  {{ $formpq->tenure->entity->registration_no }}
	</div>
	<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
		<span class="a">Alamat ibu pejabat berdaftar </span> 
		@if($formpq->formq->address)
			{{ $formpq->formq->address->address1 ? $formpq->formq->address->address1.',' : '' }}
			{{ $formpq->formq->address->address2 ? $formpq->formq->address->address2.',' : '' }}
			{{ $formpq->formq->address->address3 ? $formpq->formq->address->address3.',' : '' }}
			{{ $formpq->formq->address->postcode ? $formpq->formq->address->postcode : '' }}
			{{ $formpq->formq->address->district ? $formpq->formq->address->district->name.',' : '' }}
			{{ $formpq->formq->address->state ? $formpq->formq->address->state->name.'.' : '' }}
		@endif
	</div>
	<div style="padding-top: 15px;">
		<table>
		    <tr>
		  		<td>
		  			<p style="text-indent: 90px">Notis dengan ini diberikan bahawa kesatuan sekerja yang disebutkan di atas telah menetapkan untuk bergabung dengan <span class="dotted">{{ $formpq->formq->federation ? $formpq->formq->federation->name : '' }}</span> suatu persekutuan kesatuan sekerja, yang didaftarkan di bawah nombor sijil pendaftaran <span class="dotted">{{ $formpq->formq->federation ? $formpq->formq->federation->registration_no : '' }}</span>.</p>
		  		</td>
		  	</tr>
		  	<tr>
		  		<td>
		  			<p style="text-indent: 90px">Persetujuan anggota-anggota telah diperolehi oleh suatu undi majoriti yang diambil di suatu  {{ $formpq->formq->meeting_type ? $formpq->formq->meeting_type->name : '' }} pada <span class="dotted"> {{ strftime('%e', strtotime($formpq->formq->resolved_at)) }} </span> haribulan <span class="dotted"> {{ strftime('%B', p($formpq->formq->resolved_at)).' '.strftime('%Y', strtotime($formpq->formq->resolved_at)) }} </span>.</p>
		  		</td>
		  	</tr>
		  	<tr>
		  		<td>
		  			<p style="text-indent: 90px">Satu salinan minit-minit berkenaan dilampirkan.</p>
		  		</td>
		  	</tr>
		  	<tr>
				<td>
					<table>
						<tr>
							<td></td>
							<td class="italic center">Tandatangan</td>
							<td class="italic center">Nama orang-orang yang<br>menandatangan dalam<br>huruf besar</td>
						</tr>
						<tr>
							<td style="width: 30%">Setiausaha :</td>
							<td>
								<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
									<span class="a"> </span>  
								</div>					
							</td>
							<td>
								<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
									{{ $formpq->tenure->entity->user->name }}
								</div>				
							</td>
						</tr>
						<tr>
							<td>Tujuh orang anggota<br>(tidak semestinya pegawai)</td>
							<td>
								@foreach($formpq->formq->members as $index => $member)
								<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
									<span class="a">{{ $index+1 }}. &nbsp; </span>  
								</div>	
								@endforeach					
							</td>
							<td>
								@foreach($formpq->formq->members as $index => $member)
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
		  
		<p>Bertarikh pada <span class="dotted"> {{ strftime('%e') }} </span> haribulan <span class="dotted"> {{ strftime('%B').' '.strftime('%Y') }} </span></p><br>

	</div>
	
</body>
