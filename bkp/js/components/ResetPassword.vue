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
    <div class="container">
      <div class="row justify-content-center">
        <div style="max-width: 437px">
          <h4 class="reset-h">Create new Password</h4>
          <p class="reset-p">Enter the email accosiated with you account and we’ll send an email with instructions to reset your password.</p>
            <div class="form-group">
              <label>New Password</label>
              <input
                type="password"
                class="form-control"
                v-model="resetform.password"
                id="password-register"
                placeholder="New Password"
              />
            </div>

            <div class="form-group">
              <label>Confirm new Password</label>
              <input
                type="password"
                class="form-control"
                v-model="resetform.cpassword"
                id="password-repeat-register"
                placeholder="Repeat New Password"
              />
            </div>

            <!-- Button -->
            <button
              class="reset-btn"
              @click="doResetPassword"
            >
              Reset Password
            </button>
          </div>
        </div>
      </div>
    <Footer />
  </div>
</template>

<script>
import Loading from "vue-loading-overlay";
import Header from "./common/Header.vue";
import Footer from "./common/Footer.vue";

export default {
  name: "ResetPassword",
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
      passwordkey: "",
      username: "",
      resetform: {
        password: "",
        cpassword: "",
      },
    };
  },
  created() {
    document.title = this.$route.meta.title;
    this.passwordkey = this.$route.params.id;
    this.doResetPasswordCheckUser();
  },
  methods: {
    async doResetPasswordCheckUser() {
      this.isLoading = true;
      const cfp_details = await this.callApi(
        "post",
        window.api_path + "check_forgot_password",
        {
          id: this.passwordkey,
        }
      );

      if (cfp_details.status == 200) {
        if (cfp_details.data.code == 0) {
          this.$toast.error("This link was expired.Please generate new one!");
          setTimeout(() => {
          this.$router.push({ name: "Home" });
        }, 2000);
        }
        if (cfp_details.data.code == 1) {
          this.username = cfp_details.data.data;
          this.isLoading = false;
        }
      } else {
        this.$toast.error("This link was expired.Please generate new one!");
        setTimeout(() => {
          this.$router.push({ name: "Home" });
        }, 2000);
      }
    },
    async doResetPassword() {
      if (this.resetform.password === "") {
        this.$toast.error("Please enter New Password");
      } else if (this.resetform.password.length < 8) {
        this.$toast.error("Please enter minimum 8 character in password");
      } else if (this.resetform.cpassword === "") {
        this.$toast.error("Please enter Repeat New Password");
      } else if (this.resetform.password !== this.resetform.cpassword) {
        this.$toast.error("Both Password must be same");
      } else {
        // do forgotpassword
        this.isLoading = true;
        const fp_details = await this.callApi(
          "post",
          window.api_path + "update_forgot_password",
          {
            id: this.passwordkey,
            password: this.resetform.password,
          }
        );

        if (fp_details.status == 200) {
          if (fp_details.data.code == 1) {
            this.$toast.success(fp_details.data.data);
            this.isforgot = 1;
            this.isLoading = false;
            this.resetform.password = "";
            this.resetform.cpassword = "";
            this.$router.push({ name: "Home" });
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

<style lang="scss" scoped>
.reset-h {
  margin-top: 80px;
  font-weight: 700;
  font-size: 24px;
  line-height: 54px;
}
.reset-p {
  font-size: 14px;
  line-height: 16px;
  margin-top: 20px;
  margin-bottom: 40px;
}
.reset-btn {
  width: 100%;
  margin-top: 12px;
  background: #202C54;
  border-radius: 4px;
  border: none;
  font-weight: 500;
  font-size: 16px;
  color: white;
  height: 56px;
  margin-bottom: 80px;
  &:hover {
    filter: brightness(1.2);
  }
}
</style>
