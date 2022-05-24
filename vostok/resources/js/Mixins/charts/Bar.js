import { Bar } from 'vue-chartjs'
import randomColor from 'randomcolor'



export default {
    extends: Bar,
    data: function() {
        return {
            options: {
                scales: {
                    yAxes: [
                        {
                            ticks: {
                                beginAtZero: true
                            },
                            gridLines: {
                                display: false
                            }
                        }
                    ],
                    xAxes: [
                        {
                            ticks: {
                                beginAtZero: true
                            },
                            gridLines: {
                                display: false
                            }
                        }
                    ]
                },
                legend: {
                    display: true,
                    position: 'bottom'
                },
                tooltips: {
                    enabled: true,
                    mode: 'single',
                    callbacks: {
                        label: function(tooltipItems, data) {
                            return tooltipItems.yLabel
                        }
                    }
                },
                responsive: true,
                maintainAspectRatio: false,
                height: 150
            }
        }
    },
    props: {
        labels: {
            type: Array,
            required: true
        },
        data: {
            type: Array,
            required: true
        }
    },
    mounted() {
        // this.chartData is created in the mixin
        const colors = []
        for(let i = 0; i <= this.data.length; i++) {
          colors.push(randomColor())
        }
        this.renderChart(
            {
                labels: this.labels,
                datasets: [
                    {
                        label: '',
                        pointBackgroundColor: 'white',
                        borderWidth: 1,
                        pointBorderColor: '#249EBF',
                        data: this.data,
                        backgroundColor: colors,
                    }
                ]
            },
            this.options
        )
    }
}
