@extends('layouts.auth')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h4 class="bold">Daftar Akaun</h4>
        <p>Sila isi maklumat pada borang dibawah untuk mendaftar dengan sistem ini.</p>
        <form method="POST" action="{{ route('register') }}" class="p-t-15" id="form-register" name="form-register" role="form">
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
                <div class="col-md-12">
                    <div class="radio radio-info">
                        <input value="1" name="is_union" id="is_union_yes" class="hidden" onchange="updateEntityName()" checked="" type="radio">
                        <label for="is_union_yes">Kesatuan @include('components.info', ['text' => 'Kesatuan adalah gabungan pekerja / majikan'])</label>
                        <input value="0" name="is_union" id="is_union_no" class="hidden" onchange="updateEntityName()" type="radio">
                        <label for="is_union_no">Persekutuan @include('components.info', ['text' => 'Persekutuan adalah gabungan Kesatuan-Kesatuan Sekerja'])</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    @include('components.input', [
                        'label' => 'Nama Kesatuan',
                        'info' => 'Seperti Yang Telah Didaftarkan',
                        'mode' => 'required',
                        'name' => 'name',
                    ])
                </div>
                <div class="col-md-4">
                    @include('components.date', [
                        'label' => 'Tarikh Penubuhan',
                        'info' => 'Seperti Yang Telah Didaftarkan',
                        'mode' => 'required',
                        'name' => 'registered_at',
                    ])
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    {!! app('captcha')->display() !!}
                </div>
            </div>
            <a class="btn btn-info m-t-10 pull-right text-white" data-toggle="modal" data-target="#modal-agreement"><i class="fa fa-check m-r-5"></i> Daftar Akaun</a>
            <a class="btn btn-default m-t-10" href="{{ route('login') }}"><i class="fa fa-angle-left m-r-5"></i> Log Masuk</a>
        </form>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-agreement" tabindex="-1" role="dialog" aria-labelledby="addModalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalTitle"><span class="bold">Pengakuan</span></h5>
                <small class="text-muted">Sila baca perakuan di bawah sebelum mendaftar.</small>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body m-t-20">
                <p>Saya mengakui telah diberikuasa dengan sewajarnya oleh kesatuan sekerja berkaitan untuk membuat permohonan bagi pihaknya dan mengesahkan bahawa kenyataan-kenyataan yang terkandung dalam permohonan ini adalah benar serta mengikut kehendak Akta Kesatuan Sekerja 1959 dan Peraturan-peraturan Kesatuan Sekerja 1959</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" onclick="submitForm('form-register')" data-dismiss="modal"><i class="fa fa-check m-r-5"></i> Teruskan Pendaftaran</button>
            </div>
        </div>
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

    function updateEntityName() {
        if( $("input[name=is_union]:checked").val() == 1 )
            $("#label_name").html("Nama Kesatuan");
        else
            $("#label_name").html("Nama Persekutuan Kesatuan");

    }
</script>
@endpush