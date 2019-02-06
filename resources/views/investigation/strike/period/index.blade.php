<div class="form-group row">
    <label for="fname" class="col-md-3 control-label">Tarikh melakukan mogok <span style="color:red;">*</span></label>
    <div class="col-md-9">
        <div class="input-group">
            <a onclick="addPeriod()" class="btn btn-success btn-cons text-capitalize text-white"><i class="fa fa-plus m-r-5"></i> Tempoh Mogok</a>
        </div>
        <table class="table table-hover" id="table-period">
            <thead>
                <tr>
                    <th class="fit">Bil. </th>
                    <th>Tarikh mula</th>
                    <th>Tarikh akhir</th>
                    <th class="fit">Tindakan</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

@push('modal')
<div class="modal fade" id="modal-addPeriod" tabindex="-1" role="dialog" aria-hidden="false">
	<div class="modal-dialog ">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="modal-header clearfix text-left">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
					</button>
					<h5>Maklumat <span class="semi-bold">Tempoh Mogok</span></h5>
                    <p class="p-b-10">Sila isi maklumat pada ruangan berikut.</p>
				</div>
				<div class="modal-body">
                    <form id="form-add-period" role="form" method="post" action="{{ route('strike.period', $strike->id) }}">
						<div class="form-group-attached">
							<div class="row clearfix">
								<div class="col-md-6">
									@include('components.date', [
									'name' => 'start_date',
									'label' => 'Tarikh Mula',
									'mode' => 'required',
									])
								</div>
								<div class="col-md-6">
									@include('components.date', [
									'name' => 'end_date',
									'label' => 'Tarikh Akhir',
									'mode' => 'required',
									])
								</div>
							</div>
						</div>
					</form>
					<div class="row p-t-10">
						<div class="col-md-12">
							<button type="button" class="btn btn-info m-t-5 pull-right" onclick="submitForm('form-add-period')"><i class="fa fa-check mr-1"></i> Simpan</button>
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

var table = $('#table-period');

var settings = {
    "processing": true,
    "serverSide": true,
    "deferRender": true,
    "ajax": "{{ route('strike.period', $strike) }}",
    "columns": [
        { data: 'index', defaultContent: '', orderable: false, searchable: false, render: function (data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
        }},
        { data: "start_date", name: "start_date"},
        { data: "end_date", name: "end_date"},
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

function addPeriod() {
    $('#modal-addPeriod').modal('show');
    $('.modal form').trigger("reset");
    $('.modal form').validate();
}

function editPeriod(id) {
    $("#modal-div").load("{{ route('strike.period', $strike) }}/"+id);
}

$("#form-add-period").submit(function(e) {
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
            $("#modal-addPeriod").modal("hide");
            table.api().ajax.reload(null, false);
        }
    });
});

function removePeriod(id) {
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
                url: '{{ route('strike.period', $strike) }}/'+id,
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
