@component('mail::message')
# {{ addcslashes($subject , '#') }}

{!!
str_replace(
    array(
    	"[entity_name]"
    ),
    array(
    	$filing->created_by->entity->name
    ),
    $template
)
!!}

<strong>{{ config('app.name') }}</strong>
@endcomponent