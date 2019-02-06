@extends('layouts.app')
@include('plugins.chartjs')

@push('css')
<style type="text/css">
	.widget-9 {
	    height: unset !important;
	    padding-bottom: 20px;
	    padding-top: 20px;
	}

	.text-black {
		color: #000 !important;
	}

	x-small {
		font-size: medium !important;
	}
</style>
@endpush

@section('content')
<!-- START JUMBOTRON -->
<div class="jumbotron" data-pages="parallax">
    <div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
        <div class="inner" style="transform: translateY(0px); opacity: 1;">
            {{ Breadcrumbs::render('monitoring') }}
            <!-- END BREADCRUMB -->
            <div class="row">
                <div class="col-xl-12 col-lg-12 ">
                    <!-- START card -->
                    <div class="card card-transparent">
                        <div class="card-block p-t-0">
                            <h3 class='m-t-0'>Paparan Pemantauan</h3>
                            <p class="small hint-text m-t-5">
                                Pemantauan semua borang / permohonan boleh dilakukan melalui paparan di bawah.
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

<!-- START CONTAINER FLUID -->
<div class=" container-fluid container-fixed-lg">
    <div class="row">
    	<div class="col-md-12" id="module">
    		<div class="widget-12 card no-border widget-loader-circle no-margin padding-30">
    			<div class="card-block">
    				<div class="row">
                        <div class="col-sm-4">
                            <hr class="d-sm-block d-md-none">
                            <div class="widget-12-search">
                                <h4 class="pull-left">Jenis
                                    <span class="bold">Borang/Permohonan</span>
                                </h4>
                                <br>
                                <p class="small hint-text m-t-5">
                                    Sila pilih mana-mana jenis borang/permohonan di bawah untuk memaparkan graf statistik.
                                </p>
                                <div class="clearfix"></div>
                                <div style="max-height: 400px !important; overflow-y: auto;">
                                    @if(auth()->user()->hasAnyRole(['admin','kpks','tkpks','pkpg']))
                                    <div class="alert-menu alert {{ $table == 'formb' ? 'alert-info' : 'alert-warning' }} clickable" name="formb">
                                        <p class="mr-3 no-padding">Pendaftaran Kesatuan Sekerja (Borang B)</p>
                                    </div>
                                    <div class="alert-menu alert {{ $table == 'formbb' ? 'alert-info' : 'alert-warning' }} clickable" name="formbb">
                                        <p class="mr-3 no-padding">Pendaftaran Persekutuan Kesatuan Sekerja (Borang BB)</p>
                                    </div>
                                    <div class="alert-menu alert {{ $table == 'formo' ? 'alert-info' : 'alert-warning' }} clickable" name="formo">
                                        <p class="mr-3 no-padding">Notis Niat Menubuhkan Persekutuan Kesatuan Sekerja (Borang O)</p>
                                    </div>
                                    <div class="alert-menu alert {{ $table == 'formpq' ? 'alert-info' : 'alert-warning' }} clickable" name="formpq">
                                        <p class="mr-3 no-padding">Kesatuan Sekerja Dengan Persekutuan Kesatuan Sekerja (Borang P & Q)</p>
                                    </div>
                                    <div class="alert-menu alert {{ $table == 'formww' ? 'alert-info' : 'alert-warning' }} clickable" name="formww">
                                        <p class="mr-3 no-padding">Kesatuan Sekerja Dengan Badan Perundingan Dalam Malaysia (Borang WW)</p>
                                    </div>
                                    <div class="alert-menu alert {{ $table == 'formw' ? 'alert-info' : 'alert-warning' }} clickable" name="formw">
                                        <p class="mr-3 no-padding">Kesatuan Sekerja Dengan Badan Perundingan Luar Malaysia (Borang W)</p>
                                    </div>
                                    <div class="alert-menu alert {{ $table == 'ectr4u' ? 'alert-info' : 'alert-warning' }} clickable" name="ectr4u">
                                        <p class="mr-3 no-padding">Perakuan Cuti Tanpa Rekod Kesatuan Sekerja (eCTR4U)</p>
                                    </div>
                                    <div class="alert-menu alert {{ $table == 'formlu' ? 'alert-info' : 'alert-warning' }} clickable" name="formlu">
                                        <p class="mr-3 no-padding">Pendaftaran Perubahan Pegawai Kesatuan Sekerja (Borang LU)</p>
                                    </div>
                                    <div class="alert-menu alert {{ $table == 'forml' ? 'alert-info' : 'alert-warning' }} clickable" name="forml">
                                        <p class="mr-3 no-padding">Notis Perubahan Pegawai-Pegawai / Jawatan Pegawai-Pegawai Kesatuan Sekerja (Borang L)</p>
                                    </div>
                                    <div class="alert-menu alert {{ $table == 'forml1' ? 'alert-info' : 'alert-warning' }} clickable" name="forml1">
                                        <p class="mr-3 no-padding">Notis Perubahan Pekerja-Pekerja Kesatuan Sekerja (Borang L1)</p>
                                    </div>
                                    <div class="alert-menu alert {{ $table == 'formieu' ? 'alert-info' : 'alert-warning' }} clickable" name="formieu">
                                        <p class="mr-3 no-padding">Pembubaran Kesatuan Sekerja (Borang IEU)</p>
                                    </div>
                                    <div class="alert-menu alert {{ $table == 'formf' ? 'alert-info' : 'alert-warning' }} clickable" name="formf">
                                        <p class="mr-3 no-padding">Pembatalan Kesatuan Sekerja (Borang F)</p>
                                    </div>
                                    <div class="alert-menu alert {{ $table == 'eligibility_issue' ? 'alert-info' : 'alert-warning' }} clickable" name="eligibility_issue">
                                        <p class="mr-3 no-padding">Siasatan Isu Kelayakan Tuntutan Pengiktirafan</p>
                                    </div>
                                    @endif
                                    @if(auth()->user()->hasAnyRole(['admin','kpks','tkpks','pkpp']))
                                    <div class="alert-menu alert {{ $table == 'formg' ? 'alert-info' : 'alert-warning' }} clickable" name="formg">
                                        <p class="mr-3 no-padding">Pindaan Nama Kesatuan Sekerja (Borang G)</p>
                                    </div>
                                    <div class="alert-menu alert {{ $table == 'formj' ? 'alert-info' : 'alert-warning' }} clickable" name="formj">
                                        <p class="mr-3 no-padding">Perubahan Alamat Kesatuan Sekerja (Borang J)</p>
                                    </div>
                                    <div class="alert-menu alert {{ $table == 'formk' ? 'alert-info' : 'alert-warning' }} clickable" name="formk">
                                        <p class="mr-3 no-padding">Pindaan Peraturan / Pendaftaran Peraturan Baru (Borang K)</p>
                                    </div>
                                    <div class="alert-menu alert {{ $table == 'enforcement' ? 'alert-info' : 'alert-warning' }} clickable" name="enforcement">
                                        <p class="mr-3 no-padding">Pemeriksaan Berkanun</p>
                                    </div>
                                    <div class="alert-menu alert {{ $table == 'complaint_internal' ? 'alert-info' : 'alert-warning' }} clickable"  name="complaint_internal">
                                        <p class="mr-3 no-padding">Pengendalian Aduan</p>
                                    </div>
                                    <div class="alert-menu alert {{ $table == 'strike' ? 'alert-info' : 'alert-warning' }} clickable" name="strike">
                                        <p class="mr-3 no-padding">Pengendalian Mogok</p>
                                    </div>
                                    <div class="alert-menu alert {{ $table == 'lockout' ? 'alert-info' : 'alert-warning' }} clickable" name="lockout">
                                        <p class="mr-3 no-padding">Pengendalian Tutup Pintu</p>
                                    </div>
                                    <div class="alert-menu alert {{ $table == 'affidavit' ? 'alert-info' : 'alert-warning' }} clickable" name="affidavit">
                                        <p class="mr-3 no-padding">Penyediaan Laporan Permohonan Semakan Kehakiman / Affidavit Jawapan</p>
                                    </div>
                                    <div class="alert-menu alert {{ $table == 'fund' ? 'alert-info' : 'alert-warning' }} clickable" name="fund">
                                        <p class="mr-3 no-padding">Kutipan Dana Dan Wang Kesatuan Sekerja</p>
                                    </div>
                                    <div class="alert-menu alert {{ $table == 'insurance' ? 'alert-info' : 'alert-warning' }} clickable" name="insurance">
                                        <p class="mr-3 no-padding">Pembayaran Premium Insuran Kesatuan Sekerja</p>
                                    </div>
                                    <div class="alert-menu alert {{ $table == 'levy' ? 'alert-info' : 'alert-warning' }} clickable" name="levy">
                                        <p class="mr-3 no-padding">Pengenaan Levi</p>
                                    </div>
                                    <div class="alert-menu alert {{ $table == 'formjl1' ? 'alert-info' : 'alert-warning' }} clickable" name="formjl1">
                                        <p class="mr-3 no-padding">Penyata Kewangan (Juru Audit Luar)</p>
                                    </div>
                                    <div class="alert-menu alert {{ $table == 'formn' ? 'alert-info' : 'alert-warning' }} clickable" name="formn">
                                        <p class="mr-3 no-padding">Penyata Tahunan Kesatuan</p>
                                    </div>
                                    <div class="alert-menu alert {{ $table == 'prosecution' ? 'alert-info' : 'alert-warning' }} clickable" name="prosecution">
                                        <p class="mr-3 no-padding">Kertas Siasatan (Pendakwaan)</p>
                                    </div>
                                    <div class="alert-menu alert {{ $table == 'exception_pp30' ? 'alert-info' : 'alert-warning' }} clickable" name="exception_pp30">
                                        <p class="mr-3 no-padding">Pengecualian Seksyen 30(b), AKS 1959</p>
                                    </div>
                                    <div class="alert-menu alert {{ $table == 'exception_pp68' ? 'alert-info' : 'alert-warning' }} clickable" name="exception_pp68">
                                        <p class="mr-3 no-padding">Pengecualian Peraturan 68, AKS 1959</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
    					<div class="col-sm-8">
    						<div class="p-l-5">
    							<h4 class="pull-left m-t-5 m-b-5">Paparan <span class="bold">Graf</span></h4>
    							<div class="clearfix"></div>
    							<canvas id="myChart" width="400" height="300"></canvas>
    						</div>
    					</div>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
