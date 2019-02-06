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
        <select id="po_name" name="po_name" class="full-width" data-init-plugin="select2">
            @foreach($courts as $court)
            <option value="{{ $court->name }}">{{ $court->name }}</option>
            @endforeach
        </select>
    </div>
</div>


@include('components.bs.date', [
	'name' => 'staff_name',
	'label' => 'Nama pegawai menyempurnakan waran geledah',
	'value' => array_key_exists('staff_name',$data) ? $data['staff_name'] : ''
])

@include('components.bs.date', [
	'name' => 'warrant_no',
	'label' => 'No Waran',
	'value' => array_key_exists('warrant_no',$data) ? $data['warrant_no'] : ''
])

@include('components.bs.date', [
	'name' => 'warrant_date',
	'label' => 'Tarikh Waran',
	'value' => array_key_exists('warrant_date',$data) ? $data['warrant_date'] : date('d/m/Y')
])

@include('components.bs.date', [
	'name' => 'issued_at',
	'label' => 'Tarikh Waran Dikeluarkan',
	'value' => array_key_exists('issued_at',$data) ? $data['issued_at'] : date('d/m/Y')
])

@include('components.bs.input', [
	'name' => 'ob_pw_name',
	'label' => 'Nama Pegawai bagi pihak Pengarah KS',
	'value' => array_key_exists('ob_pw_name',$data) ? $data['ob_pw_name'] : ''
])
