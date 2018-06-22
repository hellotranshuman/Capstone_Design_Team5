<!-- 식당 사장이 메뉴판이 출력될 레이아웃을 선택하거나 직접 제작 할 수 있도록 한다. -->

<template>
    <div class="container" style="width:100%;">
        <v-container grid-list-md>
            <!-- 스낵바 : 경고 창 출력 -->
            <v-snackbar :timeout="timeout" :top="'top'" v-model="snackbar">
                {{ snackbar_text }}
                <v-btn flat color="pink" icon @click.native="snackbar = false">
                    <v-icon large> close </v-icon>
                </v-btn>
            </v-snackbar>

            <!--*************************************************** 기본 레이아웃 ***************************************************-->
            <!-- 서비스에서 제공하는 메뉴판 기본 템플릿 중 하나 선택하기. -->
            <v-layout elevation-3>
                <v-flex xs10 style="font-size: 2rem;">
                    <v-card>
                        <v-card-text>
                            <b> 메뉴판 템플릿 선택 - 선택한 템플릿 : </b>
                            <b v-if="selectWhat==null">   {{selected_template}} </b>
                            <b v-else-if="selectWhat=='bas'">
                                기본 템플릿 {{selectTemPrt}}
                            </b>
                            <b v-else-if="selectWhat=='cos'">
                                {{selectTemPrt}}
                            </b>
                        </v-card-text>
                    </v-card>
                </v-flex>
                <v-flex xs2 style="font-size: 2rem;">
                    <v-btn color="error" block style="font-size:1.5rem; height:90%; font-weight:bold" @click="save_data">
                        저장하기
                    </v-btn>
                </v-flex>
            </v-layout>

            <!-- 기본 템플릿 예시보기. -->
            <v-dialog v-model="ExTemplete" max-width="50%">
                <v-card align-content-center @click.native="ExTemplete = false">
                    <v-card-text style="font-size:1.5rem;">
                        <b> 기본 템플릿 {{selectTemplete}} </b>
                    </v-card-text>
                    <div class="tem_img">
                        <img v-if="selectTemplete == 1" class="inner_img" :src="exImg1">
                        <img v-if="selectTemplete == 2" class="inner_img" :src="exImg2">
                        <img v-if="selectTemplete == 3" class="inner_img" :src="exImg3">
                        <img v-if="selectTemplete == 4" class="inner_img" :src="exImg4">
                    </div>
                </v-card>
            </v-dialog>

            <!-- 기본 템플릿 템플릿 선택 확인하기 : 모달 -->
            <v-dialog  v-model="basicTem" max-width="20%" persistent>
                <v-card>
                    <v-card-text>
                        <h3> 기본 템플릿{{selectTemplete}}으로 적용하시겠습니까? </h3>
                        <v-btn flat color="green darken-1" @click="basicTem=false; selectWhat='bas'; selectTemPrt=selectTemplete">
                            예 </v-btn>
                        <v-btn flat color="green darken-1" @click="basicTem=false"> 아니오 </v-btn>
                    </v-card-text>
                </v-card>
            </v-dialog>

            <!-- 기본 메뉴판 템플릿 선택하기. -->
            <v-layout text-xs-center mb-5>
                <!-- 서비스에서 제공하는 메뉴판 기본 템플릿1 -->
                <v-flex xs3 style="font-size: 1.4rem;" elevation-3>
                    <v-card>
                        <v-card-text> <b>기본 템플릿1</b> </v-card-text>

                        <div class="tem_img"> <img class="inner_img" :src="exImg1"> </div>

                        <!-- 모달 출력 버튼 -->
                        <v-card-actions>
                            <v-btn color="primary" block @click="ExTemplete=true; selectTemplete=1"> 예시 보기 </v-btn>
                            <v-btn color="success" block @click="basicTem=true; selectTemplete=1"> 템플릿 선택 </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-flex>

                <!-- 서비스에서 제공하는 메뉴판 기본 템플릿2 -->
                <v-flex xs3 style="font-size: 1.4rem;" elevation-3>
                    <v-card>
                        <v-card-text> <b>기본 템플릿2</b> </v-card-text>

                        <div class="tem_img"> <img class="inner_img" :src="exImg2"> </div>

                        <!-- 모달 출력 버튼 -->
                        <v-card-actions>
                            <v-btn color="primary" block @click="ExTemplete=true; selectTemplete=2"> 예시 보기 </v-btn>
                            <v-btn color="success" block @click="basicTem=true; selectTemplete=2"> 템플릿 선택 </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-flex>

                <!-- 서비스에서 제공하는 메뉴판 기본 템플릿3 -->
                <v-flex xs3 style="font-size: 1.4rem;" elevation-3>
                    <v-card>
                        <v-card-text> <b>기본 템플릿3</b> </v-card-text>

                        <div class="tem_img"> <img class="inner_img" :src="exImg3"> </div>

                        <!-- 모달 출력 버튼 -->
                        <v-card-actions>
                            <v-btn color="primary" block @click="ExTemplete=true; selectTemplete=3"> 예시 보기 </v-btn>
                            <v-btn color="success" block @click="basicTem=true; selectTemplete=3"> 템플릿 선택 </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-flex>

                <!-- 서비스에서 제공하는 메뉴판 기본 템플릿4 -->
                <v-flex xs3 style="font-size: 1.4rem;" elevation-3>
                    <v-card>
                        <v-card-text> <b>기본 템플릿4</b> </v-card-text>

                        <div class="tem_img"> <img class="inner_img" :src="exImg4"> </div>

                        <!-- 모달 출력 버튼 -->
                        <v-card-actions>
                            <v-btn color="primary" block @click="ExTemplete=true; selectTemplete=4"> 예시 보기 </v-btn>
                            <v-btn color="success" block @click="basicTem=true; selectTemplete=4"> 템플릿 선택 </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-flex>
            </v-layout>

            <!--************************************************ 커스터마이징 설정 ***************************************************-->
            <!-- 메뉴판 템블릿 커스터마이징 -->
            <v-layout elevation-5>
                <v-flex xs10 style="font-size: 2rem;">
                    <v-card>
                        <v-card-text> <b> 커스텀마이징 템플릿 </b> </v-card-text>
                    </v-card>
                </v-flex>
                <v-flex xs2>
                    <v-btn color="error" @click="workSpace_set" @click.stop="createMode=true" block
                           style="font-size:1.5rem; height:90%; font-weight:bold">
                        메뉴판 제작
                    </v-btn>
                </v-flex>
            </v-layout>

            <!-- 사용자가 만든 커스텀마이징 템플릿 리스트 div 출력 -->
            <v-layout elevation-3 v-if="loadTemplateList !== null">
                <div style="width:100%;">
                    <v-flex v-for="n in range(0, loadListNum-1)" :key="n" elevation-10
                            style="width:31%; margin:1%; float:left; font-size: 1.2rem; background-color:#F2F2F2">
                        <v-card>
                            <v-card-text style="max-height:60px; font-size:1.5rem; font-weight:bold;">
                                {{loadTemplateList[n].layout_name}}
                            </v-card-text>
                            <div class="tem_img">
                                <img class="inner_img" :src="loadTemplateList[n].thumbnail">
                            </div>
                            <v-card-actions>
                                <v-btn color="primary" block @click="ExCustom=true; selectCustomTem=n;">예시 보기</v-btn>
                                <v-btn color="success" block @click="customTem=true; selectCustomTem=n;">선택</v-btn>
                                <v-btn color="error" block @click="customDeleteDialog=true; selectCustomTem=n;">삭제</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-flex>
                </div>
            </v-layout>

            <!-- 커스텀마이징 템플릿 예시보기 -->
            <v-dialog v-model="ExCustom" max-width="50%" v-if="loadTemplateList !== null">
                <v-card align-content-center @click.native="ExCustom=false">
                    <v-card-text style="font-size:1.5rem;">
                        <b style="text-align:center"> {{loadTemplateList[selectCustomTem].layout_name}} </b>
                    </v-card-text>
                    <div class="tem_img">
                        <img class="inner_img" :src="loadTemplateList[selectCustomTem].thumbnail">
                    </div>
                </v-card>
            </v-dialog>

            <!-- 커스텀마이징 템플릿 선택 확인하기 : 모달 -->
            <v-dialog v-model="customTem" max-width="20%" persistent v-if="loadTemplateList !== null">
                <v-card>
                    <v-card-text>
                        <h3> {{loadTemplateList[selectCustomTem].layout_name}} 으로 적용하시겠습니까? </h3>
                        <v-btn @click="customTem=false; selectWhat='cos';
                                selectTemPrt=loadTemplateList[selectCustomTem].layout_name"
                               flat color="green darken-1" > 예 </v-btn>
                        <v-btn flat color="green darken-1" @click="customTem=false"> 아니오 </v-btn>
                    </v-card-text>
                </v-card>
            </v-dialog>

            <!-- 템플릿 삭제하기 : 모달 -->
            <v-dialog v-model="customDeleteDialog" max-width="20%" persistent v-if="loadTemplateList !== null">
                <v-card>
                    <v-card-text style="font-size:1.5rem; font-weight:bold;">
                        {{loadTemplateList[selectCustomTem].layout_name}} 삭제하시겠습니까?
                    </v-card-text>
                    <v-btn flat color="green darken-1" @click="customDelete"> 예 </v-btn>
                    <v-btn flat color="green darken-1" @click="customDeleteDialog = false"> 아니오 </v-btn>
                </v-card>
            </v-dialog>


            <!--**************************************************** 제작 툴********************************************************-->
            <v-layout row justify-center>
                <v-dialog v-model="createMode" fullscreen transition="dialog-bottom-transition">
                    <v-card class="ban_drag">
                        <!-- 상단 툴바 -->
                        <v-layout>
                            <div id="topToolBar" style="width:100%; padding:0.5%; border-bottom:1px solid #A4A4A4;">
                                <b style="font-size:3rem; margin-left:10px; float:left"> 메뉴판 제작 </b>

                                <!-- 불러오기 저장하기 나가기 버튼 -->
                                <v-card-actions style="float:right">
                                    <v-btn large color="info" @click="loadMenuDialog=true"
                                           style="font-size:1.5rem;" block>
                                        불러오기
                                    </v-btn>

                                    <v-btn large color="error" block
                                           style="font-size:1.5rem;" @click.stop="saveMenuDialog=true">
                                        저장하기
                                    </v-btn>

                                    <v-btn large color="blue-grey" class="white--text" block
                                           style="font-size:1.5rem;" @click.stop="createCancelDialog=true">
                                        나가기
                                    </v-btn>
                                </v-card-actions>
                            </div>
                        </v-layout>

                        <!-- 불러오기 모달 -->
                        <v-dialog v-model="loadMenuDialog" width="40%" scrollable="" persistent>
                            <v-card>
                                <v-card-title primary-title>
                                    <div style="text-align:center; font-size:1.5rem; font-weight:bold; color:grey">
                                        메뉴판 불러오기
                                    </div>
                                    <v-spacer></v-spacer>
                                    <v-btn icon style="float:right" @click="loadMenuDialog = false">
                                        <v-icon large> clear </v-icon>
                                    </v-btn>
                                </v-card-title>

                                <ul style="height:300px; overflow:auto; border-top:1.2px solid gray;">
                                    <li v-for="i in range(0, loadListNum-1)" :key="i" class="menuList"
                                        v-if="loadTemplateList !== null" :value="i"
                                        @click="loadCreateMenu" @click.capture="temName = loadTemplateList[i].layout_name">
                                        {{ loadTemplateList[i].layout_name }}
                                    </li>
                                </ul>
                            </v-card>
                        </v-dialog>

                        <!-- 저장하기 모달 -->
                        <v-dialog v-model="saveMenuDialog" width="40%" scrollable="" persistent>
                            <v-card>
                                <v-card-title primary-title>
                                    <div style="text-align:center; font-size:1.5rem; font-weight:bold; color:grey">
                                        메뉴판 저장하기
                                    </div>
                                </v-card-title>
                                <div style="width:100%; height:50px; border-top:1.2px solid gray; padding-left:10px; margin-bottom:20px;">
                                    <v-text-field
                                            label="템플릿 명 설정"
                                            v-model="temName"
                                            full-width
                                            :rules="[(v) => v.length <= 15 || '최대 15자입니다.']"
                                            :counter="15"
                                            autofocus >
                                    </v-text-field>
                                </div>

                                <ul style="height:200px; overflow:auto; border-top:1.2px solid gray; border-bottom:1.2px solid gray;">
                                    <li v-for="i in range(0, loadListNum-1)" :key="i" class="menuList"
                                        v-if="loadTemplateList !== null"
                                        @click="editCreateMenu" :value="i">
                                        {{ loadTemplateList[i].layout_name }}
                                    </li>
                                </ul>
                                <v-card-actions>
                                    <button class="color_btn" @click="makeThumbnail"> 저장 </button>
                                    <button class="color_btn" @click="saveMenuDialog=false"> 취소 </button>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>

                        <!-- 나가기 모달 -->
                        <v-dialog v-model="createCancelDialog" width="40%" scrollable="" persistent>
                            <v-card>
                                <v-card-title primary-title>
                                    <div style="text-align:center; font-size:2rem; font-weight:bold; color:grey">
                                        메뉴판 제작을 종료하시겠습니까?
                                    </div>
                                </v-card-title>
                                <v-card-actions>
                                    <button class="color_btn" @click="createCancel">예</button>
                                    <button class="color_btn" @click="createCancelDialog=false">취소</button>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>

                        <!-- 하단 작업 공간 & 툴바 -->
                        <v-layout style="width:100%; border-bottom:1px solid #585858;">
                            <!-- 왼쪽 사이드 툴바 : 메뉴 생성 -->
                            <v-flex id='leftToolBar' xs2 style="border-right:1px solid #585858;">
                                <v-list id="selectColumn" style="background-color:#F2F2F2;">
                                    <v-list-tile avatar>
                                        <v-list-tile-content>
                                            <v-list-tile-title class="list-style">
                                                <b>메뉴판 요소 선택</b>
                                            </v-list-tile-title>
                                        </v-list-tile-content>
                                    </v-list-tile>
                                </v-list>

                                <v-list class="pt-0">
                                    <v-divider></v-divider>

                                    <!-- 메뉴 이미지 -->
                                    <v-list-tile @click="dragArea" class='mt-3' @click.capture="item = 'createdImg'">
                                        <v-list-tile-action>
                                            <v-icon>image</v-icon>
                                        </v-list-tile-action>
                                        <v-list-tile-content>
                                            <v-list-tile-title class="list-style">메뉴 이미지</v-list-tile-title>
                                        </v-list-tile-content>
                                    </v-list-tile>

                                    <!-- 메뉴 명 생성 -->
                                    <v-list-tile @click="dragArea" class='mt-3' @click.capture="item = 'createdName'">
                                        <v-list-tile-action>
                                            <v-icon>title</v-icon>
                                        </v-list-tile-action>
                                        <v-list-tile-content>
                                            <v-list-tile-title class="list-style">메뉴 명</v-list-tile-title>
                                        </v-list-tile-content>
                                    </v-list-tile>

                                    <!-- 메뉴 설명 생성 -->
                                    <v-list-tile @click="dragArea" class='mt-3' @click.capture="item = 'createdExpl'">
                                        <v-list-tile-action>
                                            <v-icon>assignment</v-icon>
                                        </v-list-tile-action>
                                        <v-list-tile-content>
                                            <v-list-tile-title class="list-style">메뉴 설명</v-list-tile-title>
                                        </v-list-tile-content>
                                    </v-list-tile>

                                    <!-- 런치 / 디너 구분 생성 -->
                                    <v-list-tile @click="dragArea" class='mt-3' @click.capture="item = 'createdL_D'">
                                        <v-list-tile-action>
                                            <v-icon>assignment</v-icon>
                                        </v-list-tile-action>
                                        <v-list-tile-content>
                                            <v-list-tile-title class="list-style">런치 / 디너 구분</v-list-tile-title>
                                        </v-list-tile-content>
                                    </v-list-tile>

                                    <!-- 메뉴 가격 -->
                                    <v-list-tile @click="dragArea" class='mt-3' @click.capture="item = 'createdPrice'">
                                        <v-list-tile-action>
                                            <v-icon>attach_money</v-icon>
                                        </v-list-tile-action>
                                        <v-list-tile-content>
                                            <v-list-tile-title class="list-style">메뉴 가격</v-list-tile-title>
                                        </v-list-tile-content>
                                    </v-list-tile>

                                    <!-- 메뉴 선택 버튼 -->
                                    <v-list-tile @click="dragArea" class='mt-3' @click.capture="item = 'createdSelect'">
                                        <v-list-tile-action>
                                            <v-icon>check_circle</v-icon>
                                        </v-list-tile-action>
                                        <v-list-tile-content>
                                            <v-list-tile-title class="list-style">메뉴 선택 버튼</v-list-tile-title>
                                        </v-list-tile-content>
                                    </v-list-tile>
                                </v-list>
                            </v-flex>

                            <!-- 작업 공간 -->
                            <v-flex xs8>
                                <div id="workSpace">
                                    <div id="menu" class="createdMenu">
                                        <div id="ElementArea"></div>
                                    </div>
                                </div>
                            </v-flex>

                            <!-- 오른쪽 사이드 툴바 : 기타 설정 -->
                            <v-flex xs2 style="border-left:1px solid #A4A4A4;">
                                <v-list style="background-color:#F2F2F2;">
                                    <v-list-tile avatar>
                                        <v-list-tile-content>
                                            <v-list-tile-title class="list-style">
                                                <b>메뉴 영역 비율 설정</b>
                                            </v-list-tile-title>
                                        </v-list-tile-content>
                                    </v-list-tile>
                                </v-list>

                                <div class="designSet_tr">
                                    <b class="designSet_name"> 세로 비율 설정</b> <br>
                                    <input type="text" id="menuRatio" class="designSet_ipt">%
                                    <button style="width: 30%; margin-left:2%; font-weight:bold"
                                            @click="setMenuRatio">적용</button>
                                </div>

                                <v-list style="margin-top:10%; background-color:#F2F2F2;">
                                    <v-list-tile avatar>
                                        <v-list-tile-content>
                                            <v-list-tile-title class="list-style">
                                                <b>메뉴 출력 설정</b>
                                            </v-list-tile-title>
                                        </v-list-tile-content>
                                    </v-list-tile>
                                </v-list>

                                <v-divider></v-divider>

                                <div class="designSet_tr">
                                    <b class="designSet_name">1줄에 출력될 메뉴의 갯수</b> <br>

                                    <select id="MenuNum" class="designSet_ipt">
                                        <option value=1> 1 </option>
                                        <option value=2> 2 </option>
                                        <option value=3 selected> 3 </option>
                                        <option value=4> 4 </option>
                                    </select> 개
                                </div>

                                <div class="designSet_tr" style="margin-bottom: 5%">
                                    <b class="designSet_name">메뉴 간격</b> <br>
                                    <select id="MenuMargin" class="designSet_ipt">
                                        <option value=1 selected> 1 </option>
                                        <option value=2> 2 </option>
                                        <option value=3> 3 </option>
                                    </select> %
                                </div>
                            </v-flex>
                        </v-layout>

                        <!-- 마우스 오른쪽 버튼 클릭스 나타나는 메뉴 창 -->
                        <div id="click_menu" class="context-menus">
                            <ul class="ul_style">
                                <li id="goFont" @click="zIndexSet" class="li_style"><b>앞으로</b></li>
                                <hr class="hr_style">

                                <li id="goBack" @click="zIndexSet" class="li_style"><b>뒤로</b></li>
                                <hr class="hr_style">

                                <li @click.stop="CallDesignSet" class="li_style"><b>영역 서식</b></li>
                                <hr class="hr_style">

                                <li @click="DeleteElement" class="li_style"><b>삭제하기</b></li>
                            </ul>
                        </div>

                        <!-- 영역 서식 메뉴창 -->
                        <v-dialog v-model="designSetDialog" width="40%" scrollable="" persistent>
                            <v-card>
                                <!-- 타이틀, 저장, 취소 -->
                                <v-card-title style="border-bottom:1.2px solid #A4A4A4;">
                                    <b class="designSet_title"> 영역 서식 </b>
                                    <v-spacer></v-spacer>

                                    <v-btn icon style="float:right" @click="SetColorAndShape">
                                        <v-icon large> done </v-icon>
                                    </v-btn>
                                    <v-btn icon style="float:right" @click="designSetDialog = false">
                                        <v-icon large> clear </v-icon>
                                    </v-btn>
                                </v-card-title>

                                <!-- 설정 항목 -->
                                <v-flex xs12 style="overflow: scroll;">
                                    <div class="designSet_tr" style="margin-top:5%">
                                        <b class="designSet_name">선 굵기 설정</b> <br>
                                        <input type="text" id="line_width" class="designSet_ipt" value="2"> px
                                    </div>

                                    <div class="designSet_tr">
                                        <b class="designSet_name">선 스타일 설정</b> <br>

                                        <select id="line_style" class="designSet_ipt">
                                            <option value="solid"> 직선 </option>
                                            <option value="none"> 없음 </option>
                                            <option value="dotted"> 짧은 점선 </option>
                                            <option value="dashed"> 긴 점선 </option>
                                            <option value="double"> 곂선 </option>
                                        </select> (선택)
                                    </div>

                                    <div class="designSet_tr">
                                        <b class="designSet_name">선 색상 선택</b> <br>

                                        <div style="width:100%; overflow:hidden">
                                            <div class="designSet_color">
                                                <div id="line_color" class="designSet_color_inner"
                                                     style="background-color:black;"></div>
                                            </div>
                                            <button class="designSet_color_btn" @click="CallColorPicker" value='line_color'>
                                                선택하기
                                            </button>
                                            <button class="designSet_color_btn" @click="ColorNull" value='line_color'>
                                                색 없음
                                            </button>
                                        </div>
                                    </div>

                                    <div class="designSet_tr">
                                        <b class="designSet_name">글자 색 선택</b> <br>

                                        <div style="width:100%; overflow:hidden">
                                            <div class="designSet_color">
                                                <div id="text_color" class="designSet_color_inner"
                                                     style="background-color:black;"></div>
                                            </div>
                                            <button class="designSet_color_btn" @click="CallColorPicker" value='text_color'>
                                                선택하기
                                            </button>
                                        </div>
                                    </div>

                                    <div class="designSet_tr">
                                        <b class="designSet_name">영역 색상</b> <br>
                                        <div style="width:100%; overflow:hidden">
                                            <div class="designSet_color">
                                                <div id="area_color" class="designSet_color_inner"></div>
                                            </div>
                                            <button class="designSet_color_btn" @click="CallColorPicker" value='area_color'>
                                                선택하기
                                            </button>
                                            <button class="designSet_color_btn" @click="ColorNull" value='area_color'>
                                                색 없음
                                            </button>
                                        </div>
                                    </div>

                                    <div class="designSet_tr">
                                        <b class="designSet_name">영역 모양 설정</b> <br>
                                        <select id="area_style" class="designSet_ipt">
                                            <option value="quadrangle"> 사각형 </option>
                                            <option value="quadrangle_R"> 둥근 사각형 </option>
                                            <option value="circle"> 원 </option>
                                        </select> (선택)
                                    </div>
                                </v-flex>
                            </v-card>
                        </v-dialog>

                        <!-- 색상 선택 -->
                        <v-dialog v-model="colorDialog" width="30%" persistent style="display:inline-block;">
                            <v-card>
                                <div>
                                    <canvas id="palette" @click="Palette_Click"> </canvas>
                                    <canvas id="bar"     @click="Bar_Click"> </canvas>
                                </div>

                                <div style="width:100%;">
                                    <div id="click_color">선택한 색상</div>
                                </div>

                                <v-card-actions>
                                    <button class="color_btn" @click="SetColor">적용</button>
                                    <button class="color_btn" @click="colorDialog = false">취소</button>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                    </v-card>
                </v-dialog>
            </v-layout>
        </v-container>
    </div>
</template>

<script type="text/javascript">
    import html2canvas from 'html2canvas';          // 화면 캡쳐
    import VueAxios from 'vue-axios';
    import axios from 'axios';

    // element move
    var target_L   = 0;
    var target_T   = 0;
    var target_Obj = null;

    // color picker
    var bar         = null;             // color bar
    var bar_cntxt   = null;             // color bar context
    var palet       = null;             // palette
    var palet_cntxt = null;             // palette context

    // setInterval
    var intervalR = null;               // 메뉴판 요소 경고용 배경 붉은색으로
    var intervalG = null;               // 메뉴판 요소 경고용 배경 회색으로

    var thumbnail = null;               // 섬네일

    export default {
        created(){
            // 메뉴 레이아웃 가져오기
            var url       = '';
            var layoutNum = null;
            var shop_id   = this.$route.params.shop_id;
            url = '/owner/' + shop_id + '/getLayout';

            // 카테고리 요청하기.
            axios.get(url)
                .then( (response) => {
                    layoutNum = response.data.layoutNum;
                    if(layoutNum < 5)
                        this.selected_template = response.data.layoutName + layoutNum;
                    else
                        this.selected_template = "커스터마이징 템플릿 - " + response.data.layoutName;
                })
                .catch((ex)=>{
                    this.snackbar_text = '레이아웃 로드 실패';
                    this.snackbar      = true;
                    return null;
                });

            this.loadCreateMenuList();
        },
        data () {
            return {
                // 스낵바 설정값
                timeout         : 2000,
                snackbar_text   : '',
                snackbar        : false,

                selectTemPrt    : 0,                        // 메뉴판 템플릿 선택 - 선택한 템플릿에 출력용으로 사용할 것
                selectTemplete  : 0,                        // 기본 템플릿 선택
                selectCustomTem : 0,                        // 선택한 커스텀 템플릿 인덱스
                selectWhat      : null,                     // 선택한 템플릿이 기본 템플릿인지 커스텀인지 구분
                selected_template : null,                   // 선택한 템플릿 번호

                // showEx
                ExTemplete : false,                         // 기본 템플릿 예시보기
                ExCustom   : false,                         // 커스텀 템플릿 예시보기

                // 이미지 주소 주소 설정 좀여
                exImg1 : '/images/template/template1.jpeg',
                exImg2 : '/images/template/template2.png',
                exImg3 : '/images/template/template3.png',
                exImg4 : '/images/template/template4.png',

                // 미리보기 모달 용
                basicTem: false,
                customTem : false,                      // 커스텀 선택 모달

                customDeleteDialog : false,             // 커스텀마이징 템플릿 삭제

                // 메뉴판 커스텀마이징
                loadMenuDialog     : false,             // 메뉴판 제작 상단 - 불러오기 모달
                saveMenuDialog     : false,             // 메뉴판 제작 상단 - 저장하기 모달
                createCancelDialog : false,             // 메뉴판 제작 상단 - 나가기 모달

                loadTemplateList : null,                // 제작한 메뉴판 리스트 불러오기.
                loadListNum      : 0,                   // 제작한 메뉴판 갯수

                temName     : '',                       // 저장할 템플릿 명

                createMode  : false,                    // 제작 판 모달 용
                item        : null,                     // 사이드 툴바에서 선택한 리스트 값 저장
                area        : null,                     // 메뉴 요소 생성 용
                Resizer     : null,                     // 엘리먼트 리사이즈 용

                designSetDialog : false,                // 영역 서식 용
                colorDialog     : false,                // 색 선택

                appColor : null,                        // 선 색, 영역 색상 구분용

                longWidth : true,                       // true : 너비가 높이 보다 더 김, false : 높이가 너비보다 더 김
            }
        },
        methods : {
            // 템플릿 선택 - 저장하기
            save_data : function () {
                let select_tem = null;                      // 선택한 템플릿
                let url        = '/saveSelectedLayout';     // 템플릿 선택하기.

                // 기본 템플릿 선택 시
                if(this.selectWhat=='bas'){
                    select_tem = this.selectTemplete;
                }
                // 커스텀 템플릿 선택 시
                else if(this.selectWhat=='cos'){
                    select_tem = this.loadTemplateList[this.selectCustomTem].id;
                }
                // 아무것도 선택하지 않았을 경우
                else if (this.selectWhat === null) {
                    this.snackbar_text = '메뉴판 템플릿을 선택해주세요';
                    this.snackbar      = true;
                    return null;
                }

                // 서버 요청
                axios.post(url, {
                    'slt_tem' : select_tem,
                    'shop_id' : this.$route.params.shop_id,
                })
                    .then( (response) => {
                        this.snackbar_text = '저장이 완료 되었습니다';
                        this.snackbar      = true;
                        location.reload();
                    })
                    .catch((ex)=>{
                        this.snackbar_text = '저장 실패';
                        this.snackbar      = true;
                    })
            },

            // 커스텀마이징 템플릿 삭제하기
            customDelete : function(){
                this.customDeleteDialog = false;
                let temData = this.loadTemplateList[this.selectCustomTem];  // 선택한 템플릿의 데이터
                let url     = '/deleteSelectedLayout';

                axios.post(url, {
                    'costom'  : temData.id
                })
                    .then( (response) => {
                        this.snackbar_text = '선택하신 템플릿을 삭제하였습니다.';
                        this.snackbar      = true;
                        this.loadCreateMenuList();                              // 메뉴 데이터 다시 불러오기.
                    })
                    .catch((ex)=>{
                        this.snackbar_text = '서버 연결 실패!';
                        this.snackbar      = true;
                    });
            },

            // 제작한 메뉴 리스트 불러오기
            loadCreateMenuList : function(){
                // 한번만 실행하기 layout_name
                let url = '/loadCustomLayout';

                axios.post(url, {
                    'shop_id' : this.$route.params.shop_id
                })
                    .then( (response) => {
                        if(response.data.layoutData != null){
                            this.loadTemplateList = response.data.layoutData;                      // 제작한 메뉴판 리스트
                            this.loadListNum      = this.loadTemplateList.length;            // 제작한 메뉴판 갯수
                        } else {
                            this.snackbar_text = '저장된 템플릿이 없습니다.';
                            this.snackbar      = true;
                        }
                    })
                    .catch((ex)=>{
                        this.snackbar_text = '메뉴 리스트 불러오기 실패';
                        this.snackbar      = true;
                    });
            },

            // 제작한 메뉴 불러와서 menu div에 삽입
            loadCreateMenu : function(){
                // 더블 클릭 방지용.
                if(this.loadMenuDialog == false) return null;

                let clickTem     = this.loadTemplateList[event.target.value];    // 클릭한 템플릿
                let loadTemplate = JSON.parse(clickTem.layout_data);             // 선택한 템플릿 설정 값 가져오기
                let workSpace    = document.getElementById('workSpace');         // 작업 영역
                let workSpace_w  = workSpace.clientWidth;                        // 작업 영역 너비
                let workSpace_h  = workSpace.clientHeight;                       // 작업 영역 높이
                let menu         = document.getElementById('menu');              // 메뉴 가져오기
                let menuRatio    = document.getElementById('menuRatio');         // 세로 비율 설정
                let MenuNum      = document.getElementById('MenuNum');           // 1줄에 출력될 메뉴 갯수
                let MenuMargin   = document.getElementById('MenuMargin');        // 메뉴 간격
                let MenuElement  = [                                             // 메뉴 요소들
                    'createdExpl','createdImg','createdL_D',
                    'createdName','createdPrice','createdSelect'
                ];
                // 메뉴 영역 요소들 지우기
                this.menuAreaCleaner();

                MenuNum.value    = loadTemplate.MenuNum;                                // 한줄에 출력될 메뉴 갯수 설정
                MenuMargin.value = loadTemplate.MenuMargin;                             // 메뉴 간의 간격
                menuRatio.value  = loadTemplate.createdMenu.ratio;                      // 메뉴 세로 비율
                this.setMenuRatio();                                                    // 메뉴 세로 비율 값 적용

                let menu_w = menu.style.width.replace('px', '');                        // 메뉴 너비 픽셀 값
                let menu_h = menu.style.height.replace('px', '');                       // 메뉴 높이 픽셀 값
                let menu_l = 0;                                                         // 메뉴 top 픽셀 값
                let menu_t = 0;                                                         // 메뉴 left 픽셀 값

                // 메뉴 영역 left, top 값 설정
                if(this.longWidth){
                    menu_t = Math.floor(workSpace_h * 0.03);                            // 패딩 값
                    menu_l = Math.floor(workSpace_w * 0.03);
                }else{
                    menu_l = Math.floor((workSpace_w - menu_w) / 2);                    // (작업 공간 높이 - 메뉴 영역 높이)/2
                    menu_t = Math.floor((workSpace_h - menu_h) / 2);
                }

                menu.style.color           = loadTemplate.createdMenu.color;            // 메뉴 글자 색
                menu.style.border          = loadTemplate.createdMenu.border;           // 메뉴 테두리 값
                menu.style.borderRadius    = loadTemplate.createdMenu.borderRadius;     // 메뉴 테두리 모양 설정
                menu.style.backgroundColor = loadTemplate.createdMenu.backgroundColor;  // 메뉴 배경 색 설정

                // 메뉴 요소 설정.
                for(let i=0; i< MenuElement.length; i++){
                    let element = document.createElement('div');
                    let reSizer = document.createElement('div');
                    let t = loadTemplate[MenuElement[i]].top.replace('%', '');
                    let l = loadTemplate[MenuElement[i]].left.replace('%', '');
                    let w = loadTemplate[MenuElement[i]].width.replace('%', '');
                    let h = loadTemplate[MenuElement[i]].height.replace('%', '');

                    element.style.top             = Math.floor( menu_h * t/100) + menu_t +'px';
                    element.style.left            = Math.floor( menu_w * l/100) + menu_l +'px';
                    element.style.width           = Math.floor( menu_w * w/100) + 'px';
                    element.style.height          = Math.floor( menu_h * h/100) + 'px';
                    element.style.border          = loadTemplate[MenuElement[i]].border;
                    element.style.zIndex          = loadTemplate[MenuElement[i]].zIndex;
                    element.style.color           = loadTemplate[MenuElement[i]].color;
                    element.style.backgroundColor = loadTemplate[MenuElement[i]].backgroundColor;
                    element.style.borderRadius    = loadTemplate[MenuElement[i]].borderRadius;
                    element.style.position        = 'absolute';

                    switch(MenuElement[i]){
                        case 'createdImg'   : element.innerText = '메뉴 이미지';      break;
                        case 'createdExpl'  : element.innerText = '메뉴 설명';      break;
                        case 'createdL_D'   : element.innerText = '런치 / 디너';    break;
                        case 'createdName'  : element.innerText = '메뉴명';         break;
                        case 'createdPrice' : element.innerText = '메뉴 가격';      break;
                        case 'createdSelect': element.innerText = '메뉴 선택 버튼';  break;
                    }
                    element.classList.add(MenuElement[i]);
                    element.classList.add('dragElement');
                    element.onmousedown = this.startDrag;
                    element.addEventListener("contextmenu", this.ShowContextmenu);     // 마우스 오른쪽 클릭 시 메뉴 창 열기.

                    // element 크기 조절기
                    reSizer.onmousedown = this.initResize;
                    reSizer.classList.add('resizer');

                    // 포함 시키기
                    element.appendChild(reSizer);
                    menu.appendChild(element);
                }
                this.loadMenuDialog = false;                                        // 모달 창 닫기
            },

            // 모든 메뉴 요소가 입력되지 않았는데 저장하면 selectColumn 색깔 변화시키기 setInterval
            selectColumn_sIv_start : function(){
                let selectColumn = document.getElementById('selectColumn');
                let count = 0;

                // 연속 클릭 금지
                if(typeof intervalR !== 'number' && typeof intervalG !== 'number'){
                    intervalR = setInterval(function(){
                        selectColumn.style.backgroundColor = '#F6CECE';
                        count++;
                    }, 300);

                    intervalG = setInterval(function(){
                        selectColumn.style.backgroundColor = '#F2F2F2'
                        if(count === 6){
                            clearInterval(intervalR);
                            clearInterval(intervalG);
                            intervalR = null;
                            intervalG = null;
                        }
                    }, 600);
                }
            },

            // 메뉴 수정하기.
            editCreateMenu : function(){
                this.temName = event.target.innerText
            },

            // 섬네일 만들기 및 검사
            makeThumbnail : function(){
                let menu          = document.getElementById('menu');        // 파일로 만들 div
                let save          = this.createSave;                        // 저장하기
                let dataURItoBlob = this.dataURItoBlob;                     // 파일로 만들기.
                this.saveMenuDialog = false

                // 메뉴 요소가 모두 생성되지 않았으면 경고창 출력
                if(menu.children.length !== 7 ){
                    this.snackbar_text = '메뉴판 요소를 모두 생성해주세요!';
                    this.snackbar      = true;
                    this.selectColumn_sIv_start();
                    return null;
                }
                // 템플릿 명 설정 유효성 검사
                else if(this.temName.replace(/ /gi, "") === ''){
                    this.snackbar_text = '템플릿 명을 입력해주세요!';
                    this.snackbar = true;
                    return null;
                }
                // 입력된 글자가 18자를 넘길 경우 경고
                else if(this.temName.toString().length > 15){
                    this.snackbar_text = '입력 가능한 글자 수는 최대 15자 입니다.';
                    this.snackbar      = true;
                    return;
                }

                // 메뉴 캡쳐하기.
                html2canvas(menu).then(function(canvas) {
                    thumbnail = dataURItoBlob(canvas.toDataURL("image/png"));
                    save();
                });
            },

            // convert base64/URLEncoded data component to raw binary data held in a string
            // 섬네일을 이미지 파일로 만들기.
            dataURItoBlob : function (dataURI) {
                let byteString = null;
                let mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];     // 마임타입 추출
                let ia         = null;                                                  // write the bytes of the string to a typed array

                if (dataURI.split(',')[0].indexOf('base64') >= 0)
                    byteString = atob(dataURI.split(',')[1]);
                else
                    byteString = unescape(dataURI.split(',')[1]);

                ia = new Uint8Array(byteString.length);

                for (var i=0; i < byteString.length; i++){
                    ia[i] = byteString.charCodeAt(i);
                }
                return new Blob([ia], {type:mimeString});
            },

            // 메뉴판 제작 - 작업 내용 저장하기.
            createSave : function() {
                let formData    = new FormData();                                // 엘리먼트들을 담음
                let MenuNum     = document.getElementById('MenuNum');            // 한줄에 표시될 메뉴 갯수
                let MenuMargin  = document.getElementById('MenuMargin');         // 메뉴들 간격 설정
                let workSpace   = document.getElementById('workSpace');          // 작업 공간 div 가져오기
                let workSpace_w =  workSpace.clientWidth;
                let workSpace_h =  workSpace.clientHeight;
                let ElementArea = document.getElementById('ElementArea');        // 비교 용
                let array       = {};                                            // 요소들의 css 값을 담을 배열, json으로 변환

                // 메뉴 영역
                let menu   = document.getElementById('menu');
                let menu_t = 0;                                         // top 값을 %값이 아닌 px 값으로 받음
                let menu_l = 0;                                         // left 값을 %값이 아닌 px 값으로 받음
                let menu_w = menu.clientWidth;                          // 너비를 %값이 아닌 px 값으로 받음
                let menu_h = menu.clientHeight;                         // 높이를 %값이 아닌 px 값으로 받음
                let ratio  = Math.floor(menu_h/menu_w*100);

                // 메뉴 영역 top, left 설정
                // 너비가 높이 보다 더 긴 경우 패딩 값 3%가 메뉴 영역의 left 값이 됨
                if(this.longWidth) {
                    menu_l = Math.floor(workSpace_w * 0.03);
                }
                // 높이가 너비 보다 더 긴 경우
                else {
                    // menu_t = Math.floor((workSpace_h - menu_h) / 2);
                    menu_l = Math.floor((workSpace_w - menu_w) / 2);
                }
                menu_t = Math.floor(workSpace_h * 0.03);

                array['MenuNum']    = MenuNum.value;                    // 한 줄에 출력 될 메뉴의 갯수
                array['MenuMargin'] = MenuMargin.value;                 // 메뉴 간의 간격 설정

                // 배열에 style 값 담기
                array['createdMenu'] = {
                    'ratio'           : ratio,
                    'border'          : menu.style.border,
                    'borderRadius'    : menu.style.borderRadius,
                    'color'           : menu.style.color,
                    'backgroundColor' : menu.style.backgroundColor,
                };

                // 메뉴 안의 요소들 가공하기 & 배열에 담기.
                for(let i = 0; i < menu.children.length; i++){
                    if( menu.children[i] !== ElementArea ){
                        // 메뉴 영역 안의 메뉴 요소들 스타일 값, 클래스
                        let element   = menu.children[i];
                        let eWidth    = element.clientWidth;                            // 엘리먼트 너비 값
                        let eHeight   = element.clientHeight;                           // 엘리먼트 높이 값
                        let eTop      = element.style.top.replace('px', '');;           // 엘리먼트 top 값
                        let eLeft     = element.style.left.replace('px', '');           // 엘리먼트 left 값
                        let className = element.getAttribute('class').split(' ')[0];    // 클래스 명 찾기

                        let get_l = eLeft - menu_l;     // padding 값을 없앰
                        let get_t = eTop - menu_t;

                        // 배열에 style 값 담기
                        array[className] ={
                            'width'           : Math.floor( eWidth / menu_w * 100 ) + "%",
                            'height'          : Math.floor( eHeight / menu_h * 100 ) + "%",
                            'top'             : Math.floor( get_t / menu_h * 100 +1)+ "%",
                            'left'            : Math.floor( get_l / menu_w * 100 +1) + "%",
                            'zIndex'          : element.style.zIndex,
                            'border'          : element.style.border,
                            'borderRadius'    : element.style.borderRadius,
                            'color'           : element.style.color,
                            'backgroundColor' : element.style.backgroundColor,
                        };
                    }
                }
                let Edit = false;           // 참이면 수정, 거짓이면 저장.
                let temID = null;

                // 입력한 템플릿 명이 기존의 템플릿 명과 같다면 수정, 아니면 저장.
                if(this.loadTemplateList !== null) {
                    for (let i = 0; i < this.loadTemplateList.length; i++) {
                        if (this.temName == this.loadTemplateList[i].layout_name) {
                            Edit = true;
                            temID = this.loadTemplateList[i].id;
                            break;
                        }
                    }
                }
                // 메뉴 출력 설정 사항 저장하기.
                formData.append('id', temID);                               // 템플릿 아이디
                formData.append('thumbnail', thumbnail);                    // 템플릿 섬네일
                formData.append('name', this.temName);                      // 작업 명
                formData.append('menu', JSON.stringify(array));             // 메뉴 스타일.
                formData.append('shop_id', this.$route.params.shop_id);     // shopID

                console.log(JSON.stringify(array)); // 체크 용

                // // formData 확인하기
                // for(var pair of formData.entries()) {
                //     console.log(pair[0]+ ': '+ pair[1]);
                // }

                // 수정하기
                if(Edit){
                    axios.post('/updateCustomLayout', formData )
                        .then( (response) => {
                            if(response.data.msg){
                                this.snackbar_text = '저장이 완료되었습니다';
                                this.snackbar      = true;

                                // 메뉴 영역 요소들 지우기
                                this.menuAreaCleaner();
                                this.createMode = false;
                                this.loadCreateMenuList();
                            }
                        })
                        .catch((ex)=>{
                            this.snackbar_text = '저장 실패';
                            this.snackbar      = true;
                        });
                }
                // 저장하기.
                else {
                    axios.post('/saveCustomLayout', formData )
                        .then( (response) => {
                            if(response.data.msg){
                                this.snackbar_text = '저장이 완료되었습니다';
                                this.snackbar      = true;

                                // 메뉴 영역 요소들 지우기
                                this.menuAreaCleaner();
                                this.createMode = false;
                                this.loadCreateMenuList();
                            }
                        })
                        .catch((ex)=>{
                            this.snackbar_text = '저장 실패';
                            this.snackbar      = true;
                        });
                }
            },

            // 메뉴판 제작 나가기
            createCancel : function(){
                this.menuAreaCleaner();
                this.createMode         = false;
                this.createCancelDialog = false;
            },

            // 메뉴판 제작 모달 로드 시 최초 실행. workSpace 및 하위 dom 설정
            workSpace_set : function(){
                let workSpace  = document.getElementById('workSpace');
                let menu       = document.getElementById('menu');
                let click_menu = document.getElementById('click_menu');

                menu.style.width  = '100%';
                menu.style.height = '70%';

                // 마우스 오른쪽 클릭 시 메뉴 창 열기.
                menu.addEventListener("contextmenu", this.ShowContextmenu);

                // 마우스 왼쪽 클릭 시 메뉴 창 닫기.
                workSpace.addEventListener("click", function() {
                    click_menu.classList.remove("active");
                });

                // 높이 퍼센트 조절
                workSpace.style.height = Math.floor(window.innerHeight * 0.9) + "px";
            },

            // 메뉴 영역 비율 설정하기.
            setMenuRatio : function(){
                let menu      = document.getElementById('menu');                        // 메뉴 영역
                let menuRatio = document.getElementById('menuRatio').value;             // 비율 입력 값
                let workSpace = document.getElementById('workSpace');                   // 작업 공간
                let max_w     = Math.floor( parseInt(workSpace.clientWidth) * 0.97 );   // 최대 너비 - 패딩 값
                let max_h     = Math.floor( parseInt(workSpace.clientHeight) * 0.97 );  // 최대 높이 - 패딩 값

                // 빈 값인지 유효성 검사.
                if(menuRatio.replace(/ /gi, "") === ''){
                    this.snackbar_text = '값을 입력해 주세요';
                    this.snackbar      = true;
                    return null;
                }
                // 숫자 값이 맞는지 검사
                else if ( isNaN(menuRatio) == true){
                    this.snackbar_text = '숫자 값을 입력해 주세요';
                    this.snackbar      = true;
                    return null;
                }
                // 세로 비율 적용 값이 최대 너비 값 이상인 경우
                // 메뉴 영역의 높이를 최대 값으로 설정하고 메뉴 영역의 너비를 비율 값으로 설정
                else if( Math.floor( max_w * menuRatio / 100) >= max_h ){
                    menu.style.height = '100%';

                    let h = menu.clientHeight;
                    menu.style.width = Math.floor(h * 100 / menuRatio) +'px';
                    menu.style.height = h +'px';
                    this.longWidth = false;
                }
                // 세로 비율 적용 값이 최대 너비 값 미만인 경우
                // 메뉴 영역의 너비를 최대 값으로 설정하고 메뉴 영역의 높이를 비율 값으로 설정
                else {
                    menu.style.width  = '100%';

                    let w = menu.clientWidth;
                    menu.style.width = w +'px';
                    menu.style.height = Math.floor(w * menuRatio / 100) +'px';
                    this.longWidth = true;
                }
            },

            // 메뉴 요소 생성 클릭
            dragArea : function(){
                let menu = document.getElementById('menu');
                menu.style.cursor = "Crosshair";
                menu.onmousedown = this.dragAreaStart;
                menu.onmouseup   = this.dragAreaStop;
            },

            // 드래그로 메뉴 요소가 만들어질 영역 표시.
            dragAreaStart : function(){
                let ElementArea = document.getElementById('ElementArea');
                let menu        = document.getElementById('menu');
                let margin = 5;

                ElementArea.classList.add('active');
                ElementArea.style.top    = (event.offsetY) + "px";
                ElementArea.style.left   = (event.offsetX) + "px";
                ElementArea.style.width  = '5px';
                ElementArea.style.height = '5px';

                // 마우스 이동 시 이벤트 : 셀렉터 크기 조절
                menu.onmousemove = this.dragAreaSet;
            },

            // 드래그 ing : 셀렉터 크기 조절
            dragAreaSet : function(){
                let margin = 10;
                let menu   = document.getElementById('menu');

                let obj_t  = parseInt(this.getTop(ElementArea));            // 드래그 셀렉터의 top
                let obj_l  = parseInt(this.getLeft(ElementArea));           // left 값
                let obj_r  = obj_l + parseInt(ElementArea.offsetWidth);     // right 값
                let obj_b  = obj_t + parseInt(ElementArea.offsetHeight);    // bottom 값

                let menu_t = parseInt(menu.offsetTop);                      // 메뉴 영역의 top 값
                let menu_l = parseInt(menu.offsetLeft);                     // left 값
                let menu_r = menu_l + parseInt(menu.offsetWidth);           // right 값
                let menu_b = menu_t + parseInt(menu.offsetHeight);          // bottom 값

                // 드래그 셀렉터의 시작 점이 메뉴 영역에 안 벗어나게 하기.
                // 왼쪽 & 위쪽 벗어남
                if(obj_l < menu_l && obj_t < menu_t){
                    ElementArea.style.left = menu_l + margin +"px";
                    ElementArea.style.top  = menu_t + margin +"px";
                }
                // 왼쪽 & 아래쪽 벗어남
                else if(obj_l < menu_l && obj_b > menu_b){
                    ElementArea.style.left = menu_l + margin +"px";
                    ElementArea.style.top  = menu_b - parseInt(ElementArea.offsetHeight) - margin +"px";
                }
                // 오른쪽 & 위쪽 벗어남
                else if(obj_r > menu_r && obj_t < menu_t){
                    ElementArea.style.left = menu_r - parseInt(ElementArea.offsetWidth) - margin +"px";
                    ElementArea.style.top  = menu_t + margin +"px";
                }
                // 위쪽 벗어남
                else if(obj_t < menu_t){
                    ElementArea.style.top  = menu_t + margin +"px";
                }
                // 왼쪽 벗어남
                else if(obj_l < menu_l){
                    ElementArea.style.left = menu_l + margin +"px";
                }

                // 드래그 셀렉터의 크기를 조절할 때 셀렉터의 크기가 메뉴 영역을 넘지 않도록 함.
                // 오른쪽 & 아래쪽 벗어남
                if(obj_r > menu_r && obj_b > menu_b){
                    ElementArea.style.width  = ElementArea.style.width.replace('px', '') - margin + 'px';
                    ElementArea.style.height = ElementArea.style.height.replace('px', '') - margin + 'px';
                    this.dragAreaStop();
                }
                // 오른쪽 벗어남
                else if(obj_r > menu_r){
                    ElementArea.style.width  = ElementArea.style.width.replace('px', '') - margin + 'px';
                    this.dragAreaStop();
                }
                // 아래쪽 벗어남
                else if(obj_b > menu_b){
                    ElementArea.style.height = ElementArea.style.height.replace('px', '') - margin + 'px';
                    this.dragAreaStop();
                }
                // 벗어난 부분 없이 메뉴 영역 안에 있음
                else {
                    ElementArea.style.width  = (event.clientX - ElementArea.offsetLeft) + 'px';
                    ElementArea.style.height = (event.clientY - ElementArea.offsetTop)  + 'px';
                }
            },

            // 드래그 종료 - 메뉴 요소 만들기
            dragAreaStop :function(){
                let menu        = document.getElementById('menu');
                let ElementArea = document.getElementById('ElementArea');

                this.area      = [];
                this.area['t'] = ElementArea.style.top;
                this.area['l'] = ElementArea.style.left;
                this.area['w'] = ElementArea.style.width;
                this.area['h'] = ElementArea.style.height;

                menu.onmousedown = null;
                menu.onmousemove = null;
                menu.onmouseup   = null;

                menu.style.cursor = "Default";
                ElementArea.classList.remove('active');

                this.createSomething();         // 메뉴판 요소 생성
            },

            // 엘리먼트 움직이기 : 위치 값 얻기 - left
            getLeft : function(argObj){
                return parseInt(argObj.style.left.replace('px', ''));
            },
            // 엘리먼트 움직이기 : 위치 값 얻기 - top
            getTop : function(argObj) {
                return parseInt(argObj.style.top.replace('px', ''));
            },
            // 엘리먼트 움직이기 : mouseDown
            startDrag : function() {
                let e_obj  = window.event ? window.event : event;               // 마우스 이벤트
                target_Obj = event.target;

                target_L = this.getLeft(target_Obj) - e_obj.clientX;
                target_T = this.getTop(target_Obj)  - e_obj.clientY;

                document.onmousemove = this.moveStart;
                document.onmouseup   = this.moveStop;
            },
            // 엘리먼트 움직이기 : mouseMove
            moveStart : function(){
                event.preventDefault();
                let e_obj  = window.event ? window.event : event;
                let move_x = parseInt(e_obj.clientX + target_L);
                let move_y = parseInt(e_obj.clientY + target_T);

                // 드래그 하는 element 이동 시키기
                target_Obj.style.left = move_x +"px";
                target_Obj.style.top  = move_y +"px";

                return false;
            },
            // 엘리먼트 움직이기 : mouseUp
            moveStop : function(){
                let menu   = document.getElementById('menu');
                let margin = 5;

                let obj_l  = parseInt(this.getLeft(target_Obj));
                let obj_t  = parseInt(this.getTop(target_Obj));
                let obj_r  = obj_l + parseInt(target_Obj.offsetWidth);
                let obj_b  = obj_t + parseInt(target_Obj.offsetHeight);

                let menu_t = parseInt(menu.offsetTop);
                let menu_l = parseInt(menu.offsetLeft);
                let menu_r = menu_l + parseInt(menu.offsetWidth);
                let menu_b = menu_t + parseInt(menu.offsetHeight);

                // 왼쪽, 위쪽 벗어남
                if(obj_l < menu_l && obj_t < menu_t){
                    target_Obj.style.left = menu_l + margin +"px";
                    target_Obj.style.top  = menu_t + margin +"px";
                }
                // 왼쪽, 아래쪽 벗어남
                else if(obj_l < menu_l && obj_b > menu_b){
                    target_Obj.style.left = menu_l + margin +"px";
                    target_Obj.style.top  = menu_b - parseInt(target_Obj.offsetHeight) - margin +"px";
                }
                // 오른쪽, 위쪽 벗어남
                else if(obj_r > menu_r && obj_t < menu_t){
                    target_Obj.style.left = menu_r - parseInt(target_Obj.offsetWidth) - margin +"px";
                    target_Obj.style.top  = menu_t + margin +"px";
                }
                // 오른쪽, 아래쪽 벗어남
                else if(obj_r > menu_r && obj_b > menu_b){
                    target_Obj.style.left = menu_r - parseInt(target_Obj.offsetWidth)  - margin +"px";
                    target_Obj.style.top  = menu_b - parseInt(target_Obj.offsetHeight) - margin +"px";
                }
                // 왼쪽 벗어남
                else if(obj_l < menu_l){
                    target_Obj.style.left = menu_l + margin +"px";
                }
                // 오른쪽 벗어남
                else if(obj_r > menu_r){
                    target_Obj.style.left = menu_r - parseInt(target_Obj.offsetWidth) - margin +"px";
                }
                // 위쪽 벗어남
                else if(obj_t < menu_t){
                    target_Obj.style.top  = menu_t + margin +"px";
                }
                // 아래쪽 벗어남
                else if(obj_b > menu_b){
                    target_Obj.style.top  = menu_b - parseInt(target_Obj.offsetHeight) - margin +"px";
                }
                document.onmousemove = null;
                document.onmouseup   = null;
            },

            // 엘리먼트 크기 조절 - mouseDown
            initResize : function() {
                this.Resizer     = event.target.parentNode;
                document.addEventListener('mousemove', this.Resize, false);
                document.addEventListener('mouseup', this.stopResize, false);
            },
            // 엘리먼트 크기 조절 - mouseMove
            Resize : function() {
                event.preventDefault();
                let menu   = document.getElementById('menu');
                let margin = 5;

                let obj_l  = parseInt(this.getLeft(this.Resizer));
                let obj_t  = parseInt(this.getTop(this.Resizer));
                let obj_r  = obj_l + parseInt(this.Resizer.offsetWidth);
                let obj_b  = obj_t + parseInt(this.Resizer.offsetHeight);

                let menu_t = parseInt(menu.offsetTop);
                let menu_l = parseInt(menu.offsetLeft);
                let menu_r = menu_l + parseInt(menu.offsetWidth);
                let menu_b = menu_t + parseInt(menu.offsetHeight);

                // 크기가 오른쪽, 아래쪽 벗어남
                if(obj_r > menu_r && obj_b > menu_b){
                    this.Resizer.style.width  = this.Resizer.style.width.replace('px', '') - margin + 'px';
                    this.Resizer.style.height = this.Resizer.style.height.replace('px', '') - margin + 'px';
                    this.stopResize();
                }
                // 오른쪽 벗어남
                else if(obj_r > menu_r){
                    this.Resizer.style.width  = this.Resizer.style.width.replace('px', '') - margin + 'px';
                    this.stopResize();
                }
                // 아래쪽 벗어남
                else if(obj_b > menu_b){
                    this.Resizer.style.height = this.Resizer.style.height.replace('px', '') - margin + 'px';
                    this.stopResize();
                }
                else {
                    let workSpace   = document.getElementById('workSpace');      // 작업 공간 div 가져오기
                    let workSpace_w = workSpace.clientWidth;
                    let workSpace_h = workSpace.clientHeight;
                    let menu_w      = menu.clientWidth;                          // 너비를 %값이 아닌 px 값으로 받음
                    let menu_h      = menu.clientHeight;                         // 높이를 %값이 아닌 px 값으로 받음
                    let leftToolBar = document.getElementById('leftToolBar').clientWidth;
                    let topToolBar  = document.getElementById('topToolBar').clientHeight;

                    // 너비가 높이 보다 더 긴 경우 패딩 값 3%가 메뉴 영역의 left 값이 됨
                    if(this.longWidth) {
                        menu_l = Math.floor(workSpace_w * 0.03);
                    }
                    // 높이가 너비 보다 더 긴 경우
                    else {
                        menu_l = Math.floor((workSpace_w - menu_w) / 2);
                    }
                    // 메뉴 top 값 설정.
                    menu_t = Math.floor(workSpace_h * 0.03);

                    /**********************************************************
                     event.clientX : 마우스 x 축 좌표 값
                     obj_l         : 메뉴 영역과 메뉴 요소의 너비 차
                     menu_l        : 작업 영역과 메뉴 영역의 너비 차
                     leftToolBar   : 좌측 툴바와 작업 영역의 너비 차

                     event.clientY : 마우스 y 축 좌표 값
                     obj_t         : 메뉴 영역과 메뉴 요소의 높이 차
                     menu_t        : 작업 영역과 메뉴 영역의 높이 차
                     topToolBar    : 상단 툴바와 작업 영역의 높이 차
                     ************************************************************/
                    this.Resizer.style.width  = (event.clientX - obj_l - menu_l - leftToolBar) + 'px';
                    this.Resizer.style.height = (event.clientY - obj_t - menu_t - topToolBar) + 'px';
                }

            },
            // 엘리먼트 크기 조절 - mouseUp
            stopResize: function() {
                document.removeEventListener('mousedown', this.initResize, false);
                document.removeEventListener('mousemove', this.Resize, false);
                document.removeEventListener('mouseup', this.stopResize, false);
            },

            // 사이드 메뉴 : 영역(엘리먼트) 생성
            createSomething : function() {
                let resizer      = document.createElement('div');           // element 크기 조절기
                let createdThing = document.createElement('div');           // 생성할 element
                let menu         = document.getElementById("menu");;

                // 메뉴판 요소는 각각 하나씩만 생성할 수 있다.
                for(let i=0; i < menu.children.length; i++) {
                    let created = menu.children[i].getAttribute('class').split(' ')[0];     // 클래스 명으로 구분함.

                    if(created == this.item){
                        this.snackbar      = true;
                        this.snackbar_text = '이미 생성한 요소입니다.';
                        return null;
                    }
                }
                // 메뉴 요소 생성
                switch(this.item){
                    // 메뉴 이미지 만들기
                    case 'createdImg' :
                        createdThing.innerText    = '메뉴 이미지';
                        createdThing.classList.add('createdImg'); break;

                    // 메뉴 이름 만들기
                    case 'createdName' :
                        createdThing.innerText    = '메뉴명';
                        createdThing.classList.add('createdName'); break;

                    // 메뉴 설명 만들기
                    case 'createdExpl' :
                        createdThing.innerText    = '메뉴 설명';
                        createdThing.classList.add('createdExpl'); break;

                    // 런디 치더 구분 만들기
                    case 'createdL_D' :
                        createdThing.innerText    = '런치 / 디너';
                        createdThing.classList.add('createdL_D'); break;

                    // 메뉴 가격
                    case 'createdPrice' :
                        createdThing.innerText    = '메뉴 가격';
                        createdThing.classList.add('createdPrice'); break;

                    // 메뉴 선택
                    case 'createdSelect' :
                        createdThing.innerText    = '메뉴 선택 버튼';
                        createdThing.classList.add('createdSelect'); break;
                }
                createdThing.style.width  = this.area.w;
                createdThing.style.height = this.area.h;

                // 마우스 오른쪽 클릭 시 메뉴 창 열기.
                createdThing.addEventListener("contextmenu", this.ShowContextmenu);

                // 생성된 element
                createdThing.style.top    = this.area.t;
                createdThing.style.left   = this.area.l;
                createdThing.style.zIndex = 10;
                createdThing.style.border = '2px solid black';
                createdThing.onmousedown  = this.startDrag;
                createdThing.classList.add('dragElement');

                // element 크기 조절기
                resizer.onmousedown = this.initResize;
                resizer.classList.add('resizer');

                // 포함 시키기
                createdThing.appendChild(resizer);
                menu.appendChild(createdThing);

            }, // end of createSomething

            // 우클릭 메뉴창 실행하기
            ShowContextmenu : function(){
                let click_menu = document.getElementById("click_menu");   // 마우스 우 클릭 시 나타나는 메뉴
                target_Obj     = event.target;

                click_menu.style.top  = event.y +"px";
                click_menu.style.left = event.x +"px";
                click_menu.classList.add("active");
                event.preventDefault();
            },

            // 우클릭 메뉴창 : 선택한 엘리먼트 앞으로 보내기 또는 뒤로 보내기
            zIndexSet : function() {
                let click_menu = document.getElementById("click_menu");

                // 클릭한 리스트에 맞춰서 z-index 값 변경하기
                if(event.target.id === 'goFont')
                    target_Obj.style.zIndex++;
                else if (event.target.id === 'goBack')
                    target_Obj.style.zIndex--;

                // 우클릭 메뉴창 닫기
                click_menu.classList.remove("active");
            },

            // 우클릭 메뉴창 : 영역 서식 창 열기
            CallDesignSet : function(){
                let click_menu = document.getElementById("click_menu");         // 우 클릭 메뉴창
                click_menu.classList.remove("active");                          // 우클릭 메뉴창 닫기
                this.designSetDialog = true                                     // 모달 창 열기
            },
            // 우클릭 메뉴창 : 영역 서식 설정 사항 적용하기.
            SetColorAndShape : function() {
                let lineWidth = document.getElementById('line_width').value;                    // 선 굵기
                let lineStyle = document.getElementById('line_style').value;                    // 선 스타일
                let lineColor = document.getElementById('line_color').style.backgroundColor;    // 선 색
                let textColor = document.getElementById('text_color').style.backgroundColor;    // 글자 색
                let areaColor = document.getElementById('area_color').style.backgroundColor;    // 영역 색
                let areaStyle = document.getElementById('area_style').value;                    // 영역 스타일

                // 선 스타일 설정(굵기, 색, 형식)
                if(lineStyle !== 'none' && lineColor !== '') {
                    target_Obj.style.border = lineWidth + 'px ' + lineStyle + ' '  + lineColor;
                }
                else if(lineStyle === 'none' || lineColor === ''){
                    target_Obj.style.border = 0;
                }

                target_Obj.style.color = textColor;                 // 글자 색 설정.
                target_Obj.style.backgroundColor = areaColor;       // 영역 색상 설정.

                // 영역 모양 설정
                switch(areaStyle){
                    case 'quadrangle'   : target_Obj.style.borderRadius = '0';      break;
                    case 'quadrangle_R' : target_Obj.style.borderRadius = '20px';   break;
                    case 'circle'       : target_Obj.style.borderRadius = '100%';   break;
                }
                this.designSetDialog = false;
            },

            // 우클릭 메뉴창 : 색 없음
            ColorNull : function() {
                this.appColor = event.target.value;
                let appColor  = document.getElementById(this.appColor);
                appColor.style.backgroundColor = '';
            },
            // 우클릭 메뉴창 : color picker 열기(색상 선택)
            CallColorPicker : function() {
                this.appColor    = event.target.value;
                this.colorDialog = true;
                this.ColorPicker_init();
            },
            // color picker 초기화
            ColorPicker_init : function() {
                let click_color = document.getElementById('click_color');
                click_color.style.backgroundColor = '';
                this.Bar_init();
                this.Palette_init();
                this.DrawingPalette(255, 0, 0);
            },
            // 색상 바 초기화
            Bar_init : function() {
                bar          = document.getElementById('bar');
                bar_cntxt    = bar.getContext('2d');
                let width    = bar.width = 20;
                let height   = bar.height = 256;
                let gradient = bar_cntxt.createLinearGradient(0, 0, width, height);

                gradient.addColorStop(0, '#ff0000');
                gradient.addColorStop(0.166, '#ff00ff');
                gradient.addColorStop(0.333, '#0000ff');
                gradient.addColorStop(0.5, '#00ffff');
                gradient.addColorStop(0.666, '#00ff00');
                gradient.addColorStop(0.834, '#ffff00');
                gradient.addColorStop(1, '#ff0000');

                bar_cntxt.fillStyle = gradient;
                bar_cntxt.fillRect(0, 0, width, height);
            },
            // 색상바 클릭
            Bar_Click : function() {
                let y     = event.clientY - bar.offsetParent.offsetTop;     // y 좌표를 가져온다.
                let color = bar_cntxt.getImageData(0, y, 1, 1).data;        // 해당 위치의 색상을 가져온다.
                this.DrawingPalette(color[0], color[1], color[2]);          // 팔레트 그리기.
            },
            // 팔레트 초기화.
            Palette_init : function() {
                palet        = document.getElementById('palette');
                palet_cntxt  = palet.getContext('2d');
                palet.width  = 256;
                palet.height = 256;
            },
            // 팔레트 그리기.
            DrawingPalette : function(r, g, b) {
                // 위에서부터 1픽셀씩 내려오면서 그림
                for (let i = 0; i < 255; i++)
                {
                    let leftColor = 255 - i; // 왼쪽 [상 -> 하] 명도 계산
                    let gradient = palet_cntxt.createLinearGradient(0, 0, 256, 1); // 그리기
                    gradient.addColorStop(0,'rgb(' + leftColor + ', ' + leftColor + ', ' + leftColor + ')');
                    gradient.addColorStop(1,'rgb(' + r + ', ' + g + ', ' + b + ')');
                    palet_cntxt.fillStyle = gradient;
                    palet_cntxt.fillRect(0, i++, 256, i);

                    // 루프당 명도를 1씩 떨어뜨림.
                    if (r > 0) { r--; }
                    if (g > 0) { g--; }
                    if (b > 0) { b--; }
                }
            },
            // 팔레트 클릭
            Palette_Click : function(){
                let x           = event.clientX - palet.offsetParent.offsetLeft;    // x 좌표를 가져온다.
                let y           = event.clientY - palet.offsetParent.offsetTop;     // y 좌표를 가져온다.
                let color       = palet_cntxt.getImageData(x, y, 1, 1).data;        // 해당 위치의 색상을 가져온다.
                let click_color = document.getElementById('click_color');

                click_color.style.backgroundColor
                    = 'rgba(' + color[0] + ', ' + color[1] + ', ' + color[2] + ', ' + color[3] +')';
            },
            // 우클릭 메뉴창 : color picker - color 적용
            SetColor : function() {
                let click_color = document.getElementById('click_color');
                let appColor    = document.getElementById(this.appColor);

                appColor.style.backgroundColor = click_color.style.backgroundColor;
                this.colorDialog = false;
            },

            // 우클릭 메뉴창 : 선택한 엘리먼트 삭제하기.
            DeleteElement : function() {
                let menu       = document.getElementById('menu');
                let click_menu = document.getElementById("click_menu");

                if(menu === target_Obj){
                    this.snackbar      = true;
                    this.snackbar_text = '메뉴 영역은 삭제할 수 없습니다.';
                } else{
                    target_Obj.parentNode.removeChild(target_Obj);
                }
                click_menu.classList.remove("active");
            },

            // 우클릭 메뉴창 : 취소 - 아무것도 안함.
            clickMenuCancel :function(){
                document.getElementById('click_menu').classList.remove('active');
            },

            // v-for 용 함수, start에서 시작해서 end까지 1식 반환
            range : function (start, end) {
                return Array(end - start + 1).fill().map((_, idx) => start + idx)
            },

            // 커스터마이징 메뉴 - 메뉴 영역 안의 모든 것을 지워버림
            menuAreaCleaner : function(){
                let menu        = document.getElementById('menu');              // 메뉴 영역 div
                let ElementArea = document.getElementById('ElementArea');       // 드래그 div

                // 메뉴 영역 요소들 지우기
                while(menu.children.length > 1) {
                    if(menu.lastChild !== ElementArea)
                        menu.removeChild(menu.lastChild);
                }
            },
        }, // end of method
    }

