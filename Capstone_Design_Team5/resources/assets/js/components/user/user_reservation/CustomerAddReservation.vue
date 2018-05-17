<template>
    <v-app>
        <v-layout row justify-center>
            <v-dialog v-model="dialog" persistent max-width="500px">
                <v-btn color="#424242" dark slot="activator" class="addReservation_btn">예약 하기</v-btn>
                <v-card>
                    <!-- v-card title -->
                    <v-card-title>
                        <span class="headline">예약 하기</span>
                    </v-card-title>
                    <!-- v-card 본문 -->
                    <v-card-text>
                        <v-container grid-list-md>
                            <v-layout wrap>
                                <!-- 예약 날짜 -->
                                <v-flex xs11 sm5 >
                                    <!-- datepicker -->
                                    <v-menu
                                        ref="reservation_menu"
                                        lazy
                                        :close-on-content-click="false"
                                        v-model="reservation_menu"
                                        transition="scale-transition"
                                        offset-y
                                        full-width
                                        :nudge-right="40"
                                        min-width="290px"
                                        :return-value.sync="start_date"
                                    >
                                        <v-text-field
                                        slot="activator"
                                        label="예약 날짜"
                                        v-model="start_date"
                                        prepend-icon="event"
                                        readonly
                                        ></v-text-field>

                                        <!-- 예약 날짜 -->
                                        <v-date-picker v-model="start_date" no-title scrollable :allowed-dates="allowedDates">
                                            <v-spacer></v-spacer>
                                            <v-btn flat color="primary" @click.stop="reservation_menu = false">Cancel</v-btn>
                                            <v-btn flat color="primary" @click="$refs.reservation_menu.save(start_date), setTime()">OK</v-btn>
                                        </v-date-picker>
                                    </v-menu>
                                </v-flex>
                                <v-flex xs12 sm6 md4>
                                    <!-- 예약 시간 -->
                                    <v-select
                                        :items="states"
                                        v-model="pick_time"
                                        label="예약 시간"
                                        single-line
                                    ></v-select>
                                </v-flex>
                                <!-- 인원수 -->
                                <v-flex xs12 sm6 md4>
                                    <v-text-field label="어른 인원" required v-model="adult_person"></v-text-field>
                                </v-flex>
                                <v-flex xs12 sm6 md4>
                                    <v-text-field label="아이 인원" required v-model="child_person"></v-text-field>
                                </v-flex>

                                <!-- 메뉴 선택 (1:true)-->
                                <div v-if="this.menu_select == 1">
                                    <B> 메뉴 예약이 가능한 가게 입니다. </B><br>
                                    <v-btn color="primary" @click="menuDialog = true"> 메뉴 선택하기 </v-btn>
                                    
                                    <!-- 메뉴판 -->
                                    <v-dialog 
                                        v-model="menuDialog"
                                    >
                                        <v-stepper v-model="Menu_Order" dark>
                                            <!-- Header -->
                                            <v-stepper-header>
                                                <!-- 1. 메뉴선택 -->
                                                <v-stepper-step step="1" :complete="Menu_Order > 1">메뉴 선택</v-stepper-step>
                                                <v-divider></v-divider>
                                                
                                                <!-- 2. 메뉴 확인 -->
                                                <v-stepper-step step="2" :complete="Menu_Order > 2">메뉴 확인</v-stepper-step>
                                                <v-divider></v-divider>
                                            </v-stepper-header>
                                            <!-- Main -->
                                            <v-stepper-items>
                                                <!-- 1. 메뉴선택 -->
                                                <v-stepper-content step="1" color="error"> 
                                                    
                                                    <v-card color="white lighten-1" class="mb-5" style="overflow:hidden">  
                                                        <Layout></Layout>
                                                    </v-card> 
                                                    
                                                    <!-- btn -->
                                                    <v-btn color="error" @click.native="Menu_Order = 2"
                                                        @click="order_menu">
                                                        확인
                                                    </v-btn>
                                                </v-stepper-content>
                                                
                                                <!-- 2. 메뉴 확인  height="200px" -->
                                                <v-stepper-content step="2">
                                                    <v-card color="white lighten-1" class="mb-5" >
                                                        <v-container :id="'menu_check_container'"> 
                                                            <v-layout v-for="i in range(0, click_menu.length-1)" :key="i" 
                                                                :id="'menu_layout'+i"  mb-3> 
                                                                <v-flex sm12>
                                                                    <v-card elevation-20>
                                                                        <v-card-text style="font-size:1.2rem">
                                                                            <div>
                                                                                <b> 메뉴명 : {{click_menu[i].menu.name}} </b> 
                                                                                <v-btn icon 
                                                                                    style="float : right" 
                                                                                    @click="click_cancel"
                                                                                    :id="i"
                                                                                >
                                                                                    <v-icon dark> close </v-icon>
                                                                                </v-btn><br>
                                                                                <b> 가격 : {{click_menu[i].menu.price}} </b> <br>
                                                                                <!-- 옵션 선택 -->
                                                                                <v-flex xs6 v-if="click_menu[i].menu.opNum != 0">
                                                                                    <b> [ 옵션 ] </b> <br>
                                                                                    <!-- 옵션 배열 길이 만큼 돌기 -->
                                                                                    <span v-for="(option, index) in optionArray[i]" :key="index">
                                                                                        <!-- 옵션 이름 -->
                                                                                        <b v-text="option['Name']"></b>
                                                                                        <!-- 옵션 세부 사항 -->
                                                                                        
                                                                                        <v-select
                                                                                            :items="optionArray[i][index]"
                                                                                            v-model="optionselect[i][index]"
                                                                                            single-line
                                                                                        ></v-select>
                                                                                    </span>
                                                                                </v-flex>
                                                                            </div>
                                                                        </v-card-text>                                        
                                                                    </v-card>
                                                                </v-flex>  
                                                            </v-layout>                                            
                                                        </v-container>   
                                                    </v-card>
                                                        <v-flex>
                                                            <v-card>
                                                                <b style="padding-left:5%; font-size: 2rem"> 총 : {{click_menu.length}} 개 </b> 
                                                                <b style="padding-left:5%; font-size: 2rem"> 합계 : {{sum_price}} 円 </b>
                                                            </v-card> 
                                                        </v-flex>
                                                    <!-- btn -->
                                                    <v-btn color="error" @click.native="Menu_Order = 2" @click="OrderMenu()"
                                                    >
                                                        메뉴 선택
                                                    </v-btn>
                                                    <v-btn flat @click.native="Menu_Order = 1">취소</v-btn>
                                                </v-stepper-content>
                                            </v-stepper-items>
                                        </v-stepper>
                                    </v-dialog>
                                </div>
                            </v-layout>
                             <!-- 요청 사항 -->
                            <v-flex>
                                <v-text-field
                                    v-model="message"
                                    label="요구 사항"
                                    required
                                ></v-text-field>
                            </v-flex>
                        </v-container>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="blue darken-1" flat @click.native="dialog = false">닫기</v-btn>
                        <v-btn color="blue darken-1" flat  @click.stop="dialog_ok = true">예약 하기</v-btn>
                        <!-- 확인 버튼 -->
                        <v-dialog v-model="dialog_ok" max-width="50%">
                          <v-card>
                            <v-card-title>
                              <div class="reservationCheck">
                                  <h2><B>예약 확인</B></h2>
                                  <br><hr><br>
                                  <h3><B> 예약 날짜 : </B> {{this.start_date}} </h3>
                                  <h3><B> 예약 시간 : </B> {{this.pick_time}} </h3>
                                  <h3><B> 어른 인원 : </B> {{this.adult_person}} </h3>
                                  <h3><B> 아이 인원 : </B> {{this.child_person}} </h3>
                                  <h3><B> 요구 사항 : </B> {{this.message}} </h3>
                              </div>
                            </v-card-title>
                            <v-card-actions>
                              <v-btn color="primary" flat @click.stop="dialog_ok=false, dialog = false" @click="SpendData(), Okey()">확인</v-btn>
                              <v-btn color="primary" flat @click.native="dialog_ok = false, dialog = false">취소</v-btn>
                            </v-card-actions>
                          </v-card>
                        </v-dialog>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-layout>
    </v-app>
