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

@include('components.bs.input', [
	'name' => 'payee_name',
	'label' => 'Pembayaran Kepada',
	'value' => array_key_exists('payee_name',$data) ? $data['payee_name'] : ''
])

@include('components.bs.input', [
	'name' => 'payee_email',
	'label' => 'Emel',
	'value' => array_key_exists('payee_email',$data) ? $data['payee_email'] : ''
])

@include('components.bs.input', [
	'name' => 'payee_phone',
	'label' => 'No. Telefon',
	'value' => array_key_exists('payee_phone',$data) ? $data['payee_phone'] : ''
])

@include('components.bs.input', [
	'name' => 'kpks_name',
	'label' => 'Nama Ketua Pengarah',
	'mode' => 'disabled',
	'value' => $letter->entity->province_office->kpks->name
])

@include('components.bs.input', [
	'name' => 'enforcement_date',
	'label' => 'Berkuatkuasa mulai',
	'value' => array_key_exists('enforcement_date',$data) ? $data['enforcement_date'] : date('d/m/Y')
])

@include('components.bs.input', [
	'name' => 'entity_new_name',
	'label' => 'Nama Baru Kesatuan',
	'value' => array_key_exists('entity_new_name',$data) ? $data['entity_new_name'] : ''
])

@include('components.bs.input', [
	'name' => 'registered_at',
	'label' => 'Tarikh Didaftarkan',
	'mode' => 'disabled',
	'value' => date('d/m/Y', strtotime($letter->filing->logs()->where('activity_type_id', 16)->first()->created_at))
])

@include('components.bs.input', [
	'name' => 'registration_no',
	'label' => 'No. Pendaftaran',
	'mode' => 'disabled',
	'value' => $letter->entity->registration_no
])

@include('components.bs.input', [
	'name' => 'date',
	'label' => 'Bertarikh pada',
	'value' => date('d/m/Y')
])
