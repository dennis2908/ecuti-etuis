<?php
$i = 10;
$code = substr($user->password, $i, 8);

while(strpos($code, '/') !== false) {
	$code = substr($user->password, $i++, 8);
}

$url = route('appeal.form', ['username' => $user->username, 'code' => $code]);

$template = explode("[button]", $template);
?>

@component('mail::message')
# {{ addcslashes($subject , '#') }}

{!!
str_replace(
    array(
    	"[type_full]",
    	"[limit]"
    ),
    array(
    	$user->user_type_id == 3 ? "kesatuan sekerja" : "persekutuan kesatuan sekerja",
    	env('MAX_DAYS_AFTER_REGISTER_ENTITY', 30)
    ),
    $template[0]
)
!!}

@component('mail::button', ['url' => $url])
Failkan Rayuan
@endcomponent

@component('mail::panel')
{{ $url }}
@endcomponent

<small><i>P/S: Jika butang/pautan di atas tidak berfungsi, sila buka pautan tersebut pada pelayar web anda.</i></small>

{!! $template[1] !!}

<strong>{{ config('app.name') }}</strong>
@endcomponent
