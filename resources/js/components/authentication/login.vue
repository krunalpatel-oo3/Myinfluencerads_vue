<template>
<!-- main content start here  -->
    <!-- main content start here  -->
    <div id="main-wrapper" class="bg-white">
        <div class="main-login">
            <div class="container-fluid px-0 overflow-hidden">
              <div class="row min-vh-100"> 
                <!-- Login Form
                ========================= -->
                <div class="col-md-12 col-lg-6 col-xl-6 d-flex flex-column order-2 order-lg-1 align-items-center justify-content-center left-side">
                    <div class="row">
                        <div class="col-lg-10 col-xl-8 col-md-8 col-xxl-6 mx-auto">
                            <div class="authentication-block">
                                <div class="auth-header">
                                    <h3>Login</h3>
                                    <p>Welcome back! Please enter your details</p>
                                    <a href="#" class="btn btn-outline  w-100"><img src="../assets/images/icon/google.svg" class="me-3">Log in with Google</a>
                                </div>
                                <div class="or-divider">
                                    <span>OR</span>
                                </div>
                                <form @submit.prevent="login" class="row cstm-form form-border login-form" method="post">
                                    <div class="col-12">
                                        <div class="form-group">
                                          <input type="text" class="form-control" required="" placeholder="Email" v-model="form.email">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                          <input type="text" class="form-control" required="" placeholder="Password" v-model="form.password">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-check form-group ps-0">
                                            <div class="custom-control custom-checkbox mr-sm-2 fp_link">
                                                <input type="checkbox" class="custom-control-input" id="customControlAutosizing">
                                                <label class="custom-control-label" for="customControlAutosizing">Keep me logged in</label>
                                            </div>
                                          </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <div class="fp_link text-end">
                                              <router-link to="/forgot_password">Forgot Password?</router-link>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="login-button w-100">
                                          <input type="submit" class="btn btn-pink w-100 hover-btn">
                                        </div>
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="login-footer text-center">
                                            <p class="d-inline-block position-relative">Don’t have an account? 
                                              <router-link to="/register">Signup for free</router-link>
                                                <img src="../assets/images/auth/signup-shape.svg" alt="signup-shape" class="position-absolute end-0 top-100"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Login Form End --> 
                
                <!-- Welcome Text
                ========================= -->
                <div class="col-md-12 col-lg-6 col-xl-6 order-1 order-lg-2 align-items-center justify-content-center right-side">
                  <div class="auth-side-wrap h-100" :style="{'background-image': 'url(' + defaultUserImgUrl + ')'}">
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
      </div>
</template>

<script>
import {reactive,ref} from 'vue'

// console.log(window.location.origin);

export default {
    name: "Header",
    data(){
         return {
            defaultUserImgUrl: "",
         }   
    },
     setup() {
        let form = reactive({
            email:'',
            password:''
        });

        let error = ref('');

        const login = async() => {
            await axios.post('/api/login', form).then(res=>{
              console.log(res);  
            })
            console.log('TES');
        }

        return {form,login,error}
     },
     mounted(){
      this.defaultUserImgUrl = "assets/images/auth/signup-bg.jpg";
     },
}
//data() {
 //   return {
   //   phaseData: null, 
     // showPhase: "",
    //};
  //},
</script>

<style>

@import '../../assets/vendors/bootstrap/bootstrap.min.css';
@import '../../assets/style.css';
@import '../../assets/css/shortcode.css';
/* @import '../../assets/css/aos.css'; */
@import '../../assets/css/responsive.css';
</style>