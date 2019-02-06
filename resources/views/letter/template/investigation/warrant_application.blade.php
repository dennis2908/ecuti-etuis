<?php
	$courts = \App\MasterModel\MasterCourt::all();
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

<div>
    <label for="fname" class="col-md-3 control-label">Nama Mahkamah
    </label>
    <div class="col-md-9">
        <select id="court_name" name="court_name" class="full-width" data-init-plugin="select2">
            @foreach($courts as $court)
            <option value="{{ $court->name }}">{{ $court->name }}</option>
            @endforeach
        </select>
    </div>
</div>

@include('components.bs.date', [
	'name' => 'staff_name',
	'label' => 'Nama pegawai',
	'value' => array_key_exists('staff_name',$data) ? $data['staff_name'] : ''
])

@include('components.bs.date', [
	'name' => 'identification_no',
	'label' => 'No Kad Pengenalan',
	'value' => array_key_exists('identification_no',$data) ? $data['identification_no'] : ''
])

@include('components.bs.input', [
	'name' => 'province_office_name',
	'label' => 'Nama Pejabat Wilayah/Negeri',
	'value' => $letter->entity->province_office->name
])


@include('components.bs.textarea', [
	'name' => 'suspicions',
	'label' => 'Disyaki',
	'value' => array_key_exists('suspicions',$data) ? $data['suspicions'] : ''
])

@include('components.bs.date', [
	'name' => 'tenant_name',
	'label' => 'Nama Penghuni',
	'value' => array_key_exists('tenant_name',$data) ? $data['tenant_name'] : date('d/m/Y')
])

@include('components.bs.textarea', [
	'name' => 'tenant_address',
	'label' => 'Alamat Premis',
	'value' => array_key_exists('tenant_address',$data) ? $data['tenant_address'] : 
])

@include('components.bs.input', [
	'name' => 'ob_pw_name',
	'label' => 'Nama Pegawai bagi pihak Pengarah KS',
	'value' => array_key_exists('ob_pw_name',$data) ? $data['ob_pw_name'] : ''
])
