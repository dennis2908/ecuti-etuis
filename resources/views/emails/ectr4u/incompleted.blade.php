<?php
$template = explode("[list]", $template);
?>

@component('mail::message')
# {{ addcslashes($subject , '#') }}

{!! $template[0] !!}
<ol type="i">
@foreach($list as $item)
	<li>{{ preg_replace('/^\s*[0-9ivx]+\s*[\)|\-\.]+\s*/', '', $item) }}</li>
@endforeach
</ol>
{!! $template[1] !!}

<strong>{{ config('app.name') }}</strong>
@endcomponent
