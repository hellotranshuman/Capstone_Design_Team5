<template>
    <div>
        <div style="background-color: #ff9a55; height: 10px"></div>
        <v-card>
            <v-jumbotron
                    gradient="
                    rgba(0,0,0,0),
                    rgba(0,0,0,0.3),
                    rgba(0,0,0,0)"
                    :src="require('../../../../../../storage/app/public/img/main.png')"
                    height="500px"
            >
                <v-container fill-height fluid>
                    <v-layout fill-height>
                        <v-flex fill-height>
                            <v-card-title>
                                <v-layout align-center justify-center column fill-height>
                                    <img src="../../../../../../storage/app/public/img/title_logo.png" style="width: 200px">
                                    <br>
                                    <strong v-if="$session.get('user_country') == 'Korea'" class="white--text text-xs-center title-text-size">
                                        두렵지 않은 해외 여행<br>
                                        맛있는 추천
                                    </strong>
                                    <strong v-else-if="$session.get('user_country') == 'USA'" class="white--text text-xs-center title-text-size">
                                        Very simple overseas trip<br>
                                        Delicious recommedation
                                    </strong>
                                    <strong v-else-if="$session.get('user_country') == 'China'" class="white--text text-xs-center title-text-size">
                                        두렵지 않은 해외 여행<br>
                                        맛있는 추천
                                    </strong>
                                    <strong v-else class="white--text text-xs-center title-text-size">
                                        怖がらずに堂々と海外旅行<br>
                                        美味しいおすすめ
                                    </strong>
                                </v-layout>
                            </v-card-title>
                            <v-card-actions>
                                <v-text-field
                                        v-model="$parent.$parent.$parent.searchDataInput"
                                        prepend-icon="search"
                                        color="orange"
                                        solo
                                        :label=labelSearch
                                        @keypress.enter="$parent.$parent.$parent.searching()"
                                ></v-text-field>
                                <v-btn color="orange" large @click="$parent.$parent.$parent.searching()">검색</v-btn>
                            </v-card-actions>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-jumbotron>
        </v-card>
        <v-layout row>
            <v-flex xs12 sm10 offset-sm1>
                <div style="background-color: #ff9a55; height: 10px"></div>
                <v-card>
                    <div v-if="$session.get('region') != undefined || $session.get('favorite_1') != undefined">
                        <v-alert
                                :value="true"
                                color="brown"
                                outline
                                class="text-xs-center display-1 mx-4"
                        >
                            <strong class="bestBanner">{{ userRecommend }}</strong>
                        </v-alert>
                        <v-container fluid grid-list-sm>
                            <v-layout row wrap>
                                <v-flex md4 xs12 v-for="(item, i) in favorite" :key="i">
                                    <div style="background-color: #ff9a55; height: 5px"></div>
                                    <v-card>
                                        <div @click="item.function(item.name, item.listLimit)">
                                            <v-jumbotron
                                                    gradient="to right,
                                                rgba(0,0,0,0.8),
                                                rgba(0,0,0,0),
                                                rgba(0,0,0,0)"
                                                    :src="item.src"
                                                    height="200px"
                                            >
                                                <v-container fill-height fluid>
                                                    <v-layout align-end justify-start row fill-height>
                                                        <span class="display-1 white--text"><b>{{ translateKor(item.name) }}<br><span class="bestText">Best {{ item.listLimit }}</span></b></span>
                                                    </v-layout>
                                                </v-container>
                                            </v-jumbotron>
                                        </div>
                                    </v-card>
                                </v-flex>
                            </v-layout>
                        </v-container>
                    </div>
                    <br>
                    <v-alert
                            :value="true"
                            color="brown"
                            outline
                            class="text-xs-center display-1 mx-4"
                    >
                        <strong class="bestBanner">{{ regionRecommend }}</strong>
                    </v-alert>
                    <v-container fluid grid-list-sm>
                        <v-layout row wrap>
                            <v-flex md4 xs12 v-for="(item, i) in area" :key="i">
                                <div style="background-color: #ff9a55; height: 5px"></div>
                                <v-card>
                                    <div @click="clickRegionList(item.postRegion, item.listLimit, item.showRegion)">
                                        <v-jumbotron
                                                gradient="to right,
                                                    rgba(0,0,0,0.8),
                                                    rgba(0,0,0,0),
                                                    rgba(0,0,0,0)"
                                                :src="item.src"
                                                height="200px"
                                        >
                                            <v-container fill-height fluid>
                                                <v-layout align-end justify-start row fill-height>
                                                    <span class="display-1 white--text"><b>{{ item.name }}<br><span class="bestText">Best {{ item.listLimit }}</span></b></span>
                                                </v-layout>
                                            </v-container>
                                        </v-jumbotron>
                                    </div>
                                </v-card>
                            </v-flex>
                        </v-layout>
                    </v-container>
                    <br>
                    <v-alert
                            :value="true"
                            color="brown"
                            outline
                            class="text-xs-center display-1 mx-4"
                    >
                        <strong class="bestBanner">{{ typeRecommend }}</strong>
                    </v-alert>
                    <v-container fluid grid-list-sm>
                        <v-layout row wrap>
                            <v-flex md4 xs12 v-for="(item, i) in food" :key="i">
                                <div style="background-color: #ff9a55; height: 5px"></div>
                                <v-card>
                                    <div @click="clickTypeList(item.postType, item.listLimit)">
                                        <v-jumbotron
                                                gradient="to right,
                                                    rgba(0,0,0,0.8),
                                                    rgba(0,0,0,0),
                                                    rgba(0,0,0,0)"
                                                :src="item.src"
                                                height="200px"
                                        >
                                            <v-container fill-height fluid>
                                                <v-layout align-end justify-start row fill-height>
                                                    <span class="display-1 white--text"><b>{{ item.name }}<br><span class="bestText">Best {{ item.listLimit }}</span></b></span>
                                                </v-layout>
                                            </v-container>
                                        </v-jumbotron>
                                    </div>
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
                        name: '東京',
                        src: '/images/toukyou.jpg',
                        postRegion: '東京',
                        showRegion: '도쿄',
                        listLimit: 7
                    },
                    {
                        name: '大阪',
                        src: '/images/oosaka.jpg',
                        postRegion: '大阪',
                        showRegion: '오사카',
                        listLimit: 7
                    },
                    {
                        name: '京都',
                        src: '/images/kyouto.jpg',
                        postRegion: '京都',
                        showRegion: '교토',
                        listLimit: 7
                    },
                    {
                        name: '福岡',
                        src: '/images/hukuoka.jpg',
                        postRegion: '福岡',
                        showRegion: '후쿠오카',
                        listLimit: 5
                    },
                    {
                        name: '札幌',
                        src: '/images/hokkaido.jpg',
                        postRegion: '札幌',
                        showRegion: '삿포로',
                        listLimit: 5
                    },
                    {
                        name: '沖縄',
                        src: '/images/okinawa.jpg',
                        postRegion: '沖縄',
                        showRegion: '오키나와',
                        listLimit: 5
                    },
                ],

                food: [
                    {
                        name: '韓国料理',
                        src: '/images/koreanFood.jpg',
                        postType: '한식',
                        listLimit: 10
                    },
                    {
                        name: '和食',
                        src: '/images/japaneseFood.jpg',
                        postType: '일식',
                        listLimit: 10
                    },
                    {
                        name: '中華料理',
                        src: '/images/chineseFood.jpg',
                        postType: '중식',
                        listLimit: 10
                    },
                ],

                favorite: [

                ],

                translateValue: {
                    '東京': 'toukyou',
                    '北海道': 'hokkaido',
                    '大阪': 'oosaka',
                    '京都': 'kyouto',
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
                },

                translateKorValue: {
                    '東京': '도쿄',
                    '北海道': '홋카이도',
                    '大阪': '오사카',
                    '福岡': '후쿠오카',
                    '京都': '교토',
                    '한식': '한식',
                    '일식': '일식',
                    '중식': '중식',
                    '양식': '양식',
                    '분식': '분식',
                    '덮밥': '덮밥',
                    '스시': '스시',
                    '패스트 푸드': '패스트 푸드',
                    '찜': '찜',
                    '탕': '탕',
                    '도시락': '도시락',
                    '카페&디저트': '카페&디저트',
                    '술집': '술집',
                    '면류': '면류',
                    '제과': '제과',
                    '': '',
                    '': '',
                },

                labelSearch: '',
                userRecommend: '',
                regionRecommend: '',
                typeRecommend: '',
            }
        },

        mounted() {
            if(this.$session.get('region')) {
                this.favorite.push({
                    name: this.$session.get('region'),
                    src: "/images/" + this.translate(this.$session.get('region')) + ".jpg",
                    function: this.clickRegionList,
                    listLimit: 7
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

            if(this.$session.get('user_country') == "Korea") {
                this.labelSearch = '식당 또는 음식';
                this.userRecommend = '사용자 맞춤 추천';
                this.regionRecommend = '지역별 평점 베스트';
                this.typeRecommend = '식종 평점 베스트';
            } else if(this.$session.get('user_country') == "USA") {
                this.labelSearch = 'Restaurant or food';
                this.userRecommend = 'Custom recommendations';
                this.regionRecommend = 'Best rated by region';
                this.typeRecommend = 'Best rated by food type';
            } else if(this.$session.get('user_country') == "China") {
                this.labelSearch = '';
                this.userRecommend = '';
                this.regionRecommend = '';
                this.typeRecommend = '';
            } else {
                this.labelSearch = '食堂あるいは食べ物';
                this.userRecommend = 'ユーザー向けおすすめ';
                this.regionRecommend = '地域別ベストレーティング';
                this.typeRecommend = '食事別ベストレーティング';
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

            translateKor(value) {
                return this.translateKorValue[value];
            }
        }
    }
</script>

<style>
    .titleText {
        font-size: 22pt
    }

    .bestText {
        font-size: 30pt;
    }

    @media (max-width: 639px) {
        .bestBanner {
            font-size: 20pt;
        }

        .title-text-size {
            font-size: 21pt;
        }
    }

    @media (min-width: 640px) {
        .title-text-size {
            font-size: 24pt;
        }
    }

</style>