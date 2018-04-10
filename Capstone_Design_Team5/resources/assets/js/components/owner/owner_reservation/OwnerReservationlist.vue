<template>
    <div>
        <!-- 중간 -->
        <div class="reservationlist">   
            <br>
            <h3><B>예약 현황</B></h3>
            전체 예약 현황을 볼 수 있습니다.
            <hr>
                
            <!-- 예약 추가 -->
            <b-btn v-b-modal.addReservation class="reservation_add">예약 추가</b-btn>
            <b-modal id="addReservation" title="예약추가" @ok="SpendData">
                <div class="addReservation">
                    <B>예약자명</B>
                        <b-input v-model="usernum"></b-input>
                    <B>예약 날짜</B><B style="margin-left:90px">예약 시간</B><br>
                        <input type="date" v-model="date">/>
                        <input type="time" v-model="time"/>
                    <br>
                    <B>인원수</B>
                    <br>
                        어른  <b-input v-model="adult_person"></b-input>
                        아이  <b-input v-model="child_person"></b-input>
                    <B>메뉴 선택 여부</B>
                        <b-form-select v-model="menuselect" class="mb-3">
                            <option :value="null">메뉴를 선택해주세요</option>
                            <option value="yes" disabled>메뉴 선택</option>
                            <option value="no">매장에서 선택</option>
                        </b-form-select>
                </div>   
            </b-modal>

            <!-- 예약 기간 지정 -->
            <div>
                <div class="datefilter">
                    <B> 기간 선택  </B>
                    <input type="date" v-model="start_date"/> ~ <input type="date" v-model="end_date"/>
                    <b-btn v-on:click="datefilter()">조회</b-btn>
                </div>

                <!-- 예약 리스트 필터 -->
                <b-button-group class="btnfilter"  size="sm">
                    <b-button variant="outline-danger">오늘</b-button>
                    <b-button variant="outline-danger">일주일</b-button>
                    <b-button variant="outline-danger">1개월</b-button>
                    <b-button variant="outline-danger">6개월</b-button>
                </b-button-group>
            </div>
    
            <!-- 예약 리스트 -->
            <div class="reservationlist_table">
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

                    <!-- 취소 -->
                    <template slot="cancel" slot-scope="data">
                        <b-button variant="danger">예약 취소</b-button>
                    </template>  
                </b-table>
            </div>
            <br>

            <!-- 페이지네이션 -->
            <div class="pagenation">
                <b-pagination align="center" :total-rows="100" v-model="currentPage" :per-page="10">
                </b-pagination>
            </div>
        </div>
    </div>
</template>
<script>
    /* 데이터 송신 */
    import VueAxios from 'vue-axios';
    import axios from 'axios';
    
    export default {
        data () {
            return {
                usernum             : '',       
                date                : '',
                time                : '',
                adult_person        : '',
                child_person        : '',
                menuselect          : '',
                start_date          : '',
                end_date            : '',
                myToggle: false,
                fields: [ 'index', 'name', 'date', 'show_details', 'cancel' ],
                items: [
                    {name: '윤진주', adult:'2', child: '3', menu: 'yes', date: '2018-03-31', hour: '13', minute: '30' },
                    {name: '윤진주2', adult:'1', child: '1', menu:'no', date: '2018-01-31', hour: '15', minute: '30'},
                ]
            }
        },
        computed: {
            btnStates () {
                return this.buttons.map(btn => btn.state)
            }
        },
         methods : {
            SpendData() {
            // axios http 라이브러리
            axios.post('/Reservationadd', {
                    usernum             : this.usernum,       
                    date                : this.date,
                    time                : this.time,
                    adult_person        : this.adult_person,
                    child_person        : this.child_person,
                    menuselect          : this.menuselect,
                }).then(console.log('success')).catch(console.log('test '));
            },
            datefilter() {
                axios.post('/Reservationadd', {
                    start_date          : this.start_date,       
                    end_date            : this.end_date,
                }).then(console.log('success')).catch(console.log('test '));
            }
  }
    }
</script>
<style>
    .reservationlist {
        padding-left: 24%;
    }

    .reservation_add {
        margin-left: 80%;
    }

    .datefilter {
        float: left;
        margin-top: 2%;
        margin-bottom: 1%;
    }

    .btnfilter {
        float: left;
        margin-left: 17%;
        margin-top: 2%;
        height: 30px;
    }
</style>