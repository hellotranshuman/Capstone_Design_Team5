<!-- 
※ 메뉴 순위를 그리는 차트

-->
<script>
import { Bar } from 'vue-chartjs';

export default {
  extends: Bar,
  mounted () {
    // Overwriting base render method with actual data.
    this.renderChart({
      labels: ['카라아게', '돈카츠', '카레', '우동', '규동'],
      datasets: [
        {
          label: '메뉴 순위',
          backgroundColor: ['#3399FF', '#FF3300', '#CCFF00', '#00CC33', '#CCCC00'],
        //   borderColor: ['#0099FF'],
        //   fill: true,
          // borderWidth: 1,
          data: [560, 380, 366, 230, 222]
        },
      ]
    })
  }
}
</script>