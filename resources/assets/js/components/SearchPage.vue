<template>
    <div>
        <v-layout row>
            <v-flex xs12>
                <v-alert :value="true" outline color="info" icon="search">
                    "{{ searchKeyword }}" 검색 결과
                </v-alert>
                <GoogleMap :currentCenter='{ lat: 35.8963134, lng: 128.6198624 }'></GoogleMap>
            </v-flex>
        </v-layout>
        <br>
        <v-layout row>
            <v-flex xs12 sm10 offset-sm1>
                <v-card>
                    <v-card-title class="headline orange--text">가게명 검색 결과</v-card-title>
                    <v-container fluid grid-list-sm>
                        <v-layout row wrap>
                            <v-flex md4 xs12 v-for="(item, i) in restaurantNameResult" :key="i">
                                <v-card>
                                    <v-card-media
                                        :src="`/images/${item.id}/${item.id}_titleImg.jpg`"
                                        height="250px"
                                        @click="moveRestaurant(item.id)"
                                    ></v-card-media>
                                    <v-card-title class="headline">{{ item.name }}<v-spacer></v-spacer><span class="orange--text">{{ item.totalRating }}</span></v-card-title>
                                    <v-card-actions>{{ item.dodobuken }} - {{ item.type }}</v-card-actions>
                                </v-card>
                            </v-flex>
                        </v-layout>
                    </v-container>
                </v-card>
                <br>
                <v-card>
                    <v-card-title class="headline orange--text">지역명 검색 결과</v-card-title>
                    <v-container fluid grid-list-sm>
                        <v-layout row wrap>
                            <v-flex md4 xs12 v-for="(item, i) in food" :key="i">
                                <v-card>
                                    <v-card-media
                                        class="white--text"
                                        :src="item.src"
                                        height="200px"
                                        @click="clickRestaurantList(item.postRegion, item.listLimit, item.center)"
                                    >
                                    <v-container fill-height fluid>
                                        <v-layout fill-height>
                                            <v-flex xs12 align-end flexbox>
                                                <span class="headline"><b>{{ item.name }}</b></span>
                                            </v-flex>
                                        </v-layout>
                                    </v-container>
                                    </v-card-media>
                                </v-card>
                            </v-flex>
                        </v-layout>
                    </v-container>
                </v-card>
                <br>
                <v-card>
                    <v-card-title class="headline orange--text">해시 태그 검색 결과</v-card-title>
                    <v-container fluid grid-list-sm>
                        <v-layout row wrap>
                            <v-flex md4 xs12 v-for="(item, i) in favorite" :key="i">
                                <v-card>
                                    <v-card-media
                                        class="black--text"
                                        :src="item.src"
                                        height="200px"
                                        @click="clickRestaurantList(item.postRegion, item.listLimit, item.center)"
                                    >
                                    <v-container fill-height fluid>
                                        <v-layout fill-height>
                                            <v-flex xs12 align-end flexbox>
                                                <span class="headline"><b>{{ item.name }}</b></span>
                                            </v-flex>
                                        </v-layout>
                                    </v-container>
                                    </v-card-media>
                                </v-card>
                            </v-flex>
                        </v-layout>
                    </v-container>
                </v-card>
                <br>
            </v-flex>
        </v-layout>
    </div>
</template>

<script>
    import GoogleMap from "./GoogleMap";
    import axios from 'axios';
    
    export default {
        components: {
            GoogleMap
        },
        props: ['searchData'],
        data() {
            return {
                searchKeyword: this.$session.get('searchKeyword'),
                restaurantNameResult: this.$session.get('searchData').shopSearchData,
                restaurantAreaResult: this.$session.get('searchData').regionSearchData,
                restaurantHashtagResult: this.$session.get('searchData').searchDatatagSearchData,
                food: {},
                favorite: {},
            }
        },

        mounted: function() {
            console.log(this.$session.get('searchData'));
        },

        methods: {
            moveRestaurant(shop_id) {
                this.$router.push('/restaurant/' + shop_id + '/info');
            }
        }
    }
</script>