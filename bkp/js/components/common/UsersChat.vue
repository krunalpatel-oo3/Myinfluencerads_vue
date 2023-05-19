<template>
    <div class="container">
      resources/js/components/common/UsersChat.vue
    </div>

</template>

<script>
import Vue from "vue";

import Echo from 'laravel-echo';
import Loading from "vue-loading-overlay";
import {bus} from "../../app";

const client = require('pusher-js');

export default {
  name: "UsersChat",
  components: {
    Loading,
  },
  computed: {
    // isHomepage() {
    //   return this.$route.path == "/";
    // }
  },
  data() {
    return {
      headerDropdown1: false,
      // mmenuExpanded: false,
      // notificationsDropdown: false,
      // publicPath: local_image_path,
      // isAuthenticated: window.isAuthenticated,
      // logged_user_full_name: "",
      // logged_user_id: null,
      // redirectto: "",
      // emailstatus: this.$route.params.emailstatus,
      // loginCMSText: "",
      // islogin: 0,
      // isfblogin: 0,
      // isLoading: false,
      // fullPage: true,
      //
      // isLoginForm: false,
      loginFormData: {
        email: "",
        password: ""
      },

    };
  },

  methods: {
    async loadCMSItemByKey(CMSItemKey) {
      // const result = await this.callApi(
      //   "post",
      //   window.api_path + "getBlockCMSItem",
      //   {
      //     key: CMSItemKey
      //   }
      // );
      //
      // if (CMSItemKey == "show_login_dialog_block") {
      //   this.loginCMSText = result.data.cMSItem.text;
      // }
    }, // loadCMSItemByKey() {

  }, // methods: {
  // LOGIN FORM BLOCK END

  created() {
    console.log('created::')
  },

  mounted() {

    console.log('mounted Echo::')
    console.log(Echo)

    window.Echo.join('-')
      .here( users=>{
          console.log('here users::')
          console.log(users)

        }

      )
      .joining(user=>{
          console.log('joining user::')
          console.log(user)

        }

      )
      .leaving(user=>{
          console.log('leaving user::')
          console.log(user)

        }

      )
      .listen('NewMessage', (e) => {
        console.log('NewMessage e::')
        console.log(e)

        //
      });

  }
};
</script>
