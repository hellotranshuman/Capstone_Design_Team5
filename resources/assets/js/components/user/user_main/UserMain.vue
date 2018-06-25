<template>
    <div>
        <v-card>
            <v-card-media
                    class="white--text"
                    src="images/main.jpg"
                    height="350px"
            >
                <v-container fill-height fluid>
                    <v-layout fill-height>
                        <v-flex fill-height>
                            <v-card-title
                                    class="titleText"
                            ><strong>
                                두렵지 않은 해외 여행<br>
                                맛있는 추천, <span class="orange--text">SMART</span> <span class="red--text">S</span>
                            </strong>
                            </v-card-title>
                            <v-card-actions>
                                <v-text-field
                                        v-model="$parent.$parent.$parent.searchDataInput"
                                        prepend-icon="search"
                                        color="grey"
                                        solo
                                        label="식당 또는 음식"
                                        @keypress.enter="$parent.$parent.$parent.searching()"
                                ></v-text-field>
                                <v-btn color="orange" large @click="$parent.$parent.$parent.searching()">검색</v-btn>
                            </v-card-actions>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-card-media>
        </v-card>
        <br>
        <v-layout row>
            <v-flex xs12 sm10 offset-sm1>
                <v-card v-if="$session.get('region') != undefined || $session.get('favorite_1') != undefined">
                    <v-card-title class="headline orange--text">사용자 맞춤</v-card-title>
                    <v-container fluid grid-list-sm>
                        <v-layout row wrap>
                            <v-flex md4 xs12 v-for="(item, i) in favorite" :key="i">
                                <v-card>
                                    <v-card-media
                                            class="white--text"
                                            :src="item.src"
                                            height="200px"
                                            @click="item.function(item.name, item.listLimit)"
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
                    <v-card-title class="headline orange--text">지역별 평점 베스트</v-card-title>
                    <v-container fluid grid-list-sm>
                        <v-layout row wrap>
                            <v-flex md4 xs12 v-for="(item, i) in area" :key="i">
                                <v-card>
                                    <v-card-media
                                            class="white--text"
                                            :src="item.src"
                                            height="200px"
                                            @click="clickRegionList(item.postRegion, item.listLimit, item.showRegion)"
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
                                            @click="clickTypeList(item.postType, item.listLimit)"
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
                        showRegion: '도쿄',
                        listLimit: 7
                    },
                    {
                        name: '오사카 베스트 7',
                        src: '/images/oosaka.jpg',
                        postRegion: '大阪',
                        showRegion: '오사카',
                        listLimit: 7
                    },
                    {
                        name: '교토 베스트 7',
                        src: '/images/kyouto.jpg',
                        postRegion: '京都',
                        showRegion: '교토',
                        listLimit: 7
                    },
                    {
                        name: '후쿠오카 베스트 5',
                        src: '/images/hukuoka.jpg',
                        postRegion: '福岡',
                        showRegion: '후쿠오카',
                        listLimit: 5
                    },
                    {
                        name: '삿포로 베스트 5',
                        src: '/images/hokkaido.jpg',
                        postRegion: '札幌',
                        showRegion: '삿포로',
                        listLimit: 5
                    },
                    {
                        name: '오키나와 베스트 5',
                        src: '/images/okinawa.jpg',
                        postRegion: '沖縄',
                        showRegion: '오키나와',
                        listLimit: 5
                    },
                ],

                food: [
                    {
                        name: '한식 베스트 10',
                        src: '/images/koreanFood.jpg',
                        postType: '한식',
                        listLimit: 10
                    },
                    {
                        name: '일식 베스트 10',
                        src: '/images/japaneseFood.jpg',
                        postType: '일식',
                        listLimit: 10
                    },
                    {
                        name: '중식 베스트 10',
                        src: '/images/chineseFood.jpg',
                        postType: '중식',
                        listLimit: 10
                    },
                ],

                favorite: [

                ],

                translateValue: {
                    '東京': 'toukyou',
                    '北海度': 'hokkaido',
                    '大阪': 'toukyou',
                    '京都': 'toukyou',
                    '東京': 'toukyou',
                    '東京': 'toukyou',
                    '東京': 'toukyou',
                    '東京': 'toukyou',
                    '한식': 'koreanFood',
                    '일식': 'japaneseFood',
                    '중식': 'chineseFood',
                    '양식': 'westernfood',
                    '분식': 'bunsik',
                    '덮밥': 'dupbab',
                    '스시': 'sushi',
                    '패스트 푸드': 'fastfood',
                    '찜': 'jjim',
                    '탕': 'tang',
                    '도시락': 'bento',
                    '카페&디저트': 'cafe',
                    '술집': 'osake',
                    '면류': 'men',
                    '제과': 'bbang',
                    '': '',
                }
            }
        },

        mounted() {
            if(this.$session.get('region')) {
                this.favorite.push({
                    name: this.$session.get('region'),
                    src: "/images/" + this.translate(this.$session.get('region')) + ".jpg",
                    function: this.clickRegionList,
                    listLimit: 5
                });
            }

            if(this.$session.get('favorite_1')) {
                this.favorite.push({
                    name: this.$session.get('favorite_1'),
                    src: "/images/" + this.translate(this.$session.get('favorite_1')) + ".jpg",
                    function: this.clickTypeList,
                    listLimit: 5
                });
                if(this.$session.get('favorite_2')) {
                    this.favorite.push({
                        name: this.$session.get('favorite_2'),
                        src: "/images/" + this.translate(this.$session.get('favorite_2')) + ".jpg",
                        function: this.clickTypeList,
                        listLimit: 5
                    });
                    if(this.$session.get('favorite_3')) {
                        this.favorite.push({
                            name: this.$session.get('favorite_3'),
                            src: "/images/" + this.translate(this.$session.get('favorite_3')) + ".jpg",
                            function: this.clickTypeList,
                            listLimit: 5
                        });
                    }
                }
            }
        },

        methods: {
            clickRegionList(postRegion, listLimit, showRegion) {
                var url = "/getRegionShopData";
                axios.post(url, {'region': postRegion, 'limit': listLimit})
                    .then(response => {
                        this.$session.set('top_mode', 'region');
                        this.$session.set('top_region', postRegion);
                        this.$session.set('top_show_region', showRegion);
                        this.$session.set('top_listLimit', listLimit);
                        this.$session.set('top_restaurantList', response.data.regionShopData);
                        this.$router.push('topList');
                    })
                    .catch(error => {
                        alert(error);
                    })
            },

            clickTypeList(postType, listLimit, postCenter) {
                var url = "/getTypeShopData";
                axios.post(url, {'type': postType, 'limit': listLimit})
                    .then(response => {
                        this.$session.set('top_mode', 'type');
                        this.$session.set('top_type', postType);
                        this.$session.set('top_listLimit', listLimit);
                        this.$session.set('top_restaurantList', response.data.typeShopData);
                        this.$router.push('topList');
                    })
                    .catch(error => {
                        alert(error);
                    })
            },

            translate(value) {
                return this.translateValue[value];
            },
        }
    }
</script>

<style>
    .titleText {
        font-size: 22pt
    }
</style>