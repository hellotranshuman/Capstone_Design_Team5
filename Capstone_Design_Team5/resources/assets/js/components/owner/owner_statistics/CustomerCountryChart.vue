<!-- ※ 방문 손님 국적을 그리는 차트 -->
<script>
import { Doughnut, mixins } from 'vue-chartjs'
const  { reactiveProp } = mixins

export default {
  extends : Doughnut,
  mixins  : [reactiveProp ],
  props   : ['chartData', 'options'],
  mounted () {
    this.renderChart(this.chartData, this.options)
  },
}
</script>