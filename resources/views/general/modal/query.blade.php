<!-- Modal -->
<div class="modal fade" id="modal-multiquery" tabindex="-1" role="dialog" aria-labelledby="addModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalTitle">Maklumat <span class="bold">Kuiri</span></h5>
                <small class="text-muted">Sila isi ulasan kuiri pada ruangan di bawah.</small>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body m-t-20">
            	<form id='form-multiquery' role="form" method="post" action="{{ $route }}">
            		@include('components.input', [
	                    'name' => 'query_id',
	                    'label' => 'ID',
	                    'mode' => 'hidden'
	                ])

	                @include('components.textarea', [
	                    'name' => 'content',
	                    'label' => 'Ulasan',
	                    'mode' => 'required',
	                    'value' => ''
	                ])

	                <button class="btn btn-warning"><i class="fa fa-angle-down m-r-5"></i> Simpan Kuiri</button>
                </form>

                <table class="table table-hover" id="table-multiquery">
					<thead>
						<tr>
							<th class="fit">Bil.</th>
							<th class="">Ulasan</th>
							<th class="fit">Tindakan</th>
						</tr>
					</thead>
				</table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" onclick="submit()"><i class="fa fa-check m-r-5"></i> Hantar</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
	$("#modal-view").modal('hide');
	$('#modal-multiquery').modal('show');
	$("#form-multiquery").validate();

	var tableQuery = $('#table-multiquery');

	var settingsQuery = {
	    "processing": true,
	    "serverSide": true,
	    "deferRender": true,
	    "ajax": "{{ $route }}",
	    "columns": [
	        { data: 'index', defaultContent: '', orderable: false, searchable: false, render: function (data, type, row, meta) {
	            return meta.row + meta.settings._iDisplayStart + 1;
	        }},
	        { data: "content", name: "content", render: function(data, type, row){
	            return $("<div/>").html(data).text();
	        }},
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
	    "iDisplayLength": 5
	};

	tableQuery.dataTable(settingsQuery);

    $("#form-multiquery").submit(function(e) {
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
                tableQuery.api().ajax.reload(null, false);
                $("#form-multiquery").trigger('reset');
            }
        });
    });

    function edit(element, id) {
    	content = $(element).parents('tr').find('td:nth-child(2)').html();
    	
    	$("#query_id").val(id);
    	$("#content").val(content);
    	$('#modal-multiquery').animate({
	        scrollTop: $(document).scrollTop()
	    }, 500);
    }

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
	                url: '{{ $route }}/'+id,
	                method: 'delete',
	                dataType: 'json',
	                async: true,
	                contentType: false,
	                processData: false,
	                success: function(data) {
	                    swal(data.title, data.message, data.status);
	                    tableQuery.api().ajax.reload(null, false);
	                }
	            });
	        }
	    });
	}

	function submit() {
	    swal({
            title: "Teruskan?",
            text: "Adakah anda pasti untuk menghantar kuiri berikut?",
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
                    url: "{{ $route2 }}",
                    method: "POST",
                    dataType: 'json',
                    async: true,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        swal(data.title, data.message, data.status);
                        $("#modal-multiquery").modal("hide");
                        table.api().ajax.reload(null, false);
                    }
                });
            }
        });
	}
</script>