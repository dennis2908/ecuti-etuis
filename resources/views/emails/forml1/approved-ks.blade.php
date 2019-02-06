@component('mail::message')
# {{ addcslashes($subject , '#') }}

{!!
str_replace(
    array(
    	"[applied_at]",
    	"[approved_at]"
    ),
    array(
    	date('d/m/Y', strtotime($filing->applied_at)),
    	date('d/m/Y', strtotime($filing->logs()->where('activity_type_id', 16)->first()->created_at))
    ),
    $template
)
!!}

<strong>{{ config('app.name') }}</strong>
@endcomponent