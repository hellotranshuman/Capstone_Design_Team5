<!-- 식당 사장이 메뉴판이 출력될 레이아웃을 선택하거나 직접 제작 할 수 있도록 한다. -->

<template>
    <div class="container" style="width:100%;">
        <v-container grid-list-md>
            <!-- 스낵바 : 경고 창 출력 -->
            <v-snackbar :timeout="timeout" :top="'top'" v-model="snackbar">
                {{ snackbar_text }}

                <v-btn 
                    color="pink" 
                    @click.native="snackbar = false"
                    flat icon 
                >
                    <v-icon large> close </v-icon>
                </v-btn>
            </v-snackbar>

<!--*************************************************** 기본 레이아웃 ***************************************************-->
            <!-- 서비스에서 제공하는 메뉴판 기본 템플릿 중 하나 선택하기. -->
            <v-layout elevation-3>
                <v-flex xs10 style="font-size: 2rem;">
                    <v-card>
                        <v-card-text>
                            <b> メニューのレイアウトを選択 - 選んだレイアウト : </b>
                            <b v-if="selectWhat==null">   
                                {{selected_template}} 
                            </b>
                            <b v-else-if="selectWhat=='bas'">
                                基本のレイアウト {{selectTemPrt}}
                            </b>
                            <b v-else-if="selectWhat=='cos'">
                                {{selectTemPrt}}
                            </b>
                        </v-card-text>
                    </v-card>
                </v-flex>
                <v-flex xs2 style="font-size: 2rem;">
                    <v-btn 
                        @click="save_data"  
                        block  
                        style=" height:100%;
                                color: #46362c;
                                font-size:1.5rem;                                 
                                font-weight:bold; 
                                background-color: #d2b07d;
                                margin:0;"
                    >
                        セーブ
                    </v-btn>
                </v-flex>
            </v-layout>

            <!-- 기본 템플릿 예시보기. -->
            <v-dialog v-model="ExTemplete" max-width="50%">
                <v-card 
                    align-content-center
                    @click.native="ExTemplete = false"
                >
                    <v-card-text style="background-color: #efe2bd; font-size:1.5rem;">
                        <b> 基本のレイアウト {{selectTemplete}} </b>
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
            <v-dialog  v-model="basicTem" max-width="30%" persistent>
                <v-card style="padding:1%; background-color:#efe2bd;">
                    <v-card-text>
                        <div style="width:100%; font-size:1.5rem; text-align:center; font-weight:bold;"> 
                            基本のレイアウト{{selectTemplete}}に設定しますか? 
                        </div>

                        <v-layout mt-2>
                            <v-flex xs6 mr-1>
                                <v-btn                            
                                    class="amber lighten-5" 
                                    @click="basicTem     = false; 
                                            selectWhat   = 'bas'; 
                                            selectTemPrt = selectTemplete"
                                    block
                                >
                                    はい 
                                </v-btn>
                            </v-flex>

                            <v-flex xs6>
                                <v-btn       
                                    class="amber lighten-5"  
                                    @click="basicTem=false"
                                    block
                                > 
                                     いいえ 
                                </v-btn>
                            </v-flex>
                        </v-layout>                       
                    </v-card-text>
                </v-card>
            </v-dialog>

            <!-- 기본 메뉴판 템플릿 선택하기. -->
            <v-layout text-xs-center mb-5>
                <!-- 서비스에서 제공하는 메뉴판 기본 템플릿1 -->
                <v-flex xs3 style="font-size: 1.4rem;" elevation-3>
                    <v-card>
                        <v-card-text> 
                            <b>基本のレイアウト1</b> 
                        </v-card-text>

                        <div class="tem_img"> 
                            <img class="inner_img" :src="exImg1"> 
                        </div>

                        <!-- 모달 출력 버튼 -->
                        <v-card-actions>                            
                            <v-btn 
                                style="background-color:#E7D7B7; font-weight:bold;" block 
                                @click="ExTemplete=true; selectTemplete=1"
                            > 
                                例を見ること 
                            </v-btn>

                            <v-btn 
                                style="background-color:#E2C189; font-weight:bold;"  block 
                                @click="basicTem=true; selectTemplete=1"
                            > 
                                選択 
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-flex>

                <!-- 서비스에서 제공하는 메뉴판 기본 템플릿2 -->
                <v-flex xs3 style="font-size: 1.4rem;" elevation-3>
                    <v-card>
                        <v-card-text> 
                            <b>基本のレイアウト2</b> 
                        </v-card-text>

                        <div class="tem_img"> 
                            <img class="inner_img" :src="exImg2"> 
                        </div>

                        <!-- 모달 출력 버튼 -->
                        <v-card-actions>
                            <v-btn 
                                style="background-color:#E7D7B7; font-weight:bold;" block 
                                @click="ExTemplete=true; selectTemplete=2"
                            > 
                                例を見ること
                            </v-btn>

                            <v-btn 
                                style="background-color:#E2C189; font-weight:bold;" block 
                                @click="basicTem=true; selectTemplete=2"
                            > 
                                選択  
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-flex>

                <!-- 서비스에서 제공하는 메뉴판 기본 템플릿3 -->
                <v-flex xs3 style="font-size: 1.4rem;" elevation-3>
                    <v-card>
                        <v-card-text> 
                            <b>基本のレイアウト3</b> 
                        </v-card-text>

                        <div class="tem_img"> 
                            <img class="inner_img" :src="exImg3"> 
                        </div>

                        <!-- 모달 출력 버튼 -->                        
                        <v-card-actions>
                            <v-btn 
                                style="background-color:#E7D7B7; font-weight:bold;" block 
                                @click="ExTemplete=true; selectTemplete=3"
                            > 
                                例を見ること 
                            </v-btn>

                            <v-btn 
                                style="background-color:#E2C189; font-weight:bold;" block 
                                @click="basicTem=true; selectTemplete=3"
                            > 
                                選択 
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-flex>

                <!-- 서비스에서 제공하는 메뉴판 기본 템플릿4 -->
                <v-flex xs3 style="font-size: 1.4rem;" elevation-3>
                    <v-card>
                        <v-card-text> 
                            <b>基本のレイアウト4</b> 
                        </v-card-text>

                        <div class="tem_img"> 
                            <img class="inner_img" :src="exImg4"> 
                        </div>

                        <!-- 모달 출력 버튼 -->
                        <v-card-actions>
                            <v-btn 
                                style="background-color:#E7D7B7; font-weight:bold;" block 
                                @click="ExTemplete=true; selectTemplete=4"
                            > 
                                例を見ること 
                            </v-btn>

                            <v-btn 
                                style="background-color:#E2C189; font-weight:bold;" block 
                                @click="basicTem=true; selectTemplete=4"
                            > 
                                選択 
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-flex>
            </v-layout>

