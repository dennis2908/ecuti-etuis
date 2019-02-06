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
            reject: {
                text: "Tidak Termasuk",
                value: "reject",
                className: "btn-danger",
            },
            approve: {
                text: "Termasuk",
                value: "approve",
                className: "btn-success",
            },
        }
    })
    .then((data) => {
        if (data == "reject") {
            $("#modal-div").load("{{ $route_reject }}");
            $("#modal-view").modal('hide');
        }
        else if (data == "approve") {
            $("#modal-div").load("{{ $route_approve }}");
            $("#modal-view").modal('hide');
        }
        else if (data == "delay") {
            $("#modal-div").load("{{ $route_delay }}");
            $("#modal-view").modal('hide');
        }
    });
</script>