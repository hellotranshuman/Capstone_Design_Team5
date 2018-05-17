
<!-- 회원가입 -->
<template>
    <v-app>
        <v-container>
            <v-flex xs12 sm6 offset-sm3>
                <v-btn v-if="user_category" color="green" outline block large>개인 회원 수정</v-btn>
                <v-btn v-else color="red" outline block large>사업자 회원 수정</v-btn>
            </v-flex>
            <br>
            <v-flex xs12 sm6 offset-sm3>
                <v-card>
                    <v-card-text>
                        <v-text-field
                        v-model="user_id"
                        disabled
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
                <v-card v-if="user_category">
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
                    </v-card-text>
                </v-card>
            </v-flex>
            <v-flex xs12 sm6 offset-sm3>
                <br>
                <v-btn color="green" block outline large @click="editInfo()">정보 수정</v-btn>
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
                user_category:  true,
                user_id:        "",
                user_pw1:       "",
                user_pw2:       "",

                user_name:      "",
                user_gender:    true,
                user_year:      "",
                user_month:     "",
                user_day:       "",

                user_email:     "",
                user_country:   "",
                user_favorite:  [],

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

                snackbar:   false,
                snackText:  "",
                timeout:    3000
            }
        },

        mounted: function() {
            var url = "/getInfo"

            axios.post(url, {user_id : this.$session.get('user_id')})
                    .then(response => {
                        //console.log(response.data[0].category);
                        //this.user_category = response.data[0].category;
                        this.user_category  = response.data[0].category;
                        this.user_id        = response.data[0].user_id;
                        this.user_name      = response.data[0].name;
                        this.user_gender    = response.data[0].gender == '0' ? "Male" : "Female";
                        let user_birthday   = response.data[0].birthday.split('-');
                        this.user_year      = user_birthday[0];
                        this.user_month     = user_birthday[1];
                        this.user_day       = user_birthday[2];
                        this.user_email     = response.data[0].email;
                        this.user_country   = response.data[0].country;
                        if(this.user_category) {
                            this.user_favorite = [
                                response.data[0].favorite_1,
                                response.data[0].favorite_2,
                                response.data[0].favorite_3
                            ]
                        }
                    })
                    .catch(error => {
                        alert(error);
                    });
        },

        methods: {
            editInfo() {
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

                if(this.user_category) {
                    var temp = this.user_favorite;
                    if(temp[3]) {
                        this.snackbar = true;
                        this.snackText = "선호하는 음식은 최대 3가지 입니다.";
                        return;
                    }
                }

                var url = "/editInfo";

                var temp = {
                    user_id     : this.user_id,
                    password    : this.user_pw1,
                    email       : this.user_email,
                    name        : this.user_name,
                    country     : this.user_country,
                    birthday    : this.user_year + '-' + this.user_month + '-' + this.user_day,
                    category    : this.user_category,
                    gender      : this.user_gender,
                    favorite_1  : this.user_favorite[0],
                    favorite_2  : this.user_favorite[1],
                    favorite_3  : this.user_favorite[2],
                }

                axios.post(url, temp)
                    .then(response => {
                        location.replace("/");
                    })
                    .catch(error => {
                        alert(JSON.stringify(temp));
                    });
            }
        }
    }
</script>