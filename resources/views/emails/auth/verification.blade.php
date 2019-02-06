<?php
$i = 10;
$code = substr($user->password, $i, 8);

while(strpos($code, '/') !== false) {
	$code = substr($user->password, $i++, 8);
}

$url = route('auth.verify', ['username' => $user->username, 'code' => $code])
?>

@component('mail::message')
# Pengesahan Emel

Untuk pengesahkan emel dan pengaktifan akaun anda, sila klik pada butang/pautan dibawah:

@component('mail::button', ['url' => $url])
Aktifkan Akaun
@endcomponent

@component('mail::panel')
{{ $url }}
@endcomponent

<small><i>P/S: Jika butang/pautan di atas tidak berfungsi, sila buka pautan tersebut pada pelayar web anda.</i></small><br><br>

Terima kasih,<br>
<strong>{{ config('app.name') }}</strong>
@endcomponent
