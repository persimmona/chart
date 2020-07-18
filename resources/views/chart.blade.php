<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Charts</title>

        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3"></script>

        <!-- Styles -->
        <style>
            .chart-container{
                display: flex;
                flex-direction: column;
                align-items: center;

            }
            .wrapper{
                width:50vw;
                padding-bottom: 20px;
            }
        </style>
    </head>
    <body>
    <div class="chart-container" style="">
        <div class="wrapper"><canvas id="lvr"></canvas></div>
        <div class="wrapper"><canvas id="lcr"></canvas></div>
        <div class="wrapper"><canvas id="churnRate"></canvas></div>
    </div>

    <script>
        let options = {
            elements: {
                line: {
                    tension: 0.000001
                }
            },
            hover: {
                mode: 'nearest',
                intersect: true
            },
            tooltips: {
                mode: 'index',
                intersect: false,
            },
            legend: {
                display: false,
            }
        };

        let lvr = document.getElementById('lvr').getContext('2d');
        let chartLvr = new Chart(lvr, {
            type: 'line',
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: [{
                    backgroundColor: '#8C77FE',
                    borderColor: '#8C77FE',
                    data: {!! json_encode($lvr) !!},
                    fill: false,
                }]
            },
            options: Chart.helpers.merge(options, {
                title: {
                    text: 'Lead Velocity Rate',
                    display: true
                }
            })
        });

        let lcr = document.getElementById('lcr').getContext('2d');
        let chartLcr = new Chart(lcr, {
            type: 'line',
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: [{
                    backgroundColor: '#8C77FE',
                    borderColor: '#8C77FE',
                    data: {!! json_encode($lcr) !!},
                    fill: false,
                }]
            },
            options: Chart.helpers.merge(options, {
                title: {
                    text: 'Lead Conversion Rate',
                    display: true
                }
            })
        });

        let churnRate = document.getElementById('churnRate').getContext('2d');
        let chartChurnRate = new Chart(churnRate, {
            type: 'line',
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: [{
                    backgroundColor: '#8C77FE',
                    borderColor: '#8C77FE',
                    data: {!! json_encode($churnRate) !!},
                    fill: false,
                }]
            },
            options: Chart.helpers.merge(options, {
                title: {
                    text: 'Churn Rate',
                    display: true
                }
            })
        });
    </script>
    </body>
</html>
