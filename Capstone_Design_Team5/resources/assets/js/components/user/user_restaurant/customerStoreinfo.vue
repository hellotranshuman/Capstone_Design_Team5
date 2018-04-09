<template>
    <div>
        가게 정보
        <b-btn v-b-modal.reservation_add>예약 하기</b-btn>
        <!-- 예약 하기 -->
        <b-modal id="reservation_add" title="예약하기">
            <addReservation></addReservation>
        </b-modal>
    </div>
</template>
<script>
import addReservation from './addReservation.vue';

    export default {
        components : {
            'addReservation' : addReservation
        }
    }
</script>
<style>
</style>
