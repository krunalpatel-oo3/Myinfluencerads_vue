<template>
    <main>
        <!-- banner section  -->
        <section class="banner-section">
            <div class="container">
                
                <form @submit.prevent="update()" method="post">
                    <vs-select  filter v-model="role_input" placeholder="Please select" >
                        <vs-option v-for="role in roles"  :value="role.id" :label="role.name">{{ role.name}} </vs-option>
                    </vs-select>
                    
                    <h1>Number format :  {{ $numFormat(100000) }}</h1>
                    <h1>Number format with dollar sign :  {{ $numFormatWithDollar(100000) }}</h1>
                    <h1>Number format with dollar sign :  {{ $subString('This ia smkn kfnndjfndkfk dknfksdnfksdnfk ') }}</h1>

                    <!-- <Select2 v-model="myValue" :options="myOptions" :settings="{ settingOption: value, settingOption: value }" @change="myChangeEvent($event)" @select="mySelectEvent($event)" />
                    <h4>Value: {{ myValue }}</h4> -->


                    <div class="form-group">
                      <label for="pwd">Name:</label>
                      <Field type="text" name="name" v-model="form.name" class="form-control" placeholder="Enter Name" rules="required"/>
                      <ErrorMessage name="name" />
                    </div>
                    <div class="form-group">
                      <label for="pwd">Is AMC?:</label>
                      <select v-model="form.is_amc" name="is_amc" @click="onChange($event)">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                      </select>
                    </div>
                    <div class="form-group" v-if="is_close">
                        <label for="pwd">AMC price:</label>
                        <Field type="text" name="amcprice" v-model="form.amc_price" class="form-control" placeholder="Enter AMC price" rules="required" />
                        <ErrorMessage name="amcprice" />
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

    //Validate:
    import { Form, Field, ErrorMessage,defineRule  } from 'vee-validate';
    
    // import Select2 from 'vue3-select2-component';

    defineRule("required", (value) => {
    if (!value || !value.length) {
        return "This field is required";
    }
    return true;
    });
    export default {
        components: {
            Form,
            Field,
            ErrorMessage,
            defineRule ,
            // Select2
        },
        // name: "Register",
        data() {
            return {
                myValue: '',
            myOptions: ['op1', 'op2', 'op3'],
                token_data: localStorage.getItem('token'), 
                form: {
                    name : '',
                    mobile : '',
                    is_amc: 1,
                    amc_price: '',
                },
                is_close: 1,
                roles: [],
                role_input: '',
            }
        },
        mounted: function() {
            const token = localStorage.getItem('token');
            
            console.log(this.$subString('This ia smkn kfnndjfndkfk dknfksdnfksdnfk '))
            this.getUserData(1);
            
            axios.get('api/user-roles').then(res =>{
                // console.log(res.data);
                this.roles = res.data;
            });
        },
        methods: {
            onChange(e){
                if(e.target.value == 1){
                    this.is_close = 1
                }else{
                    this.is_close = 0
                    console.log(e.target.value);
                }
            },
            update(){
                alert();
                const postData = {
                    title: this.role_input,
                    // description: this.$refs.post_description.value,
                };
                axios.post('api/user-store', postData).then(res =>{

                });
            },
            getUserData(id){
                axios.get('api/user-info').then(res =>{
                    if(res.data.status){
                        console.log(res.data.data.name);
                        this.form= res.data.data
                    }else{
                        alert('inc..');
                    }
                });
            },
        },
        created(){
            
            axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('token')}` 
        }
    }
</script>