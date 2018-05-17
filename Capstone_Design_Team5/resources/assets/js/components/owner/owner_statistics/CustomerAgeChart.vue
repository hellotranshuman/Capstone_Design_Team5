<!-- 
※ 방문 손님 연령대를 그리는 차트

-->
<script>
import { Doughnut, mixins } from 'vue-chartjs'
const  { reactiveProp } = mixins

export default {
  extends: Doughnut,
  mixins : [reactiveProp ],
  props: ['options'],
  mounted () {
    // this.chartData is created in the mixin.
    // If you want to pass options please create a local options object
    this.renderChart(this.chartData, this.options)
  },
}
</script>