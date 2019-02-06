<div class="form-group row">
    <label for="fname" class="col-md-3 control-label">Nama Pemeriksa <span style="color:red;">*</span></label>
    <div class="col-md-9">
        <table class="table table-hover " id="table-examiner">
            <thead>
                <tr>
                    <th class="fit">Bil.</th>
                    <th>Nama</th>
                    <th class="fit">Tindakan</th>
                </tr>
            </thead>
        </table>
        <div class="card-title p-t-10">
            <button onclick="addExaminer()" class="btn btn-primary btn-cons" type="button"><i class="fa fa-plus m-r-5"></i> Tambah Pemeriksa</button>
        </div>
    </div>
</div>
@push('modal')
<div class="modal fade" id="modal-addExaminer" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content-wrapper">
            <div class="modal-content">
                <div class="modal-header clearfix text-left">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                    </button>
                    <h5>Maklumat <span class="semi-bold">Pemeriksa</span></h5>
                    <p class="p-b-10">Sila isi maklumat pada ruangan di bawah.</p>
                </div>
                <div class="modal-body">
                    <form id="form-add-examiner" role="form" method="post" action="{{ route('formlu.examiner', $formlu->id) }}">
                        <p class="m-t-10 bold">Maklumat Pemeriksa</p>
                        <div class="form-group-attached">
                            <div class="row">
                                <div class="col-md-12">
                                    @include('components.input', [
                                        'name' => 'name',
                                        'label' => 'Nama',
                                        'mode' => 'required',
                                    ])
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="col-md-12 p-t-10">
                        <button type="button" class="btn btn-info m-t-5 pull-right submit" onclick="submitForm('form-add-examiner')"><i class="fa fa-check" ></i> Simpan</button>
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

var table = $('#table-examiner');

var settings = {
    "processing": true,
    "serverSide": true,
    "deferRender": true,
    "ajax": "{{ route('formlu.examiner', $formlu->id) }}",
    "columns": [
        { data: 'index', defaultContent: '', orderable: false, searchable: false, render: function (data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
        }},
        { data: "examiner.name", name: "examiner.name"},
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
    "iDisplayLength": 10
};

table.dataTable(settings);

function addExaminer() {
    $('#modal-addExaminer').modal('show');
    $('.modal form').trigger("reset");
    $('.modal form').validate();
}

function editExaminer(id) {
    $("#modal-div").load("{{ route('formlu.examiner', $formlu->formu->id) }}/"+id);
}

$("#form-add-examiner").submit(function(e) {
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
            $("#modal-addExaminer").modal("hide");
            table.api().ajax.reload(null, false);
        },
        error: function(xhr, ajaxOptions, thrownError){
            swal('Harap Maaf!', 'Pegawai ini sudah dipilih.', 'error');
        }
    });
});

function removeExaminer(id) {
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
                url: '{{ route('formlu.examiner', $formlu->formu->id) }}/'+id,
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
