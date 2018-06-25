<template>
    <div>
        <v-app>
            <v-navigation-drawer
                    v-model="menu"
                    fixed
                    app
                    temporary
                    touchless
                    hide-overlay
            >
                <v-list>
                    <v-list-tile avatar to="/editInformation">
                        <v-list-tile-avatar>
                            <v-icon large>account_circle</v-icon>
                        </v-list-tile-avatar>
                        <v-list-tile-content>
                            <v-list-tile-title>{{ user_id+"("+user_name+")" }} 님</v-list-tile-title>
                            <v-list-tile-sub-title v-if="checkRestaurant()">사업자 회원</v-list-tile-sub-title>
                            <v-list-tile-sub-title v-else>개인 회원</v-list-tile-sub-title>
                        </v-list-tile-content>
                    </v-list-tile>
                </v-list>
                <v-divider></v-divider>
                <v-list v-if="!checkRestaurant()">
                    <v-list-tile to="/userOrderHistory">
                        <v-list-tile-action>
                            <v-icon large>assignment</v-icon>
                        </v-list-tile-action>
                        <v-list-tile-content>
                            <v-list-tile-title>주문 내역</v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>
                    <v-list-tile to="/userReviewHistory">
                        <v-list-tile-action>
                            <v-icon large>rate_review</v-icon>
                        </v-list-tile-action>
                        <v-list-tile-content>
                            <v-list-tile-title>리뷰 내역</v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>
                    <v-list-tile to="/userPageReservation">
                        <v-list-tile-action>
                            <v-icon large>history</v-icon>
                        </v-list-tile-action>
                        <v-list-tile-content>
                            <v-list-tile-title>예약 내역</v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>
                    <v-list-tile to="/userCoupon">
                        <v-list-tile-action>
                            <v-icon large>loyalty</v-icon>
                        </v-list-tile-action>
                        <v-list-tile-content>
                            <v-list-tile-title>쿠폰함</v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>
                    <v-list-tile>
                        <v-list-tile-action>
                            <v-icon large>favorite</v-icon>
                        </v-list-tile-action>
                        <v-list-tile-content>
                            <v-list-tile-title>찜목록</v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>
                    <!-- 커뮤니케이션 버튼 -->
                    <v-dialog v-model="communicationDialog" fullscreen hide-overlay transition="dialog-bottom-transition" full-width>
                        <v-list-tile @click="" slot="activator">
                            <v-list-tile-action>
                                <v-icon large>sentiment_very_satisfied</v-icon>
                            </v-list-tile-action>
                            <v-list-tile-content>
                                <v-list-tile-title>
                                    Communication
                                </v-list-tile-title>
                            </v-list-tile-content>
                        </v-list-tile>
                        <!-- 출력될 modal창 내용-->
                        <v-card>
                            <v-toolbar dark color="grey darken-3">
                                <v-toolbar-title>Communication</v-toolbar-title>
                                <v-spacer></v-spacer>
                                <!-- 이 버튼을 누르면 communicationDialog의 값을 false로 만들어
                                출력된 모달창을 사라지도록 한다는 것 -->
                                <v-btn icon @click.native="communicationDialog = false" dark>
                                    <v-icon>close</v-icon>
                                </v-btn>
                            </v-toolbar>
                            <v-list three-line subheader>
                                <!-- 커뮤니케이션 버튼 기능 -->
                                <UserCommunication></UserCommunication>
                            </v-list>
                        </v-card>
                    </v-dialog>
                    <!-- 커뮤니케이션 버튼 끝 -->
                </v-list>
                <v-list v-else-if="checkRestaurant() != 'needCreate'">
                    <v-subheader>가게 관리</v-subheader>
                    <v-list-tile @click="moveMyMenu()">
                        <v-list-tile-action>
                            <v-icon large color="green">developer_board</v-icon>
                        </v-list-tile-action>
                        <v-list-tile-content>
                            <v-list-tile-title>메뉴</v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>
                    <v-list-tile @click="moveMyReservation()">
                        <v-list-tile-action>
                            <v-icon large color="green">playlist_add_check</v-icon>
                        </v-list-tile-action>
                        <v-list-tile-content>
                            <v-list-tile-title>예약</v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>
                    <v-list-tile @click="moveMyStats()">
                        <v-list-tile-action>
                            <v-icon large color="green">timeline</v-icon>
                        </v-list-tile-action>
                        <v-list-tile-content>
                            <v-list-tile-title>통계</v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>
                    <v-divider></v-divider>
                    <v-subheader>내 가게 페이지</v-subheader>
                    <v-list-tile @click="moveMyRestaurant()">
                        <v-list-tile-action>
                            <v-icon large color="green">restaurant</v-icon>
                        </v-list-tile-action>
                        <v-list-tile-content>
                            <v-list-tile-title>내 가게로 이동</v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>
                </v-list>
                <v-list v-else>
                    <v-subheader>가게 관리</v-subheader>
                    <v-list-tile @click="moveMyRestaurant()">
                        <v-list-tile-action>
                            <v-icon large color="green">restaurant</v-icon>
                        </v-list-tile-action>
                        <v-list-tile-content>
                            <v-list-tile-title>가게 생성하기</v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>
                </v-list>
            </v-navigation-drawer>
            <v-toolbar
                    app
                    color='white'
                    dense
                    scroll-off-screen
                    :scroll-threshold="0"
            ><!-- scroll-off-screen: 스크롤을 내리면 toolbar가 숨겨짐 -->
                <!-- scroll-threshold: 스크롤 민감도 -->
                <v-btn class="mr-0" icon @click="openMenu()">
                    <v-icon large color="grey">menu</v-icon>
                </v-btn>
                <v-toolbar-title class="logo-title">
                    <router-link to="/" style="text-decoration: none" class="orange--text logo1">SMART</router-link><router-link :to="{ name: 'home' }" style="text-decoration: none" class="red--text logo1">さしすせそ</router-link>
                    <router-link to="/" style="text-decoration: none" class="orange--text logo2">SMART</router-link><router-link :to="{ name: 'home' }" style="text-decoration: none" class="red--text logo2">S</router-link>
                </v-toolbar-title>
                <v-text-field
                        v-if="$route.path != '/'"
                        v-model="searchDataInput"
                        prepend-icon="search"
                        label="식당 또는 음식"
                        solo
                        flat
                        color="orange"
                        @keypress.enter="searching()"
                ></v-text-field>
                <v-spacer v-if="$route.path == '/'"></v-spacer>
                <v-btn class="mr-0" icon @click.native.stop="gps_modal = true">
                    <v-icon large color="red">gps_fixed</v-icon>
                </v-btn>
                <v-btn v-if="!checkLogin()" class="mx-1" icon @click="loginForm=true">
                    <v-icon large color="grey">account_circle</v-icon>
                </v-btn>
                <v-menu v-else offset-y>
                    <v-btn class="mx-1" icon slot="activator">
                        <v-icon large color="blue">account_circle</v-icon>
                    </v-btn>
                    <v-list>
                        <v-list-tile @click="logout()">
                            <v-list-tile-action>
                                <v-icon large color="blue">directions_run</v-icon>
                            </v-list-tile-action>
                            <v-list-tile-title>Logout</v-list-tile-title>
                        </v-list-tile>
                    </v-list>
                </v-menu>
            </v-toolbar>
            <!-- 컴포넌트 출력 -->
            <v-content v-scroll="onScroll" column align-center justify-center>
                <router-view></router-view>
            </v-content>
        </v-app>
        <v-dialog v-model="gps_modal" max-width="400">
            <v-card>
                <v-card-title class="headline">GPS 위치 지정<v-spacer></v-spacer>
                    <v-btn icon @click.native.stop="gps_modal = false">
                        <v-icon large color="red">close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text>위치를 기반으로 식당을 검색하거나 추천해 드립니다 ^^</v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="amber lighten-1" @click.native="gps_search = true">직접 입력</v-btn>
                    <v-dialog v-model="gps_search" max-width="500">
                        <v-card>
                            <v-card-title class="headline">위치를 입력하세요</v-card-title>
                            <v-card-actions>
                                <v-flex>
                                    <gmap-autocomplete
                                            class="searchBar"
                                            @place_changed="setPlace"
                                            @keypress="setPlace"
                                    ></gmap-autocomplete>
                                </v-flex>
                                <v-btn color="amber lighten-1" @click.native="gps_search = false; gps_modal = false; searchingAddress()">검색</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                    <v-btn color="red" @click.native="gps_modal = false">GPS로 위치 찾기</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog
                v-model='loginForm'
                max-width='300px'
        >
            <v-card>
                <v-card-text>
                    <v-flex xs3>
                        <span class="headline"><strong>Login</strong></span>
                    </v-flex>
                    <v-form>
                        <v-text-field
                                placeholder="ID"
                                autofocus
                                required
                                v-model='idValue'
                        ></v-text-field>
                        <v-text-field
                                placeholder="Password"
                                type="password"
                                required
                                v-model='pwValue'
                                @keypress.enter="login()"
                        ></v-text-field>
                    </v-form>
                </v-card-text>
                <v-card-actions>
                    <v-btn color="green" block large outline @click="login()">로그인</v-btn>
                    <router-link to="register" style="text-decoration: none">
                        <v-btn color="blue" block large outline @click="loginForm = false">회원가입</v-btn>
                    </router-link>
                </v-card-actions>
                <br>
            </v-card>
        </v-dialog>
        <v-snackbar
                v-model="snackbar"
                :timeout="timeout"
                top
                vertical
        >
            {{ snackText }}
            <v-btn flat color="pink" @click.native="snackbar = false">Close</v-btn>
        </v-snackbar>
        <v-fab-transition>
            <v-btn
                    v-if="scrollTopButton"
                    @click="scrollToTop()"
                    color="orange"
                    dark
                    fixed
                    bottom
                    right
                    fab
            >
                <v-icon>keyboard_arrow_up</v-icon>
            </v-btn>
        </v-fab-transition>
    </div>
