<div class="agency">
    <button class="btn btn-primary btn-sm btn-cons" type="button" onclick="addParticipant()"><i class="fa fa-plus m-r-5"></i> Tambah </button>

    <table class="table table-hover " id="table-participant">
        <thead>
            <tr>
                <th class="fit">Bil.</th>
                <th>Nama</th>
                <th>Jenis</th>
                <th class="fit">Tindakan</th>
            </tr>
        </thead>
    </table>
</div>

@push('modal')
<div class="modal fade" id="modal-addParticipant" tabindex="-1" role="dialog" aria-hidden="false">
	<div class="modal-dialog ">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="modal-header clearfix text-left">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
					</button>
					<h5>Maklumat <span class="semi-bold">Individu / Agensi Luar yang terlibat</span></h5>
                    <p class="p-b-10">Sila isi maklumat pada ruangan di bawah.</p>
				</div>
				<div class="modal-body">
					<form id="form-add-participant" role="form" method="post" action="{{ route('fund.id1.participant', $fund->id) }}">

						<div class="form-group form-group-default required">
							<label>
								<span> Jenis Pihak yang terlibat</span>
							</label>
							<div class="radio radio-primary">
                                @foreach($party_types as $party_type)
                                <input name="party_type_id" value="{{ $party_type->id }}" id="type{{ $party_type->id }}" type="radio" class="hidden" onchange="participantType()" required>
                                <label for="type{{ $party_type->id }}">{{ $party_type->name }}</label>
                                @endforeach
							</div>
						</div>

                        <div class="form-group-attached type2 hidden">

                            <div class="type1 hidden">
                                @include('components.input', [
                                    'name' => 'member_no',
                                    'label' => 'Nombor Ahli',
                                ])
                            </div>

							<div class="row">
								<div class="col-md-12">
									@include('components.input', [
										'name' => 'individual_name',
										'label' => 'Nama',
									])
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									@include('components.input', [
										'name' => 'occupation',
										'label' => 'Pekerjaan',
									])
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									@include('components.input', [
										'name' => 'identification_no',
										'label' => 'No Kad Pengenalan',
                                        'options' => 'maxlength=12 minlength=12',
                                        'class' => 'numeric',
									])
								</div>
								<div class="col-md-6">
									@include('components.input', [
										'name' => 'phone',
										'label' => 'No Telefon',
									])
								</div>
							</div>
                        </div>

                        <div class="form-group-attached type3 hidden">
							<div class="row">
								<div class="col-md-12">
									@include('components.input', [
										'name' => 'company_name',
										'label' => 'Nama Agensi Syarikat',
									])
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									@include('components.input', [
										'name' => 'registration_no',
										'label' => 'No Pendaftaran Syarikat',
									])
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									@include('components.textarea', [
										'name' => 'address_company',
										'label' => 'Alamat',
									])
								</div>
							</div>
                            <div class="row">
                                <div class="col-md-12">
                                    @include('components.input', [
                                        'name' => 'email',
                                        'label' => 'Emel',
                                    ])
                                </div>
                            </div>
							<div class="row">
								<div class="col-md-6">
									@include('components.input', [
										'name' => 'fax',
										'label' => 'No Faks',
									])
								</div>
								<div class="col-md-6">
									@include('components.input', [
										'name' => 'phone_company',
										'label' => 'Telefon',
									])
								</div>
							</div>
						</div>
					</form>
					<div class="row">
						<div class="col-md-12 p-t-10">
							<button type="button" class="btn btn-info m-t-5 pull-right submit" onclick="submitForm('form-add-participant')"><i class="fa fa-check"></i> Simpan</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
</div>
@endpush

@push('js')
<script>
function participantType() {
    var type = $('input[name="party_type_id"]:checked').val();

    if(type == 1) {
        $(".type1").removeClass("hidden");
        $(".type2").removeClass("hidden");
        $(".type3").addClass("hidden");
     }
    else if(type == 2) {
        $(".type1").addClass("hidden");
        $(".type2").removeClass("hidden");
        $(".type3").addClass("hidden");
     }
    else if(type == 3) {
        $(".type1").addClass("hidden");
        $(".type2").addClass("hidden");
        $(".type3").removeClass("hidden");
     }
}

var table = $('#table-participant');

var settings = {
    "processing": true,
    "serverSide": true,
    "deferRender": true,
    "ajax": "{{ route('fund.id1.participant', $fund->id) }}",
    "columns": [
        { data: 'index', defaultContent: '', orderable: false, searchable: false, render: function (data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
        }},
        { data: "name", name: "name"},
        { data: "party_type.name", name: "party_type.name"},
        { data: "action", name: "action", orderable: false, searchable: false},
    ],
    "columnDefs": [
        { className: "nowrap", "targets": [ 3 ] }
    ],
    "sDom": "<t><'row'<p i>>",
    "destroy": true,
    "scrollCollapse": true,
    "oLanguage": {
        "sEmptyTable":      "Tiada data",
        "sInfo":            "Paparan dari _START_ hingga _END_ dari _TOTAL_ rekod",
        "sInfoEmpty":       "Paparan 0 hingga 0 dari 0 rekod",
        "sInfoFiltered":    "(Ditapis dari jumlah _MAX_ rekod)",
        "sInfoPostFix":     "",
        "sInfoThousands":   ",",
        "sLengthMenu":      "Papar _MENU_ rekod",
        "sLoadingRecords":  "Diproses...",
        "sProcessing":      "Sedang diproses...",
        "sSearch":          "Carian:",
       "sZeroRecords":      "Tiada padanan rekod yang dijumpai.",
       "oPaginate": {
           "sFirst":        "Pertama",
           "sPrevious":     "Sebelum",
           "sNext":         "Kemudian",
           "sLast":         "Akhir"
       },
       "oAria": {
           "sSortAscending":  ": diaktifkan kepada susunan lajur menaik",
           "sSortDescending": ": diaktifkan kepada susunan lajur menurun"
       }
    },
    "iDisplayLength": 10
};

table.dataTable(settings);

function addParticipant() {
    $('#modal-addParticipant').modal('show');
    $('.modal form').trigger("reset");
    $('.modal form').validate();
}

function editParticipant(id) {
    $("#modal-div").load("{{ route('fund.id1.participant',$fund->id) }}/"+id);
}

$("#form-add-participant").submit(function(e) {

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
            $("#modal-addParticipant").modal("hide");
            table.api().ajax.reload(null, false);
        }
    });
});

function removeParticipant(id) {
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
                url: '{{ route('fund.id1.participant', $fund->id) }}/'+id,
                method: 'delete',
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
</script>
@endpush
