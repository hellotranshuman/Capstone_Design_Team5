<template>
    <div class="container" style="border:1px solid">
        <div id="operator_head">
            <h1 style="float:left; margin-top:4%;"> 메뉴 관리 </h1> 
            <hr>  
        </div>
        <div style="width:98%; margin: auto; margin-bottom:1%;">
            <router-link to="menuOperate" class="link"> 메뉴 추가 </router-link>
            <router-link to="menuList"    class="link"> 메뉴 보기 </router-link>
            <router-link to="menuLayout"  class="link"> 메뉴판 레이아웃 설정 </router-link>
        </div>

        <transition>
            <router-view> </router-view>
        </transition>
            
        <div style="margin-bottom:5%;"> </div>    
    </div>
</template>
        
<script type="text/javascript"> 
import VueAxios from 'vue-axios';
import axios from 'axios';
 
export default {
}
</script>

<style>
    .link {
        width: 20%; 
        margin-right:5%;  
        font-size: 20px;
        overflow: hidden;
    }
    hr {
        width: 100%;
        border:1.3px solid;
        margin-bottom: 3%;
        overflow: hidden;
    }
    #operator_head{
        width:98%; 
        margin: auto;
        overflow: hidden;
    }
</style>
