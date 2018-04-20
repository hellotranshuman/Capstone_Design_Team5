
<!-- 회원가입 -->
<template>
    <v-app>
        <v-layout row justify-center>
            <v-dialog v-model="dialog" persistent max-width="500px">
                <v-btn round color="success" slot="activator" style="width: 30vw; height: 50vh">개인 회원</v-btn>
                <v-card>
                    <v-card-title>
                        <span class="headline">개인 회원 가입</span>
                    </v-card-title>
                    <v-card-text>
                        <v-container grid-list-md>
                            <v-layout wrap>
                                <v-flex xs12>
                                    <v-text-field v-model="F_user_id" placeholder="ID" required></v-text-field>
                                </v-flex>
                                <v-flex xs12>
                                    <v-text-field v-model="F_user_email" placeholder="Email" required></v-text-field>
                                </v-flex>
                                <v-flex xs12>
                                    <v-text-field v-model="F_user_name" placeholder="Name" required></v-text-field>
                                </v-flex>
                                <v-flex xs12 sm6>
                                    <v-text-field v-model="F_password" placeholder="Password" type="password" required></v-text-field>
                                </v-flex>
                                <v-flex xs12 sm6>
                                    <v-text-field v-model="F_C_password" placeholder="Confirm Password" type="password" required></v-text-field>
                                </v-flex>
                                <v-flex xs12>
                                    <v-radio-group v-model="F_sexValue" :mandatory="false">
                                        <v-radio label="Male" value="male" default></v-radio>
                                        <v-radio label="Female" value="female"></v-radio>
                                    </v-radio-group>
                                </v-flex>
                                <v-flex xs12>
                                    <v-select v-model="F_country"
                                              placeholder="Country"
                                              required
                                              :items="['한국', '日本', 'USA']"
                                    ></v-select>
                                </v-flex>
                                <v-flex xs12 sm3>
                                    <v-select v-model="F_year"
                                              placeholder="Year"
                                              required
                                              :items="['1995', '1996', '1997', '1998', '1999', '2000', '2001', '2002', '2003', '2004', '2005', '2006', '2007']"
                                    ></v-select>
                                </v-flex>
                                <v-flex xs12 sm3>
                                    <v-select v-model="F_month"
                                              placeholder="Month"
                                              required
                                              :items="['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12']"
                                    ></v-select>
                                </v-flex>
                                <v-flex xs12 sm3>
                                    <v-select v-model="F_day"
                                              placeholder="Day"
                                              required
                                              :items="['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31']"
                                    ></v-select>
                                </v-flex>
                            </v-layout>
                        </v-container>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="blue darken-1" flat @click.native="dialog = false">Close</v-btn>
                        <v-btn color="blue darken-1" flat @click.native="register()">Register</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
            <v-dialog v-model="dialog2" persistent max-width="500px">
                <v-btn round color="error" slot="activator" style="width: 30vw; height: 50vh">사업자 회원</v-btn>
                <v-card>
                    <v-card-title>
                        <span class="headline">사업자 회원 가입</span>
                    </v-card-title>
                    <v-card-text>
                        <v-container grid-list-md>
                            <v-layout wrap>
                                <v-flex xs12>
                                    <v-text-field v-model="F_user_id" placeholder="ID" required></v-text-field>
                                </v-flex>
                                <v-flex xs12>
                                    <v-text-field v-model="F_user_email" placeholder="Email" required></v-text-field>
                                </v-flex>
                                <v-flex xs12>
                                    <v-text-field v-model="F_user_name" placeholder="Name" required></v-text-field>
                                </v-flex>
                                <v-flex xs12 sm6>
                                    <v-text-field v-model="F_password" placeholder="Password" type="password" required></v-text-field>
                                </v-flex>
                                <v-flex xs12 sm6>
                                    <v-text-field v-model="F_C_password" placeholder="Confirm Password" type="password" required></v-text-field>
                                </v-flex>
                                <v-flex xs12>
                                    <v-radio-group v-model="F_sexValue" :mandatory="false">
                                        <v-radio label="Male" value="male" default></v-radio>
                                        <v-radio label="Female" value="famale"></v-radio>
                                    </v-radio-group>
                                </v-flex>
                                <v-flex xs12>
                                    <v-select v-model="F_country"
                                              placeholder="Country"
                                              required
                                              :items="['한국', '日本', 'USA']"
                                    ></v-select>
                                </v-flex>
                                <v-flex xs12 sm3>
                                    <v-select v-model="F_year"
                                              placeholder="Year"
                                              required
                                              :items="['1995', '1996', '1997', '1998', '1999', '2000', '2001', '2002', '2003', '2004', '2005', '2006', '2007']"
                                    ></v-select>
                                </v-flex>
                                <v-flex xs12 sm3>
                                    <v-select v-model="F_month"
                                              placeholder="Month"
                                              required
                                              :items="['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12']"
                                    ></v-select>
                                </v-flex>
                                <v-flex xs12 sm3>
                                    <v-select v-model="F_day"
                                              placeholder="Day"
                                              required
                                              :items="['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31']"
                                    ></v-select>
                                </v-flex>
                            </v-layout>
                        </v-container>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="blue darken-1" flat @click.native="dialog2 = false">Close</v-btn>
                        <v-btn color="blue darken-1" flat @click.native="register2()">Register</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-layout>
    </v-app>
</template>

<script>
    import axios  from 'axios';
    export default {
        data: () => ({
            dialog: false,
            dialog2: false,
            F_sexValue: "male",
            F_user_id: "",
            F_user_email: "",
            F_user_name: "",
            F_password: "",
            F_C_password: "",
            F_country: "한국",
            F_year: "",
            F_month: "",
            F_day: ""
        }),

        methods: {
            register() {
                var url = "/register";
                axios.post(url, {
                    user_id     : this.F_user_id,
                    password    : this.F_password,
                    c_password  : this.F_C_password,
                    email       : this.F_user_email,
                    name        : this.F_user_name,
                    country     : this.F_country,
                    birthday    : this.F_year + '-' + this.F_month + '-' + this.F_day,
                    category    : 'user',
                    gender      : this.F_sexValue,
                })
                    .then(function (response) {
                       alert(response.data.msg);
                    })
                    .catch(function (error) {
                        alert('error!');
                    });
            },
            register2() {
                var url = "/register";
                axios.post(url, {
                    user_id     : this.F_user_id,
                    password    : this.F_password,
                    c_password  : this.F_C_password,
                    email       : this.F_user_email,
                    name        : this.F_user_name,
                    country     : this.F_country,
                    birthday    : this.F_year + '-' + this.F_month + '-' + this.F_day,
                    category    : 'owner',
                    gender      : this.F_sexValue,
                })
                    .then(function (response) {
                       var url = response.data.url;

                       location.replace(url);
                    })
                    .catch(function (error) {
                        alert('error!');
                    });
            }
        }
    }
</script>