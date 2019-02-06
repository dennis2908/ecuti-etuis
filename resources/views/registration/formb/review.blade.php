@extends('layouts.app')

@section('content')
<!-- START JUMBOTRON -->
<div class="jumbotron" data-pages="parallax">
    <div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
        <div class="inner">
            <!-- START BREADCRUMB -->
            {{ Breadcrumbs::render('registration.formb') }}
            <!-- END BREADCRUMB -->
            <div class="row">
                <div class="col-xl-12 col-lg-12 ">
                    <!-- START card -->
                    <div class="card card-transparent">
                        <div class="card-block p-t-0">
                            <h3 class='m-t-0'>Semakan <span class="semi-bold">Pendaftaran Kesatuan Sekerja</span></h3>
                            <p class="small hint-text m-t-5">
                                Semakan boleh dilalukan melalui paparan di bawah, dan kuiri boleh dilakukan jika terdapat maklumat yg tidak lengkap.
                            </p>
                            <br>
                            <button onclick="back()" class="btn btn-default"><i class="fa fa-angle-left m-r-5"></i> Kembali</button>
                            <button onclick="submitQuery()" class="btn btn-info"><i class="fa fa-check m-r-5"></i> Hantar Kuiri</button>
                        </div>
                    </div>
                    <!-- END card -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END JUMBOTRON -->

<div class="card card-transparent flex-row">
    <ul class="nav nav-tabs nav-tabs-simple nav-tabs-left bg-white" id="tab-3">
        <li class="nav-item">
            <a href="#" class="active" data-toggle="tab" data-target="#tab1" aria-expanded="true">Borang B2</a>
        </li>
        <li class="nav-item">
            <a href="#" data-toggle="tab" data-target="#tab2" class="" aria-expanded="false">Borang B3</a>
        </li>
        <li class="nav-item">
            <a href="#" data-toggle="tab" data-target="#tab3" class="" aria-expanded="false">Borang B4</a>
        </li>
        <li class="nav-item">
            <a href="#" data-toggle="tab" data-target="#tab4" class="" aria-expanded="false">Dokumen Sokongan</a>
        </li>
    </ul>
    <div class="tab-content bg-white" style="width: 100%">
        <div class="tab-pane active" id="tab1" aria-expanded="true">
            @include('registration.formb.b2.review')
        </div>
        <div class="tab-pane" id="tab2" aria-expanded="false">
            @include('registration.formb.b3.review')
        </div>
        <div class="tab-pane" id="tab3" aria-expanded="false">
            @include('registration.formb.b4.review')
        </div>
        <div class="tab-pane" id="tab4" aria-expanded="false">
            <h5>Dokumen <strong>Sokongan</strong></h5>
            <table class="table">
                <tbody>
                    <tr>
                        <td class="fit"><button class="btn btn-default btn-xs btn-query"><i class="fa fa-question"></i></button></td>
                        <td>Borang B (3 Salinan Asal)</td>
                    </tr>
                    <tr>
                        <td class="fit"><button class="btn btn-default btn-xs btn-query"><i class="fa fa-question"></i></button></td>
                        <td>Buku Perlembagaan Tanpa Cawangan / Buku Perlembagaan Bercawangan (4 Salinan Asal)</td>
                    </tr>
                    <tr>
                        <td class="fit"><button class="btn btn-default btn-xs btn-query"><i class="fa fa-question"></i></button></td>
                        <td>Minit Mesyuarat Penubuhan</td>
                    </tr>
                    <tr>
                        <td class="fit"><button class="btn btn-default btn-xs btn-query"><i class="fa fa-question"></i></button></td>
                        <td>SSM</td>
                    </tr>
                    <tr>
                        <td class="fit"><button class="btn btn-default btn-xs btn-query"><i class="fa fa-question"></i></button></td>
                        <td>Salinan KP Pemohon</td>
                    </tr>
                    <tr>
                        <td class="fit"><button class="btn btn-default btn-xs btn-query"><i class="fa fa-question"></i></button></td>
                        <td>Surat Kebenaran Guna Alamat Majikan (jika berkenaan)</td>
                    </tr>
                    <tr>
                        <td class="fit"><button class="btn btn-default btn-xs btn-query"><i class="fa fa-question"></i></button></td>
                        <td>Bukti Penggajian Pemohon & Pegawai Penaja</td>
                    </tr>
                    <tr>
                        <td class="fit"><button class="btn btn-default btn-xs btn-query"><i class="fa fa-question"></i></button></td>
                        <td>Surat Pengesahan Majikan / Surat Tawaran</td>
                    </tr>
                    <tr>
                        <td class="fit"><button class="btn btn-default btn-xs btn-query"><i class="fa fa-question"></i></button></td>
                        <td>Borang Praecipe</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection