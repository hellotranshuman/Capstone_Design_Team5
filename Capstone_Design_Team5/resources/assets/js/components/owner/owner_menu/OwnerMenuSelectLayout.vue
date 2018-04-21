<!-- 식당 사장이 메뉴판이 출력될 레이아웃을 선택하거나 직접 제작 할 수 있도록 한다. -->

<template>
    <div class="container" style="width:100%;">
        <v-container grid-list-md>
            <!-- 서비스에서 제공하는 메뉴판 기본 템플릿 중 하나 선택하기. -->
            <v-layout elevation-3>
                <v-flex xs10 style="font-size: 2rem;">
                    <v-card>
                        <v-card-text><b>메뉴판 템플릿 선택 - 선택한 템플릿 : {{selected_template}} </b></v-card-text>
                    </v-card> 
                </v-flex>
                <v-flex xs2 style="font-size: 2rem;">
                    <v-btn dark block style="height:90%;" @click="save_data"> 
                         저장하기
                    </v-btn>
                </v-flex>
            </v-layout>

            <v-layout text-xs-center mb-5>
                <!-- 서비스에서 제공하는 메뉴판 기본 템플릿1 -->
                <v-flex xs3 style="font-size: 1.2rem;" elevation-3>
                    <v-card>
                        <v-card-text> 기본 템플릿1 </v-card-text>

                        <div class="tem_img"> <img :src="exImg1"> </div>
                         
                        <!-- 템플릿 예시 이미지 출력 : 모달 -->
                        <v-dialog max-width="50%">
                            <v-btn dark block slot="activator"> 예시 보기 </v-btn>
                            <v-card align-content-center>
                                <v-card-text> 기본 템플릿1 예시 이미지 출력 </v-card-text>
                                <div class="tem_img"> <img :src="exImg1"> </div>
                            </v-card>
                        </v-dialog>

                        <!-- 템플릿 선택하기 : 모달 -->
                         <v-dialog  v-model="tem1" max-width="20%">
                            <v-btn dark block slot="activator"> 템플릿 선택 </v-btn>
                            <v-card>
                                <v-card-text> 
                                    <h3> 기본 템플릿1으로 적용하시겠습니까? </h3>
                                    <v-btn flat color="green darken-1" 
                                        @click.native="selected_template=1; tem1=false"> 예 </v-btn>
                                    <v-btn  color="green darken-1" flat  @click.native="tem1 = false"> 아니오 </v-btn>
                                </v-card-text>
                            </v-card>
                        </v-dialog>
                    </v-card>
                </v-flex>
                
                <!-- 서비스에서 제공하는 메뉴판 기본 템플릿2 -->
                <v-flex xs3 style="font-size: 1.2rem;" elevation-3>
                    <v-card>
                        <v-card-text> 기본 템플릿2 </v-card-text> 
                        
                        <div class="tem_img"> <img :src="exImg2"> </div>

                        <!-- 템플릿 예시 이미지 출력 : 모달 -->
                        <v-dialog max-width="50%">
                            <v-btn dark block slot="activator"> 예시 보기 </v-btn>
                            <v-card>
                                <v-card-text> 기본 템플릿2 예시 이미지 출력 </v-card-text>
                                <div class="tem_img"> <img :src="exImg2"> </div>
                            </v-card>
                        </v-dialog>

                        <!-- 템플릿 선택하기 : 모달 -->
                        <v-dialog v-model="tem2" max-width="20%">
                            <v-btn dark block slot="activator"> 템플릿 선택 </v-btn>
                            <v-card>
                                <v-card-text> 
                                    <h3> 기본 템플릿2으로 적용하시겠습니까? </h3> 
                                    <v-btn  color="green darken-1" flat 
                                        @click.native="selected_template=2; tem2 = false"> 예 </v-btn>
                                    <v-btn  color="green darken-1" flat  @click.native="tem2 = false"> 아니오 </v-btn>
                                </v-card-text>
                            </v-card>
                        </v-dialog>

                    </v-card>
                </v-flex>

                <!-- 서비스에서 제공하는 메뉴판 기본 템플릿3 -->
                <v-flex xs3 style="font-size: 1.2rem;" elevation-3>
                    <v-card>
                        <v-card-text> 기본 템플릿3 </v-card-text>

                        <div class="tem_img"> <img :src="exImg3"> </div>

                        <!-- 템플릿 예시 이미지 출력 : 모달 -->
                        <v-dialog max-width="50%">
                            <v-btn dark block slot="activator"> 예시 보기 </v-btn>
                            <v-card>
                                <v-card-text> 기본 템플릿3 예시 이미지 출력 </v-card-text>
                                <div class="tem_img"> <img :src="exImg3"> </div>
                            </v-card>
                        </v-dialog>

                        <!-- 템플릿 선택하기 : 모달 -->
                        <v-dialog v-model="tem3" max-width="20%">
                            <v-btn dark block slot="activator"> 템플릿 선택 </v-btn>
                            <v-card>
                                <v-card-text> 
                                    <h3> 기본 템플릿3으로 적용하시겠습니까? </h3>
                                    <v-btn  color="green darken-1" flat 
                                        @click.native="selected_template=3; tem3 = false"> 예 </v-btn>                                    
                                    <v-btn color="green darken-1" flat  @click.native="tem3 = false"> 아니오 </v-btn>
                                </v-card-text>
                            </v-card>
                        </v-dialog>
                    </v-card>
                </v-flex>

                <!-- 서비스에서 제공하는 메뉴판 기본 템플릿4 -->
                <v-flex xs3 style="font-size: 1.2rem;" elevation-3>
                    <v-card>
                        <v-card-text> 기본 템플릿4 </v-card-text>

                        <div class="tem_img"> <img :src="exImg4"> </div>

                        <!-- 템플릿 예시 이미지 출력 : 모달 -->
                        <v-dialog max-width="50%">
                            <v-btn dark block slot="activator"> 예시 보기 </v-btn>
                            <v-card>
                                <v-card-text> 기본 템플릿4 예시 이미지 출력 </v-card-text>
                                <div class="tem_img"> <img :src="exImg4"> </div>
                            </v-card>
                        </v-dialog>

                        <!-- 템플릿 선택하기 : 모달 -->
                        <v-dialog v-model="tem4" max-width="20%">
                            <v-btn dark block slot="activator"> 템플릿 선택 </v-btn>
                            <v-card>
                                <v-card-text> 
                                    <h3> 기본 템플릿4으로 적용하시겠습니까? </h3> 
                                    <v-btn  color="green darken-1" flat 
                                        @click.native="selected_template=4; tem4 = false"> 예 </v-btn>
                                    <v-btn color="green darken-1" flat @click.native="tem4 = false"> 아니오 </v-btn>
                                </v-card-text>
                            </v-card>
                        </v-dialog>

                    </v-card>
                </v-flex>
            </v-layout>

            <!-- 메뉴판 템블릿 커스터마이징 -->
            <v-layout elevation-3>
                <v-flex xs12 style="font-size: 2rem;">
                    <v-card>
                         <v-card-text>
                            <b> 메뉴판 템플릿 제작 </b>
                        </v-card-text>
                    </v-card>
                </v-flex>
            </v-layout>

            <v-layout elevation-3>
                <v-flex xs12>
                    <v-card>
                        <v-card-text style="font-size: 1rem;"> 
                            <!-- 제작 툴로 이동. -->
                            <v-btn dark @click="create_menu"> 메뉴판 제작 </v-btn>
                                제작 툴을 사용하여 자신만의 메뉴판을 직접 제작합니다.
                        </v-card-text> 
                    </v-card> 
                </v-flex>
            </v-layout>

        </v-container>
    </div>
