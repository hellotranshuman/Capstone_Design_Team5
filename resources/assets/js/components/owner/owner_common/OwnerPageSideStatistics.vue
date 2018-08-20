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


            <v-subheader v-if="index == 0" :key="index + '_statistic'">
              <span id="sideBar-name">{{listHeaderTitle}}</span>
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
      sideBarList : [
        {name : '総合グラフ', url : 'totalStatistics'},  // 사이드바 목록
      ] ,
      listHeader : 'MY Restaurant',
      listHeaderTitle  : 'グラフ'
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

/* sideBar-active-color {
    color: green;
} */

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
