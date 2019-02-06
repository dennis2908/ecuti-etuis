@component('mail::message')
# {{ addcslashes($subject , '#') }}

{!!
str_replace(
    array(
    	"[type_full]"
    ),
    array(
    	$user->user_type_id == 3 ? "kesatuan sekerja" : "persekutuan kesatuan sekerja"
    ),
    $template
)
!!}

<strong>{{ config('app.name') }}</strong>
@endcomponent
