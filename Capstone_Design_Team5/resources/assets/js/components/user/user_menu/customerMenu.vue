<template>
    <div class="Menu_container">
        <br>
        <h3> <B> 「 {{ storename }} 」　메뉴판</B></h3>
        <hr>
        <b-form-group label="Stacked  checkboxes">
            <b-form-checkbox-group stacked v-model="selected" name="flavour2" :options="options">
            </b-form-checkbox-group>
        </b-form-group>
    </div>   
</template>
<script>
    export default {
        data() {
            return {
                storename : '이치란 라면'
            }
        }
    }
</script>
<style>
    .Menu_container {
        border:8px solid #353535;
        width: 80%;
        margin: auto;
        text-align: center;
        padding: 2%;
    }
</style>
