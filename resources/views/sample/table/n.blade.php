<div class="row">
	<div class="col-md-12">
		<div class="table-responsive">
			<div class="dataTables_wrapper no-footer" id="basicTable_wrapper">
				<table class="table table-hover dataTable no-footer" id="basicTable" role="grid">
					<thead>
						<tr role="row">
							<th>Tarikh Permohonan</th>
							<th>Status</th>
							<th>Tindakan</th>
						</tr>
					</thead>
					<tbody>
						@foreach(range(1,5) as $index)
						<tr role="row">
							<td class="v-align-middle">
								{{ date("d/m/Y", mt_rand(strtotime('1 January 2017'), strtotime('13 January 2018'))) }}
							</td>
							<td class="v-align-middle">
								<?php
								$strings = array(
									'<span class="badge badge-default">Telah Dihantar</span>',
									'<span class="badge badge-default">Diterima</span>',
									'<span class="badge badge-default">tutup</span>',
									'<span class="badge badge-default">Ditolak</span>',
									'<span class="badge badge-success">Lulus</span>',
								);
								$key = array_rand($strings);
								echo $strings[$key];
								?>
							</td>
							<td class="v-align-middle">
								<a onclick="viewData(1)" href="javascript:;" class="btn btn-default btn-xs mb-1"><i class="fa fa-search mr-1"></i> Lihat</a>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@push('js')
<div class="modal fade" id="modal-view" tabindex="-1" role="dialog" aria-hidden="false">
	<div class="modal-dialog modal-xl">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="modal-header clearfix text-left" style="background-color: #f3f3f3;">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
					</button>
					<h5>Maklumat <span class="semi-bold">Penyata Kewangan &amp; Penyata Tahunan Kesatuan</span></h5>
					<p class="p-b-10">Semua maklumat berkenaan permohonan tersebut telah dipaparkan dalam bentuk kronologi dibawah</p>

					<div class="pb-3">
						Nama Kesatuan: <a onclick="openModalKS()" href="javascript:;" class="text-complete bold">Kesatuan Unijaya</a ></span><br>
						Tarikh Penubuhan: <strong>19/01/2018</strong><br>
						Nama Setiausaha: <strong>Adlan Arif Zakaria</strong>
					</div>
				</div>
				<div class="modal-body pt-3">
					 @include('sample.timeline.n') 
				</div>
				<div class="modal-footer" style="background-color: #f3f3f3;">
					<button type="button" class="btn btn-secondary mt-4" data-dismiss="modal">Tutup</button>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
function viewData(id) {
	$("#modal-view").modal("show");
}
</script>
@endpush