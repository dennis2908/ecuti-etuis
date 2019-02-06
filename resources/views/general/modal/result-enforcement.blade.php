<script type="text/javascript">
    swal({
        title: "Keputusan Ketua Pengarah",
        text: "Sila pilih keputusan terhadap permohonan yang diterima",
        icon: "info",
        buttons: {
            delay: {
                text: "Tangguh",
                value: "delay",
                className: "btn-warning",
            },
            result: {
                text: "Buat Keputusan",
                value: "result",
                className: "btn-success",
            },
        }
    })
    .then((data) => {
        if (data == "result") {
            $("#modal-div").load("{{ $route_result }}");
            $("#modal-view").modal('hide');
        }
        else if (data == "delay") {
            $("#modal-div").load("{{ $route_delay }}");
            $("#modal-view").modal('hide');
        }
    });
</script>