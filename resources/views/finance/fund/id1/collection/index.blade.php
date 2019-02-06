<div class="form-group row">
    <label for="fname" class="col-md-3 control-label">
        Nyatakan kelulusan kutipan dana terdahulu yang pernah dibuat oleh Kesatuan mengikut tahun
    </label>
    <div class="col-md-9">
        <button class="btn btn-primary btn-sm btn-cons" type="button" onclick="addCollection()"><i class="fa fa-plus m-r-5"></i> Tambah Tahun</button>

        <table class="table table-hover m-t-5" id="table-collection">
            <thead>
                <tr>
                    <th class="fit">Bil.</th>
                    <th class="fit">Tahun</th>
                    <th>Tujuan Kutipan Dana</th>
                    <th class="fit">Tindakan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1.</td>
                    <td></td>
                    <td></td>
                    <td class="nowrap">
                        <a href="javascript:;" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modal-history"><i class="fa fa-search"></i></a>
                        <a href="javascript:;" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Padam"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@push('modal')
<div class="modal fade" id="modal-addCollection" tabindex="-1" role="dialog" aria-hidden="false">
	<div class="modal-dialog ">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="modal-header clearfix text-left">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
					</button>
					<h5>Tambah <span class="semi-bold">Kutipan Dana Terdahulu</span></h5>
                    <p class="p-b-10">Sila isi maklumat pada ruangan di bawah.</p>
				</div>
				<div class="modal-body">
					<form id="form-add-collection" role="form" method="post" action="{{ route('fund.id1.collection', $fund->id) }}">
						<div class="form-group-attached">
							<div class="row">
								<div class="col-md-12">
                                    <div class="form-group form-group-default form-group-default-custom form-group-default-select2 required">
	                                    <label><span>Tahun</span></label>
	                                    <select id="prior_fund_id" name="prior_fund_id" class="full-width autoscroll" data-init-plugin="select2" required>
	                                        <option value="" selected="" disabled="">Pilih satu..</option>
	                                        @foreach($prior_collections as $collection)
                                            <option value="{{ $collection->id }}" objective="{{ $collection->objective }}">{{ date('Y', strtotime($collection->start_date)) }}</option>
	                                        @endforeach
	                                    </select>
	                                </div>
								</div>
							</div>
                            <div class="row">
    							<div class="col-md-12">
                                    @include('components.input', [
                                    	'name' => 'prior_objective',
										'label' => 'Tujuan Kutipan',
										'mode' => 'readonly',
										'class' => 'text-capitalize'
									])
    							</div>
    						</div>
						</div>
					</form>
					<div class="row">
						<div class="col-md-12 p-t-10">
							<button type="button" class="btn btn-info m-t-5 pull-right" onclick="submitForm('form-add-collection')"><i class="fa fa-check mr-1"></i> Simpan</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
</div>
@endpush

@push('js')
<script>
var table2 = $('#table-collection');

var settings2 = {
    "processing": true,
    "serverSide": true,
    "deferRender": true,
    "ajax": "{{ route('fund.id1.collection', $fund->id) }}",
    "columns": [
        { data: 'index', defaultContent: '', orderable: false, searchable: false, render: function (data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
        }},
        { data: "year", name: "year"},
        { data: "objective", name: "objective"},
        { data: "action", name: "action", orderable: false, searchable: false},
    ],
    "columnDefs": [
        { className: "nowrap", "targets": [ 3 ] }
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
    "iDisplayLength": 10
};

table2.dataTable(settings2);

function addCollection() {
    $('#modal-addCollection').modal('show');
    $('.modal form').trigger("reset");
    $('.modal form').validate();
}

function viewCollection(id) {
    $("#modal-div").load("{{ route('fund.id1.collection',$fund->id) }}/"+id);
}

$("#form-add-collection").submit(function(e) {
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
            $("#modal-addCollection").modal("hide");
            table2.api().ajax.reload(null, false);
        }
    });
});

function removeCollection(id) {
    swal({
        title: "Padam Data",
        text: "Data yang telah dipadam tidak boleh dikembalikan. Teruskan?",
        icon: "warning",
        buttons: ["Batal", { text: "Padam", closeModal: false }],
        dangerMode: true,
    })
    .then((confirm) => {
        if (confirm) {
            $.ajax({
                url: '{{ route('fund.id1.collection', $fund->id) }}/'+id,
                method: 'delete',
                dataType: 'json',
                async: true,
                contentType: false,
                processData: false,
                success: function(data) {
                    swal(data.title, data.message, data.status);
                    table2.api().ajax.reload(null, false);
                }
            });
        }
    });
}

$("#prior_fund_id").change(function() {
	$("#prior_objective").val($("#prior_fund_id option:selected").attr("objective"));
});
</script>
@endpush
