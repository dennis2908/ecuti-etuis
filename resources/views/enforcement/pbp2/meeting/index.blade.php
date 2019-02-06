<div class="form-group row">
	<label for="checklist43" class="col-md-4 control-label">
		<div class="checkbox check-success mt-0 data-true">
			<input value="1" id="checklist43" type="checkbox" class="hidden">
			<label for="checklist43">Tarikh mesyuarat sebelumnya diadakan</label>
		</div>
	</label>
	<div class="col-md-8">
		<button onclick="addMeeting()" class="btn btn-primary btn-cons" type="button"><i class="fa fa-plus m-r-5"></i> Tambah Tarikh</button>

		<table class="table table-hover " id="table-meeting">
			<thead>
				<tr>
					<th class="fit">Bil.</th>
					<th>Bilangan Mesyuarat</th>
					<th class="fit">Tarikh</th>
					<th class="fit">Tindakan</th>
				</tr>
			</thead>
		</table>
	</div>
</div>
@push('modal')
<div class="modal fade" id="modal-add-meeting" tabindex="-1" role="dialog" aria-hidden="false">
	<div class="modal-dialog ">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="modal-header clearfix text-left">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
					</button>
					<h5>Maklumat <span class="semi-bold">Tarikh Mesyuarat Sebelumnya</span></h5>
				</div>
				<div class="modal-body">
					<form id="form-add-meeting" role="form" method="post" action="{{ route('pbp2.meeting', request()->id) }}">
						<div class="form-group-attached">
							<div class="row">
								<div class="col-md-12">
									@include('components.input', [
										'name' => 'total_meeting',
										'label' => 'Bilangan Mesyuarat',
										'mode' => 'required',
									])
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									@include('components.date', [
										'name' => 'meeting_date',
										'label' => 'Tarikh Mesyuarat',
										'mode' => 'required',
									])
								</div>
							</div>
						</div>
					</form>
					<div class="row">
						<div class="col-md-12 p-t-10">
							<button type="button" class="btn btn-info m-t-5 pull-right" onclick="submitForm('form-add-meeting')"><i class="fa fa-check mr-1"></i> Simpan</button>
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

	var table5 = $('#table-meeting');

	var settings5 = {
	    "processing": true,
	    "serverSide": true,
	    "deferRender": true,
	    "ajax": "{{ route('pbp2.meeting', request()->id) }}",
	    "columns": [
	        { data: 'index', defaultContent: '', orderable: false, searchable: false, render: function (data, type, row, meta) {
	            return meta.row + meta.settings._iDisplayStart + 1;
	        }},
	        { data: "total_meeting", name: "total_meeting"},
	        { data: "meeting_at", name: "meeting_at"},
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
	    "iDisplayLength": -1
	};

	table5.dataTable(settings5);

	// search box for table
	$('#search-table-meeting').keyup(function() {
	    table5.fnFilter($(this).val());
	});

	function addMeeting() {
	    $('#modal-add-meeting').modal('show');
	    $('.modal form').trigger("reset");
	    $('.modal form').validate();
	}

	function editMeeting(id) {
		$("#modal-div").load("{{ route('pbp2.meeting', request()->id) }}/"+id);
	}

	$("#form-add-meeting").submit(function(e) {
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
	            $("#modal-add-meeting").modal("hide");
	            table5.api().ajax.reload(null, false);
	        }
	    });
	});

	function removeMeeting(id) {
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
	                url: '{{ route('pbp2.meeting', request()->id) }}/'+id,
	                method: 'delete',
	                dataType: 'json',
	                async: true,
	                contentType: false,
	                processData: false,
	                success: function(data) {
	                    swal(data.title, data.message, data.status);
	                    table5.api().ajax.reload(null, false);
	                }
	            });
	        }
	    });
	}

</script>
@endpush