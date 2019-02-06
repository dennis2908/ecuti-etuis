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
	'name' => 'applicant_name',
	'label' => 'Pengadu',
	'mode' => 'disabled',
	'value' => $letter->entity->name
])

<div>
    <label for="fname" class="col-md-3 control-label">Pihak yang Dituduh</label>
    <div class="col-md-9">
        @foreach($letter->filing->pd13->accused as $respondent)
        {{ $respondent->name }},
        @endforeach
    </div>
</div>


@include('components.bs.textarea', [
	'name' => 'context',
	'label' => 'Dimaklumkan bahawa',
	'value' => array_key_exists('context',$data) ? $data['context'] : ''
])

@include('components.bs.textarea', [
	'name' => 'point_of_view',
	'label' => 'Pandangan',
	'value' => array_key_exists('point_of_view',$data) ? $data['point_of_view'] : ''
])

@include('components.bs.date', [
	'name' => 'contact_name',
	'label' => 'Nama pegawai yang boleh dihubungi',
	'value' => array_key_exists('contact_name',$data) ? $data['contact_name'] : ''
])

@include('components.bs.date', [
	'name' => 'contact_phone',
	'label' => 'No Telefon',
	'value' => array_key_exists('accept_date',$data) ? $data['accept_date'] : ''
])

@include('components.bs.input', [
	'name' => 'kpks_name',
	'label' => 'Nama Ketua Pengarah',
	'mode' => 'disabled',
    'value' => $letter->entity->province_office->kpks->name
])
