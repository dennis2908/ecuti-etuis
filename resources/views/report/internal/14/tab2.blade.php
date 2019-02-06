<?php
$sectors = array(
	'Kerajaan',
	'Swasta',
	'Badan Berkanun'
);
?>
<!-- START CONTAINER FLUID -->
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
						<th>Bergabung</th>
						<th>Sektor</th>
						@foreach(range($start_year, $end_year) as $index => $year)
						<th class="fit" colspan="2">{{ $year }}</th>
						@endforeach
					</tr>
					<tr>
						<th></th>
						<th></th>
						<th></th>
						@foreach(range($start_year, $end_year) as $index => $year)
						<th>Bilangan Kesatuan Sekerja</th>
						<th>Keanggotaan</th>
						@endforeach
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach($types as $ind => $type)
					<tr>
						<td {{ $ind == 1 ? 'rowspan=3 style=vertical-align:middle' : '' }}>{{ $ind+1 }}</td>
						<td {{ $ind == 1 ? 'rowspan=3 style=vertical-align:middle' : '' }}>{{ $type }}</td>
						@if($ind == 1)
						<td>{{ $sectors[0] }}</td>
						@else
						<td> - </td>
						@endif
						@foreach(range($start_year, $end_year) as $index => $year)
						<?php
							$report = (clone $view_report)->where('year', $year);
						?>
							@if($ind == 1)
							<td align="center">{{ $report->where('type', $ind)->where('sector_id', 1)->sum('unions') }}</td>
							<td align="center">{{ $report->where('type', $ind)->where('sector_id', 1)->sum('membership') }}</td>
							@else
							<td align="center">{{ $report->where('type', $ind)->sum('unions') }}</td>
							<td align="center">{{ $report->where('type', $ind)->sum('membership') }}</td>
							@endif
						@endforeach
					</tr>
					@if($ind == 1)
						@foreach($sectors as $i => $sector)
							@if($i == 0)
								@continue
							@endif
							<tr>
								<td>{{ $sector }}</td>
								@foreach(range($start_year, $end_year) as $index => $year)
								<?php
									$report = (clone $view_report)->where('year', $year);
								?>
								<td align="center">{{ $report->where('type', $ind)->where('sector_id', $i)->sum('unions') }}</td>
								<td align="center">{{ $report->where('type', $ind)->where('sector_id', $i)->sum('unions') }}</td>
								@endforeach
							</tr>
						@endforeach
					@endif
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
	<!-- END card -->
</div>
<!-- END CONTAINER FLUID -->
