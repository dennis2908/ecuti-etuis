<h5>Permohonan <strong>Pendaftaran Kesatuan Sekerja</strong></h5>
<div class="card card-borderless">
    <ul class="nav nav-tabs nav-tabs-simple hidden-sm-down" role="tablist" data-init-reponsive-tabs="dropdownfx">
        <li class="nav-item">
            <a class="active" data-toggle="tab" role="tab" data-target="#innertab1" href="#" aria-expanded="true">Maklumat Kesatuan Sekerja</a>
        </li>
        <li class="nav-item">
            <a href="#" data-toggle="tab" role="tab" data-target="#innertab2" class="" aria-expanded="false">Butiran Pemohon</a>
        </li>
        <li class="nav-item">
            <a href="#" data-toggle="tab" role="tab" data-target="#innertab3" class="" aria-expanded="false">Butiran Pegawai</a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="innertab1" aria-expanded="true">
            <table class="table">
                <tbody>
                    <tr>
                        <td class="fit"><button class="btn btn-default btn-xs btn-query"><i class="fa fa-question"></i></button></td>
                        <td>Nama Kesatuan Sekerja</td>
                        <td>Kesatuan Unijaya</td>
                    </tr>
                    <tr>
                        <td class="fit"><button class="btn btn-default btn-xs btn-query"><i class="fa fa-question"></i></button></td>
                        <td>Alamat Ibu Pejabat</td>
                        <td>
                            D-9-5, Megan Avenue 1, 189<br>
                            Jalan Tun Razak, 50400<br>
                            Kuala Lumpur
                        </td>
                    </tr>
                    <tr>
                        <td class="fit"><button class="btn btn-default btn-xs btn-query"><i class="fa fa-question"></i></button></td>
                        <td>Tarikh Penubuhan</td>
                        <td>12/03/2018</td>
                    </tr>
                    <tr>
                        <td class="fit"><button class="btn btn-default btn-xs btn-query"><i class="fa fa-question"></i></button></td>
                        <td>Cawangan</td>
                        <td>Bercawangan</td>
                    </tr>
                    <tr>
                        <td class="fit"><button class="btn btn-default btn-xs btn-query"><i class="fa fa-question"></i></button></td>
                        <td>Jenis Kesatuan</td>
                        <td>Majikan</td>
                    </tr>
                    <tr>
                        <td class="fit"><button class="btn btn-default btn-xs btn-query"><i class="fa fa-question"></i></button></td>
                        <td>Sektor</td>
                        <td>Kerajaan</td>
                    </tr>
                    <tr>
                        <td class="fit"><button class="btn btn-default btn-xs btn-query"><i class="fa fa-question"></i></button></td>
                        <td>Bilangan Ahli</td>
                        <td>100 Orang</td>
                    </tr>
                    <tr>
                        <td class="fit"><button class="btn btn-default btn-xs btn-query"><i class="fa fa-question"></i></button></td>
                        <td>Nama Setiausaha Penaja</td>
                        <td>Adlan Arif Bin Zakaria</td>
                    </tr>
                    <tr>
                        <td class="fit"><button class="btn btn-default btn-xs btn-query"><i class="fa fa-question"></i></button></td>
                        <td>Tarikh Permohonan</td>
                        <td>15/01/2018</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="tab-pane" id="innertab2" aria-expanded="false">
            <div class="card card-transparent">
                <div class="card-header px-0">
                    <div class="card-title">
                        <button onclick="addData()" class="btn btn-default btn-query"><i class="fa fa-question m-r-5"></i> Kuiri</button>
                    </div>
                    <div class="pull-right">
                        <div class="col-xs-12">
                            <input type="text" id="search-table" class="form-control search-table pull-right" placeholder="Carian">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="card-block table-responsive">
                    <table class="table table-hover " id="table">
                        <thead>
                            <tr>
                                <th class="fit">Bil.</th>
                                <th>Nama</th>
                                <th>No. Kad Pengenalan</th>
                                <th>Pekerjaan</th>
                                <th>Alamat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(range(1,7) as $index)
                            <tr>
                                <td>{{ $index }}</td>
                                <td>Adlan Arif Bin Zakaria</td>
                                <td>010101010110</td>
                                <td>Developer</td>
                                <td>
                                    D-9-5, Megan Avenue 1, 189<br>
                                    Jalan Tun Razak, 50400<br>
                                    Kuala Lumpur
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="innertab3" aria-expanded="false">
            <div class="card card-transparent">
                <div class="card-header px-0">
                    <div class="card-title">
                        <button onclick="addData()" class="btn btn-default btn-query"><i class="fa fa-question m-r-5"></i> Kuiri</button>
                    </div>
                    <div class="pull-right">
                        <div class="col-xs-12">
                            <input type="text" id="search-table" class="form-control search-table pull-right" placeholder="Carian">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="card-block table-responsive">
                    <table class="table table-hover " id="table">
                        <thead>
                            <tr>
                                <th class="fit">Bil.</th>
                                <th>Nama Jawatan</th>
                                <th>Nama</th>
                                <th>Umur (Tahun)</th>
                                <th>Kewarganegaraan</th>
                                <th>No. Kad Pengenalan / No. Passport</th>
                                <th>Alamat</th>
                                <th>Butir-butir mengenai jawatan dahulu yang dipegang dalam kesatuan sekerja</th>
                                <th>Butir-butir mengenai apa-apa thabitan di mana-mana Mahkamah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(range(1,7) as $index)
                            <tr>
                                <td>{{ $index }}</td>
                                <td>Presiden</td>
                                <td>Adlan Arif Bin Zakaria</td>
                                <td>24</td>
                                <td>Malaysia</td>
                                <td>010101010110</td>
                                <td>
                                    D-9-5, Megan Avenue 1, 189<br>
                                    Jalan Tun Razak, 50400<br>
                                    Kuala Lumpur
                                </td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>