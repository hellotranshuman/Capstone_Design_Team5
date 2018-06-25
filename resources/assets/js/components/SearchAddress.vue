<template>
    <div>
        <v-container>
            <v-flex xs12 sm10 offset-sm1>
                <v-card>
                    <google-map :currentCenter="$session.get('searchAddress')">

                    </google-map>
                </v-card>
            </v-flex>
        </v-container>
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

        data(){
            return {
                
            }
        },

        mounted() {

        },

        methods: {

        }
    }
</script>

<style>

</style>