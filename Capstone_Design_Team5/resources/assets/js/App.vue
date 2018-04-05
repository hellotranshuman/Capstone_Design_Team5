<template>
    <div class="container">
        <div>
            <transition name="fade">
                <router-view></router-view>
            </transition>
        </div>
    </div>
</template>

<style>
    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s
    }
    .fade-enter, .fade-leave-active {
        opacity: 0
    }
</style>

<script>

    import createCupon from './components/owner/owner_coupon/createCupon.vue';
    import ownerPageSide from './components/owner/owner_common/ownerPageSide.vue';
    import ownerPageTop from './components/owner/owner_common/ownerPageTop.vue';
    import datePicker from './components/owner/owner_coupon/datePicker.vue';

    export default {
        components: {
            'datePicker': datePicker,
            'createCoupon': createCupon,
            'ownerPageSide': ownerPageSide,
            'ownerPageTop': ownerPageTop
        }
    }

</script>