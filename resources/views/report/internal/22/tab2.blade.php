<?php
$unions = array(
    'Johor',
    'Kedah',
    'Kelantan',
    'Melaka',
    'Negeri Sembilan',
    'Pahang',
    'Pulau Pinang',
    'Perak',
    'Perlis',
    'Selangor',
    'Terengganu',
    'Sabah',
    'Sarawak',
    'Wilayah Persekutuan Kuala Lumpur',
    'Wilayah Persekutuan Labuan',
    'Wilayah Persekutuan Putrajaya',
);
?><!-- START CONTAINER FLUID -->
<div class=" container-fluid container-fixed-lg bg-white">
	<!-- START card -->
	<div class="card card-transparent">
		<div class="card-header px-0">
			<div class="pull-right">
				<div class="col-xs-12">
					<input type="text" id="search-table" class="form-control pull-right" placeholder="Carian..">
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="card-block table-responsive">
			<table class="table table-hover " id="table">
				<thead>
					<tr>
						<th class="fit">Bil.</th>
						<th>Negeri</th>
						<th>No. Pendaftaran</th>
						<th>Nama Kesatuan Sekerja</th>
						@foreach(range($start_year, $end_year) as $index => $year)
						<th class="fit">{{ $year }}</th>
						@endforeach
					</tr>
					<tr>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						@foreach(range($start_year, $end_year) as $index => $year)
						<th class="fit">Jumlah Keanggotaan</th>
						@endforeach
					</tr>
				</thead>
				<tbody>
					<?php
		                $unions = $view_report_query->groupBy('entity_id', 'un_name')->get();
		            ?>
					@foreach($unions as $ind => $union)
					<tr>
						<td>{{ $ind+1 }}</td>
						<td>{{ $union->first()->st_name }}</td>
						<td>{{ $union->first()->registration_no }}</td>
						<td>{{ $union->first()->un_name }}</td>
						@foreach(range($start_year, $end_year) as $index => $year)
						<?php
							$report = (clone $union)->where('year', $year);
						?>
						<td align="center">{{ $report->sum('membership') }}</td>
						@endforeach
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
	<!-- END card -->
</div>
<!-- END CONTAINER FLUID -->
