<?php
$name = ($name or false) ? $name : null;
?>

<div class="form-group row">
	<label {{ "id=label_$name" }} for="{{ $name or '' }}" class="col-md-3 control-label">
		{{ $label or 'Input Field' }}
		@isset($mode) @if(strpos($mode, 'required') !== false)<span style="color:red;">*</span>@endif @endisset
		@isset($info) @include('components.info', ['text' => $info]) @endisset
	</label>
	<div class="col-md-9">
		<div class="radio radio-primary {{ $class or '' }}">
			@foreach($data as $index => $text)
			<input name="{{ $name }}" value="{{ $index }}" id="{{ $name.'_'.$index }}" type="radio" class="hidden {{ $options or '' }}" {{ $mode or '' }} {{ $options or '' }} @isset($selected){{ $selected == $index ? 'checked' : '' }}@endisset>
			<label for="{{ $name.'_'.$index }}">{{ $text }}</label>
			@endforeach
		</div>
	</div>
</div>