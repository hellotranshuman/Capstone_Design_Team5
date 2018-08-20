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
      <v-flex xl10 lg10 md8 xs9 id="router-view-outer" class="pa-5">
        <v-container id="router-view-inner">
          <router-view></router-view>
        </v-container>
      </v-flex>
    </v-layout>
  </v-content>
</template>

<script>
export default {
  data() {
    return {
        shop_id     : this.$route.params.shop_id,  // 식당 아이디를 저장하는 변수,
        sideBarList : [
            {name : 'お店へ', url : '/restaurant/' + this.$route.params.shop_id + '/info', listHeaderTitle : '設定'},
            {name : 'お店情報', url : 'editRestaurant', listHeaderTitle : 'お店管理'},  // 사이드바 목록
            {name : 'クーポン', url : 'createCoupon', listHeaderTitle : null},
            {name : 'メニュー追加', url : 'menuOperate', listHeaderTitle : '電子メニュー'},
            {name : 'メニュー管理', url : 'menuList', listHeaderTitle : null},
            {name : 'メニューデザイン', url : 'menuLayout', titlistHeaderTitlele : null},
        ] ,
        listHeader : 'MY Restaurant',
        listHeaderTitle  : '設定'
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

