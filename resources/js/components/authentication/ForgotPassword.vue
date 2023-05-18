<template>
<div class="main-login">
    <div class="container-fluid px-0 overflow-hidden">
        <div class="row min-vh-100">
            <!-- Login Form -->
            <div class="col-md-12 col-lg-6 col-xl-6 d-flex flex-column order-2 order-lg-1 align-items-center justify-content-center left-side">
                <div class="row">
                    <div class="col-lg-10 col-xl-8 col-md-8 col-xxl-6 mx-auto">
                        <div class="authentication-block">
                            <div class="auth-header">
                                <h3>Forgot Password</h3>
                                <p>Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one</p>
                            </div>
                            <form class="row cstm-form form-border login-form" method="POST" action="{{ route('password.email') }}">
                                <div class="col-12">
                                    <div class="form-group">
                                        <input id="email" class="form-control" type="email" name="email"  required autofocus placeholder="test@test.com"/>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="login-button w-100">
                                        <button class="btn btn-pink w-100 hover-btn">
                                            Email Password Reset Link
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Login Form End -->

            <!-- Welcome Text -->
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
</template>
<script>
    import {reactive,ref} from 'vue'
    export default {
        name: "Header",
        data(){
             return {
                defaultUserImgUrl: "",
             }   
        },
        mounted(){
        this.defaultUserImgUrl = "assets/images/auth/signup-bg.jpg";
        },
    }
    </script>