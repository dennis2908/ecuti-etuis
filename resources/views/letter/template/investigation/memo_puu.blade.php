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

@include('components.bs.date', [
	'name' => 'date',
	'label' => 'Tarikh Surat Tuan',
	'value' => array_key_exists('date',$data) ? $data['date'] : date('d/m/Y')
])

@include('components.bs.input', [
	'name' => 'entity_name',
	'label' => 'Siasatan Terhadap',
	'mode' => 'disabled',
	'value' => $letter->filing->pdw01->subject
])

@include('components.bs.date', [
	'name' => 'contact_name',
	'label' => 'Nama pegawai yang boleh dihubungi',
	'value' => array_key_exists('contact_name',$data) ? $data['contact_name'] : ''
])

@include('components.bs.date', [
	'name' => 'contact_phone',
	'label' => 'No Telefon',
	'value' => array_key_exists('contact_phone',$data) ? $data['contact_phone'] : ''
])

@include('components.bs.input', [
	'name' => 'kpks_name',
	'label' => 'Nama Ketua Pengarah',
	'mode' => 'disabled',
    'value' => $letter->entity->province_office->kpks->name
])
