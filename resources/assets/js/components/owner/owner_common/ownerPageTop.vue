<template>
    <div>
        <v-btn class="topBar-button" color="brown darken-1" flat  to="editRestaurant">설정</v-btn>
        <div class="topBar-vertical-line"></div>
        <v-btn class="topBar-button" color="brown darken-1" flat  to="ownerReservationList">예약</v-btn>
        <div class="topBar-vertical-line"></div>
        <v-btn class="topBar-button" color="brown darken-1" flat  to="totalStatistics">통계</v-btn>
    </div>
</template>

<script>
export default {

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