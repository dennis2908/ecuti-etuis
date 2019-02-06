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
	'value' => $letter->entity->addresses->last()->address->address1.
	    ($letter->entity->addresses->last()->address->address2 ? ', '.$letter->entity->addresses->last()->address->address2 : '').
	    ($letter->entity->addresses->last()->address->address3 ? ', '.$letter->entity->addresses->last()->address->address3 : '').
	    ', '.
	    $letter->entity->addresses->last()->address->postcode.' '.
	    ($letter->entity->addresses->last()->address->district ? $letter->entity->addresses->last()->address->district->name : '').', '.
	    ($letter->entity->addresses->last()->address->state ? $letter->entity->addresses->last()->address->state->name : '')
])

@include('components.bs.input', [
	'name' => 'accept_date',
	'label' => 'Tarikh Permohonan Diterima',
	'value' => array_key_exists('accept_date',$data) ? $data['accept_date'] : date('d/m/Y')
])

@include('components.bs.date', [
	'name' => 'registered_at',
	'label' => 'Tarikh Didaftarkan',
	'mode' => 'disabled',
	'value' => date('d/m/Y', strtotime($letter->filing->logs()->where('activity_type_id', 16)->first()->created_at))
])

@include('components.bs.input', [
	'name' => 'kpks_name',
	'label' => 'Nama Ketua Pengarah',
	'mode' => 'disabled',
	'value' => $letter->entity->province_office->kpks->name
])

@include('components.bs.input', [
	'name' => 'province_office_name',
	'label' => 'Nama Pejabat Wilayah/Negeri',
	'mode' => 'disabled',
	'value' => $letter->entity->province_office->name
])