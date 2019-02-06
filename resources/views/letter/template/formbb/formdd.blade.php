<?php
$kpks = \App\UserStaff::where('role_id', 17)->whereHas('user', function($user) {
            return $user->where('user_status_id', 1);
        })->get()->last();
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
	'name' => 'entity_name',
	'label' => 'Nama Persekutuan',
	'mode' => 'disabled',
	'value' => $letter->entity->name
])

@include('components.bs.input', [
	'name' => 'signed_at',
	'label' => 'Tarikh Ditandatangani',
	'mode' => 'disabled',
	'value' => date('d/m/Y')
])

@include('components.bs.input', [
	'name' => 'registration_no',
	'label' => 'No. Pendaftaran',
	'mode' => 'disabled',
	'value' => $letter->entity->registration_no
])

@include('components.bs.input', [
	'name' => 'kpks_name',
	'label' => 'Nama Ketua Pengarah',
	'mode' => 'disabled',
	'value' => $kpks->province_office->name
])
