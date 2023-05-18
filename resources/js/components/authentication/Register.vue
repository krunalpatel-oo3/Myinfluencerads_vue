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
                            <form class="row cstm-form form-border login-form" method="post">
                                <div class="col-12 col-md-6 ">
                                    <div class="form-group">
                                      <input type="text" class="form-control" required="" v-model="registerform.fname" placeholder="First Name">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                      <input type="text" class="form-control" required="" v-model="registerform.lname" placeholder="Last Name">
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
                                      <input type="text" class="form-control" v-model="registerform.phone_number" required="" placeholder="Phone Number">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                      <input type="text" class="form-control" required="" v-model="registerform.email" placeholder="Email">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                      <input type="text" class="form-control" required="" placeholder="Password" v-model="registerform.password">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                      <input type="text" class="form-control" required="" v-model="registerform.confirm_pass" placeholder="Confirm Password">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="login-button w-100">
                                      <button type="submit" class="btn btn-pink w-100 hover-btn" @click="doregister">Register</button>
                                    </div>
                                </div>
                            </form>
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
    import {reactive,ref} from 'vue'
    
    
    export default {
        name: "Register",
        data(){
            return {
                signupBackgroundImg: "",
                registerform: {
                    fname: "",
                    lname:"",
                    role:"0",
                    phone_number:"",
                    email: "",
                    password: "",
                    cpassword: "",
                    agree: ""
                }
            }   
        },
        mounted(){
        this.signupBackgroundImg = "assets/images/auth/signup-bg.jpg";
        },
    }
</script>