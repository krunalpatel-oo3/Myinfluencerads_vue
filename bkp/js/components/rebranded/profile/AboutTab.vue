<template>
  <div>
    <div class="about-section">
      <div class="row">
        <div class="col-lg-8 col-md-7 col-12">
          <div class="about-sec-left">
            <div class="main-info" style="border-bottom: 1px solid #d2d5dd">
              <div class="d-flex justify-content-between ">
                <h2 class="mb-0 t-22 w500">{{ userProfile.User.title }}</h2>
                <div class="row align-items-center">
                  <p class="w500 t-22 mb-0" style="margin-right: 20px">
                    ${{ userProfile.User.hourly_rate }}/hr
                  </p>
                  <button
                    @click="$modal.show('edit-about-dialog')"
                    class="edit-icon ml-auto"
                    style="position: relative;"
                  >
                    <EditIcon />
                  </button>
                </div>
              </div>
              <p class="about-desc">
                {{ userProfile.User.description }}
              </p>
            </div>
            <div class="additional-info" style="border-bottom: 1px solid #d2d5dd">
              <h2 class="mb-0 t-22 w500 lh-36">Skills</h2>
              <div v-for="(category, index) in userProfile.categories" :key="index">
                <div class="row mx-0">
                  <div class="w-100">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-left">
                          <h4 class="mb-0 t-18 w500 lh-54">{{ category.title }}</h4>
                        </div>
                        <div class="d-right">
                            <button
                              @click="edit_category(category)"
                              class="edit-icon"
                              style="position: relative; margin-left: 15px"
                            >
                              <EditIcon />
                            </button>
                            <button
                              @click="delete_skill(category)"
                              class="edit-icon"
                              style="position: relative; margin-left: 11px"
                            >
                              <DeleteIcon />
                            </button>
                        </div>
                    </div>
                  </div>  
                </div>
                <div class="row mx-0">
                  <button v-for="(skill, index) in category.skills" :key="index" class="skill">
                    + {{ skill.title }}
                  </button>
                </div>
              </div>
              <button @click="$modal.show('add-skills-dialog')" class="add-btn">
                <PlusIcon style="margin-right: 5px" />
                Add a category
              </button>
            </div>

            <div class="additional-info">
              <h2 class="mb-0 t-22 w500 lh-36">Services</h2>
              <div class="custom-checkbox-group mt-3">
                <label class="custom-checkbox custom-checkbox-dark">
                  <input v-if="userProfile.User.services != null && userProfile.User.services.split(',').includes('on-site')" checked type="checkbox" value="on-site" id="on-site" @change="changeServices($event)">
                  <input v-else type="checkbox" value="on-site" id="on-site" @change="changeServices($event)">
                  <span>On-site event streaming</span>
                </label>
              </div>
              <div class="custom-checkbox-group">
                <label class="custom-checkbox custom-checkbox-dark">
                  <input v-if="userProfile.User.services != null && userProfile.User.services.split(',').includes('remote-production')" checked type="checkbox" value="remote-production" id="remote-production" @change="changeServices($event)">
                  <input v-else type="checkbox" value="remote-production" id="remote-production" @change="changeServices($event)">
                  <span>Remote Production</span>
                </label>
              </div>
              <div class="custom-checkbox-group">
                <label class="custom-checkbox custom-checkbox-dark">
                  <input v-if="userProfile.User.services != null && userProfile.User.services.split(',').includes('post-production')" checked type="checkbox" value="post-production" id="post-production" @change="changeServices($event)">
                  <input v-else type="checkbox" value="post-production" id="post-production" @change="changeServices($event)">
                  <span>Post production</span>
                </label>
              </div>
              <div class="custom-checkbox-group">
                <label class="custom-checkbox custom-checkbox-dark">
                  <input v-if="userProfile.User.services != null && userProfile.User.services.split(',').includes('consulting')" checked type="checkbox" value="consulting" id="consulting" @change="changeServices($event)">
                  <input v-else type="checkbox" value="consulting" id="consulting" @change="changeServices($event)">
                  <span>Consulting</span>
                </label>
              </div>
              <div class="custom-checkbox-group">
                <label class="custom-checkbox custom-checkbox-dark">
                  <input v-if="userProfile.User.services != null && userProfile.User.services.split(',').includes('video-production')" checked type="checkbox" value="video-production" id="video-production" @change="changeServices($event)">
                  <input v-else type="checkbox" value="video-production" id="video-production" @change="changeServices($event)">
                  <span>Video Production</span>
                </label>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-5 col-12 sticky-col">
          <div class="about-sec-right">
            <!-- <div class="review">
                <div class="review-upper">
                  <div class="ru-left">
                    <span class="sub-title">
                      10,694 Reviews
                    </span>
                    <span class="review-star">
                      <RatingStar class="rating-star" :fill="'#FB8200'" />
                      <RatingStar class="rating-star" :fill="'#FB8200'" />
                      <RatingStar class="rating-star" :fill="'#FB8200'" />
                      <RatingStar class="rating-star" :fill="'#FB8200'" />
                      <RatingStar class="rating-star" :fill="'#FB8200'" />
                    </span>
                    <span class="review-count">
                      4.7
                    </span>
                  </div>
                </div>
                <div class="review-lower">
                  <ProgressBar />
                </div>
            </div>
            <div class="bussiness">
                <div class="sub-title">
                    4+ years in business
                </div>
                <div class="bus-desc">
                    <ul class="bus-list list-unstyled">
                        <li>
                          <div class="bl-upper">
                            $100k+
                          </div>
                          <div class="bl-lower">
                            Total Earnings
                          </div>
                        </li>
                        <li>
                          <div class="bl-upper">
                           5
                          </div>
                          <div class="bl-lower">
                            Total Jobs
                          </div>
                        </li>
                        <li>
                          <div class="bl-upper">
                            4429
                          </div>
                          <div class="bl-lower">
                            Total Hours
                          </div>
                        </li>
                    </ul>
                </div>
            </div> -->
            <div class="education">
              <div class="d-flex align-items-center justify-content-between">
                <p v-if="userProfile.User.school != null" class="sub-title">
                  {{ userProfile.User.school }}
                </p>
                <p v-else class="sub-title">Education</p>
                <button
                  @click="$modal.show('edit-education-dialog')"
                  class="edit-icon"
                  style="
                      position: relative;
                      
                      margin-left: 15px;
                    "
                >
                  <EditIcon />
                </button>
              </div>
              <p class="t-18 lh-30 w400 mb-0">
                {{
                  momentDatetime(
                    userProfile.User.school_start_date,
                    getJsMomentDateFormat()
                  )
                }} - {{
                  momentDatetime(
                    userProfile.User.school_end_date,
                    getJsMomentDateFormat()
                  )
                }}
              </p>
              <p class="t-18 lh-30 w400 mb-0">
                {{ userProfile.User.degree }}, {{ userProfile.User.area_study }}
              </p>
            </div>
            <div class="d-flex align-items-center justify-content-between">
              <h2 class="sub-title" style="margin-top: 16px">
                Languages
              </h2>
              <button
                @click="$modal.show('edit-lang-dialog')"
                class="edit-icon"
                style="position: relative; margin-left: 15px"
              >
                <EditIcon />
              </button>
            </div>
            <div class="lang-sec">
              <span class="t-18 w500" style="margin-top: 10px" v-for="(lang, index) in userProfile.userlanguage" :key="index">
                     {{ lang.text }}<span v-if="userProfile.userlanguage.length !== index+1">,</span>
                     </span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <EditAboutModal
      :userProfile="userProfile"
      @updateAbout="$emit('updateProfile')"
    />
    <ProjectDescriptionModal
      :portfolio="userProfile.portfolio"
      @update-portfolio="updateAbout"
    />
    <EditPortfolioProjectModal
      :portfolio="portfolio"
      @update-portfolio="updateAbout"
    />
    <EditEducationModal
      :userProfile="userProfile.User"
      @update-education="$emit('updateProfile')"
    />
    <EditSkillsModal
      :editcategory="editCategory"
      @update-skill="$emit('updateProfile')"
    />
    <SendInviteModal />
    <EditLanguagesModal
      :userlanguage="userProfile.userlanguage"
      @update-language="$emit('updateProfile')"
    />
    <AddSkillsModal
      :userProfile="userProfile.User"
      @update-skill="$emit('updateProfile')"
    />
    <ChangeAvatarModal
      :userProfile="userProfile.User"
      @update-image="$emit('updateProfile')"
    />
    <ChangeCoverImageModal @update-cover="$emit('updateProfile')" />
  </div>
