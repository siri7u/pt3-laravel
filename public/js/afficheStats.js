function afficheStats() {

    data = [];
    var labels = new Array(100);

    function renderChart(data, labels, name) {
        var ctx = document.getElementById(name).getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{

                    data: data,
                }]
            },
            label: "alt",
        });
        Chart.defaults.global.legend.display = false;
        Chart.defaults.global.tooltips.enabled = false;
    }

    //ordonnée, abscisse, et l'id de la div dans laquelle mettre le graph
    renderChart(eles, labels, "chart1");
    renderChart(eles, labels, "chart2");
    renderChart(eles, labels, "chart3");

}