</template>
        
<script type="text/javascript"> 
import VueAxios from 'vue-axios';
import axios from 'axios'; 
 
export default { 
    data () {
        return { 
            // 이미지 주소 주소 설정 좀여
            exImg1 : '/images/template/template1.jpeg',
            exImg2 : '/images/template/template2.png',
            exImg3 : '/images/template/template3.png',
            exImg4 : '/images/template/template4.png',

            // 모달 용 
            tem1: false,
            tem2: false,
            tem3: false,
            tem4: false,

            // 선택한 템플릿
            selected_template : "없음" 
        }
    },
    created() {
        // 메뉴 레이아웃 가져오기
        var url = '';
        var layoutNum = null;
        var shop_id = this.$route.params.shop_id;

        url = '/owner/' + shop_id + '/getLayout';

        // 카테고리 요청하기.
        axios.get(url)
            .then( (response) => {
                layoutNum = response.data.layoutNum;
                this.selected_template = "기본 템플릿" + layoutNum;
            })
            .catch((ex)=>{
                alert('레이아웃 로드 실패');
            });
    },
    methods : {

        // 저장하기
        save_data : function () { 
            var slt_tem = this.selected_template; // 선택한 템플릿

            if ( slt_tem === '없음'){
                alert('메뉴판 템플릿을 선택해주세요');
            }
            else { 
                // 선택한 템플릿 설정 저장하기.
                let url = '이거 설정 좀여';
            
                axios.post(url, slt_tem)
                .then( (response) => {
                    get_datas = response.data 
                })
                .catch((ex)=>{
                    alert('저장 실패');
                })
            }
        },
        // 커스터마이징
        create_menu : function() {
            alert('메뉴판 제작');
            // 메뉴판 제작 툴로 페이지 이동.
            window.location.href = "/#/OwnerMenuCreate" 
        }
    }

}

</script>

<style>
    .tem_img {
        position: relative;
        width: 100%;
        height: 0;
        overflow: hidden;
        padding-bottom: 70%;
    }
    img { 
        position: absolute;
	    top: 0;
	    left: 0;
	    width: 100%;
	    height: 100%; 
    }
</style>