<template>
    <div>
        <!-- 중간 -->
        <div class="reservationAccept">   
            <br>
            <h3><B>예약 수락</B></h3>
            현재 신청된 예약 현황을 볼 수 있습니다.
            <hr><br>
            <h5><B> 예약 신청 대기 인원</B></h5>
            <div class="reservation_list">
                <b-table :items="items" :fields="fields">
                    <!-- index -->
                    <template  slot="index" slot-scope="data">
                        {{data.index + 1}}
                    </template>
                    <!-- 이름 -->
                    <!-- 날짜 -->
                    <template slot="date" slot-scope="row">
                        {{row.item.date}} - {{row.item.hour}}시 {{row.item.minute}}분
                    </template>

                    <!-- 세부사항 -->
                    <template slot="show_details" slot-scope="row">
                        <b-button size="sm" @click.stop="row.toggleDetails" class="mr-2">
                            {{ row.detailsShowing ? 'Hide' : 'Show'}} Details
                        </b-button>
                    </template>

                    <template slot="row-details" slot-scope="row">
                        <b-card>
                            <b-row class="mb-2">
                                <b-col sm="3" class="text-sm-right"><b>인원</b></b-col>
                                <b-col>어른 : {{ row.item.adult }} <br>아이 : {{row.item.adult}}</b-col>
                            </b-row>
                            <b-row class="mb-2">
                                <b-col sm="3" class="text-sm-right"><b>메뉴 선택 여부</b></b-col>
                                <b-col>{{ row.item.menu }}</b-col>
                            </b-row>
                        </b-card>
                    </template>

                    <!-- 동의 & 거절 -->
                    <template slot="Accept" slot-scope="data">
                        <b-button variant="primary" name="accept">수락</b-button>
                    </template>
                    <template slot="Cancel" slot-scope="data">
                        <b-button variant="danger" name="cancel">거절</b-button>
                    </template>
                </b-table>
            </div>
        </div>
    </div>
</template>
<script>
    
    export default {
        data () {
            return {
                myToggle: false,

                buttons: [
                    { variant: 'outline-danger', caption: '오늘', state: false },
                    { variant: 'outline-danger', caption: '1주일', state: false },
                    { variant: 'outline-danger', caption: '1개월', state: false },
                    { variant: 'outline-danger', caption: '6개월', state: false },
                ],
                fields: [ 'index', 'name', 'date', 'show_details', 'Accept' , 'Cancel' ],
                items: [
                    {name: '윤진주', adult:'2', child: '3', menu: 'yes', date: '2018-03-31', hour: '13', minute: '30' },
                    {name: '윤진주2', adult:'1', child: '1', menu:'no', date: '2018-01-31', hour: '15', minute: '30'},
                ]
            }
        }
    }
</script>
<style>
    .reservationAccept {
        padding-left: 24%;
    }
</style>