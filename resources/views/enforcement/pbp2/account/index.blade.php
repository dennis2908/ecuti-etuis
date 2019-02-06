<div class="form-group row">
	<label for="checklist30" class="col-md-4 control-label">
		<div class="checkbox check-success mt-0 data-true">
			<input value="1" id="checklist30" type="checkbox" class="hidden">
			<label for="checklist30">a) Kesatuan mempunyai Akaun <span class="bold">Semasa/ Simpanan</span>
				<i style="cursor: help; color: #48B0F7;" class="fa fa-question-circle" data-html="true" data-toggle="tooltip" title="Peraturan 35 Peraturan-Peraturan Kesatuan Sekerja 1959"></i>
			</label>
		</div>
	</label>
	<div class="col-md-8">
		<button onclick="addAccount()" class="btn btn-primary btn-cons" type="button"><i class="fa fa-plus m-r-5"></i> Tambah Akaun</button>

		<table class="table table-hover " id="table-account">
			<thead>
				<tr>
					<th class="fit">Bil.</th>
					<th class="fit">Jenis</th>
					<th class="fit">Nombor Akaun</th>
					<th> Nama Bank</th>
					<th class="fit">Tindakan</th>
				</tr>
			</thead>
		</table>
	</div>
</div>
@push('modal')
<div class="modal fade" id="modal-add-account" tabindex="-1" role="dialog" aria-hidden="false">
	<div class="modal-dialog ">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="modal-header clearfix text-left">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
					</button>
					<h5>Maklumat <span class="semi-bold">Akaun Semasa/Simpanan Tetap</span></h5>
				</div>
				<div class="modal-body">
					<form id="form-add-account" role="form" method="post" action="{{ route('pbp2.account', request()->id) }}">
						<div class="form-group-attached">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group form-group-default form-group-default-custom form-group-default-select2 required">
	                                    <label><span>Jenis Akaun</span></label>
	                                    <select id="account_type_id" name="account_type_id" class="full-width autoscroll state" data-init-plugin="select2" required="">
	                                        <option value="" selected="" disabled="">Pilih satu..</option>
	                                        <option value="1">Akaun Simpanan</option>
	                                        <option value="2">Akaun Semasa</option>
	                                    </select>
	                                </div>
								</div>
							</div>						
							<div class="row">
								<div class="col-md-12">
									@include('components.input', [
										'name' => 'account_no',
										'label' => 'No. Akaun',
										'mode' => 'required',
									])
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									@include('components.input', [
										'name' => 'bank_name',
										'label' => 'Nama Bank',
										'mode' => 'required',
									])
								</div>
							</div>
						</div>
					</form>
					<div class="row">
						<div class="col-md-12 p-t-10">
							<button type="button" class="btn btn-info m-t-5 pull-right" onclick="submitForm('form-add-account')"><i class="fa fa-check mr-1"></i> Simpan</button>
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

	var table3 = $('#table-account');

	var settings3 = {
	    "processing": true,
	    "serverSide": true,
	    "deferRender": true,
	    "ajax": "{{ route('pbp2.account', request()->id) }}",
	    "columns": [
	        { data: 'index', defaultContent: '', orderable: false, searchable: false, render: function (data, type, row, meta) {
	            return meta.row + meta.settings._iDisplayStart + 1;
	        }},
	        { data: "account_type", name: "account_type"},
	        { data: "account_no", name: "account_no"},
	        { data: "bank_name", name: "bank_name"},
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
	    "iDisplayLength": -1
	};

	table3.dataTable(settings3);

	// search box for table
	$('#search-table-account').keyup(function() {
	    table3.fnFilter($(this).val());
	});

	function addAccount() {
	    $('#modal-add-account').modal('show');
	    $('.modal form').trigger("reset");
	    $('.modal form').validate();
	}

	function editAccount(id) {
		$("#modal-div").load("{{ route('pbp2.account', request()->id) }}/"+id);
	}

	$("#form-add-account").submit(function(e) {
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
	            $("#modal-add-account").modal("hide");
	            table3.api().ajax.reload(null, false);
	        }
	    });
	});

	function removeAccount(id) {
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
	                url: '{{ route('pbp2.account', request()->id) }}/'+id,
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