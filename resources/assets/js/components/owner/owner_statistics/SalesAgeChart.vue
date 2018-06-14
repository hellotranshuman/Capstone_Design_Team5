<!-- ※ 매출 연령대를 그리는 차트 -->
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