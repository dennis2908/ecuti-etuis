<script type="text/javascript">
    swal({
        title: "Keputusan Ketua Pengarah",
        text: "Sila pilih keputusan terhadap permohonan yang diterima",
        icon: "info",
        buttons: {
            reject: {
                text: "Tidak Daftar",
                value: "reject",
                className: "btn-danger",
            },
            approve: {
                text: "Daftar",
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
    });
</script>