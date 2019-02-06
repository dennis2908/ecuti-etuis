<!-- Modal -->
<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="addModalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalTitle">Kemaskini <span class="bold">Paparan Surat</span></h5>
                <small class="text-muted">Sila muat naik DOCX pada ruangan di bawah.</small>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body m-t-20">
                <form action="{{ route('admin.letter.attachment', $type->id) }}" enctype="multipart/form-data" class="attachment dropzone no-margin">
                    <div class="fallback">
                        <input name="file" type="file" multiple/>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                <button type="button" class="btn btn-info" onclick="submit()"><i class="fa fa-check m-r-5"></i> Hantar</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

$("#modal-edit").modal('show');

function submit() {
    swal({
        title: "Berjaya!",
        text: "Data yang telah dikemaskini.",
        icon: "success",
        button: "OK",
    })
    .then((confirm) => {
        $("#modal-edit").modal('hide');
    });
}

$(".attachment").dropzone({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: "{{ route('admin.letter.attachment', $type->id) }}",
    addRemoveLinks : true,
    maxFiles: 1,
    acceptedFiles: '.docx,.doc,.odt',
    uploadMultiple: false,
    parallelUploads: 1,
    dictRemoveFile: "Padam Fail",
    init: function () {
        var myDropzone = this;

        $.ajax({
            url: '{{ route('admin.letter.attachment', $type->id) }}',
            method: 'get',
            dataType: 'json',
            async: true,
            contentType: false,
            processData: false,
            success: function(data) {
                $.each(data, function(key,value){
                    var mockFile = { name: value.name, size: value.size, id: value.id };
                    myDropzone.emit("addedfile", mockFile);
                    myDropzone.emit("thumbnail", mockFile, "{{ asset('images/docx.jpg') }}");

                    $(mockFile.previewElement).prop('id', value.id);
                    $(".dz-details > img").attr('alt', '');
                });
            }
        });

        myDropzone.on("addedfile", function (file) {
            if(file.id) {
                file._downloadLink = Dropzone.createElement("<a class=\"btn btn-default btn-xs\" id=\"bt-down\" style=\"margin-top:5px;\" href=\"{{ url('general/letter/') }}/"+file.id+"/"+file.name+"\" title=\"Muat Turun\" data-dz-download><i class=\"fa fa-download m-r-5\"></i> Muat Turun</a>");
                file.previewElement.appendChild(file._downloadLink);
            }
            myDropzone.emit("thumbnail", file, "{{ asset('images/docx.jpg') }}");
        });

        myDropzone.on("maxfilesexceeded", function(file) {
            myDropzone.removeAllFiles();
            myDropzone.addFile(file);
        });

        $(".dz-remove").addClass('btn', 'btn-danger', 'btn-xs');
        
    },
    success: function(file, response) {
        file.previewElement.id = response.id;
        file._downloadLink = Dropzone.createElement("<a class=\"btn btn-default btn-xs\" id=\"bt-down\" style=\"margin-top:5px;\" href=\"{{ url('general/letter') }}/"+response.id+"/"+file.name+"\" title=\"Muat Turun\" data-dz-download><i class=\"fa fa-download m-r-5\"></i> Muat Turun</a>");
        file.previewElement.appendChild(file._downloadLink);
        return file.previewElement.classList.add("dz-success");
    },
    removedfile: function(file) {
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
                    url: '{{ route('admin.letter.attachment', $type->id) }}',
                    method: 'delete',
                    dataType: 'json',
                    async: true,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        swal(data.title, data.message, data.status);
                        if(data.status == "success")
                            file.previewElement.remove();
                    }
                });
            }
        });
    },
});

</script>
