<!-- START CONTAINER FLUID -->
<div class=" container-fluid container-fixed-lg bg-white p-t-15 p-b-15">
    <!-- START card -->
    <div class="card card-transparent">
        <div class="card-block">
        	<div class="row">
                @foreach(range($start_year, $end_year) as $index => $graph)
                <div class="col-md-12 m-b-20">
        			<canvas id="myChart{{ $index }}" width="400" height="200"></canvas>
        		</div>
                <div class="col-md-12 m-b-20">
        			<canvas id="myChart{{ $index }}2" width="400" height="200"></canvas>
        		</div>
                @endforeach
        	</div>
        </div>
    </div>
    <!-- END card -->
</div>
<!-- END CONTAINER FLUID -->

<script type="text/javascript">
@foreach(range($start_year, $end_year) as $indYear => $year)
var ctx{{ $indYear }} = document.getElementById("myChart{{ $indYear }}").getContext('2d');
var ctx{{ $indYear }}2 = document.getElementById("myChart{{ $indYear }}2").getContext('2d');

var myChart{{ $indYear }} = new Chart(ctx{{ $indYear }}, {
    type: 'line',
    data: {
        labels: [
            @foreach($states as $indState => $state)
                "{{ $state }}",
            @endforeach
        ],
        datasets: [
            {
                label: 'Kesatuan Sekerja',
                data: [
                    @foreach($states as $indState => $state)
                        <?php
                            $report = (clone $view_report)->where('year', $year)->where('state', $indState + 1);
                        ?>
                        {{ $report->sum('unions') }},
                    @endforeach
                ],
                fill: 'false',
                backgroundColor: 'rgba(19,149,186,0.5)',
                borderColor: 'rgba(19,149,186,0.5)',
                borderWidth: 2,
            }
        ]
    },
    options: {
        title: {
            display: true,
            text: '{{ $name }}: {{ $year }}',
            fontSize: 16,
        },
        legend: {
            display: true,
        },
        scales: {
            yAxes: [{
                scaleLabel: {
                    display: false,
                    labelString: 'Jumlah',
                },
                ticks: {
                    beginAtZero: true,
                    autoSkip: false
                }
            }],
            xAxes: [{
                stacked: false,
                beginAtZero: true,
                scaleLabel: {
                    display: false,
                    labelString: 'Negeri',
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

var myChart{{ $indYear }}2 = new Chart(ctx{{ $indYear }}2, {
    type: 'line',
    data: {
        labels: [
            @foreach($states as $indState => $state)
                "{{ $state }}",
            @endforeach
        ],
        datasets: [
            {
                label: 'Keanggotaan',
                data: [
                    @foreach($states as $indState => $state)
                        <?php
                            $report = (clone $view_report)->where('year', $year)->where('state', $indState + 1);
                        ?>
                        {{ $report->sum('membership') }},
                    @endforeach
                ],
                fill: 'false',
                backgroundColor: 'rgba(255,205,86,0.5)',
                borderColor: 'rgba(255,205,86,0.5)',
                borderWidth: 2,
            }
        ]
    },
    options: {
        title: {
            display: false,
            text: '{{ $name }}: {{ $year }}',
            fontSize: 16,
        },
        legend: {
            display: true,
        },
        scales: {
            yAxes: [{
                scaleLabel: {
                    display: false,
                    labelString: 'Jumlah',
                },
                ticks: {
                    beginAtZero: true,
                    autoSkip: false
                }
            }],
            xAxes: [{
                stacked: false,
                beginAtZero: true,
                scaleLabel: {
                    display: false,
                    labelString: 'Negeri',
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
@endforeach
</script>
