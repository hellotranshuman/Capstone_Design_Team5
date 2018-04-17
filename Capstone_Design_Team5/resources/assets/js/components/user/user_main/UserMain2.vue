<template>
    <div>
        <v-flex xs12 sm8 offset-sm2>
            <v-card>
                <v-subheader><h1>현재 위치 : 후쿠오카 텐진</h1></v-subheader>
                <v-flex xs12 sm6 offset-sm3>
                    <template>
                        <div id="app">
                            <google-map :testCenter=testCenter></google-map>
                        </div>
                    </template>
                </v-flex>
            </v-card>
        </v-flex>
        <br>
        <v-layout row>
            <v-flex xs12 sm8 offset-sm2>
                <v-card>
                    <v-subheader><h1>최근 리뷰</h1></v-subheader>
                    <v-container fluid grid-list-sm>
                        <v-layout row wrap v-if="test">
                            <v-flex xs4 v-for="i in 3" :key="i">
                                <v-card-title primary-title>
                                    <h3 class="headline mb-0">{{test[i][0]}}</h3>
                                </v-card-title>
                                <v-card-media :src="`/images/${test[i][1]}.jpg`" height="200px"></v-card-media>
                                <v-card-actions>
                                    <v-btn flat color="orange" :to="`${test[i][2]}`" style="width: 33%">Info</v-btn>
                                    <v-btn flat color="orange" :to="`${test[i][3]}`" style="width: 33%">Menu</v-btn>
                                    <v-btn flat color="orange" :to="`${test[i][4]}`" style="width: 33%">Review</v-btn>
                                </v-card-actions>
                            </v-flex>
                        </v-layout>
                    </v-container>
                    <v-subheader><h1>나에게 맞는 가게</h1></v-subheader>
                    <v-container fluid grid-list-sm>
                        <v-layout row wrap v-if="test2">
                            <v-flex xs4 v-for="i in 3" :key="i">
                                <v-card-title primary-title>
                                    <h3 class="headline mb-0">{{test2[i][0]}}</h3>
                                </v-card-title>
                                <v-card-media :src="`/images/${test2[i][1]}.jpg`" height="200px"></v-card-media>
                                <v-card-actions>
                                    <v-btn flat color="orange" :to="`${test2[i][2]}`" style="width: 33%">Info</v-btn>
                                    <v-btn flat color="orange" :to="`${test2[i][3]}`" style="width: 33%">Menu</v-btn>
                                    <v-btn flat color="orange" :to="`${test2[i][4]}`" style="width: 33%">Review</v-btn>
                                </v-card-actions>
                            </v-flex>
                        </v-layout>
                    </v-container>
                </v-card>
            </v-flex>
        </v-layout>
    </div>
</template>

<script>
    import GoogleMap from "./../../GoogleMap";
    export default {
        name: "App",
        components: {
            GoogleMap
        },
        data(){
            return {
                test: [[], ["도쿄 아게야", 1, "/restaurant/1/info", "/restaurant/1/menu", "/restaurant/1/review"], ["시부야 텐야", 2, "/restaurant/2/info", "/restaurant/2/menu", "/restaurant/2/review"], ["오사카 우동", 3, "/restaurant/3/info", "/restaurant/3/menu", "/restaurant/3/review"]],
                test2: [[], ["오사카 요시노야", 4, "/restaurant/4/info", "/restaurant/4/menu", "/restaurant/4/review"], ["주부국제공항 오하기", 5, "/restaurant/5/info", "/restaurant/5/menu", "/restaurant/5/review"], ["도쿄 소바신", 6, "/restaurant/6/info", "/restaurant/6/menu", "/restaurant/6/review"]],
                key: "AIzaSyDTHKQzISVxAAfuBGp0HKj5GpMPNqR_Ovo",
                testCenter: {lat: 33.5882038, lng: 130.3989663}
            }
        }
    }
</script>

<style>

</style>