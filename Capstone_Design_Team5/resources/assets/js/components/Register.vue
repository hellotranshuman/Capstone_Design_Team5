
<!-- 회원가입 -->
<template>
    <v-app>
        <v-container>
            <v-flex xs12 sm6 offset-sm3>
                <v-btn color="green" outline block large @click="user_categoty = true">개인 회원</v-btn>
                <v-btn color="red" outline block large @click="user_categoty = false">사업자 회원</v-btn>
            </v-flex>
            <br>
            <v-flex xs12 sm6 offset-sm3>
                <v-card>
                    <v-card-text>
                        <v-text-field
                        v-model="user_id"
                        placeholder="ID"
                        required
                        color="green"
                        :rules="idRules"
                        ></v-text-field>
                        <v-text-field
                        v-model="user_pw1"
                        :append-icon="hidePw1 ? 'visibility' : 'visibility_off'"
                        :append-icon-cb="() => (hidePw1 = !hidePw1)"
                        :type="hidePw1 ? 'password' : 'text'"
                        label="Enter your password"
                        color="green"
                        :rules="pwRules"
                        ></v-text-field>
                        <v-text-field
                        v-model="user_pw2"
                        :append-icon="hidePw2 ? 'visibility' : 'visibility_off'"
                        :append-icon-cb="() => (hidePw2 = !hidePw2)"
                        :type="hidePw2 ? 'password' : 'text'"
                        label="Enter your password confirm"
                        color="green"
                        :rules="pwRules"
                        ></v-text-field>
                    </v-card-text>
                </v-card>
                <br>
                <v-card>
                    <v-card-text>
                        <v-text-field
                        v-model="user_name"
                        placeholder="Name"
                        required
                        color="green"
                        ></v-text-field>
                        <v-radio-group v-model="user_gender" row>
                            <v-radio label="Male" value="Male" color="green"></v-radio>
                            <v-radio label="Female" value="Female" color="green"></v-radio>
                        </v-radio-group>
                        <v-layout row wrap>
                            <v-flex xs4>
                                <v-text-field
                                v-model="user_year"
                                placeholder="Year"
                                required
                                color="green"
                                ></v-text-field>
                            </v-flex>
                            <v-flex xs4>
                                <v-select
                                v-model="user_month"
                                :items="month"
                                label="Month"
                                color="green"
                                single-line
                                ></v-select>
                            </v-flex>
                            <v-flex xs4>
                                <v-text-field
                                v-model="user_day"
                                placeholder="Day"
                                required
                                append-icon="cake"
                                color="green"></v-text-field>
                            </v-flex>
                        </v-layout>
                        <v-text-field
                        v-model="user_email"
                        placeholder="Email"
                        required
                        append-icon="email"
                        color="green"></v-text-field>
                        <v-select
                        v-model="user_country"
                        :items="country"
                        label="Country"
                        single-line
                        auto
                        append-icon="language"
                        hide-details
                        color="green"
                        ></v-select>
                    </v-card-text>
                </v-card>
                <br>
                <v-card v-if="user_categoty">
                    <v-card-text>
                        <v-select
                        v-model="user_favorite"
                        :items="food"
                        label="Favorite Food (max 3 items)"
                        single-line
                        auto
                        hide-details
                        multiple
                        chips
                        color="green"
                        ></v-select>
                        <v-select
                        v-model="user_region"
                        :items="ddbkList"
                        label="Favorite Region"
                        single-line
                        auto
                        append-icon="location_on"
                        hide-details
                        chips
                        color="green"
                        ></v-select>
                    </v-card-text>
                </v-card>
            </v-flex>
            <v-flex v-if="user_categoty" xs12 sm6 offset-sm3>
                <br>
                <v-btn color="green" block outline large @click="register()">개인 회원 가입</v-btn>
            </v-flex>
            <v-flex v-else xs12 sm6 offset-sm3>
                <v-btn color="red" block outline large @click="register()">사업자 회원 가입</v-btn>
            </v-flex>
        </v-container>
        <v-snackbar
        v-model="snackbar"
        :timeout="timeout"
        top
        vertical
        >
        {{ snackText }}
        <v-btn flat color="pink" @click.native="snackbar = false">Close</v-btn>
        </v-snackbar>
    </v-app>
</template>

