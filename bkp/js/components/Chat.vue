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
      <div class="row">
        <div class="col-xl-6 offset-xl-3">
          <div class="margin-top-70"></div>
          <div class="login-register-page">
            <!-- Welcome Text -->
            <div class="welcome-text">
              <h3>Hi, { { username } }</h3>
              <p>Chat Test</p>
            </div>

            <!-- Form -->
            <users-chat></users-chat>

          </div>
        </div>
      </div>
    </div>

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
import UsersChat from "./common/UsersChat.vue";
import Footer from "./common/Footer.vue";
export default {
  name: "ChatTest",
  components: {
    Header,
    UsersChat,
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
    };
  },
  created() {
    document.title = this.$route.meta.title;
    // this.doResetPasswordCheckUser();
  },
  methods: {

  },
};
</script>
