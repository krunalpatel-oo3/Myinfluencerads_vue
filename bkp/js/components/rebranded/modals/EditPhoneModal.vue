<template>
  <modal
    name="edit-phone-dialog"
    :width="824"
    height="auto"
    :scrollable="true"
    :adaptive="true"
    transition=""
    class="section-modal edit-phone-modal"
    style="overflow: hidden"
  >
    <div
      class="modal-close"
      @click="$modal.hide('edit-phone-dialog')"
    >
      <CloseIcon />
    </div>
    <div class="row">
      <h2 class="w700 poppins t-33" style="margin-bottom: 17px">Change Phone</h2>
      <div class="col-12">
        <label>Phone</label>
        <vue-tel-input
          v-model="phone"
          :dropdownOptions="dropdownOptions"
          :inputOptions="inputOptions"
        />
      </div>
      <div class="btns">
        <button @click="updateSetting" class="btn roboto btn-hover">Save Changes</button>
      </div>
    </div>
  </modal>
</template>

<script>
import CloseIcon from "../icons/CloseIcon.vue";
import { VueTelInput } from 'vue-tel-input';

export default {
  name: "EditPhoneModal",
   props: ['userprofile'],
  components: {
    VueTelInput,
    CloseIcon
  },
  data () {
    return {
      phone:null,
      logged_user_id: null,
      dropdownOptions: {
        showDialCodeInList: true,
        showDialCodeInSelection: true,
        showFlags: true,
        width: '300px'
      },
      inputOptions: {
        showDialCode: true
      }
    }
  },
  mounted() {
    this.phone = this.userprofile.phone;
  },
  methods: {
    async updateSetting() {
      const regExNumber = /^[0-9 +]+$/;
      if (!this.phone) {
        this.$toast.warning(" timezone is required! ");
        return;
      } else if(!this.phone.match(regExNumber)){
        this.$toast.warning(" Only numbers are allowed! ");
        return;
      }

      const result = await this.callApi(
        "post",
        window.api_path + "profile/updateProfileSetting",
        {
          phone: this.phone,
          user_id: localStorage.logged_user_id,
        }
      );
      this.userprofile.phone = this.phone;
      if (result.status != 200) {
        this.$toast.error(result.data.message);
        return;
      }
      this.newCommunityText = "";
      this.$toast.success("Details updated successfully!");
      this.$modal.hide('edit-phone-dialog');
      this.$emit('update-setting', result);
    }
   }
};
</script>
<style src="vue-tel-input/dist/vue-tel-input.css"></style>
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