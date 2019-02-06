@component('mail::message')
# {{ addcslashes($subject , '#') }}

{!!
str_replace(
    array(
    	"[entity_name]",
    	"[reasons]",
    ),
    array(
    	$filing->created_by->entity->name,
    	$filing->logs()->where('activity_type_id', 15)->first()->data,
    ),
    $template
)
!!}

<strong>{{ config('app.name') }}</strong>
@endcomponent