@component('mail::message')
# {{ addcslashes($subject , '#') }}

{!!
str_replace(
    array(
    	"[case_no]"
    ),
    array(
    	$filing->references->first()->reference_no
    ),
    $template
)
!!}

<strong>{{ config('app.name') }}</strong>
@endcomponent