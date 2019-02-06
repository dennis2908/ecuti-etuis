<?php
$name = ($name or false) ? $name : null;
?>
<div class="form-group row">
	<label {{ "id=label_$name" }} class="col-md-3 control-label">
		{{ $label or 'Input Field' }}
		@isset($mode) @if(strpos($mode, 'required') !== false)<span style="color:red;">*</span>@endif @endisset
		@isset($info) @include('components.info', ['text' => $info]) @endisset
	</label>
	<div class="col-md-9">
		<input class="form-control m-t-5" name="address1" type="text" value="" required>
		<input class="form-control m-t-5" name="address2" type="text" value="">
		<input class="form-control m-t-5" name="address3" type="text" value="">
		<div class="row">
			<div class="col-md-2 m-t-5">
				<input class="form-control numeric" name="postcode" aria-required="true" type="text" value="" placeholder="Poskod" minlength="5" maxlength="5" required >
			</div>
			<div class="col-md-5 m-t-5">
				<select id="" name="state_id" class="full-width autoscroll" data-init-plugin="select2" required>
					<option disabled hidden selected>Pilih Negeri</option>
					<option value="1">Johor</option>
					<option value="2">Kedah</option>
					<option value="3">Selangor</option>
				</select>
			</div>
			<div class="col-md-5 m-t-5">
				<select id="" name="district_id" class="full-width autoscroll" data-init-plugin="select2" required>
					<option disabled hidden selected>Pilih Daerah</option>
					<option value="1">Muar</option>
					<option value="2">Batu Pahat</option>
					<option value="3">Johor Bahru</option>
				</select>
			</div>
		</div>
	</div>
</div>