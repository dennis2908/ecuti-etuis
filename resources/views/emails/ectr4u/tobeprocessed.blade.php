@component('mail::message')
# {{ addcslashes($subject , '#') }}

{!!
str_replace(
    array(
    	"[url]"
    ),
    array(
    	env('APP_URL')
    ),
    $template
)
!!}

<strong>{{ config('app.name') }}</strong>
@endcomponent