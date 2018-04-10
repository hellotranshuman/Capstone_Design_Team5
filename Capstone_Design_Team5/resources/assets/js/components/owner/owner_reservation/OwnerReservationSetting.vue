<template>
    <div>
        <div class="reservationlist">   
            <br>
            <h3><B>예약 설정</B></h3>
            예약에 대한 설정을 할 수 있습니다.
            <hr>
            <br>
            <!-- 달력 -->
            <div>
                <div class = "dateCalendar">
                    <datepicker :inline="true" :format="YYYY-MM-DD" v-model="datepicker"></datepicker> 
                </div>
                <form>
                    <div class="dateSetting">
                        <h2 class="fontColor_white" style="margin-top:3%"><B>{{datepicker}}</B></h2>
                    </div>
                <br><br><br><br>
                <h5><B>예약 가능 여부</B> </h5>
                <div>
                    <b-form-group>
                        <b-form-radio-group v-model="selected"
                                            :options="options"
                                            name = "reservation_select"
                        >
                        </b-form-radio-group>
                    </b-form-group>
                </div>
                <br>
                <h5><B>예약 가능 시간</B> </h5>
                <div class="app">
                    <time-picker :format="YYYY-MM-DD" v-model="start_time"></time-picker>
                    <h1>{{start_time}}</h1>
                    <span> &nbsp;&nbsp; to &nbsp;&nbsp; </span>
                </div>
                <br><br>
                <b-button v-on:click="SpendData()">저장하기</b-button>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
    import Datepicker       from 'vuejs-datepicker';
    import TimePicker       from 'vue-timepicker'

    import VueAxios         from 'vue-axios';
    import axios            from 'axios';

    export default {
        data() {
            return {
                options: [
                    { text: '예약 가능', value: 'true' },
                    { text: '예약 불가능', value: 'false' }
                ],
                selected     : '',
                datepicker   : '',
                start_time   : '',
                end_time     : '',
                }
        },
        components: {
            'Datepicker'       : Datepicker,
            'timePicker'       : TimePicker
        },
        methods : {
            SpendData() {
            // axios http 라이브러리
                axios.post('/Reservationset', {
                    datepicker      : this.datepicker, 
                    selected        : this.selected,
                    start_time      : this.start_time,
                     end_time        : this.end_time   
                }).then(console.log('success')).catch(console.log('test '));
            }
        }
    }
</script>
<style>
    /* 폰트 컬러 */
    .fontColor_white {
        color: white;
    }

    .reservationlist {
        padding-left: 24%;
    }

    /* 달력 */
    .dateCalendar {
        float:left; 
        margin-left:7%; 
        margin-right: 10%;
        margin-bottom:5%;
    }
    .SelectDate {
        font-size: 20px;
        font-weight: bolder;
        text-align: center;
    }
    
    .dateSetting {
        background-color: #353535;
        height: 55px;
        width: 330px;
        float: left;
        margin-right: 8%;
        text-align: center;
    }

    /* 저장 */
    .reservationSettingSave {
        float: right;
        margin-right: 15%;
        background-color: #353535;
        color: white;
        width: 200px;
        height: 30px;
    }
</style>