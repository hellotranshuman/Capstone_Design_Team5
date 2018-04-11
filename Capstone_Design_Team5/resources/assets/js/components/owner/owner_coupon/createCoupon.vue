<template>
<v-app>
  <div class="create_coupon">
    <br>
      <h3><B>쿠폰 추가</B></h3>
      원하는 쿠폰을 제작하여 등록할 수 있습니다.
    <hr><br>
    <v-dialog v-model="dialog" max-width="500px">
      <v-btn color="#424242" dark slot="activator">쿠폰 추가</v-btn>
            <v-card>
                <!-- v-card title -->
                <v-card-title>
                <span class="headline">쿠폰 추가</span>
                </v-card-title>
                <!-- v-card 본문 -->
                <v-card-text>
                <v-container grid-list-md>
                    <v-layout wrap>
                    <!-- 쿠폰 이름 -->
                    <v-flex xs12 sm6 md4>
                        <v-text-field label="쿠폰 이름" required v-model="CouponItem.CouponName"></v-text-field>
                    </v-flex>
                    <!-- 쿠폰 종류 -->
                    <v-flex xs12>
                        <v-select
                        label="쿠폰 종류"
                        required
                        :items="['가격 할인', '상품 제공']"
                        v-model="CouponItem.CouponType"
                        ></v-select>
                    </v-flex>
                    <v-flex xs12 sm6 md4>
                        <v-text-field label="할인 가격" required v-model="CouponItem.Discount"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6 md4>
                        <v-text-field label="제공 상품" required v-model="CouponItem.addproduct"></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                         <v-text-field label="쿠폰 조건" required v-model="CouponItem.Condition"></v-text-field>
                    </v-flex>

                    <v-flex xs11 sm5>
                        <!-- datepicker -->
                        <v-menu
                            ref="start_menu"
                            lazy
                            :close-on-content-click="false"
                            v-model="start_menu"
                            transition="scale-transition"
                            offset-y
                            full-width
                            :nudge-right="40"
                            min-width="290px"
                            :return-value.sync="CouponItem.start_date"
                        >
                            <v-text-field
                            slot="activator"
                            label="pick start Date"
                            v-model="CouponItem.start_date"
                            prepend-icon="event"
                            readonly
                            ></v-text-field>

                            <v-date-picker v-model="CouponItem.start_date" no-title scrollable>
                                <v-spacer></v-spacer>
                                <v-btn flat color="primary" @click="start_menu = false">Cancel</v-btn>
                                <v-btn flat color="primary" @click="$refs.start_menu.save(CouponItem.start_date)">OK</v-btn>
                            </v-date-picker>
                        </v-menu>
                    </v-flex>

                    <v-flex xs11 sm5>
                         <v-menu
                            ref="end_menu"
                            lazy
                            :close-on-content-click="false"
                            v-model="end_menu"
                            transition="scale-transition"
                            offset-y
                            full-width
                            :nudge-right="40"
                            min-width="290px"
                            :return-value.sync="CouponItem.end_date"
                        >
                            <v-text-field
                            slot="activator"
                            label="pick end Date"
                            v-model="CouponItem.end_date"
                            prepend-icon="event"
                            readonly
                            ></v-text-field>
                            <v-date-picker v-model="CouponItem.end_date" no-title scrollable>
                            <v-spacer></v-spacer>
                            <v-btn flat color="primary" @click="end_menu = false">Cancel</v-btn>
                            <v-btn flat color="primary" @click="$refs.end_menu.save(CouponItem.end_date)">OK</v-btn>
                            </v-date-picker>
                        </v-menu>

                        </v-flex>
                    </v-layout>
                </v-container>
                </v-card-text>
                <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" flat @click.native="dialog = false">Close</v-btn>
                <v-btn color="blue darken-1" flat @click.native="save">Save</v-btn>
                </v-card-actions>
            </v-card>
    </v-dialog>
    <v-data-table
      :headers="headers"
      :items="items"
      hide-actions
      class="elevation-1"
    >
      <template slot="items" slot-scope="props">
        <td>{{ props.index + 1 }}</td>
        <td>{{ props.item.CouponName }}</td>
        <td class="text-xs-right">{{ props.item.CouponType }}</td>
        <td class="text-xs-right">{{ props.item.start_date }}</td>
        <td class="text-xs-right">{{ props.item.end_date }}</td>
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
</v-app>
</template>

<script>
import VueAxios         from 'vue-axios';
import axios            from 'axios';


export default {
    data() {
        return {
            /* date picker */
            start_date: null,
            start_menu: false,
            modal: false,

            end_date: null,
            end_menu: false,

            /* table */
            dialog: false,
            headers: [
                {
                text: 'index',
                align: 'left',
                sortable: false,
                value: 'name'
                },
                { text: '쿠폰 이름', value: 'CouponName' },
                { text: '쿠폰 종류', value: 'CouponType' },
                { text: '사용 시작일', value: 'start_date' },
                { text: '사용 종료일', value: 'end_date' },
                { text: 'Actions', value: 'name', sortable: false }
            ],

            /* 저장 & 편집 & 삭제 */
            items: [],
            CouponIndex: -1,
            CouponItem: {
                CouponName: '',
                CouponType: '',
                Discount: null,
                addproduct: null,
                Condition: null,
                start_date: null,
                end_date: null
            },
            defaultItem: {
                CouponName: '',
                CouponType: '',
                Discount: null,
                addproduct: null,
                Condition: null,
                start_date: null,
                end_date: null

            }
        }
    },
    computed: {
      formTitle () {
        return this.CouponIndex === -1 ? '쿠폰 추가' : '쿠폰 변경'
      }
    },

    watch: {
      dialog (val) {
        val || this.close()
      }
    },

    methods: {
      editItem (item) {
        this.CouponIndex = this.items.indexOf(item)
        this.CouponItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {
        const index = this.items.indexOf(item)
        confirm('쿠폰을 삭제 하시겠습니까?') && this.items.splice(index, 1)
      },

      close () {
        this.dialog = false
        setTimeout(() => {
          this.CouponItem = Object.assign({}, this.defaultItem)
          this.CouponIndex = -1
        }, 300)
      },

      save () {
        if (this.CouponIndex > -1) {
          Object.assign(this.items[this.CouponIndex], this.CouponItem)

        } else {
          this.items.push(this.CouponItem)
        }
        
        /* Data 송신 */
          axios.post('/restaurant/createCoupon', {
            name                : this.CouponItem.CouponName,
            shop_id             : this.$route.params.shop_id,
            category            : this.CouponItem.CouponType,
            discount            : this.CouponItem.Discount,
            add_product         : this.CouponItem.addproduct,
            price_condition     : this.CouponItem.Condition,
            start_date          : this.CouponItem.start_date,
            expiry_date         : this.CouponItem.end_date
          }).then(function (response) {
              alert(response.data.content);
          });

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