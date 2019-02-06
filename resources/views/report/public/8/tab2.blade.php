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
						<th>Negeri</th>
						@foreach(range($start_year, $end_year) as $index => $year)
						<th class="fit" colspan="2">{{ $year }}</th>
						@endforeach
					</tr>
					<tr>
						<th></th>
						<th></th>
						@foreach(range($start_year, $end_year) as $index => $year)
						<th>Bilangan Kesatuan Sekerja</th>
						<th>Jumlah Keanggotaan</th>
						@endforeach
					</tr>
				</thead>
				<tbody>
					@foreach($states as $ind => $state)
					<tr>
						<td>{{ $ind+1 }}</td>
						<td>{{ $state }}</td>
						@foreach(range($start_year, $end_year) as $index => $year)
						<?php
							$report = (clone $view_report)->where('year', $year);
						?>
						<td align="center">{{ $report->where('state', $ind+1)->sum('unions') }}</td>
						<td align="center">{{ $report->where('state', $ind+1)->sum('membership') }}</td>
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
