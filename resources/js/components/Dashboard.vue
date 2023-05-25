<template>
        <main>
        <!-- banner section  -->
        <section class="banner-section">
            <div class="container">
                <p>Dashboard...</p>
                <button type="button" @click="logout">logout</button>
            </div>
        </section>
        </main>
</template>

<script>
import {reactive,ref} from 'vue'
//import { userRouter } from "vue-router"
    export default{
        setup(){
            // function logouts(){
            //     alert('S');   
            // }
        },
        methods:{
            async logout(){
                const $v =this.$router;
                localStorage.removeItem('token');
                $v.push('/login');
            }
        }
    }
</script>