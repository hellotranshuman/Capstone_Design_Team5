<template>
<v-app>
    <div class="create_coupon">
        <br>
        <h3><B>예약 설정</B></h3>
        예약에 관련 설정 할 수 있습니다.
        <hr><br>
        <v-dialog v-model="dialog" persistent max-width="500px">
          <v-btn color="#424242" dark slot="activator">예약 설정 추가</v-btn>
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
                      <!-- 예약 시간 start_time-->
                      <v-flex xs11 sm5>
                        <v-menu
                          ref="start_menu"
                            lazy
                            :close-on-content-click="false"
                            v-model="start_menu"
                            transition="scale-transition"
                            offset-y
                            full-width
                            :nudge-right="40"
                            max-width="290px"
                            min-width="290px"
                            :return-value.sync="ReservationSettingItem.start_time"
                         >
                        <v-text-field
                          slot="activator"
                          label="start Time"
                          v-model="ReservationSettingItem.start_time"
                          prepend-icon="access_time"
                          readonly
                          hint="예약 설정 시간대 선택"
                          persistent-hint
                          ></v-text-field>
                          <v-time-picker v-model="ReservationSettingItem.start_time" @change="$refs.start_menu.save(ReservationSettingItem.start_time)"></v-time-picker>
                         </v-menu>
                      </v-flex>
                      <!-- 시간 설정 end_time -->
                      <v-flex xs300 sm5>
                        <v-menu
                          ref="end_menu"
                          lazy
                          :close-on-content-click="false"
                          v-model="end_menu"
                          transition="scale-transition"
                          offset-y
                          full-width
                          :nudge-right="40"
                          max-width="290px"
                          min-width="290px"
                          :return-value.sync="ReservationSettingItem.end_time"
                        >
                          <v-text-field
                              slot="activator"
                              label="end Time"
                              v-model="ReservationSettingItem.end_time"
                              prepend-icon="access_time"
                              readonly
                          ></v-text-field>
                            <v-time-picker v-model="ReservationSettingItem.end_time" @change="$refs.end_menu.save(ReservationSettingItem.end_time)"></v-time-picker>
                        </v-menu>
                      </v-flex>
                      <br><br>
                      <!-- 예약 가능 불가능 여부 확인 -->
                      <v-flex xs12 sm6>
                        <v-select
                            label="예약 가능 여부"
                            required
                            :items="['예약 가능', '예약 불가능']"
                            v-model="ReservationSettingItem.impossible"
                        >
                        </v-select>
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
    <div class="coupon_table">
        <v-data-table
                :headers="headers"
                :items="items"
                hide-actions
                class="elevation-1"
            >
            <template slot="items" slot-scope="props">
                <td>{{ props.index + 1 }}</td>
                <td>{{ props.item.CouponName }}</td>
                <td class="text-xs-right">{{ props.item.pick_date }}</td>
                <td class="text-xs-right">{{ props.item.start_time }}</td>
                <td class="text-xs-right">{{ props.item.end_time }}</td>
                <td class="text-xs-right">{{ props.item.impossible }}</td>
                <td class="justify-center layout px-0">
                <v-btn icon class="mx-0" @click="editItem(props.item)">
                    <v-icon color="teal">edit</v-icon>
                </v-btn>
                <v-btn icon class="mx-0" @click="deleteItem(props.item)">
                    <v-icon color="pink">delete</v-icon>
                </v-btn>
                </td>
            </template>
        </v-data-table>
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
             /* Add ReservationSetting */
                dialog: false,
                impossible : null,

                /* date picker */
                pick_date: null,
                menu: false,
                modal: false,

                /* time picker */
                start_time: null,
                start_menu: false,
                modal: false,

                end_time: null,
                end_menu: false,
                modal: false,

            /* table */
            dialog: false,
            headers: [
                {
                text: 'index',
                align: 'left',
                sortable: false,
                value: 'name'
                },
                { text: '예약 날짜', value: 'pick_date' },
                { text: '시작 시간', value: 'start_time' },
                { text: '종료 시간', value: 'end_time' },
                { text: '가능 여부', value: 'impossible' },
                { text: 'Actions', value: 'name', sortable: false }
            ],

            /* 저장 & 편집 & 삭제 */
            items: [],
            ReservationSettingIndex: -1,
            ReservationSettingItem: {
                pick_date: null,
                start_time: null,
                end_time: null,
                impossible: '',
            },
            defaultItem: {
                pick_date: null,
                start_time: null,
                end_time: null,
                impossible: '',
            }
        }
    },
    computed: {
      formTitle () {
        return this.ReservationSettingIndex === -1 ? '예약 설정 추가' : '예약 설정 변경'
      }
    },

    watch: {
      dialog (val) {
        val || this.close()
      }
    },

    methods: {
      editItem (item) {
        this.ReservationSettingIndex = this.items.indexOf(item)
        this.ReservationSettingItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {
        const index = this.items.indexOf(item)
        confirm('예약을 취소 하시겠습니까?') && this.items.splice(index, 1)
      },

      close () {
        this.dialog = false
        setTimeout(() => {
          this.ReservationSettingItem = Object.assign({}, this.defaultItem)
          this.ReservationSettingIndex = -1
        }, 300)
      },

      save () {
        if (this.ReservationSettingIndex > -1) {
          Object.assign(this.items[this.ReservationSettingIndex], this.ReservationSettingItem)
        } else {
          this.items.push(this.ReservationSettingItem)
        }
        /* Data 송신 */
          axios.post('/addReservationSetting', {
            pick_date         : this.ReservationSettingItem.pick_date,
            start_time        : this.ReservationSettingItem.start_time,
            end_time          : this.ReservationSettingItem.end_time,
            impossible        : this.ReservationSettingItem.impossible, 
          }).then(console.log('success')).catch(console.log('test '));

        this.close()
      }
    }
}
</script>
<style>

    .create_coupon {
        padding-left: 5%;
        padding-right: 5%;
    }
</style>