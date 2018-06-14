<template>
    <v-app>
        <div class="create_coupon">
            <br>
            <h3><B>쿠폰 추가</B></h3>
            원하는 쿠폰을 제작하여 등록할 수 있습니다.
            <hr><br>
            <v-dialog v-model="dialog" max-width="500px">
                <!-- 쿠폰 추가 버튼 -->
                <v-btn color="teal lighten-1" slot="activator" style="color:white">쿠폰 추가</v-btn>
                <v-card>
                    <v-toolbar color="teal lighten-1" style="height:20px">
                    </v-toolbar>

                    <!-- v-card title -->
                    <v-card-title>
                        <span class="headline"> <B> 쿠폰 추가 </B> </span>
                    </v-card-title>

                    <!-- v-card 본문 -->
                    <v-card-text>
                        <v-container grid-list-md>
                            <v-layout wrap>

                                <!-- 쿠폰 이름 -->
                                <v-flex xs12>
                                    <v-text-field label="쿠폰 이름" required v-model="CouponItem.CouponName"></v-text-field>
                                </v-flex>

                                <!-- 쿠폰 종류 -->
                                <v-flex xs12 sm6 md4>
                                    <v-select
                                            label="쿠폰 종류"
                                            required
                                            :items="['가격 할인', '상품 제공']"
                                            v-model="CouponItem.CouponType"
                                    ></v-select>
                                </v-flex>

                                <!-- 가격 할인 -->
                                <v-flex xs12 sm6 md4 v-if="CouponItem.CouponType == '가격 할인'">
                                    <v-text-field label="할인 가격" required v-model="CouponItem.Discount"></v-text-field>
                                </v-flex>

                                <!-- 상품 제공 -->
                                <v-flex xs12 sm6 md4 v-else-if="CouponItem.CouponType == '상품 제공'">
                                    <v-select
                                            label="상품 선택"
                                            required
                                            :items="AddProductSelect"
                                            v-model="CouponItem.add_product"
                                    ></v-select>
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
                        <v-btn color="error" flat @click.native="dialog = false">Close</v-btn>
                        <v-btn color="blue darken-1" flat @click.native="save()">Save</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>

            <v-data-table
                    :headers="headers"
                    :items="items"
                    hide-actions
                    class="createCouponTable"
            >
                <template slot="items" slot-scope="props">
                    <td>{{ props.item.name }}</td>
                    <td class="text-xs-left">{{ props.item.category }}</td>
                    <td class="text-xs-left">{{ props.item.discount }}</td>
                    <td class="text-xs-left">{{ props.item.menu_name }}</td>
                    <td class="text-xs-left">{{ props.item.price_condition }}</td>
                    <td class="text-xs-left">{{ props.item.start_date }}</td>
                    <td class="text-xs-left">{{ props.item.expiry_date }}</td>
                    <td class="justify-center layout px-0">
                        <v-btn icon class="mx-0" @click="deleteItem(props.item)">
                            <v-icon color="pink">delete</v-icon>
                        </v-btn>
                    </td>
                </template>
            </v-data-table>
        </div>

        <!-- error snackbar -->
        <v-snackbar
                :timeout="1000"
                v-model="createCoupon_snackbar"
                :top="'top'"
        >
            <v-icon dark>announcement</v-icon> {{ createCoupon_text }}
        </v-snackbar>
    </v-app>
</template>

<script>
    import VueAxios         from 'vue-axios';
    import axios            from 'axios';
    export default {
        data() {
            return {
                /* snackbar */
                createCoupon_snackbar : false,
                createCoupon_text : '쿠폰 이름을 입력해 주세요',

                /* date picker */
                start_date: null,
                start_menu: false,
                modal: false,
                end_date: null,
                end_menu: false,
                clickCouponid: 0,

                /* table */
                dialog: false,
                headers: [
                    { text: '쿠폰 이름',    value: 'name' },
                    { text: '쿠폰 종류',    value: 'category' },
                    { text: '할인율',       value: 'discount' },
                    { text: '제공 상품',    value: 'menu_name' },
                    { text: '쿠폰 조건',    value: 'price_condition' },
                    { text: '사용 시작일',  value: 'start_date' },
                    { text: '사용 종료일',  value: 'end_date' },
                    { text: 'Actions',     value: 'name',           sortable: false }
                ],
                /* 저장 & 편집 & 삭제 */
                items: [],
                /* 메뉴 선택 */
                AddProductSelect : [],
                menu_id : 0,
                menuDataList : [],
                CouponItem: {
                    name: '',
                    category: '',
                    discount: null,
                    add_product: null,
                    price_condition: null,
                    start_date: null,
                    expiry_date: null
                }
            }
        },
        /* 데이터 값 받기 */
        created: function () {
            axios.post('/owner/getCouponList', {
                'shop_id' : this.$route.params.shop_id
            }).then((response) => {
                /* DB Coupon Data */
                var Index       = response.data.couponNum;
                this.items      = response.data.coupon;
                /* menu_data */
                var menuData    = response.data.menuList;
                this.menuDataList = menuData;
                this.menu_data_product();
            })
        },
        methods: {
            menu_data_product() {
                // 0: id / name
                for(var i = 0; i < this.menuDataList.length; i++)
                {
                    this.AddProductSelect.push(this.menuDataList[i].name);
                }
            },
            deleteItem (item) {
                const index = this.items.indexOf(item);
                this.clickCouponid = this.items[index].id;

                axios.post('/owner/deleteCoupon', {
                    'coupon_id'         : this.clickCouponid
                }).then((response) => {
                    location.reload();
                })
                    .catch(console.log('test'));
            },

            save() {
                /* 유효성 검사 */
                if(this.CouponItem.CouponName == null)
                {
                    this.createCoupon_snackbar = true;
                }
                else if(this.CouponItem.CouponType == null){
                    this.createCoupon_text = " 쿠폰 종류를 선택하세요. "
                    this.createCoupon_snackbar = true;
                }
                else if(this.CouponItem.CouponType == "가격 할인" && this.CouponItem.Discount == null){
                    this.createCoupon_text = " 할인 가격을 입력하세요. "
                    this.createCoupon_snackbar = true;
                }
                else if(this.CouponItem.CouponType == "상품 제공" && this.CouponItem.add_product == null){
                    this.createCoupon_text = " 제공 상품을 선택하세요."
                    this.createCoupon_snackbar = true;
                }
                else if(this.CouponItem.Condition == null){
                    this.createCoupon_text = " 쿠폰 조건을 입력하세요. "
                    this.createCoupon_snackbar = true;
                }
                else if( this.CouponItem.start_date == null || this.CouponItem.end_date == null) {
                    this.createCoupon_text = "날짜를 선택해 주세요"
                }
                else{
                    /* 메뉴id 찾기 */
                    for(var i = 0; i < this.menuDataList.length; i++)
                    {
                        if(this.CouponItem.add_product == this.menuDataList[i].name)
                        {
                            this.menu_id = this.menuDataList[i].id;
                            break;
                        }
                    }
                    /* Data 송신 */
                    axios.post('/owner/createCoupon', {
                        name                : this.CouponItem.CouponName,
                        shop_id             : this.$route.params.shop_id,
                        category            : this.CouponItem.CouponType,
                        discount            : this.CouponItem.Discount,
                        add_product         : this.menu_id,
                        price_condition     : this.CouponItem.Condition,
                        start_date          : this.CouponItem.start_date,
                        expiry_date         : this.CouponItem.end_date,
                    }).then((response) => {
                        this.dialog = false
                        location.reload();
                    })
                        .catch(console.log('test'));
                }
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