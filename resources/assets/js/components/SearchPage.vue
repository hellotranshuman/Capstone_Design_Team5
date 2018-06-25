<template>
    <div>
        <v-layout row>
            <v-flex xs12 sm10 offset-sm1>
                <v-card-title class="headline orange--text">
                    {{ searchKeyword }} 검색 결과 <v-spacer></v-spacer>
                    <v-btn color="grey" flat @click="filter = true"><v-icon large>filter_list</v-icon>필터</v-btn>
                </v-card-title>
                <GoogleMap :currentCenter='{ lat: 35.8963134, lng: 128.6198624 }'></GoogleMap>
            </v-flex>
        </v-layout>
        <br>
        <v-layout row>
            <v-flex xs12 sm10 offset-sm1>
                <v-card>
                    <v-card-title class="headline orange--text">가게명 검색 결과</v-card-title>
                    <v-container fluid grid-list-sm>
                        <v-layout row wrap v-if="restaurantNameResult.length != 0">
                            <v-flex md4 xs12 v-for="(item, i) in restaurantNameResult" :key="i">
                                <v-card>
                                    <v-card-media
                                            :src="`/images/${item.id}/${item.id}_titleImg.jpg`"
                                            height="250px"
                                            @click="moveRestaurant(item.id)"
                                    ></v-card-media>
                                    <v-card-title class="headline">{{ item.name }}<v-spacer></v-spacer><span class="orange--text">{{ item.totalRating }}</span></v-card-title>
                                    <v-card-actions><h2>{{ item.dodobuken }} - {{ item.type }}</h2></v-card-actions>
                                </v-card>
                            </v-flex>
                        </v-layout>
                        <v-card-text v-else>
                            검색 결과가 없습니다.
                        </v-card-text>
                    </v-container>
                </v-card>
                <br>
                <v-card>
                    <v-card-title class="headline orange--text">지역명 검색 결과</v-card-title>
                    <v-container fluid grid-list-sm>
                        <v-layout row wrap v-if="restaurantAreaResult.length != 0">
                            <v-flex md4 xs12 v-for="(item, i) in restaurantAreaResult" :key="i">
                                <v-card>
                                    <v-card-media
                                            :src="`/images/${item.shop_id}/${item.shop_id}_titleImg.jpg`"
                                            height="250px"
                                            @click="moveRestaurant(item.shop_id)"
                                    ></v-card-media>
                                    <v-card-title class="headline">{{ item.shop_name }}<v-spacer></v-spacer><span class="orange--text">{{ item.totalRating }}</span></v-card-title>
                                    <v-card-actions><h2>{{ item.shop_address }} - {{ item.shop_type }}</h2></v-card-actions>
                                </v-card>
                            </v-flex>
                        </v-layout>
                        <v-card-text v-else>
                            검색 결과가 없습니다.
                        </v-card-text>
                    </v-container>
                </v-card>
                <br>
                <v-card>
                    <v-card-title class="headline orange--text">해시 태그 검색 결과</v-card-title>
                    <v-container fluid grid-list-sm>
                        <v-layout row wrap v-if="restaurantHashtagResult.length != 0">
                            <v-flex md4 xs12 v-for="(item, i) in restaurantHashtagResult" :key="i">
                                <v-card>
                                    <v-card-media
                                            :src="`/images/${item.shop_id}/${item.shop_id}_titleImg.jpg`"
                                            height="250px"
                                            @click="moveRestaurant(item.shop_id)"
                                    ></v-card-media>
                                    <v-card-title class="headline">{{ item.shop_name }}<v-spacer></v-spacer><span class="orange--text">{{ item.totalRating }}</span></v-card-title>
                                    <v-card-actions><h2>{{ item.shop_ddobuken }} - {{ item.shop_type }}</h2></v-card-actions>
                                </v-card>
                            </v-flex>
                        </v-layout>
                        <v-card-text v-else>
                            검색 결과가 없습니다.
                        </v-card-text>
                    </v-container>
                </v-card>
                <br>
            </v-flex>
        </v-layout>
        <v-dialog
                v-model="filter"
                fullscreen
                hide-overlay
                transition="dialog-bottom-transition"
                scrollable
        >
            <v-card>
                <v-toolbar>
                    <v-btn icon @click="filter = false">
                        <v-icon>close</v-icon>
                    </v-btn>
                    <v-toolbar-title>Fillter</v-toolbar-title>
                </v-toolbar>
                <v-card-text>
                    <v-divider></v-divider>
                    <span class="headline">검색 필터</span>
                    <v-radio-group v-model="option1" row>
                        <v-radio label="평점순" value="1" color="orange"></v-radio>
                        <v-radio label="인기순" value="2" color="orange"></v-radio>
                    </v-radio-group>
                    <v-divider></v-divider>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
    import GoogleMap from "./GoogleMap";
    import axios from 'axios';

    export default {
        components: {
            GoogleMap
        },
        data() {
            return {
                filter: false,
                option1: "1",
                searchKeyword: this.$session.get('searchKeyword'),
                restaurantNameResult: this.$session.get('searchData').shopSearchData,
                restaurantAreaResult: this.$session.get('searchData').regionSearchData,
                restaurantHashtagResult: this.$session.get('searchData').tagSearchData,
            }
        },

        created() {

        },

        methods: {
            moveRestaurant(shop_id) {
                this.$router.push('/restaurant/' + shop_id + '/info');
            },
        }
    }
</script>