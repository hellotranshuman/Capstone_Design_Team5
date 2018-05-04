<template>
<v-app>
    <div class="ownerReservationSetting">
        <br>
        <h3><B>예약 설정</B></h3>
        예약 관련된 설정을 할 수 있습니다.
        <hr><br>
        <v-dialog v-model="dialog" persistent max-width="500px">
          <v-btn color="#424242" dark slot="activator" @click="settime()">예약 설정 추가</v-btn>
            <v-card>
              <!-- v-card title -->
              <v-card-title>
                <span class="headline">예약 설정 추가</span>
              </v-card-title>
              <!-- v-card 본문 -->
              <v-card-text>
                <v-container grid-list-md>
                  <v-layout wrap>
                    <!-- 예약 설정 날짜 -->
                    <v-flex xs11 >
                        <!-- datepicker -->
                        <v-menu
                            ref="menu"
                            lazy
                            :close-on-content-click="false"
                            v-model="menu"
                            transition="scale-transition"
                            offset-y
                            full-width
                            :nudge-right="40"
                            min-width="290px"
                            :return-value.sync="ReservationSettingItem.pick_date"
                        >
                          <v-text-field
                            slot="activator"
                            label="pick Date"
                            v-model="ReservationSettingItem.pick_date"
                            prepend-icon="event"
                            readonly
                            hint="예약 설정할 날짜 선택"
                            persistent-hint
                          ></v-text-field>

                          <v-date-picker v-model="ReservationSettingItem.pick_date" no-title scrollable>
                            <v-spacer></v-spacer>
                            <v-btn flat color="primary" @click="menu = false">Cancel</v-btn>
                            <v-btn flat color="primary" @click="$refs.menu.save(ReservationSettingItem.pick_date)">OK</v-btn>
                            </v-date-picker>
                          </v-menu>
                      </v-flex>
                      <br><br>
                      <v-flex xs11 >
                        <!-- 예약 가능 / 불가능 -->
                          <v-radio-group v-model="ReservationSettingItem.impossible" :mandatory="false"  row>
                            <v-radio label="예약 가능" value="예약 가능"></v-radio>
                            <v-radio label="예약 불가능" value="예약 불가능"></v-radio>
                          </v-radio-group>
                      </v-flex>
                      <!-- 예약 시간 설정 -->
                      <v-flex v-if="this.ReservationSettingItem.impossible == '예약 가능'">
                          예약 가능한 시간대를 설정해 주세요.
                          <v-select
                            :items="time_item"
                            v-model="ReservationSettingItem.reservation_time"
                            multiple
                            label="Select"
                            class="input-group--focused"
                            item-value="text"
                          ></v-select>
                      </v-flex>
                  </v-layout>
                </v-container>
              </v-card-text>
              <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" flat @click.native="dialog = false">Close</v-btn>
                    <v-btn color="blue darken-1" flat @click.native="save" >Save</v-btn>
              </v-card-actions>
            </v-card>
        </v-dialog>
    <div>
      <div class="reservation_calender">
        <v-layout justify-space-between wrap>
          <v-flex class="my-3">
                <v-date-picker 
                        v-model="reservationCal"  
                        event-color="error"
                        :events="arrayEvents">
                </v-date-picker>
            </v-flex>
        </v-layout>
      </div>
      <div class="reservation_set_table">
        <br>
          <v-data-table
                  :headers="headers"
                  :items="items"
                  hide-actions
                  class="elevation-1"
              >
              <template slot="items" slot-scope="props">
                  <td class="text-xs-left">{{ props.item.pick_date }}</td>
                  <td class="text-xs-left">{{ props.item.impossible }}</td>
                  <td class="text-xs-left">{{ props.item.set_time }}</td>
                  <td class="justify-center layout px-0">
                  <v-btn icon class="mx-0" @click.stop=" setdialog = true"
                                            @click="deleteItem(props.item)"
                  >
                      <v-icon color="pink">delete</v-icon>
                  </v-btn>
                  <v-dialog v-model="setdialog" max-width="500px">
                        <v-card>
                            <v-card-text>
                              예약 설정이 삭제 되었습니다.
                            </v-card-text>
                            <v-btn icon class="mx-0"  @click.stop="setdialog = false"
                            >
                                <v-icon color="error">확인</v-icon>
                            </v-btn>
                        </v-card>
                    </v-dialog>
                  </td>
              </template>
          </v-data-table>
      </div>
    </div>
  </div>
</v-app>
</template>

<script>
import VueAxios         from 'vue-axios';
import axios            from 'axios';

