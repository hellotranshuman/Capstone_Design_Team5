<template>
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
        <v-toolbar-title style='width: 20vw'>AIOF <span class='red--text'>Restaurant</span></v-toolbar-title>
        <v-text-field
        flat
        solo-inverted
        prepend-icon="search"
        label="Search"
        class="hidden-sm-and-down"
        ></v-text-field>
        <v-btn icon>
        <v-icon large color="red">gps_fixed</v-icon>
        </v-btn>
        <v-spacer></v-spacer><!-- 간격 -->
        <v-btn icon @click="login = true">
        <v-icon large color="blue">account_circle</v-icon>
        </v-btn>
        </v-toolbar>
        <v-dialog
        v-model='login'
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
                        ></v-text-field>
                        <v-text-field
                        label="Password"
                        type="password"
                        required
                        ></v-text-field>
                    </v-form>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" flat>로그인</v-btn>
                    <router-link :to="{name: 'userregister'}" style="text-decoration: none;">
                        <v-btn color="blue darken-1" flat>회원가입</v-btn>
                    </router-link>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-app>
</template>

<script>
    export default {
        data: () => ({
            menu: false,
            login: false
        })
    }
</script>

<style>

</style>