<!-- 
사장님 통계페이지 사이드바        
-->
<template>
  <div>
    <div id="sidebar_wrapper">
        <ul class="sidebar_nav">
            <li class="sidebar_brand"><B>통계</B></li>
            <li class="sidebar_brand"><B>종합 통계</B></li>
            <li><router-link to="OwnerTotalStatistics">종합 통계</router-link></li>
            <li><router-link to="">손님 통계</router-link></li>
            <li><router-link to="">매출 통계</router-link></li>
            <li><router-link to="">메뉴 통계</router-link></li>
        </ul>
    </div>
    <div id="router_view">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
export default {

}
</script>

<style>
    /* 폰트 컬러 */
  .fontColor_red {
    color: red;
  }
  .fontColor_white {
    color: white;
  }

  /* 사이드바 */
  #sidebar_wrapper {
    width: 20%; 
    height: 100vh;
    float: left; 
    background: #000;
    display: table-column;
  }

  #page-content_wrapper {
    width: 100%;
  }

  #router_view {
    width:80%;  
    float: left; 
    position:relative; 
    display: table-column;
  }

  /* 사이드바 스타일 */
  .sidebar_nav {
    width: 100%;
    margin: 0;
    padding: 0;
    list-style: none;
    margin-bottom: 10%;
  }

  .sidebar_nav li {
    text-indent: 1.5em;
    line-height: 2.8em;
  }

  .sidebar_nav li a {
    display: block;
    text-decoration: none;
    color: #999;
  }

  .sidebar_nav li a:hover {
    color: #fff;
    background: rgba(255, 255, 255, 0.2);
  }

  .sidebar_nav > .sidebar_brand {
    font-size: 1.3em;
    color: white;

    line-height: 3em;
  }

</style>
