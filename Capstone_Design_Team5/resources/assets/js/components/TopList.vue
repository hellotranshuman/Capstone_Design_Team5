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
                    <v-card-title class="headline orange--text">{{ region }} 베스트 {{ listLimit }}</v-card-title>
                    <v-container fluid grid-list-sm>
                        <v-layout row wrap>
                            <v-flex md4 xs12 v-for="(item, i) in restaurantList" :key="i">
                                <v-card>
                                    <v-card-media
                                            :src="`/images/${item.shop_id}/${item.shop_id}_titleImg.jpg`"
                                            height="250px"
                                            @click="moveRestaurant(item.shop_id)"
                                    ></v-card-media>
                                    <v-card-title class="headline">{{ item.shop_name }}<v-spacer></v-spacer><span class="orange--text">{{ item.totalRating }}</span></v-card-title>
                                    <v-card-actions>{{ item.shop_ddobuken }} - {{ item.shop_type }}</v-card-actions>
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

        props: ['searchAddress', 'region', 'listLimit', 'restaurantList'],

        data(){
            return {

            }
        },

        mounted() {
            console.log(this.restaurantList);
        },

        methods: {
            open_gps_dialog() {
                this.$parent.$parent.$parent.gps_search = true;
            },

            moveRestaurant(shop_id) {
                this.$router.push('/restaurant/' + shop_id + '/info');
            }
        }
    }
</script>

<style>

</style>