<div class="form-group form-group-default {{ $mode or '' }}">
	<label>
		<span {{ "id=label_$name" }}>{{ $label or 'Input Field' }}</span>
		@isset($info)@include('components.info', ['text' => $info])@endisset
	</label>
	<form action="/file-upload" class="dropzone no-margin">
		<div class="fallback">
			<input 
			id="{{ $name or '' }}"
			class="form-control {{ $class or '' }}"
			name="{{ $name or '' }}"
			{{ $mode or '' }}
			type="file"
			{{ $options or '' }}
			multiple
			>
		</div>
	</form>
</div>