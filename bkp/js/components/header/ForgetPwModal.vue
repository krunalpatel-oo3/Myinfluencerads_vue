<template>
  <modal
    name="forget-password-dialog"
    :width="500"
    height="auto"
    :scrollable="true"
    :adaptive="true"
    transition=""
    class="section-modal section-modal-login fp-modal"
  >
    <loading
      :active.sync="isLoading"
      :can-cancel="false"
      :is-full-page="true"
      background-color="#000"
      color="#202c54"
    ></loading>
    <div class="modal-close" @click="closeModal">
      <icon-base
        width="24"
        height="24"
        viewBox="0 0 24 23.99"
        icon-name="close-round"
      >
        <icon-close-round
        />
      </icon-base>
    </div>
    <div v-if="!stepSuccess" class="row mx-0">
      <div class="col-12">
        <h4 class="fp-h">Forgot Password?</h4>
        <p class="fp-p">Enter the email associated with you account and we’ll send an email with instructions to reset your password.</p>
        <div class="form-group">
          <label>Email address</label>
          <input
            type="text"
            class="form-control fp-input"
            v-model="email"
            placeholder="Enter email address"
          />
        </div>
        <button class="fp-submit" @click="doForgotPassword">Send Instructions</button>
      </div>
    </div>
    <div v-else class="row mx-0">
      <div class="col-12">
        <h4 class="fp-h" style="margin-top: 20px">Email has been sent!</h4>
        <p class="fp-p">Please check your inbox and click in the received recovery link to reset your password.</p>
      </div>
    </div>
  </modal>
</template>

<script>
import IconCloseRound from "../common/icons/IconCloseRound.vue";
import IconBase from "../common/IconBase.vue";
import Loading from "vue-loading-overlay";

export default {
  name: "ForgetPwModal",
  data () {
    return {
      email: null,
      isLoading: false,
      stepSuccess: false
    }
  },
  components: {
    IconCloseRound,
    IconBase,
    Loading,
  },
  methods: {
    async doForgotPassword() {
      if (!this.email) {
        this.$toast.error("Please fill Email address");
      } else {
        this.isLoading = true
        const fp_details = await this.callApi(
          "post",
          window.api_path + "request_forgot_password",
          {
            email: this.email,
          }
        );

        if (fp_details.status === 200) {
          this.isLoading = false
          if (fp_details.data.code === 1) {
            this.stepSuccess = true
            this.email = "";
          } else {
            this.$toast.error(fp_details.data.data);
            this.isLoading = false;
          }
        } else {
          this.isLoading = false
          this.$toast.error("Details not sent, please try again");
        }
      }
    },
    closeModal () {
      this.$modal.hide('forget-password-dialog');
      this.email = ""
      this.stepSuccess = false
    }
  }
};
</script>

<style lang="scss" scoped>
.fp-h {
  margin-top: 35px;
  text-align: center;
  font-weight: 700;
  font-size: 24px;
  line-height: 54px;
}
.fp-p {
  margin: 20px 35px;
  text-align: center;
}
.fp-input {
  border: 1px solid #DDE0E6;
  border-radius: 4px;
}
.fp-submit {
  background: #202C54;
  border-radius: 4px;
  border: none;
  color: #FFFFFF;
  font-weight: 500;
  font-size: 16px;
  width: 100%;
  height: 56px;
  margin-bottom: 35px;
  &:hover {
    filter: brightness(1.2);
  }
}
.modal-close {
  z-index: 1000;
}
</style>
