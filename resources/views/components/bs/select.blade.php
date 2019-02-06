<?php
$name = ($name or false) ? $name : null;
$unique_id = uniqid();
$initialize = isset($initialize) ? $initialize : true;
?>
<div id="{{ $unique_id }}" class="form-group row">
	<label {{ "id=label_$name" }} for="{{ $name or '' }}" class="col-md-3 control-label">
		{{ $label or 'Input Field' }}
		@isset($mode) @if(strpos($mode, 'required') !== false)<span style="color:red;">*</span>@endif @endisset
		@isset($info) @include('components.info', ['text' => $info]) @endisset
	</label>
	<div class="col-md-9">
		<select id="{{ $name or '' }}" name="{{ $name or '' }}" data-placeholder="{{ $placeholder or '' }}" class="full-width autoscroll {{ $class or '' }}" data-init-plugin="select2" {{ $mode or '' }} {{ $options or '' }}>
			@if($initialize)
			<option disabled hidden selected>Pilih satu..</option>
			@endif
			@foreach($data as $index => $text)
			<option value="{{ $index }}" @isset($selected){{ $selected == $index ? 'selected' : '' }}@endisset>{{ $text }}</option>
			@endforeach
		</select>
	</div>
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