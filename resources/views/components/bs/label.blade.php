<div class="form-group row">
	<label class="col-md-3 control-label">
		{{ $label or 'Label Field' }}
		@isset($info) @include('components.info', ['text' => $info]) @endisset
	</label>
	<div class="col-md-9">
		{{ $slot or '' }}
	</div>
</div>