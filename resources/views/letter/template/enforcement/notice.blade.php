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

<div>
    <label for="fname" class="col-md-3 control-label">Pegawai Pejabat
    </label>
    <div class="col-md-9">
        <select id="user_id" name="user_id" class="full-width" data-init-plugin="select2">
            @foreach($staffs as $staff)
            <option value="{{ $staff->user->id }}">{{ $staff->user->name }}</option>
            @endforeach
        </select>
    </div>
</div>

@include('components.bs.input', [
	'name' => 'location',
	'label' => 'Tempat Perjumpaan',
	'value' => array_key_exists('location',$data) ? $data['location'] : ''
])

@include('components.bs.date', [
	'name' => 'meet_at',
	'label' => 'Tarikh Perjumpaan',
	'value' => array_key_exists('meet_at',$data) ? $data['meet_at'] : date('d/m/Y')
])

@include('components.bs.textarea', [
	'name' => 'suggestions',
	'label' => 'Ulasan',
	'value' => array_key_exists('suggestions',$data) ? $data['suggestions'] : date('d/m/Y')
])

@include('components.bs.input', [
	'name' => 'ob_kpks_name',
	'label' => 'Nama Pegawai bagi pihak Ketua Pengarah',
	'value' => array_key_exists('ob_kpks_name',$data) ? $data['ob_kpks_name'] : ''
])
