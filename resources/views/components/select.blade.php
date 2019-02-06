<?php
$name = ($name or false) ? $name : null;
$unique_id = uniqid();
$initialize = isset($initialize) ? $initialize : true;
?>
<div id="{{ $unique_id }}" class="form-group form-group-default form-group-default-custom form-group-default-select2 {{ $mode or '' }}">
	<label>
		<span {{ "id=label_$name" }}>{{ $label or 'Input Field' }}</span>
		@isset($info)@include('components.info', ['text' => $info])@endisset
	</label>
	<select id="{{ $name or '' }}" name="{{ $name or '' }}" data-placeholder="{{ $placeholder or '' }}" class="full-width autoscroll {{ $class or '' }}" data-init-plugin="select2" {{ $mode or '' }} {{ $options or '' }}>
		@if($initialize)
		<option disabled hidden selected>Pilih satu..</option>
		@endif
		@foreach($data as $index => $text)
		<option value="{{ $index }}" @isset($selected){{ $selected == $index ? 'selected' : '' }}@endisset>{{ $text }}</option>
		@endforeach
	</select>
</div>

@push('js')
<script type="text/javascript">
$(document).ready(function() {
@if(isset($modal) && $modal)
	$('#{{ $unique_id }} select[data-init-plugin=select2]').select2({
		dropdownParent: $('#{{ $unique_id }} select[data-init-plugin=select2]').parents(".modal-dialog").find('.modal-content'),
		language: 'ms',
		// allowClear: true,
	});
@else
	$("#{{ $unique_id }} select[data-init-plugin=select2]").select2({
		language: 'ms',
		// allowClear: true,
	});
@endif
});
</script>
@endpush