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
	'value' => $letter->filing->formp->address->address1.
	    ($letter->filing->formp->address->address2 ? ', '.$letter->filing->formp->address->address2 : '').
	    ($letter->filing->formp->address->address3 ? ', '.$letter->filing->formp->address->address3 : '').
	    ', '.
	    $letter->filing->formp->address->postcode.' '.
	    ($letter->filing->formp->address->district ? $letter->filing->formp->address->district->name : '').', '.
	    ($letter->filing->formp->address->state ? $letter->filing->formp->address->state->name : '')
])

@include('components.bs.input', [
	'name' => 'province_office_name',
	'label' => 'Nama Pejabat Wilayah/Negeri',
	'mode' => 'disabled',
	'value' => $letter->entity->province_office->name
])

@include('components.bs.input', [
	'name' => 'kpks_name',
	'label' => 'Nama Ketua Pengarah',
	'mode' => 'disabled',
	'value' => $letter->entity->province_office->kpks->name
])
