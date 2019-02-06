

<script type="text/javascript">
$('#user_type_id').select2({
    dropdownParent: $('#user_type_id').parents(".modal-dialog").find('.modal-content'),
    language: 'ms',
});
$('#state_id').select2({
    dropdownParent: $('#state_id').parents(".modal-dialog").find('.modal-content'),
    language: 'ms',
});

$('#district_id').select2({
    dropdownParent: $('#district_id').parents(".modal-dialog").find('.modal-content'),
    language: 'ms',
});

$('#entity_id').select2({
    dropdownParent: $('#entity_id').parents(".modal-dialog").find('.modal-content'),
    language: 'ms',
});

$('#branch_id').select2({
    dropdownParent: $('#branch_id').parents(".modal-dialog").find('.modal-content'),
    language: 'ms',
});

$('#modal-add').modal('show');
$(".modal form").validate();

$("#form-add").submit(function(e) {
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
            $("#modal-add").modal("hide");
            table.api().ajax.reload(null, false);
        }
    });
});
</script>