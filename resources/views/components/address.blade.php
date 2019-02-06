<div class="form-group-attached m-b-10">
	@include('components.input', [
		'name' => 'address1',
		'label' => 'Street 1',
	])

	<div class="row">
		<div class="col-md-6">
		@include('components.input', [
			'name' => 'address2',
			'label' => 'Street 2',
		])
		</div>
		<div class="col-md-6">
		@include('components.input', [
			'name' => 'address3',
			'label' => 'Street 3',
		])
		</div>
	</div>

	<div class="row">
		<div class="col-md-4">
		@include('components.input', [
			'name' => 'postcode',
			'label' => 'Postcode',
		])
		</div>
		<div class="col-md-8">
		@include('components.select', [
			'name' => 'country',
			'label' => 'Country',
			'data' => [
				'1' => 'Malaysia', 
				'2' => 'Singapore',
				'3' => 'Thailand',
				'4' => 'Indonesia',
				'5' => 'Brunei',
				'6' => 'Vietnam',
			],
		])
		</div>
	</div>

	<div class="row">
		<div class="col-md-6">
		@include('components.select', [
			'name' => 'state',
			'label' => 'State',
			'data' => [
				'1' => 'Johor',
				'2' => 'Kedah',
				'3' => 'Kelantan',
				'4' => 'Melaka',
				'5' => 'Negeri Sembilan'
			],
		])
		</div>
		<div class="col-md-6">
		@include('components.select', [
			'name' => 'district',
			'label' => 'District',
			'data' => [
				'1' => 'Johor Bahru', 
				'2' => 'Muar',
				'3' => 'Batu Pahat',
				'4' => 'Mersing',
				'5' => 'Segamat',
			],
		])
		</div>
	</div>
</div>