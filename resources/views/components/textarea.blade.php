<?php
$name = ($name or false) ? $name : null;
?>
<div class="form-group form-group-default {{ $mode or '' }}">
	<label>
		<span {{ "id=label_$name" }}>{{ $label or 'Textarea Field' }}</span>
		@isset($info)@include('components.info', ['text' => $info])@endisset
	</label>
	<textarea 
		id="{{ $name or '' }}"
		class="form-control {{ $class or '' }}"
		name="{{ $name or '' }}"
		placeholder="{{ $placeholder or '' }}"
		{{ $mode or '' }}
		{{ $options or '' }}
		style="height: 150px;"
		>{!! $value or '' !!}</textarea>
</div>