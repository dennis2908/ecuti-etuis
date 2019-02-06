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
		    height: 0.8em;
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
	    <span class='uppercase'>FORM W</span><br><br>
		<span>TRADE UNIONS ACT 1959<br>(Section 76B (1) and Regulation 30B)<br>APPLICATION FOR PERMISSION TO AFFILIATE WITH OR BE MEMBER OF A<br>CONSULTATIVE OR SIMILAR BODY OUTSIDE MALAYSIA</span><br><br>
	</div>
	<div>To the Director General of Trade Unions, Kuala Lumpur,</div>
	<div class="dotted line" style="padding-bottom: 6px; text-align: left;">
		<span class="a">Name of trade union </span>  {{ $formw->tenure->entity->name }}
	</div>
	<div class="dotted line" style="padding-bottom: 6px; text-align: left;">
		<span class="a">Registration number </span>  {{ $formw->tenure->entity->registration_no }}
	</div>
	<div class="dotted line" style="padding-bottom: 6px; text-align: left;">
		<span class="a">Address of head office</span> 
		@if($formw->address)
			{{ $formw->address->address1 ? $formw->address->address1.',' : '' }}
			{{ $formw->address->address2 ? $formw->address->address2.',' : '' }}
			{{ $formw->address->address3 ? $formw->address->address3.',' : '' }}
			{{ $formw->address->postcode ? $formw->address->postcode : '' }}
			{{ $formw->address->district ? $formw->address->district->name.',' : '' }}
			{{ $formw->address->state ? $formw->address->state->name.'.' : '' }}
		@endif
	</div>
	<div style="padding-top: 15px;">
		<table>
		  	<tr>
		  		<td>We, the undersigned, apply for permission for the above-named trade union to* affiliate with/be a member of the following body-</td>
		  	</tr>
		  	<tr>
		  		<td>
		  			<div class="dotted line" style="padding-bottom: 6px; text-align: left;">
						<span class="a">Name </span>  {{ $formw->consultant_name }}
					</div> 
					<div class="dotted line" style="padding-bottom: 6px; text-align: left;">
						<span class="a">Address of its head office </span> {{ $formw->consultant_address }}
					</div> 
					<br>
		  		</td>
		  	</tr>
		    <tr>
		  		<td class="justify">
		  			2.&nbsp;&nbsp;The objects for which the above body is established are-
		  			<ul>
		  				@foreach($formw->purposes as $index => $purpose)
		  				<li>
		  					<div class="dotted line" style="padding-bottom: 6px; text-align: left;">
								<span class="a"></span>  {{ $purpose->purpose }}</span>
							</div>
						</li>
		  				@endforeach
		  			</ul>
		  		</td>
		  	</tr>
		  	<tr>
		  		<td class="justify">
		  			3.&nbsp;&nbsp;A copy of the constitution and rules of the above body is attached to this application.
		  		</td>
		  	</tr>
		  	<tr>
		  		<td class="justify">
		  			4.&nbsp;&nbsp;The statement of particulars relating to the office bearers of the above body required by section 76B (2) (c) is given in the Schedule attached to this application.
		  		</td>
		  	</tr>
		  	<tr>
		  		<td class="justify">
		  			5.&nbsp;&nbsp;We have been duly authorised by the trade union to make this application on its behalf, such authorisation consisting of a resolution passed by its members at the *general meeting/*delegates' conference on <span class="dotted"></span> A copy of the relevant minutes is attached here to.
		  		</td>
		  	</tr>
		  	<tr>
				<td>
					<table>
						<tr>
							<td width="15%"></td>
							<td width="25%" class="italic center">Signature of the applicants</td>
							<td class="italic center">Names(in block letters)</td>
						</tr>
						@foreach($formw->requesters as $index => $requester)
						<tr>
							<td>{{ $requester->officer->designation ? $requester->officer->designation->name : '' }}</td>
							<td>
								<div class="dotted line" style="padding-bottom: 6px; text-align: left;">
									<span class="a">{{ $index+1 }}. &nbsp; </span>  
								</div>				
							</td>
							<td>
								<div class="dotted line" style="padding-bottom: 6px; text-align: left;">
									{{ $requester->officer->name }}
								</div>			
							</td>
						</tr>
						@endforeach
					</table>
				</td>
			</tr>
		</table>
		<hr style="color: 1px solid black">
		<small>*Delete whichever is not applicable</small>
	</div>
</body>
