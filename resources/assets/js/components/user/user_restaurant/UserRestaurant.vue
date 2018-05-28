<!--
    [ 가게 정보 페이지 ]
    가게 주인이 입력한 정보, 업로드한 이미지를 바탕으로 가게 페이지를 동적으로 제작함.
-->
<template>
    <div class="container">
        <v-app>
            <!-- 타이틀 이미지와 가게 명이 들어갈 div -->
            <div class="title_div">
                <div id="title_img">
                    <div id="name_area">
                        <b id="name"> </b>
                    </div>
                </div>
            </div>

            <!-- 가게 설명이 들어갈 div -->
            <div style="width:100%;">
                <div style=" float:left; display: flex" >
                    <b class='column'> 소개 </b>
                </div>

                <div style="float:right; margin-right:1%; display: flex">
                    <b id="totalRating" class='column' style="text-align: right;">방문객 평점 :</b>

                    <!-- 예약 하기 -->
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
                                        <div v-if="this.reservation_selectMenu == 1">
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
                                                            <v-btn flat @click="menuDialog = false">취소</v-btn>
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
                                                                    <b class="total"> 총 : {{click_menu.length}} 개 </b> <br>
                                                                    <b class="total"> 합계 : {{sum_price}} 円 </b>
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
                                <v-dialog v-model="dialog_ok" max-width="500px">
                                    <v-card>
                                        <v-card-title>
                                            <div>
                                                <div class="reservationCheck_title"><b>예약 확인</b></div>
                                                <hr>
                                                <div class="reservationCheck_main">
                                                    <B> 예약 날짜 : </B> {{this.start_date}}    <br>
                                                    <B> 예약 시간 : </B> {{this.pick_time}}     <br>
                                                    <B> 어른 인원 : </B> {{this.adult_person}}  <br>
                                                    <B> 아이 인원 : </B> {{this.child_person}}  <br>
                                                    <B> 요구 사항 : </B> {{this.message}}
                                                </div>
                                            </div>
                                        </v-card-title>
                                        <v-card-actions>
                                            <v-btn color="primary" flat @click.stop="dialog_ok=false, dialog = false" @click="SpendData(), res_Okey()">확인</v-btn>
                                            <v-btn color="primary" flat @click.native="dialog_ok = false, dialog = false">취소</v-btn>
                                        </v-card-actions>
                                    </v-card>
                                </v-dialog>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>

                    <!-- 쿠폰 다운 -->
                    <v-btn
                            small
                            color="cyan darken-1"
                            @click="dialog2 = true"
                            style="color:white"
                    ><B>쿠폰 다운</B></v-btn>
                    <v-dialog
                            v-model="dialog2"
                            fullscreen
                            hide-overlay
                    >
                        <v-card>
                            <v-toolbar card dark color="cyan darken-1">
                                <v-btn icon dark @click.native="dialog2 = false">
                                    <v-icon>close</v-icon>
                                </v-btn>
                                <v-toolbar-title></v-toolbar-title>
                                <v-spacer></v-spacer>
                            </v-toolbar>

                            <v-card-text>
                                <div class="CouponDownTitle"><B>쿠폰 다운 받기</B></div>
                                <hr>
                                <div class="CouponDownMain">
                                    <template v-for="(item, index) in items">
                                        <!-- 쿠폰 리스트 -->
                                        <v-list-tile :key="item.name" avatar ripple >
                                            <v-list-tile-content style="height:700px; padding-top:2%;padding-bottom:2%;">
                                                <v-list-tile-title>
                                                    <B> {{ item.name }} </B>
                                                </v-list-tile-title>
                                                <!-- 카테고리 -->
                                                <v-list-tile-sub-title class="text--primary">
                                                    {{ item.category }}
                                                </v-list-tile-sub-title>
                                                <v-list-tile-sub-title v-if="item.category == '상품 제공'">
                                                    {{item.price_condition}}이상일 경우, &nbsp; {{ item.add_product }} 제공
                                                </v-list-tile-sub-title>
                                                <v-list-tile-sub-title v-if="item.category == '가격 할인'">
                                                    {{item.price_condition}}이상일 경우, &nbsp; {{ item.discount }} 할인
                                                </v-list-tile-sub-title>
                                                <v-list-tile-sub-title>
                                                    [ {{ item.start_date }} ~ {{ item.expiry_date}} ]
                                                </v-list-tile-sub-title>
                                            </v-list-tile-content>
                                            <!-- 아이콘 -->
                                            <v-list-tile-action>
                                                <!-- 쿠폰 다운 -->
                                                <v-btn flat icon color="error" @click="Download(item)">
                                                    <v-icon>get_app</v-icon>
                                                </v-btn>
                                            </v-list-tile-action>
                                        </v-list-tile>
                                        <v-divider v-if="index + 1 < items.length" :key="index"></v-divider>
                                    </template>
                                </div>
                            </v-card-text>
                        </v-card>
                    </v-dialog>
                </div>
            </div>

            <div id="explanation" class="frame" style="padding:2%;"></div>

            <!-- 갤러리 이미지가 들어갈 div -->
            <b class='column'> 갤러리 </b>
            <div id="gallery_div" class="frame">
                <!-- 더보기 div 클릭 시 v-dialog 출력 -->
                <div id="moreImg" class="gallery" style="display:none">
                    <div class="gallery_img MoreImg_inner"
                         @click="PrtAllGalleryImg"
                         @click.stop="ShowMoreImg=true">더 보기</div>
                </div>

                <!-- 갤러리 이미지 더 보기. -->
                <v-dialog v-model="ShowMoreImg" width="95%" scrollable="">
                    <v-card>
                        <!-- 타이틀, x 버튼 -->
                        <v-card-title>
                            <h2 class="column" style="margin: auto"> Gallery </h2>
                            <v-btn icon style="float:right" @click="ShowMoreImg=false">
                                <v-icon large> clear </v-icon>
                            </v-btn>
                        </v-card-title>

                        <!-- 갤러리 이미지 출력 영역 -->
                        <v-flex xs12 id="prtAllImgs"></v-flex>
                    </v-card>
                </v-dialog>
            </div>

            <!-- 구글 맵스, 텍스트 주소가 출력 될 div -->
            <b class='column'> 주소 </b>
            <div class="frame">
                <div class="title_div" style="margin-top:1%; margin-bottom: 1%;">
                    <!-- 구글 맵스 -->
                    <div id="map"></div>
                </div>
                <div>
                    <b class='column'> 상세 주소 : </b>
                    <div id="dodobuken" class="resInfo" style="margin-right: 3px;"></div>
                    <div id="cities"    class="resInfo" style="margin-right: 3px;"></div>
                    <div id="address"   class="resInfo" style="margin-right: 3px;"></div>
                </div>
            </div>

            <!-- 요리 유형 출력 div -->
            <div class="frame_small">
                <span class="column"> <b>요리 유형</b> </span>
                <span id="type" class="column_value"> </span>
            </div>

            <!-- 좌석 수 출력 div -->
            <div class="frame_small">
                <span class="column"> <b>좌석 수</b> </span>
                <span id="seat_num" class="column_value"> </span>
            </div>

            <!-- 전화번호 출력 div -->
            <div class="frame_small">
                <span class="column"> <b>전화번호</b> </span>
                <span id="phone" class="column_value"> </span>
            </div>

            <!-- 이용 시간 출력 div -->
            <div class="frame_small">
                <div class="column"  style="float:left;"> <b>이용 시간</b> </div>
                <div class="column_value" style="float:left;">
                    <span class="timeInfo"> 런치 : </span>
                    <span class="timeInfo" id="lunch_open"> </span>
                    <span class="timeInfo" id="lunch_close"> ~ </span>
                    <span class="timeInfo" id="lunch_lo"> ( last order : </span> <span> ) </span> <br>

                    <span class="timeInfo" > 디너 : </span>
                    <span class="timeInfo" id="dinner_open"> </span>
                    <span class="timeInfo" id="dinner_close"> ~ </span>
                    <span class="timeInfo" id="dinner_lo"> ( last order : </span><span> ) </span>
                </div>
            </div>

            <!-- 결제 방식 출력 div -->
            <div class="frame_small">
                <span class="column"> <b>결제 방식</b> </span>
                <span id="payment" class="column_value"> </span>
            </div>

            <!-- 기타 정보 출력 div -->
            <div class="frame_small">
                <span class="column"> <b>이용 안내</b> </span>
                <span class="column_value">
                <span id="children"    class="resInfo"> 아이 동반 : </span>
                <span id="pet"         class="resInfo"> 애완 동물 동반 : </span>
                <span id="parking"     class="resInfo"> 주차 : </span>
                <span id="smoking"     class="resInfo"> 흡연 : </span>
                <span id="privateroom" class="resInfo"> 개인실 : </span>
            </span>
            </div>
        </v-app>
    </div>
