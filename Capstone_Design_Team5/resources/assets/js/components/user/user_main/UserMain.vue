<template>
    <v-app>
        <v-container grid-list-md text-xs-center>
            <v-layout row wrap>
                <v-flex xs12>
                    <h1>₍₍ ◝(・ω・)◟ ⁾⁾ 임시 메인페이지 へ(￣∇￣へ)</h1>
                </v-flex>
                <br><br><hr><br><br>
                <v-flex>
                    <v-btn color="success" class="main-button-style" to="/userRestaurantMain">
                    식당 여기로~~
                    </v-btn>
                </v-flex>
                <v-flex>
                    <v-btn color="info" class="main-button-style" to="/ownerPage/ownerPageSideSetting">
                    사장님 여기로~~
                    </v-btn>
                </v-flex>
            </v-layout>
        </v-container>
    </v-app>
</template>

<script>
export default {
    data(){
        return {
            
        }
    },

    methods:{

    }
}
</script>

<style>
    .main-button-style {
        font-size: 2em;
        font-weight: bold;   
        width: 100%;
        height: 100%;
    }
</style>