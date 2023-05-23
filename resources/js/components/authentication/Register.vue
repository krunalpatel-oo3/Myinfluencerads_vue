<template>
    <div id="main-wrapper" class="bg-white">
        <div class="container-fluid px-0 overflow-hidden">
          <div class="row min-vh-100"> 
            <!-- Login Form -->
            <div class="col-md-12 col-lg-6 col-xl-6 d-flex flex-column order-2 order-lg-2 align-items-center justify-content-center left-side">
                <div class="row">
                    <div class="col-lg-10 col-xxl-7 col-xl-8 mx-auto">
                        <div class="authentication-block">
                            <div class="auth-header">
                                <h3>Sign Up</h3>
                                <p>Create an Account for fee!</p>
                                <a href="#" class="btn btn-outline  w-100"><img src="assets/images/icon/google.svg" class="me-3">Log in with Google</a>
                            </div>
                            <div class="or-divider">
                                <span>OR</span>
                            </div>
                            <!-- <div class="row cstm-form form-border login-form" @submit.prevent="submitForm" method="post"> -->
                            <Form class="row cstm-form form-border login-form" @submit="submitForm">
                              <div :class="{ error: v$.fname.$errors.length }">
                                <input v-model="formData.fname">
                                <div class="input-errors" v-for="error of v$.fname.$errors" :key="error.$uid">
                                  <div class="error-msg">{{ error.$message }}</div>
                                </div>
                              </div>

                                <div class="col-12 col-md-6 ">
                                    <div class="form-group">
                                      <input type="text" class="form-control" v-model="registerform.fname" placeholder="First Name"/>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                      <input type="text" class="form-control"  v-model="registerform.lname" placeholder="Last Name">
                                    </div>
                                </div>
                                <div class="col-12">
                                  <div class="form-group">
                                    <select class="form-select form-control" aria-label="Default select example" placeholder="Who are you?" v-model="registerform.role">
                                      <option value="0" selected disabled>Who are you?</option>
                                      <option value="1">Manager</option>
                                      <option value="2">Engineer</option>
                                    </select>
                                  </div>
                              </div>
                                <div class="col-12">
                                    <div class="form-group">
                                      <input type="text" class="form-control" v-model="registerform.phone_number" placeholder="Phone Number">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                      <input type="text" class="form-control" v-model="registerform.email" placeholder="Email">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                      <input type="password" class="form-control"  placeholder="Password" v-model="registerform.password">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                      <input type="password" class="form-control" v-model="registerform.confirm_pass" placeholder="Confirm Password">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="login-button w-100">
                                      <button type="submit" class="btn btn-pink w-100 hover-btn">Register</button>
                                      <button type="submit" class="btn btn-pink w-100 hover-btn" @click="submitForm">Register</button>
                                    </div>
                                </div>
                            </Form>
                            <div class="row">
                                <div class="col-12">
                                    <div class="login-footer text-center">
                                        <p class="d-inline-block position-relative">Already have an account?  
                                            <router-link to="/login">Login</router-link>
                                            <img src="assets/images/auth/signup-shape.svg" alt="signup-shape" class="position-absolute end-0 top-100"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Login Form End --> 
            
            <!-- Welcome Text -->
            <div class="col-md-12 col-lg-6 col-xl-6 order-1 order-lg-1 align-items-center justify-content-center right-side">
              <div class="auth-side-wrap signup-page-bg h-100" :style="{'background-image': 'url(' + signupBackgroundImg + ')'}">
                <div class="auth-side-content w-100 h-100 d-flex flex-column">
                  <div class="row g-0 my-auto py-5">
                    <div class="col-10 col-lg-9 mx-auto text-center"> 
                      <div>
                        <router-link to="/">
                            <img src="../assets/images/logo-white.svg">
                        </router-link>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Welcome Text End --> 
            </div>
          </div>
        </div>
      </div>
</template>

<script>
    import axios from 'axios';
    import {reactive,ref} from 'vue'
    //Validate.
    // import Vuelidate from 'vuelidate'
    import { useVuelidate } from '@vuelidate/core'
    import {required } from "@vuelidate/validators" 
    // import { required, email } from "vuelidate/lib/validators";
    // import { required, minLength } from 'vuelidate/lib/validators'

    //Toaster notification
    import { useToast } from "vue-toastification";
    import "vue-toastification/dist/index.css" 
    
    import { Form } from 'vee-validate';

    export default {
        name: "Register",
        setup(){
          const rules = {
            fname:{required},
          };
          
          const formData = reactive({
            fname: "",
            lname:"",
            role:"0",
            phone_number:"",
            email: "",
            password: "",
            cpassword: "",
          });
          const v$= useVuelidate(rules,formData);

          return { formData, v$ }

          const doregister = (values, actions) =>{
            alert('test');
            return false;
          };

          const submitForm = async () => {
            const result =await v$.value.$validate();
            console.log(result);
            if(result){
              alert('Success, form submitted,');
            }else{
              alert('Failed, form submitted,');
            }
          }
        },
        data(){
            return {
                v$: useVuelidate(),
                signupBackgroundImg: "",
                registerform: {
                    fname: "",
                    lname:"",
                    role:"0",
                    phone_number:"",
                    email: "",
                    password: "",
                    cpassword: "",
                    agree: "",
                }
            }   
        },
        validations() {

          return {
            fname: { required }
            // minLength: minLength(4)
          }
        },
        methods:{
          async submitForm(){
            alert('Cal....');
            console.log(this.v$.$touch)
            
          },
            // async doregister() {
            //   // Get toast interface
            //   const toast = useToast();

            //   if (this.registerform.fname == "") {
            //     toast.error('Please enter First name');
            //     return false;
            //   }
            //   else if (this.registerform.lname == "") {
            //     toast.error('Please enter Last name')
            //     return false;
            //   }
            //   else if (this.registerform.role == "" || this.registerform.role == 0) {
            //     toast.error('Please select role')
            //     return false;
            //   }
            //   else if (this.registerform.phone_number == "") {
            //     toast.error('Please enter phone number')
            //     return false;
            //   }
            //   else if (this.registerform.email == "") {
            //     toast.error('Please enter email')
            //     return false;
            //   }
            //   else if (this.registerform.password == "") {
            //     toast.error('Please enter password')
            //     return false;
            //   }
            //   else if (this.registerform.confirm_pass == "") {
            //     toast.error('Please enter confirm password')
            //     return false;
            //   }
            //   else {
            //     // do registration
            //     alert('Submit//');
            //     axios.post('/api/registration',
            //         {
            //             fname:this.registerform.fname,
            //             lname:this.registerform.lname,
            //             email:this.registerform.email,
            //             role:this.registerform.role,
            //             phone_number:this.registerform.phone_number,
            //             password:this.registerform.password,
            //             confirm_pass:this.registerform.confirm_pass,
            //         })
            //         .then((res) => {
            //             console.log(res)
            //             router.push({name: 'Login'})
            //         })
            //         .catch((err) => {
            //             console.log(err)
            //         });
            //   }
            // },

          // return {
          //   doregister
          // }
        },
        mounted(){
        this.signupBackgroundImg = "assets/images/auth/signup-bg.jpg";
        },
    }
</script>