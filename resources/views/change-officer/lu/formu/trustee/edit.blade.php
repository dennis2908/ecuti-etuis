

<div class="modal fade" id="modal-editTrustee" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content-wrapper">
            <div class="modal-content">
                <div class="modal-header clearfix text-left">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                    </button>
                    <h5>Maklumat <span class="semi-bold">Pemegang Amanah</span></h5>
                    <p class="p-b-10">Sila isi maklumat pada ruangan di bawah.</p>
                </div>
                <div class="modal-body">
                    <form id="form-edit-trustee" role="form" method="post" action="{{ route('formlu.trustee.form', [ request()->id, $trustee->id]) }}">
                        <p class="m-t-10 bold">Maklumat Pemegang Amanah</p>
                        <div class="form-group-attached">
                            <div class="row">
                                <div class="col-md-12">
                                    @include('components.input', [
                                        'name' => 'name',
                                        'label' => 'Nama',
                                        'mode' => 'required',
                                        'value' => $trustee->name
                                    ])
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                        
                <div class="modal-footer">  
                    <div class="col-md-12 p-t-10">
                        <button type="button" class="btn btn-info m-t-5 pull-right submit" onclick="submitForm('form-edit-trustee')"><i class="fa fa-check" ></i> Simpan</button>
                
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>
@include('components.ajax.address')

<script src="{{ asset('js/global.js') }}"></script>
<script type="text/javascript">
    $('#modal-editTrustee').modal('show');
    $(".modal form").validate();

    $("#form-edit-trustee").submit(function(e) {
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
                $("#modal-editTrustee").modal("hide");
                table2.api().ajax.reload(null, false);
            }
        });
    });
</script>