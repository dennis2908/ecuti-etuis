<?php
$bg = array(
    'rgba(10,79,99,0.5)',
    'rgba(241,108,32,0.5)',
    'rgba(255,99,132,0.5)',
    'rgba(255,205,86,0.5)'
);
?>
<!-- START CONTAINER FLUID -->
<div class=" container-fluid container-fixed-lg bg-white p-t-15 p-b-15">
    <!-- START card -->
    <div class="card card-transparent">
        <div class="card-block">
        	<div class="row">
                @foreach($categories as $index => $category)
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
@foreach($categories as $indCategory => $category)
var ctx{{ $indCategory}} = document.getElementById("myChart{{ $indCategory}}").getContext('2d');
var ctx{{ $indCategory}}2 = document.getElementById("myChart{{ $indCategory}}2").getContext('2d');

var myChart{{ $indCategory}} = new Chart(ctx{{ $indCategory}}, {
    type: 'line',
    data: {
        labels: [
            @foreach(range($start_year, $end_year) as $index => $year)
                "{{ $year }}",
            @endforeach
        ],
        datasets: [
            {
                label: 'Kesatuan Sekerja',
                data: [
                    @foreach(range($start_year, $end_year) as $index => $year)
                        <?php
                            $report = (clone $view_report)->where('year', $year)->where('category', $indCategory + 4);
                        ?>
                        {{ $report->sum('unions') }},
                    @endforeach
                ],
                fill: 'false',
                backgroundColor: 'rgba(19,149,186,0.5)',
                borderColor: 'rgba(19,149,186,0.5)',
                borderWidth: 2
            }
        ]
    },
    options: {
        title: {
            display: true,
            text: '{{ $name }}: {{ $category }}',
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
                    beginAtZero:true,
                    autoSkip: false
                }
            }],
            xAxes: [{
                stacked: false,
                beginAtZero: true,
                scaleLabel: {
                    display: true,
                    labelString: 'Tahun',
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

var myChart{{ $indCategory}}2 = new Chart(ctx{{ $indCategory}}2, {
    type: 'line',
    data: {
        labels: [
            @foreach(range($start_year, $end_year) as $index => $year)
                "{{ $year }}",
            @endforeach
        ],
        datasets: [
            {
                label: 'Keanggotaan',
                data: [
                    @foreach(range($start_year, $end_year) as $index => $year)
                        <?php
                            $report = (clone $view_report)->where('year', $year)->where('category', $indCategory + 4);
                        ?>
                        {{ $report->sum('membership') }},
                    @endforeach
                ],
                fill: 'false',
                backgroundColor: 'rgba(255,205,86,0.5)',
                borderColor: 'rgba(255,205,86,0.5)',
                borderWidth: 2
            }

        ]
    },
    options: {
        title: {
            display: false,
            text: '{{ $name }}: {{ $category }}',
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
                    beginAtZero:true,
                    autoSkip: false
                }
            }],
            xAxes: [{
                stacked: false,
                beginAtZero: true,
                scaleLabel: {
                    display: true,
                    labelString: 'Tahun',
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
