<!-- ※ 방문 평점을 그리는 차트 -->
<script>
import { Radar, mixins } from 'vue-chartjs';
const  { reactiveProp } = mixins

export default {
  extends : Radar,
  mixins  : [reactiveProp ],
  props   : ['chartData', 'options'],
  mounted () {
    this.renderChart(this.chartData, this.options)
  },
}
</script>