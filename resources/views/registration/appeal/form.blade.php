@extends('layouts.auth')

@section('content')
<div class="col-md-12">
    <h4 class="bold">Rayuan (Seksyen 8(2) Akta Kesatuan Sekerja)</h4>
    <!-- <h4 class="bold">Rayuan (Seksyen 73(4) Akta Kesatuan Sekerja)</h4> -->
    <p>Sila isi maklumat pada borang dibawah untuk permohonan rayuan.</p>
    <form method="POST" action="{{ route('appeal.submit') }}" class="p-t-15" id="form-appeal" name="form-appeal" role="form">
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{ $user->id }}">
        <div class="row">
            <div class="col-md-8">
                <div class="form-group form-group-default required">
                    <label id="label_entity_name">Nama {{ $user->user_type_id == 3 ? 'Kesatuan' : 'Persekutuan Kesatuan' }}</label>
                    <input readonly aria-required="true" class="form-control" name="name" placeholder="" required="" type="text" value="{{ $user->entity->name }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group form-group-default input-group required">
                    <div class="form-input-group">
                        <label>Tarikh Penubuhan</label>
                        <input readonly aria-required="true" class="form-control" name="registered_at" placeholder="" required="" type="text" value="{{ date('d/m/Y', strtotime($user->entity->registered_at)) }}">
                    </div>
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @include('components.textarea', [
                    'label' => 'Justifikasi Kelewatan Mengemukakan Permohonan',
                    'info' => 'Justifikasi kelewatan mengemukakan permohonan melebihi tempoh 30 hari selepas tarikh penubuhan',
                    'mode' => 'required',
                    'name' => 'justification'
                ])
            </div>
        </div>
        <button class="btn btn-info m-t-10 pull-right" type="submit"><i class="fa fa-check m-r-5"></i> Hantar</button>
        <a class="btn btn-default m-t-10" href="{{ route('login') }}"><i class="fa fa-angle-left m-r-5"></i> Log Masuk</a>
    </form>
</div>
@endsection

@push('js')
<script type="text/javascript">

    $(function() {
        $('#form-appeal').validate()
    })

    $("#form-appeal").submit(function(e) {
        e.preventDefault();
        var form = $(this);

        $.ajax({
            url: form.attr('action'),
            method: form.attr('method'),
            data: new FormData(form[0]),
            dataType: 'json',
            async: true,
            contentType: false,
            processData: false,
            success: function(data) {
                swal(data.title, data.message, data.status).then((value) => {
                    if(data.status == "success")
                        location.href="{{ route('login') }}";
                });
            }
        });
    });

</script>
@endpush