</template>

<script type="text/javascript">
    import Vue      from 'vue';
    import VueAxios from 'vue-axios';
    import axios    from 'axios';
    // import * as VueGoogleMaps from 'vue2-google-maps';

    // 예약 하기
    import { EventBus } from '../user_menu/eventBus.js';
    import DefaultLayout1 from '../user_menu/MenuDefaultLayout1.vue';

    var layout = DefaultLayout1;     // 사장이 선택한 메뉴판 탬플릿
    var obj    = [];                 // 클릭한 배열 담기
    var check  = 0;                  // 클릭한 배열 index용 변수

    // // 구글 맵스 키 값
    // Vue.use(VueGoogleMaps, {
    //     load: {
    //         key: 'AIzaSyDeu-HoB1RsF5Vf0xjEvBwwCKodP8mkgWQ',
    //     }
    // });

    var restaurant_id = '';           // 유저(관광객)가 클릭한 식당의 아이디 값. 식당의 아이디 값으로 데이터를 요청함.
    var get_datas  = null;           // 요청한 데이터들이 담길 변수 JSON으로 받을 예정
    var url = '';

    export default{
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
                optionId : [],

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
                reservation_selectMenu : 1,

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
                ],

                /* 쿠폰 */
                translateTextDownDialog : false,
                dialog2: false,
                clickCouponid : null,
                clickCouponname : null,

                items: [
                    {
                        id : '1',
                        name : '안녕fsdfsd',
                        category : '상품 제공',
                        price_condition : '1000',
                        add_product : '제공',
                        start_date : '2018-03-02',
                        expiry_date : '2019-04-03'
                    },
                    {
                        id : '2',
                        name : 'd',
                        category : '가격 할인',
                        price_condition : '1000',
                        discount : '200',
                        start_date : '2018-03-02',
                        expiry_date : '2019-04-03'

                    }
                ],

                /* 갤러리 이미지 더 보기. */
                ShowMoreImg : false
            }
        },
        created() {
            // 값 보내기
            this.shop_id = this.$route.params.shop_id;
            url = '/restaurant/' + this.shop_id + '/getInfo';

            // url = '/restaurant/1/getInfo';

            axios.get(url)
                .then( (response) => {
                    get_datas = response.data.restaurant;

                    // get_datas = [
                    //     {
                    //         'name'          : 'Innovative Cuisine',
                    //         'type'          : '한식',
                    //         'explanation'   : "최고의 재료를 찾아내고 그 재료가 지닌 다양한 맛을 연구해 한식이 지낸 깊은 향과 숨은 맛을 전합니다. " +
                    //                             "최상의 식재료를 선별, 그에 걸맞는 신중한 조리를 통해 재료 본연의 맛을 극대화한 한식,"+
                    //                             "전통 한식 본연의 못브에 대한 셰프의 철학과 감성을 더해 궁극의 요리 예술로서 풀어낸 한식"+
                    //                             "저희는 매일 바뀌는 계절과 에너지의 흐름을 되짚어가며 한식의 성숙하고 자연스러운 맛을"+
                    //                             "오랜 시간의 노고가 스며든 정성스러운 손길로 표현합니다.",
                    //         'dodobuken'     : '도쿄 도',
                    //         'cities'        : '미나토 구',
                    //         'address'       : '아카사카 1-11-6',
                    //         'phone'         : '010-8991-8606',
                    //         'lunch_open'    : '11:30',
                    //         'lunch_close'   : '15:00',
                    //         'lunch_lo'      : '14:30',
                    //         'dinner_open'   : '17:30',
                    //         'dinner_close'  : '22:00',
                    //         'dinner_lo'     : '21:30',
                    //         'payment'       : '카드 결제 가능',
                    //         'seat_num'      : '70석',
                    //         'children'      : 'yes',
                    //         'pet'           : 'yes',
                    //         'parking'       : 'no',
                    //         'smoking'       : 'no',
                    //         'privateroom'   : 'no'
                    //     },
                    //     {
                    //         'totalrate'        : 4.7,
                    //     },
                    //     {
                    //         'filename' : "13_titleImg,jpeg",
                    //         'path' : '/images/13/'
                    //     },


                    //     {
                    //         'filename' : "13_galleryImg0,jpeg",
                    //         'path' : '/images/13/'
                    //     },

                    //     {
                    //         'filename' : "13_galleryImg1,jpeg",
                    //         'path' : '/images/13/'
                    //     },


                    //     {
                    //         'filename' : "13_galleryImg1,jpeg",
                    //         'path' : '/images/13/'
                    //     },
                    //     {
                    //         'filename' : "13_galleryImg1,jpeg",
                    //         'path' : '/images/13/'
                    //     },


                    //     {
                    //         'filename' : "13_galleryImg1,jpeg",
                    //         'path' : '/images/13/'
                    //     },

                    //     {
                    //         'filename' : "13_galleryImg1,jpeg",
                    //         'path' : '/images/13/'
                    //     },


                    //     {
                    //         'filename' : "13_galleryImg1,jpeg",
                    //         'path' : '/images/13/'
                    //     },
                    // ];

                    // 예약 하기
                    // 메뉴
                    EventBus.$on('select_menus', function(menu) {
                        obj.push( menu[check] ); check++;
                    });

                    // 예약하기
                    var set_time_data;
                    axios.post('/getReservationSettingList', {
                        'shop_id' : this.$route.params.shop_id
                    }).then((response) => {
                        /* 그 가게의 예약설정된 Data */
                        var reservationSettingData = response.data.settingData;

                        /* item안에 넣기 */
                        this.items = reservationSettingData;

                        /* 메뉴가 선택 가능한 가게인지 아닌지 */
                        this.reservation_selectMenu = response.data.menuSelectData[0].reservation_selectMenu;

                        /* 기본 가게 정보 */
                        this.lunch_open = this.resData[0].lunch_open;
                        this.lunch_close = this.resData[0].lunch_close;
                        this.dinner_open = this.resData[0].dinner_open;
                        this.dinner_close = this.resData[0].dinner_close;
                    })


                    axios.post('/getCouponList', {
                        'shop_id' : this.$route.params.shop_id
                    }).then((response) => {
                        // 쿠폰
                        var Coupondata = response.data.coupon;
                        this.items = Coupondata;
                    });


                    // 데이터 바인딩-기본정보
                    this.enter_data(get_datas[0]);

                    // 데이터 바인딩-평점
                    this.enter_data(get_datas[1]);

                    // 지도 생성
                    this.geoCoder(get_datas[0]);

                    // 타이틀 이미지 삽입
                    this.enter_title(get_datas[2]);

                    // 갤러리 이미지 출력
                    this.enter_galley();
                })
                .catch((ex)=>{
                    alert('왜 안대');
                })
        },

        components : {
            'Layout' : layout
        },

        methods : {
            // 각 공간에 해당 값들을 삽입함.
            enter_data : function(argArray){
                let iterator = Object.keys(argArray);

                for (let key of iterator){
                    if(document.getElementById(key) !== null){
                        let get_div = document.getElementById(key);

                        switch(argArray[key]){
                            case 1      : get_div.innerText += '가능';          break;
                            case 0      : get_div.innerText += '불가';          break;
                            case 'yes'  : get_div.innerText += '가능';          break;
                            case 'no'   : get_div.innerText += '불가';          break;
                            case null   : get_div.innerText += 0;               break;
                            default     : get_div.innerText += argArray[key];   break;
                        }
                    }
                }
            },

            // 타이틀 이미지 삽입하기
            enter_title : function(argImgArray){
                document.getElementById('title_img').style.backgroundImage
                    = "url(" + argImgArray.path + argImgArray.filename + ")";
            },

            // 갤러리에 이미지 추가하기.
            enter_galley : function(){
                let gallery_div = document.getElementById('gallery_div');

                // 넘어온 데이터 배열 갯수 : 0은 기본 데이터 , 1은 평점, 2는 타이틀 이미지
                let argNum = get_datas.length;

                // 등록된 이미지가 없으면 메세지 출력
                if(argNum -3 == 0) {
                    gallery_div.innerText = "등록된 이미지가 없습니다.";
                }
                // 등록된 이미지가 6개 이하.
                else if(argNum -3 < 7) {
                    for (let i=3; i < argNum; i++){
                        // div, img 생성
                        let createdDiv = document.createElement('div');
                        let createdImg = document.createElement('img');

                        // 생성한 div와 img에 css와 src를 추가함.
                        createdImg.src = get_datas[i].path + get_datas[i].filename;
                        createdImg.classList.add('gallery_img');
                        createdDiv.classList.add('gallery');

                        // 생성한 div와 img를 갤러리 div에 추가.
                        createdDiv.appendChild(createdImg);
                        gallery_div.prepend(createdDiv);
                    }
                }
                // 등록된 이미지가 6개 초과
                else {
                    // 더 보기 display none에서 block으로
                    let moreImg = document.getElementById('moreImg');
                    moreImg.style.display = 'block';

                    for (let i=3; i < 8; i++){
                        // div, img 생성
                        let createdDiv = document.createElement('div');
                        let createdImg = document.createElement('img');

                        // 생성한 div와 img에 css와 src를 추가함.
                        createdImg.src = get_datas[i].path + get_datas[i].filename;
                        createdImg.classList.add('gallery_img');
                        createdDiv.classList.add('gallery');

                        // 생성한 div와 img를 갤러리 div에 추가.
                        createdDiv.appendChild(createdImg);
                        gallery_div.prepend(createdDiv);
                    }

                }
            },

            // 모든 갤러리 이미지 출력
            PrtAllGalleryImg : function() {
                let prtAllImgs = document.getElementById('prtAllImgs');
                let argNum     = get_datas.length;

                for(let i=3; i < argNum; i++){
                    let outer = document.createElement('div');
                    let inner = document.createElement('img');

                    // 생성한 div와 img에 css와 src를 추가함.
                    inner.src = get_datas[i].path + get_datas[i].filename;
                    inner.classList.add('img-inner');
                    outer.classList.add('img-outer');

                    // 생성한 div와 img를 갤러리 div에 추가.
                    outer.appendChild(inner);
                    prtAllImgs.appendChild(outer);
                }
            },

            // 구글 맵스 설정하기.
            geoCoder : function (argAddress) {
                let map      = new google.maps.Map(document.getElementById('map'), {zoom: 18}); // 구글 맵스 생성
                let address  = argAddress.dodobuken +
                    argAddress.cities +
                    argAddress.address;                              // 사장이 입력한 주소 값 더하기
                let geocoder = new google.maps.Geocoder();                                      // 지오 코더

                // 지오 코드 실행 : 텍스트 주소로 해당 주소 경위도 구하기.
                geocoder.geocode( { 'address': address}, function(results, status) {
                    if (status == 'OK') {
                        map.setCenter(results[0].geometry.location);    // 지도 중앙 값 설정
                        let marker = new google.maps.Marker({           // 마크 설정
                            map: map,
                            position: results[0].geometry.location
                        });
                    } else {
                        alert('Geocode was not successful for the following reason: ' + status);
                    }
                });
            },

            // 예약하기
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


            res_Okey() {
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

                    this.optionArray[i]     = [];
                    this.optionselect[i]    = [];
                    this.optionId[i]        = [];
                    for(var j = 0; j < opNumMax; j++)
                    {
                        // 서브 옵션 개수
                        var supOption = this.click_menu[i].menu['subOpNum' + (j+1)];

                        // 옵션 이름 넣기
                        this.optionArray[i][j]  = [];
                        this.optionId[i][j]     = this.click_menu[i].menu['optionId' + (j+1)]
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
                    time           : this.pick_time,
                    message        : this.message,

                    // 메뉴
                    menulength  : this.menu.length,         // 메뉴 개수
                    menu_id     : this.menu,                // 선택한 메뉴가 있는 배열
                    option      : this.optionId,            // 옵션 Id
                    suboption   : this.optionselect,         // 서브 옵션
                    sum_price   : this.sum_price
                }).then((response) => {
                    alert(response.data.msg);
                }).catch(console.log('test '));
            },

            // ------ 쿠폰 ---------
            Download(item) {
                const index = this.items.indexOf(item);
                this.clickCouponid = this.items[index].id;

                /* Data 송신 -> 자신의 쿠폰함으로 담긴다*/
                axios.post('/userCouponCreate', {
                    // 쿠폰ID
                    id  :  this.clickCouponid
                }).then(console.log('success')).catch(console.log('test '));
            },
            Okey() {
                alert('쿠폰함에 쿠폰이 다운되었습니다.');
            }
        }
    };
