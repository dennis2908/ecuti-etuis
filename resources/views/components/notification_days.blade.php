$(".btn-send-custom").on("click", function() {

	if( $('.fa-lock').length > 0 ) {
		swal("Opps!", "Sila cetak dokumen di atas sebelum hantar melalui sistem.", "error");
		return;
	}

	swal({
		title: "Hantar?",
		text: "Adakah anda pasti untuk menghantar permohonan ini?",
		icon: "warning",
		buttons: ["Batal", { text: "Hantar", closeModal: false }],
	})
	.then((confirm) => {
		if (confirm) {
			swal("Berjaya", "Permohonan ini telah dihantar. Sila hantar dokumen fizikal ke Pejabat Wilayah Negeri dalam tempoh {{ $days }} hari.", "success");
		}
	});
})