</template>
<script>
    import { EventBus } from '../user_menu/eventBus.js';
    import VueAxios from 'vue-axios';
    import axios    from 'axios';

    // 사용자 설정에 따라 레이아웃을 선택함.
    import DefaultLayout1 from '../user_menu/MenuDefaultLayout1.vue';
    // import DefaultLayout2 from './MenuDefaultLayout2.vue';
    // import DefaultLayout3 from './MenuDefaultLayout3.vue';
    // import DefaultLayout4 from './MenuDefaultLayout4.vue';
    // import CustomLayout from './MenuDefaultLayout1.vue';      // 아직

    var layout = DefaultLayout1;     // 사장이 선택한 메뉴판 탬플릿
    var obj    = [];                 // 클릭한 배열 담기
    var check  = 0;                  // 클릭한 배열 index용 변수    

  export default {
      created : function () {
        // 메뉴
        EventBus.$on('select_menus', function(menu) { 
            obj.push( menu[check] ); check++;
        });

        // 예약
        var set_time_data;
        axios.post('/reservationSetting', {
            'shop_id' : this.$route.params.shop_id
        }).then((response) => {
            /* 그 가게의 예약설정된 Data */
            var reservationSettingData = response.data.reservationSetting;

            /* item안에 넣기 */
            this.items = reservationSettingData;

            /* 메뉴가 선택 가능한 가게인지 아닌지 */
            this.menu_select = menu_select;

            /* 기본 가게 정보 */
            this.lunch_open = this.resData[0].lunch_open;
            this.lunch_close = this.resData[0].lunch_close;
            this.dinner_open = this.resData[0].dinner_open;
            this.dinner_close = this.resData[0].dinner_close;
        })
    }, 
      components : {
          'Layout' : layout
      },
      data() {
          return {
            dialog: false,
            dialog_ok : false,
            menuDialog : false,

            Menu_Order: 0,
            click_menu:[],          // 클릭한 메뉴들이 담김
            Ordercheck: false,      // 주문 확인 창 
            sum_price : 0,          // 선택한 메뉴 총 가격
            translateText : [],     // 번역한 텍스트 값이 들어갈 배열 

            // 옵션 선택
            optionselect : [],
            optionArray: [],        // 클릭한 메뉴의 옵션 값을 관리할 배열 
            
            // 메뉴 아이디 배열
            menu : [],
            Order : [],

            // 이쁜 메뉴 배열
            HappyMenu : [],

            /* reservation */      
            adult_person        : '',
            child_person        : '',
            menuselect          : '',
            message             : '',

            /* date picker */
            start_date: null,
            reservation_menu: false,
            modal: false,

            /* timePicker*/
            /* 예약 시간 배열 */
            states : [],
            /* 선택한 시간 */
            pick_time : '',

            /* 메뉴 선택 가능한지 안한지 */
            menu_select : 1,

            /* 기본 식당 시간 */
            lunch_open  : '09:00',
            lunch_close : '14:00',
            dinner_open : '17:00',
            dinner_close : '22:00',

            /* DB에서 받아 온 값 - reservation_set */
            items:[
                {
                    impossible  : '예약 불가능',
                    pick_date   : '2018-05-03',   
                },
                {
                    impossible  : '예약 가능',
                    pick_date   : '2018-05-04',
                    set_time : [
                        "11:00", "12:00", "13:30"
                    ]

                },
                {
                    impossible  : '예약 불가능',
                    pick_date   : '2018-05-05'   
                },
                {
                    impossible  : '예약 불가능',
                    pick_date   : '2018-05-07'   
                }
            ]
        }
    },

    methods : {
        // 불가능 한 날짜 반환.
        allowedDates(val)
        {
            var index = 0;
            var maxlength = this.items.length;

            var dateCheck = "";

            for(var $i = 0; $i < maxlength; $i++)
            {
                // impossible이 예약 불가능일 경우 달력에 표시되지 않습니다.
                if(val == this.items[$i].pick_date && this.items[$i].impossible == '예약 불가능'){
                    dateCheck += this.items[$i].pick_date + "&&"
                }
            }
            return !(dateCheck);
        }, 

        setTime() {
            /* date가 클릭시 item안의 set_time[]을 select 문에 넣기 */
            var maxIndex = this.items.length;
            this.states = [];

            /* true/ false로 날짜가 배열안에 있는지 없는지 파악 */
            var check = false;

            for(var i = 0; i < maxIndex; i++) 
            {
                // 배열안의 예약 가능 시간 빼오기
                if(this.start_date == this.items[i].pick_date && this.items[i].impossible == "예약 가능")
                {
                    check = true;
                    for(var j = 0; j < this.items[i].set_time.length; j++)
                    {
                        this.states.push(this.items[i].set_time[j])
                    }                    
                }
            }

            /* 사장님이 지정한 설정 배열에 날짜가 존재하지 않는 경우 */
            if(check == false) {
                this.basic_time();
            }
        },
        
        // 기본 시간 으로 설정
        basic_time() {
                // 점심 "11:00 -> 11"
                var lunch_open_hour     = parseInt(this.lunch_open.substr(0, 2))
                var lunch_close_hour    = parseInt(this.lunch_close.substr(0,2))
                var lunch_open_minute   = this.lunch_open.substr(3,2)
                var lunch_close_minute  = this.lunch_close.substr(3,2)
                // 저녁
                var dinner_open_hour    = parseInt(this.dinner_open.substr(0, 2))
                var dinner_close_hour   = parseInt(this.dinner_close.substr(0,2))
                var dinner_open_minute  = this.dinner_open.substr(3,2)
                var dinner_close_minute = this.dinner_close.substr(3,2)

                // 시
                var hour;
                var lunch_minute = lunch_open_minute;
                var dinner_minute = dinner_open_minute;

                // 점심 시작 - 점심 끝
                for(var i = lunch_open_hour; i <= lunch_close_hour; i++)
                {
                    hour = i;
                    // 시작) 분 : 00
                    if(lunch_minute == '00')
                    {
                        this.states.push(hour + ":" + lunch_minute);
                        if(hour == lunch_close_hour && lunch_close_minute != '30')
                        {
                            break;
                        }
                        else {
                            lunch_minute = '30';
                            this.states.push(hour + ":" + lunch_minute);
                        }
                        lunch_minute = '00';
                    }
                    else if(lunch_minute == '30')
                    {
                        this.states.push(hour + ":" + lunch_minute);
                        lunch_minute = '00';
                    }

                }

                for(var i = dinner_open_hour; i <= dinner_close_hour; i++)
                {
                    hour = i;
                    // 시작) 분 : 00
                    if(dinner_minute == '00')
                    {
                        this.states.push(hour + ":" + dinner_minute);
                        if(hour == dinner_close_hour && dinner_close_minute != '30')
                        {
                            break;
                        }
                        else {
                            dinner_minute = '30';
                            this.states.push(hour + ":" + dinner_minute);
                        }
                        dinner_minute = '00';
                    }
                    else if(dinner_minute == '30')
                    {
                        this.states.push(hour + ":" + dinner_minute);
                        dinner_minute = '00';
                    }

                }
            },
        

        Okey() {
          confirm('예약이 완료 되었습니다.')
        },

        // -------------- 메뉴판 ---------------
        // 주문하기 버튼 클릭 시 호출되는 함수
        order_menu : function() { 
            this.click_menu = obj;
            this.sum_price = 0;

            for(let i=0; i< this.click_menu.length; i++){
                this.sum_price += this.click_menu[i].menu.price
            } 

            this.select();
        }, 

        // v-for 용 함수, start에서 시작해서 end까지 1식 반환
        range : function (start, end) {
            return Array(end - start + 1).fill().map((_, idx) => start + idx)
        },

        // 메뉴 취소하기 
        click_cancel : function() {
            var id          = event.target.parentNode.id;                        // 클릭한 메뉴 click_menu의 배열 키 값
            var container   = document.getElementById('menu_check_container');   // 메뉴 확인 창
             
            this.sum_price  = this.sum_price - this.click_menu[id].menu.price;   // 총 가격 빼기
            this.click_menu.splice(id, 1);                                       // 선택한 메뉴 배열에서 취소한 메뉴 삭제
             
            alert('선택한 메뉴를 취소하였습니다.');
        },

        // 옵션 선택
         select() {
            var argId = argId;
            var MenuMax = this.click_menu.length;

            // 메뉴 길이 만큼 돌기
            for(var i = 0; i < MenuMax; i++)
            {
                // 해당 메뉴 옵션 개수
                var opNumMax = this.click_menu[i].menu.opNum;

                this.optionArray[i] = [];
                this.optionselect[i] = [];
                for(var j = 0; j < opNumMax; j++)
                {
                    // 서브 옵션 개수
                    var supOption = this.click_menu[i].menu['subOpNum' + (j+1)];

                    // 옵션 이름 넣기
                    this.optionArray[i][j] = [];
                    this.optionArray[i][j][ 'Name' ] = this.click_menu[i].menu['optionName' + (j+1)];

                    for(var z = 0; z < supOption; z++)
                    {
                        // 옵션 상세 정보
                        this.optionArray[i][j][z] = this.click_menu[i].menu[ (j+1)+ 'optionValue' + (z+1) ];
                    } 
                }
            }
        },

        // 메뉴 주문 데이터 송신
        OrderMenu() {
             // 주문한 메뉴
            for(var i = 0; i < this.click_menu.length; i++)
            {
                this.menu[i] = this.click_menu[i].menu.id;
            }

            this.menuDialog = false;
        },
        
        SpendData() {
        // axios http 라이브러리
        // -- 사장님 수락 리스트에 등록 --
             axios.post('/requestReservation', {
                shop_id        : this.$route.params.shop_id,
                adult_person   : this.adult_person,
                child_person   : this.child_person,
                date           : this.start_date,
                time           : this.time,
                message        : this.message,
                // 선택한 menu id
                menu     : this.menu,
                // 옵션
                option   : this.optionselect
            }).then((response) => {
                alert(response.data.msg);
            }).catch(console.log('test '));
        }
    }
}
</script>
<style>
  .addReservation_btn {
    width: 200px;
    height: 30px;
    text-align: center;
  }
</style>
