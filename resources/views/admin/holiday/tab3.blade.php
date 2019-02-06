<!-- START CONTAINER FLUID -->
<div class=" container-fluid container-fixed-lg bg-white">
	<!-- START card -->
	<div class="card card-transparent">
		<!-- <div class="card-header px-0">
			<div class="card-title">
				<button id="" class="btn btn-default btn-sm" type="button">
					<i class="fa fa-print m-r-5"></i> Cetak
				</button>
				<button id="" class="btn btn-default btn-sm" type="button">
					<i class="fa fa-download m-r-5"></i> Excel
				</button>
				<button id="" class="btn btn-default btn-sm" type="button">
					<i class="fa fa-download m-r-5"></i> PDF
				</button>
			</div>
			<div class="pull-right">
				<div class="col-xs-12">
					<input type="text" id="weekend-search-table" class="form-control pull-right" placeholder="Carian..">
				</div>
			</div>
			<div class="clearfix"></div>
		</div> -->
		<div class="card-block">
			<table class="table table-hover " id="table-weekend">
				<thead>
					<tr>
						<th class="fit">Bil.</th>
						<th>Negeri</th>
						<th>Cuti Minggu</th>
					</tr>
				</thead>
				<tbody>
					<form id="form-update-weekend" role="form" method="post" action="{{ route('admin.holiday.weekend') }}">
						@foreach($states as $state)
						<tr>
							<td>{{ $state->id }}.</td>
							<td>{{ $state->name }}</td>
							<td>
								<div class="radio radio-success">
									<input class="hidden" value="1" name="is_friday_{{ $state->id }}" id="is_friday_yes_{{ $state->id }}" type="radio" >
									<label for="is_friday_yes_{{ $state->id }}">Jumaat/Sabtu</label>
									<input class="hidden" value="0" name="is_friday_{{ $state->id }}" id="is_friday_no_{{ $state->id }}" type="radio">
									<label for="is_friday_no_{{ $state->id }}">Sabtu/Ahad</label>
								</div>
							</td>
						</tr>
						@endforeach
					</form>
				</tbody>
			</table>
		</div>
	</div>
	<!-- END card -->
	<div class="row mt-5">
		<div class="col-md-12">
			<ul class="pager wizard no-style">
				<li class="submit">
					<button onclick="submitForm('form-update-weekend')" class="btn btn-info btn-cons btn-animated from-left pull-right fa fa-check" type="button">
						<span>Simpan</span>
					</button>
				</li>
				<li class="next">
					<button class="btn btn-success btn-cons btn-animated from-left pull-right fa fa-angle-right" type="button">
						<span>Seterusnya</span>
					</button>
				</li>
				<li class="previous">
					<button class="btn btn-default btn-cons btn-animated from-left fa fa-angle-left" type="button">
						<span>Kembali</span>
					</button>
				</li>
			</ul>
		</div>
	</div>
</div>
<!-- END CONTAINER FLUID -->

@push('js')
<script>
var table3 = $('#table-weekend');

// search box for table
$('#weekend-search-table').keyup(function() {
	table3.fnFilter($(this).val());
});

$("#form-update-weekend").submit(function(e) {
	e.preventDefault();
	var form = $(this);

	if(!form.valid())
	   return;

	$.ajax({
		url: form.attr('action'),
		method: form.attr('method'),
		data: new FormData(form[0]),
		dataType: 'json',
		async: true,
		contentType: false,
		processData: false,
		success: function(data) {
			swal(data.title, data.message, data.status);
			table3.api().ajax.reload(null, false);
		}
	});
});

@foreach($states as $state)
	$("#is_friday_{{ ($state->is_friday_weekend == 1) ? 'yes' : 'no' }}_{{ $state->id }}").prop('checked', true).trigger('change');
@endforeach
</script>
@endpush
