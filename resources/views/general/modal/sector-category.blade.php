<!-- Modal -->
<div class="modal fade disable-scroll" id="modal-sectorCategory" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content-wrapper">
            <div class="modal-content">
                <div class="modal-header clearfix text-left">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                    </button>
                    <h5 class="modal-title" id="addModalTitle">Kemaskini Kategori Sektor <span class="bold">Kesatuan Sekerja</span></h5>
                    <p class="p-b-10">Sila pilih kategori di bawah dan isikan jenis kategori </p>
                </div>
                <div class="modal-body">
                    <form id='form-sectorCategory' role="form" method="post" action="{{ $route }}">
                        <div class="radio radio-primary">
                            <div>
                                <input name="is_national" value="1" id="is_national_1" type="radio" class="hidden" required>
                                <label for="is_national_1">Kebangsaan</label>
                                <input name="is_national" value="0" id="is_national_0" type="radio" class="hidden" required>
                                <label for="is_national_0">Dalaman</label>
                            </div>
                        </div>
                        <hr>
                        <div class="radio radio-primary">
                            <div>
                                @foreach($sector_categories as $sector_category)
                                <input name="sector_category_id" value="{{ $sector_category->id }}" id="sector_category_{{ $sector_category->id }}" type="radio" class="hidden" required>
                                <label for="sector_category_{{ $sector_category->id }}">{{ $sector_category->name }}</label>
                                @endforeach
                            </div>
                        </div>
                        
                        <input class="form-control" name="sector_category" aria-required="true" type="text" value="{{ $form->sector_category }}" placeholder="" required>
                    </form>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" onclick="submitForm('form-sectorCategory')"><i class="fa fa-check m-r-5"></i> Hantar</button>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>

<script type="text/javascript">
    $("#modal-view").modal('hide');
    $('#modal-sectorCategory').modal('show');
    $("#form-sectorCategory").validate();

    $("#sector_category_{{ $form->sector_category_id }}").prop('checked', true).trigger('change');
    $("#is_national_{{ $form->is_national }}").prop('checked', true).trigger('change');

    $("#form-sectorCategory").submit(function(e) {
        e.preventDefault();
        var form = $(this);

        if(!form.valid())
           return;

        swal({
            title: "Teruskan?",
            text: "Adakah anda pasti untuk kemaskini kategori sektor tersebut?",
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
                        swal(data.title, data.message, data.status);
                        $("#modal-sectorCategory").modal("hide");
                        table.api().ajax.reload(null, false);
                    }
                });
            }
        });

        
    });
</script>