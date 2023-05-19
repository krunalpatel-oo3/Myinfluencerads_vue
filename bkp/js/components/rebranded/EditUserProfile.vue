<template>
  <div class="profile-rebranded edit-profile-page">
    <loading
      :active.sync="isLoading"
      :can-cancel="false"
      :is-full-page="fullPage"
      background-color="#000"
      color="#202c54"
    ></loading>
    <Header />
    <div class="cover-img">
      
        <button
          @click="$modal.show('change-cover-dialog')"
          class="edit-icon"
          style="top: 20px; right: 40px"
        >
          <EditIcon />
        </button>
        <img :src="userProfile.User.cover_image" alt="" @error="setAltImg"/>
      
    </div>
    <div class="container">
      <div class="profile-wrapper">
        <div class="col-12">
          <div class="avtar-wrapper">
              <div class="avatar-img" style="position: relative">
                <button
                  @click="$modal.show('change-avatar-dialog')"
                  class="edit-icon"
                  style="bottom: -10px; right: -10px"
                >
                  <EditIcon />
                </button>
                <img
                  v-if="userProfile.User.profile_photo != null"
                  class="user-avatar"
                  :src="userProfile.User.profile_photo"
                  alt=""
                  @error="setAltImg"
                />

                <img
                  v-else
                  :src="defaultUserImgUrl"
                  class="user-avatar"
                  alt=""
                />
              </div>
              <div class="u-info">
                <div class="row mx-0">
                  <h3 class="t-34 t-black w400 mb-0">
                    {{ userProfile.User.full_name }}
                  </h3>
                </div>
                <p class="t-19 w300 mb-0">{{ userProfile.User.title }}</p>
                <p class="t-16 w300 mb-0" style="color: rgba(0, 0, 0, 0.73)">
                  {{ userProfile.User.location }}
                </p>
              </div>
          </div>
        </div>
        <!-- <div class="col-md-6">
            <div class="row justify-content-sm-end justify-content-center ">
                <div class="col-lg-4 col-md-5 col-sm-6 col-12 col-6 text-end">
                    <div class="send-invite-btn">
                        <a class="btn btn-secondary font-weight-bold w-100">Send an invite</a>
                    </div> 
                </div>
                <div class="col-lg-6 col-md-7 col-sm-6 col-8">
                  <div class="label-switch">
                    <span>Seller</span>
                    <div class="custom-switch custom-switch-y on-off">
                      <input type="checkbox" class="custom-control-input" id="authenticator1" checked />
                      <label for="authenticator1"></label>
                    </div>
                    <span>Buyer</span>
                  </div>  
                </div>
            </div>
        </div> -->
      </div>
      <div class="navigation">
        <a
          v-for="(t, index) in tabs"
          :key="index"
          :class="t === tab ? 'active-tab' : ''"
          @click="tab = t"
        >{{ t }}</a
        >
      </div>
      <AboutTab
        v-if="tab === 'About'"
        :user-profile="userProfile"
        :edit-category="editCategory"
        :portfolio="portfolio"
        @updateProfile="loadUserProfile"
      />
      <CommunityTab
        v-if="tab === 'Community'"
        :user-profile="userProfile"
      />
      <SystemsTab
        v-if="tab === 'Public Systems'"
        :user-profile="userProfile"
      />
<!--      <PortfolioTab />-->
    </div>
    <!-- <ProfileProjectModal :editcategory="editcategory" style='
        maxHeight: "100%",
        width: "100%",
        placement: "center top"
     '/> -->
    <Footer style="margin-top: 60px" />
  </div>
</template>

<script>
import Header from "../common/Header.vue";
import Footer from "../common/Footer.vue";
import ProfileProjectModal from "./modals/ProfileProjectModal";
import EditIcon from "./icons/EditIcon";
import DeleteIcon from "./icons/DeleteIcon";
import PlusIcon from "./icons/PlusIcon";
import AboutTab from "./profile/AboutTab";
import CommunityTab from "./profile/CommunityTab";
import PortfolioTab from "./profile/PortfolioTab";
import SystemsTab from "./profile/SystemsTab";
import appMixin from "../../appMixin";
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import DatePicker from "vue2-datepicker";
import "vue2-datepicker/index.css";