</script>

<style>
    /* 모바일 */
    @media (max-width: 639px){
        html         { font-size: 10px; }
        #name        { font-size: 1.5rem; }
        #explanation {max-height: 200px; overflow: scroll;}
        .column      { font-size: 1.8rem; }
        .timeInfo    { font-size: 1.5rem; }
        .resInfo     { font-size: 1.5rem; }
        .gallery     { width: 48%; padding-bottom: 35%; }
        .img-outer   { width: 90%; padding-bottom: 60%; }

        /* 예약하기 */
        .total {
            padding-left: 5%;
            padding-right: 5%;
            padding-top: 10%;
            font-size: 17px;
        }

        .reservationCheck_title {
            font-size: 17px;
            padding-bottom: 1%;
        }
        .reservationCheck_main {
            padding-top: 1%;
            font-size: 15px;
        }

        /* 쿠폰 */
        .CouponDownTitle {
            font-size: 14px;
            text-align: center;
        }
        .CouponDownMain {
            font-size: 20px;
            text-align: center;
        }
    }
    /* 테블릿 */
    @media (min-width: 640px) and (max-width: 1023px){
        html         { font-size: 12px; }
        #name        { font-size: 2rem; }
        #explanation {max-height: 300px; overflow: scroll;}
        .column      { font-size: 2rem; }
        .timeInfo    { font-size: 1.5rem; }
        .resInfo     { font-size: 1.7rem; }
        .gallery     { width: 48%; padding-bottom: 35%; }
        .img-outer   { width: 90%; padding-bottom: 60%; }

        /* 예약하기 */
        .total {
            padding-left: 5%;
            padding-right: 5%;
            padding-top: 10%;
            font-size: 20px;
        }

        .reservationCheck_title {
            font-size: 20px;
            padding-bottom: 1%;
        }
        .reservationCheck_main {
            padding-top: 1%;
            font-size: 18px;
        }

        /* 쿠폰 */
        .CouponDownTitle {
            font-size: 20px;
            text-align: center;
        }
    }
    /* 데스트 탑 */
    @media (min-width: 1024px){
        html        { font-size: 15px; }
        #name       { font-size: 2rem; }
        .column     { font-size: 2rem; }
        .timeInfo   { font-size: 1.5rem; }
        .resInfo    { font-size: 1.7rem; }
        .gallery    { width: 31%; padding-bottom: 25%;}
        .img-outer  { width: 46%; padding-bottom: 40%;}

        /* 예약하기 */
        .total {
            padding-left: 5%;
            padding-right: 5%;
            padding-top: 10%;
            font-size: 20px;
        }

        .reservationCheck_title {
            font-size: 20px;
            padding-bottom: 1%;
        }
        .reservationCheck_main {
            padding-top: 1%;
            font-size: 18px;
        }

        /* 쿠폰 */
        .CouponDownTitle {
            font-size: 20px;
            text-align: center;
        }
    }

    /* 가게 설명, 갤러리, 주소 */
    .frame {
        width: 100%;
        border-top: 1px solid;
        font-size: 1.8rem;
        color: #848484;
        display:inline-block;
        margin-bottom: 5%;
    }

    /* 요리 유형, 좌석 수, 전화번호, 이용시간, 결제 방식, 이용안내 */
    .frame_small {
        width: 100%;
        height: auto;
        padding-top: 3%;
        padding-left: 1%;
        border-top: 1px solid #848484;
        margin-bottom: 3%;
        display:inline-block;
    }

    /* 가게 메인 이미지 */
    .title_div {
        width: 100%;
        height: 0;
        padding-bottom: 40%;
        margin-bottom: 5%;
        overflow: hidden;
        position: relative;
    }
    #title_img{
        top: 0;
        left: 0;
        width: 105%;
        height: 105%;
        background-size: 100% 100%;
        /* background-image: url('./test4.jpg'); */
        position: absolute;
        object-fit: cover;
    }

    /* 가게 명 */
    #name_area {
        top: 0;
        left: 0;
        padding:4px;
        opacity: 0.5;
        background: black;
        color: white;
        text-align: center;
        display:inline-block;
    }

    /*갤러리 관련.*/
    .gallery{
        height: 0;
        margin: 1%;
        border: 1px solid #D8D8D8;
        float: left;
        overflow: hidden;
        position: relative;
    }
    .gallery_img {
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        position: absolute;
        transition: all 0.3s ease-in-out;
    }
    /* 마우스 오버 시 이미지 확대 */
    .gallery_img:hover {
        transform:          scale(1.2);
        -o-transform:       scale(1.2);
        -ms-transform:      scale(1.2);
        -moz-transform:     scale(1.2);
        -webkit-transform:  scale(1.2);
    }
    /* 갤러리 이미지 더 보기 */
    .MoreImg_inner {
        font-size:2rem;
        padding-top: 25%;
        text-align:center;
    }
    #prtAllImgs {
        background-color: white;
        overflow: auto;
    }
    .img-outer {
        height: 0;
        margin: 1%;
        border: 1px solid #D8D8D8;
        float: left;
        overflow: hidden;
        position: relative;
    }
    .img-inner{
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        position: absolute;
    }

    /* 정보 칼럼 */
    .column{
        margin-right: 20px;
        color: #6E6E6E;
        text-align: left;
        position: relative;
        display:inline-block;
    }
    /* 정보 내용 */
    .column_value{
        font-size: 1.7rem;
        padding: 3px;
        position: relative;
    }

    /* 구글 맵스용 */
    #map {
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: 1px solid #6E6E6E;
        position: absolute;
    }
    /* 가게 정보 */
    .resInfo{
        margin-right: 10px;
        display:inline-block;
    }
</style>
