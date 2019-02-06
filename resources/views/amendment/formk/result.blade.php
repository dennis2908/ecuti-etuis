@extends('layouts.app')

@section('content')
<!-- START JUMBOTRON -->
<div class="jumbotron" data-pages="parallax">
	<div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
		<div class="inner">
			<!-- START BREADCRUMB -->
			{{ Breadcrumbs::render('formk.result') }}
			<div class="row">
				<div class="col-xl-12 col-lg-12 ">
					<!-- START card -->
					<div class="card card-transparent">
						<div class="card-block p-t-0">
							<h3 class='m-t-0'>Keputusan Borang K</h3>
							<p class="small hint-text m-t-5">
								Sila isi ruangan di bawah untuk keputusan bagi setiap perubahan pada buku perlembagaan.
							</p>
						</div>
					</div>
					<!-- END card -->
				</div>
			</div>
		</div>
	</div>
</div>
<!-- END JUMBOTRON -->

<!-- START CONTAINER FLUID -->
<div class=" container-fluid container-fixed-lg bg-white">
	<!-- START card -->
	<div class="card card-transparent">
		<div class="card-block table-reponsive">
			<form id='form-result' role="form" method="post" action="{{ route('formk.process.result.formk', $formk->id) }}">
				<table class="table table-hover " id="table-appeals">
					<thead>
						<tr>
							<th class="fit">Bil.</th>
							<th>Peraturan Lama</th>
							<th>Peraturan Baru</th>
							<th>Justifikasi</th>
							<th>Keputusan</th>
							<th>Ulasan</th>
						</tr>
					</thead>
					<tbody>
						@foreach($formk->constitution->changes as $index => $change)
						<tr>
							<td>{{ $index+1 }}</td>
							<td>
								<?php
									if($change->type->id == 1) {
										echo '-';
									}
									else {
										$current_constitution = $formk->tenure->entity->constitutions()->where('filing_status_id', 9)->get()->last();
										$previous_item = $current_constitution->items()->withTrashed()->where('code', $change->item()->withTrashed()->firstOrFail()->code)->get();

										if(count($previous_item) > 0)
											echo $previous_item->last()->content;
										else
											echo '-';
									}
								?>
							</td>
							<td>
								<?php
									if($change->type->id == 3) {
										echo '-';
									}
									else {
										echo $change->item->content;
									}
								?>
							</td>
							<td>{!! $change->justification !!}</td>
							<td class="nowrap">
								<div class="radio radio-primary">
									<input name="is_approved[]" id="is_approved_1" value="1" type="radio" class="hidden" required>
									<label for="is_approved_1"><span class=''>Lulus</span></label>
									<br>
									<input name="is_approved[]" id="is_approved_0" value="0" type="radio" class="hidden" required>
									<label for="is_approved_0"><span class=''>Tidak Lulus</span></label>
								</div>
							</td>
							<td>
								<input type="hidden" name="constitution_change_id[]" value="{{ $change->id }}">
								<textarea class="form-control" name="result_details[]" style="height: 100px;" required></textarea>
							</td>
						</tr>
						@endforeach					
					</tbody>
				</table>
			</form>
			<br>
			<div class="form-group">
				<button type="button" class="btn btn-default mr-1" onclick="location.href='{{ route('formk.list') }}'" ><i class="fa fa-angle-left mr-1"></i> Kembali</button>
				<button type="button" class="btn btn-info pull-right ml-1" onclick="submitForm('form-result')"><i class="fa fa-check mr-1"></i> Hantar Keputusan</button>
				<button type="button" class="btn btn-default pull-right ml-1" onclick="delay()"><i class="fa fa-folder-open mr-1"></i> Tangguh</button>
			</div>
		</div>
	</div>
	<!-- END card -->
</div>
<!-- END CONTAINER FLUID -->
@endsection

@push('js')
<script type="text/javascript">
	$("#form-result").validate();

	function delay() {
		$("#modal-div").load("{{ route('formk.process.delay', $formk->id) }}");
	    $("#modal-view").modal('hide');
	}

	$("#form-result").submit(function(e) {
        e.preventDefault();
        var form = $(this);

        if(!form.valid())
           return;

        swal({
            title: "Teruskan?",
            text: "Adakah anda pasti untuk menghantar keputusan?",
            icon: "warning",
            buttons: {
                cancel: "Batal",
                confirm: {
                    text: "Teruskan",
                    value: "confirm",
                    closeModal: false,
                    className: "btn-info",
                },
            },
            dangerMode: true,
        })
        .then((confirm) => {
            if (confirm) {
                $.ajax({
                    url: form.attr('action'),
                    method: form.attr('method'),
                    data: new FormData(form[0]),
                    dataType: 'json',
                    async: true,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        swal({
					        title: data.title,
					        text: data.message,
					        icon: data.status,
					        button: "OK",
					    })
					    .then((confirm) => {
					        if (confirm) {
					            location.href="{{ route('formk.list') }}";
					        }
					    });
                    }
                });
            }
        });
    });
</script>
@endpush