<?php
$bg = array(
    'rgba(19,149,186,0.5)',
    'rgba(255,205,86,0.5)',
    'rgba(255,99,132,0.5)'
);
?>
<!-- START CONTAINER FLUID -->
<div class=" container-fluid container-fixed-lg bg-white p-t-15 p-b-15">
    <!-- START card -->
    <div class="card card-transparent">
        <div class="card-block">
        	<div class="row">
        		<div class="col-md-12 m-b-20">
        			<canvas id="myChart" width="400" height="200"></canvas>
        		</div>
        	</div>
        </div>
    </div>
    <!-- END card -->
</div>
<!-- END CONTAINER FLUID -->

<script type="text/javascript">
var ctx = document.getElementById("myChart").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [
            @foreach(range($start_year, $end_year) as $index => $year)
                "{{ $year }}",
            @endforeach
        ],
        datasets: [
            @foreach($locations as $ind => $location)
            {
                label: '{{ $location }}',
                data: [
                    @foreach(range($start_year, $end_year) as $index => $year)
                        <?php
                            $report = (clone $view_report)->where('year', $year)->where('location', $ind);
                        ?>
                        {{ $report->sum('unions') }},
                    @endforeach
                ],
                backgroundColor: '{{ $bg[$ind] }}',
                borderWidth: 1,
            },
            @endforeach
        ]
    },
    options: {
        title: {
            display: true,
            text: '{{ $name }}',
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
</script>
