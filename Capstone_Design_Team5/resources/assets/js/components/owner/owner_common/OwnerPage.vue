<template>
    <div class="ownerPage">
        <div>
            <ownerPageTop></ownerPageTop>
        </div>
        <div>
            <router-view to="/ownerPage/ownerPageSide_Setting"></router-view>
        </div>
    </div>
</template>
<script>
    import ownerPageTop from './ownerPageTop.vue';

    export default {
        components : {
            'ownerPageTop' : ownerPageTop
        }

    }
</script>
<style>

</style>
