<!-- 기본 제공 템플릿 1-->

<template>
    <div class="container" style="width:100%; border:1px solid; ">
         기본 제공 템플릿 1
          
    </div>
</template>
        
<script type="text/javascript"> 
import VueAxios from 'vue-axios';
import axios from 'axios';
 
var restaurant_id = 13;
var get_datas = null;

export default {
    created() { 
        // 값 보내기
        // axios.get('/call_menu',restaurant_id)
        // .then( (response) : {
        //     get_datas = response.data;    
        //     alert(get_datas);
        // })
        // .catch((ex):{ 
        //     alert('왜 안대');
        // })

        get_datas = {
            'menu0': {
                basic : {
                    'name' : '김치찌개',
                    'explanation' : '맛있는 김치찌개',
                    'price' : '6000',
                    'category' : '식사류',
                    'remark' : 'dinner'
                },
                img : {
                    'filename' : "13_titleImg,jpeg",
                    'path'     : '/images/13/'
                },
                option : {
                    'option_name'   : "간",
                    'option_value0' : '싱겁게',
                    'option_value1' : '보통',
                    'option_value2' : '짜게'
                },
            },
            'menu1' :{ 
                basic : { 
                        'name' : '김밥',
                        'explanation' : '한줄에 2천원 에바참치',
                        'price' : '2000',
                        'category' : '분식류',
                        'remark' : 'default'
                },
                img : { 
                    'filename' : "13_titleImg,jpeg",
                    'path'     : '/images/13/'
                }
            },
            'menu2' : { 
                basic : { 
                    'name' : '라면',
                    'explanation' : '집에서 먹는게 이득',
                    'price' : '2500',
                    'category' : '식사류',
                    'remark' : 'lunch'
                },
                img : { 
                    'filename' : "13_titleImg,jpeg",
                    'path'     : '/images/13/'
                },
                option : { 
                    'option_name'   : "추가",
                    'option_value0' : '계란',
                    'option_value1' : '공기밥',
                    'option_value2' : '치즈'
                },
            },
            'menu3' :{ 
                basic : { 
                    'name' : '치킨',
                    'explanation' : '최고',
                    'price' : '17000',
                    'category' : '안주',
                    'remark' : 'dinner'
                },
                img : { 
                    'filename' : "13_titleImg,jpeg",
                    'path'     : '/images/13/'
                },
                option : {
                    'option_name'   : "옵션",
                    'option_value0' : '순살',
                    'option_value1' : '무 많이',
                    'option_value2' : '소스 추가'
                },
            },
            'menu4' : {
                basic : {
                    'name' : '순대',
                    'explanation' : '떡볶이 친구',
                    'price' : '3000',
                    'category' : '분식류',
                    'remark' : 'lunch'
                },
                img : {
                    'filename' : "13_titleImg,jpeg",
                    'path'     : '/images/13/'
                },
                option : {
                    'option_name'   : "내장 어떻하실?",
                    'option_value0' : '순대만요',
                    'option_value1' : '내장 섞어줘요' 
                }
            }
        };


        alert(get_datas);
        // let iterator = get_datas.;

        // for(let key of iterator){
        //     console.log(key);
        // }
    },

    data : function () {
        return {
            menu_datas : {},
            menu_img : {},
            menu_option : {},
        }
    },

    methods : {
        data_maping : function () {
            
        }
    }

}

</script>

<style>

</style>