<!--************************************************ 커스터마이징 설정 ***************************************************-->
            <!-- 메뉴판 템블릿 커스터마이징 -->
            <v-layout elevation-5>
                <v-flex xs10 style="font-size: 2rem;"> 
                    <v-card>                                                    
                        <v-card-text> 
                            <b> カスタマイズしたレイアウト </b> 
                        </v-card-text>                           
                    </v-card> 
                </v-flex>
                <v-flex xs2>   
                    <v-btn  
                        @click="workSpace_set" 
                        @click.stop="createMode=true" 
                        style=" height: 100%;
                                color: #46362c;
                                font-size: 1.5rem;                                  
                                font-weight: bold;
                                background-color: #d2b07d;
                                margin:0;"
                        block
                    >
                        レイアウトの制作
                    </v-btn>                 
                </v-flex>
            </v-layout>
            
            <!-- 사용자가 만든 커스텀마이징 템플릿 리스트 div 출력 -->
            <v-layout 
                elevation-3 
                v-if="loadTemplateList !== null"
            >
                <div style="width:100%;">
                    <v-flex 
                        v-for="n in range(0, loadListNum-1)" :key="n" 
                        style= "width:31%; 
                                margin:1%; 
                                float:left; 
                                font-size:1.2rem; 
                                background-color:#F2F2F2"
                        elevation-10
                    >
                        <v-card>
                            <v-card-text 
                                style= "max-height:60px; 
                                        font-size:1.5rem; 
                                        font-weight:bold;"
                            >
                                {{loadTemplateList[n].layout_name}}
                            </v-card-text>

                            <div class="tem_img">
                                <img class="inner_img" :src="loadTemplateList[n].thumbnail">
                            </div>
                            <v-card-actions>
                                <v-btn 
                                    style="background-color: #efe2bd; font-weight:bold;" block 
                                    @click="ExCustom=true; selectCustomTem=n;"
                                >
                                    例を見ること
                                </v-btn>

                                <v-btn 
                                    style="background-color: #f6e2a1; font-weight:bold;" block 
                                    @click="customTem=true; selectCustomTem=n;"
                                >
                                    選択
                                </v-btn>

                                <v-btn 
                                    style="background-color: #d2b07d; font-weight:bold;" block 
                                    @click="customDeleteDialog=true; selectCustomTem=n;"
                                >
                                    削除
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-flex>
                </div>
            </v-layout> 

            <!-- 커스텀마이징 템플릿 예시보기 -->
            <v-dialog 
                v-if="loadTemplateList !== null"
                v-model="ExCustom" 
                max-width="50%" 
            >
                <v-card 
                    align-content-center 
                    @click.native="ExCustom=false"
                >
                    <v-card-text style="background-color: #efe2bd; font-size:1.5rem;">
                        <b> {{loadTemplateList[selectCustomTem].layout_name}} </b>
                    </v-card-text>

                    <div class="tem_img">
                        <img class="inner_img" :src="loadTemplateList[selectCustomTem].thumbnail">
                    </div>
                </v-card>
            </v-dialog>

            <!-- 커스텀마이징 템플릿 선택 확인하기 : 모달 -->
            <v-dialog 
                v-if="loadTemplateList !== null"
                v-model="customTem" 
                max-width="30%" 
                persistent 
            >
                <v-card style="padding:1%; background-color:#efe2bd;">
                    <v-card-text>
                        <div style="width:100%; font-size:1.5rem; text-align:center; font-weight:bold;"> 
                            {{loadTemplateList[selectCustomTem].layout_name}}に設定しますが。 
                        </div>

                        <v-layout mt-2>
                            <v-flex xs6 mr-1>
                                <v-btn 
                                    @click="customTem = false; 
                                            selectWhat = 'cos';
                                            selectTemPrt = loadTemplateList[selectCustomTem].layout_name"
                                    class="amber lighten-5"
                                    block
                                > 
                                    はい 
                                </v-btn>
                            </v-flex>

                            <v-flex xs6>
                                <v-btn 
                                    @click="customTem=false"
                                    class="amber lighten-5"
                                    block
                                > 
                                    いいえ 
                                </v-btn>
                            </v-flex>
                        </v-layout>     
                    </v-card-text>
                </v-card>
            </v-dialog>

            <!-- 템플릿 삭제하기 : 모달 -->
            <v-dialog 
                v-if="loadTemplateList !== null"
                v-model="customDeleteDialog" 
                max-width="30%" 
                persistent 
            >
                <v-card style="padding:1%; background-color:#efe2bd;">
                    <v-card-text>
                        <div style="width:100%; font-size:1.5rem; text-align:center; font-weight:bold;"> 
                            {{loadTemplateList[selectCustomTem].layout_name}}を削除しましょうか?
                        </div>

                        <v-layout mt-2>
                            <v-flex xs6 mr-1> 
                                <v-btn 
                                    @click="customDelete"
                                    class="amber lighten-5"
                                    block
                                >
                                    はい
                                </v-btn>
                            </v-flex>

                            <v-flex xs6>                             
                                <v-btn 
                                    @click="customDeleteDialog = false"
                                    class="amber lighten-5"
                                    block
                                >
                                    いいえ 
                                </v-btn>
                            </v-flex>
                        </v-layout>     
                    </v-card-text>
                </v-card>
            </v-dialog>