</template>

<script>
import EditAboutModal from "../modals/EditAboutModal";
import ProjectDescriptionModal from "../modals/ProjectDescriptionModal";
import EditEducationModal from "../modals/EditEducationModal";
import EditPortfolioProjectModal from "../modals/EditPortfolioProjectModal";
import EditSkillsModal from "../modals/EditSkillsModal";
import SendInviteModal from "../modals/SendInviteModal";
import AddSkillsModal from "../modals/AddSkillsModal";
import EditLanguagesModal from "../modals/EditLanguagesModal";
import ChangeAvatarModal from "../modals/ChangeAvatarModal";
import ChangeCoverImageModal from "../modals/ChangeCoverImageModal";
import EditIcon from "../icons/EditIcon";
import DeleteIcon from "../icons/DeleteIcon";
import PlusIcon from "../icons/PlusIcon";
import appMixin from "../../../appMixin";
import RatingStar from "../icons/RatingStar";
import ProgressBar from "../../ProgressBar"

export default {
  name: "AboutTab",
  props: {
    userProfile: {
      type: Object,
      required: true
    },
    editCategory: {
      required: true
    },
    portfolio: {
      required: true
    }
  },
  mixins: [appMixin],
  data() {
    return {
      services: {
        onSite: "",
        remoteProduction: "",
        postProduction: "",
      }
    };
  },
  components: {
    EditAboutModal,
    ProjectDescriptionModal,
    EditEducationModal,
    EditPortfolioProjectModal,
    EditSkillsModal,
    SendInviteModal,
    AddSkillsModal,
    EditLanguagesModal,
    ChangeAvatarModal,
    ChangeCoverImageModal,
    EditIcon,
    DeleteIcon,
    PlusIcon,
    RatingStar,
    ProgressBar
  },
  methods: {
    updateAbout() {
      // this.editCategory = category;
      // this.$modal.show("edit-skills-dialog");
    },
    edit_category(category) {
      this.editCategory = category;
      this.$modal.show("edit-skills-dialog");
    },
    async delete_skill(idx) {
      const result = await this.callApi(
        "post",
        window.api_path + "profile/deleteUserCategory",
        {
          user_id: localStorage.logged_user_id,
          category: idx.category_id
        }
      );

      if (result.status !== 200) {
        this.$toast.error(result.data.message);
        return;
      }
      this.$emit('updateProfile');
      this.$toast.success("Category was deleted successfully");
    },
    async changeServices(e){
      const result = await this.callApi(
        "post",
        window.api_path + "profile/addUpdateServices",
        {
          service_name: e.target.value,
          is_checked: e.target.checked
        }
      );

      if (!result.data.status) {
        this.$toast.error(result.data.message);
        return;
      }else{
        this.$emit('updateProfile');
        this.$toast.success(result.data.message);
      }
    }
  }
};
</script>

