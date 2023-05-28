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
//Toaster notification
import { useToast } from "vue-toastification";
import "vue-toastification/dist/index.css" 

    export default{
        setup(){
            // function logouts(){
            //     alert('S');   
            // }
        },
        methods:{
            async logout(){
                // Get toast interface
                const toast = useToast();
                const $v =this.$router;
                axios.post('api/logout').then(res =>{
                    console.log(res.data)
                    toast.error(res.data.data.message)
                    localStorage.removeItem('token');
                    $v.push('/login');
                });
            }
        }
    }
</script>