
<!-- 회원가입 -->
<template>
    <v-app>
    <v-container text-xs-center>
        <v-btn round color="success" style="width: 30vw; height: 50vh"><span>개인 회원</span></v-btn>
        <v-btn round color="error" style="width: 30vw; height: 50vh">사업자 회원</v-btn>
    </v-container>
    </v-app>
</template>

<script>
    export default {
        data () {
            return {
        e2: 0
        }
    },

        computed: {
            color () {
                switch (this.e2) {
                    case 0: return 'teal'
                    case 1: return 'brown'
                }
            }
        }
    }
</script>