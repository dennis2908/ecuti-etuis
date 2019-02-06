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
	'name' => 'letter_reference_no',
	'label' => 'No Rujukan Surat Tuan',
	'value' => array_key_exists('letter_reference_no',$data) ? $data['letter_reference_no'] : ''
])

@include('components.bs.date', [
	'name' => 'letter_reference_date',
	'label' => 'Tarikh Surat Tuan',
	'value' => array_key_exists('letter_reference_date',$data) ? $data['letter_reference_date'] : date('d/m/Y')
])

@include('components.bs.date', [
	'name' => 'kpks_letter_date',
	'label' => 'Tarikh Surat Ketua Pengarah',
	'value' => array_key_exists('kpks_letter_date',$data) ? $data['kpks_letter_date'] : date('d/m/Y')
])

@include('components.bs.textarea', [
	'name' => 'reasons',
	'label' => 'Tidak membenarkan kesatuan untuk ',
	'value' => array_key_exists('reasons',$data) ? $data['reasons'] : ''
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
