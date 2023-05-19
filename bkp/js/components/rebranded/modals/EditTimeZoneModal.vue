<template>
  <modal
    name="edit-timezone-dialog"
    :width="824"
    height="auto"
    :scrollable="true"
    :adaptive="true"
    transition=""
    class="section-modal edit-timezone-modal"
  >
    <div
      class="modal-close"
      @click="$modal.hide('edit-timezone-dialog')"
    >
      <CloseIcon />
    </div>
    <div class="row">
      <h2 class="w700 poppins t-33 title-modal" style="margin-bottom: 17px">Change Time Zone</h2>
      <div class="col-12 timezone-select-col pop-modal-body">
        <label>Time Zone</label>
        <v-select
          v-model="timezone"
          label="label"
          code="code"
          item-text="label"
          :options="timezones"
          :clearable="false"
          class="form-control v-select-light timezone-select"
          placeholder="Select option"
        >
          <template #open-indicator="{ attributes }">
            <span v-bind="attributes">
              <icon-base
                width="12"
                height="6.84"
                view-box="0 0 12 6.84"
                icon-name="angle-down"
              >
                <icon-angle-down />
              </icon-base>
            </span></template
          >
        </v-select>
      </div>
      <div class="btns pop-btns" style="margin-top: 30px">
        <button @click="updateSetting" class="btn roboto btn-hover">Save Changes</button>
      </div>
    </div>
  </modal>
</template>

<script>
import CloseIcon from "../icons/CloseIcon.vue";
import IconBase from "../../common/IconBase";
import IconAngleDown from "../../common/icons/IconAngleDown.vue";

export default {
  name: "EditTimeZoneModal",
  props: ["userprofile"],
  components: {
    CloseIcon,
    IconBase,
    IconAngleDown
  },
  data() {
    return {
      timezone: null,
      logged_user_id: null,
      timezones: [
        "GMT	Greenwich Mean Time	GMT",
        "UTC	Universal Coordinated Time	GMT",
        "ECT	European Central Time	GMT+1:00",
        "EET	Eastern European Time	GMT+2:00",
        "ART	(Arabic) Egypt Standard Time	GMT+2:00",
        "EAT	Eastern African Time	GMT+3:00",
        "MET	Middle East Time	GMT+3:30",
        "NET	Near East Time	GMT+4:00",
        "PLT	Pakistan Lahore Time	GMT+5:00",
        "IST	India Standard Time	GMT+5:30",
        "BST	Bangladesh Standard Time	GMT+6:00",
        "VST	Vietnam Standard Time	GMT+7:00",
        "CTT	China Taiwan Time	GMT+8:00",
        "JST	Japan Standard Time	GMT+9:00",
        "ACT	Australia Central Time	GMT+9:30",
        "AET	Australia Eastern Time	GMT+10:00",
        "SST	Solomon Standard Time	GMT+11:00",
        "NST	New Zealand Standard Time	GMT+12:00",
        "MIT	Midway Islands Time	GMT-11:00",
        "HST	Hawaii Standard Time	GMT-10:00",
        "AST	Alaska Standard Time	GMT-9:00",
        "PST	Pacific Standard Time	GMT-8:00",
        "PNT	Phoenix Standard Time	GMT-7:00",
        "MST	Mountain Standard Time	GMT-7:00",
        "CST	Central Standard Time	GMT-6:00",
        "EST	Eastern Standard Time	GMT-5:00",
        "IET	Indiana Eastern Standard Time	GMT-5:00",
        "PRT	Puerto Rico and US Virgin Islands Time	GMT-4:00",
        "CNT	Canada Newfoundland Time	GMT-3:30",
        "AGT	Argentina Standard Time	GMT-3:00",
        "BET	Brazil Eastern Time	GMT-3:00",
        "CAT	Central African Time	GMT-1:00"
      ]
    };
  },
  mounted() {
    this.timezone = this.userprofile.timezone;
  },
  methods: {
    async updateSetting() {
      if (!this.timezone) {
        this.$toast.warning(" timezone is required! ");
        return;
      }
      const result = await this.callApi(
        "post",
        window.api_path + "profile/updateProfileSetting",
        {
          timezone: this.timezone,

          user_id: localStorage.logged_user_id
        }
      );
      if (result.status != 200) {
        this.$toast.error(result.data.message);
        return;
      }
      this.newCommunityText = "";
      this.$toast.success("Details updated successfully!");
      this.$modal.hide("edit-timezone-dialog");

      this.$emit("update-setting", result);
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

