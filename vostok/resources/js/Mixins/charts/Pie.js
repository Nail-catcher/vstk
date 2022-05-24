import { Pie } from 'vue-chartjs'
import randomColor from 'randomcolor'
export default {
  extends: Pie,
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
    const labels = []
    const colors = ["#d45555", "#ffa500", "#008000"]
    this.labels.forEach((label, index) => {
      labels.push(`${label}(${this.data[index]})`)
      colors.push(randomColor())
    })
    this.renderChart(
      {
        labels,
        datasets: [
          {
            label: '# of Votes',
            data: this.data,
            backgroundColor: colors
          }
        ]
      },
      {
        responsive: true,
        legend: {
          display: true,
          position: 'bottom'
        }
      }
    )
  }
}
