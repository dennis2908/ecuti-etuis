<div class="form-group row">
    <label for="fname" class="col-md-3 control-label">
        Tahun Kewangan Borang N yang lepas
        <i style="cursor: help; color: #48B0F7;" class="fa fa-question-circle" data-html="true" data-toggle="tooltip" title="Maksima 3 tahun berturut-turut"></i>
    </label>
    <div class="col-md-9">
        <button class="btn btn-primary btn-sm btn-cons" type="button" onclick="add()"><i class="fa fa-plus m-r-5"></i> Tambah Tahun</button>

        <table class="table table-hover " id="table-year">
            <thead>
                <tr>
                    <th class="fit">Bil.</th>
                    <th>Tahun</th>
                    <th>Nama Juruaudit</th>
                    <th class="fit">Tindakan</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

@push('modal')
<div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-hidden="false">
	<div class="modal-dialog ">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="modal-header clearfix text-left">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
					</button>
					<h5>Maklumat <span class="semi-bold">Tahun Kewangan Borang N Yang Lepas</span></h5>
                    <p class="p-b-10">Sila lengkapkan maklumat pada ruangan di bawah.</p>
				</div>
				<div class="modal-body">
					<form id="form-add-formn" role="form" method="post" action="{{ route('formjl1.formn', $auditor->id) }}">
						<div class="form-group-attached">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group form-group-default form-group-default-custom form-group-default-select2 required">
                                        <label>Tahun</label>
                                        <select id="formn_id" name="formn_id" class="full-width autoscroll" data-init-plugin="select2" required>
                                            <option value="" selected="" disabled="">Pilih satu..</option>
                                            @foreach($prior_formns as $formn)
                                            <option value="{{ $formn->id }}">{{ $formn->year }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
							<div class="row">
								<div class="col-md-12">
									@component('components.label', [
										'label' => 'Nama Juruaudit',
										'mode' => 'required',
									])
                                    -
                                    @endcomponent
								</div>
							</div>
						</div>
					</form>
					<div class="row">
						<div class="col-md-12 p-t-10">
							<button type="button" class="btn btn-info m-t-5 pull-right" onclick="submitForm('form-add-formn')"><i class="fa fa-check mr-1"></i> Simpan</button>
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
<script type="text/javascript">

$('#formn_id').select2({
    dropdownParent: $('#formn_id').parents(".modal-dialog").find('.modal-content'),
    language: 'ms',
});
var table = $('#table-year');

var settings = {
    "processing": true,
    "serverSide": true,
    "deferRender": true,
    "ajax": "{{ route('formjl1.formn', $auditor->id) }}",
    "columns": [
        { data: 'index', defaultContent: '', orderable: false, searchable: false, render: function (data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
        }},
        { data: "year", name: "year"},
        { data: "auditor_name", name: "auditor_name"},
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

table.dataTable(settings);

function add() {
    $('#modal-add').modal('show');
    $('.modal form').trigger("reset");
    $('.modal form').validate();
}

function edit(id) {
    $("#modal-div").load("{{ route('formjl1.formn',$auditor->id) }}/"+id);
}

$("#form-add-formn").submit(function(e) {
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
            $("#modal-add").modal("hide");
            table.api().ajax.reload(null, false);
        }
    });
});

function remove(id) {
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
                url: '{{ route('formjl1.formn', $auditor->id) }}/'+id,
                method: 'delete',
                dataType: 'json',
                async: true,
                contentType: false,
                processData: false,
                success: function(data) {
                    swal(data.title, data.message, data.status);
                    table.api().ajax.reload(null, false);
                }
            });
        }
    });
}
</script>
@endpush
