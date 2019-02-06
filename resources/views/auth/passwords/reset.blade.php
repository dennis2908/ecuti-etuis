@extends('layouts.auth')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h4 class="bold">Set Semua Kata Laluan</h4>
        <p>Kemaskini kata laluan baru anda untuk mengakses sistem e-TUIS.</p>
        <form method="POST" action="{{ route('password.request') }}" class="p-t-15" id="form-reset" name="form-reset" role="form">
            {{ csrf_field() }}
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="row">
                <div class="col-md-12">
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
            <button class="btn btn-info m-t-10 pull-right" type="submit"><i class="fa fa-check m-r-5"></i> Hantar</button>
            <a class="btn btn-default m-t-10" href="{{ route('login') }}"><i class="fa fa-angle-left m-r-5"></i> Log Masuk</a>
        </form>
    </div>
</div>
@endsection

@push('js')
<script type="text/javascript">
    $(function() {
        $('#form-reset').validate({
            rules: {
                password: "required",
                password_confirmation: {
                    equalTo: "input[name=password]"
                }
            }
        })
    })
</script>
@endpush
