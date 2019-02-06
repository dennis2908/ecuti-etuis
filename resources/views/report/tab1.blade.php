<!-- START CONTAINER FLUID -->
<div class=" container-fluid container-fixed-lg bg-white p-t-15 p-b-15">
    <!-- START card -->
    <div class="card card-transparent">
        <div class="card-block">
        	<div class="row">
        		<div class="col-md-12 m-b-20">
        			<canvas id="myChart" width="400" height="200"></canvas>
        		</div>
                <div class="col-md-6 m-b-20">
                    <canvas id="myChart2" width="400" height="200"></canvas>
                </div>
                <div class="col-md-6 m-b-20">
                    <canvas id="myChart3" width="400" height="200"></canvas>
                </div>
                <div class="col-md-6 m-b-20">
                    <canvas id="myChart4" width="400" height="200"></canvas>
                </div>
                <div class="col-md-6 m-b-20">
                    <canvas id="myChart5" width="400" height="200"></canvas>
                </div>
        	</div>
        </div>
    </div>
    <!-- END card -->
</div>
<!-- END CONTAINER FLUID -->

@push('js')
<script type="text/javascript">
var ctx = document.getElementById("myChart").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [
            @foreach( $months as $index => $month )
                "{{ $month }}",
            @endforeach
        ],
        datasets: [
            {
                label: 'Sektor A',
                data: [
                    @foreach( $months as $index => $month )
                        {{ rand(1,50) }},
                    @endforeach
                ],
                backgroundColor: 'rgba(19,149,186,0.5)',
                borderWidth: 1
            },
            {
                label: 'Sektor B',
                data: [
                    @foreach( $months as $index => $month )
                        {{ rand(1,50) }},
                    @endforeach
                ],
                backgroundColor: 'rgba(255,205,86,0.5)',
                borderWidth: 1
            }

        ]
    },
    options: {
        title: {
            display: true,
            text: 'Bilangan Kesatuan Sekerja Mengikut Sektor',
            fontSize: 16,
        },
        legend: {
            display: false,
            labels: {
                fontColor: 'rgb(255, 99, 132)'
            }
        },
        scales: {
            yAxes: [{
                scaleLabel: {
                    display: false,
                    labelString: 'Jumlah',
                },
                ticks: {
                    beginAtZero:true,
                    autoSkip: false
                }
            }],
            xAxes: [{
                stacked: false,
                beginAtZero: true,
                scaleLabel: {
                    display: true,
                    labelString: 'Bulan',
                },
                ticks: {
                    stepSize: 1,
                    min: 0,
                    autoSkip: false,
                }
            }]
        }
    }
});
</script>
@endpush

@push('js')
<script type="text/javascript">
var ctx2 = document.getElementById("myChart2").getContext('2d');
var myChart2 = new Chart(ctx2, {
    type: 'line',
    data: {
        labels: ["2013", "2014", "2015", "2016", "2017", "2018"],
        fill: 'start',
        datasets: [{
            label: '# of Pengguna Luar',
            data: [8, 12, 3, 5, 2, 3],
            borderWidth: 1,
            backgroundColor: 'rgba(19,149,186,0.5)'
        },{
            label: '# of Pengguna Dalam',
            data: [5, 7, 6, 4, 5, 2],
            borderWidth: 1,
            backgroundColor: 'rgba(241,108,32,.5)'
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>
@endpush

@push('js')
<script type="text/javascript">
var randomScalingFactor = function() {
    return Math.round(Math.random() * 100);
};

var ctx3 = document.getElementById("myChart3").getContext('2d');
var myChart3 = new Chart(ctx3, {
    type: 'pie',
    data: {
        datasets: [{
            data: [
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
            ],
            backgroundColor: [
                'rgba(19,149,186,0.5)',
                'rgba(241,108,32,0.5)',
                'rgba(255,99,132,0.5)',
                'rgba(255,205,86,0.5)',
                'rgba(75,192,192,0.5)',
            ],
            label: 'Dataset 1'
        }],
        labels: [
            'Jenis 1',
            'Jenis 2',
            'Jenis 3',
            'Jenis 4',
            'Jenis 5'
        ]
    },
    options: {
        responsive: true
    }
});
</script>
@endpush

@push('js')
<script type="text/javascript">
var ctx4 = document.getElementById("myChart4").getContext('2d');
var myChart4 = new Chart(ctx4, {
    type: 'doughnut',
    data: {
        datasets: [{
            data: [
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
            ],
            backgroundColor: [
                'rgba(19,149,186,0.5)',
                'rgba(241,108,32,0.5)',
                'rgba(255,99,132,0.5)',
                'rgba(255,205,86,0.5)',
                'rgba(75,192,192,0.5)',
            ],
            label: 'Dataset 1'
        }],
        labels: [
            'Jenis 1',
            'Jenis 2',
            'Jenis 3',
            'Jenis 4',
            'Jenis 5'
        ]
    },
    options: {
        responsive: true,
        animation: {
            animateScale: true,
            animateRotate: true
        }
    }
});
</script>
@endpush

@push('js')
<script type="text/javascript">
var ctx5 = document.getElementById("myChart5").getContext('2d');
var myChart5 = new Chart(ctx5, {
    type: 'line',
    data: {
        labels: ["2013", "2014", "2015", "2016", "2017", "2018"],
        datasets: [{
            label: '# of Pengguna Luar',
            data: [8, 12, 3, 5, 2, 3],
            fill: 'false',
            borderColor: 'rgba(19,149,186,0.5)'
        },{
            label: '# of Pengguna Dalam',
            data: [5, 7, 6, 4, 5, 2],
            fill: 'false',
            borderColor: 'rgba(241,108,32,.5)'
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>
@endpush