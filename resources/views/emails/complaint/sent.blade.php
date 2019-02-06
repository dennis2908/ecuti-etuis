@component('mail::message')
# {{ addcslashes($subject , '#') }}

{!!
str_replace(
    array(
    	"[complaint_by]",
    	"[received_at]",
    	"[reference_no]",
    	"[officer_name]"
    ),
    array(
    	$filing->complaint_by,
    	$filing->logs()->where('activity_type_id', 12)->first()->data,
    	$filing->references->first()->reference_no,
    	$filing->distributions()->whereHas('assigned_to.entity_staff.role', function($role) { return $role->where('name', 'ppw'); })->first()->assigned_to->name
    ),
    $template
)
!!}

<strong>{{ config('app.name') }}</strong>
@endcomponent
