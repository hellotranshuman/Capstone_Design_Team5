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
                </v-list>

            </v-navigation-drawer>
            <v-toolbar
                    app
                    color='grey darken-3'
                    dark
                    scroll-off-screen
            ><!-- scroll-off-screen: 스크롤을 내리면 toolbar가 숨겨짐 -->
                <v-btn icon @click.native="menu = !menu">
                    <v-icon large>menu</v-icon>
                </v-btn>
                <v-toolbar-title style='width: 20vw'><router-link to="/" style="text-decoration: none" class="white--text">AIOF</router-link> <router-link :to="{ name: 'home' }" style="text-decoration: none" class="red--text">Restaurant</router-link></v-toolbar-title>
                <v-text-field
                        flat
                        solo-inverted
                        prepend-icon="search"
                        label="Search"
                        class="hidden-sm-and-down"
                ></v-text-field>
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
                <v-spacer></v-spacer><!-- 간격 -->
                <v-btn icon @click="loginForm = true">
                    <v-icon large color="blue">account_circle</v-icon>
                </v-btn>
            </v-toolbar>
            <v-content>
                <v-container fluid>
                    <router-view></router-view>
                </v-container>
            </v-content>
            <v-footer app></v-footer>
            <v-dialog
                    v-model='loginForm'
                    max-width='290'
            >
                <v-card>
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
            </v-dialog>
        </v-app>
    </div>
</template>

<script>
    import axios  from 'axios';
    export default {
        data: () => ({
            menu: false,
            loginForm: false,
            loginStatus: false,
            gps_modal: false,
            gps_search: false,
            idValue: '',
            pwValue: ''
        }),

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

                        if(loginFlag)
                            location.replace(response.data.link);
                    })
                    .catch(function (error) {
                        alert('error!');
                    });
            }
        }
    }
</script>