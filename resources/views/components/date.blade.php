<?php
$name = ($name or false) ? $name : null;
?>
<div class="form-group form-group-default input-group {{ $mode or '' }}">
    <div class="form-input-group">
        <label>
			<span {{ "id=label_$name" }}>{{ $label or 'Input Field' }}</span>
			@isset($info)@include('components.info', ['text' => $info])@endisset
		</label>
		<input 
		id="{{ $name or '' }}"
		class="form-control datepicker {{ $class or '' }}"
		name="{{ $name or '' }}"
		placeholder="{{ $placeholder or '' }}"
		{{ $mode or '' }}
		type="{{ $type or 'text' }}"
		value="{{ $value or '' }}"
		{{ $options or '' }}
		>
    </div>
    <div class="input-group-addon">
        <i class="fa fa-calendar"></i>
    </div>
</div>