<style scoped>
  .sub-title{
    font-weight: 500 !important;
    font-size: 22px !important;
    line-height: 36px !important;
    margin-bottom:8px !important;
  }
  .education p {
    font-weight: 400;
    font-size: 18px;
    line-height: 30px;
  }
  .bussiness {
    margin-bottom: 16px;
  }
  .bus-list{
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -ms-flex-wrap:wrap;
    flex-wrap:wrap;
    -webkit-box-pack: justify;
    -ms-flex-pack: justify;
    justify-content: space-between;
  }
  .bus-list li{
    width:33.33%;
    padding-right: 10px;
    font-size: 15px;
    line-height: 21px;
    color: #000;
  }
  .bl-upper {
    font-weight: 500;
    font-size: 18px;
    line-height: 21px;
  }
  .bus-list li:last-child {
    padding-right: 0;
  }
  .sticky-col{
    position: sticky;
    top: 20px;
    -ms-flex-item-align: start;
    align-self: flex-start;
  }
  .review-upper .ru-left {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: justify;
    -ms-flex-pack: justify;
    justify-content: space-between;
  }
  .review-star svg {
    width: 20px;
    height: 20px;
  }
  .review-upper .ru-left .sub-title {
    margin-bottom: 0 !important;
  }
  .review-count {
    font-weight: 500;
    font-size: 24px;
    line-height: 54px;
  }
  .bussiness .sub-title {
    margin-bottom: 20px !important;
  }
  .about-sec-left {
    padding-right: 40px;
  }
  .about-sec-right {
      padding-left: 40px;
  }
  .about-desc {
    font-size: 16px;
    line-height: 24px;
    margin-bottom:30px;
    margin-top:15px;
  }
  .add-btn{
    margin-bottom: 25px;
  }

  @media all and (max-width:991px){
    .education p{
      font-size: 16px;
      line-height: 24px;
    }
    .about-sec-left {
      padding-right: 20px;
    }
    .about-sec-right {
        padding-left: 20px;
    }
    .profile-rebranded .skill{
      margin-bottom: 19px;
    }
  }

  @media all and (max-width:767px){
    .about-sec-right,
    .about-sec-left{
      padding:0 10px;
    }
    .about-sec-right {
      margin-top: 15px;
      padding-top: 15px !important;
      border-top: 1px solid rgb(210, 213, 221);
    }
  }
</style>