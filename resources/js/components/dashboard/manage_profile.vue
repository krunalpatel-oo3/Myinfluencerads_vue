<template>
    <main>
        <!-- banner section  -->
        <section class="banner-section">
            <div class="container">
                <form @prevent.submit="update" method="post">
                    <div class="form-group">
                      <label for="pwd">Name:</label>
                      <input type="text" v-model="form.name" class="form-control" placeholder="Enter Name">
                    </div>
                    <div class="form-group">
                      <label for="pwd">Mobile No:</label>
                      <input type="text" v-model="form.mobile" class="form-control" placeholder="Enter Mobile Number">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </form>
            </div>
        </section>
    </main>
</template>
<script>
    import axios from 'axios';
    import {reactive,ref,onMounted} from 'vue';
    
    //Toaster notification
    import { useToast } from "vue-toastification";
    import "vue-toastification/dist/index.css"; 

    export default {
        // name: "Register",
        data() {
            return {
                token_data: localStorage.getItem('token'), 
                form: {
                    name : '',
                    mobile : '',
                }
            }
        },
        mounted: function() {
            const token = localStorage.getItem('token');
            console.log(token);
            this.getUserData(1);
        },
        methods: {
            getUserData(id){
                axios.get('api/user-info').then(res =>{
                    if(res.data.status){
                        console.log(res.data.data.name);
                        this.form= res.data.data
                    }else{
                        alert('inc..');
                    }
                });
            }
        },
        created(){
            
            axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('token')}` 
        }
    }
</script>