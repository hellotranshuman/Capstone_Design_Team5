<template>
    <div>
        <br>
        <google-map :testCenter=testCenter></google-map>
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

        data(){
            return {
                test: [[], ["tokyo ageya", 1, "/restaurant/1/info", "/restaurant/1/menu", "/restaurant/1/review"], ["tokyo tenya", 2, "/restaurant/2/info", "/restaurant/2/menu", "/restaurant/2/review"], ["tokyo udon", 3, "/restaurant/3/info", "/restaurant/3/menu", "/restaurant/3/review"]],
                test2: [[], ["yoshinoya", 4, "/restaurant/4/info", "/restaurant/4/menu", "/restaurant/4/review"], ["ohagi", 5, "/restaurant/5/info", "/restaurant/5/menu", "/restaurant/5/review"], ["sobasin", 6, "/restaurant/6/info", "/restaurant/6/menu", "/restaurant/6/review"]],
                key: "AIzaSyDTHKQzISVxAAfuBGp0HKj5GpMPNqR_Ovo",
                testCenter: {lat: 35.8963134, lng: 128.6198624}
            }
        },
        methods: {
            testing() {
                alert("test!");
            }
        }
    }
</script>

<style>
    #page-content_wrapper {
        width: 100%;
    }
</style>