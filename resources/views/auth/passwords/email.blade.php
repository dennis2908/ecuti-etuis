@extends('layouts.auth')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h4 class="bold">Lupa Kata Laluan ?</h4>
        <p>Isikan alamat emel anda dan kami akan menghantar URL pemulihan kepada anda.</p>
        <form method="POST" action="{{ route('password.email') }}" class="p-t-15" id="form-recover" name="form-recover" role="form">
            {{ csrf_field() }}
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
                <div class="col-md-12 p-l-0">
                    <small>Masalah log masuk? Hubungi pentadbir sistem di <a class="text-complete" href="mailto:admin@email.com">admin@email.com</a></small>
                </div>
            </div>
            <br>
            <div class="g-recaptcha text" data-sitekey="6Lc4Z1MUAAAAACku67XxtFp_jHA3PCUD3iQPbK9S"></div>
            <br>
            <button class="btn btn-info m-t-10 pull-right" type="submit"><i class="fa fa-check m-r-5"></i> Hantar URL Pemulihan</button>
            <a class="btn btn-default m-t-10" href="{{ route('login') }}"><i class="fa fa-angle-left m-r-5"></i> Log Masuk</a>
        </form>
    </div>
</div>
@endsection

@push('js')
<script type="text/javascript">
    $(function() {
        $('#form-recover').validate()
    })
</script>
@endpush