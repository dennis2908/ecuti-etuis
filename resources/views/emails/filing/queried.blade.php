<?php
$template = explode("[queries]", $template);
?>

@component('mail::message')
# {{ addcslashes($subject , '#') }}

{!! $template[0] !!}
<ol type="i">
@foreach($queries as $query)
	<li>{{ $query->content }}</li>
@endforeach
</ol>
{!! $template[1] !!}

<strong>{{ config('app.name') }}</strong>
@endcomponent
