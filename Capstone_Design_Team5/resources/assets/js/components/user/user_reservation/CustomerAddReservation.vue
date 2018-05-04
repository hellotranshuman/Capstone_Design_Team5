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
                                <!-- 예약자 이름 -->
                                <v-flex xs12>
                                <v-text-field label="예약자 명" required v-model="username"></v-text-field>
                                </v-flex>
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
                                        label="pick Date"
                                        v-model="start_date"
                                        prepend-icon="event"
                                        readonly
                                        ></v-text-field>

                                        <!-- 예약 날짜 -->
                                        <v-date-picker v-model="start_date" no-title scrollable :allowed-dates="allowedDates">
                                            <v-spacer></v-spacer>
                                            <v-btn flat color="primary" @click.stop="reservation_menu = false">Cancel</v-btn>
                                            <v-btn flat color="primary" @click="$refs.reservation_menu.save(start_date)">OK</v-btn>
                                        </v-date-picker>
                                    </v-menu>
                                </v-flex>
                                <!-- 예약 시간 -->
                                <v-flex xs11 sm5>
                                    <v-menu
                                        ref="menu"
                                        lazy
                                        :close-on-content-click="false"
                                        v-model="menu2"
                                        transition="scale-transition"
                                        offset-y
                                        full-width
                                        :nudge-right="40"
                                        max-width="290px"
                                        min-width="290px"
                                        :return-value.sync="time"
                                    >
                                        <v-text-field
                                        slot="activator"
                                        label="pick Time"
                                        v-model="time"
                                        prepend-icon="access_time"
                                        readonly
                                        ></v-text-field>
                                        <!-- <v-time-picker 
                                                    v-model="time" 
                                                    :allowed-hours="allowedHours"
                                                    :allowed-minutes="allowedMinutes"                                                
                                        ></v-time-picker> -->
                                    </v-menu>
                                </v-flex>
                                <!-- 인원수 -->
                                <v-flex xs12 sm6 md4>
                                    <v-text-field label="어른 인원" required v-model="adult_person"></v-text-field>
                                </v-flex>
                                <v-flex xs12 sm6 md4>
                                    <v-text-field label="아이 인원" required v-model="child_person"></v-text-field>
                                </v-flex>
                            </v-layout>
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
                                  <h3><B> 예약자 명 : </B> {{this.username}} </h3>
                                  <h3><B> 예약 날짜 : </B> {{this.start_date}} </h3>
                                  <h3><B> 예약 시간 : </B> {{this.time}} </h3>
                                  <h3><B> 어른 인원 : </B> {{this.adult_person}} </h3>
                                  <h3><B> 아이 인원 : </B> {{this.child_person}} </h3>
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
import VueAxios from 'vue-axios';
import axios from 'axios';

  export default {
      data() {
          return {
            dialog: false,
            dialog_ok : false,

            /* reservation */
            username            : '',       
            adult_person        : '',
            child_person        : '',
            menuselect          : '',

            /* date picker */
            start_date: null,
            reservation_menu: false,
            modal: false,

            /* time picker */
            time: null,
            menu2: false,
            modal2: false,

            /* 가능한 시간대 */
            owner_start_hour    : 0,
            owner_end_hour      : 0,
            owner_start_minute  : 0,
            owner_end_minute    : 0,

            /* DatePicker*/

            items:[
                {
                    impossible : '예약 불가능',
                    pick_date: '2018-05-03',   
                },
                {
                    impossible : '예약 가능',
                    pick_date: '2018-05-04'   
                },
                {
                    impossible : '예약 불가능',
                    pick_date: '2018-05-05'   
                },
                {
                    impossible : '예약 불가능',
                    pick_date: '2018-05-07'   
                }
            ]

        }
    },

    /* Data값 받기 */
    // created: function () {
    //     axios.post('/reservationSetting', {
    //         'shop_id' : this.$route.params.shop_id
    //     }).then((response) => {
    //         /* 그 가게의 예약설정된 Data */
    //         var reservationSettingData = response.data.reservationSetting;

    //         /* item안에 넣기 */
    //         this.items = reservationSettingData;
    //     })
    //     checkDate();
    // },

    methods : {
        allowedDates(val)
        {
            var index = 0;
            var maxlength = this.items.length;

            var dateCheck = "";

            for(var $i = 0; $i < maxlength; $i++)
            {
                if(!(val != this.items[$i].pick_date)){
                    dateCheck += this.items[$i].pick_date + "&&"
                }
            }

            return dateCheck;
        }, 

        /* timeset(timeIndex) {  
            var start_time  = this.items[timeIndex].start_time;
            var end_time    = this.items[timeIndex].end_time;

            // 시작 시간
            if(start_time.substr(0,1) != 0)
            {
                this.owner_start_hour = parseInt(start_time.substr(0,2));
            }
            else {
                this.owner_start_hour = parseInt(start_time.substr(1,1));
            }
            
            // 시작 분
            if(start_time.substr(3,1) != 0)
            {
                this.owner_start_minute = parseInt(start_time.substr(3,2));
            }
            else {
                this.owner_start_minute = parseInt(start_time.substr(4,1));
            }

            // 끝 시간
            if(end_time.substr(0,1) != 0)
            {
                this.owner_end_hour = parseInt(end_time.substr(0,2));
            }
            else {
                this.owner_end_hour = parseInt(end_time.substr(1,1));
            }
            
            // 시작 분
            if(end_time.substr(3,1) != 0)
            {
                this.owner_end_minute = parseInt(end_time.substr(3,2));
            }
            else {
                this.owner_end_minute = parseInt(end_time.substr(4,1));
            }
 */
        },  

        /* 가능한 시간대 */
        //allowedHours: v => v >= this.owner_start_hour && v <= this.owner_end_hour,
        //allowedMinutes: v => v >= this.owner_start_minute && v <= this.owner_start_minute,

        Okey() {
          confirm('예약이 완료 되었습니다.')
        },
        
        SpendData() {
        // axios http 라이브러리
        // -- 사장님 수락 리스트에 등록 --
            axios.post('/addReservation', {
                username       : this.username,
                adult_person   : this.adult_person,
                child_person   : this.child_person,
                start_date     : this.start_date, 
                time           : this.time,
            }).then(console.log('success')).catch(console.log('test '));
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