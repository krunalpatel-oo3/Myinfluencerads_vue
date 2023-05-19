<template>
  <modal
    name="edit-address-dialog"
    :width="824"
    height="auto"
    :scrollable="true"
    :adaptive="true"
    transition=""
    class="section-modal edit-address-modal"
  >
    <div
      class="modal-close"
      @click="$modal.hide('edit-address-dialog')"
    >
      <CloseIcon />
    </div>
    <div class="row">
      <h2 class="w700 poppins t-33 title-modal" style="margin-bottom: 17px">Change Address</h2>
      <div class="col-12 pop-modal-body">
        <label>Address</label>
        <places
          placeholder="Address"
          v-model="address"
          @change="val => { autocomplete = val }"
          :options="options"
        />
        <div class="row mx-0">
          <div class="col-6 p-0 pr-3">
            <label>Country</label>
            <input type="text" v-model="country" placeholder="Feugat 10">
          </div>
          <div class="col-6 p-0 pl-3">
            <label>City</label>
            <input type="text" v-model="city" placeholder="Chicago">
          </div>
        </div>
        <div class="row mx-0">
          <div class="col-6 p-0 pr-3">
            <label>Postal Code</label>
            <input type="text" v-model="postal_code" placeholder="46020">
          </div>
          <div class="col-6 p-0 pl-3">
            <label>State/Province</label>
            <input type="text" v-model="state" placeholder="Texas">
          </div>
        </div>

      </div>
      <div class="btns pop-btns">
        <button @click="updateSetting" class="btn roboto btn-hover">Save Changes</button>
      </div>
    </div>
  </modal>
</template>

<script>
import CloseIcon from "../icons/CloseIcon.vue";
import vSelect from "vue-select";
import IconBase from "../../common/IconBase.vue";
import IconAngleDown from "../../common/icons/IconAngleDown.vue";
import { countries } from "../../../countries";
import Places from 'vue-places'

export default {
  name: "EditAddressModal",
  props: ["userprofile"],
  components: {
    Places,
    CloseIcon,
    vSelect,
    IconBase,
    IconAngleDown
  },
  data() {
    return {
      language: 'en',
      country: null,
      address: null,
      postal_code: null,
      city: null,
      state: null,
      logged_user_id: null,
      autocomplete: null,
      options: {
        language: 'en'
      }
    };
  },
  mounted() {
    this.country = this.userprofile.country;
    this.address = this.userprofile.address;
    this.city = this.userprofile.city;
    this.postal_code = this.userprofile.postal_code;
  },
  methods: {
    async updateSetting() {
      if (!this.country) {
        this.$toast.warning(" country is required! ");
        return;
      }
      const result = await this.callApi(
        "post",
        window.api_path + "profile/updateProfileSetting",
        {
          country: this.country,
          address: this.address,
          city: this.city,
          postal_code: this.postal_code,
          user_id: localStorage.logged_user_id
        }
      );

      if (result.status != 200) {
        this.$toast.error(result.data.message);
        return;
      }
      this.newCommunityText = "";
      this.$toast.success("Details updated successfully!");
      this.$modal.hide("edit-address-dialog");

      this.$emit("update-setting", result);
    }
  },
  watch: {
    autocomplete: {
      handler (val) {
        if (val.administrative) this.state = val.administrative
        if (val.country) this.country = val.country
        if (val.postcode) this.postal_code = val.postcode
        if (val.city) this.city = val.city
      },
      deep: true
    }
  },
  computed: {
    countriesArr() {
      return Object.keys(countries);
    },
    cities() {
      if (this.city) return countries[this.country];
      return [];
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
  .ap-input-icon {
    display: none;
  }
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
      font-size: 18px;
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

