<template>
    <div class="header">
        <div class="title">
          <h1 class="fontColor_white"><B class="fontColor_red"> SMART</B> sasisuseso </h1>
        </div>
        <!-- 메인 바 -->
        <div id="main_bar">
          <b-navbar class="navbar_nav" type="dark" toggleable>
              <b-navbar-toggle target="nav_dropdown_collapse"></b-navbar-toggle>
              <b-collapse is-nav id="nav_dropdown_collapse">
                <b-navbar-nav>
                  <b-nav-item><router-link to="/ownerPage/ownerPageSideSetting" class="fontColor_white"><B>설정</B></router-link></b-nav-item>
                  <b-nav-item><router-link to="/ownerPage/ownerPageSideReservation" class="fontColor_white"><B>예약</B></router-link></b-nav-item>
                  <b-nav-item><router-link to="/" class="fontColor_white"><B>통계</B></router-link></b-nav-item>
                </b-navbar-nav>
              </b-collapse>
            </b-navbar>
        </div>

    </div>
</template>

<script>
    export default {

    }

</script>

<style>
  .header {
    background-color: #353535;
  }
    .title {
      margin-left: 4%;
      padding-top: 1%;
    }
    #main_bar {
      font-size: 20px;
    }



  /* 폰트 컬러 */
  .fontColor_red {
    color: red;
  }
  .fontColor_white {
    color: white;
  }

  /* 상단 nav */
  .navbar_nav {
    padding-left: 30px;
  }

</style>