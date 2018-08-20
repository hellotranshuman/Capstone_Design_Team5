<template>
    <div>
        <v-btn class="topBar-button" color="brown darken-1" flat  to="editRestaurant">{{this.topBarSetup}}</v-btn>
        <div class="topBar-vertical-line"></div>
        <v-btn class="topBar-button" color="brown darken-1" flat  to="ownerReservationList">{{this.topBarReservation}}</v-btn>
        <div class="topBar-vertical-line"></div>
        <v-btn class="topBar-button" color="brown darken-1" flat  to="totalStatistics">{{this.topBarStatistics}}</v-btn>
    </div>
</template>

<script>
export default {
    data() {
        return {
            topBarSetup         : '設定',
            topBarReservation   : '予約',
            topBarStatistics    : 'グラフ'
        }
    }
}
</script>
<style>
.topBar-button {
    font-weight: bold;
    font-size: 1.5em;
    border-left: 1em;
}

.topBar-vertical-line {
    display: inline;
    border-left: 3px solid #6D4C41;
}
</style>