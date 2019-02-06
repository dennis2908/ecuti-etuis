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

@include('components.bs.date', [
	'name' => 'carbon_copy',
	'label' => 'Salinan Kepada',
	'value' => array_key_exists('carbon_copy',$data) ? $data['carbon_copy'] : ''
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
	'name' => 'ob_kpks_name',
	'label' => 'Nama Pegawai bagi pihak Ketua Pengarah',
	'mode' => 'disabled',
	'value' => array_key_exists('ob_kpks_name',$data) ? $data['ob_kpks_name'] :''
])

@include('components.bs.input', [
	'name' => 'province_office_name',
	'label' => 'Nama Pejabat Wilayah/Negeri',
	'mode' => 'disabled',
	'value' => $letter->entity->province_office->name
])
