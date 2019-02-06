<?php
$i = 10;
$code = substr($user->password, $i, 8);

while(strpos($code, '/') !== false) {
    $code = substr($user->password, $i++, 8);
}

$url = route('auth.verify', ['username' => $user->username, 'code' => $code]);

$template = explode("[button]", $template);
?>

@component('mail::message')
# {{ addcslashes($subject , '#') }}

{!!
str_replace(
    array(
    	"[name]",
    	"[type_full]",
    	"[username]",
    	"[password]",
    	"[type]",
    	"[entity_name]",
    	"[registered_at]"
    ),
    array(
    	ucwords($user->name),
    	$user->user_type_id == 3 ? "kesatuan sekerja" : "persekutuan kesatuan sekerja",
    	$user->username,
    	$password,
    	$user->user_type_id == 3 ? "Kesatuan" : "Persekutuan",
    	$user->entity->name,
    	date('d/m/Y', strtotime($user->entity->registered_at))
    ),
    $template[0]
)
!!}

@component('mail::button', ['url' => $url])
Sahkan Emel
@endcomponent

@component('mail::panel')
{{ $url }}
@endcomponent

<small><i>P/S: Jika butang/pautan di atas tidak berfungsi, sila buka pautan tersebut pada pelayar web anda.</i></small>

{!! $template[1] !!}

<strong>{{ config('app.name') }}</strong>
@endcomponent
