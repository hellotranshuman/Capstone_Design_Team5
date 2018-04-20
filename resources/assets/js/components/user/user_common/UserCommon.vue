<!--
※참고
식당 페이지 틀
-->
<template>
    <div>
        <!-- 최상단 검색 등 작업 부분 -->
        <UserHeader></UserHeader>
        <!-- 정보, 메뉴, 리뷰 페이지를 선택하는 부분 -->
        <UserSelectBar></UserSelectBar>
    </div>
</template>

<script>
    // 유저 화면 상단 컴포넌트 import
    import UserHeader from '../user_common/customerMainTop.vue';
    // 유저 화면 상단 컴포넌트 import
    import UserSelectBar from '../user_common/UserSelectBar.vue';

    export default{
        // 컴포넌트 선언
        components: {
            'UserHeader' : UserHeader,
            'UserSelectBar' : UserSelectBar
        }
    }
</script>

<style>

</style>