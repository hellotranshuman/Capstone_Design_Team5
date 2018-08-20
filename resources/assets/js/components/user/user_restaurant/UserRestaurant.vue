<!--
    [ 가게 정보 페이지 ]
    가게 주인이 입력한 정보, 업로드한 이미지를 바탕으로 가게 페이지를 동적으로 제작함.
-->
<template>
<v-app style="margin:1%;">
    <!--스낵바 : 경고 창 출력-->
    <v-snackbar 
        v-model="snackbar"
        :timeout="timeout" 
        :top="'top'" 
    >
        {{ snackbar_text }}

        <v-btn 
            @click.native="snackbar = false"
            color="pink"
            flat icon 
        >
            <v-icon large> close </v-icon>
        </v-btn>
    </v-snackbar> 

    <!-- 예약 하기 모달 창 --> 
    <v-dialog v-model="dialog" max-width="500px" persistent>
        <v-card style="border: 10px solid #E7D7B7;">
            <!-- v-card title -->
            <v-card-title>
                <span style="margin: auto"> 
                    <h2>
                        <b style="color:#6d4d35">
                            <v-icon large> alarm </v-icon>
                            {{trans_reservation_text}}
                        </b>
                    </h2>
                </span>
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
                                :label="trans_reservation_date"
                                v-model="start_date"
                                prepend-icon="event"
                                readonly
                                color="brown"
                             ></v-text-field>

                                <!-- 예약 날짜 -->
                                <v-date-picker 
                                    v-model="start_date" 
                                    no-title 
                                    scrollable 
                                    :allowed-dates="allowedDates"
                                    color="brown"
                                >
                                    <v-spacer></v-spacer>

                                    <v-btn 
                                        flat color="brown"
                                        @click.stop="reservation_menu = false"
                                    >
                                        Cancel
                                    </v-btn>

                                    <v-btn 
                                        flat
                                        color="brown"
                                        @click="$refs.reservation_menu.save(start_date), setTime()"
                                    >
                                        OK
                                    </v-btn>
                                </v-date-picker>
                            </v-menu>
                        </v-flex>
                        <v-flex xs12 sm6 md4>
                            <!-- 예약 시간 -->
                            <v-select
                                :items="states"
                                v-model="pick_time"
                                :label="trans_reservation_time"
                                single-line
                                color="brown"
                            ></v-select>
                        </v-flex>
                        <!-- 인원수 -->
                        <v-flex xs12 sm6 md4>
                            <v-text-field 
                                :label="trans_reservation_person" 
                                v-model="adult_person"
                                required
                                color="brown"
                            ></v-text-field>
                        </v-flex>

                        <v-flex xs12 sm6 md4>
                            <v-text-field 
                                :label="trans_reservation_child" 
                                v-model="child_person"
                                required
                                color="brown"
                            ></v-text-field>
                        </v-flex>

                        <!-- 메뉴 선택 (1:true)-->
                        <div v-if="this.reservation_selectMenu == 1">
                            <B style="color:#6d4d35"> {{trans_reservation_check}} </B><br>
                            <v-btn color="brown" style="color:white" @click="menuDialog = true"> 
                                {{trans_menu_select}} 
                            </v-btn>

                            <!-- 메뉴판 -->
                            <v-dialog v-model="menuDialog">
                                <v-stepper v-model="Menu_Order" style="background-color:#efe2bd">
                                    <!-- Header -->
                                    <v-stepper-header>
                                        <!-- 1. 메뉴선택 -->
                                        <v-stepper-step step="1" :complete="Menu_Order > 1">
                                            {{trans_menu_select}}
                                        </v-stepper-step>
                                        <v-divider></v-divider>

                                        <!-- 2. 메뉴 확인 -->
                                        <v-stepper-step step="2" :complete="Menu_Order > 2">
                                            {{trans_menu_check}}
                                        </v-stepper-step>
                                        <v-divider></v-divider>
                                    </v-stepper-header>

                                    <!-- Main -->
                                    <v-stepper-items>
                                        <!-- 1. 메뉴선택 -->
                                        <v-stepper-content step="1" color="error">
                                            <v-card 
                                                color="white lighten-1" 
                                                class="mb-5" 
                                                style="overflow:hidden"
                                            >
                                                <Layout></Layout>
                                            </v-card>

                                            <!-- btn -->
                                            <v-btn 
                                                style="background-color:#ff9a55; color:white"
                                                @click="order_menu"
                                                @click.native="Menu_Order = 2"
                                            >
                                                OK
                                            </v-btn>
                                            <v-btn flat @click="menuDialog = false"> Cancel </v-btn>
                                        </v-stepper-content>

                                        <!-- 2. 메뉴 확인  height="200px" -->
                                        <v-stepper-content step="2">
                                            <v-card color="white lighten-1" class="mb-5" >
                                                <v-container :id="'menu_check_container'">
                                                    <v-layout 
                                                        v-for="i in range(0, click_menu.length-1)" 
                                                        :key="i"
                                                        :id="'menu_layout'+i"  
                                                        mb-3
                                                    >
                                                        <v-flex sm12>
                                                            <v-card elevation-20>
                                                                <v-card-text style="font-size:1.2rem">
                                                                    <div>
                                                                        <b> {{trans_menu_name}} : {{click_menu[i].menu.name}} </b>
                                                                        <v-btn 
                                                                            style="float : right"
                                                                            @click="click_cancel"
                                                                            :id="i" icon
                                                                        >
                                                                            <v-icon dark> close </v-icon>
                                                                        </v-btn> <br>

                                                                        <b> {{trans_menu_price}} : {{click_menu[i].menu.price}} </b> <br>

                                                                        <!-- 옵션 선택 -->
                                                                        <v-flex xs6 v-if="click_menu[i].menu.opNum != 0">
                                                                            <b> [ Option ] </b> 
                                                                            <br>
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
                                                    <b class="total"> 
                                                        {{click_menu.length}} 点 
                                                    </b> 
                                                    <br>

                                                    <b class="total"> 
                                                        {{trans_sum}} : {{sum_price}} 円 
                                                    </b>
                                                </v-card>
                                            </v-flex>
                                            <!-- btn -->
                                            <v-btn 
                                                 style="background-color:#ff9a55; color:white"
                                                @click="OrderMenu()"
                                                @click.native="Menu_Order = 2" 
                                            >
                                                {{trans_menu_select}}
                                            </v-btn>
                                            <v-btn flat @click.native="Menu_Order = 1">Cancel</v-btn>
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
                            :label="trans_reservation_message"
                            required
                            color="brown"
                        ></v-text-field>
                    </v-flex>
                </v-container>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                 <v-btn style="color: white; background-color: #ff9a55;" @click.stop="SpendData()">{{trans_reservation_text}}</v-btn>
                <v-btn style="color: white; background-color: #6d4d35" @click.native="dialog = false">Cancel</v-btn>
               

                <!-- 확인 버튼
                <v-dialog   
                    v-model="dialog_ok" 
                    max-width="500px" 
                    style="background-color:#E2C189;"
                    class="text-xs-center"            
                >
                    <v-card style="border: 10px solid #E7D7B7;" class="text-xs-center">
                        <v-card-title>
                            <div>
                                <div class="reservationCheck_title">
                                    <b>{{trans_reservation_recheck}}</b>
                                </div>
                                <br>
                                <div class="reservationCheck_main">
                                    <B style="color:#6d4d35"> {{trans_reservation_date}} : </B> {{this.start_date}}    <br>
                                    <B style="color:#6d4d35"> {{trans_reservation_time}} : </B> {{this.pick_time}}     <br>
                                    <B style="color:#6d4d35"> {{trans_reservation_person}} : </B> {{this.adult_person}}  <br>
                                    <B style="color:#6d4d35"> {{trans_reservation_child}} : </B> {{this.child_person}}  <br>
                                    <B style="color:#6d4d35"> {{trans_reservation_message}} : </B> {{this.message}}
                                </div>
                            </div>
                        </v-card-title>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn 
                                @click="SpendData()" 
                                @click.stop="dialog_ok=false, dialog = false" 
                                 style="color:#ff9255" flat
                            >
                                OK
                            </v-btn>

                            <v-btn 
                                @click.native="dialog_ok = false, dialog = false"
                                style="color:#9d724b" flat
                            >
                                Cancel
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog> -->
            </v-card-actions>
        </v-card>
    </v-dialog>

    <!-- 쿠폰 다운 모달 창 -->
    <v-dialog
        v-model="dialog2"
        fullscreen
        hide-overlay >
        
        <v-card>
            <v-toolbar card style="background-color:#E2C189">
                <v-btn icon dark @click.native="dialog2 = false">
                    <v-icon>close</v-icon>
                </v-btn>
                <v-toolbar-title></v-toolbar-title>
                <v-spacer></v-spacer>
            </v-toolbar>

            <v-card-text>
                <div style="margin-left:5%; margin-right:5%">
                <div class="CouponDownTitle">
                    <h2 style="color:#6d4d35">
                        <B>{{trans_coupon_down_text}}</B>
                    </h2>
                </div>
                <hr>

                <div class="CouponDownMain" style="color:#9d724b">
                    <template v-for="(item, index) in coupon_items">
                        <!-- 쿠폰 리스트 -->
                        <v-list-tile :key="item.name" avatar ripple >
                            <v-list-tile-content style="height:700px;">
                                <v-list-tile-title style="color:#6d4d35">
                                    <B> {{ item.name }} </B>
                                </v-list-tile-title>

                                <!-- 카테고리 -->
                                <v-list-tile-sub-title v-if="item.category == '商品提供'">
                                    {{item.price_condition}} {{trans_baai}}, &nbsp; {{ item.menu_name }} {{trans_product}}
                                    [ {{ item.start_date }} ~ {{ item.expiry_date}} ]
                                    &nbsp; &nbsp;
                                    {{trans_coupon_count}} : {{ item.use_check }}
                                    <span v-if="item.coupon_count != null"> {{trans_coupon_count}} : {{ item.coupon_count }} </span>
                                </v-list-tile-sub-title>

                                <v-list-tile-sub-title v-if="item.category == '価格割引'">
                                    {{item.price_condition}} {{trans_baai}}, &nbsp; {{ item.discount }} {{trans_discount}}
                                    [ {{ item.start_date }} ~ {{ item.expiry_date}} ]
                                    &nbsp; &nbsp;
                                    <span v-if="item.coupon_count != null"> {{trans_coupon_count}} : {{ item.coupon_count }} </span>
                                </v-list-tile-sub-title>
                            </v-list-tile-content>

                            <!-- 아이콘 -->
                            <v-list-tile-action>
                                <!-- 쿠폰 다운 -->
                                <v-btn 
                                    flat icon 
                                    color="error"
                                    @click="Download(item)"  
                                    @click.native="coupon_snackbar = true"
                                >
                                    <v-icon>get_app</v-icon>
                                </v-btn>
                            </v-list-tile-action>
                        </v-list-tile>
                        <v-divider v-if="index + 1 < coupon_items.length" :key="index"></v-divider>
                    </template>
                </div>
                </div>
            </v-card-text>
        </v-card>
    </v-dialog>

    <!-- 타이틀 -->
    <div class="title_div">    
        <!-- 그라데이션 -->
        <div id="title_gra"></div>  
            
        <div id="title_inner">           
            <div class="title_contents_div" style="height:60%;">    
                <!-- 식당 이름 -->            
                <b id="name" style="margin-left:0.5%"></b> 

                <hr v-if="browser_state=='com'"   style="background-color:#ff9a55; border:4px solid #ff9a55;">  
                <hr v-if="browser_state=='phone'" style="background-color:#ff9a55; border:2px solid #ff9a55;">  

                <!-- 식당 이름 로마자 -->            
                <b id="namer" style="margin-left:10px"></b> 
            </div>      
            
            <!-- 식당 평점 star star_border star_half -->
            <v-layout 
                class="title_contents_div" 
                style= "height:40%;
                        margin-top:0.5%; 
                        margin-bottom:1%;"
            >
                <v-flex xs8 v-if="browser_state=='com'">
                    <b id="totalRating" style="font-size:3rem;"> </b>

                    <span id="prtStar">
                        <v-icon x-large color="yellow darken-3"> star_border </v-icon>
                        <v-icon x-large color="yellow darken-3"> star_border </v-icon>
                        <v-icon x-large color="yellow darken-3"> star_border </v-icon>
                        <v-icon x-large color="yellow darken-3"> star_border </v-icon>
                        <v-icon x-large color="yellow darken-3"> star_border </v-icon>
                    </span> 
                </v-flex>

                <v-flex xs6 v-if="browser_state=='phone'">
                    <b id="totalRating" style="font-size:1.2rem;"> </b>

                    <span id="prtStar">
                        <v-icon small color="yellow darken-3"> star_border </v-icon>
                        <v-icon small color="yellow darken-3"> star_border </v-icon>
                        <v-icon small color="yellow darken-3"> star_border </v-icon>
                        <v-icon small color="yellow darken-3"> star_border </v-icon>
                        <v-icon small color="yellow darken-3"> star_border </v-icon>
                    </span> 
                </v-flex>

                <v-spacer></v-spacer>

                <!-- 좋아요 - 데스크탑 favorite_border favorite -->
                <v-flex xs2 v-if="browser_state=='com'">
                    <button                         
                        id="LikeIt" 
                        @click="I_Like_It" 
                        class="btns" 
                        style="width:100%; font-size:1.5rem; border: 2px solid white; color:white;"                 
                    >                                  
                        <v-icon id="LikeIcon" large color="red"> favorite_border </v-icon>
                    </button>
                </v-flex>
                
                <!-- 좋아요 - 폰 -->
                <v-flex xs4 v-if="browser_state=='phone'">                  
                     <div                         
                        id="LikeIt" 
                        @click="I_Like_It" 
                        class="btns"    
                        style="width:90%; border:2px solid white; color: white"
                    >                                 
                        <v-icon id="LikeIcon" small color="red"> favorite_border </v-icon>
                    </div>
                </v-flex>
            </v-layout>
        </div>
        
        <!-- 타이틀 이미지 src="./image.jpg"-->
        <img id="title_img">
    </div>

    <div style="width:100%; padding:2%;">
        <v-layout>
            <!-- 식당 소개 -->
            <v-flex lg8 xs12 mr-3>
                <b class='column_title'> {{resExplanation}} </b>
                <div 
                    class= "frame explanation-outer" 
                    style= "height:0;
                            padding-bottom:30%; 
                            overflow:hidden; 
                            position:relative;"
                    >
                    <div id= "explanation"></div>
                </div>
            </v-flex>

            <!-- 전화번호/주소/쿠폰다운/예약 : 데스크탑 -->
            <v-flex xs4 v-if="browser_state=='com'">
                <!-- 전화번호 출력 -->
                <div class="column_title"> 
                    <b style="font-size:1.5rem;"> {{resPhone}} </b> 
                </div>
                <div class="frame_small">
                    <span id="phone" class="addressInfo"> </span>
                </div>

                <!-- 주소 출력 -->
                <div class="column_title"> 
                    <b style="font-size:1.5rem;"> {{resAddress}} </b>
                </div>
                <div class="frame_small">
                    <span id="dodobuken" class="addressInfo" style="margin-right: 3px;"></span>
                    <span id="cities"    class="addressInfo" style="margin-right: 3px;"></span>
                    <span id="address"   class="addressInfo" style="margin-right: 3px;"></span>
                </div>

                <v-layout mt-5>           
                    <!-- 쿠폰 다운 -->
                    <v-flex xs5 mr-3> 
                        <v-btn 
                            style="background-color:#E2C189;"  
                            @click="dialog2 = true" 
                            class="btns" 
                            block
                        >
                            <v-icon large> restaurant_menu </v-icon> &nbsp; {{trans_coupon_down_text}}
                        </v-btn>  
                    </v-flex>
        
                    <!-- 예약 하기 -->               
                    <v-flex xs5>          
                        <v-btn 
                            style="background-color:#E7D7B7;"  
                            @click="dialog=true" 
                            class="btns" 
                            block 
                        >
                            <v-icon large> alarm </v-icon> &nbsp; {{trans_reservation_text}}
                        </v-btn>
                    </v-flex> 
                </v-layout>       
            </v-flex>
        </v-layout>

        <!-- 전화번호/주소/쿠폰다운/예약 : 폰 -->
        <v-layout>
            <v-flex xs12 v-if="browser_state=='phone'">
                <!-- 전화번호 출력 div -->
                <div class="column_title"> 
                    <b style="font-size:1.5rem;"> {{resPhone}} </b> 
                </div>
                <div class="frame_small">
                    <span id="phone" class="addressInfo"> </span>
                </div>

                <!-- 주소 출력 div -->
                <div class="column_title"> 
                    <b style="font-size:1.5rem;"> {{resAddress}} </b>
                </div>
                <div class="frame_small">
                    <span id="dodobuken" class="addressInfo" style="margin-right: 3px;"></span>
                    <span id="cities"    class="addressInfo" style="margin-right: 3px;"></span>
                    <span id="address"   class="addressInfo" style="margin-right: 3px;"></span>
                </div>

                <v-layout mb-5>           
                    <!-- 쿠폰 다운 -->
                    <v-flex xs5 mr-3> 
                        <v-btn 
                            style="background-color:#E2C189;"  
                            @click="dialog2 = true" 
                            class="btns" 
                            block
                        >
                            <v-icon large> restaurant_menu </v-icon> &nbsp; {{trans_coupon_down_text}}
                        </v-btn>  
                    </v-flex>
        
                    <!-- 예약 하기 -->               
                    <v-flex xs5>          
                        <v-btn 
                            style="background-color:#E7D7B7;"  
                            @click="dialog=true" 
                            class="btns" 
                            block 
                        >
                            <v-icon large> alarm </v-icon> &nbsp; {{trans_reservation_text}}
                        </v-btn>
                    </v-flex> 
                </v-layout>       
            </v-flex> 
        </v-layout>

        <!-- 갤러리 이미지가 들어갈 div -->
        <b class='column_title'> 
            {{resGallery}} 
        </b>
        <div id="gallery_div" class="frame"> </div>

        <!-- 갤러리 이미지 더 보기. -->
        <v-dialog 
            v-model="ShowMoreImg" 
            width="85%" 
            scrollable=""
        >
            <v-card @click.native="ShowMoreImg=false" style="background-color: #efe2bd;">
                <!-- 타이틀, x 버튼 -->
                <v-card-title style="border-bottom:3px solid #FE9A2E;">
                    <h2 class="column_title" style="margin: auto"> Gallery </h2>

                    <v-btn icon style="float:right" @click="ShowMoreImg=false">
                        <v-icon large> clear </v-icon>
                    </v-btn>
                </v-card-title>

                <!-- 갤러리 이미지 출력 영역 -->
                <v-flex xs12 id="prtAllImgs"> </v-flex>
            </v-card>
        </v-dialog>

        <!-- 구글 맵스, 텍스트 주소가 출력 될 div -->
        <b class='column_title'> {{resAddress}} </b>
        <div class="frame">
            <div class="title_div" style="margin-top:1%; margin-bottom: 1%;">
                <!-- 구글 맵스 -->
                <div id="map"></div>
            </div>        
        </div>

        <!-- 요리 유형 출력 div -->
        <div class="column_title"> 
            <b>{{resType}}</b> 
        </div>
        <div class="frame_small">
            <span id="type" class="column_value"> </span>
        </div>

        <!-- 좌석 수 출력 div -->
        <div class="column_title"> 
            <b> {{resSeat}} </b> 
        </div>
        <div class="frame_small">
            <span id="seat_num" class="column_value"> </span>
        </div>

        <!-- 이용 시간 출력 div -->
        <div class="column_title" style="float:left;"> 
            <b> {{resTime}} </b> 
        </div>
        <div class="frame_small">
            <div class="column_value" style="float:left;">
                <span class="timeInfo"> {{resLunch}} : </span>
                <span class="timeInfo" id="lunch_open"> </span>
                <span class="timeInfo" id="lunch_close"> ~ </span>  
                <span class="timeInfo" id="lunch_lo"> ( last order : </span> <span class="timeInfo"> ) </span> 
                
                <br> 

                <span class="timeInfo" > {{resDinner}} : </span>
                <span class="timeInfo" id="dinner_open"> </span>
                <span class="timeInfo" id="dinner_close"> ~ </span>  
                <span class="timeInfo" id="dinner_lo"> ( last order : </span><span class="timeInfo"> ) </span>
            </div>
        </div>

        <!-- 결제 방식 출력 div -->
        <div class="column_title"> 
            <b> {{resPayment}} </b> 
        </div>
        <div class="frame_small">
            <span id="payment" class="column_value"> </span>
        </div>

        <!-- 기타 정보 출력 div -->
        <div class="column_title"> 
            <b> {{resGuide}} </b> 
        </div>
        <div class="frame_small"> 
            <div id="children"    class="column_value"> {{resChidren}} : </div>
            <div id="pet"         class="column_value"> {{resPet}} : </div>
            <div id="parking"     class="column_value"> {{resCar}} : </div>
            <div id="smoking"     class="column_value"> {{resSmoke}} : </div>
            <div id="privateroom" class="column_value"> {{resIndividual}} : </div> 
        </div>

        <!-- snackber (reservation) -->
        <v-snackbar
            v-model="reservation_snackbar"  
            :timeout="5000"  
            :vertical="'vertical'"
            :top="'top'"
        >
            {{trans_reservation_ok}}
            <v-btn flat color="white" @click.native="reservation_snackbar = false">Close</v-btn>
        </v-snackbar>

        <!-- snackber (coupon) -->
        <v-snackbar
            v-model="coupon_snackbar"
            :timeout="5000"
            :vertical="'vertical'"
            :top="'top'"
        >
            {{coupon_text}}
            <v-btn flat color="white" @click.native="coupon_snackbar = false">Close</v-btn>
        </v-snackbar>

        <!-- snackbar (add reservation) -->
        <!-- error snackbar -->
        <v-snackbar
            :timeout="1000"
            v-model="addreservation_snackbar"   
            :top="'top'"
        >
            <v-icon dark>announcement</v-icon> {{ addreservation_text }}
        </v-snackbar>
    </div>    
