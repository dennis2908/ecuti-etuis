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

@include('components.bs.textarea', [
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

@include('components.bs.input', [
	'name' => 'filing_applied_at',
	'label' => 'Tarikh Permohonan',
	'mode' => 'disabled',
	'value' => date('d/m/Y', strtotime($letter->filing->applied_at)),
])

@include('components.bs.textarea', [
	'name' => 'extra_documents_received',
	'label' => 'Salinan Dokumen Tambahan',
	'value' => array_key_exists('extra_documents_received',$data) ? $data['extra_documents_received'] : ''
])

@include('components.bs.textarea', [
	'name' => 'reasons',
	'label' => 'Sebab-sebab',
	'mode' => 'disabled',
	'value' => array_key_exists('reasons',$data) ? $data['reasons'] : ''
])

@include('components.bs.textarea', [
	'name' => 'extra_documents_checked',
	'label' => 'Semakan Dokumen Tambahan',
	'value' => array_key_exists('extra_documents_checked',$data) ? $data['extra_documents_checked'] : ''
])

@include('components.bs.input', [
	'name' => 'pw_name',
	'label' => 'Nama Pengarah Kesatuan Sekerja',
	'mode' => 'disabled',
	'value' => $letter->entity->province_office->pw->name
])
