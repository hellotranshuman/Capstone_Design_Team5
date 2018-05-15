<template>
    <div>
        <v-card>
            <v-flex xs12 sm10 offset-sm1>
                <v-alert @click="open_gps_dialog()" :value="true" outline color="success" icon="gps_fixed" style="cursor:pointer">
                    {{ searchAddress[0] }}
                </v-alert>
                <GoogleMap :currentCenter=searchAddress[1]></GoogleMap>
            </v-flex>
        </v-card>
        <br>
        <v-layout row>
            <v-flex xs12 sm10 offset-sm1>
                <v-carousel>
                    <v-carousel-item src="/images/1.jpg"></v-carousel-item>
                    <v-carousel-item src="/images/2.jpg"></v-carousel-item>
                    <v-carousel-item src="/images/3.jpg"></v-carousel-item>
                </v-carousel>
            </v-flex>
        </v-layout>
    </div>
</template>

<script>
    import GoogleMap from "../../GoogleMap";
    export default {
        components: {
            GoogleMap
        },

        props: ['searchAddress'],

        data(){
            return {
                test: [[], ["tokyo ageya", 1, "/restaurant/1/info", "/restaurant/1/menu", "/restaurant/1/review"], ["tokyo tenya", 2, "/restaurant/2/info", "/restaurant/2/menu", "/restaurant/2/review"], ["tokyo udon", 3, "/restaurant/3/info", "/restaurant/3/menu", "/restaurant/3/review"]],
                test2: [[], ["yoshinoya", 4, "/restaurant/4/info", "/restaurant/4/menu", "/restaurant/4/review"], ["ohagi", 5, "/restaurant/5/info", "/restaurant/5/menu", "/restaurant/5/review"], ["sobasin", 6, "/restaurant/6/info", "/restaurant/6/menu", "/restaurant/6/review"]],
                key: "AIzaSyDTHKQzISVxAAfuBGp0HKj5GpMPNqR_Ovo",

            }
        },

        methods: {
            open_gps_dialog() {
                this.$parent.$parent.$parent.gps_search = true;
            }
        }
    }
</script>

<style>

</style>