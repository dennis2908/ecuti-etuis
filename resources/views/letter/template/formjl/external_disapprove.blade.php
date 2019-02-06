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
	'name' => 'filing_applied_at',
	'label' => 'Tarikh Permohonan',
	'mode' => 'disabled',
	'value' => date('d/m/Y', strtotime($letter->filing->applied_at)),
])

@include('components.bs.input', [
	'name' => 'auditor_name',
	'label' => 'Nama Penuh Juruaudit',
	'mode' => 'disabled',
    'value' => $letter->filing->auditor_name
])

@include('components.bs.input', [
	'name' => 'auditor_identification_no',
	'label' => 'No. Kad Pengenalan',
	'mode' => 'disabled',
    'value' => $letter->filing->auditor_identification_no
])

@include('components.bs.date', [
	'name' => 'year_end',
	'label' => 'Tahun Berakhir',
	'value' => array_key_exists('year_end',$data) ? $data['year_end'] : date('Y'),
])

@include('components.bs.textarea', [
	'name' => 'reasons',
	'label' => 'Alasan-alasan',
	'mode' => 'disabled',
	'value' => $letter->filing->logs()->where('activity_type_id', 16)->first()->data
])

@include('components.bs.input', [
	'name' => 'pw_name',
	'label' => 'Nama Pengarah Kesatuan Sekerja',
	'mode' => 'disabled',
	'value' => $letter->entity->province_office->pw->name
])

@include('components.bs.input', [
	'name' => 'province_office_name',
	'label' => 'Nama Pejabat Wilayah/Negeri',
	'mode' => 'disabled',
	'value' => $letter->entity->province_office->name
])