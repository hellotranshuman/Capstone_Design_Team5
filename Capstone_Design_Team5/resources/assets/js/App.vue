<template>
    <div>
        <v-app>
            <v-navigation-drawer
                    app
                    v-model="menu"
                    disable-resize-watcher
                    temporary
                    hide-overlay
            ><!-- disable-resize-watcher: 화면 크기가 재조정 될 경우 자동으로 서랍을 열거나 닫는 것을 막음-->
                <v-toolbar flat class="transparent">
                    <v-list class="pa-0">
                        <v-list-tile avatar>
                            <v-list-tile-avatar>
                                <v-icon large>account_circle</v-icon>
                            </v-list-tile-avatar>
                            <v-list-tile-content>
                                <v-list-tile-title>김성준 님</v-list-tile-title>
                            </v-list-tile-content>
                        </v-list-tile>
                    </v-list>
                </v-toolbar>
                <v-list>
                    <v-divider></v-divider>
                    <v-list-tile @click="">
                        <v-list-tile-action>
                            <v-icon large>assignment</v-icon>
                        </v-list-tile-action>
                        <v-list-tile-content>
                            <v-list-tile-title>주문 내역</v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>
                    <v-list-tile @click="">
                        <v-list-tile-action>
                            <v-icon large>rate_review</v-icon>
                        </v-list-tile-action>
                        <v-list-tile-content>
                            <v-list-tile-title>리뷰 내역</v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>
                    <v-list-tile @click="">
                        <v-list-tile-action>
                            <v-icon large>loyalty</v-icon>
                        </v-list-tile-action>
                        <v-list-tile-content>
                            <v-list-tile-title>쿠폰함</v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>
                    <v-list-tile @click="">
                        <v-list-tile-action>
                            <v-icon large>favorite</v-icon>
                        </v-list-tile-action>
                        <v-list-tile-content>
                            <v-list-tile-title>찜목록</v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>
                    <v-list-tile @click="">
                        <v-list-tile-action>
                            <v-icon large>settings</v-icon>
                        </v-list-tile-action>
                        <v-list-tile-content>
                            <v-list-tile-title>설정</v-list-tile-title>
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
            </v-navigation-drawer>
            <v-container>
            <v-toolbar
                    app
                    color='amber lighten-1'
                    dark
                    scroll-off-screen
            ><!-- scroll-off-screen: 스크롤을 내리면 toolbar가 숨겨짐 -->
                <v-btn icon @click.native="menu = !menu">
                    <v-icon large>menu</v-icon>
                </v-btn>
                <v-text-field
                        flat
                        solo-inverted
                        prepend-icon="search"
                        label="Search"      
                >
                </v-text-field>
                <v-btn icon @click.native.stop="gps_modal = true">
                    <v-icon large color="red">gps_fixed</v-icon>
                </v-btn>
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
                                            <v-text-field placeholder="place" required></v-text-field>
                                        </v-flex>
                                        <v-spacer></v-spacer>
                                        <v-btn color="amber lighten-1" to="/search" @click.native="gps_search = false; gps_modal = false">검색</v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-dialog>
                            <v-btn color="red" @click.native="gps_modal = false">GPS로 위치 찾기</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
                <v-btn icon @click="loginForm = true">
                    <v-icon large color="blue">account_circle</v-icon>
                </v-btn>
            </v-toolbar>
            </v-container>
            <v-content>
                <v-container fluid>
                    <router-view></router-view>
                </v-container>
            </v-content>
            <v-dialog
                    v-model='loginForm'
                    max-width='290'
            >
                <v-card v-if="!getLoginStatus()">
                    <v-card-title>
                        <span class="headline">Login</span>
                    </v-card-title>
                    <v-card-text>
                        <v-form>
                            <v-text-field
                                    label="ID"
                                    required
                                    v-model='idValue'
                            ></v-text-field>
                            <v-text-field
                                    label="Password"
                                    type="password"
                                    required
                                    v-model='pwValue'
                            ></v-text-field>
                        </v-form>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="blue darken-1" flat @click="login()">로그인</v-btn>
                        <router-link :to="{name: 'register'}" style="text-decoration: none;">
                            <v-btn color="blue darken-1" flat @click="loginForm=false">회원가입</v-btn>
                        </router-link>
                    </v-card-actions>
                </v-card>
                <v-card v-else>
                    <v-card-title>
                        <span class="headline">User Information</span>
                    </v-card-title>
                    <v-card-text>
                        Hello, User!
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn v-if="getOwnerCheck()" color="blue darken-1" flat @click="">go to my restaurant</v-btn>
                        <v-btn color="blue darken-1" flat @click="logout()">Logout</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-app>
    </div>
</template>

<script>
    import axios  from 'axios';
    // 커뮤니케이션 버튼
    import UserCommunication from './components/user/user_communication/UserCommunication.vue';

    export default {
        data: () => ({
            menu: false,
            loginForm: false,
            gps_modal: false,
            gps_search: false,
            idValue: '',
            pwValue: '',

            communicationDialog: false,     // 커뮤니케이션 버튼을 통해 모달창을 출력하는데 사용
        }),

        components : {
            'UserCommunication' : UserCommunication,            //  커뮤니케이션 버튼
        },

        methods: {
            login() {
                var url = "/login";
                axios.post(url, {
                    user_id     : this.idValue,
                    password    : this.pwValue
                })
                    .then(function (response) {
                        alert(response.data.msg);
                        var loginFlag = response.data.login;
                        if(loginFlag) {
                            sessionStorage.setItem('loginStatus', true)
                            if(response.data.restaurantId != "/") {
                                sessionStorage.setItem('restaurantId', restaurantId);
                                location.replace("/owner" + response.data.link + "/menu");
                            } else 
                                location.replace("/");
                        }
                    })
                    .catch(function (error) {
                        alert('error!');
                    });
            },

            logout() {
                sessionStorage.clear();
                location.replace("logout");
            },

            getLoginStatus() {
                return sessionStorage.getItem('loginStatus');
            },

            getOwnerCheck() {
                return sessionStorage.getItem('restaurantId');
            }
        }
    }
</script>