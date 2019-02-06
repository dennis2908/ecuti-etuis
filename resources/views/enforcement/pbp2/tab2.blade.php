<!-- START CONTAINER FLUID -->
<div class=" container-fluid container-fixed-lg bg-white">
	<!-- START card -->
	<div class="card card-transparent">
		<div class="card-block">
			<form id="form-tab2" class="form-horizontal" role="form" autocomplete="off" method="post" action="#">

				<div class="card card-transparent mt-3 mb-2">
					<div class="card-block p-t-0">
						<h5 class='m-t-5'><span class="semi-bold">:: Butir-butir</span> Kesatuan Sekerja</h5> 
						<hr>
					</div>
				</div>
				<!--Syarat: Kalau Kesatuan cawangan, letak nama dan alamat cawangan-->
				@component('components.bs.label', [
					'label' => '(a)(i) Nama dan Alamat berdaftar Kesatuan',
				])
				<span class="bold">{{ $enforcement->entity->name }}</span><br>
				@if($enforcement->entity->addresses->last()->address)
				{!! $enforcement->entity->addresses->last()->address->address1.
                ($enforcement->entity->addresses->last()->address->address2 ? ',<br>'.$enforcement->entity->addresses->last()->address->address2 : '').
                ($enforcement->entity->addresses->last()->address->address3 ? ',<br>'.$enforcement->entity->addresses->last()->address->address3 : '').
                ',<br>'.
                $enforcement->entity->addresses->last()->address->postcode.' '.
                ($enforcement->entity->addresses->last()->address->district ? $enforcement->entity->addresses->last()->address->district->name : '').', '.
                ($enforcement->entity->addresses->last()->address->state ? $enforcement->entity->addresses->last()->address->state->name : '') !!}
                @endif
				@endcomponent
				<!-- end syarat-->

				<div class="form-group row">
					<label for="dashboard" class="col-md-3 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="1" id="checklist1" type="checkbox" class="hidden">
							<label for="checklist1">(a)(ii) Alamat Terkini
								<span style="color:red;">*</span>
								<i style="cursor: help; color: #48B0F7;" class="fa fa-question-circle" data-html="true" data-toggle="tooltip" title="Jika tidak sama seperti diatas"></i>
							</label>
						</div>
					</label>
					<div class="col-md-9">
						<input class="form-control col-md-12 m-t-5" name="address1" type="text" value="{{ $enforcement->pbp2->latest_address ? $enforcement->pbp2->latest_address->address1 : '' }}">
						<input class="form-control col-md-12 m-t-5" name="address2" type="text" value="{{ $enforcement->pbp2->latest_address ? $enforcement->pbp2->latest_address->address2 : '' }}">
						<input class="form-control col-md-12 m-t-5" name="address3" type="text" value="{{ $enforcement->pbp2->latest_address ? $enforcement->pbp2->latest_address->address3 : '' }}">
						<div class="row address">
							<div class="col-md-2 m-t-5">
								<input class="form-control numeric postcode" name="postcode" aria-required="true" type="text" value="{{ $enforcement->pbp2->latest_address ? $enforcement->pbp2->latest_address->postcode : '' }}" placeholder="Poskod" minlength="5" maxlength="5">
							</div>
							<div class="col-md-5 m-t-5">
								<select id="state_id" name="state_id" class="full-width autoscroll state" data-init-plugin="select2">
									<option disabled hidden selected>Pilih Negeri</option>
									@foreach($states as $index => $state)
									<option value="{{ $state->id }}">{{ $state->name }}</option>
									@endforeach
								</select>
							</div>
							<div class="col-md-5 m-t-5">
								<select id="district_id" name="district_id" class="full-width autoscroll district" data-init-plugin="select2" >
									<option disabled hidden selected>Pilih Daerah</option>
								</select>
							</div>
						</div>
					</div>
				</div>

				@component('components.bs.label', [
					'label' => '(b) No. Telefon',
				])
				{{ $enforcement->entity->phone }}
				@endcomponent

				@include('components.bs.input', [
					'label' => '(c) No. Faks',
					'name' => 'fax',
					'value' => $enforcement->pbp2->fax
				])

				@component('components.bs.label', [
					'label' => '(d) Alamat Emel',
				])
				{{ $enforcement->entity->email }}
				@endcomponent

				@include('components.bs.input', [
					'label' => '(e) Laman Web',
					'name' => 'website',
					'value' => $enforcement->pbp2->website
				])

				<div class="form-group row">
					<label for="dashboard" class="col-md-3 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="1" id="checklist2" type="checkbox" class="hidden">
							<label for="checklist2">(f) Papan Kenyataan
								<span style="color:red;">*</span>
								<i style="cursor: help; color: #48B0F7;" class="fa fa-question-circle" data-html="true" data-toggle="tooltip" title="Cth: Seksyen 38(2) Akta Kesatuan Sekerja 1959"></i>
							</label>
						</div>
					</label>
					<div class="col-md-9">
						<input type="text" name="dashboard" class="form-control" value="{{ $enforcement->pbp2->dashboard }}">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-md-3 control-label">Jenis alamat Kesatuan <span style="color:red;">*</span></label>
					<div class="col-md-9">
						<div class="radio radio-primary">
							@foreach($address_types as $type)
							<input name="address_type_id" value="{{ $type->id }}" id="address_type_{{ $type->id }}" type="radio" class="hidden">
							<label for="address_type_{{ $type->id }}">{{ $type->name }}</label>
							@endforeach
						</div>
					</div>
				</div>

				<!-- Syarat: Jika Kesatuan Majikan, hide button Lampiran A5-->
				<div class="form-group row">
					<label for="fname" class="col-md-3 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="1" id="checklist3" type="checkbox" class="hidden">
							<label for="checklist3">Jenis kesatuan adalah induk(bercawangan)
								<i style="cursor: help; color: #48B0F7;" class="fa fa-question-circle" data-html="true" data-toggle="tooltip" title="Lampiran A5 perlu diisi untuk setiap cawangan"></i>
							</label>
						</div>
					</label>
					<div class="col-md-8">
						<table class="table table-hover m-t-0" id="table-a5">
							<thead>
								<tr>
									<th class="fit">No.</th>
									<th>Cawangan</th>
									<th class="fit">Tindakan</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
				<!-- End syarat -->

				<!-- Syarat: Jika Kesatuan Cawangan, hide button Lampiran A6-->
				<div class="form-group row">
					<label for="fname" class="col-md-3 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="1" id="checklist4" type="checkbox" class="hidden">
							<label for="checklist4">Kesatuan mempunyai Perjanjian Bersama</label>
						</div>
					</label>
					<div class="col-md-9">
						<a id="" href="{{ route('pbp2.a6', $enforcement->id) }}" target="_blank" class="btn btn-primary btn-cons text-capitalize btn-sm"><i class="fa fa-plus m-r-5"></i> Lampiran A6</a>
					</div>
				</div>
				<!-- End syarat -->
				
				<div class="card card-transparent mt-3 mb-2">
					<div class="card-block p-t-0">
						<h5 class='m-t-5'><span class="semi-bold">:: Pegawai</span> Yang Ditemui</h5> 
						<hr>
					</div>
				</div>

				<div class="form-group row">
					<label for="fname" class="col-md-3 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="1" id="checklist5" type="checkbox" class="hidden">
							<label for="checklist5">Pegawai Yang Ditemui</label>
						</div>
					</label>
					<div class="col-md-9">
						<a id="" href="{{ route('pbp2.a1', $enforcement->id) }}" target="_blank" class="btn btn-primary btn-cons text-capitalize btn-sm"><i class="fa fa-plus m-r-5"></i> Lampiran A1</a>
					</div>
				</div>

				<div class="card card-transparent mt-3 mb-2">
					<div class="card-block p-t-0">
						<h5 class='m-t-5'><span class="semi-bold">:: Maklumat penuh</span> pegawai-pegawai Kesatuan Sekerja</h5> 
						<hr>
					</div>
				</div>

				<div class="form-group row">
					<label for="fname" class="col-md-3 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="1" id="checklist6" type="checkbox" class="hidden">
							<label for="checklist6">Maklumat penuh pegawai-pegawai Kesatuan</label>
						</div>
					</label>
					<div class="col-md-9">
						<a id="" href="{{ route('pbp2.a2', $enforcement->id) }}" target="_blank" class="btn btn-primary btn-cons text-capitalize btn-sm"><i class="fa fa-plus m-r-5"></i> Lampiran A2</a>
					</div>
				</div>

				<div class="card card-transparent mt-3 mb-2">
					<div class="card-block p-t-0">
						<h5 class='m-t-5'><span class="semi-bold">:: Maklumat Elaun</span> dan Insentif Pegawai Kesatuan</h5> 
						<hr>
					</div>
				</div>

				<div class="form-group row">
					<label for="fname" class="col-md-3 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="1" id="checklist7" type="checkbox" class="hidden">
							<label for="checklist7">Maklumat Elaun dan Insentif Pegawai Kesatuan</label>
						</div>
					</label>
					<div class="col-md-9">
						<a id="" href="{{ route('pbp2.a3.list', $enforcement->id) }}" target="_blank" class="btn btn-primary btn-cons text-capitalize btn-sm"><i class="fa fa-plus m-r-5"></i> Lampiran A3</a>
					</div>
				</div>

				<div class="card card-transparent mt-3 mb-2">
					<div class="card-block p-t-0">
						<h5 class='m-t-5'><span class="semi-bold">:: Maklumat </span> Pekerja Kesatuan</h5> 
						<hr>
					</div>
				</div>

				<div class="form-group row">
					<label for="fname" class="col-md-3 control-label">
						<div class="checkbox check-success mt-0 data-true">
							<input value="1" id="checklist8" type="checkbox" class="hidden">
							<label for="checklist8">Maklumat Pekerja Kesatuan</label>
						</div>
					</label>
					<div class="col-md-9">
						<a id="" href="{{ route('pbp2.a4.list', $enforcement->id) }}" target="_blank" class="btn btn-primary btn-cons text-capitalize btn-sm"><i class="fa fa-plus m-r-5"></i> Lampiran A4</a>
					</div>
				</div>
				<div class="row mt-5">
					<div class="col-md-12">
						<ul class="pager wizard no-style">
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
			</form>
		</div>
	</div>
	<!-- END card -->
