<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content-wrapper">
            <div class="modal-content">
                <div class="modal-header clearfix text-left">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                    </button>
                    <h5>Maklumat <span class="semi-bold">Pegawai</span></h5>
                    <p class="p-b-10">Maklumat pegawai yang membuat permohonan.</p>
                </div>
                <div class="modal-body">
                    <form id="form-edit" role="form" method="post" action="{{ route('formq.member.form', [ request()->id , $member->id ]) }}">
                        <div class="row">
                            <div class="col-md-12">
                                @include('components.input', [
                                    'name' => 'name',
                                    'label' => 'Nama',
                                    'mode' => 'required',
                                    'value' => $member->name
                                ])
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">  
                    <button type="button" class="btn btn-info m-t-5 pull-right submit" onclick="submitForm('form-edit')"><i class="fa fa-check m-r-5"></i> Hantar</button>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>
<script type="text/javascript">

$('#modal-edit').modal('show');
$(".modal form").validate();

$("#form-edit").submit(function(e) {
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
            $("#modal-edit").modal("hide");
            table.api().ajax.reload(null, false);
        }
    });
});
</script>