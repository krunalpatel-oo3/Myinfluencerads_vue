<template>
<main>
    <!-- banner section  -->
    <section class="banner-section">

        <div class="container">
            <form @submit.prevent="update()" method="post">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="first_name">First Name:</label>
                            <label for="first_name">First Name:</label>
                            <input type="text" id="first_name" v-model="form.first_name" class="form-control" placeholder="Enter first name" rules="required"/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="last_name">Last Name:</label>
                            <input type="text" id="last_name" v-model="form.last_name" class="form-control" placeholder="Enter last name" rules="required"/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="contact_no">Contact Number:</label>
                            <input type="text" id="contact_no" v-model="form.contact_no" class="form-control" placeholder="Enter contact number">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="contact_no">Password:</label>
                            <input type="text" id="contact_no" v-on:keyup="checkSamePassword($event)"  v-model="form.password" class="form-control" placeholder="Enter passeo">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="contact_no">Confirm Password:</label>
                            <input type="text" v-on:keyup="checkSamePassword($event)" v-model="form.confirm_password" class="form-control" placeholder="Enter confirm passeo">
                        </div>
                        <div v-if="is_not_same">
                            The password and confirm password should same.
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary"><font-awesome-icon icon="fa-solid fa-floppy-disk fs-5" /> Submit</button>
            </form>
        </div>
    </section>
    </main>

</template>
<script>
    import axios from 'axios';
    import {reactive,ref} from 'vue';

    //Toaster notification
    import { useToast } from "vue-toastification";
    import "vue-toastification/dist/index.css"; 

    //Validate:
    import Vuelidate from 'vuelidate'
    import { Form, Field, ErrorMessage,defineRule  } from 'vee-validate';

        export default {
            components: {
            },
            data() {
                return {
                    token_data: localStorage.getItem('token'), 
                    form: {
                        first_name : '',
                        mobile : '',
                        is_amc: 1,
                        amc_price: '',
                        confirm_password: '',
                        password: ''
                    },
                    is_close: 1,
                    roles: [],
                    role_input: '',
                    name: '',
                    is_not_same: false,
                }
            },
            
            methods:{
                update: function(){
                    if(this.form.confirm_password){
                        alert('Filled.' + this.is_not_same);
                    }
                },
                checkSamePassword: function(e){
                    console.log(this.form.password + ' C: '+ this.form.confirm_password);
                    if(this.form.confirm_password != '' && this.form.confirm_password != this.form.password  ){
                        this.is_not_same = true; 
                    }else{
                        this.is_not_same = false; 
                    }
                    
                }
            }
        }
</script>