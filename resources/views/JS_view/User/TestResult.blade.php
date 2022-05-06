<script type="text/javascript">
    const totalResult = {!! json_encode($data['result']['Total']) ?? [] !!};

    window.onload = function() {
        init();
    };

    function init() {
        randerPieChart();
    }
    
    function randerPieChart() {
        const failCount = totalResult['errorCount'];
        const successCount = totalResult['sampleCount']-totalResult['errorCount'];
        const ctx = document.querySelector('#Canvas_success_rate');
        const data = {
            labels: ["失敗", "成功"],
            datasets: [{
                label: '成功率',
                data: [failCount, successCount],
                backgroundColor: ['rgb(255, 99, 71)', 'rgb(154, 205, 50)'],
                datalabels: {
                    anchor: 'center'
                }
            }]
        };
        const config = {
            type: 'pie',
            data: data,
            options: {
                plugins: {
                    datalabels: {
                        backgroundColor: function(context) {
                            return context.dataset.backgroundColor;
                        },
                        borderColor: 'white',
                        borderRadius: 25,
                        borderWidth: 2,
                        color: 'white',
                        display: function(context) {
                            const dataset = context.dataset;
                            const count = dataset.data.length;
                            const value = dataset.data[context.dataIndex];
                            return value > count * 1.5;
                        },
                        font: {
                            weight: 'bold'
                        },
                        padding: 6,
                        formatter: Math.round
                    }
                },
            }
        };
        const successRateChart = new Chart(ctx, config);
    }

</script>
