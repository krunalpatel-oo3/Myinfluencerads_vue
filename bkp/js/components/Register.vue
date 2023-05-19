
<template>
  <div>
    <loading
      :active.sync="isLoading"
      :can-cancel="false"
      :is-full-page="fullPage"
      background-color="#000"
      color="#202c54"
    ></loading>

    <!-- Register block -->
    <section class="section-modal section-modal-register">
      <div class="modal-container">
        <div class="modal-content modal-content-500">
          <div class="modal-close">
            <icon-base
              width="24"
              height="24"
              viewBox="0 0 24 23.99"
              icon-name="close-round"
              ><icon-close-round
            /></icon-base>
          </div>

          <div class="register-form">
            <h3 class="h4">Create an account</h3>

            <form action="">
              <div class="form-group">
                <label for="registerEmailAddress">Email address</label>
                <input
                  type="text"
                  class="form-control"
                  v-model="registerform.email"
                  id="registerEmailAddress"
                  placeholder="Enter email address"
                />
              </div>
              <div class="form-group">
                <label for="registerUsername">Username</label>
                <input
                  type="text"
                  class="form-control"
                  v-model="registerform.name"
                  id="registerUsername"
                  placeholder="Enter username"
                />
              </div>
              <div class="form-group">
                <label for="registerPassword">Password</label>
                <input
                  type="password"
                  class="form-control"
                  v-model="registerform.password"
                  id="registerPassword"
                  placeholder="Create password"
                />
              </div>
              <div class="form-group">
                <label for="registerCPassword">Confirm password</label>
                <input
                  type="password"
                  class="form-control"
                  v-model="registerform.cpassword"
                  id="registerCPassword"
                  placeholder="Re-enter password"
                />
              </div>

              <div class="custom-checkbox-group">
                <label class="custom-checkbox custom-checkbox-sm">
                  <input
                    type="checkbox"
                    v-model="registerform.agree"
                    value="1"
                  />
                  <span
                    >I have read and agree to the
                    <router-link :to="{ name: 'home' }">terms</router-link>,
                    <router-link :to="{ name: 'home' }">privacy</router-link>
                    and
                    <router-link :to="{ name: 'home' }"
                      >other details</router-link
                    ></span
                  >
                </label>
              </div>

              <button
                class="btn btn-primary btn-lg btn-block"
                @click="doregister"
                form="register-form"
              >
                Sign Up
              </button>
            </form>

<!--              <GoogleLogin-->
<!--              class="btn btn-outline-grey btn-block btn-icon"-->
<!--              :params="params"-->
<!--              :onSuccess="loginWithGoogle"-->
<!--            >-->
<!--              <icon-base-->
<!--                width="20"-->
<!--                height="20"-->
<!--                viewBox="0 0 20 20"-->
<!--                icon-name="google"-->
<!--                ><icon-google-->
<!--              /></icon-base>-->
<!--              <span>Continue with Google</span>-->
<!--            </GoogleLogin>-->

            <div class="register-signin">
              Already member?
              <router-link :to="{ name: 'login' }">Sign In</router-link>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-bg"></div>
    </section>
  </div>
</template>

<script>
import Loading from "vue-loading-overlay";
import IconBase from "./common/IconBase.vue";
import IconGoogle from "./common/icons/IconGoogle.vue";
import GoogleLogin from "vue-google-login";
import IconCloseRound from "./common/icons/IconCloseRound.vue";

export default {
  name: "Register",
  components: {
    Loading,
    IconBase,
    IconGoogle,
    IconCloseRound
  },
  data() {
    return {
      publicPath: local_image_path,
      isregisterd: 0,
      isLoading: false,
      fullPage: true,
      registerform: {
        name: "",
        email: "",
        password: "",
        cpassword: "",
        agree: ""
      }
    };
  },
  created() {
    document.title = this.$route.meta.title;
  },
  methods: {
    async doregister() {
      if (this.registerform.name == "") {
        this.$toast.error("Please enter Name");
      } else if (this.registerform.email == "") {
        this.$toast.error("Please enter Email");
      } else if (this.registerform.password == "") {
        this.$toast.error("Please enter Password");
      } else if (this.registerform.cpassword == "") {
        this.$toast.error("Please enter Repeat Password");
      } else if (this.registerform.password != this.registerform.cpassword) {
        this.$toast.error("Both Password must be same");
      } else if (this.registerform.agree == "") {
        this.$toast.error("Please Agree to terms of service");
      } else {
        // do registration
        this.isLoading = true;
        const reg_details = await this.callApi(
          "post",
          window.api_path + "registration",
          {
            name: this.registerform.name,
            email: this.registerform.email,
            password: this.registerform.password
          }
        );

        console.log(reg_details)

        // if (reg_details.status == 200) {
        //   console.log(reg_details)
        //   if (reg_details.data.code == 1) {
        //     // this.$toast.success(reg_details.data.data);
        //     this.isregisterd = 1;
        //     this.isLoading = false;
        //     this.registerform.name = "";
        //     this.registerform.email = "";
        //     this.registerform.password = "";
        //     this.registerform.cpassword = "";
        //     this.registerform.agree = "";
        //   } else {
        //     console.log(reg_details.data)
        //     // this.$toast.error(reg_details.data.data);
        //     this.isLoading = false;
        //     this.isregisterd = 2;
        //   }
        // } else {
        //   this.$toast.error("Registration not done, please try again");
        //   this.isLoading = false;
        //   this.isregisterd = 2;
        // }

        // if (this.isregisterd == 0) {
        //   setTimeout(() => {
        //     this.isLoading = false;
        //   }, 10000);
        // }
      }
    },
    async loginWithGoogle(googleUser) {
      this.isLoading = true;
      var profile = googleUser.getBasicProfile();
console.log(profile);
      const googlelogin_details = await this.callApi(
        "post",
        window.api_path + "googlelogin",
        {
          name: profile.getName(),
          email: profile.getEmail(),
          user: profile.getId()
        }
      );

      if (googlelogin_details.status == 200) {
        this.isLoading = false;
        if (googlelogin_details.data.code == 1) {
          this.isfblogin = 1;

          if (localStorage.getItem("sgemail") != null) {
            localStorage.removeItem("sgemail");
          }
          localStorage.setItem("sgemail", profile.getEmail());

          if (localStorage.getItem("sgtoken") != null) {
            localStorage.removeItem("sgtoken");
          }
          localStorage.setItem("sgtoken", googlelogin_details.data.token);

          if (localStorage.getItem("sgname") != null) {
            localStorage.removeItem("sgname");
          }
          localStorage.setItem("sgname", googlelogin_details.data.name);

          if (localStorage.getItem("sgphoto") != null) {
            localStorage.removeItem("sgphoto");
          }
          localStorage.setItem("sgphoto", googlelogin_details.data.photo);

          if (localStorage.getItem("sgtype") != null) {
            localStorage.removeItem("sgtype");
          }
          localStorage.setItem("sgtype", 2);

          window.sgtype = 2;
          window.isAuthenticated = true;
          this.$router.push({ name: "dashboard" });
        } else {
          this.$toast.error(googlelogin_details.data.data);
          this.isfblogin = 2;
        }
      } else {
        this.$toast.error("Login not done, please try again");
        this.isLoading = false;
        this.isfblogin = 2;
      }

      if (this.isfblogin == 0) {
        setTimeout(() => {
          this.isLoading = false;
        }, 10000);
      }
    }, // async loginWithGoogle(googleUser) {

  },
  mounted() {}
};
</script>