</template>

<script>
    import axios  from 'axios';
    // 커뮤니케이션 버튼
    import UserCommunication from './components/user/user_communication/UserCommunication.vue';

    export default {
        components : {
            'UserCommunication' : UserCommunication,            //  커뮤니케이션 버튼
        },

        data() {
            return {
                menu: false,        // navigation-drawer(왼쪽 메뉴바)
                loginForm: false,   // login dialog
                gps_modal: false,   // gps dialog
                gps_search: false,  // gps search dialog
                idValue: '',        // login form user id
                pwValue: '',        // login form user pw

                user_id: this.$session.get('user_id'),      // user id
                user_name: this.$session.get('user_name'),  // user name

                communicationDialog: false,     // 커뮤니케이션 버튼을 통해 모달창을 출력하는데 사용

                snackbar:   false,  // snackbar 상태
                snackText:  "",     // snackbar 내용
                timeout:    3000,   // snackbar 표시 시간

                searchAddressInput: "", // 사용자가 입력한 address value

                searchDataInput: "",    // 사용자가 입력한 search value

                offsetTop: 0,
                scrollTopButton: false,
            }
        },

        created: function() {

        },

        methods: {
            login() {
                var url = "/login";
                axios.post(url, {
                    user_id     : this.idValue,
                    password    : this.pwValue
                })
                    .then(response => {
                        if(!response.data.login) { // 로그인 실패시
                            this.snackbar = true;
                            this.snackText = response.data.msg;
                            return;
                        }
                        if(response.data.restaurant_id != "/") { // 사장인지 손님인지 체크
                            if(response.data.restaurant_id != "noneRestaurant") // 가게를 만든 사장인지 체크
                                this.$session.set('restaurant_id', response.data.restaurant_id); // 가게를 만든 사장이라면, 가게 id set
                            else
                                this.$session.set('restaurant_id', 'needCreate');
                        } else {
                            if(response.data.favorite_region)
                                this.$session.set('region', response.data.favorite_region);
                            if(response.data.favorite_1) {
                                this.$session.set('favorite_1', response.data.favorite_1);
                                if(response.data.favorite_2) {
                                    this.$session.set('favorite_2', response.data.favorite_2);
                                    if(response.data.favorite_3)
                                        this.$session.set('favorite_3', response.data.favorite_3);
                                }
                            }
                        }

                        this.$session.set('loginStatus', true);                     // 로그인 상태 true
                        this.$session.set('user_id', response.data.user_id);        // user_id set
                        this.$session.set('user_name', response.data.user_name);    // user_name set

                        if(this.$session.get('restaurant_id')) { // 사장이라면 가게페이지, 손님이라면 메인페이지로 이동
                            if(!(this.$session.get('restaurant_id') == 'needCreate')) { // 가게를 만들지 않은 사장인지 체크
                                var restaurant_id = this.$session.get('restaurant_id');
                                location.replace('/owner/' + restaurant_id + '/editRestaurant');
                            } else {
                                location.replace('/owner/createRestaurant');
                            }
                        } else
                            location.replace(response.data.restaurant_id);
                    })
                    .catch(error => {
                        this.snackbar = true;
                        this.snackText = error;
                    });
            },

            logout() {
                this.$session.clear();
                location.replace('/');
            },

            checkLogin() {
                return this.$session.get('loginStatus');
            },

            checkRestaurant() {
                if(!this.$session.get('restaurant_id' == 'needCreate')) // 가게 등록한 사장인지 아닌지 체크
                    return this.$session.get('restaurant_id');
                else
                    return "needCreate";
            },

            moveMyMenu() {
                var restaurant_id = this.$session.get('restaurant_id');
                location.replace('/owner/' + restaurant_id + '/menuOperate');
            },

            moveMyReservation() {
                var restaurant_id = this.$session.get('restaurant_id');
                location.replace('/owner/' + restaurant_id + '/ownerReservationList');
            },

            moveMyStats() {
                var restaurant_id = this.$session.get('restaurant_id');
                location.replace('/owner/' + restaurant_id + '/totalStatistics');
            },

            moveMyRestaurant() {
                var restaurant_id = this.$session.get('restaurant_id');

                if(restaurant_id != "needCreate") // 가게를 등록했으면 가게 페이지로, 아니면 생성 페이지로
                    location.replace('/restaurant/' + restaurant_id + '/info');
                else
                    location.replace('/owner/createRestaurant');
            },

            openMenu() {
                if(this.checkLogin()) {
                    this.menu = !this.menu;
                } else {
                    this.snackbar = true;
                    this.snackText = "로그인이 필요합니다!";
                    this.loginForm = true;
                }
            },

            setPlace(AddressInput) {
                this.searchAddressInput = AddressInput;
            },

            searchingAddress() {
                if(this.searchAddressInput.formatted_address) {
                    this.$session.set('searchAddress', this.searchAddressInput.geometry.location);
                    this.$router.push('searchAddress');
                }
            },

            searching() {
                if(this.searchDataInput == "")
                    return;
                var url = "/getSearchData";
                axios.post(url, {'searchData': this.searchDataInput})
                    .then(response => {
                        this.$session.set('searchKeyword', this.searchDataInput);
                        this.$session.set('searchData', response.data);

                        if(this.$route.path != '/search')
                            this.$router.push('/search');
                        else
                            this.$router.go(this.$router.currentRoute);
                    })
                    .catch(error => {
                        alert(error);
                    })
            },

            onScroll (e) {
                this.offsetTop = document.documentElement.scrollTop
                if(this.offsetTop >= 300) {
                    this.scrollTopButton = true;
                } else {
                    this.scrollTopButton = false;
                }
            },

            scrollToTop() {
                document.documentElement.scrollTop = 0;
            }
        }
    }
</script>
<style>
    @media screen and (max-width: 500px) {
        .logo1 {
            font-size: 0pt;
        }

        .logo2 {
            font-size: 14pt;
        }

        .logo-title {
            margin-left: 0px;
            letter-spacing: 0px;
        }
    }

    @media screen and (min-width: 500px) {

        .logo2 {
            font-size: 0pt;
        }
    }

    .searchBar {
        width: 100%;
        font-size: 20px;
        text-align: center;
    }
</style>