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

@include('components.bs.input', [
	'name' => 'company_name',
	'label' => 'Nama Syarikat',
	'mode' => 'disabled',
	'value' => $letter->filing->forma->company_name,
])

@include('components.bs.textarea', [
	'name' => 'company_address',
	'label' => 'Lokasi Siasatan',
	'mode' => 'disabled',
	'value' => $letter->filing->forma->company_address->address1.
	    ($letter->filing->forma->company_address->address2 ? ', '.$letter->filing->forma->company_address->address2 : '').
	    ($letter->filing->forma->company_address->address3 ? ', '.$letter->filing->forma->company_address->address3 : '').
	    ', '.
	    $letter->filing->forma->company_address->postcode.' '.
	    ($letter->filing->forma->company_address->district ? $letter->filing->forma->company_address->district->name : '').', '.
	    ($letter->filing->forma->company_address->state ? $letter->filing->forma->company_address->state->name : '')
])

@include('components.bs.input', [
	'name' => 'filing_reference_no',
	'label' => 'No. Rujukan Permohonan',
	'mode' => 'disabled',
	'value' => $letter->filing->references->last()->reference_no,
])

@include('components.bs.input', [
	'name' => 'filing_applied_at',
	'label' => 'Tarikh Permohonan',
	'mode' => 'disabled',
	'value' => date('d/m/Y', strtotime($letter->filing->forma->applied_at)),
])

@include('components.bs.textarea', [
	'name' => 'investigate_at',
	'label' => 'Tarikh Siasatan',
    'value' => array_key_exists('investigate_at',$data) ? $data['investigate_at'] : date('d/m/Y')
])

@include('components.bs.textarea', [
	'name' => 'investigation_details',
	'label' => 'Maklumat Siasatan',
    'value' => array_key_exists('investigation_details',$data) ? $data['investigation_details'] : ''
])

@include('components.bs.textarea', [
	'name' => 'scope',
	'label' => 'Skop Keanggotaan',
    'value' => array_key_exists('scope',$data) ? $data['scope'] : ''
])

@include('components.bs.input', [
	'name' => 'kpks_name',
	'label' => 'Nama Ketua Pengarah',
	'mode' => 'disabled',
	'value' => $letter->entity->province_office->kpks->name
])
