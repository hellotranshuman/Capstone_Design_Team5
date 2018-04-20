<!-- 
※ 메뉴 순위를 그리는 차트

-->
<script>
import { Bar } from 'vue-chartjs';

export default {
  extends: Bar,
  mounted () {
    this.firstBar = this.$refs.canvas.getContext('2d').createLinearGradient(0, 0, 0, 450);
    this.secondBar = this.$refs.canvas.getContext('2d').createLinearGradient(0, 0, 0, 450);
    this.thirdBar = this.$refs.canvas.getContext('2d').createLinearGradient(0, 0, 0, 450);
    this.fourthBar = this.$refs.canvas.getContext('2d').createLinearGradient(0, 0, 0, 450);
    this.fifthBar  = this.$refs.canvas.getContext('2d').createLinearGradient(0, 0, 0, 450);

    this.firstBar.addColorStop(0, 'rgba(255, 0,0, 0.9)');
    this.firstBar.addColorStop(0.5, 'rgba(255, 0, 0, 0.7)');
    this.firstBar.addColorStop(1, 'rgba(255, 0, 0, 0.3)');
    
    this.secondBar.addColorStop(0, 'rgba(000, 051, 255, 0.9)')
    this.secondBar.addColorStop(0.5, 'rgba(000, 051, 255, 0.7)');
    this.secondBar.addColorStop(1, 'rgba(000, 051, 255, 0.3)');

    this.thirdBar.addColorStop(0, 'rgba(000, 153, 102, 0.9)')
    this.thirdBar.addColorStop(0.5, 'rgba(000, 153, 102, 0.7)');
    this.thirdBar.addColorStop(1, 'rgba(000, 153, 102, 0.3)');

    this.fourthBar.addColorStop(0, 'rgba(102, 000, 204, 0.9)')
    this.fourthBar.addColorStop(0.5, 'rgba(102, 000, 204, 0.7)');
    this.fourthBar.addColorStop(1, 'rgba(102, 000, 204, 0.3)');

    this.fifthBar.addColorStop(0, 'rgba(255, 102, 000, 0.9)')
    this.fifthBar.addColorStop(0.5, 'rgba(255, 102, 000, 0.7)');
    this.fifthBar.addColorStop(1, 'rgba(255, 102, 000, 0.3)');

    // Overwriting base render method with actual data.
    this.renderChart({
      labels: ['남방 치킨', '토종닭 숯불 구이', '믹스 후라이', 
      '돼지 갈비', '어린이 세트'],
      datasets: [
        {
          label: '메뉴 순위',
          backgroundColor: [this.firstBar, this.secondBar, this.thirdBar, this.fourthBar, this.fifthBar],
          hoverBackgroundColor:['rgba(255,051,051,0.8)','rgba(000,102,255,0.8)','rgba(051,204,153,0.8)',
          'rgba(102,000,153,0.8)','rgba(255,051,000,0.8)'],
        //   fill: true,
          // borderWidth: 1,
          data: [560, 380, 366, 230, 222]
        },
      ]
    })
  }
}
</script>