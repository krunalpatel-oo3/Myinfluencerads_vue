<template>
  <modal
    name="edit-password-dialog"
    :width="824"
    height="auto"
    :scrollable="true"
    :adaptive="true"
    transition=""
    class="section-modal edit-password-modal"
  >
    <div
      class="modal-close"
      @click="$modal.hide('edit-password-dialog')"
    >
      <CloseIcon />
    </div>
    <div class="row">
      <h2 class="w700 poppins t-33 title-modal" style="margin-bottom: 17px">Change Password</h2>
      <div class="col-12 pop-modal-body">
        <label>Current Password</label>
        <input type="password" v-model="old_password" placeholder="Enter password">
        <label>New Password</label>
        <input type="password" v-model="password" placeholder="Enter new password">
        <label>Confirm New Password</label>
        <input type="password" v-model="confirm_password" placeholder="Confirm new password">
      </div>
      <div class="btns pop-btns">
        <button @click="updateSetting" class="btn roboto btn-hover">Save Changes</button>
      </div>
    </div>
  </modal>
</template>

<script>
import CloseIcon from "../icons/CloseIcon.vue";

export default {
  name: "EditPasswordModal",
  components: {
    CloseIcon
  },
  data () {
    return {
      password: "",
      confirm_password: "",
      old_password: "",
      logged_user_id: null,
    }
  },
   mounted() {
    this.full_name = this.userprofile.full_name;

  },
   methods: {
      async updateSetting() {
      if (!this.old_password) {
        this.$toast.warning("Current password is required!");
        return;
      }
      
      if (!this.password) {
        this.$toast.warning("New password is required!");
        return;
      } else if(this.password.length < 8){
        this.$toast.warning("Password must be 8 characters long!");
        return;
      }

      if (this.password != this.confirm_password) {
        this.$toast.warning("New password and confirm password does not match!");
        return;
      }


      const result = await this.callApi(
        "post",
        window.api_path + "profile/updateProfileSetting",
        {
          password: this.password,
          old_password: this.old_password,
          user_id: localStorage.logged_user_id,


        }
      );

      if (result.data.code == 0) {
        this.$toast.error(result.data.data);
        return;
      }
      this.newCommunityText = "";
      this.$toast.success(result.data.data);
            this.$modal.hide('edit-password-dialog');

      this.$emit('update-setting', result);
      //this.$router.push(this.redirecturl + result.data.slug);
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

@media all and (max-width:1024px){
  .title-modal {
      font-size: 26px;
  }

  .pop-modal-body label {
      font-size: 20px;
  }

  .pop-modal-body input {
      height: auto;
      padding: 10px 15px;
      line-height: normal;
  }

  .pop-modal-body input::-webkit-input-placeholder{
      font-size:16px !important;
  }
  .pop-modal-body input::-moz-placeholder{
      font-size:16px !important;
  }
  .pop-modal-body input:-ms-input-placeholder{
      font-size:16px !important;
  }
  .pop-modal-body input::-ms-input-placeholder{
      font-size:16px !important;
  }
  .pop-modal-body input::placeholder{
      font-size:16px !important;
  }
  .pop-btns .btn {
    height: auto !important;
    padding: 10px 15px !important;
    width: 100% !important;
    max-width: 170px !important;
    font-size: 18px !important;
  }
}

@media all and (max-width:767px){
  .modal-close {
    top: 20px !important;
    right: 20px !important;
  }
  .modal-close svg {
    width: 30px;
    height: 30px;
  }
}

@media all and (max-width:575px){
  .title-modal{
    font-size: 22px;
    line-height:normal;
  }
}
</style>

