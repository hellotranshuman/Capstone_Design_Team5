<template>
    <div>
        <div style="background-color: #ff9a55; height: 10px"></div>
        <v-layout row>
            <v-flex xs12 sm10 offset-sm1>
                <v-card>
                    <v-card-title class="headline orange--text">
                        <strong style="font-size: 24pt">{{ searchKeyword }} {{ searching }}</strong><v-spacer></v-spacer>
                        <v-btn color="grey" flat @click="filter = true"><v-icon large>filter_list</v-icon>필터</v-btn>
                    </v-card-title>
                    <GoogleMap googleMapMode="search"></GoogleMap>
                </v-card>
            </v-flex>
        </v-layout>
        <v-layout row>
            <v-flex xs12 sm10 offset-sm1>
                <v-card>
                    <div style="background-color: #ff9a55; height: 10px"></div>
                    <v-alert
                            :value="true"
                            color="brown"
                            outline
                            class="text-xs-center display-1 mx-4"
                    >
                        <strong class="bestBanner">{{ restaurantName }}</strong>
                    </v-alert>
                    <v-container fluid grid-list-sm>
                        <v-layout row wrap v-if="restaurantNameResult.length != 0">
                            <v-flex md4 xs12 v-for="(item, i) in restaurantNameResult" :key="i">
                                <v-card>
                                    <div style="background-color: #ff9a55; height: 5px"></div>
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
                            <strong style="font-size: 22pt">{{ noneResult }}</strong>
                        </v-card-text>
                    </v-container>
                    <v-alert
                            :value="true"
                            color="brown"
                            outline
                            class="text-xs-center display-1 mx-4"
                    >
                        <strong class="bestBanner">{{ foodType }}</strong>
                    </v-alert>
                    <v-container fluid grid-list-sm>
                        <v-layout row wrap v-if="restaurantTypeResult.length != 0">
                            <v-flex md4 xs12 v-for="(item, i) in restaurantTypeResult" :key="i">
                                <v-card>
                                    <div style="background-color: #ff9a55; height: 5px"></div>
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
                            <strong style="font-size: 22pt">{{ noneResult }}</strong>
                        </v-card-text>
                    </v-container>
                    <v-alert
                            :value="true"
                            color="brown"
                            outline
                            class="text-xs-center display-1 mx-4"
                    >
                        <strong class="bestBanner">{{ regionName }}</strong>
                    </v-alert>
                    <v-container fluid grid-list-sm>
                        <v-layout row wrap v-if="restaurantAreaResult.length != 0">
                            <v-flex md4 xs12 v-for="(item, i) in restaurantAreaResult" :key="i">
                                <v-card>
                                    <div style="background-color: #ff9a55; height: 5px"></div>
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
                            <strong style="font-size: 22pt">{{ noneResult }}</strong>
                        </v-card-text>
                    </v-container>
                    <v-alert
                            :value="true"
                            color="brown"
                            outline
                            class="text-xs-center display-1 mx-4"
                    >
                        <strong class="bestBanner">{{ hashTag }}</strong>
                    </v-alert>
                    <v-container fluid grid-list-sm>
                        <v-layout row wrap v-if="restaurantHashtagResult.length != 0">
                            <v-flex md4 xs12 v-for="(item, i) in restaurantHashtagResult" :key="i">
                                <v-card>
                                    <div style="background-color: #ff9a55; height: 5px"></div>
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
                            <strong style="font-size: 22pt">{{ noneResult }}</strong>
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
                    <br>
                    <span class="headline">검색 필터</span>
                    <v-radio-group v-model="option1" row>
                        <v-radio label="평점순" value="1" color="orange"></v-radio>
                        <v-radio label="인기순" value="2" color="orange"></v-radio>
                    </v-radio-group>
                    <br>
                    <v-divider></v-divider>
                    <br>
                    <span class="headline">지역 선택</span>
                    <v-select
                            v-model="option2"
                            :items="dodobukenList"
                            label="지역"
                            append-icon="location_on"
                            hide-details
                            single-line
                            auto
                            chips
                            color="orange"
                    ></v-select>
                    <br>
                    <v-divider></v-divider>
                    <br>
                    <span class="headline">가격대</span>
                    <v-radio-group v-model="option3">
                        <v-radio label="전체" value="0" color="orange"></v-radio>
                        <v-radio label="1만원 대" value="1" color="orange"></v-radio>
                        <v-radio label="2만원 대" value="2" color="orange"></v-radio>
                        <v-radio label="3만원 대" value="3" color="orange"></v-radio>
                        <v-radio label="4만원 대" value="4" color="orange"></v-radio>
                        <v-radio label="5만원 이상" value="5" color="orange"></v-radio>
                    </v-radio-group>
                    <br>
                    <v-divider></v-divider>
                    <br>
                </v-card-text>
                <v-btn @click="filter = false; changeFilter()">변경</v-btn>
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
                option2: "전체",
                option3: "0",
                searchKeyword: this.$session.get('searchKeyword'),
                restaurantNameResult: this.$session.get('searchData').shopSearchData,
                restaurantAreaResult: this.$session.get('searchData').regionSearchData,
                restaurantHashtagResult: this.$session.get('searchData').tagSearchData,
                restaurantTypeResult: this.$session.get('searchData').typeSearchData,
                dodobukenList: [
                    '전체','東京', '北海道', '札幌', '京都',
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
                restaurantName: "",
                foodType: "",
                regionName: "",
                hashTag: "",
                noneResult: "",
                searching: "",

            }
        },

        created() {
            if(this.$session.get('user_country') == "Korea") {
                this.restaurantName = '가게명 검색 결과';
                this.foodType = '식종 검색 결과';
                this.regionName = '지역명 검색 결과';
                this.hashTag = '해시 태그 검색 결과';
                this.noneResult = '검색 결과가 없습니다.';
                this.searching = '검색 결과';
            } else if(this.$session.get('user_country') == "USA") {
                this.restaurantName = 'Result of searching restaurant name';
                this.foodType = 'Result of searching food type';
                this.regionName = 'Result of searching region name';
                this.hashTag = 'Result of searching hashtag';
                this.noneResult = 'No results were found for your search.';
                this.searching = 'Searching';
            } else if(this.$session.get('user_country') == "China") {
                this.restaurantName = '';
                this.foodType = '';
                this.regionName = '';
                this.hashTag = '';
                this.noneResult = '';
                this.searching = '';
            } else {
                this.restaurantName = '食堂名結果';
                this.foodType = '食事別結果';
                this.regionName = '地域名結果';
                this.hashTag = 'ハッシュタグ結果';
                this.noneResult = '検索結果がありません。';
                this.searching = 'の検索結果';
            }
        },

        methods: {
            moveRestaurant(shop_id) {
                this.$router.push('/restaurant/' + shop_id + '/info');
            },

            changeFilter() {
                var url = "/getSearchData";

                var priceMin = 0;
                var priceMax = 0;

                switch(this.option3) {
                    case '0':
                        priceMin = 0;
                        priceMax = 0;
                        break;
                    case '1':
                        priceMin = 1;
                        priceMax = 1000;
                        break;
                    case '2':
                        priceMin = 1001;
                        priceMax = 2000;
                        break;
                    case '3':
                        priceMin = 2001;
                        priceMax = 3000;
                        break;
                    case '4':
                        priceMin = 3001;
                        priceMax = 4000;
                        break;
                    case '5':
                        priceMin = 4001;
                        priceMax = 9999;
                        break;
                }

                if(this.option2 == '전체') {
                    axios.post(url, {'searchData': this.$session.get('searchKeyword'), 'searchType': this.option1, 'searchPriceMin': priceMin, 'searchPriceMax': priceMax})
                        .then(response => {
                            this.$session.set('searchData', response.data);

                            if(this.$route.path != '/search')
                                this.$router.push('/search');
                            else
                                this.$router.go(this.$router.currentRoute);
                        })
                        .catch(error => {
                            alert(error);
                        })
                } else {
                    axios.post(url, {'searchData': this.$session.get('searchKeyword'), 'searchType': this.option1, 'searchArea': this.option2, 'searchPriceMin': priceMin, 'searchPriceMax': priceMax})
                        .then(response => {
                            this.$session.set('searchData', response.data);

                            if(this.$route.path != '/search')
                                this.$router.push('/search');
                            else
                                this.$router.go(this.$router.currentRoute);
                        })
                        .catch(error => {
                            alert(error);
                        })
                }
            }
        }
    }
</script>