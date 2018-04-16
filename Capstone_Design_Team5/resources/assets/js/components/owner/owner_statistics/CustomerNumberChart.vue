<!-- 
※ 방문 손님수를 그리는 차트

-->
<script>
import { Line } from 'vue-chartjs'

export default {
  extends: Line,
  mounted () {
    // Overwriting base render method with actual data.
    this.renderChart({
      labels: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
      datasets: [
        {
          label: '작년 손님수',
          backgroundColor: '#3399FF',
          data: [130, 160, 120, 150, 110, 180, 239, 200, 340, 320, 312, 350]
        },
        {
          label: '올해 손님수',
          backgroundColor: '#FF6666',
          data: [230, 260, 320, 300, 310, 280, 339, 400, 440, 520, 512, 550]
        }
      ]
    })
  }
}
</script>