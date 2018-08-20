<template>
    <v-app>
        <div class="create_coupon">

            <br>
            <h2 class="Main_title"><B>クーポン追加</B></h2>
            <span class="sub_title"><B> クーポンを制作して登録できます。 </B></span>
            <hr class="Main_title"><br>

            <v-dialog v-model="dialog" max-width="500px" >
                <!-- 쿠폰 추가 버튼 -->
                <v-btn slot="activator"
                       style="color:white; background-color:#ff9a55">
                    クーポン追加
                </v-btn>
                <v-card class="card_color"
                        style="border: 10px solid #efe2bd; ">
                    <!-- v-card 본문 -->
                    <v-card-title>
                        <span  class="Main_title" style="margin:auto"> &nbsp;  <h3><B> <v-icon large> restaurant_menu </v-icon> &nbsp;　クーポン追加 </B></h3> </span>
                    </v-card-title>
                    <v-card-text>
                        <v-container grid-list-md>
                            <v-layout wrap>

                                <!-- 쿠폰 이름 -->
                                <v-flex xs12>
                                    <v-text-field
                                            label="クーポン名"
                                            required
                                            v-model="CouponItem.CouponName"
                                            color="orange darken-1"
                                    ></v-text-field>
                                </v-flex>

                                <!-- 쿠폰 종류 -->
                                <v-flex xs12 sm6 md4>
                                    <v-select
                                            label="クーポン種類"
                                            required
                                            :items="['価格割引', '商品提供']"
                                            v-model="CouponItem.CouponType"
                                            color="orange darken-1"
                                    ></v-select>
                                </v-flex>

                                <!-- 가격 할인 -->
                                <v-flex xs12 sm6 md4 v-if="CouponItem.CouponType == '価格割引'">
                                    <v-text-field
                                            label="割引"
                                            required
                                            v-model="CouponItem.Discount"
                                            color="orange darken-1"
                                    ></v-text-field>
                                </v-flex>

                                <!-- 상품 제공 -->
                                <v-flex xs12 sm6 md4 v-else-if="CouponItem.CouponType == '商品提供'">
                                    <v-select
                                            label="商品選択"
                                            required
                                            :items="AddProductSelect"
                                            v-model="CouponItem.add_product"
                                            color="orange darken-1"
                                    ></v-select>
                                </v-flex>
                                <v-flex xs12>
                                    <v-text-field
                                            label="クーポン条件"
                                            required
                                            v-model="CouponItem.Condition"
                                            color="orange darken-1"
                                    ></v-text-field>
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
                                                label="クーポン使用期間＿初め"
                                                v-model="CouponItem.start_date"
                                                prepend-icon="event"
                                                readonly
                                                color="orange darken-1"

                                        ></v-text-field>

                                        <v-date-picker
                                                v-model="CouponItem.start_date"
                                                no-title
                                                scrollable
                                                color="orange darken-1"
                                        >
                                            <v-spacer></v-spacer>
                                            <v-btn flat style="color:#ff9a55" @click="start_menu = false">キャンセル</v-btn>
                                            <v-btn flat style="color:#ff9a55" @click="$refs.start_menu.save(CouponItem.start_date)">確認</v-btn>
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
                                                label="クーポン使用期間＿終了"
                                                v-model="CouponItem.end_date"
                                                prepend-icon="event"
                                                color="orange darken-1"
                                                readonly
                                        ></v-text-field>
                                        <v-date-picker
                                                v-model="CouponItem.end_date"
                                                no-title
                                                scrollable
                                                color="orange darken-1"
                                        >
                                            <v-spacer></v-spacer>
                                            <v-btn flat style="color:#ff9a55" @click="end_menu = false">キャンセル</v-btn>
                                            <v-btn flat style="color:#ff9a55" @click="$refs.end_menu.save(CouponItem.end_date)">確認</v-btn>
                                        </v-date-picker>
                                    </v-menu>
                                </v-flex>
                                <v-spacer></v-spacer>
                            </v-layout>

                            <!-- 쿠폰 갯수 (개수제한) -->
                            <v-flex>
                                <v-checkbox :label="'発行数設定'"
                                            v-model="coupon_count"
                                            color="orange darken-1"
                                ></v-checkbox>
                                <div v-if="coupon_count == true">
                                    <v-text-field label="発行数"
                                                  required
                                                  v-model="CouponItem.count"
                                                  color="orange darken-1"
                                    ></v-text-field>
                                </div>
                            </v-flex>
                        </v-container>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn style="color:white; background-color:#6d4d35" @click.native="dialog = false">Close</v-btn>
                        <v-btn style="color:white; background-color:#ff9a55"  @click.native="save()">Save</v-btn>
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
                    <td class="text-xs-left">{{ props.item.discount_product }}</td>
                    <td class="text-xs-left">{{ props.item.price_condition }}</td>
                    <td class="text-xs-left">{{ props.item.start_date }}</td>
                    <td class="text-xs-left">{{ props.item.expiry_date }}</td>
                    <td class="text-xs-left">{{ props.item.coupon_count }}</td>
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
                createCoupon_text : 'クーポンの名前を入力してください',

                /* date picker */
                start_date: null,
                start_menu: false,
                modal: false,
                end_date: null,
                end_menu: false,
                clickCouponid: 0,

                /* coupont count */
                coupon_count : false,

                /* table */
                dialog: false,
                headers: [
                    { text: 'クーポン名',    value: 'name' },
                    { text: 'クーポン種類',    value: 'category' },
                    { text: ' ',           value: 'discount_product' },
                    { text: 'クーポン条件',    value: 'price_condition' },
                    { text: '使用初め',  value: 'start_date' },
                    { text: '使用終了',  value: 'expiry_date' },
                    { text: '発行数',    value: 'coupon_count'},
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
                    expiry_date: null,
                    count : 0
                }
            }
        },
        /* 데이터 값 받기 */
        created: function () {
            axios.post('/owner/getCouponList', {
                'shop_id' : this.$route.params.shop_id
            }).then((response) => {
                /* DB Coupon Data */
                var CouponData     = response.data.coupon;
                var CouponArray = [];

                // 넣기
                for(var i = 0; i < CouponData.length; i++)
                {
                    CouponArray[i] = [];
                    CouponArray[i]['coupon_id']       = CouponData[i].id;
                    CouponArray[i]['name']       = CouponData[i].name;
                    CouponArray[i]['category']   = CouponData[i].category;
                    if(CouponData[i].category == '価格割引')
                    {
                        CouponArray[i]['discount_product'] = CouponData[i].discount;
                    }
                    else if(CouponData[i].category == '商品提供'){
                        CouponArray[i]['discount_product'] = CouponData[i].menu_name;
                    }
                    CouponArray[i]['price_condition'] = CouponData[i].price_condition;
                    CouponArray[i]['start_date']      = CouponData[i].start_date;
                    CouponArray[i]['expiry_date']        = CouponData[i].expiry_date;
                    // 쿠폰 개수
                    CouponArray[i]['coupon_count']           = CouponData[i].coupon_count;
                }

                this.items = CouponArray;

                /* menu_data */
                var menuData        = response.data.menuList;
                this.menuDataList   = menuData;
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
                this.clickCouponid = this.items[index].coupon_id;

                axios.post('/owner/deleteCoupon', {
                    'coupon_id'         : this.clickCouponid
                }).then((response) => {
                    // location.reload();
                })
                    .catch(console.log('test'));
            },

            save() {
                var check = true;

                /* 유효성 검사 */
                if(this.CouponItem.CouponName == null)
                {
                    this.createCoupon_snackbar = true;
                    check = false;
                }
                else if(this.CouponItem.CouponType == null){
                    this.createCoupon_text = " クーポン種類を選択してください。";
                    this.createCoupon_snackbar = true;
                    check = false;
                }
                else if(this.CouponItem.CouponType == "가격 할인" && this.CouponItem.Discount == null){
                    this.createCoupon_text = " 割引価格を入力してください。";
                    this.createCoupon_snackbar = true;
                    check = false;

                }
                else if(this.CouponItem.CouponType == "가격 할인" && this.CouponItem.Discount != null)
                {
                    // 숫자만 가능
                    var regNumber = /^[0-9]*$/;

                    if(!regNumber.test(this.CouponItem.Discount)) {
                        this.createCoupon_text = "割引価格の項目は数字だけ記入してください。";
                        this.createCoupon_snackbar = true;
                        check = false;
                    }

                }
                else if(this.CouponItem.CouponType == "상품 제공" && this.CouponItem.add_product == null){
                    this.createCoupon_text = " 提供商品を選択してください。";
                    this.createCoupon_snackbar = true;
                    check = false;
                }
                else if(this.CouponItem.Condition == null){
                    this.createCoupon_text = " クーポン条件を入力してください。";
                    this.createCoupon_snackbar = true;
                    check = false;
                }
                else if( this.CouponItem.start_date == null || this.CouponItem.end_date == null) {
                    this.createCoupon_text = "使用期間を選択してください。";
                    this.createCoupon_snackbar = true;
                    check = false;
                }
                else if( this.CouponItem.count != null)
                {
                    // 숫자만 가능
                    var regNumber = /^[0-9]*$/;

                    if(!regNumber.test(this.CouponItem.count)) {
                        this.createCoupon_text = "　発行数設定の項目は数字だけ記入してください。";
                        this.createCoupon_snackbar = true;
                        check = false;
                    }
                }

                if(check == true)
                {
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
                        count               : this.CouponItem.count
                    }).then((response) => {
                        location.reload();
                    })
                        .catch(console.log('test'));

                    this.dialog = false;
                }
            }
        }
    }
</script>
<style>
    .Main_title {
        color: #6d4d35;
    }

    .sub_title {
        color : #9d724b;
    }

    .create_coupon {
        padding-left: 4%;
        padding-right: 3%;
    }
</style>