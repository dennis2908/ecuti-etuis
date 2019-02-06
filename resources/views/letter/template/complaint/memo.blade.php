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
	'name' => 'carbon_copy',
	'label' => 'Salinan Kepada',
	'value' => array_key_exists('carbon_copy',$data) ? $data['carbon_copy'] : ''
])

@include('components.bs.input', [
	'name' => 'entity_name',
	'label' => 'Nama Kesatuan',
	'mode' => 'disabled',
	'value' => $letter->entity->name
])

@include('components.bs.date', [
	'name' => 'decided_at',
	'label' => 'Tarikh Keputusan',
	'value' => array_key_exists('decided_at',$data) ? $data['decided_at'] : date('d/m/Y')
])

@include('components.bs.textarea', [
	'name' => 'decisions',
	'label' => 'Keputusan',
	'mode' => 'disabled',
	'value' => $letter->filing->logs()->where('activity_type_id', 16)->first()->data
])

@include('components.bs.input', [
	'name' => 'ob_kpks_name',
	'label' => 'Nama Pegawai bagi Pihak Ketua Pengarah',
	'value' => array_key_exists('ob_kpks_name',$data) ? $data['ob_kpks_name'] : ''
])
