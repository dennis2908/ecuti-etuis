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
	'name' => 'your_letter',
	'label' => 'Surat Tuan',
	'value' => array_key_exists('your_letter',$data) ? $data['your_letter'] :''
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
	'value' => array_key_exists('ob_kpks_name',$data) ? $data['ob_kpks_name'] :''
])
