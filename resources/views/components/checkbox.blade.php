<div class="form-group form-group-default {{ $mode or '' }}">
	<label>
		<span {{ "id=label_$name" }}>{{ $label or 'Input Field' }}</span>
		@isset($info)@include('components.info', ['text' => $info])@endisset
	</label>
	<div class="checkbox check-primary {{ $class or '' }}">
		@foreach($data as $index => $text)
		<input name="{{ $name }}" value="{{ $index }}" id="{{ $name.'_'.$index }}" type="checkbox" class="hidden {{ $options or '' }}" {{ $mode or '' }} {{ $options or '' }} @isset($selected){{ $selected == $index ? 'checked' : '' }}@endisset>
		<label for="{{ $name.'_'.$index }}">{{ $text }}</label>
		@endforeach
	</div>
</div>