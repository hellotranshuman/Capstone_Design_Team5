<template>
  <!-- Reservation Main -->
  <div>
    <div id="sidebar_wrapper">
        <ul class="sidebar_nav">
            <li class="sidebar_brand"><B>예약</B></li>
            <li class="sidebar_brand"><B>예약 관리</B></li>
            <li><router-link to="/ownerPage/ownerReservationlist">예약 현황</router-link></li>
            <li><router-link to="/ownerPage/ownerReservationAccept">예약 수락</router-link></li>
            <li><router-link to="/ownerPage/ownerReservationSetting">예약 설정</router-link></li>
        </ul>
    </div>
    <div>
      <router-view  to="/ownerReservationlist"></router-view>
    </div>
  </div>
</template>

<script>

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
    width: 200px;
    height: 600px; 
    float: left;

    background: #000;
  }

  #page-content_wrapper {
    width: 100%;
  }

    /* 사이드바 스타일 */
  .sidebar_nav {
    width: 250px;
    margin: 0;
    padding: 0;
    list-style: none;
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
