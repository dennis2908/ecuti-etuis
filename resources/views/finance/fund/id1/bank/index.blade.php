<div class="form-group row">
    <label for="fname" class="col-md-3 control-label">
        Baki Bank Terkini
    </label>
    <div class="col-md-9">
        <button class="btn btn-primary btn-sm btn-cons" type="button" onclick="addBank()"><i class="fa fa-plus m-r-5"></i> Tambah Bank</button>

        <table class="table table-hover " id="table-bank">
            <thead>
                <tr>
                    <th class="fit">Bil.</th>
                    <th>Nama Bank</th>
                    <th>No Akaun</th>
                    <th>Baki Terkini (RM)</th>
                    <th class="fit">Tindakan</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

@push('modal')
<div class="modal fade" id="modal-addBank" tabindex="-1" role="dialog" aria-hidden="false">
	<div class="modal-dialog ">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="modal-header clearfix text-left">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
					</button>
					<h5>Maklumat <span class="semi-bold">Baki Terkini Bank</span></h5>
                    <p class="p-b-10">Sila isi maklumat pada ruangan di bawah.</p>
				</div>
				<div class="modal-body">
					<form id="form-add-bank" role="form" method="post" action="{{ route('fund.id1.bank', $fund->id) }}">
						<div class="form-group-attached">
							<div class="row">
								<div class="col-md-12">
									@include('components.input', [
										'name' => 'name',
										'label' => 'Nama Bank',
										'mode' => 'required',
									])
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									@include('components.input', [
										'name' => 'account_no',
										'label' => 'Nombor Akaun',
										'mode' => 'required',
									])
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group form-group-default input-group">
										<div class="input-group-addon">
											RM
										</div>
										<div class="form-input-group">
											<label>Baki Bank</label>
											<input type="text" class="form-control decimal" name="balance" required>
										</div>
									</div>
								</div>
							</div>
						</div>
					</form>
					<div class="row">
						<div class="col-md-12 p-t-10">
							<button type="button" class="btn btn-info m-t-5 pull-right" onclick="submitForm('form-add-bank')"><i class="fa fa-check mr-1"></i> Simpan</button>
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
var table3 = $('#table-bank');

var settings3 = {
    "processing": true,
    "serverSide": true,
    "deferRender": true,
    "ajax": "{{ route('fund.id1.bank', $fund->id) }}",
    "columns": [
        { data: 'index', defaultContent: '', orderable: false, searchable: false, render: function (data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
        }},
        { data: "name", name: "name"},
        { data: "account_no", name: "account_no"},
        { data: "balance", name: "balance"},
        { data: "action", name: "action", orderable: false, searchable: false},
    ],
    "columnDefs": [
        { className: "nowrap", "targets": [ 4 ] }
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

table3.dataTable(settings3);

function addBank() {
    $('#modal-addBank').modal('show');
    $('.modal form').trigger("reset");
    $('.modal form').validate();
}

function editBank(id) {
    $("#modal-div").load("{{ route('fund.id1.bank',$fund->id) }}/"+id);
}

$("#form-add-bank").submit(function(e) {
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
            $("#modal-addBank").modal("hide");
            table3.api().ajax.reload(null, false);
        }
    });
});

function removeBank(id) {
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
                url: '{{ route('fund.id1.bank', $fund->id) }}/'+id,
                method: 'delete',
                dataType: 'json',
                async: true,
                contentType: false,
                processData: false,
                success: function(data) {
                    swal(data.title, data.message, data.status);
                    table3.api().ajax.reload(null, false);
                }
            });
        }
    });
}
</script>
@endpush
