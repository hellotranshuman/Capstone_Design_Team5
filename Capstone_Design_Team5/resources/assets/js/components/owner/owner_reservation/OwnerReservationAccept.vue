<template>
<v-app>
    <div class="create_coupon">
        <br>
        <h3><B>예약 수락</B></h3>
        신청받은 예약을 확인하고 수락 할 수 있습니다.
        <hr><br>
      <div class="coupon_table">
        <v-data-table
                :headers="headers"
                :items="items"
                hide-actions
                class="elevation-1"
            >
            <template slot="items" slot-scope="props">
                <td>{{ props.index + 1 }}</td>
                <td>{{ props.item.usernum }}</td>
                <td class="text-xs-right">{{ props.item.start_date }}</td>
                <td class="text-xs-right">{{ props.item.time }}</td>
                <td class="text-xs-right">{{ props.item.adult_person }}</td>
                <td class="text-xs-right">{{ props.item.child_person }}</td>
                <td class="justify-center layout px-0">
                <v-btn color="primary" dark @click="AcceptItem(props.item)" small>
                  Accept <v-icon dark right>check_circle</v-icon>
                </v-btn>
                <v-btn dark  @click="deleteItem(props.item)" small>
                  <v-icon dark left>remove_circle</v-icon>Cancel
                </v-btn>
                </td>
            </template>
            <template slot="no-data">
              <v-btn color="primary" @click="initialize">Reset</v-btn>
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
            /* table */
            dialog: false,
            headers: [
                {
                text: 'index',
                align: 'left',
                sortable: false,
                value: 'name'
                },
                { text: '예약자 명', value: 'usernum' },
                { text: '예약 날짜', value: 'start_date' },
                { text: '예약 시간', value: 'time' },
                { text: '어른 인원', value: 'adult_person' },
                { text: '아이 인원', value: 'child_person' },
                { text: '수락 & 거절', value: 'Accept', sortable: false },
            ],

            /* 저장 & 편집 & 삭제 */
            items: [],
            ReservationAcceptIndex: -1,
            ReservationAcceptItem: {
                usernum: '',
                start_date: null,
                time: null,
                adult_person: 0,
                child_person: 0
            },
            defaultItem: {
              usernum: '',
              start_date: null,
              time: null,
              adult_person: 0,
              child_person: 0
            }
        }
    },

    watch: {
      dialog (val) {
        val || this.close()
      }
    },

    methods: {
      /* 가상 데이터 */
       initialize () {
        this.items = [
          {
              usernum: '가',
              start_date: '2018-02-10',
              time: '11:00',
              adult_person: 0,
              child_person: 0
          },
          {
              usernum: '가',
              start_date: '2018-02-10',
              time: '11:00',
              adult_person: 0,
              child_person: 0
          }
        ]
      },
      AcceptItem (item) {
        const index = this.items.indexOf(item)
        confirm('예약을 수락 하시겠습니까?')
        axios.post('/addReservation', {
          usernum        : item.usernum,
          adult_person   : item.adult_person,
          child_person   : item.child_person,
          start_date     : item.start_date, 
          time           : item.time,
        }).then(console.log('success')).catch(console.log('test '));
      },

      deleteItem (item) {
        const index = this.items.indexOf(item)
        confirm('예약을 거절 하시겠습니까?') && this.items.splice(index, 1)
      },

      /* Data 송신 */
      // SpendData() {
      //       // axios http 라이브러리
      //       axios.post('/addReservation', {
      //               usernum        : this.usernum,
      //               adult_person   : this.adult_person,
      //               child_person   : this.child_person,
      //               menuselect     : this.menuselect,
      //               start_date     : this.start_date, 
      //               time           : this.time,
      //       }).then(console.log('success')).catch(console.log('test '));
      // }
    }
}
</script>
<style>

    .create_coupon {
        padding-left: 5%;
        padding-right: 5%;
    }
</style>