export default {
  name: "EditUserProfile",
  components: {
    Header,
    Footer,
    Loading,
    ProfileProjectModal,
    EditIcon,
    DeleteIcon,
    PlusIcon,
    DatePicker,
    AboutTab,
    CommunityTab,
    SystemsTab,
    PortfolioTab
  },
  mixins: [appMixin],
  data() {
    return {
      isLoading: false,
      tab: "About",
      tabs: ["About", "Community", "Public Systems", "Portfolio"],
      publicPath: local_image_path,
      logged_user_id: null,
      userProfile: null,
      editCategory: null,
      portfolio: null,
      skills: [],
      defaultUserImgUrl: "",
      coverImageUrl: "",
      projects: [
        { title: "Digital magazine" },
        { title: "UI/UX" },
        { title: "Online Streaming" },
        { title: "Digital Experiences" }
      ],
      fullPage: true
    };
  },
  methods: {
    setAltImg(event) {
      event.target.src = base_url + "images/emptyImg.png";
    },
    async loadUserProfile() {
      this.isLoading = true;
      const result = await this.callApi(
        "get",
        window.api_path + "profile/" + this.logged_user_id + "/getUserProfile"
      );
      console.log("result: ", result);
      if (result.status !== 200) {
        this.$toast.error(result.data.message);
        this.userProfile = [];
        this.isLoading = false;
        if(result.status === 401 && result.data.message == "Token has expired"){
          setTimeout(() => {
            localStorage.removeItem("sgtoken");
            localStorage.removeItem("sgtype");
            localStorage.removeItem("logged_user_id");
            window.location.href = home_url;
          }, 2000);
        }
        return;
      }
      this.userProfile = result.data;
      this.coverImageUrl = result.data.UserCoverPhotoImageProps.image_url
      this.isLoading = false;
    },
    openModal(portfolio) {
      this.portfolio = portfolio;
      //this.$modal.show("ProfileProjectModal");
      this.$FModal.show({
        component: ProfileProjectModal,
        maxHeight: "100%",
        width: "100%",
        placement: "center top"
      }, {
        portfolio: this.portfolio

      });
    },

    edit_portfolio(portfolio) {
      this.portfolio = portfolio;
      this.$modal.show("edit-portfolio-dialog");
    },
    async delete_portfolio(idx) {
      const result = await this.callApi(
        "post",
        window.api_path + "DeletePortfolio",
        {
          user_id: localStorage.logged_user_id,
          id: idx
        }
      );

      if (result.status !== 200) {
        this.$toast.error(result.data.message);
        return;
      }
      this.loaduserProfileList();
      this.$toast.success("portfolio was deleted successfully");
    },

    async update_usertype(user_type) {
      const result = await this.callApi(
        "post",
        window.api_path + "profile/updateUserType",
        {
          user_id: localStorage.logged_user_id,
          user_type: user_type
        }
      );

      if (result.status !== 200) {
        this.$toast.error(result.data.message);
        return;
      }
      //  this.loaduserProfileList();
      this.$toast.success("user type update successfully");
    }
  },
  mounted() {
    this.defaultUserImgUrl = base_url + "images/default-user-avatar-sm.jpg";
    this.logged_user_id = localStorage.getItem("logged_user_id");
    this.loadUserProfile();
  },
  watch: {
    isNormal(val) {
      if (!val) {
        this.update_usertype("pro");
        this.tabs = ["About", "Community", "Public Systems", "Portfolio"];
        this.isPro = true;
      } else {
        this.update_usertype("normal");
        this.tabs = ["About", "Community", "Public Systems"];
        this.isPro = false;
      }
    }
  }
};
</script>

<style>
  .profile-wrapper{
    margin-top:30px;
  }
  .profile-rebranded .navigation a{
    display: inline-block;
    vertical-align: top;
  }
  .edit-profile-page .more .btn-link{
    color:#F2A91C;
  }

  @media all and (max-width:1024px){
    .profile-rebranded .edit-icon svg,
    .profile-rebranded .delete-icon svg {
        width: 14px;
        height: 14px;
    }
    .profile-rebranded .edit-icon, .profile-rebranded .delete-icon{
      width: 30px;
      height: 30px;
      padding:0;
    }
    .avatar-img .edit-icon {
      bottom: 10px !important;
      right: -5px !important;
    }

    .profile-rebranded .navigation a{
      padding-bottom: 6px;
      font-size: 20px;
    }
    .sub-title[data-v-cc868c56]{
      font-size: 20px !important;
    }
    .education p{
      font-size: 16px;
      line-height: 26px;
    }
    .u-info h3 {
      font-size: 24px;
    }
    .u-info .t-19 {
      font-size: 16px !important;
      margin-top: 5px;
    }
  }

  @media all and (max-width:767px){
    .profile-rebranded .navigation{
      display: block;
      white-space: nowrap;
      -webkit-overflow-scrolling: touch;
      -ms-overflow-style: -ms-autohiding-scrollbar;
      overflow-x: auto;
    }
    .profile-rebranded .navigation a{
      margin-right: 40px;
      font-size: 18px;
    }
  }

  @media all and (max-width:575px){
    .avatar-img {
      width: 90px;
      height: 90px;
    }
    .profile-rebranded .user-avatar {
      height: 100%;
      width: 100%;
    }
    .avtar-wrapper .u-info {
      width: calc(100% - 130px);
    }
    .profile-rebranded .navigation{
      margin-top: 20px;
    }
    .cover-img .edit-icon{
      right: 20px !important;
    }
  }

  @media all and (max-width:480px){
    .avtar-wrapper {
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
    }
    .avtar-wrapper .u-info > .row {
      -webkit-box-pack: center;
      -ms-flex-pack: center;
      justify-content: center;
      margin: 10px 0;
    }
    .avtar-wrapper .u-info {
      width: 100%;
      text-align: center;
      margin-left: 0;
    }
  }
</style>