</div>
<!-- END CONTAINER FLUID -->

@push('js')
<script type="text/javascript">

	$('#form-tab2').validate();

    var table20 = $('#table-a5');

    var settings20 = {
        "processing": true,
        "serverSide": true,
        "deferRender": true,
        "ajax": "{{ route('pbp2.a5', request()->id) }}",
        "columns": [
            { data: 'index', defaultContent: '', orderable: false, searchable: false, render: function (data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
            }},
            { data: "name", name: "name", searchable: true},
            { data: "action", name: "action", orderable: false, searchable: false},
        ],
        "columnDefs": [
            { className: "nowrap", "targets": [ 2 ] }
        ],
        "sDom": "<t><'row'<p i>>",
        "destroy": true,
        "scrollCollapse": true,
        "oLanguage": {
            "sEmptyTable":      "Tiada data",
            "sInfo":            "Paparan dari _START_ hingga _END_ dari _TOTAL_ rekod",
            "sInfoEmpty":       "Paparan 0 hingga 0 dari 0 rekod",
            "sInfoFiltered":    "(Ditapis dari jumlah _MAX_ rekod)",
            "sInfoPostFix":     "",
            "sInfoThousands":   ",",
            "sLengthMenu":      "Papar _MENU_ rekod",
            "sLoadingRecords":  "Diproses...",
            "sProcessing":      "Sedang diproses...",
            "sSearch":          "Carian:",
           "sZeroRecords":      "Tiada padanan rekod yang dijumpai.",
           "oPaginate": {
               "sFirst":        "Pertama",
               "sPrevious":     "Sebelum",
               "sNext":         "Kemudian",
               "sLast":         "Akhir"
           },
           "oAria": {
               "sSortAscending":  ": diaktifkan kepada susunan lajur menaik",
               "sSortDescending": ": diaktifkan kepada susunan lajur menurun"
           }
        },
        "iDisplayLength": -1
    };

    table20.dataTable(settings20);

    @if($enforcement->pbp2->latest_address)
    	$("#state_id").val( {{ $enforcement->pbp2->latest_address->state_id }} ).trigger('change');
    @endif

    @if($enforcement->pbp2->latest_address)
    	$("#district_id").val( {{ $enforcement->pbp2->latest_address->district_id }} ).trigger('change');
    @endif

    $("#address_type_{{ $enforcement->pbp2->address_type_id }}").prop('checked', true).trigger('change');

    @if($enforcement->pbp2->latest_address)
		$("#checklist1").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->pbp2->dashboard)
		$("#checklist2").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->a5->count() != 0)
		$("#checklist3").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->a6->count() != 0)
		$("#checklist4").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->a1->count() != 0)
		$("#checklist5").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->a2->count() != 0)
		$("#checklist6").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->a3->count() != 0)
		$("#checklist7").prop('checked', true).trigger('change');
	@endif

	@if($enforcement->a4->count() != 0)
		$("#checklist8").prop('checked', true).trigger('change');
	@endif

</script>
@endpush
