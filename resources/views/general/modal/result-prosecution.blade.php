<script type="text/javascript">
    swal({
        title: "Keputusan",
        text: "Sila pilih keputusan terhadap kertas siasatan yang diterima",
        icon: "info",
        buttons: {
            approve: {
                text: "Perakukan",
                value: "approve",
                className: "btn-success",
            },
        }
    })
    .then((data) => {
        if (data == "approve") {
            swal({
                title: "Teruskan?",
                text: "Adakah anda pasti untuk menghantar keputusan tersebut?",
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
                        url: '{{ $route }}',
                        method: 'POST',
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
    });
</script>