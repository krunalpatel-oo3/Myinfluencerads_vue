<template>
  <modal
    name="edit-email-dialog"
    :width="824"
    height="auto"
    :scrollable="true"
    :adaptive="true"
    transition=""
    class="section-modal edit-email-modal"
  >
    <div
      class="modal-close"
      @click="$modal.hide('edit-email-dialog')"
    >
      <CloseIcon />
    </div>
    <div class="row">
      <h2 class="w700 poppins t-33" style="margin-bottom: 17px">Change Email</h2>
      <div class="col-12">
        <label>Email</label>
        <input type="email" v-model="email" placeholder="example@gmail.com">
      </div>
      <div class="btns">
        <button @click="updateSetting" class="btn roboto btn-hover" :disabled="submitting">
          <div v-if="submitting" class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
          </div>
          <span v-else>Save Changes</span>
        </button>
      </div>
    </div>
  </modal>
</template>

<script>
import CloseIcon from "../icons/CloseIcon.vue";

export default {
  name: "EditEmailModal",
  props: ["userprofile"],
  components: {
    CloseIcon
  },
  data() {
    return {
      email: "",
      logged_user_id: null,
      submitting: false
    };
  },
  mounted() {
    this.email = this.userprofile.email;
  },
  methods: {
    async updateSetting() {
      const emailRegEx = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      if (!this.email) {
        this.$toast.warning("Email is required!");
        return;
      }else if(!this.email.match(emailRegEx)){
        this.$toast.warning("Please enter valid email address!");
        return;
      }
      
      this.submitting = true
      const result = await this.callApi(
        "post",
        window.api_path + "profile/updateProfileSetting",
        {
          email: this.email,
          user_id: localStorage.logged_user_id
        }
      );
      this.submitting = false
      if (result.data.code == 0) {
        this.$toast.error(result.data.data);
        return;
      }
      if (result.status != 200) {
        this.$toast.error(result.data.message);
        return;
      }
      this.newCommunityText = "";
      this.$toast.success("Data updated successfully");
      this.$emit("update-setting", result);
      this.$modal.hide("edit-email-dialog");
    }
  }
};
</script>

<style lang="scss" scoped>
label {
  font-size: 26px;
  line-height: 30px;
  color: #000000;
  font-weight: 700;
}
input {
  margin-bottom: 20px;
  width: 100%;
  height: 73px;
  background: #E5E5E5;
  border-radius: 5px;
  font-size: 22px;
  padding: 0 17px;
  color: #333333;
  &::placeholder {
    font-size: 22px;
    font-weight: 500;
    color: #333333;
  }
  border: none;
}
.modal-close {
  padding: 0 !important;
  top: 31px !important;
  right: 31px !important;
}

.row {
  margin: 10px 20px 0px 20px;
  display: flex;
  justify-content: center;
  flex-wrap: wrap;

  .btns {
    width: 100%;
    display: flex;
    justify-content: center;
    margin-top: 10px;
    margin-bottom: 20px;

    .btn {
      margin: 0 !important;
      height: 83.34px;
      width: 284.25px;
      background: #F2A91C;
      border-radius: 15px;
      font-size: 24px;
      border: none;
      color: #000000;
      font-weight: 500;
    }
  }

  h2 {
    width: 100%;
    text-align: center;
    line-height: 54px;
  }
}
</style>

