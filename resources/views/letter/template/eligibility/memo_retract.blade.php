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
	'name' => 'province_office_name',
	'label' => 'Nama Pejabat Wilayah/Negeri',
	'mode' => 'disabled',
	'value' => $letter->entity->province_office->name
])

@include('components.bs.input', [
	'name' => 'company_name',
	'label' => 'Nama Syarikat',
	'mode' => 'disabled',
	'value' => $letter->filing->forma->company_name,
])

@include('components.bs.input', [
	'name' => 'filing_applied_at',
	'label' => 'Tarikh Permohonan',
	'mode' => 'disabled',
	'value' => date('d/m/Y', strtotime($letter->filing->forma->applied_at)),
])

@include('components.bs.input', [
	'name' => 'entity_name',
	'label' => 'Nama Kesatuan',
	'mode' => 'disabled',
	'value' => $letter->entity->name
])

@include('components.bs.input', [
	'name' => 'letter_reference_no',
	'label' => 'No. Rujukan Surat Jabatan Perhubungan Perusahaan ',
	'value' => array_key_exists('letter_reference_no',$data) ? $data['letter_reference_no'] : ''
])

@include('components.bs.input', [
	'name' => 'letter_reference_date',
	'label' => 'Tarikh Surat Jabatan Perhubungan Perusahaan ',
	'value' => array_key_exists('letter_reference_date',$data) ? $data['letter_reference_date'] : date('d/m/Y')
])

