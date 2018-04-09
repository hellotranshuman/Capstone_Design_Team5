<template>
  <div id="ownerCreteCupon">
    <!-- 위 -->
    <div class = "top">
      <ownerPageTop></ownerPageTop>
    </div>
    <div class="content">
      <!-- 옆 -->
      <div class="side_left">
        <ownerPageSide></ownerPageSide>
      </div>
      <!-- 본문 -->
      <div class="sid_right">
        <br>
        <div>
            <h3><B> 쿠폰 </B></h3>
            쿠폰을 추가할 수 있습니다.
            <hr>
            <b-btn v-b-modal.modal1 class="cupon_add"> 쿠폰 추가 </b-btn>
        </div>
       
        <!-- 쿠폰 추가 창 -->
        <div>
          <b-modal id="modal1" title="쿠폰 추가">
            쿠폰명
            <b-form-input class="cuponName" type="text" placeholder="Enter Cupon name"></b-form-input>
            <br>
            쿠폰종류
            <br>
            <select class="cupon_select">
                <option>가격 할인</option>
                <option>상품 제공</option>
            </select>
            <br>
            할인 가격
            <b-form-input class="cuponDiscount" type="text" ></b-form-input>
            쿠폰 조건
            <b-form-input class="cuponCondition" type="text" ></b-form-input>
            <b-form-group>
                <b-form-radio-group v-model="selected"
                                              :options="options"
                                              plain />
            </b-form-group>
            쿠폰 설명
            <b-form-input class="cuponName" type="text" ></b-form-input>
            날짜 설정
            <datePicker></datePicker>
            <b-btn>submit</b-btn>
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
              <a href="">{{ data.item.delete }}</a>
            </template>
        </b-table>
        </div><br>
        <div class="cupon_pagenation">
          <b-pagination align="center" :total-rows="100" v-model="currentPage" :per-page="10">
          </b-pagination>
          <br>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import ownerPageSide from '../owner_common/ownerPageSide.vue';
import ownerPageTop from '../owner_common/ownerPageTop.vue'
import datePicker from './datePicker.vue';

export default {
    components : {
            'datePicker'    : datePicker,
            'ownerPageSide' : ownerPageSide,
            'ownerPageTop'  : ownerPageTop
        },
    data () {
    return {
      selected: 'first',
      options: [
        { text: '이상', value: 'up' },
        { text: '이하', value: 'down' },
      ],
      fields: [
        'index',
        { key: 'cupon_name', label: 'Cupon Name' },
        'cupon_date',
        'delete'
      ],
      items: [
        { cupon_name: '300Discount', cupon_date: { start:'2018.03.02', end:'2018.03.03' }, delete:'delete'  },
        { cupon_name: 'addProduct', cupon_date: { start:'2018.03.02', end:'2018.03.03' }, delete:'delete' }
      ]
    }
  }
}
</script>
<style>
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
  .cuponCondition {
    width: 100px;
  }
  .cupon_select {
    height: 30px;
  }
</style>
