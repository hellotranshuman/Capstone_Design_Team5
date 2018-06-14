<template>
    <div>
        <v-layout row>
            <v-flex xs12>
                <v-alert @click="open_gps_dialog()" :value="true" outline color="success" icon="gps_fixed" style="cursor:pointer">
                    {{ searchAddress[0] }}
                </v-alert>
                <GoogleMap :currentCenter=searchAddress[1]></GoogleMap>
            </v-flex>
        </v-layout>
        <br>
        <v-layout row>
            <v-flex xs12 sm10 offset-sm1>
                <v-card>
                    <v-card-title class="headline orange--text">지역별 평점 베스트</v-card-title>
                    <v-container fluid grid-list-sm>
                        <v-layout row wrap>
                            <v-flex md4 xs12 v-for="(item, i) in area" :key="i">
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
                    <v-card-title class="headline orange--text">식종 평점 베스트</v-card-title>
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
                <v-card v-if="$session.get('region') != '' || favoriteFood_1 != ''">
                    <v-card-title class="headline orange--text">사용자 맞춤</v-card-title>
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
    import GoogleMap from "../../GoogleMap";
    import axios from 'axios';
    export default {
        components: {
            GoogleMap
        },

        props: ['searchAddress'],

        data(){
            return {
                area: [
                    {
                        name: '도쿄 베스트 7',
                        src: '/images/toukyou.jpg',
                        postRegion: '東京',
                        center: { lat: 35.6693863, lng: 139.6012973 },
                        listLimit: 7
                    },
                    {
                        name: '오사카 베스트 7',
                        src: '/images/oosaka.jpg',
                        postRegion: '大阪',
                        center: { lat: 34.6784656, lng: 135.4601306 },
                        listLimit: 7
                    },
                    {
                        name: '교토 베스트 7',
                        src: '/images/kyouto.jpg',
                        postRegion: '京都',
                        center: { lat: 35.0061653, lng: 135.7259306 },
                        listLimit: 7
                    },
                    {
                        name: '후쿠오카 베스트 5',
                        src: '/images/hukuoka.jpg',
                        postRegion: '福岡',
                        center: { lat: 33.5988166, lng: 130.3522306 },
                        listLimit: 5
                    },
                    {
                        name: '삿포로 베스트 5',
                        src: '/images/hokkaido.jpg',
                        postRegion: '札幌',
                        center: { lat: 43.0595074, lng: 141.3354806 },
                        listLimit: 5
                    },
                    {
                        name: '오키나와 베스트 5',
                        src: '/images/okinawa.jpg',
                        postRegion: '沖縄',
                        center: { lat: 26.3628668, lng: 127.7787335 },
                        listLimit: 5
                    },
                ],

                food: [
                    {
                        name: '한식 베스트 10',
                        src: '/images/koreanFood.jpg'
                    },
                    {
                        name: '일식 베스트 10',
                        src: '/images/japaneseFood.jpg'
                    },
                    {
                        name: '중식 베스트 10',
                        src: '/images/chineseFood.jpg'
                    },
                ],

                favorite: [

                ],
            }
        },

        mounted() {
            if(this.$session.get('region')) {
                this.favorite.push({
                    name: this.$session.get('region'),
                    src: "/images/" + this.$session.get('region') + ".jpg"
                });
            }

            if(this.$session.get('favorite_1')) {
                this.favorite.push({
                    name: this.$session.get('favorite_1'),
                    src: "/images/" + this.$session.get('favorite_1') + ".jpg"
                });
                if(this.$session.get('favorite_2')) {
                    this.favorite.push({
                        name: this.$session.get('favorite_2'),
                        src: "/images/" + this.$session.get('favorite_2') + ".jpg"
                    });
                    if(this.$session.get('favorite_3')) {
                        this.favorite.push({
                            name: this.$session.get('favorite_3'),
                            src: "/images/" + this.$session.get('favorite_3') + ".jpg"
                        });
                    }
                }
            }
        },

        methods: {
            open_gps_dialog() {
                this.$parent.$parent.$parent.gps_search = true;
            },

            clickRestaurantList(postRegion, listLimit, postCenter) {
                var url = "/getRegionShopData";
                axios.post(url, {'region': postRegion, 'limit': listLimit})
                    .then(response => {
                        this.$router.push({ name: 'topList', params: { region: postRegion, listLimit: listLimit, topCenter: postCenter, restaurantList: response.data.regionShopData }})
                    })
                    .catch(error => {
                        alert(error);
                    })
            }
        }
    }
</script>

<style>

</style>