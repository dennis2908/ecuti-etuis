@component('mail::message')
# {{ addcslashes($subject , '#') }}

{!! $template !!}

<strong>{{ config('app.name') }}</strong>
@endcomponent
