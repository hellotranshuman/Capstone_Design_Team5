<template>
  <div id="ownerCreteCupon">
    <meta name="viewport" content="width=device-width" />
    <!-- 본문 -->
    <div class="sid_right">
      <br>
      <div>
        <h3><B> 쿠폰 </B></h3>
        쿠폰을 추가할 수 있습니다.
        <hr>
        <b-btn v-b-modal.modal1 class="cupon_add"><B> 쿠폰 추가 </B></b-btn>
      </div>
       
      <!-- 쿠폰 추가 창 -->
      <div>
        <b-modal id="modal1" title="쿠폰 추가" @ok="SpendData">
          <!-- 쿠폰이름 -->
          <B class="Coupon_setting_name">쿠폰명</B>
          <b-form-input class="cuponName" v-model="CouponName" type="text" placeholder="Enter Cupon name"></b-form-input><br>

          <B class="Coupon_setting_name">쿠폰종류</B>
          <br>
          <select class="cupon_select" v-model="CouponType">
            <option><B>가격 할인</B></option>
            <option><B>상품 제공</B></option>
          </select><br>
          <br>
          
          <B class="Coupon_setting_name">할인 가격</B>
          <b-form-input class="cuponDiscount" type="text" v-model="Discount"></b-form-input><br>

          <B class="Coupon_setting_name">제공 상품 이름</B><br>
          <b-form-input class="cuponadd" type="text" v-model="addproduct"></b-form-input><br>
          <br>
          <B class="Coupon_setting_name">쿠폰 조건</B>
          <b-form-input class="cuponCondition" type="text" v-model="Condition"></b-form-input>
          <b-form-group>
            <b-form-radio-group v-model="selected"
                                :options="options"
                                plain />
          </b-form-group>
          <B class="Coupon_setting_name">쿠폰 설명</B>
          <b-form-input class="coupon_explanation" type="text" v-model="explanation"></b-form-input><br>

          <!-- Datepicker -->
          <B class="Coupon_setting_name">날짜 설정</B>
            <div>
              <Datepicker class="start_date" v-model="start_date"></Datepicker>
                <span class="and"> ~ </span>
              <Datepicker class="end_date" v-model="end_date"></Datepicker>
            </div>
        </b-modal>
      </div>
      
        <!-- 추가한 쿠폰 table -->
      <div class="cupon_table">
        <B> 제공중인 쿠폰 </B>
        <b-table :fields="fields" :items="items">

          <template slot="index" slot-scope="data">
            {{data.index + 1}}
          </template>

          <template slot="cupon_date" slot-scope="data">
            {{data.item.cupon_date.start}} ~ {{data.item.cupon_date.end}}
          </template>

          <template slot="delete" slot-scope="data">
            <b-button variant="danger" name="delete">삭제</b-button>
          </template>
        </b-table>
      </div><br>
        
        <!-- pagenation -->
      <div class="cupon_pagenation">
        <b-pagination align="center" :total-rows="100" :per-page="10">
        </b-pagination>
        <br>
      </div>
    </div>
  </div>
</template>
<script>
import Datepicker             from 'vuejs-datepicker';

import VueAxios from 'vue-axios';
import axios from 'axios';

export default {
    components : {
        'Datepicker'    : Datepicker
    },
    data () {
      return {
        /* 쿠폰 */
        CouponName: '',
        CouponType:'',
        Discount:'',
        addproduct:'',
        Condition:'',
        explanation:'',
        start_date : '',
        end_date : '',
      

        /* 쿠폰 창 */
        selected: 'first',
        options: [
          { text: '이상', value: 'up' },
          { text: '이하', value: 'down' },
        ],
        /* 쿠폰 table */
        fields: [
          'index',
          { key: 'cupon_name', label: 'Cupon Name' },
          'cupon_date',
          'delete'
        ],
        items: [
          { cupon_name: '300Discount', cupon_date: { start:'2018.03.02', end:'2018.03.03' } },
          { cupon_name: 'addProduct', cupon_date: { start:'2018.03.02', end:'2018.03.03' } }
        ]
      }
    },
  methods : {
    SpendData() {
    // axios http 라이브러리
      axios.post('/Coupon', {
        CouponName        : this.CouponName,
        CouponType        : this.CouponType,
        Discount          : this.Discount,
        addproduct        : this.addproduct,
        Condition         : this.Condition,
        explanation       : this.explanation,
        start_date        : this.start_date,
        end_date          : this.end_date
      }).then(console.log('success')).catch(console.log('test '));
    }
  }
}

/* axios */

</script>
<style>
    /* 반응형 웹 만들기 */ 
    /* 모바일 */
    @media all and (max-width: 320px) {
    }
    /* 태블릿*/
    @media all and (min-width: 321px) and (max-width: 768px) {
    }
    /* 웹 */
    @media all and (min-width: 769px) {
    }


    .sid_right {
      padding-left: 24%;
    }

    /* 쿠폰 */
    .cupon_add {
      margin-left: 80%;
    }
    .cuponInput {
      width: 250px;
    }
    .cuponDiscount {
      width: 100px;
    }
    .cuponadd {
      width: 100px;
      float: left;
    }
    .cuponCondition {
      width: 100px;
    }
    .cupon_select {
      height: 30px;
    }
    .Coupon_setting_name {
      font-size: 14px;
    }
    .coupon_explanation {
      height: 70px;
    } 

    /* Datepicker */
    .start_date {
    float: left;
    margin-right: 3%;
    }

    .and {
      float: left;
    }

    .end_date {
      float: left;
      margin-left: 3%;
    }
</style>
