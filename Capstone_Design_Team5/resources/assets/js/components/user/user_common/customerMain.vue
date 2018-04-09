<template>
    <div class="container">
        <customerMainTop></customerMainTop>
        <div class="time_lank">
            실시간 검색어
        </div>
        <div class="blank">
        </div>
        <div class="Store_Main">
              <b-card no-body>
                <b-tabs card v-model="tabIndex">
                <b-tab title="가게 정보" :title-link-class="linkClass(0)">
                    <customerStoreinfo></customerStoreinfo>
                </b-tab>
                <b-tab title="전자메뉴판" :title-link-class="linkClass(1)">
                    <customerMenu></customerMenu>
                </b-tab>
                <b-tab title="리뷰" :title-link-class="linkClass(2)">
                    리뷰 내용
                </b-tab>
                </b-tabs>
            </b-card>
        </div>
    </div>
</template>
<script>
import customerMainTop      from './customerMainTop.vue';
import customerMenu         from './customerMenu.vue';
import customerStoreinfo    from './customerStoreinfo.vue';

    export default {
        data() {
            return {    
                tabIndex: 0
            }
        },
         methods: {
            linkClass (idx) {
                if (this.tabIndex === idx) {
                    return ['bg-dark', 'text-white']
                } else {
                    return ['bg-light', 'text-dark']
                }
            }
        },
        components : {
            'customerMainTop'   : customerMainTop,
            'customerMenu'      : customerMenu,
            'customerStoreinfo' : customerStoreinfo
        }
    }
</script>
<style>
    .time_lank {
        padding-bottom: 10px; 
    }

    .blank {
        width: 100%;
        height: 40px;
        background-color: #353535;
    }
</style>
