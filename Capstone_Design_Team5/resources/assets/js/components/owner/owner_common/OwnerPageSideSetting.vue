<template>
    <!-- Setting Main 
        04.13.04:08 작업
        사이드 네비게이션과 라우터 네비게이션 비율 퍼센트로 맞춤. 
        설정 - 사이드 네비게이션에서 안쓰는 li 삭제 : 전자 메뉴판 관리, 홈페이지 디자인 삭제함.
    -->
  <div>
    <div id="sidebar_wrapper">
        <ul class="sidebar_nav">
            <li class="sidebar_brand"><B>MY Restaurant</B></li>
            <li @click="myhome()"><span style="color: grey; cursor:pointer">내 페이지</span></li>
            <li class="sidebar_brand"><B>가게 관리</B></li>
            <li><router-link to="editRestaurant">가게 정보</router-link></li>
            <li><router-link to="createCoupon">쿠폰</router-link></li>
            <li class="sidebar_brand"><B>메뉴 관리</B></li> 
            <li><router-link to="menu">전자 메뉴판</router-link></li>
        </ul>
    </div>
    <div id="router_view">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
export default {
  methods: {
    myhome() {
      var link = '/restaurant/' + this.$route.params.shop_id + '/info';
      location.replace(link);
    }
  }
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