</v-app>
</template>

<script type="text/javascript">
    import Vue      from 'vue';
    import VueAxios from 'vue-axios';
    import axios    from 'axios';
    // import * as VueGoogleMaps from 'vue2-google-maps';

    // 예약 하기
    import { EventBus } from '../user_menu/eventBus.js';
    import DefaultLayout1 from '../user_menu/MenuDefaultLayout1.vue';
    import { isUpdateExpression } from 'babel-types';

    var layout = DefaultLayout1;     // 사장이 선택한 메뉴판 탬플릿
    var obj    = [];                 // 클릭한 배열 담기
    var check  = 0;                  // 클릭한 배열 index용 변수

    // // 구글 맵스 키 값
    // Vue.use(VueGoogleMaps, {
    //     load: {
    //         key: '',
    //     }
    // });

    var restaurant_id = '';          // 유저(관광객)가 클릭한 식당의 아이디 값. 식당의 아이디 값으로 데이터를 요청함.
    var get_datas  = null;           // 요청한 데이터들이 담길 변수 JSON으로 받을 예정
    var url = '';

    export default{
        data() {
            return {
                // 스낵바 설정값
                timeout         : 2000,
                snackbar_text   : '',
                snackbar        : false,

                // 가게 정보 
                resExplanation  : '紹介',
                resPhone        : '電話番号',
                resAddress      : '住所',
                resGallery      : 'ギャラリー',
                resType         : '料理ジャンル',
                resSeat         : '席数',
                resTime         : '営業時間',
                resLunch        : 'ランチ',
                resDinner       : 'ディナ',
                resPayment      : '支払い方法',
                resGuide        : '利用案内',
                resChidren      : 'お子様連れ',
                resPet          : 'ペット',
                resCar          : '駐車場',
                resSmoke        : '喫煙',
                resIndividual   : '貸切',

                // snackbar
                reservation_snackbar    : false,
                coupon_snackbar         : false,
                coupon_text             : '',
                addreservation_snackbar : false,
                addreservation_text     : '',

                shop_id : null,
                shopLike : false,           // 가게 좋아요. true일 경우 좋아요, false일 경우 좋아요 x

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
                adult_person        : null,
                child_person        : null,
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
                pick_time : null,

                /* 메뉴 선택 가능한지 안한지 */
                reservation_selectMenu : 1,

                /* 기본 식당 시간 */
                lunch_open  : '',
                lunch_close : '',
                dinner_open : '',
                dinner_close : '',

                /* DB에서 받아 온 값 - reservation_set */
                res_items:[],

                /* 쿠폰 */
                translateTextDownDialog : false,
                dialog2: false,
                clickCouponid : null,
                clickCouponname : null,

                coupon_items: [],

                /* 갤러리 이미지 더 보기. */
                ShowMoreImg : false,

                /* 브라우저 크기 */
                browser_state : null,

                /* 국적 */
                country : null,

                /* 국적 --> 번역 */
                trans_reservation_text : '予約',
                trans_reservation_date : '予約日',
                trans_reservation_time : '予約時間',
                trans_reservation_person : '大人数',
                trans_reservation_child : '子供数',
                trans_reservation_check : 'メーニュー予約が可能な店です。',
                trans_menu_select : 'メーニュー選択',
                trans_sum : '小計',
                trans_menu_price : '値段',
                trans_menu_name : 'メニュー名',
                trans_reservation_message : '要求事項',
                trans_reservation_recheck : '予約確認',
                trans_menu_check : 'メニュー確認',
                trans_menu_name : 'メーニュー名',
                trans_reservation_ok : '予約できました。',

                /* 쿠폰 */
                trans_coupon_down_text : 'クーポン',
                trans_baai : '場合',
                trans_product : '提供',
                trans_discount : '割引',
                trans_coupon_count : '残り',

            }
        },
        created(){        
            // 화면 크기 구하기.   
            if(window.outerWidth < 639){ 
                this.browser_state = 'phone';
            }
            else {                 
                this.browser_state = 'com';
            }

            // 예약하기
            var set_time_data;

            axios.post('/getReservationSettingList', {
                'shop_id' : this.$route.params.shop_id
            }).then((response) => {
                /* 그 가게의 예약설정된 Data */
                var reservationSettingData = response.data.settingData;

                /* item안에 넣기 */
                this.res_items = reservationSettingData;

                /* 메뉴가 선택 가능한 가게인지 아닌지 */
                this.reservation_selectMenu = response.data.menuSelectData[0].reservation_selectMenu;

                /* 기본 가게 정보 */
                this.lunch_open = response.data.restaurantData[0].lunch_open;
                this.lunch_close = response.data.restaurantData[0].lunch_close;
                this.dinner_open = response.data.restaurantData[0].dinner_open;
                this.dinner_close = response.data.restaurantData[0].dinner_close;
            })

            axios.post('/getCouponList', {
                'shop_id' : this.$route.params.shop_id
            }).then((response) => {
                // 쿠폰
                var Coupondata = response.data.coupon;
                this.coupon_items = Coupondata;
            });

            // ---- 번역 Korea/Japan/China/USA ----
            this.country = this.$session.get('user_country');
            
            if(this.$session.get('user_country') == 'Korea')
            {
                /* 가게 정보 */
                this.resExplanation = '소개';
                this.resPhone = '전화번호';
                this.resAddress = '주소';
                this.resGallery = '갤러리';
                this.resType = '요리 유형';
                this.resSeat = '좌석 수';
                this.resTime = '이용 시간';  
                this.resLunch = '런치';
                this.resDinner = '디너';
                this.resPayment = '결제 방식';
                this.resGuide = '이용 안내';
                this.resChidren = '아이 동반'; 
                this.resPet = '애완 동물'; 
                this.resCar = '주차장';
                this.resSmoke = '흡연석';
                this.resIndividual = '개인실'; 

                /* 예약 */s
                this.trans_reservation_text = '예약 하기';
                this.trans_reservation_date = '예약 날짜';
                this.trans_reservation_time = '예약 시간';
                this.trans_reservation_person = '어른 수';
                this.trans_reservation_child = '아이 수';
                this.trans_reservation_check = '메뉴 예약이 가능한 가게입니다.' ;
                this.trans_menu_select = '메뉴 선택';
                this.trans_menu_check = '메뉴 확인';
                this.trans_menu_name = '메뉴명'
                this.trans_menu_price = '가격'
                this.trans_sum = '합계'
                this.trans_reservation_message = '요구사항';
                this.trans_reservation_recheck = '예약 확인';
                this.trans_reservation_ok = '예약이 완료 되었습니다.';
                
                /* 쿠폰*/
                this.trans_coupon_down_text = '쿠폰 받기';
                this.trans_baai = '경우';
                this.trans_product = '제공';
                this.trans_discount = '할인';
                this.trans_coupon_count = '남은 개수';
            }
            else if(this.$session.get('user_country') == 'China')
            {
                /* 가게 정보 */
                this.resExplanation = '简介';
                this.resPhone = '电话号码';
                this.resAddress = '地址';
                this.resGallery = '画廊';
                this.resType = '菜类型';
                this.resSeat = '座数';
                this.resTime = '使用时间';  
                this.resLunch = '午餐';
                this.resDinner = '晚餐';
                this.resPayment = '结算方式';
                this.resGuide = '使用指南';
                this.resChidren = '儿童同行'; 
                this.resPet = '宠物'; 
                this.resCar = '停车场';
                this.resSmoke = '吸烟室';
                this.resIndividual = '个人室'; 
                
                /* 예약 */
                this.trans_reservation_text = '豫約';
                this.trans_reservation_date = '豫約时间';
                this.trans_reservation_time = '豫約時間';
                this.trans_reservation_person = '大人 數';
                this.trans_reservation_child = '孩子 數';
                this.trans_reservation_check = '菜单的店预订。' 
                this.trans_menu_select = '选择菜单';
                this.trans_menu_check = '确认菜单';
                this.trans_menu_name = '弥涅名';
                this.trans_menu_price = '价格';
                this.trans_sum = '合计';
                this.trans_reservation_message = '要求事项';
                this.trans_reservation_recheck = '确认预约';
                this.trans_reservation_ok = '预约已完成。';

                /* 쿠폰 */
                this.trans_coupon_down_text = '领取优惠券';
                this.trans_baai = '情况';
                this.trans_product = '提供';
                this.trans_discount = '折扣';
                this.trans_coupon_count = '余数';
            }
            else if(this.$session.get('user_country') == 'USA')
            {                
                /* 가게 정보 */
                this.resExplanation = 'Explanation';
                this.resPhone = 'Phone';
                this.resAddress = 'Address';
                this.resGallery = 'Gallery';
                this.resType = 'Type';
                this.resSeat = 'Seat';
                this.resTime = 'Time';  
                this.resLunch = 'Lunch';
                this.resDinner = 'Dinner';
                this.resPayment = 'Payment';
                this.resGuide = 'Guide';
                this.resChidren = 'Chidren'; 
                this.resPet = 'Pet'; 
                this.resCar = 'parking lot';
                this.resSmoke = 'smoking seat';
                this.resIndividual = 'private room'; 

                /* 예약 */
                this.trans_reservation_text = 'Reservation';
                this.trans_reservation_date = 'Reservation Date';
                this.trans_reservation_time = 'Reservation Time';
                this.trans_reservation_person = 'Adult';
                this.trans_reservation_child = 'Child';
                this.trans_reservation_check = 'You can reservation a menu at the store.' 
                this.trans_menu_select = 'Select Menu';
                this.trans_menu_check = 'Check Menu';
                this.trans_menu_name = 'Menu Name';
                this.trans_menu_price = 'Price';
                this.trans_sum = 'Sum';
                this.trans_reservation_message = 'Requirements';
                this.trans_reservation_recheck = 'Reservation Check';
                this.trans_reservation_ok = 'reservation is complete.';

                /* 쿠폰 */
                this.trans_coupon_down_text = 'CouponDown';
                this.trans_baai = 'Case';
                this.trans_product = 'Provision';
                this.trans_discount = 'Discount';
                this.trans_coupon_count = 'Remaining number';
            }

        },

        mounted() {
            // 값 보내기
            this.shop_id = this.$route.params.shop_id;

            url = '/restaurant/' + this.shop_id + '/getInfo';

            axios.get(url).then( (response) => {
                get_datas = response.data.restaurant;       
                this.shopLike = response.data.shopLike;             

                // 예약 하기 메뉴 
                EventBus.$on('select_menus', function(menu) {
                    obj.push( menu[check] ); check++;
                });

                // 데이터 바인딩-기본정보
                this.enter_data(get_datas[0]);

                // 데이터 바인딩-평점
                this.enter_data(get_datas[1]);

                // 별점 찍기
                this.prtStarRate(get_datas[1].totalRating);

                // 지도 생성
                this.geoCoder(get_datas[0]);

                // 타이틀 이미지 삽입
                this.enter_title(get_datas[2]);

                // 갤러리 이미지 출력
                this.enter_galley();

                // 좋아요 바인딩
                this.I_Like_It(); 
            })
            .catch((ex)=>{ })     
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
                            case true  : get_div.innerText += '가능';          break;
                            case false : get_div.innerText += '불가';          break;
                            case '1'   : get_div.innerText += '가능';          break;
                            case '0'   : get_div.innerText += '불가';          break;
                            case 1     : get_div.innerText += '가능';          break;
                            case 0     : get_div.innerText += '불가';          break;
                            case null  : get_div.innerText += 0;               break;
                            default    : get_div.innerText += argArray[key];   break;
                        }

                        if(key === 'trans_explanation' && argArray[key] != null){
                            document.getElementById('explanation').innerText = argArray[key];
                        }
                    }
                }
            },

            // 타이틀 이미지 삽입하기
            enter_title : function(argImgArray){
                document.getElementById('title_img').src = argImgArray.path + argImgArray.filename;
            },

            // 좋아연.
            I_Like_It : function(){  
                let LikeIcon = document.getElementById('LikeIcon'); 
                let url      = '/restaurantsLike';
                let shop_id  = this.$route.params.shop_id; 
                let data     = this;
                 
                // 클릭 시 데이터 보내기.
                function SendValue(argValue){                
                    // 좋아요 and 좋아요 취소
                    axios.post(url, {
                        'shop_id' : shop_id,
                        'shopLike': argValue
                    })
                    // 결과 true(좋아요) or false(좋아요 x)
                    .then((response) => {        
                        let result = response.data.shopLike;    // 결과

                        if(result === 'failed'){                     
                            data.snackbar_text = '로그인해 주세요!';
                            data.snackbar      = true;
                        }                      
                        else {                     
                            ChangeColor(response.data.shopLike);   
                        }          
                    })
                    // 서버 연결 실패
                    .catch((ex)=>{ });                           
                };
                
                // 색깔 바꾸기 빈 하트 -> 하트 -> 빈하트
                function ChangeColor(argValue){  
                    if(argValue === true){
                        LikeIcon.innerText = 'favorite';                    
                    }
                    else if(argValue === false){
                        LikeIcon.innerText = 'favorite_border'; 
                    }    
                } 

                // 좋아요 버튼 클릭한 경우 데이터 보내기.
                if (event.target.id == 'LikeIt') { 
                    // 좋아요 상태인 경우 좋아요 취소
                    if(this.shopLike === true) { 
                        this.shopLike = false;
                    }
                    // 좋아요 상태가 아니였을 경우 좋아요 
                    else if(this.shopLike === false){  
                        this.shopLike = true;                    
                    }
                    // 변경 사항 서버에 보내기.
                    SendValue(this.shopLike);    
                }    
                // 페이지를 로드한 경우 색상 적용 시키기
                else {
                    ChangeColor(this.shopLike); 
                }                             
            },         

            // 별점 찍기 star, star_border, star_half
            prtStarRate : function(argValue){
                let prtStar = document.getElementById('prtStar');
                let score   = Math.floor(argValue);                 // 소수점 이하를 제외한 점수
                let point   = parseFloat(argValue) - score;         // 소수점 첫번째 자리

                point =  Math.floor(point * 10);                    // 소수점 첫번째 자리 구하기.
  
                for(let i=0; i < score; i++){
                    prtStar.children[i].innerText = 'star';
                }

                if(point !== 0){
                    if(point > 4) {  
                        prtStar.children[score].innerText = 'star_half';
                    }
                } 
            },   

            // 갤러리에 이미지 추가하기.
            enter_galley : function(){
                // 넘어온 데이터 배열 갯수 : 0은 기본 데이터 , 1은 평점, 2는 타이틀 이미지
                let argNum      = get_datas.length;       
                let browser_w   = window.outerWidth;                                      // 브라우저 너비
                let gallery_div = document.getElementById('gallery_div'); 
                let vueObj      = this;

                // 갤러리에 이미지 생성해서 넣기.
                function appendImg (Index) {
                    // div, img 생성
                    let createdDiv = document.createElement('div');
                    let createdImg = document.createElement('img');

                    // 생성한 div와 img에 css와 src를 추가함.
                    createdImg.src = get_datas[Index].path + get_datas[Index].filename;
                    createdImg.classList.add('gallery_img');
                    createdDiv.classList.add('gallery');

                    // 생성한 div와 img를 갤러리 div에 추가.
                    createdDiv.appendChild(createdImg);
                    gallery_div.prepend(createdDiv);
                }

                // 더보기 버튼 만들기.
                function appendMore (){
                    let moreImg = document.createElement('div');
                    let lastImg = gallery_div.children[gallery_div.children.length-1];

                    moreImg.innerText = '더 보기';

                    moreImg.classList.add('gallery_img');
                    moreImg.classList.add('MoreImg_inner');

                    // 클릭 시 모달 창 띄우기
                    moreImg.addEventListener('click',function(){  
                        vueObj.PrtAllGalleryImg();
                        vueObj.ShowMoreImg = true; 
                    },false); 

                    lastImg.appendChild(moreImg);
                }

                // 등록된 이미지가 없으면 메세지 출력
                if(argNum -3 == 0) {
                    gallery_div.innerText = "등록된 이미지가 없습니다.";
                    return;
                }

                // 모바일 환경 이미지 2개만.
                if(browser_w < 639){   
                    // 등록된 이미지가 2개 이하.
                    if(argNum -3 < 3) {
                        for (let i=3; i < argNum; i++){                     
                            appendImg(i);
                        }
                    }
                    // 등록된 이미지가 2개 초과
                    else {                      
                        for (let i=3; i < 7; i++){      
                            appendImg(i);
                        }
                        appendMore();
                    }
                }
                // 모바일 이외의 환경
                else {
                    // 등록된 이미지가 6개 이하.
                    if(argNum -3 < 6) {
                        for (let i=3; i < argNum; i++){
                            appendImg(i);
                        }
                    }
                    // 등록된 이미지가 6개 초과
                    else { 
                        for (let i=3; i < 8; i++){
                            appendImg(i);
                        }
                        appendMore();
                        console.log(this.ShowMoreImg);
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
                    } 
                });
            },

            // 예약하기
            // 불가능 한 날짜 반환.
            allowedDates(val) {
                var index     = 0;
                var maxlength = this.res_items.length;
                var dateCheck = "";

                for(var $i = 0; $i < maxlength; $i++)
                {
                    // impossible이 예약 불가능일 경우 달력에 표시되지 않습니다.
                    if(val == this.res_items[$i].pick_date &&  this.res_items[$i].remark == 0){
                        dateCheck += this.res_items[$i].pick_date + "&&"
                    }
                }
                return !(dateCheck);
            },

            setTime() {
               let shop_id = this.$route.params.shop_id;
                
                /* date가 클릭시 item안의 set_time[]을 select 문에 넣기 */
                this.states = [];

                // db에서 데이터 받기
                axios.post('/getReservationSettingByDate', {
                    shop_id    : shop_id,
                    click_date : this.start_date,
                }).then((response) => {

                    var pick_time = response.data.settingData;

                    if(pick_time != '')
                    {
                        for(var i = 0; i < pick_time.length; i++)
                        {
                            // 배열안의 예약 가능 시간 빼오기
                            this.states.push(pick_time[i].start_time.substr(0,5));
                        }
                    }
                    /* 사장님이 지정한 시간대가 없을 경우 */

                    else {
                        this.basic_time();
                    }
                });
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
                    else if(dinner_minute == '30')s
                    {
                        this.states.push(hour + ":" + dinner_minute);
                        dinner_minute = '00';
                    }

                }
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

                this.coupon_text = "選択したメーニューをキャンセルしました。";
                this.coupon_snackbar = true;
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
                /* 유효성 검사 */
                if(this.start_date == null)
                {
                    if(this.country == 'Korea')
                    {
                        this.addreservation_text = "예약 날짜를 선택해주세요"
                        this.addreservation_snackbar = true;
                        return;
                    }
                    else if(this.country == 'China')
                    {
                        this.addreservation_text = " 请选择预约日期。"
                        this.addreservation_snackbar = true;
                        return;
                    }
                    else if(this.country == 'USA')
                    {
                        this.addreservation_text = " Please select a reservation date"
                        this.addreservation_snackbar = true;
                        return;
                    }
                    else {
                        this.addreservation_text = " 予約日を選択してください。"
                        this.addreservation_snackbar = true;
                        return;
                    }
                }
                if(this.pick_time == null)
                {
                    if(this.country == 'Korea')
                    {
                        this.addreservation_text = "예약 시간를 선택해주세요"
                        this.addreservation_snackbar = true;
                        return;
                    }
                    else if(this.country == 'China')
                    {
                        this.addreservation_text = " 请选择预约时间。"
                        this.addreservation_snackbar = true;
                        return;
                    }
                    else if(this.country == 'USA')
                    {
                        this.addreservation_text = " Select reservation time "
                        this.addreservation_snackbar = true;
                        return;
                    }
                    else {
                        this.addreservation_text = " 予約時間を選択してください。"
                        this.addreservation_snackbar = true;
                        return;
                    }
                }
                if(this.adult_person != null || this.child_person != null)
                {
                    // 숫자만 가능
                    var regNumber = /^[0-9]*$/;

                    if(!regNumber.test(this.adult_person)) {
                        if(this.country == 'Korea')
                        {
                            this.addreservation_text = "어른 수 항목은 숫자로 입력해주세요"
                            this.addreservation_snackbar = true;
                            return;
                        }
                        else if(this.country == 'China')
                        {
                            this.addreservation_text = " 成人数字项目请输入数字。"
                            this.addreservation_snackbar = true;
                            return;
                        }
                        else if(this.country == 'USA')
                        {
                            this.addreservation_text = " Please enter adult number items in figures. "
                            this.addreservation_snackbar = true;
                            return;
                        }
                        else { 
                            this.addreservation_text = "大人数の項目は数字だけ入力してください。";
                            this.addreservation_snackbar = true;
                            return;
                        }
                    }

                    if(!regNumber.test(this.child_person)) {
                        if(this.country == 'Korea')
                        {
                            this.addreservation_text = "아이 수 항목은 숫자로 입력해주세요"
                            this.addreservation_snackbar = true;
                            return;
                        }
                        else if(this.country == 'China')
                        {
                            this.addreservation_text = " 请用数字输入品目数量。"
                            this.addreservation_snackbar = true;
                            return;
                        }
                        else if(this.country == 'USA')
                        {
                            this.addreservation_text = " Please enter child number items in figures. "
                            this.addreservation_snackbar = true;
                            return;
                        }
                        else { 
                            this.addreservation_text = "子供数の項目は数字だけ入力してください。";
                            this.addreservation_snackbar = true;
                            return;
                        }
                    }

                }
                
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
                        this.reservation_snackbar = true;
                        this.dialog = false;
                    }).catch(console.log('test '));
                
            },

            // ------ 쿠폰 ---------
            Download(item) {
                const index = this.coupon_items.indexOf(item);
                this.clickCouponid = this.coupon_items[index].id;

                /* Data 송신 -> 자신의 쿠폰함으로 담긴다*/
                axios.post('/userCouponCreate', {
                    // 쿠폰ID
                    id  :  this.clickCouponid
                }).then((response) => {
                    var CouponAlready = response.data.msg;

                    if(CouponAlready == true)
                    {
                        if(this.country == 'Korea')
                        {
                            this.addreservation_text = "마이페이지 - 쿠폰함을 확인해주세요"
                            this.addreservation_snackbar = true;
                        }
                        else if(this.country == 'China')
                        {
                            this.addreservation_text = " 请确认我的主页-优惠券。"
                            this.addreservation_snackbar = true;
                        }
                        else if(this.country == 'USA')
                        {
                            this.addreservation_text = " Please check my page-to-tape box. "
                            this.addreservation_snackbar = true;
                        }
                        else { 
                            this.coupon_text = 'マイパージ・クーポンを確認してください。';
                            this.coupon_snackbar = true;
                        }

                    }
                    else {
                        if(this.country == 'Korea')
                        {
                            this.addreservation_text = "이미 다운받으셨거나 소진되었습니다."
                            this.addreservation_snackbar = true;
                        }
                        else if(this.country == 'China')
                        {
                            this.addreservation_text = " 已下载或已耗尽。"
                            this.addreservation_snackbar = true;
                        }
                        else if(this.country == 'USA')
                        {
                            this.addreservation_text = " You have already downloaded or exhausted. "
                            this.addreservation_snackbar = true;
                        }
                        else { 
                            this.coupon_text = 'すでにダウンロードしたり、消尽されました。';
                            this.coupon_snackbar = true;
                        }
                    }

                })
                .catch(console.log('test'));
            }
        }
    };
