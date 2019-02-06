<?php
setlocale(LC_TIME, "ms", "en_MS");
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
	    <span class='uppercase bold'>FORM P</span><br><br>
		<span>TRADE UNIONS ACT 1959<br>(Section 74(1) and Regulation 21)</span><br><br>
		<span class="bold">NOTICE OF INTENTION TO AFFILIATE WITH A FEDERATION OF TRADE UNIONS</span><br><br>
	</div>

	<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
		<span class="a">Name of trade union </span>  {{ $formpq->tenure->entity->name }}
	</div>
	<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
		<span class="a">Certificate of Registration number </span>  {{ $formpq->tenure->entity->registration_no }}
	</div>
	<div class="dotted line" style="padding-bottom: 5px; text-align: left;">
		<span class="a">Registered address of head office</span> 
		@if($formp->formp->address)
			{{ $formpq->formp->address->address1 ? $formpq->formp->address->address1.',' : '' }}
			{{ $formpq->formp->address->address2 ? $formpq->formp->address->address2.',' : '' }}
			{{ $formpq->formp->address->address3 ? $formpq->formp->address->address3.',' : '' }}
			{{ $formpq->formp->address->postcode ? $formpq->formp->address->postcode : '' }}
			{{ $formpq->formp->address->district ? $formpq->formp->address->district->name.',' : '' }}
			{{ $formpq->formp->address->state ? $formpq->formp->address->state->name.'.' : '' }}
		@endif
	</div>
	<table>
	  	<tr>
	  		<td colspan="2">To:</td>
	  	</tr>
	  	<tr>
	  		<td width="10%"></td>
	  		<td style="padding-top: 0px">
	  			The Director General of Trade Unions,<br>
	    		Kuala Lumpur.<br>
	  		</td>
	  	</tr>
	    <tr>
	  		<td colspan="2">
	  			<div style="text-indent: 90px">Notice is hereby given that it is the intention of the above-mentioned trade union to affiliate with the <span class="dotted">{{ $formpq->formp->federation ? $formpq->formp->federation->name : '' }}</span>.</div>
	  		</td>
	  	</tr>
	  	<tr>
	  		<td colspan="2">
	  			A vote of the members of this trade union will be taken at a {{ $formpq->formp->meeting_type ? $formpq->formp->meeting_type->name : '' }} on {{ date('d/m/Y' , strtotime($formpq->formp->resolved_at)) }}.
	  		</td>
	  	</tr>
	  </table>

	  <table>
		<tr style="vertical-align: top">
			<td style="width: 80%; text-align: right;"></td>
			<td style="text-align: left;">
				...............................................<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i>Secretary</i>
			</td>
		</tr>
	</table>
	<p>Dated this <span class="dotted"> {{ strftime('%e') }} </span> day of <span class="dotted"> {{ strftime('%B').' '.strftime('%Y') }} </span></p><br>
	
	<hr style="border: 1px solid">
	<div class="center italic" style="font-size: 15px;">*Delete whichever is inappropriate</div> 
</body>