export default {
    data() {
        return {
                /* dialog */
                setdialog : false,

                /* click */
                clickItem : null,

                /* Add ReservationSetting */
                dialog: false,

                /* 예약 가능인가 불가능인가 */
                impossible : '',

                /* date picker */
                pick_date: null,
                menu: false,
                modal: false,

                /* time picker */
                // select 목록
                time_item : [],
                    lunch_open   : '11:30',
                    lunch_close  : '14:30',
                    dinner_open  : '16:00',
                    dinner_close : '22:30',

            /* reservation_Date */
            reservationCal: null,
            arrayEvents: [],
            date: null,

            /* table */
            dialog: false,
            headers: [
                { text: '예약 날짜', value: 'pick_date' },
                { text: '예약 가능 여부', value: 'impossible' },
                { text: '예약 가능 시간', value: 'set_time' },
                { text: 'Actions', value: 'name', sortable: false }
            ],

            /* 저장 & 편집 & 삭제 */
            items: [],
            ReservationSettingItem: {
                pick_date: null,
                impossible : null,
                reservation_time : [],
            }
        }
    },
    /* Data값 받기 */
     created: function () {
        axios.post('/getReservationSettingList', {
            'shop_id' : this.$route.params.shop_id
        }).then((response) => {
            var reservationSettingData = response.data.settingData;
            this.items = reservationSettingData;

            /* 가게 lunch.dinner open/close */ 
            this.lunch_open = lunch_open,
            this.lunch_close = lunch_close,
            this.dinner_open = dinner_open,
            this.dinner_close = dinner_close
        })

        this.checkDate();
    },

    mounted () {
        this.arrayEvents
        const d = new Date()
        d.toISOString().substr(0, 10);
        return d.toISOString().substr(0, 10);
    },

    methods: {
      // 예약 불가능 날짜 설정 메서드
      checkDate() {
          var itemIndex   = this.items.length;

          for(var i = 0; i < itemIndex; i++)
          {
            if(this.items[i].impossible == '예약 불가능')
            {
                this.arrayEvents.push(this.items[i].pick_date)
            }
            else {
                this.arrayEvents.push(1)
            }
          }
      },
      // 가게 시간 업로드 매서드
      settime() { 
          // 점심 "11:00 -> 11"
          var lunch_open_hour     = parseInt(this.lunch_open.substr(0, 2))
          var lunch_close_hour    = parseInt(this.lunch_close.substr(0,2))
          var lunch_open_minute   = this.lunch_open.substr(3,3)
          var lunch_close_minute  = this.lunch_close.substr(3,3)
          // 저녁
          var dinner_open_hour    = parseInt(this.dinner_open.substr(0, 2))
          var dinner_close_hour   = parseInt(this.dinner_close.substr(0,2))
          var dinner_open_minute  = this.dinner_open.substr(3,3)
          var dinner_close_minute = this.dinner_close.substr(3,3)

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
                  this.time_item.push(hour + ":" + lunch_minute);
                  if(hour == lunch_close_hour && lunch_close_minute != '30')
                  {
                      break;
                  }
                  else {
                      lunch_minute = '30';
                      this.time_item.push(hour + ":" + lunch_minute);
                  }
                  lunch_minute = '00';
              }
              else if(lunch_minute == '30')
              {
                  this.time_item.push(hour + ":" + lunch_minute);
                  lunch_minute = '00';
              }
              
          }

          for(var i = dinner_open_hour; i <= dinner_close_hour; i++)
          {
              hour = i;
              // 시작) 분 : 00
              if(dinner_minute == '00')
              {                
                  this.time_item.push(hour + ":" + dinner_minute);
                  if(hour == dinner_close_hour && dinner_close_minute != '30')
                  {
                      break;
                  }
                  else {
                      dinner_minute = '30';
                      this.time_item.push(hour + ":" + dinner_minute);
                  }
                  dinner_minute = '00';
              }
              else if(dinner_minute == '30')
              {
                  this.time_item.push(hour + ":" + dinner_minute);
                  dinner_minute = '00';
              }
              
          }
      },

      deleteItem (item) {
        const index = this.items.indexOf(item);
        this.clickItem = this.items[index].id;

        axios.post('/deleteReservationSetting', {
            'id'                : this.clickItem,
        }).then((response) => {

            alert(response.data.flag);
            /*
            if(response.data.flag === 'true')
                alert('삭제되었습니다');
            location.reload(); */
        })
        .catch(console.log('test'));
      },

      save () {
        /* Data 송신 */
          axios.post('/setReservationSetting', {
            shop_id           : this.$route.params.shop_id,
            setting_date      : this.ReservationSettingItem.pick_date,
            impossible        : this.ReservationSettingItem.impossible, 
            set_time          : this.ReservationSettingItem.reservation_time,
            /* 배열 개수 */
            set_time_length   : this.ReservationSettingItem.reservation_time.length,

            /* 달력 날짜 클릭 시 넘어오는 날짜 값 */
            click_date        : this.reservationCal
          }).then((response) => {
              if(response.data.flag === 'true')
                  alert('예약 설정이 완료되었습니다.');
              location.reload();
          })
          .catch(console.log('test'));

        this.dialog = false
      }
    }
}
</script>
<style>
    .reservation_calender {
        float: left;
        width: 150px;
        height: 200px;
    }

    .reservation_set_table {
      float: left;
      padding-left : 15%;
    }
    .ownerReservationSetting {
      padding-left : 2%;
      padding-right : 2%;
    }
</style>