</script>

<style>
    .ban_drag{
        user-select:none;               /* 드래그 방지 */
        -ms-user-select: none;
        -moz-user-select: -moz-none;
        -webkit-user-select: none;
        -khtml-user-select: none;
    }

    /* 이미지 비율용 스타일 */
    .tem_img {
        width: 100%;
        height: 0;
        padding-bottom: 70%;
        overflow: hidden;
        position: relative;
    }
    .inner_img {
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        position: absolute;
    }

    /* 메뉴 제작 작업 공간 */
    #workSpace {
        width: 100%;
        position: relative;
        overflow: auto;
        margin: auto;
        padding: 3%;
        background-color: #F2F2F2;
    }

    /* 제작한 메뉴판 리스트 불러오기 */
    .menuList {
        font-size: 1.5rem;
        margin-top: 10px;
        padding: 10px;
        color: #424242;
        font-weight: bold;
        list-style: none;
    }
    .menuList:hover {
        background-color: lightblue;
    }

    /* 드래그로 div 선택 */
    #ElementArea {
        width: 10px;
        height: 10px;
        opacity: 0.2;
        z-index: 100;
        background-color: lightcoral;
        position: absolute;
        display: none;
    }
    #ElementArea.active{
        display: block;
    }

    /* 메뉴 출력 설정 */
    #MenuPrt {
        width: 30%;
        z-index:100;
        margin-top: 5%;
        border: 3px solid #585858;
        background-color: #EFF5FB;
        position: absolute;
        display: none;
    }
    #MenuPrt.active {
        display: block;
        left : 35%;
    }

    /* 리스트 스타일 */
    .list-style{
        font-size: 1.5rem;
        font-weight: bold;
        color: #6E6E6E;
    }

    /* 메뉴 영역 */
    .createdMenu {
        font-size: 1.5rem;
        z-index: 1;
        border: 2px solid black;
        margin: auto;
        text-align: center;
        overflow: hidden;
        background-color: white;
    }
    /* 메뉴 이미지 영역 */
    .createdImg {
        /* background-image: url('./image.jpg');
        background-size: 100% 100%; */
        font-size: 1.5rem;
        text-align: center;
        background-color: white;
    }
    /* 메뉴 이름 영역 */
    .createdName {
        font-size: 1.5rem;
        text-align: center;
        background-color: white;
    }
    /* 메뉴 설명 영역 */
    .createdExpl {
        font-size: 1.5rem;
        text-align: center;
        background-color: white;
    }
    /* 런치 디너 구분 영역 */
    .createdL_D {
        font-size: 1.5rem;
        text-align: center;
        background-color: white;
    }
    /* 메뉴 가격 영역 */
    .createdPrice {
        font-size: 1.5rem;
        text-align: center;
        background-color: white;
    }
    /* 메뉴 선택 영역 */
    .createdSelect {
        font-size: 1.5rem;
        text-align: center;
        background-color: white;
    }

    /* 엘리먼트 움직이기 용 */
    .dragElement {
        position: absolute;
        cursor: pointer;
    }
    /* div 크기 조절기 */
    .resizer {
        width: 10px;
        height: 10px;
        right: 0;
        bottom: 0;
        z-index: 90;
        position: absolute;
        cursor: se-resize;
        background-color:salmon;
    }

    /* 마우스 메뉴 */
    .ul_style {
        margin: 0px;
        padding: 0px;
        font-size: 1.2rem;
    }
    .hr_style {
        margin: 3%;
        border: thin solid #D8D8D8;
    }
    .context-menus {
        width: 20%;
        border: 1px solid black;
        z-index:100;
        position: absolute;
        display: none;
        text-align: center;
    }
    .context-menus.active {
        display: block;
        background-color: #EFF5FB;
    }
    .context-menus.active>.ul_style>.li_style {
        list-style: none;
        padding: 10px;
        color: #424242;
        font-weight: bold;
    }
    .context-menus.active>.ul_style>.li_style:hover {
        background-color: lightgreen;
    }

    /* 영역 서식 메뉴창 */
    #designSet {
        width: 40%;
        height: 0;
        padding-bottom: 50%;
        z-index:100;
        border: 3px dashed #585858;
        background-color: whitesmoke;
        position: absolute;
        display: none;
    }
    #designSet.active {
        top : 15%;
        left: 30%;
        display: block;
    }
    .designSet_title {
        font-size: 2rem;
        margin-left: 3%;
        color: gray;
    }
    .designSet_tr {
        width: 90%;
        font-size: 1.3rem;
        margin: auto;
        margin-bottom: 6%;
    }
    .designSet_name {color: #6E6E6E;}
    .designSet_ipt{
        width: 50%;
        font-size: 1.3rem;
        margin-left: 5%;
        text-align: center;
        color: #6E6E6E;
        border-bottom: 1.5px solid #6E6E6E;
    }
    .designSet_color {
        width: 10%;
        height: 0;
        border: 1px solid black;
        margin-left: 5%;
        margin-right: 3%;
        position: relative;
        float: left;
        overflow: hidden;
        padding-bottom: 9%;
    }
    .designSet_color_inner{
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        position: absolute;
    }
    .designSet_color_btn {
        font-size: 1.5rem;
        margin-left: 5%;
        float: left;
        font-weight: bold;
        color: cadetblue;
    }

    #palette {
        width:256px;
        height:256px;
    }
    #bar {
        width:20px;
        height:256px;
    }
    #click_color {
        height:50;
        font-size: 1.5rem;
        border-top: 2px solid #A4A4A4;
        border-bottom: 2px solid #A4A4A4;
        color: gray;
        text-align: center;
        font-weight: bold;
    }
    .color_btn {
        width: 50%;
        font-size: 1.5rem;
        text-align: center;
        font-weight: bold;
        float: left;
        color: #6E6E6E;
    }
</style>