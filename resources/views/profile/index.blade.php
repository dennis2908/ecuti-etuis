@extends('layouts.app')
@include('plugins.dropify')

@push('css')
<style type="text/css">
.modal-open .select2-container {
    z-index: 1039 !important;
}
</style>
@endpush

@push('css')
<style type="text/css">
.modal-open .select2-container {
    z-index: 1039 !important;
}
</style>
@endpush

@section('content')
<!-- START JUMBOTRON -->
<div class="jumbotron" data-pages="parallax">
	<div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
		<div class="inner" style="transform: translateY(0px); opacity: 1;">
			{{ Breadcrumbs::render('profile') }}
		</div>
	</div>
</div>
<!-- END JUMBOTRON -->
<!-- START CONTAINER FLUID -->
<div class=" container-fluid container-fixed-lg">
    <!-- START card -->
    <div class="card card-transparent">
        <div class="card-block">
        	<form id='form-edit' role="form" method="post" action="{{ route('profile') }}">
	    		<div class="row">
	        		<div class="col-md-3">
	        			<input type="file" class="dropify" name="picture_url" @if(auth()->user()->picture_url)data-default-file="{{ route('profile.picture', 'avatar.jpg') }}" @endif data-allowed-file-extensions="jpg png gif jpeg" />
	        			<a class="btn btn-default btn-block m-t-10 text-capitalize" onclick="passwordData()"><i class="fa fa-lock m-r-5"></i> Kemaskini Kata Laluan</a>

	        			@if(auth()->user()->hasRole('ks'))
	        			<div class="alert alert-warning m-t-10">
		                	<strong>Perhatian:</strong>
			                Untuk penyerahan tugas kepada Setiausaha baru, sila klik pada butang di bawah. Akaun ini akan ditutup selepas pendaftaran Setiausaha baru selesai.		                
			            </div>

	        			<a class="btn btn-danger btn-block text-capitalize text-white" onclick="handOver()"><i class="fa fa-refresh m-r-5"></i> Serahan Tugas</a>
	        			@endif
	        		</div>
	        		<div class="col-md-9 bg-white p-3">
	        			<h3 class=''>Profil Pengguna</h3>
						<p class="small hint-text m-b-20">
							Anda boleh mengemaskini profil anda melalui ruangan borang di bawah.
						</p>
						
	    				<div class="row">        				
	        				<div class="col-md-12 padding-0">
			        			@include('components.input', [
			        				'name' => 'name',
			        				'label' => 'Nama Pengguna',
			        				'mode' => 'required',
			        				'value' => auth()->user()->name
			        			])
			        		</div>
			        		<div class="col-md-12 padding-0">
			        			@include('components.input', [
			        				'name' => 'email',
			        				'label' => 'Alamat Emel',
			        				'type' => 'email',
			        				'mode' => 'required',
			        				'value' => auth()->user()->email
			        			])
			        		</div>
			        		@if(!auth()->user()->hasAnyRole(['admin','ks']))
			        		<div class="col-md-12 padding-0">
			        			@include('components.input', [
			        				'name' => 'designation',
			        				'label' => 'Jawatan',
			        				'value' => auth()->user()->entity->role->description,
			        				'options' => 'disabled'
			        			])
			        		</div>
			        		<div class="col-md-12 padding-0">
			        			@include('components.input', [
			        				'name' => 'office-province',
			        				'label' => 'Pejabat Wilayah',
			        				'value' => auth()->user()->entity->province_office->name,
			        				'options' => 'disabled'
			        			])
			        		</div>
			        		@elseif(auth()->user()->hasRole('ks'))
			        		<div class="col-md-12 padding-0">
				        		<div class="form-group form-group-default form-group-default-custom form-group-default-select2 required">
			                        <label><span>Industri</span></label>
			                        <select id="industry_id" name="industry_id" class="full-width autoscroll" required data-init-plugin="select2" required="">
			                        	<option disabled selected hidden>Pilih satu..</option> 
			                            @foreach($industries as $index => $industry)
			                            <option value="{{ $industry->id }}"
			                            	@if(auth()->user()->entity->industry_type_id == $industry->id) 
			                            		selected
			                            	@endif>
			                            	{{ $industry->name }}
			                            </option>
			                            @endforeach
			                        </select>
			                    </div>
			                </div>
			        		@endif

	        			</div>
		        		<div class="row mb-3">
							<div class="col-md-12">
								<a type="button" class="btn btn-info pull-right text-white" onclick="submitForm('form-edit')"><i class="fa fa-check mr-1"></i> Simpan</a>
							</div>
						</div>
	        		</div>	        	
	    		</div>
			</form>
        </div>
    </div>
    <!-- END card -->
</div>
<!-- END CONTAINER FLUID -->
@endsection

@push('modal')
<!-- Modal -->
<div class="modal fade" id="modal-handover" tabindex="-1" role="dialog" aria-labelledby="addModalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalTitle">Serahan <span class="bold">Tugas</span></h5>
                <small class="text-muted">Sila isi maklumat pada ruangan di bawah.</small>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body m-t-20">
            	<form id='form-handover' role="form" method="post" action="{{ route('profile.handover') }}">
                @include('components.input', [
                    'name' => 'new_email',
                    'label' => 'Email Setiausaha Baru',
                    'mode' => 'required',
                    'modal' => true,
                    'type' => 'email',
                ])
            	</form>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                <button type="button" class="btn btn-info" onclick="submitForm('form-handover')"><i class="fa fa-check m-r-5"></i> Hantar</button>
            </div>
        </div>
    </div>
</div>
@endpush

@push('js')
<script type="text/javascript">
	$('.dropify').dropify();

	$("#form-edit").validate();

	function handOver() {
		$("#modal-handover").modal("show");
		$("#form-handover").validate();
		$("#form-handover").trigger("reset");
	}

	$("form").submit(function(e) {
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
				$("#modal-handover").modal("hide");
	        }
	    });
	});
</script>
@endpush
