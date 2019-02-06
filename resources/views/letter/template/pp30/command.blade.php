
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
	'name' => 'exception',
	'label' => 'Pengecualian Daripada',
    'value' => array_key_exists('exception',$data) ? $data['exception'] : ''
])

<div>
    <label for="fname" class="col-md-3 control-label">Penggal
    </label>
    <div class="col-md-9">
        <select id="tenure" name="tenure" class="full-width" data-init-plugin="select2">
            @foreach($letter->entity->tenures as $tenure)
            <option value="{{ $tenure->start_year }}-{{ $tenure->end_year }}">{{ $tenure->start_year }}-{{ $tenure->end_year }}</option>
            @endforeach
        </select>
    </div>
</div>

@include('components.bs.input', [
	'name' => 'officers',
	'label' => 'Nama Pegawai',
	'mode' => 'disabled',
	'value' => $letter->filing->officers,
])
