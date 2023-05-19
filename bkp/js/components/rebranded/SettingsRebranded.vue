<template>
  <div class="settings-rebranded">
    <Header />
    <div class="cover-img">
      <img :src="userprofile.cover_image" alt="" @error="setAltImg" >
    </div>
    <div class="container">
      <div class="d-flex flex-wrap">
        <div class="avatar-cont">
          <img class="user-avatar" :src="userprofile.profile_photo" @error="setAltImg" >
        </div>
        <div style="margin-left: 43px; margin-top: 16px;">
          <h4 class="mb-0 t-34 w500">Settings</h4>
          <p class="t-18 lh-23 t-color2 mb-0" style="margin-top: 5px"> {{userprofile.login}}</p>
        </div>
      </div>
    </div>

    <!-- Navigation -->
    <div class="d-flex flex-wrap navigation">
      
      <a
        v-for="(t, index) in tabs"
        :class="t === tab ? 'active-tab' : ''"
        @click="tab = t"
        :key="index"
      >
        {{ t }}
      </a>
    </div>

    <!-- Settings Tabs -->
    <GeneralTab
      v-if="tab === 'General'"
      :user-profile="userprofile"
    />
    <LocationTab
      v-if="tab === 'Location'"
      :user-profile="userprofile"
    />
    <PlanTab v-if="tab === 'Plan'"/>
    <NotificationsTab v-if="tab === 'Notifications'" />

    <Footer style="margin-top: 60px" />

    <!-- Modals -->
    <EditFullNameModal  :userprofile="userprofile"  @update-setting="updateSetting" />
    <EditTimeZoneModal :userprofile="userprofile"  @update-setting="updateSetting"/>
    <EditPhoneModal :userprofile="userprofile"  @update-setting="updateSetting"/>
    <EditAddressModal :userprofile="userprofile"  @update-setting="updateSetting"/>
    <EditEmailModal :userprofile="userprofile"  @update-setting="updateSetting"/>
    <EditPasswordModal :userprofile="userprofile"  @update-setting="updateSetting"/>
  </div>
</template>

<script>
import Header from "../common/Header.vue";
import Footer from "../common/Footer.vue";
import EditSettingsIcon from "./icons/EditSettingsIcon";
import EditFullNameModal from "./modals/EditFullNameModal";
import EditTimeZoneModal from "./modals/EditTimeZoneModal";
import AddPaymentModal from "./modals/AddPaymentModal";
import EditPhoneModal from "./modals/EditPhoneModal";
import EditAddressModal from "./modals/EditAddressModal";
import EditEmailModal from "./modals/EditEmailModal";
import EditPasswordModal from "./modals/EditPasswordModal";
import PlanTab from "./settings/PlanTab";
import NotificationsTab from "./settings/NotificationsTab";
import LocationTab from "./settings/LocationTab";
import GeneralTab from "./settings/GeneralTab";

import Vue from "vue";
import vSelect from "vue-select";

Vue.component("v-select", vSelect);
import "vue-select/dist/vue-select.css";

export default {
  name: "Settings",
  components: {
    Header,
    Footer,
    EditSettingsIcon,
    EditFullNameModal,
    EditTimeZoneModal,
    AddPaymentModal,
    EditAddressModal,
    EditPhoneModal,
    EditEmailModal,
    EditPasswordModal,
    PlanTab,
    NotificationsTab,
    LocationTab,
    GeneralTab
  },
  data() {
    return {
      userprofile:null,
      UserProfilePhotoImageProps:null,
      UserCoverPhotoImageProps:null,
      tab: "General",
      tabs: ["General", "Location", "Plan", "Notifications"],
      publicPath: local_image_path,
      authenticator: false,
    };
  },
  mounted() {
    this.logged_user_id = localStorage.getItem("logged_user_id");
    this.loaduserProfileList();
 },
  methods: {
    setAltImg(event) {
      event.target.src = base_url + "images/emptyImg.png";
    },
    updateSetting(e){
       this.loaduserProfileList();
    },
    async loaduserProfileList() {
      const result = await this.callApi(
        "get",
        window.api_path +'profile/'+this.logged_user_id+ "/getUserProfile"
      );
      if (result.status !== 200) {
        this.$toast.error(result.data.message);
        this.userprofile = [];
        return;
      }
      this.userprofile = result.data.User;
      this.UserProfilePhotoImageProps = result.data.UserProfilePhotoImageProps;
      this.UserCoverPhotoImageProps = result.data.UserCoverPhotoImageProps;
    },
    openModal() {
      this.$FModal.show(
        {
          component: ProfileProjectModal,
          maxHeight: "100%",
          width: "100%",
          placement: "center top"
        }
      );
    },
  }
};
</script>
