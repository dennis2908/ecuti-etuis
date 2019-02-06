$(".datepicker").datepicker({
    language: 'ms',
	format : "dd/mm/yyyy",
	autoclose: true,
}).on('changeDate', function(){
    $(this).trigger('change');

    if($(this).valid()){
       $(this).parent().find('label.error').remove();
       $(this).parents('.form-group').removeClass('has-error');
       $(this).removeClass('error');
    }
});

$('.numeric').on('keydown', function(e){
	-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()
});

$('.decimal').keypress(function(event) {
	if ( event.which != 8 && event.which != 0 && (event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
		event.preventDefault();
	}
});

function submitForm(form_id) {
	$("#"+form_id).submit()
    // $("#"+form_id).submit();
}

$(document).ajaxError(function(event, xhr, settings, thrownError) {
	// console.log(xhr.status);
	if(xhr.status == 422) {
		var errors = xhr.responseJSON.errors;
		$.each(errors,function(key, data){
			$("[name='"+key+"']").parents('.form-group').addClass('has-error');
			$("[name='"+key+"']").parents('.form-group').find('.error').html("");
			$("[name='"+key+"']").parents('.form-group').append('<label class="error">'+data[0]+'</label>');
		});
	}
});

$(document).ajaxSuccess(function(event, xhr, settings, thrownError) {
	// console.log(xhr.status);
	if(xhr.status == 422) {
		var errors = xhr.responseJSON.errors;
		$.each(errors,function(key, data){
			$("[name='"+key+"']").parents('.form-group').addClass('has-error');
			$("[name='"+key+"']").parents('.form-group').find('.error').html("");
			$("[name='"+key+"']").parents('.form-group').append('<label class="error">'+data[0]+'</label>');
		});
	}
});

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$( document ).ajaxComplete(function() {
	$('[data-toggle="tooltip"]').tooltip();
});

decones = {
	'01' : "Satu",
	'02' : "Dua",
	'03' : "Tiga",
	'04' : "Empat",
	'05' : "Lima",
	'06' : "Enam",
	'07' : "Tujuh",
	'08' : "Lapan",
	'09' : "Sembilan",
	10 : "Sepuluh",
	11 : "Sebelas",
	12 : "Dua Belas",
	13 : "Tiga Belas",
	14 : "Empas Belas",
	15 : "Lima Belas",
	16 : "Enam Belas",
	17 : "Tujuh Belas",
	18 : "Lapan Belas",
	19 : "Sembilan Belas"
};
ones = {
	0 : " ",
	1 : "Satu",
	2 : "Dua",
	3 : "Tiga",
	4 : "Empat",
	5 : "Lima",
	6 : "Enam",
	7 : "Tujuh",
	8 : "Lapan",
	9 : "Sembilan",
	10 : "Sepuluh",
	11 : "Sebelas",
	12 : "Dua Belas",
	13 : "Tiga Belas",
	14 : "Empat Belas",
	15 : "Lima Belas",
	16 : "Enam Belas",
	17 : "Tujuh Belas",
	18 : "Lapan Belas",
	19 : "Sembilan Belas"
};
tens = {
	0 : "",
	2 : "Dua Puluh",
	3 : "Tiga Puluh",
	4 : "Empat Puluh",
	5 : "Lima Puluh",
	6 : "Enam Puluh",
	7 : "Tujuh Puluh",
	8 : "Lapan Puluh",
	9 : "Sembilan Puluh"
};

hundreds = [
	"Ratus",
	"Ribu",
	"Juta",
	"Bilion",
	"Trilion",
	"Quadrillion"
];

function toCommas(value) {
    return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function number_format(number) {
	var num = parseFloat(Math.round(number * 100) / 100).toFixed(2).toString();
	var num_arr = num.toString().split(".");
	var wholenum = toCommas(num_arr[0]);
	var decnum = num_arr[1];
	return wholenum + '.' + decnum;
}

function toWords(number) {
	var num = parseFloat(Math.round(number * 100) / 100).toFixed(2).toString();
	var num_arr = num.toString().split(".");
	var wholenum = toCommas(num_arr[0]);
	var decnum = num_arr[1];
	var whole_arr = wholenum.split(",");
	var rettxt = "";

	whole_arr.forEach(function(i, key, arr) {
    
    	i = parseInt(i).toString();
    	
		if(parseInt(i) < 20) {
			rettxt += ones[parseInt(i)];
		}
		else if(parseInt(i) < 100) {
			rettxt += tens[i.substring(0,1)];
			rettxt += ' '+ones[i.substring(1,2)];
		}
		else {
			rettxt += ones[i.substring(0,1)]+' '+hundreds[0];
			rettxt += ' '+tens[i.substring(1,2)];
			rettxt += ' '+ones[i.substring(2,3)];
		}

		if(whole_arr.length - key - 1 > 0) {
			rettxt += ' '+hundreds[whole_arr.length - key - 1]+' ';
		}
	});

	return rettxt.toLowerCase();
}

function toRinggit(number) {
	var num = parseFloat(Math.round(number * 100) / 100).toFixed(2).toString();
	var num_arr = num.toString().split(".");
	var wholenum = toCommas(num_arr[0]);
	var decnum = num_arr[1];
	var whole_arr = wholenum.split(",");
	var rettxt = "";

	whole_arr.forEach(function(i, key, arr) {
    
    	i = parseInt(i).toString();
    	
		if(parseInt(i) < 20) {
			rettxt += ones[parseInt(i)];
		}
		else if(parseInt(i) < 100) {
			rettxt += tens[i.substring(0,1)];
			rettxt += ' '+ones[i.substring(1,2)];
		}
		else {
			rettxt += ones[i.substring(0,1)]+' '+hundreds[0];
			rettxt += ' '+tens[i.substring(1,2)];
			rettxt += ' '+ones[i.substring(2,3)];
		}

		if(whole_arr.length - key - 1 > 0) {
			rettxt += ' '+hundreds[whole_arr.length - key - 1]+' ';
		}
	});

	rettxt += " Ringgit";

	if(parseInt(decnum) > 0) {
		rettxt += " dan ";

		if(parseInt(decnum) < 20) {
			rettxt += decones[decnum];
		}
		else if(parseInt(decnum) < 100) {
			rettxt += tens[decnum.substring(0,1)];
			rettxt += ' '+ones[decnum.substring(1,2)];
		}
		rettxt += " Sen";
	}

	return rettxt.toLowerCase();
}

////////////////////////////////////////////////////////

var numbers_my = {
	0: 'kosong',
	1: 'satu',
	2: 'dua',
	3: 'tiga',
	4: 'empat',
	5: 'lima',
	6: 'enam',
	7: 'tujuh',
	8: 'lapan',
	9: 'sembilan'
};

$('.btn-unlock').hide();
$('.btn-lock').click( function() {
    $(this).parent().find('i.fa-lock').removeClass('fa-lock').addClass('fa-unlock');
    $(this).parents('h5').find('.btn-input').hide();
    $(this).parents('h5').find('.btn-unlock').show();
});
$('.btn-unlock').click( function() {
    $(this).parent().find('i.fa-unlock').removeClass('fa-unlock').addClass('fa-lock');
    $(this).parents('h5').find('.btn-input').show();
    $(this).parents('h5').find('.btn-unlock').hide();
});

$(".is-ic").on('change', function() {
	if( $(this).prop('checked') ) {
		$(this).parents('.is-icpassport').find('.input-passport').hide();
		$(this).parents('.is-icpassport').find('.input-ic').show();
		$(this).parents('.is-icpassport').find('.input-passport input').prop('disabled', true);
		$(this).parents('.is-icpassport').find('.input-ic input').prop('disabled', false);
	}
	else {
		$(this).parents('.is-icpassport').find('.input-passport').show();
		$(this).parents('.is-icpassport').find('.input-ic').hide();
		$(this).parents('.is-icpassport').find('.input-passport input').prop('disabled', false);
		$(this).parents('.is-icpassport').find('.input-ic input').prop('disabled', true);
	}
});

$(".is-passport").on('change', function() {
	if( $(this).prop('checked') ) {
		$(this).parents('.is-icpassport').find('.input-passport').show();
		$(this).parents('.is-icpassport').find('.input-ic').hide();
		$(this).parents('.is-icpassport').find('.input-passport input').prop('disabled', false);
		$(this).parents('.is-icpassport').find('.input-ic input').prop('disabled', true);
	}
	else {
		$(this).parents('.is-icpassport').find('.input-passport').hide();
		$(this).parents('.is-icpassport').find('.input-ic').show();
		$(this).parents('.is-icpassport').find('.input-passport input').prop('disabled', true);
		$(this).parents('.is-icpassport').find('.input-ic input').prop('disabled', false);
	}
});

$(".is-ic, .is-passport").trigger('change');

$('.date input').datepicker({ 
    language: 'ms',
	format: 'dd/mm/yyyy',
    autoclose: true,
}).on('changeDate', function(){
    $(this).trigger('change');

    if($(this).valid()){
       $(this).parent().find('label.error').remove();
       $(this).parents('.form-group').removeClass('has-error');
       $(this).removeClass('error');
    }
});

$(".btn-query").on("click", function() {
	if( $(this).hasClass('btn-default') ) {
		$(this).removeClass('btn-default');
		$(this).addClass('btn-warning');
	}
	// else {
	// 	$(this).addClass('btn-default');
	// 	$(this).removeClass('btn-warning');
	// }

	swal({
        title: "Ulasan Kuiri",
        text: "Ulasan kuiri adalah tidak wajib.",
        icon: "info",
        buttons: ["Batal Kuiri", { text: "Simpan", closeModal: false, className: "btn-info" }],
        content: {
            element: "textarea",
            attributes: {
                placeholder: "Kuiri",
            },
        }
    })
    .then((data) => {
        // console.log(data);
        if (data !== null)
            swal("Berjaya", "Kuiri telah disimpan.", "success");
        else {
        	$(this).addClass('btn-default');
        	$(this).removeClass('btn-warning');
        }

    });
});

function submitQuery() {
	swal({
        title: "Hantar Kuiri",
        text: "Adakah anda pasti untuk menghantar kuiri?",
        icon: "warning",
        buttons: ["Tutup", { text: "Hantar", closeModal: false, className: "btn-info" }]
    })
    .then((data) => {
        // console.log(data);
        if (data !== null)
            swal("Berjaya", "Kuiri telah dihantar.", "success");

        $("#modal-query").modal('hide');
    });
}

function submitResult() {
	swal({
        title: "Hantar Keputusan",
        text: "Adakah anda pasti untuk menghantar keputusan ini?",
        icon: "warning",
        buttons: ["Tutup", { text: "Hantar", closeModal: false, className: "btn-info" }]
    })
    .then((data) => {
        // console.log(data);
        if (data !== null)
            swal("Berjaya", "Keputusan telah dihantar.", "success");

        $("#modal-rejected").modal('hide');
    });
}

function back() {
    window.history.back();
}

function deleteData(id) {
    swal({
        title: "Padam Data",
        text: "Data yang telah dipadam tidak boleh dikembalikan. Teruskan?",
        icon: "warning",
        buttons: ["Batal", { text: "Padam", closeModal: false }],
        dangerMode: true,
    })
    .then((confirm) => {
        if (confirm) {
            swal("Berjaya!", "Data telah dipadamkan.", "success");
        }
    });
}

function downloadData(id) {
	location.href="http://speedtest-sgp1.digitalocean.com/10mb.test";
}

function saveData(id) {
	swal("Berjaya!", "Data telah disimpan.", "success");
}

function addData() {
	$("#modal-add").modal("show");
}

function editData(id) {
	$("#modal-edit").modal("show");
}

function submitAdd() {
	$("#modal-add").modal("hide");
	swal("Berjaya!", "Data telah dihantar.", "success");
}

function submitUpdate() {
	$("#modal-edit").modal("hide");
	swal("Berjaya!", "Data telah dikemaskini.", "success");
}

function addData2() {
	$("#modal-add2").modal("show");
}

function editData2(id) {
	$("#modal-edit2").modal("show");
}

function submitAdd2() {
	$("#modal-add2").modal("hide");
	swal("Berjaya!", "Data telah dihantar.", "success");
}

function submitUpdate2() {
	$("#modal-edit2").modal("hide");
	swal("Berjaya!", "Data telah dikemaskini.", "success");
}

function submitPassword() {
	$("#modal-password").modal("hide");
	swal("Berjaya!", "Kata laluan telah dikemaskini.", "success");
}

function passwordData(id) {
	$("#modal-password").modal("show");
}

jQuery.extend(jQuery.validator.messages, {
    required: "Ruangan ini perlu diisi.",
    remote: "Sila betulkan maklumat pada ruangan ini.",
    email: "Sila masukkan format emel yang sah.",
    url: "Sila masukkan format URL yang sah.",
    date: "Sila masukkan format tarikh yang sah.",
    dateISO: "Sila masukkan format ISO tarikh yang sah.",
    number: "Sila masukkan nombor yang sah.",
    digits: "Sila masukkan nombor digit sahaja.",
    creditcard: "Sila masukkan nombor kad kredit yang sah.",
    equalTo: "Sila masukkan nilai yang sama semula.",
    accept: "Sila masukkan nilai dengan penyambung yang sah.",
    maxlength: jQuery.validator.format("Sila masukkan tidak melebihi {0} aksara."),
    minlength: jQuery.validator.format("Sila masukkan sekurang-kurangnya {0} aksara."),
    rangelength: jQuery.validator.format("Sila masukkan di antara {0} dan {1} aksara."),
    range: jQuery.validator.format("Sila masukkan nilai di antara {0} dan {1}."),
    max: jQuery.validator.format("Sila masukkan nilai kurang daripada atau sama dengan {0}."),
    min: jQuery.validator.format("Sila masukkan nilai lebih daripada atau sama dengan {0}.")
});