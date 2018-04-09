<template>
    <div class="addReservation">
        <B>예약자명</B>
            <b-input></b-input>
        <B>예약 날짜</B><B style="margin-left:90px">예약 시간</B><br>
            <input type="date" />
            <input type="time" />
        <br>
        <B>인원수</B>
        <br>
            어른  <b-input></b-input>
            아이  <b-input></b-input>
        <B>메뉴 선택 여부</B>
            <b-form-select v-model="selected" class="mb-3">
                <option :value="null">메뉴를 선택해주세요</option>
                <option value="yes" disabled>메뉴 선택</option>
                <option value="no">매장에서 선택</option>
            </b-form-select>
    </div>    
</template>

<script>
    export default {
        data() {
            return {
                selected: null
            }
        }
    }
</script>

<style>
    .addReservation B{
        padding-bottom: 30px;
    }
</style>