</div>
<!-- END CONTAINER FLUID -->
@endsection

@push('js')
<script type="text/javascript">

$(".alert-menu").on('click', function() {
	window.location.replace("{{ route('monitoring') }}?module="+$(this).attr('name'));
});

var ctx = document.getElementById("myChart").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [
            @foreach($results as $index => $result)
            <?php
                if($index > 4)
                    break;
            ?>
            "{{ $result->year }}",
            @endforeach
        ],
    	fill: 'start',
        datasets: [{
            label: '# Selesai',
            data: [
                @foreach($results as $index => $result)
                <?php
                    if($index > 4)
                        break;
                ?>
                {{ $result->completed }},
                @endforeach
            ],
            borderWidth: 1,
            backgroundColor: 'rgba(19,149,186,0.5)'
        },{
            label: '# Dalam Proses',
            data: [
                @foreach($results as $index => $result)
                <?php
                    if($index > 4)
                        break;
                ?>
                {{ $result->pending }},
                @endforeach
            ],
            borderWidth: 1,
            backgroundColor: 'rgba(241,108,32,.5)'
        }]
    },
    options: {
        tooltips: {
            mode: 'label',
            callbacks: {
                label: function(tooltipItem, data) {
                    var corporation = data.datasets[tooltipItem.datasetIndex].label;
                    var valor = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];

                    // Loop through all datasets to get the actual total of the index
                    var total = 0;
                    for (var i = 0; i < data.datasets.length; i++)
                        total += data.datasets[i].data[tooltipItem.index];

                    // If it is not the last dataset, you display it as you usually do
                    if (tooltipItem.datasetIndex != data.datasets.length - 1) {
                        return corporation + " : " + valor;
                    } else { // .. else, you display the dataset and the total, using an array
                        return [corporation + " : " + valor, "# Jumlah : " + total];
                    }
                }
            }
        },
        scales: {
            xAxes: [{
                stacked: true,
            }],
            yAxes: [{
                ticks: {
                    beginAtZero:true
                },
                stacked: true,
            }]
        }
    }
});

$(".type-list").scrollbar();
</script>
@endpush
