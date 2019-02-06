<div class="form-group form-group-default {{ $mode or '' }}">
	<label>
		<span>{{ $label or 'Input Field' }}</span>
		@isset($info)@include('components.info', ['text' => $info])@endisset
	</label>
	{{ $slot or '' }}
</div>