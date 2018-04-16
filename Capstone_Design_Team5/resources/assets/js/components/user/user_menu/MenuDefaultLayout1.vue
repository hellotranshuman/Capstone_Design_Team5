<!-- 기본 제공 레이아웃 1  persistent-->

<template>
<div class="container" style="width:100%; border:1px solid; ">
<v-container style="color:white">
    <!-- 카테고리 영역 -->
    <v-layout xs12> 
            <v-card style="margin:auto">
            <v-bottom-nav :value="true" :active.sync="e2">
                <v-btn 
                    v-for="(value,key) in categorys" :key="key"
                    :value="value" @click="click_category" >
                    {{value}} 
                </v-btn>
            </v-bottom-nav>
        </v-card>
    </v-layout> 

    <!-- 메뉴 영역 메뉴 비율 고정 시키기-->
    <v-layout xs12 
        v-if="menu_row_num !== 0" 
        v-for="index in range(0, menu_row_num-1)" :key="index">
        
        <v-flex 
            v-for="n in range( index*3, index * 3 + 2)" :key="n"  
            v-if="n < get_menus.length"
            xs4 elevation-20 mx-3 my-3 >
        
            <v-card color="white" style="color:black;">
                
                <div class="tem_img">
                    <img :src="get_menus[n].img.path + get_menus[n].img.filename">
                    <!-- <img src="./example6.jpg"> -->
                </div>

                <v-card-title primary-title>
                    <div class="menu_name">
                        <h3 class="menu_info"> {{get_menus[n].menu.name}} </h3>
                    </div>
                    <div class="menu_expl">
                        <div class="menu_info"> {{get_menus[n].menu.explanation}} </div>
                    </div>
                    <div class="menu_price">
                        <h4 class="menu_info"> {{get_menus[n].menu.price}} </h4>
                    </div> 
                    
                    <div class="menu_price" :id="n"> 
                        <v-btn 
                            color="primary" 
                            slot="activator" 
                            flat width=100%; 
                            @click="select_menu"
                        > 주문하기</v-btn>
                    </div>

                </v-card-title>
            </v-card>
        </v-flex>
    </v-layout>

</v-container>
</div>
</template>
        
<script type="text/javascript"> 
import VueAxios from 'vue-axios';
import axios from 'axios';
  
export default {

    created() {
        // 메뉴 카테고리 받아오기
        var url = '/menu/getCategory';
        var get_categorys = null;
        var shopData = new FormData();

        shopData.append('shop_id', this.$route.params.shop_id);

        // 카테고리 요청하기.
        axios.post(url, shopData)
        .then( (response) => {
            get_categorys = response.data.category;
            this.categorys = this.unique(get_categorys) // 카테고리 중복 값 제거.
        })
        .catch((ex)=>{
            alert('메뉴 로드 실패');
        });
    },
    
    data() {
        return {  
            e2           : null,       // 카테고리 클릭 값
            categorys    : null,       // 카테고리 배열
            get_menus    : null,       // 해당 카테고리 메뉴들
            menu_row_num : 0,          // 메뉴 출력 v-layout 갯수
            select_menus : []
        }
    },

    methods : {
        // 메뉴 카테고리 클릭
        click_category : function() {
            var category = event.target;                     // 선택한 카테고리
            var url      = '/menu/getCategory'; // 서버에 요청할 주소
            var data = new FormData();

            // 클릭한 값 검사
            if(category.value === undefined) {
                category = category.parentNode.value;
            } else {
                category = category.value;
                data.append('test', 'dddd');
                // data.append('category', category);
            }

            // 클릭한 카테고리의 메뉴 호출
            axios.post(url, data)
            .then( (response) => {
                console.log(data);
                console.log(response.data);
                /*
                this.get_menus = response.data 

                // 출력할 v-layout 개수 설정
                if( this.get_menus.length%3 === 0 )
                    this.menu_row_num = this.get_menus.length / 3;
                else 
                    this.menu_row_num = Math.floor(this.get_menus.length / 3) + 1;*/
            })
            .catch((ex)=>{
                alert('메뉴 로드 실패');
            });

            // 옵션 셀렉트 만들기 용 데이터 가공
            // for (let i=0; i < this.get_menus.length; i++){
            //     if( this.get_menus[i].option !== undefined){
            //         let OptionData  = this.get_menus[i].option;
            //         let iterator    = Object.keys(OptionData);
            //         let OptionValue = [];

            //         for (let key of iterator){ 
            //             //alert(key);
            //             if(key !== 'name'){
            //                 OptionValue.push(OptionData[key]);
            //             }
            //         }
            //         this.get_menus[i].OptionValues = [];
            //         this.get_menus[i].OptionValues = OptionValue;
            //     }
            //     console.log(this.get_menus[i]);
            // }

        }, // end of click_category

        // 배열 중복 값 제거, 인자는 서버에 받은 카테고리 목록
        unique : function(argArr) {
            var array = [];
 
            for(let i=0; i < argArr.length; i++){
                // array에 없는 값이면 push
                if( !array.includes(argArr[i]['category']) ) { 
                    array.push(argArr[i]['category']);
                }
            }
            return array;
        },

        // v-for 용 함수, start에서 시작해서 end까지 1식 반환
        range : function (start, end) {
            return Array(end - start + 1).fill().map((_, idx) => start + idx)
        },

        select_menu : function () {
            var menu = event.target.parentNode.parentNode.id;    // 클릭한 메뉴 배열 키 값 가져오기.
            
            this.select_menus.push(this.get_menus[menu]);
            console.log(this.select_menus);
            alert('선택하신 메뉴가 추가 되었습니다.');
        }

    }// end of method

}// end of export default
</script>

<style>
.tem_img {
    position: relative;
    width: 100%;
    height: 0;
    overflow: hidden;
    padding-bottom: 70%;
}
img { 
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%; 
} 
.menu_name { 
    position: relative;
    width: 100%;
    height: 0; 
    overflow: hidden;
    padding-bottom: 10%;
}
.menu_expl { 
    position: relative;
    width: 100%;
    height: 0;
    overflow: hidden;
    padding-bottom: 15%; 
}
.menu_price { 
    position: relative;
    width: 50%;
    height: 0; 
    overflow: hidden;
    padding-bottom: 12%; 
}
.menu_info {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%; 
} 
select {
    widows: 100%;
}
</style>
