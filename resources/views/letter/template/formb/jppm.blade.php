@include('components.bs.input', [
	'name' => 'reference_no',
	'label' => 'No. Rujukan',
	'mode' => 'disabled',
	'value' => $letter->reference ? $letter->reference->reference_no : ''
])

@include('components.bs.date', [
	'name' => 'letter_date',
	'label' => 'Tarikh Surat',
	'value' => array_key_exists('letter_date',$data) ? $data['letter_date'] : date('d/m/Y')
])

@include('components.bs.input', [
	'name' => 'entity_name',
	'label' => 'Nama Kesatuan',
	'mode' => 'disabled',
	'value' => $letter->entity->name
])

@include('components.bs.input', [
	'name' => 'carbon_copy',
	'label' => 'Salinan Kepada',
	'value' => array_key_exists('carbon_copy',$data) ? $data['carbon_copy'] : ''
])

@include('components.bs.input', [
	'name' => 'registration_no',
	'label' => 'No. Pendaftaran',
	'mode' => 'disabled',
	'value' => $letter->entity->registration_no
])

@include('components.bs.input', [
	'name' => 'registered_at',
	'label' => 'Tarikh Didaftarkan',
	'mode' => 'disabled',
	'value' => date('d/m/Y', strtotime($letter->entity->formb->logs()->where('activity_type_id', 16)->first()->created_at))
])

@include('components.bs.textarea', [
	'name' => 'address',
	'label' => 'Alamat',
	'mode' => 'disabled',
	'value' => $letter->filing->address->address1.
	    ($letter->filing->address->address2 ? ', '.$letter->filing->address->address2 : '').
	    ($letter->filing->address->address3 ? ', '.$letter->filing->address->address3 : '').
	    ', '.
	    $letter->filing->address->postcode.' '.
	    ($letter->filing->address->district ? $letter->filing->address->district->name : '').', '.
	    ($letter->filing->address->state ? $letter->filing->address->state->name : '')
])

@include('components.bs.textarea', [
	'name' => 'scope',
	'label' => 'Skop Keanggotaan',
	'value' => array_key_exists('scope',$data) ? $data['scope'] : ''
])

@include('components.bs.input', [
	'name' => 'kpks_name',
	'label' => 'Nama Ketua Pengarah',
	'mode' => 'disabled',
	'value' => $letter->entity->province_office->kpks->name
])
