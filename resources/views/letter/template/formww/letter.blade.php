include('components.bs.input', [
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
	'name' => 'consultant_name',
	'label' => 'Nama Badan Perunding',
	'mode' => 'disabled',
	'value' => $letter->filing->consultant_name,
])

@include('components.bs.input', [
	'name' => 'province_office_name',
	'label' => 'Nama Pejabat Wilayah/Negeri',
	'mode' => 'disabled',
	'value' => $letter->entity->province_office->name
])

@include('components.bs.input', [
	'name' => 'ob_kpks_name',
	'label' => 'Nama Pegawai Bagi Pihak Ketua Pengarah',
	'value' => array_key_exists('ob_kpks_name',$data) ? $data['ob_kpks_name'] : ''
])
