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
                                <v-flex>
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
                                  <h3><B> 예약 시간 : </B> {{this.pick_time}} </h3>
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

            /* timePicker*/
            /* 예약 시간 배열 */
            states : [],
            /* 선택한 시간 */
            pick_time : '',

            /* 기본 식당 시간 */
            basic_info: {
                lunch_open  : '09:00',
                lunch_close : '14:00',
                dinner_open : '17:00',
                dinner_close : '22:00',
            },

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

    /* Data값 받기 */
    created: function () {
        var set_time_data;
        axios.post('/reservationSetting', {
            'shop_id' : this.$route.params.shop_id
        }).then((response) => {
            /* 그 가게의 예약설정된 Data */
            var reservationSettingData = response.data.reservationSetting;

            /* item안에 넣기 */
            this.items = reservationSettingData;
        })
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

            confirm(maxIndex)

            for(var i = 0; i < maxIndex; i++) 
            {
                // 배열안의 예약 가능 시간 빼오기
                if(this.start_date == this.items[i].pick_date)
                {
                    confirm('adasdfadf');
                    for(var j = 0; j < this.items[i].set_time.length; j++)
                    {
                        this.states.push(this.items[i].set_time[j])
                    }
                }
            }
        },

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
                time           : this.pick_time
            }).then(console.log('success')).catch(console.log('test '));
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
