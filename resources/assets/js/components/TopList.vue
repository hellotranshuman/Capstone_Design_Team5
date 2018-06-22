<template>
    <div>
        <v-layout row>
            <v-flex xs12>
                <v-alert v-if="$session.get('top_mode') == 'region'" @click="open_gps_dialog()" :value="true" outline color="success" icon="gps_fixed" style="cursor:pointer">
                    {{ $session.get('top_region') }}
                </v-alert>
                <!--<GoogleMap v-if="$session.get('top_mode') == 'region'" :currentCenter="latlngProps"></GoogleMap>-->
                <div v-if="$session.get('top_mode') == 'region'" id="google_map">

                </div>
            </v-flex>
        </v-layout>
        <br>
        <v-layout row>
            <v-flex xs12 sm10 offset-sm1>
                <v-card>
                    <v-card-title v-if="$session.get('top_mode') == 'region'" class="headline orange--text">{{ $session.get('top_show_region') }} 베스트 {{ $session.get('top_listLimit') }}</v-card-title>
                    <v-card-title v-else class="headline orange--text">{{ $session.get('top_type') }} 베스트 {{ $session.get('top_listLimit') }}</v-card-title>
                    <v-container fluid grid-list-sm>
                        <v-layout row wrap>
                            <v-flex md4 xs12 v-for="(item, i) in $session.get('top_restaurantList')" :key="i">
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

        data(){
            return {

            }
        },

        mounted() {
            if(this.$session.get('top_mode') == 'region')
                this.geoCoder(this.$session.get('top_region'));
        },

        methods: {
            open_gps_dialog() {
                this.$parent.$parent.$parent.gps_search = true;
            },

            moveRestaurant(shop_id) {
                this.$router.push('/restaurant/' + shop_id + '/info');
            },

            geoCoder(argAddress) {
                var address = argAddress;
                var map = new google.maps.Map(document.getElementById('google_map'), {zoom: 14});
                var geocoder = new google.maps.Geocoder();

                geocoder.geocode({'address': address}, function(results, status) {
                    if(status === google.maps.GeocoderStatus.OK) {
                        map.setCenter(results[0].geometry.location);
                    } else
                        console.log(status);
                });
            },
        }
    }
</script>

<style>
    #google_map {
        height: 200pt;
    }
</style>