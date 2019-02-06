@component('mail::message')
# {{ addcslashes($subject , '#') }}

{!!
str_replace(
    array(
    	"[entity_name]",
    	"[approved_at]"
    ),
    array(
    	$filing->created_by->entity->name,
    	date('d/m/Y', strtotime($filing->logs()->where('activity_type_id', 16)->first()->created_at))
    ),
    $template
)
!!}

<strong>{{ config('app.name') }}</strong>
@endcomponent