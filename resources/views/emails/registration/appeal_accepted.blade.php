<?php
$url = route('login');

$template = explode("[button]", $template);
?>

@component('mail::message')
# {{ addcslashes($subject , '#') }}

{!!
str_replace(
    array(
    	"[type_full]"
    ),
    array(
    	$user->user_type_id == 3 ? "kesatuan sekerja" : "persekutuan kesatuan sekerja"
    ),
    $template[0]
)
!!}

@component('mail::button', ['url' => $url])
Failkan Borang B
@endcomponent

@component('mail::panel')
{{ $url }}
@endcomponent

<small><i>P/S: Jika butang/pautan di atas tidak berfungsi, sila buka pautan tersebut pada pelayar web anda.</i></small>

{!! $template[1] !!}

<strong>{{ config('app.name') }}</strong>
@endcomponent
