<?php
$url = route('handover', substr($user->password, 11, 8));

$template = explode("[button]", $template);
?>

@component('mail::message')
# {{ addcslashes($subject , '#') }}

{!!
str_replace(
    array(
    	"[entity_name]"
    ),
    array(
    	$user->entity->name
    ),
    $template[0]
)
!!}

@component('mail::button', ['url' => $url])
Terima Tugas
@endcomponent

@component('mail::panel')
{{ $url }}
@endcomponent

<small><i>P/S: Jika butang/pautan di atas tidak berfungsi, sila buka pautan tersebut pada pelayar web anda.</i></small>

{!! $template[1] !!}

<strong>{{ config('app.name') }}</strong>
@endcomponent
