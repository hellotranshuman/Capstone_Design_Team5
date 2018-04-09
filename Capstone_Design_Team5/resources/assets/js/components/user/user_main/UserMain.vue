<template>
    <div> 
        <h1>성준아 메인페이지 구현해줘!!!</h1>
        <p>여기 주소 resources/assets/js/components/user/user_main/UserMain.vue</p>
        {{ test }}
        <router-view></router-view>
    </div>
</template>

<script>
export default {
    data(){
        return {
            test: '이렇게 하면 되는 거 같아'
        }
    },

    methods:{

    }
}
</script>

<style>
</style>