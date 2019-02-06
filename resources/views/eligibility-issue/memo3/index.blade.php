@extends('layouts.app')
@include('plugins.timepicker')

@section('content')
<!-- START JUMBOTRON -->
<div class="jumbotron" data-pages="parallax">
    <div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
        <div class="inner">
            <!-- START BREADCRUMB -->
            {{ Breadcrumbs::render('eligibility-issue') }}
            <!-- END BREADCRUMB -->
            <div class="row">
                <div class="col-xl-12 col-lg-12 ">
                    <!-- START card -->
                    <div class="card card-transparent">
                        <div class="card-block p-t-0">
                            <h3 class='m-t-0'>Surat Siasatan</h3>
                            <p class="small hint-text m-t-5">
                                Sila lengkapkan semua maklumat berikut mengikut turutan dan arahan yang dipaparkan.
                            </p>
                        </div>
                    </div>
                    <!-- END card -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END JUMBOTRON -->
<div class=" container-fluid container-fixed-lg bg-white">
    <!-- START card -->
    <div class="card card-transparent">
        <div class="card-block">
            <div class="form-horizontal" role="form" autocomplete="off" method="post" action="#">

                @include('components.bs.input', [
                    'name' => 'name',
                    'label' => 'Rujukan Kami',
                    'mode' => 'required'
                ])

                 @include('components.bs.date', [
                    'name' => 'decided',
                    'label' => 'Tarikh Surat',
                    'mode' => 'required',
                    'value' => date('d/m/Y'),
                ])

                @include('components.bs.input', [
                    'name' => 'name',
                    'label' => 'Rujukan Tuan',
                    'mode' => 'required'
                ])

                 @include('components.bs.date', [
                    'name' => 'decided',
                    'label' => 'Tarikh Surat Tuan',
                    'mode' => 'required',
                    'value' => date('d/m/Y'),
                ])

                @include('components.bs.address', [
                    'name' => 'name',
                    'label' => 'Alamat Majikan',
                    'mode' => 'required'
                ])

                @include('components.bs.input', [
                    'name' => 'name',
                    'label' => 'Perkara',
                    'mode' => 'required'
                ])

                @include('components.bs.input', [
                    'name' => 'name',
                    'label' => 'Nama Pegawai Penyiasat',
                    'mode' => 'required'
                ])

                @include('components.bs.input', [
                    'name' => 'name',
                    'label' => 'Jawatan',
                    'mode' => 'required'
                ])

                @include('components.bs.input', [
                    'name' => 'name',
                    'label' => 'Hari Siasatan',
                    'mode' => 'required'
                ])

                 @include('components.bs.date', [
                    'name' => 'decided',
                    'label' => 'Tarikh Siasatan',
                    'mode' => 'required',
                    'value' => date('d/m/Y'),
                ])

                <div class="form-group row">
                    <label class="col-md-3 control-label">Masa Siasatan</label>
                    <div class="col-md-9">
                        <div class="input-group bootstrap-timepicker">
                          <input id="timepicker" type="text" class="form-control">
                          <span class="input-group-addon"><i class="pg-clock"></i></span>
                        </div>
                    </div>
                </div>

                @include('components.bs.input', [
                    'name' => 'name',
                    'label' => 'Nama Pengarah Wilayah / Negeri',
                    'mode' => 'required'
                ])

                
                <br>
                <div class="form-group">
                    <button type="button" class="btn btn-default mr-1" ><i class="fa fa-angle-left mr-1"></i> Kembali</button>
                    <button type="button" class="btn btn-info pull-right" onclick="submitAdd()" data-dismiss="modal"><i class="fa fa-check mr-1"></i> Hantar</button>
                </div>

            </div>
        </div>
    </div>
    <!-- END card -->
</div>
@endsection
@push('js')
<script type="text/javascript">
    $('#timepicker').timepicker({
        defaultValue: '12:45 AM'
    });
</script>
@endpush