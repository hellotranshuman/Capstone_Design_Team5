<!-- 
사장님 통계페이지 사이드바        
-->
<template>
  <v-content>
    <v-layout>
      <v-flex xl2 lg2 md4 xs3 class="sideBarList">
        <v-list>
          <template v-for="(sidebarItem, index) in sideBarList">
            <v-subheader v-if="index == 0" :key="index" id="sideBar-title-name-outer">
              <span id="sideBar-title-name">
                <hr class="sideBar-hr-line">
                {{listHeader}}
                <hr class="sideBar-hr-line">
              </span>
            </v-subheader>
            <v-subheader v-if="sidebarItem['listHeaderTitle'] != null" :key="index + '_setting'">
              <span id="sideBar-name">{{sidebarItem['listHeaderTitle']}}</span>
            </v-subheader>
            <v-list-tile avatar :key="sidebarItem['name']" :to="sidebarItem['url']" active-class="orange--text">
              <v-container>
                <v-list-tile-title v-html="sidebarItem['name']" class="sideBarList-font"></v-list-tile-title>
              </v-container>
            </v-list-tile>             
          </template>
        </v-list>
      </v-flex>
      <v-flex xl10 lg10 md8 xs9 id="router-view-outer">
        <v-container id="router-view-inner">
          <router-view></router-view>
        </v-container>
      </v-flex>
    </v-layout>
  </v-content>
</template>

<!-- <div id="sidebar_wrapper">
            <ul class="sidebar_nav">
                <li class="sidebar_brand"><B>설정</B></li>
               a <li><router-link :to="'/restaurant/' + $route.params.shop_id + '/info'">내 가게 페이지</router-link></li>

                <li class="sidebar_brand"><B>가게 관리</B></li>
            a    <li><router-link to="editRestaurant">가게 정보</router-link></li>
              a  <li><router-link to="createCoupon">쿠폰</router-link></li>

                <li class="sidebar_brand"><B>전자 메뉴판</B></li>
            a    <li><router-link to="menuOperate">메뉴 추가</router-link></li>
             a   <li><router-link to="menuList">메뉴 관리</router-link></li>
             a   <li><router-link to="menuLayout">레이아웃 설정</router-link></li>
            </ul>
        </div> -->


<script>
export default {
  data() {
    return {
        shop_id     : this.$route.params.shop_id,  // 식당 아이디를 저장하는 변수,
        sideBarList : [
            {name : '내 가게 페이지', url : '/restaurant/' + this.$route.params.shop_id + '/info', listHeaderTitle : '설정'},
            {name : '가게 정보', url : 'editRestaurant', listHeaderTitle : '가게 관리'},  // 사이드바 목록
            {name : '쿠폰', url : 'createCoupon', listHeaderTitle : null},
            {name : '메뉴 추가', url : 'menuOperate', listHeaderTitle : '전자 메뉴판'},
            {name : '메뉴 관리', url : 'menuList', listHeaderTitle : null},
            {name : '레이아웃 설정', url : 'menuLayout', titlistHeaderTitlele : null},
        ] ,
        listHeader : 'MY Restaurant',
        listHeaderTitle  : '설정'
    }
  },
}
</script>

<style>
#router-view-outer {
  background: #efe2bd;
  padding: 1%;
}

#router-view-inner {
  background: white;
}

.sideBarList {
  background: #fff; 
}

.sideBarList-font {
  font-weight: bold;
  font-size: 1.2em;
}

#sideBar-title-name {
  color: #ff9a55;
  font-weight: bold;
  font-size: 2.2em;
}

#sideBar-title-name-outer {
  padding-bottom: 10%;
}

#sideBar-name {
  color: #6d4d35;
  font-weight: bold;
  font-size: 1.7em;
}

#content-side-header {
  margin: 300px;
}

/* 링크를 클릭하려고 마우스를 가져갔을 때 */
a:hover { 
  color: #9d724b; 
  text-decoration: none;
}

hr.sideBar-hr-line {
  width: 90%;
  height: 2px;
  margin-left: auto;
  margin-right: auto;
  background-color:#ff9a55;
  color:#ff9a55;
  border: 0 none;
}
</style>

