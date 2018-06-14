<!-- ※ 매출에서 성비를 그리는 그래프 -->
<script>
import { Pie, mixins } from 'vue-chartjs'
const  { reactiveProp } = mixins

export default {
  extends : Pie,
  mixins  : [reactiveProp ],
  props   : ['chartData', 'options'],
  mounted () {
    this.renderChart(this.chartData, this.options)
  },
}
</script>