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
var myChart{{ $indYear }} = new Chart(ctx{{ $indYear }}, {
    type: 'horizontalBar',
    data: {
        labels: [
            @foreach($industries as $indIndustry => $industry)
                "{{ $industry }}",
            @endforeach
        ],
        datasets: [
            {
                label: 'Keanggotaan',
                data: [
                    @foreach($industries as $indIndustry => $industry)
                        <?php
                            $report = (clone $view_report)->where('year', $year)->where('industry', $indIndustry + 1);
                        ?>
                        {{ $report->sum('membership') }},
                    @endforeach
                ],
                backgroundColor: 'rgba(255,205,86,0.5)',
                borderWidth: 1,
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
                    labelString: 'Industri',
                },
                ticks: {
                    stepSize: 1,
                    min: 0,
                    autoSkip: false
                }
            }],
            xAxes: [{
                stacked: false,
                beginAtZero: true,
                scaleLabel: {
                    display: false,
                    labelString: 'Jumlah',
                },
                ticks: {
                    beginAtZero: true,
                    autoSkip: false
                }
            }]
        }
    }
});
@endforeach
</script>
