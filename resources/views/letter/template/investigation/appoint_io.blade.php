<?php
	$staffs = \App\User::where('user_type_id', 2)->where('user_status_id', 1)->get();
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
	'label' => 'Nama Kesatuan',
	'mode' => 'disabled',
	'value' => $letter->entity->name
])

@include('components.bs.date', [
	'name' => 'case_no',
	'label' => 'No Kes',
	'value' => array_key_exists('case_no',$data) ? $data['case_no'] : ''
])

@include('components.bs.input', [
	'name' => 'hq_reference_no',
	'label' => 'No. Rujukan Ibu Pejabat',
	'value' => array_key_exists('hq_reference_no',$data) ? $data['hq_reference_no'] : ''
])

@include('components.bs.date', [
	'name' => 'hq_memo_date',
	'label' => 'Tarikh Memo Ibu Pejabat',
	'value' => array_key_exists('hq_memo_date',$data) ? $data['hq_memo_date'] : date('d/m/Y')
])

@include('components.bs.date', [
	'name' => 'accept_date',
	'label' => 'Tarikh Memo Diterima',
	'value' => array_key_exists('accept_date',$data) ? $data['accept_date'] : date('d/m/Y')
])

<div>
    <label for="fname" class="col-md-3 control-label">Pegawai Pendakwa
    </label>
    <div class="col-md-9">
        <select id="po_name" name="po_name" class="full-width" data-init-plugin="select2">
            @foreach($staffs as $staff)
            <option value="{{ $staff->user->name }}">{{ $staff->user->name }}</option>
            @endforeach
        </select>
    </div>
</div>

@include('components.bs.input', [
	'name' => 'pw_name',
	'label' => 'Nama Pengarah Wilayah/Negeri',
	'mode' => 'disabled',
    'value' => $letter->entity->province_office->pw->name
])

@include('components.bs.input', [
	'name' => 'province_office_name',
	'label' => 'Nama Pejabat Wilayah/Negeri',
	'mode' => 'disabled',
	'value' => $letter->entity->province_office->name
])