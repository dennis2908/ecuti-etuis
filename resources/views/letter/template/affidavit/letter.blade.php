<?php
	$respondent_list = '';
	foreach ($letter->filing->respondents as $key => $respondent) {
		$respondent_list .= $respondent->respondent.',';
	}
?>

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
	'name' => 'applicant',
	'label' => 'Nama Pemohon',
	'mode' => 'disabled',
	'value' => $letter->filing->applicant
])

@include('components.bs.textarea', [
	'name' => 'address',
	'label' => 'Alamat Pejabat Peguam',
	'mode' => 'disabled',
	'value' => $letter->filing->report->court->address->address1.
	    ($letter->filing->report->court->address->address2 ? ', '.$letter->filing->report->court->address->address2 : '').
	    ($letter->filing->report->court->address->address3 ? ', '.$letter->filing->report->court->address->address3 : '').
	    ', '.
	    $letter->filing->report->court->address->postcode.' '.
	    ($letter->filing->report->court->address->district ? $letter->filing->report->court->address->district->name : '').', '.
	    ($letter->filing->report->court->address->state ? $letter->filing->report->court->address->state->name : '')
])

@include('components.bs.input', [
	'name' => 'judicial_no',
	'label' => 'No. Semakan Kehakiman',
	'mode' => 'disabled',
	'value' => $letter->filing->report->judicial_no
])

@include('components.bs.textarea', [
	'name' => 'respondents',
	'label' => 'Responden',
	'mode' => 'disabled',
	'value' => $respondent_list
])

@include('components.bs.input', [
	'name' => 'contact_name',
	'label' => 'Nama Pegawai untuk Dihubungi',
	'value' => array_key_exists('contact_name',$data) ? $data['contact_name'] : ''
])

@include('components.bs.input', [
	'name' => 'contact_phone',
	'label' => 'No Telefon Pegawai',
	'value' => array_key_exists('contact_phone',$data) ? $data['contact_phone'] : ''
])

@include('components.bs.input', [
	'name' => 'contact_email',
	'label' => 'Emel Pegawai',
	'value' => array_key_exists('contact_email',$data) ? $data['contact_email'] : ''
])

@include('components.bs.input', [
	'name' => 'ob_kpks_name',
	'label' => 'Nama Pegawai bagi pihak Ketua Pengarah',
	'value' => array_key_exists('ob_kpks_name',$data) ? $data['ob_kpks_name'] : ''
])
