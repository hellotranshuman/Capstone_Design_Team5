<template>
    <v-app>
        <div class="ownerPage">
            <div>
                <OwnerPageTop></OwnerPageTop>
            </div>
            <div>
                <router-view to="/ownerPage/ownerPageSideSetting"></router-view>
            </div>
        </div>
    </v-app>
</template>
<script>
import OwnerPageTop from './ownerPageTop.vue';

export default {
    components : {
        'OwnerPageTop' : OwnerPageTop
    }
}
</script>
<style>

</style>