<!--**************************************************** 제작 툴********************************************************-->
            <v-layout row justify-center>
                <v-dialog 
                    v-model="createMode" 
                    fullscreen 
                    transition="dialog-bottom-transition"
                >
                    <v-card class="ban_drag">
                        <!-- 상단 툴바 -->                         
                        <v-layout style="background-color: #efe2bd;"> 
                            <v-flex xs2 style="background-color: #efe2bd;"></v-flex>
                            <v-spacer></v-spacer>

                            <v-flex xs4 
                                id="topToolBar" 
                                style= "padding:0.5%; 
                                        background-color: #efe2bd;"
                            >                                                                   
                                <b style= "font-size:3rem; 
                                           margin-left:10px; 
                                           float:left;
                                           color: #46362c;"
                                > 
                                    メニュー制作 
                                </b>                             
                            </v-flex> 

                            <!-- 불러오기 저장하기 나가기 버튼 -->
                            <v-flex xs3 style="background-color: #efe2bd;"> 
                                <v-card-actions style="width:100%; float:right;">
                                    <v-btn 
                                        @click.stop="loadMenuDialog=true" 
                                        class="tool_topToolBar_btn amber lighten-5"
                                        block round top
                                    >
                                        ロード 
                                    </v-btn>

                                    <v-btn 
                                        @click.stop="saveMenuDialog=true"
                                        class="tool_topToolBar_btn amber lighten-5"      
                                        block round top
                                    > 
                                        セーブ
                                    </v-btn>

                                    <v-btn 
                                        @click.stop="createCancelDialog=true"
                                        class="tool_topToolBar_btn amber lighten-5"  
                                        block round top
                                    > 
                                        キャンセル 
                                    </v-btn>
                                </v-card-actions>   
                            </v-flex>       
                                
                            <v-spacer></v-spacer>
                            <v-flex xs2 style="background-color: #efe2bd;"></v-flex>         
                        </v-layout>

                        <!-- 불러오기 모달 -->
                        <v-dialog 
                            v-model="loadMenuDialog" 
                            width="40%" 
                            scrollable="" 
                            persistent
                        >
                            <v-card style="padding:2%; background-color:#f6e2a1;">
                                <v-card-title style="border-bottom:2px solid #46362c; padding:1%;">
                                    <div 
                                        style= "font-size:2rem; 
                                                font-weight:bold; 
                                                color:#46362c;"
                                    >
                                        メニューロード 
                                    </div>

                                    <v-spacer></v-spacer>

                                    <v-btn 
                                        @click="loadMenuDialog = false"                                         
                                        style="float:right" icon
                                    >
                                        <v-icon x-large> close </v-icon>
                                    </v-btn>
                                </v-card-title>

                                <ul 
                                    class="MenuLayoutList_ul"
                                    style="height:300px;"
                                >
                                    <li 
                                        v-if="loadTemplateList !== null"     :value="i"
                                        v-for="i in range(0, loadListNum-1)" :key="i" 
                                        @click="loadCreateMenu" 
                                        @click.capture="temName = loadTemplateList[i].layout_name"
                                        class="MenuLayoutList_li"
                                    >
                                        {{ loadTemplateList[i].layout_name }}
                                    </li>
                                </ul>
                            </v-card>
                        </v-dialog>

                        <!-- 저장하기 모달 -->
                        <v-dialog 
                            v-model="saveMenuDialog" 
                            width="40%" 
                            scrollable="" 
                            persistent
                        >
                            <v-card style="padding:2%; background-color:#f6e2a1;">
                                <v-card-title style="padding:1%;">
                                    <div 
                                        style= "color       : #46362c;
                                                font-size   : 2rem; 
                                                font-weight : bold; "
                                    >
                                        作ったメニューをセーブします。
                                    </div>
                                </v-card-title>

                                <div 
                                    style= "width         : 100%; 
                                            height        : 60px; 
                                            padding       : 5px;  
                                            border-top    : 2px solid #46362c; 
                                            border-bottom : 2px solid #46362c; "
                                >
                                    <v-text-field 
                                        label="テンプレートの名前(最大15字)" 
                                        v-model="temName"  
                                        autofocus 
                                        full-width
                                        style="height:50px; background-color:white;"
                                    >
                                    </v-text-field>                                    
                                </div>

                                <ul 
                                    class="MenuLayoutList_ul"
                                    style="height        : 200px;                                              
                                           border-bottom : 2px solid #46362c;"
                                >
                                    <li 
                                        v-for="i in range(0, loadListNum-1)" :key="i" 
                                        v-if="loadTemplateList !== null"     :value="i"
                                        @click="editCreateMenu"             
                                        class="MenuLayoutList_li"
                                    >
                                        {{ loadTemplateList[i].layout_name }}
                                    </li>
                                </ul>

                                <v-card-actions>
                                    <v-btn 
                                        @click="makeThumbnail"
                                        class="tool_topToolBar_btn amber lighten-5"      
                                        block   
                                    > 
                                        セーブ  
                                    </v-btn>
                                    <v-btn 
                                        @click="saveMenuDialog=false"
                                        class="tool_topToolBar_btn amber lighten-5"      
                                        block
                                    > 
                                        キャンセル 
                                    </v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>

                        <!-- 나가기 모달 -->
                        <v-dialog 
                            v-model="createCancelDialog"
                            width="40%"  
                            persistent
                        >
                            <v-card style="padding:2%; background-color:#f6e2a1;">
                                <v-card-title>
                                    <div 
                                        style= "width       : 100%;
                                                font-size   : 2rem; 
                                                font-weight : bold; 
                                                text-align  : center; 
                                                color       : #46362c"
                                    >
                                        メニュー作りを終了しますか。
                                    </div>
                                </v-card-title>

                                <v-card-actions>
                                    <v-btn 
                                        @click="createCancel"
                                        class="tool_topToolBar_btn amber lighten-5"      
                                        block
                                    >
                                        はい
                                    </v-btn>
                                    <v-btn 
                                        @click="createCancelDialog=false"
                                        class="tool_topToolBar_btn amber lighten-5"      
                                        block
                                    >
                                        いいえ
                                    </v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>

                        <!-- 하단 작업 공간 & 툴바 -->
                        <v-layout 
                            style= "width            : 100%; 
                                    background-color : #efe2bd;
                                    border-bottom    : 1px solid #585858;" 
                        >
                            <v-spacer></v-spacer>

                            <!-- 왼쪽 사이드 툴바 : 메뉴 생성 -->
                            <v-flex xs2
                                id='leftToolBar'  
                                style="background-color: white; padding: 1%;"
                            >
                                <v-flex xs12 
                                    id="selectColumn" 
                                    class="toolBarList_title" 
                                > 
                                    メニューの要素を選択
                                </v-flex>

                                <!-- 메뉴 이미지 -->
                                <v-flex xs12>
                                    <v-btn
                                        @click="dragArea" 
                                        @click.capture="item = 'createdImg'"
                                        class="toolBarList_btn amber lighten-4"      
                                        block round
                                    >
                                        <v-icon color="brown darken-4"> image </v-icon>
                                        &nbsp; メニューのイメージ
                                    </v-btn>
                                </v-flex>

                                <!-- 메뉴 명 -->
                                <v-flex xs12>
                                    <v-btn
                                        @click="dragArea" 
                                        @click.capture="item = 'createdName'"
                                        class="toolBarList_btn amber lighten-4"      
                                        block round
                                    >
                                        <v-icon color="brown darken-4"> title </v-icon>
                                        &nbsp; メニューの名前
                                    </v-btn>
                                </v-flex>
                                
                                <!-- 메뉴 설명 -->
                                <v-flex xs12>
                                    <v-btn
                                        @click="dragArea" 
                                        @click.capture="item = 'createdExpl'"
                                        class="toolBarList_btn amber lighten-4"      
                                        block round
                                    >
                                        <v-icon color="brown darken-4"> assignment </v-icon>
                                        &nbsp; メニューの説明
                                    </v-btn>
                                </v-flex>

                                <!-- 런치 / 디너 구분 생성 -->
                                <v-flex xs12>
                                    <v-btn
                                        @click="dragArea" 
                                        @click.capture="item = 'createdL_D'"
                                        class="toolBarList_btn amber lighten-4"      
                                        block round
                                    >
                                        <v-icon color="brown darken-4"> watch_later </v-icon>
                                        &nbsp; ランチ / ディナー 
                                    </v-btn>
                                </v-flex>

                                <!-- 메뉴 가격 -->
                                <v-flex xs12>
                                    <v-btn
                                        @click="dragArea" 
                                        @click.capture="item = 'createdPrice'"
                                        class="toolBarList_btn amber lighten-4"      
                                        block round
                                    >
                                        <v-icon color="brown darken-4"> attach_money </v-icon>
                                        &nbsp; メニューの価格
                                    </v-btn>
                                </v-flex>

                                <!-- 메뉴 가격 -->
                                <v-flex xs12>
                                    <v-btn
                                        @click="dragArea" 
                                        @click.capture="item = 'createdSelect'"
                                        class="toolBarList_btn amber lighten-4"      
                                        block round
                                    >
                                        <v-icon color="brown darken-4"> check_circle </v-icon>
                                        &nbsp; メニュー選択のボタン
                                    </v-btn>
                                </v-flex>
                            </v-flex>

                            <v-spacer></v-spacer>

                            <!-- 작업 공간 -->
                            <v-flex xs7>
                                <div id="workSpace">
                                    <div id="menu" class="createdMenu">
                                        <div id="ElementArea"></div>
                                    </div>
                                </div>
                            </v-flex>

                            <v-spacer></v-spacer>

                            <!-- 오른쪽 사이드 툴바 : 기타 설정 -->
                            <v-flex xs2 style="background-color: white; padding: 1%;">
                                <v-flex xs12 class="toolBarList_title"> 
                                    メニューのサイズを設定
                                </v-flex>

                                <v-flex xs12 mt-3 mb-3> 
                                    <v-flex xs12 class="rightToolBar_miniTitle">
                                        メニューの縦の割合を設定
                                    </v-flex>

                                    <input 
                                        type="text" 
                                        id="menuRatio" 
                                        class="designSet_ipt" 
                                        @keyup="setMenuRatioByEnterKey"
                                    > 
                                    <b> % </b>

                                    <button
                                        @click="setMenuRatio"
                                        style= "width: 30%; 
                                                margin-left:2%; 
                                                font-size:1.4rem; 
                                                font-weight:bold; 
                                                color: #6d4d35;"
                                    >
                                        適用
                                    </button>
                                </v-flex>
                               
                                <v-flex xs12 class="toolBarList_title" mt-5> 
                                    メニューの出力を設定
                                </v-flex>

                                <v-flex xs12 mt-3> 
                                    <v-flex xs12 class="rightToolBar_miniTitle">
                                        一行に出力するメニューの数
                                    </v-flex> 
                                    <select id="MenuNum" class="designSet_ipt" mt-2>
                                        <option value=1> 1 </option>
                                        <option value=2> 2 </option>
                                        <option value=3 selected> 3 </option>
                                        <option value=4> 4 </option>
                                    </select> 
                                    <b> つ </b>

                                    <v-flex xs12 class="rightToolBar_miniTitle" mt-3>
                                        メニューの間隔
                                    </v-flex>  
                                    <select id="MenuMargin" class="designSet_ipt" mt-2>
                                        <option value=1 selected> 1 </option>
                                        <option value=2> 2 </option>
                                        <option value=3> 3 </option>
                                    </select> 
                                    <b> % </b>
                                </v-flex>
                            </v-flex>
                            <v-spacer></v-spacer>
                        </v-layout>

                        <!-- 마우스 오른쪽 버튼 클릭스 나타나는 메뉴 창 -->
                        <div id="click_menu" class="context-menus">
                            <ul class="ul_style">
                                <li id="goFont" @click="zIndexSet" class="li_style">
                                    <b> 前に </b>
                                </li>
                                <hr class="hr_style">

                                <li id="goBack" @click="zIndexSet" class="li_style">
                                    <b> 後ろに </b>
                                </li>
                                <hr class="hr_style">

                                <li @click.stop="CallDesignSet" class="li_style">
                                    <b> 領域の書式 </b>
                                </li>
                                <hr class="hr_style">

                                <li @click="DeleteElement" class="li_style">
                                    <b> 削除 </b>
                                </li>
                            </ul>
                        </div>

                        <!-- 영역 서식 메뉴창 -->
                        <v-dialog 
                            v-model="designSetDialog" 
                            width="40%"
                            scrollable="" 
                            persistent
                        >
                            <v-card style="padding:2%; background-color:#f6e2a1;">
                                <!-- 타이틀, 저장, 취소 -->
                                <v-layout style="padding:2%; border-bottom: 2px solid #46362c;" mb-3>
                                    <v-flex xs10 class="designSet_title"> 
                                        領域の書式 
                                    </v-flex>
                                    <v-spacer></v-spacer>

                                    <v-flex xs1>
                                        <v-btn @click="SetColorAndShape" icon block>
                                            <v-icon x-large> done </v-icon>
                                        </v-btn>
                                    </v-flex>     

                                    <v-flex xs1>
                                        <v-btn @click="designSetDialog = false" icon block>
                                            <v-icon x-large> clear </v-icon>
                                        </v-btn>
                                    </v-flex>                                    
                                </v-layout>

                                <!-- 설정 항목 -->
                                <v-flex xs12 class="designSet_info" style="overflow: scroll;">
                                    <v-layout>
                                        <v-flex xs6 class="designSet_area">
                                            <b class="designSet_name"> 
                                                線の太さを設定 
                                            </b> 
                                            <br>      
                                            <input type="text" id="line_width" class="designSet_ipt" value="2"> px
                                        </v-flex>

                                         <v-flex xs6 class="designSet_area">
                                            <b class="designSet_name">  
                                                線のスタイルを設定 
                                            </b> 
                                            <br>
                                            <select id="line_style" class="designSet_ipt">
                                                <option value="solid"> 直線 </option>
                                                <option value="none"> 無し </option>
                                                <option value="dotted"> 短い点線 </option>
                                                <option value="dashed"> 長い点線  </option>
                                                <option value="double"> ダブル </option>
                                            </select> (選択)
                                        </v-flex>
                                    </v-layout>

                                    <v-layout>
                                        <v-flex xs6 class="designSet_area">
                                            <b class="designSet_name"> 線の色を選択 </b> <br>
                                            
                                            <v-layout>
                                                <v-flex xs4 class="designSet_color_outer">
                                                    <div 
                                                        id="line_color" 
                                                        class="designSet_color_inner"
                                                        style="background-color:black;"
                                                    >
                                                    </div>
                                                </v-flex>

                                                <v-flex xs8>
                                                    <button 
                                                        @click="CallColorPicker" 
                                                        class="designSet_color_btn"  
                                                        value="line_color" 
                                                    >
                                                        選択
                                                    </button>

                                                    <button 
                                                        @click="ColorNull" 
                                                        class="designSet_color_btn" 
                                                        value="line_color" 
                                                    >
                                                        無し
                                                    </button>
                                                </v-flex>                                                
                                            </v-layout>
                                        </v-flex>

                                        <v-flex xs6 class="designSet_area">
                                            <b class="designSet_name"> 
                                                字の色を選択 
                                            </b> 
                                            <br>                                            
                                            <v-layout>
                                                <v-flex xs4 class="designSet_color_outer">
                                                    <div 
                                                        id="text_color" 
                                                        class="designSet_color_inner"
                                                        style="background-color:black;"
                                                    >
                                                    </div>
                                                </v-flex>

                                                <v-flex xs8>
                                                    <button
                                                        @click="CallColorPicker" 
                                                        class="designSet_color_btn"  
                                                        value="text_color" 
                                                    >
                                                        選択
                                                    </button>
                                                </v-flex>                                                
                                            </v-layout>
                                        </v-flex>
                                    </v-layout>

                                    <v-layout>
                                        <v-flex xs6 class="designSet_area">
                                            <b class="designSet_name"> 
                                                領域の色を選択 
                                            </b> 
                                            <br>                                            
                                            <v-layout>
                                                <v-flex xs4 class="designSet_color_outer">
                                                    <div 
                                                        id="area_color" 
                                                        class="designSet_color_inner"
                                                        style="background-color:black;"
                                                    >
                                                    </div>
                                                </v-flex>

                                                <v-flex xs8>
                                                    <button 
                                                        @click="CallColorPicker" 
                                                        class="designSet_color_btn"  
                                                        value="area_color" 
                                                    >
                                                        選択
                                                    </button>

                                                    <button  
                                                        @click="ColorNull" 
                                                        class="designSet_color_btn" 
                                                        value="area_color" 
                                                    >
                                                        無し
                                                    </button>
                                                </v-flex>                                                
                                            </v-layout>
                                        </v-flex>

                                        <v-flex xs6 class="designSet_area">                                             
                                            <b class="designSet_name"> 領域の様子を選択 </b> <br>
                                            
                                            <select id="area_style" class="designSet_ipt">
                                                <option value="quadrangle">  四角形 </option>
                                                <option value="quadrangle_R"> 丸い四角形 </option>
                                                <option value="circle"> 丸 </option>
                                            </select> (選択)
                                        </v-flex>
                                    </v-layout> 
                                </v-flex>
                            </v-card>
                        </v-dialog>

                        <!-- 색상 선택 -->
                        <v-dialog 
                            v-model="colorDialog" 
                            width="280px" 
                            persistent 
                            style="display:inline-block;"
                        >
                            <v-card style="background-color: #efe2bd;">
                                <div>
                                    <canvas id="palette" @click="Palette_Click">                                         
                                    </canvas>
                                    <canvas id="bar" @click="Bar_Click">                                         
                                    </canvas>
                                </div>

                                <div style="width:100%;">
                                    <div id="click_color"> 選んだ色 </div>
                                </div>

                                <v-layout>    
                                    <v-flex xs6>
                                        <v-btn 
                                            class="color_btn amber lighten-5" 
                                            @click="SetColor"
                                            block 
                                        >　
                                            設定　
                                        </v-btn>
                                    </v-flex>
                                    <v-flex xs6>
                                        <v-btn 
                                            class="color_btn amber lighten-5" 
                                            @click="colorDialog = false"                                        
                                            block 
                                        >　
                                            キャンセル　
                                        </v-btn>
                                    </v-flex>
                                </v-layout>    
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

            // 선택한 레이아웃 가져오기.
            axios.get(url)
            .then( (response) => {
                layoutNum = response.data.layoutNum;
                if(layoutNum < 5)
                    this.selected_template = response.data.layoutName + layoutNum;
                else
                    this.selected_template = "カスタマイズレイアウト - " + response.data.layoutName;
            })
            .catch((ex)=>{  
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
                exImg2 : '/images/template/template2.jpeg',
                exImg3 : '/images/template/template3.jpeg',
                exImg4 : '/images/template/template4.jpeg',

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
                    this.snackbar_text = 'メニューのレイアウトを選んでください。';
                    this.snackbar      = true;
                    return null;
                }

                // 서버 요청
                axios.post(url, {
                    'slt_tem' : select_tem,
                    'shop_id' : this.$route.params.shop_id,
                })
                .then( (response) => {
                    this.snackbar_text = 'セーブ';
                    this.snackbar      = true;
                    location.reload();
                })
                .catch((ex)=>{ 
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
                        this.snackbar_text = '選んだレイアウトを削除しました。';
                        this.snackbar      = true;
                        this.loadCreateMenuList();                              // 메뉴 데이터 다시 불러오기.
                    })
                    .catch((ex)=>{ 
                    });
            },            
            
            // 엘리먼트 left 값 얻기
            getLeft : function(argObj){
                return parseInt(argObj.style.left.replace('px', ''));
            },
            // 엘리먼트 top 값 얻기 
            getTop : function(argObj) {
                return parseInt(argObj.style.top.replace('px', ''));
            },
            // 엘리먼트 너비 값 얻기
            getWidth : function(argObj) {
                return parseInt(argObj.style.width.replace('px', ''));
            },
            // 엘리먼트 너비 값 얻기
            getHeight : function(argObj) {
                return parseInt(argObj.style.height.replace('px', ''));
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
                        this.loadTemplateList = response.data.layoutData;                // 제작한 메뉴판 리스트
                        this.loadListNum      = this.loadTemplateList.length;            // 제작한 메뉴판 갯수
                    } else {
                        this.snackbar_text = 'セーブしたレイアウトがありません。';
                        this.snackbar      = true;
                    }
                })
                .catch((ex)=>{ 
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

                // 메뉴 세로 비율 값 적용
                this.setMenuRatio();                                                    

                let menu_w = this.getWidth(menu);                       // 메뉴 너비 픽셀 값
                let menu_h = this.getHeight(menu);                      // 메뉴 높이 픽셀 값
                let menu_l = 0;                                         // 메뉴 left 픽셀 값
                let menu_t = Math.floor(workSpace_h * 0.03);            // 메뉴 top 픽셀 값

                // 메뉴 영역 left, top 값 설정 - 가로가 세로 보다 긴 경우
                if(this.longWidth){  
                    menu_l = Math.floor(workSpace_w * 0.03);            // 패딩 값 3%
                }
                // 세로가 가로 보다 긴 경우 
                else{
                    menu_l = Math.floor((workSpace_w - menu_w) / 2);    // (작업 공간 높이 - 메뉴 영역 높이)/2 
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
                        case 'createdImg'   : element.innerText = 'イメージ';           break;
                        case 'createdExpl'  : element.innerText = '説明';              break;
                        case 'createdL_D'   : element.innerText = 'ランチ / ディナー';   break;
                        case 'createdName'  : element.innerText = '名前';              break;
                        case 'createdPrice' : element.innerText = '価格';              break;
                        case 'createdSelect': element.innerText = '選択のボタン';       break;
                    }
                    element.classList.add(MenuElement[i]);
                    element.classList.add('dragElement');
                    element.onmousedown = this.moveElement;
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
                        selectColumn.style.backgroundColor = 'white';
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
                    this.snackbar_text = 'メニューの要素を全部作ってください!';
                    this.snackbar      = true;
                    this.selectColumn_sIv_start();
                    return null;
                }
                // 템플릿 명 설정 유효성 검사
                else if(this.temName.replace(/ /gi, "") === ''){
                    this.snackbar_text = 'レイアウトの名前を書いてください';
                    this.snackbar = true;
                    return null;
                }
                // 입력된 글자가 18자를 넘길 경우 경고
                else if(this.temName.toString().length > 15){
                    this.snackbar_text = '書ける字は最大で15字です。';
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
                let ia         = null;  // write the bytes of the string to a typed array

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
                let menu_t = Math.floor(workSpace_h * 0.03);            // top 값을 %값이 아닌 px 값으로 받음
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
                    menu_l = Math.floor((workSpace_w - menu_w) / 2);  
                }                 
    
                array['MenuNum']    = MenuNum.value;                    // 한 줄에 출력 될 메뉴의 갯수
                array['MenuMargin'] = MenuMargin.value;                 // 메뉴 간의 간격 설정

                // 배열에 style 값 담기
                array['createdMenu'] = {
                    'ratio'          : ratio, 
                    'border'         : menu.style.border,
                    'borderRadius'   : menu.style.borderRadius,
                    'color'          : menu.style.color,
                    'backgroundColor': menu.style.backgroundColor,
                };

                // 메뉴 안의 요소들 가공하기 & 배열에 담기.
                for(let i = 0; i < menu.children.length; i++){
                    if( menu.children[i] !== ElementArea ){
                        // 메뉴 영역 안의 메뉴 요소들 스타일 값, 클래스
                        let element   = menu.children[i];
                        let eWidth    = this.getWidth(element);                         // 엘리먼트 너비 값
                        let eHeight   = this.getHeight(element);                        // 엘리먼트 높이 값
                        let eTop      = this.getTop(element);                           // 엘리먼트 top 값
                        let eLeft     = this.getLeft(element);                          // 엘리먼트 left 값
                        let className = element.getAttribute('class').split(' ')[0];    // 클래스 명 찾기

                        let get_l = eLeft - menu_l;     // padding 값을 없앰
                        let get_t = eTop - menu_t; 
                        // console.log('get_t =' + eTop +"-"+ menu_t);

                        // 배열에 style 값 담기
                        array[className] ={
                            'width'           : Math.floor( eWidth / menu_w * 100 ) + "%",
                            'height'          : Math.floor( eHeight / menu_h * 100 ) + "%",
                            'top'             : Math.floor( get_t / menu_h * 100)+ "%",   
                            'left'            : Math.floor( get_l / menu_w * 100) + "%",                              
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

                // console.log(JSON.stringify(array)); // 체크 용

                // // formData 확인하기
                // for(var pair of formData.entries()) {
                //     console.log(pair[0]+ ': '+ pair[1]);
                // }

                // 수정하기
                if(Edit){
                    axios.post('/updateCustomLayout', formData )
                    .then( (response) => {
                        if(response.data.msg){
                            this.snackbar_text = 'セーブ';
                            this.snackbar      = true;

                            // 메뉴 영역 요소들 지우기
                            this.menuAreaCleaner();
                            this.createMode = false;
                            this.loadCreateMenuList();
                        }
                    })
                    .catch((ex)=>{ 
                    });
                }
                // 저장하기.
                else {
                    axios.post('/saveCustomLayout', formData )
                    .then( (response) => {
                        if(response.data.msg){
                            this.snackbar_text = 'セーブ';
                            this.snackbar      = true;

                            // 메뉴 영역 요소들 지우기
                            this.menuAreaCleaner();
                            this.createMode = false;
                            this.loadCreateMenuList();
                        }
                    })
                    .catch((ex)=>{ 
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

            // 메뉴 영역 비율 설정하기 - 엔터 키로 호출
            setMenuRatioByEnterKey : function(){ 
                if(window.event.keyCode == 13) this.setMenuRatio();
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
                    this.snackbar_text = '値を書いてください。';
                    this.snackbar      = true;
                    return null;
                }
                // 숫자 값이 맞는지 검사
                else if ( isNaN(menuRatio) == true){
                    this.snackbar_text = '数字を書いてください。';
                    this.snackbar      = true;
                    return null;
                }
                /* 세로 비율 적용 값이 최대 너비 값 이상인 경우
                    메뉴 영역의 높이를 최대 값으로 설정하고 메뉴 영역의 너비를 비율 값으로 설정 */
                else if( Math.floor( max_w * menuRatio / 100) >= max_h ){      
                    menu.style.height = '100%';

                    let h = menu.clientHeight;                                     
                    menu.style.width = Math.floor(h * 100 / menuRatio) +'px';                     
                    menu.style.height = h +'px';
                    this.longWidth = false;
                }                
                /* 세로 비율 적용 값이 최대 너비 값 미만인 경우
                    메뉴 영역의 너비를 최대 값으로 설정하고 메뉴 영역의 높이를 비율 값으로 설정 */
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
                    ElementArea.style.width  = this.getWidth(ElementArea) - margin + 'px';                    
                    ElementArea.style.height = this.getHeight(ElementArea) - margin + 'px'; 
                    this.dragAreaStop(); 
                }
                // 오른쪽 벗어남                
                else if(obj_r > menu_r){                 
                    ElementArea.style.width = this.getWidth(ElementArea) - margin + 'px';    
                    this.dragAreaStop();                 
                } 
                // 아래쪽 벗어남                
                else if(obj_b > menu_b){                               
                    ElementArea.style.height = this.getHeight(ElementArea) - margin + 'px'; 
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
            
            // 엘리먼트 움직이기 : mouseDown
            moveElement : function() {
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
                    target_Obj.style.left = menu_l +"px";                    
                    target_Obj.style.top  = menu_t +"px";
                }
                // 왼쪽, 아래쪽 벗어남
                else if(obj_l < menu_l && obj_b > menu_b){                    
                    target_Obj.style.left = menu_l +"px";   
                    target_Obj.style.top  = menu_b - parseInt(target_Obj.offsetHeight) +"px";
                }                
                // 오른쪽, 위쪽 벗어남
                else if(obj_r > menu_r && obj_t < menu_t){               
                    target_Obj.style.left = menu_r - parseInt(target_Obj.offsetWidth) +"px";            
                    target_Obj.style.top  = menu_t +"px";
                }
                // 오른쪽, 아래쪽 벗어남
                else if(obj_r > menu_r && obj_b > menu_b){               
                    target_Obj.style.left = menu_r - parseInt(target_Obj.offsetWidth) +"px";    
                    target_Obj.style.top  = menu_b - parseInt(target_Obj.offsetHeight) +"px";
                }
                // 왼쪽 벗어남
                else if(obj_l < menu_l){             
                    target_Obj.style.left = menu_l +"px";
                }
                // 오른쪽 벗어남                
                else if(obj_r > menu_r){                                  
                    target_Obj.style.left = menu_r - parseInt(target_Obj.offsetWidth) +"px";
                }
                // 위쪽 벗어남                
                else if(obj_t < menu_t){                    
                    target_Obj.style.top  = menu_t +"px";
                } 
                // 아래쪽 벗어남                
                else if(obj_b > menu_b){                                  
                    target_Obj.style.top  = menu_b - parseInt(target_Obj.offsetHeight) +"px";
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
                    this.Resizer.style.width  = this.getWidth(this.Resizer) + 'px';
                    this.Resizer.style.height = this.getHeight(this.Resizer) + 'px';
                    this.stopResize();
                } 
                // 오른쪽 벗어남                
                else if(obj_r > menu_r){                    
                    this.Resizer.style.width  = this.getWidth(this.Resizer) + 'px';
                    this.stopResize();
                } 
                // 아래쪽 벗어남                
                else if(obj_b > menu_b){                     
                    this.Resizer.style.height = this.getHeight(this.Resizer) + 'px';
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
                        this.snackbar_text = 'もう作りました。';
                        return null;
                    }
                }
                // 메뉴 요소 생성
                switch(this.item){
                    // 메뉴 이미지 만들기
                    case 'createdImg' :
                        createdThing.innerText    = 'イメージ';
                        createdThing.classList.add('createdImg'); break;

                    // 메뉴 이름 만들기
                    case 'createdName' :
                        createdThing.innerText    = '名前';
                        createdThing.classList.add('createdName'); break;

                    // 메뉴 설명 만들기
                    case 'createdExpl' :
                        createdThing.innerText    = '説明';
                        createdThing.classList.add('createdExpl'); break;

                    // 런디 치더 구분 만들기
                    case 'createdL_D' :
                        createdThing.innerText    = 'ランチ / ディナー';
                        createdThing.classList.add('createdL_D'); break;

                    // 메뉴 가격
                    case 'createdPrice' :
                        createdThing.innerText    = '価格';
                        createdThing.classList.add('createdPrice'); break;

                    // 메뉴 선택
                    case 'createdSelect' :
                        createdThing.innerText    = '選択のボタン';
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
                createdThing.onmousedown  = this.moveElement;
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
                    this.snackbar_text = 'メニューの領域は削除することができません。';
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
        object-fit: contain;
        position: absolute;
    }

    /* 레이아웃 제작 툴 상단 툴바 버튼 스타일 */
    .tool_topToolBar_btn { 
        font-size:1.4rem;
        font-weight: bold; 
        border: 2px solid #46362c;
        color: #46362c;
    }

    /* 메뉴 제작 작업 공간 */
    #workSpace {
        width: 100%; 
        position: relative;
        overflow: auto;
        margin: auto;
        padding: 3%; 
        background-color: white;
    }

    /* 제작한 메뉴판 리스트 ul */    
    .MenuLayoutList_ul {
        overflow-y: auto;
    }
    .MenuLayoutList_ul::-webkit-scrollbar {
        width: 0px;                      
        background: transparent;        
    }

    /* 제작한 메뉴판 리스트 li */    
    .MenuLayoutList_li {
        font-size: 1.5rem;
        margin-top: 10px;
        padding: 10px;
        color: #46362c;
        font-weight: bold;
        background-color: white;
        list-style: none;
    }
    .MenuLayoutList_li:hover {
        background-color: lightblue;
    }

    /* 리스트 스타일 */
    .toolBarList_title {        
        font-size: 1.4rem;
        font-weight: bold;
        color: #46362c;
        text-align : center;
        border-bottom : 2px solid #ff9a55;
    }

    .toolBarList_btn{
        margin-top: 20px;
        font-size: 1.2rem;
        font-weight: bold;        
        color: #46362c;
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

    /* 우측 툴바 소 타이틀 */
    .rightToolBar_miniTitle{        
        font-size:1.2rem;
        font-weight: bold;
        text-align: left;
        color: #9d724b;
    }

    /* 드래그로 div 선택 */
    #ElementArea {
        width: 10px;
        height: 10px;
        z-index: 100;
        opacity: 0.7;
        background-color: #d2b07d;
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
        background-color:#ff9a55;
    }

    /* 마우스 메뉴 */
    .ul_style {
        margin: 0px;
        padding: 0px;
        font-size: 1.2rem;
    }
    .hr_style {
        margin: 3%;
        border: thin solid #d2b07d;
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
        background-color: #efe2bd;
    }
    .context-menus.active>.ul_style>.li_style {
        list-style: none;
        padding: 10px;
        color: #46362c;
        font-weight: bold;
    }
    .context-menus.active>.ul_style>.li_style:hover {
        background-color: #d2b07d;
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
        font-weight: bold;  
        color: #46362c;        
    } 
      
    .designSet_info {
        overflow-y: auto;
    }
    .designSet_info::-webkit-scrollbar {
        width: 0px;                      
        background: transparent;        
    }

    .designSet_area {
        margin: 1%;
        padding: 2%;
        background-color: white;
    }

    .designSet_tr {
        width: 90%;
        font-size: 1.3rem;
        margin: auto;
        margin-bottom: 6%;
    }
    .designSet_name {
        font-size: 1.3rem; 
        margin-bottom: 10px;
        color: #9d724b;
    }
    .designSet_ipt{
        width: 50%;
        font-size: 1.3rem;
        margin-left: 5%;
        text-align: left;
        color: #46262c;
        border-bottom: 2px solid black;
    }
    .designSet_color_outer {
        width: 100%;
        height: 0;
        border: 1px solid black; 
        padding-bottom: 30%;
        position: relative; 
        overflow: hidden;
    }
    .designSet_color_inner{
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        position: absolute;
    }
    .designSet_color_btn {
        width: 100%;
        font-size: 1.5rem;
        font-weight: bold; 
        margin: 2%; 
        margin-left: 3%;
        color: #46362c;
        border: 1.5px solid #46362c;
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
        border-top: 2px solid #46362c;
        border-bottom: 2px solid #46362c;
        color: #46362c;
        background-color: white;
        text-align: center;
        font-weight: bold;
    }
    .color_btn {
        /* width: 50%; */
        font-size: 1.3rem;
        text-align: center;
        font-weight: bold;
        /* float: left; */
        color: #46362c;
    }
</style>