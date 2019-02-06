@extends('layouts.auth')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h4 class="bold">Daftar Akaun</h4>
        <p>Sila isi maklumat pada borang dibawah untuk mendaftar dengan sistem ini.</p>
        <form method="POST" action="{{ route('handover.create') }}" class="p-t-15" id="form-register" name="form-register" role="form">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-8">
                    @include('components.input', [
                        'label' => 'Nama Setiausaha Penaja',
                        'info' => 'Nama Penuh Setiausaha Penaja',
                        'mode' => 'required',
                        'name' => 'uname',
                    ])
                </div>
                <div class="col-md-4">
                    @include('components.input', [
                        'label' => 'ID Pengguna',
                        'info' => 'No. Kad Pengenalan Setiausaha Penaja',
                        'options' => 'maxlength=12 minlength=12',
                        'class' => 'numeric',
                        'mode' => 'required',
                        'name' => 'username',
                    ])
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    @include('components.input', [
                        'label' => 'No. Telefon',
                        'info' => 'No. Telefon Setiausaha Penaja',
                        'mode' => 'required',
                        'name' => 'phone',
                        'type' => 'tel',
                    ])
                </div>
                <div class="col-md-8">
                    @include('components.input', [
                        'label' => 'Alamat Emel',
                        'info' => 'Alamat Emel Kesatuan Sekerja',
                        'mode' => 'required',
                        'name' => 'email',
                        'type' => 'email',
                    ])
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    @include('components.input', [
                        'label' => 'Kata Laluan',
                        'info' => 'Minimum 8 Aksara',
                        'mode' => 'required',
                        'name' => 'password',
                        'type' => 'password',
                        'options' => 'minlength=8',
                        'placeholder' => 'Minimum 8 Aksara',
                    ])
                </div>
                <div class="col-md-6">
                    @include('components.input', [
                        'label' => 'Pengesahan Kata Laluan',
                        'info' => 'Sama Seperti Kata Laluan',
                        'mode' => 'required',
                        'name' => 'password_confirmation',
                        'type' => 'password',
                        'options' => 'minlength=8',
                        'placeholder' => 'Minimum 8 Aksara',
                    ])
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <p>Dengan mendaftar, saya bersetuju dengan  <a href="#" class="text-info bold">Terma dan Syarat</a> yang ditetapkan.</p>
                    <div class="g-recaptcha text" data-sitekey="6Lc4Z1MUAAAAACku67XxtFp_jHA3PCUD3iQPbK9S"></div>
                </div>
            </div>
            <button class="btn btn-info m-t-10 pull-right" type="submit"><i class="fa fa-check m-r-5"></i> Daftar Akaun</button>
            <a class="btn btn-default m-t-10" href="{{ route('login') }}"><i class="fa fa-angle-left m-r-5"></i> Log Masuk</a>
        </form>
    </div>
</div>
@endsection

@push('js')
<script type="text/javascript">

    $(function() {
        $('#form-register').validate({
            rules: {
                password: "required",
                password_confirmation: {
                    equalTo: "input[name=password]"
                }
            }
        })
    })

    $("#form-register").submit(function(e) {
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
                swal(data.title, data.message, data.status)
                .then((confirm) => {
                    if (confirm) {
                        location.href="{{ route('login') }}";
                    }
                });
            }
        });
    });
</script>
@endpush