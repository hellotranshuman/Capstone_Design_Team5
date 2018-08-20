<template>
    <div>
        <div style="background-color: #ff9a55; height: 10px"></div>
        <br>
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
                        <strong class="bestBanner">{{ shopLike }}</strong>
                    </v-alert>
                    <v-container fluid grid-list-sm>
                        <v-layout row wrap v-if="shopData.length != 0">
                            <v-flex md4 xs12 v-for="(item, i) in shopData" :key="i">
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
                </v-card>
            </v-flex>
        </v-layout>
    </div>
</template>

<script>
    import axios from 'axios';
    export default {
        data(){
            return {
                shopData: "",

                shopLike: "",
                noneResult: "",
            }
        },

        mounted() {
            var url = "/getShopLikeData";
                axios.post(url, "")
                    .then(response => {
                        this.shopData = response.data.shopLikeList;
                        console.log(this.shopData);
                    })
                    .catch(error => {
                        alert(error);
                    })

            if(this.$session.get('user_country') == "Korea") {
                this.shopLike = '찜목록';
                this.noneResult = '찜한 가게가 없습니다.';
            } else if(this.$session.get('user_country') == "USA") {
                this.shopLike = 'Like restaurant';
                this.noneResult = 'No there like restaurant';
            } else if(this.$session.get('user_country') == "China") {
                this.shopLike = '';
                this.noneResult = '찜한 가게가 없습니다.';
            } else {
                this.shopLike = '気になる店';
                this.noneResult = '気になる店がありません。';
            }
        },

        methods: {
            moveRestaurant(shop_id) {
                this.$router.push('/restaurant/' + shop_id + '/info');
            },
        }
    }
</script>