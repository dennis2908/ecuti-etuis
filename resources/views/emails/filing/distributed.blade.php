@component('mail::message')
# {{ addcslashes($subject , '#') }}

{!!
str_replace(
    array(
    	"[module_name]",
    	"[reference_no]"
    ),
    array(
    	$filing->logs->first()->module->name,
    	$filing->references->first()->reference_no
    ),
    $template
)
!!}

<strong>{{ config('app.name') }}</strong>
@endcomponent