<script>
    import axios  from 'axios';
    export default {
        data() {
            return {
                user_categoty:  true,
                user_id:        "",
                user_pw1:       "",
                user_pw2:       "",

                user_name:      "",
                user_gender:    "",
                user_year:      "",
                user_month:     "",
                user_day:       "",

                user_email:     "",
                user_country:   "",
                user_favorite:  "",
                user_region:    "",

                hidePw1: true,
                hidePw2: true,

                idRules: [
                    v => !!v || 'ID is required'
                ],
                pwRules: [
                    v => !!v || 'Password is required'
                ],
                month: [
                    '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'
                ],
                country: [
                    'Korea', 'Japan', 'China', 'USA'
                ],
                food: [
                    '한식', '일식', '중식', '양식', '분식', '덮밥', '스시', '패스트 푸드', '찜', '탕',
                    '도시락', '카페&디저트', '술집', '면류', '제과'
                ],
                ddbkList : [
                    '東京', '北海道', '札幌', '京都',
                    '大阪', '靑森', '岩手', '宮城',
                    '秋田', '山形', '福島', '茨城',
                    '栃木', '群馬', '埼玉', '千葉',
                    '神奈川', '新潟', '富山', '石川',
                    '福井', '山梨', '長野', '岐阜',
                    '靜岡', '愛知', '三重', '滋賀',
                    '兵庫', '奈良', '和歌山', '鳥取', 
                    '島根', '岡山', '廣島', '山口',
                    '德島', '香川', '愛媛', '高知',
                    '福岡', '佐賀', '長崎', '熊本',
                    '大分', '宮崎', '鹿兒島', '沖繩'
                ],

                snackbar:   false,
                snackText:  "",
                timeout:    3000
            }
        },

        methods: {
            register() {
                if(this.user_id == "") {
                    this.snackbar = true;
                    this.snackText = "아이디는 필수 입력 사항입니다.";
                    return;
                }

                if(this.user_pw1 == "") {
                    this.snackbar = true;
                    this.snackText = "비밀번호는 필수 입력 사항입니다.";
                    return;
                }

                if(this.user_pw1 != this.user_pw2) {
                    this.snackbar = true;
                    this.snackText = "비밀번호와 비밀번호 확인이 서로 다릅니다.";
                    return;
                }

                if(this.user_name == "") {
                    this.snackbar = true;
                    this.snackText = "이름은 필수 입력 사항입니다.";
                    return;
                }

                if(this.user_gender == "") {
                    this.snackbar = true;
                    this.snackText = "성별은 필수 입력 사항입니다.";
                    return;
                }

                if(this.user_year == "" || this.user_month == "" || this.user_day == "") {
                    this.snackbar = true;
                    this.snackText = "생년월일은 필수 입력 사항입니다.";
                    return;
                }

                if(this.user_year < 1900 || this.user_year > 2018) {
                    this.snackbar = true;
                    this.snackText = "년도를 확인해주세요.";
                    return;
                }

                if(this.user_email == "") {
                    this.snackbar = true;
                    this.snackText = "이메일은 필수 입력 사항입니다.";
                    return;
                }

                if(this.user_country == "") {
                    this.snackbar = true;
                    this.snackText = "국가는 필수 입력 사항입니다.";
                    return;
                }

                if(this.user_categoty) {
                    var temp = this.user_favorite;
                    if(temp[3]) {
                        this.snackbar = true;
                        this.snackText = "선호하는 음식은 최대 3가지 입니다.";
                        return;
                    }
                }

                var url = "/register";

                var sendData = {
                    user_id         : this.user_id,
                    password        : this.user_pw1,
                    email           : this.user_email,
                    name            : this.user_name,
                    country         : this.user_country,
                    birthday        : this.user_year + '-' + this.user_month + '-' + this.user_day,
                    category        : this.user_categoty,
                    gender          : this.user_gender,
                    favorite_1      : this.user_favorite[0],
                    favorite_2      : this.user_favorite[1],
                    favorite_3      : this.user_favorite[2],
                    favorite_region : this.user_region
                }

                axios.post(url, sendData)
                    .then(response => {
                        var url = response.data.url;
                        location.replace(url);
                    })
                    .catch(error => {
                        alert(error);
                    });
            }
        }
    }
</script>