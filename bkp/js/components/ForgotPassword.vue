<template>
  <div>
    <loading
      :active.sync="isLoading"
      :can-cancel="false"
      :is-full-page="fullPage"
      background-color="#000"
      color="#202c54"
    ></loading>
    <Header />

    <!-- Page Content -->
    <!-- <div class="container">
      <div class="row">
        <div class="col-xl-6 offset-xl-3">
          <div class="margin-top-70"></div>
          <div class="login-register-page">
            <!-- Welcome Text -->
            <!-- <div class="welcome-text">
              <h3>Forgot Password</h3>
            </div> -->

            <!-- Form -->
            <!-- <form method="post" id="login-form"> -->
            <!-- <div class="input-with-icon-left">
              <i class="icon-material-baseline-mail-outline"></i>
              <input
                type="text"
                class="input-text with-border"
                v-model="fpemail"
                id="emailaddress"
                placeholder="Email Address"
              />
            </div> -->
            <!-- </form> -->

            <!-- Button -->
            <!-- <button
              class="button full-width button-sliding-icon ripple-effect"
              @click="doForgotPassword"
              form="login-form"
            >
              Forgot Password
              <i class="icon-material-outline-arrow-right-alt"></i>
            </button>

            <div class="welcome-text mt-4">
              <span
                >Already have an account?
                <router-link :to="{ name: 'login' }">Log In!</router-link></span
              >
            </div>
          </div>
        </div>
      </div>
    </div> -->

    <section class="section-cpostadd">
      <div class="container">
        <h4> Forgot Password</h4>
        <div class="cpostadd-container wblock">
          <div class="row">
            <div class="col-md-6">
               <div class="form-group">
            <label>Email Address</label>
            <input
              type="text"
              class="form-control"
               v-model="fpemail"
                id="emailaddress"
              placeholder="Email address"
            />
          </div>
            </div>
          </div>
          <div class="btns">
            <button class="btn btn-primary btn-wide" @click="doForgotPassword"
              form="login-form"> Forgot Password</button>
          </div>
        </div>
      </div>
    </section>

    <!-- Spacer -->
    <div class="margin-top-70"></div>
    <!-- Spacer / End-->

    <Footer />
  </div>
</template>

<script>
import Vue from "vue";
import Loading from "vue-loading-overlay";
import Header from "./common/Header.vue";
import Footer from "./common/Footer.vue";

export default {
  name: "ForgotPassword",
  components: {
    Header,
    Footer,
    Loading,
  },
  data() {
    return {
      publicPath: window.local_image_path,
      fpemail: "",
      isLoading: false,
      fullPage: true,
      isforgot: 0,
    };
  },
  created() {
    document.title = this.$route.meta.title;
  },
  methods: {
    async doForgotPassword() {
      if (this.fpemail == "") {
        this.$toast.error("Please enter Email address");
      } else {
        // do forgotpassword
        this.isLoading = true;
        const fp_details = await this.callApi(
          "post",
          window.api_path + "request_forgot_password",
          {
            email: this.fpemail,
          }
        );

        if (fp_details.status == 200) {
          if (fp_details.data.code == 1) {
            this.$toast.success(fp_details.data.data);
            this.isforgot = 1;
            this.isLoading = false;
            this.fpemail = "";
          } else {
            this.$toast.error(fp_details.data.data);
            this.isLoading = false;
            this.isforgot = 2;
          }
        } else {
          this.$toast.error("Details not sent, please try again");
          this.isLoading = false;
          this.isforgot = 2;
        }

        if (this.isforgot == 0) {
          setTimeout(() => {
            this.isLoading = false;
          }, 10000);
        }
      }
    },
  },
};
</script>