</script>

<style>
    @import url(//cdn.rawgit.com/hiun/NanumSquare/master/nanumsquare.css); 

    /* 모바일 */
    @media (max-width: 639px){ 
        #name           { font-size: 1.1rem; margin-left: 5px;}  
        #namer          { font-size: 0.9rem; margin-left: 10px;}   
        #title_inner    { top: 50%; width: 100%; height: 50%; }  
        #title_gra      { top: 50%; width: 100%; height: 50%; }  

        .title_div {
            padding-bottom: 60%;
        }          
        .title_contents_div { 
            width: 85%;  
        }
        .btns {  
            font-size: 0.8rem;
        }
        .explanation-outer { 
            padding-bottom:60%; 
        } 
        #explanation {      
            top:0;
            left:0;       
            font-size: 1rem;
        }
        .column_title   { font-size: 1.2rem; }     
        .column_value   { font-size: 1rem;}
        .timeInfo       { font-size: 1rem; } 
        .gallery        { width: 48%; padding-bottom: 35%; }
        .img-outer      { width: 90%; padding-bottom: 60%; }

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
        #name           { font-size: 2rem; margin-left: 5px;}      
        #namer          { font-size: 1.5rem; margin-left: 10px;}   
        #title_inner    { top: 50%; width: 100%; height: 50%; }
        #title_gra      { top: 50%; width: 100%; height: 50%; }

        .title_div {
            padding-bottom: 60%;
        }  
        .title_contents_div { 
            width: 85%;  
        }
        .btns {  
            font-size: 1rem;
        }
        .explanation-outer { 
            padding-bottom:60%; 
        } 
        #explanation {          
            top:0;
            left:0;        
            font-size: 1.2rem; 
        }
        .column_title   { font-size: 2rem; }     
        .column_value   { font-size: 1.5rem;}
        .timeInfo       { font-size: 1.5rem; } 
        .gallery        { width: 48%; padding-bottom: 35%; }
        .img-outer      { width: 90%; padding-bottom: 60%; }

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
        #name           { font-size: 5rem; }   
        #namer          { font-size: 1.7rem; }     
        #title_inner    { top: 60%; width: 100%; height: 40%; }    
        #title_gra      { top: 60%; width: 100%; height: 40%; }

        .title_div {
            padding-bottom: 50%;
        }        
        .title_contents_div { 
            width: 65%;  
        }
        .btns {  
            font-size: 1.2rem;
        }
        .explanation-outer { 
            padding-bottom:30%; 
        } 
        #explanation {            
            font-size: 1.2rem;
        }
        .column_title   { font-size: 2rem; }        
        .column_value   { font-size: 1.7rem;}
        .timeInfo       { font-size: 1.5rem; } 
        .gallery        { width: 18%; padding-bottom: 15%;}
        .img-outer      { width: 46%; padding-bottom: 40%;}

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
            color: #6d4d35;
        }
        .reservationCheck_main {
            padding-top: 1%;
            font-size: 18px;
            color: #9d724b;
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
        border-top: 3px solid #ff9a55; 
        display:inline-block;
        margin-bottom: 20px;
    }

    /* 요리 유형, 좌석 수, 전화번호, 이용시간, 결제 방식, 이용안내 */
    .frame_small {
        width: 100%;
        padding-top: 1%;
        padding-left: 1%;
        border-top: 3px solid #FE9A2E;
        margin-bottom: 20px;
        display:inline-block;
        height: auto;
    }

    /* 가게 메인 이미지 */
    .title_div {
        width: 100%;
        height: 0;
        margin-bottom: 3%;
        overflow: hidden;
        position: relative;
    }
    #title_inner{ 
        z-index: 2; 
        position: absolute; 
        color: white;        
    }
    #title_gra{ 
        z-index: 1;         
        background-image: 
            linear-gradient( 
                to bottom, 
                rgba(0,0,0,0),
                rgba(0,0,0,0.5),
                rgba(0,0,0,0.9)
            );
        position: absolute; 
    }

    /* 타이틀 용 */
    .title_contents_div {  
        margin-left: 5%; 
        margin: left; 
        text-align: left;   
        overflow: hidden;  
    }  

    .explanation-outer {
        height:0; 
        overflow:hidden; 
        position:relative;
    } 

    #explanation {
        width: 100%;
        height: 100%;  
        padding: 2%; 
        color: #6d4d35;                    
        position:absolute; 
        overflow: auto;
        overflow-x: hidden; 
 
        font-weight: bold;
        letter-spacing: -50;
        line-height: 24pt; 
        text-align: left; 
    }      
    /* 설명 스크롤바 없애기 */
    #explanation::-webkit-scrollbar {
        width: 0px;                     /* remove scrollbar space */
        background: transparent;        /* optional: just make scrollbar invisible */
    }

    #title_img {        
        top: 0;
        left: 0;
        width: 100%;
        height: 100%; 
        z-index: 0;
        position: absolute;
        object-fit: cover;
    }

    /* 좋아여 */
    #LikeIt {   
        color: white;
        border: 2px solid white; 
    }

    .btns {   
        text-align: center;      
        font-weight: bolder;  
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
        color: white;
        font-weight: bold;
        text-align:center;
        background-color: black;
        opacity: 0.5;
        z-index: 2;
    }
    #prtAllImgs {
        background-color: white;
        overflow: auto;
    }
    /* 설명 스크롤바 없애기 */
    #prtAllImgs::-webkit-scrollbar {
        width: 0px;                     /* remove scrollbar space */
        background: transparent;        /* optional: just make scrollbar invisible */
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
    .column_title{
        margin-right: 20px;
        color: #9d724b;
        text-align: left;
        position: relative;
        display:inline-block;
    }
    /* 정보 내용 */
    .column_value{
        padding: 3px;
        position: relative;
        font-weight: bold;
        color: #6d4d35; 
    }

    /* 구글 맵스용 */
    #map {
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: 1px solid #6d4d35;
        position: absolute;
    }
    /* 가게 주소 */
    .addressInfo{
        margin-right: 10px;
        display:inline-block;
        font-weight: bold;
        font-size: 1.2rem;
        color: #6d4d35;
    }
</style>