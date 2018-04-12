<template>
    <div class="top">
        <br>
        <div>
            <!-- title -->
            <h2 class="title"><B><B class="fontColor_Red">SMART</B> sasisuseso</B></h2>
            <!-- 검색바 -->
            <div class="search">
                <input type="text" class="search_text"/>
                <!-- <img src="./searcher.png" class="search_img" /> -->
            </div>
            <!-- 유저 -->
            <table class="user_table">
                <tr>
                    <td  rowspan="2">
                        <!-- <img src="./user.png" class="user_img"/> -->
                        </td>
                    <td>&nbsp;&nbsp; {{name}}님 </td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp; <a href="#"> 마이페이지 </a></td>
                    <td>&nbsp; <a href="#"> 로그아웃 </a></td>
                </tr>
            </table>
        </div>
        <br><br>
    <p class="title_line"></p>
    </div>
</template>
<script>
export default {
    data() {
        return {
            name : '윤진주',
        }
    }
}
</script>
<style>
    .fontColor_Red {
        color: red;
    }
    
    /* title */

    .title {
        float: left;
        margin-top: 1%;
        margin-left: 1%;
    }
    .title_line {
        background-color:#BDBDBD;
        width: 100%;
        height: 3px;
        margin-top: 1%;
    }

    /* 검색 */
    .search {
        background-color: #353535;
        width: 500px;
        height: 45px;
        margin-left: 5%;
        float: left;
    } 
    .search_text {
        width: 400px;
        height: 35px;
        margin: 1% 1% 0% 7%;
    }
    .search_img {
        width: 30px;
        height: 30px;
    }

    /* 유저 */
    .user_table {
        float: left;
        margin-left: 6%;
    }
    .user_img {
        width: 40px;
        height: 40px;

    }
</style>

