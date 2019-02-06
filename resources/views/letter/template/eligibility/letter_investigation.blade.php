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

@include('components.bs.textarea', [
	'name' => 'address',
	'label' => 'Alamat',
	'mode' => 'disabled',
	'value' => $letter->entity->addresses->last()->address->address1.
	    ($letter->entity->addresses->last()->address->address2 ? ', '.$letter->entity->addresses->last()->address->address2 : '').
	    ($letter->entity->addresses->last()->address->address3 ? ', '.$letter->entity->addresses->last()->address->address3 : '').
	    ', '.
	    $letter->entity->addresses->last()->address->postcode.' '.
	    ($letter->entity->addresses->last()->address->district ? $letter->entity->addresses->last()->address->district->name : '').', '.
	    ($letter->entity->addresses->last()->address->state ? $letter->entity->addresses->last()->address->state->name : '')
])

@include('components.bs.input', [
	'name' => 'company_name',
	'label' => 'Nama Syarikat',
	'mode' => 'disabled',
	'value' => $letter->filing->forma->company_name,
])

@include('components.bs.textarea', [
	'name' => 'company_address',
	'label' => 'Alamat Syarikat',
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
	'name' => 'filing_applied_at',
	'label' => 'Tarikh Permohonan',
	'mode' => 'disabled',
	'value' => date('d/m/Y', strtotime($letter->filing->forma->applied_at)),
])

<div>
    <label for="staff_name" class="col-md-3 control-label">Nama Kakitangan
    </label>
    <div class="col-md-9">
        <select id="staff_name" name="staff_name" class="full-width" data-init-plugin="select2">
            @foreach($staffs as $staff)
            <option value="{{ $staff->name }}" role="{{ $staff->role->name }}">{{ $staff->name }}</option>
            @endforeach
        </select>
    </div>
</div>

<div>
    <label for="staff_name" class="col-md-3 control-label">Peranan Kakitangan
    </label>
    <div class="col-md-9">
        <span id="role"></span>
    </div>
</div>

@include('components.bs.input', [
	'name' => 'ob_kpks_name',
	'label' => 'Nama Pegawai bagi pihak Ketua Pengarah',
	'value' => array_key_exists('ob_kpks_name',$data) ? $data['ob_kpks_name'] :''
])

@include('components.bs.input', [
	'name' => 'hq_reference_no',
	'label' => 'No. Rujukan Ibu Pejabat',
	'value' => array_key_exists('hq_reference_no',$data) ? $data['hq_reference_no'] :''
])

@include('components.bs.input', [
	'name' => 'hq_date',
	'label' => 'Tarikh Rujukan Ibu Pejabat',
	'value' => array_key_exists('hq_date',$data) ? $data['hq_date'] : date('d/m/Y')
])

<script type="text/javascript">
	$('#staff_name').on('change', function(){
		var role_name = $("#staff_name option:selected").val();
		$("#role").text(role_name);
	}
</script>