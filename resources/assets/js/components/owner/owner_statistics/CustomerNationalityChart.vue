<!-- 
※ 방문 손님 국적을 그리는 차트

-->
<script>
import { Doughnut } from 'vue-chartjs'

export default {
  extends: Doughnut,
  mounted () {
    // Overwriting base render method with actual data.
    this.renderChart({
      labels: ['한국', '중국', '대만', '홍콩', '미국', '호주', '영국', '프랑스', '그외'],
      datasets: [
        {
          label: '방문 손님 국적',
          backgroundColor: ['#3399FF', '#FF3300', '#CCFF00', '#00CC33', '#CCCC00','#990066', '#663300','#FF6666', '#66FFFF'],
          data: [34, 34, 7, 7, 3, 3, 2, 2, 8]
        },
        // {
        //   label: '올해 손님 성비',
        //   backgroundColor: ['#6699FF','#f87979'],
        //   data: [55,45]
        // }
      ]
    })
  }
}
</script>