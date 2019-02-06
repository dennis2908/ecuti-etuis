@component('mail::message')
# {{ addcslashes($subject , '#') }}

{!!
str_replace(
    array(
    	"[module_name]",
    	"[reference_no]",
    	"[entity_name]"
    ),
    array(
    	$filing->logs->first()->module->name,
    	$filing->references->first()->reference_no,
    	$filing->created_by->entity->name
    ),
    $template
)
!!}

<strong>{{ config('app.name') }}</strong>
@endcomponent