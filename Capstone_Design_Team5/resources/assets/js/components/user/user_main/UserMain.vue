<template>
    <div>
        <br>
        <v-card>
            <v-flex>
                <template>
                    <div id="app">
                        <google-map :testCenter=testCenter></google-map>
                    </div>
                </template>
            </v-flex>
        </v-card>
        <br>
        <v-layout row>
            <v-flex xs12 sm10 offset-sm1>
                <v-card>
                    <v-subheader><h1>최근 리뷰</h1></v-subheader>
                    <v-container fluid grid-list-sm>
                        <v-layout row wrap>
                            <v-flex>
                                <v-card-title primary-title>
                                    <h3 class="headline mb-0">{{test[1][0]}}</h3>
                                </v-card-title>
                                <v-card-media :src="`/images/${test[1][1]}.jpg`" height="200px"></v-card-media>
                                <v-card-actions>
                                    
                                </v-card-actions>
                            </v-flex>
                            <v-flex>
                                <v-card-title primary-title>
                                    <h3 class="headline mb-0">{{test[1][0]}}</h3>
                                </v-card-title>
                                <v-card-media :src="`/images/${test[1][1]}.jpg`" height="200px"></v-card-media>
                                <v-card-actions>
                                    
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
                test: [[], ["tokyo ageya", 1, "/restaurant/1/info", "/restaurant/1/menu", "/restaurant/1/review"], ["tokyo tenya", 2, "/restaurant/2/info", "/restaurant/2/menu", "/restaurant/2/review"], ["tokyo udon", 3, "/restaurant/3/info", "/restaurant/3/menu", "/restaurant/3/review"]],
                test2: [[], ["yoshinoya", 4, "/restaurant/4/info", "/restaurant/4/menu", "/restaurant/4/review"], ["ohagi", 5, "/restaurant/5/info", "/restaurant/5/menu", "/restaurant/5/review"], ["sobasin", 6, "/restaurant/6/info", "/restaurant/6/menu", "/restaurant/6/review"]],
                key: "AIzaSyDTHKQzISVxAAfuBGp0HKj5GpMPNqR_Ovo",
                testCenter: {lat: 35.8963134, lng: 128.6198624}
            }
        }
    }
</script>

<style>
#page-content_wrapper {
    width: 100%;
  }
</style>