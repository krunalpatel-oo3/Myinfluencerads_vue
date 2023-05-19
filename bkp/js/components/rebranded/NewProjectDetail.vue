<template>
  <div class="system-page">
    <Header />
    <img class="wave-bg" :src="`${publicPath}wave-upload.png`" alt="">
    <img class="semi-circle-bg" :src="`${publicPath}semi-circle-bg.png`">
    <div v-if="isLoading" class="container skeleton"></div>
    <div v-else class="container detail-wrapper">
      <div class="row mx-0">
        <div class="col-md-8">
          <div class="row mx-0 dw-left">
            <h1 class="t-black t-36 w700" style="margin-top: 30px; margin-bottom: 10px">{{ projectData.name }}</h1>
            <div @click="addVote" :class="projectData.is_already_voted ? 'like-tag like-tag-active' : 'like-tag'">
              <ThumbsUp :fill="'#F2A91C'" :width="20" :height="20" style="margin-right: 5px; margin-top: -2px;" />
              <span>{{ user_project_votes_count || 0 }}</span>
            </div>
          </div>
          <router-link to="" class="t-color1 t-24 w600 category-link" style="margin-top: 5.5px">
            {{ projectData.categoryname ? projectData.categoryname : "" }}
          </router-link>
          <p class="t-18 t-color2" style="margin-top: 10px">{{ projectData.short_desc }}</p>
        </div>
        <div class="col-md-4">
          <div class="row dw-right w-100 d-flex justify-content-end align-items-start h-100">
            <div class="user-info" style="margin-top: 30px">
              <div v-if="projectData.creator" class="row align-items-center mb-3">
                <img style="border-radius: 50%" :src="projectData.creator.profile_photo || defaultUserImgUrl"
                     width="60px" height="60px" alt="">
                <router-link :to="{
                      name: 'userprofile',
                      params: { slug: projectData.creator ? projectData.creator.id : '' }
                   }" class="w600 t-18 t-black my-0 link-hover" style="margin-left: 12px"
                             v-if="projectData.creator && projectData.creator.full_name">
                  {{ projectData.creator ? projectData.creator.full_name : '' }}
                </router-link>
              </div>
              <div>
                <p class="t-16 t-black w300 mb-0 w-100">{{ projectData.creator ? projectData.creator.title : '' }}</p>
                <p class="t-14 t-color9 w-100 mb-1">{{ projectData.creator ? projectData.creator.location : '' }}</p>
                <button class="contact-project-btn">Contact about project</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="project-gallery" style="margin-top: 13px;">
        <div class="project-gallery-top">
          <swiper class="swiper" :options="swiperOptionTop" ref="swiperTop">
            <swiper-slide
              v-for="(imgpath, index) in projectImage"
               :key="index"
              v-if="imgpath.filename"
            >
              <img :src="imgpath.filename" style="max-height: 462px; object-fit: cover" @error="setAltProImg" />
              <div class="budget-badge">
                <span class="budget-text">Budget:</span> 
                <span class="budget-price">$ {{ projectData.estimated_budget }}</span>
              </div>
            </swiper-slide>
            <swiper-slide v-if="projectData.link_youtube != 'null' && projectData.link_youtube != null">
              <iframe width="100%" :src="`https://www.youtube.com/embed/${getEmbed(
                      projectData.link_youtube
                    )}`" frameborder="0" style="min-height: 400px" allowfullscreen></iframe>
            </swiper-slide>
            <div class="swiper-btn-prev" slot="button-prev">
              <icon-base
                width="16.54"
                height="28"
                view-box="0 0 16.54 28"
                icon-name="angle-right-2"
              >
                <icon-angle-right-2 />
              </icon-base>
            </div>
            <div class="swiper-btn-next" slot="button-next">
              <icon-base
                width="16.54"
                height="28"
                view-box="0 0 16.54 28"
                icon-name="angle-right-2"
              >
                <icon-angle-right-2 />
              </icon-base>
            </div>
          </swiper>
        </div>
        <div class="project-gallery-thumbs">
          <swiper
            class="swiper gallery-thumbs"
            :options="swiperOptionThumbs"
            ref="swiperThumbs"
          >
            <swiper-slide
              v-for="(imgpath, index) in projectImage"
              :key="index"

              v-if="imgpath.filename"
            ><img :src="imgpath.filename" @error="setAltProImg" /></swiper-slide>
            <swiper-slide v-if="projectData.link_youtube != 'null' && projectData.link_youtube != null">
              <img
                :src="getYoutubeImg(`${projectData.link_youtube}`)"
                alt="">
            </swiper-slide>
          </swiper>
        </div>
      </div>

      <div class="row equipments">
        <h2 class="w500 t-20 t-black roboto">Part List</h2>
        <div class="table-responsive custom-table">
          <table class="table table-align-middle">
            <thead>
            <tr>
              <th scope="col" class="text-center">QTY</th>
              <th scope="col" class="th-product-name">Product name</th>
              <th scope="col">Description</th>
              <th scope="col" class="text-center">Manufacturer</th>
              <th scope="col" class="text-center">Price</th>
              <th scope="col" class="text-center">Shop</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(project,key) in projectProducts" :key="key">
              <td class="text-center w700">{{ project.qty }}</td>
              <td>
                <div class="d-flex align-items-center">
                  <img
                    :src="`${publicPath}camera_360.png`"
                    alt=""
                    class="rounded-circle width-32 mr-2"
                  />
                  <div class="text-nowrap flex-grow-1">{{ project.product.name ? project.product.name.substring(0, 20) : '' }}</div>
                </div>
              </td>
              <td v-html="project.product.desc ? project.product.desc.substring(0, 50) : ''"></td>
              <td class="text-center" v-html="project.product.manufacturer ? project.product.manufacturer.substring(0, 50) : ''"></td>
              <td class="text-center" v-html="project.product.price"></td>
              <td class="text-center">
                <a target="_blank" v-bind:href="project.product.link" class="btn btn-xs btn-link">
                  <icon-base
                    width="20"
                    height="17.58"
                    view-box="0 0 20 17.58"
                    icon-name="shopping-cart"
                  >
                    <icon-shopping-cart />
                  </icon-base>
                </a>
              </td>
            </tr>
  
            <tr v-for="(pr,key) in projectCustomLines" :key="key">
              <td class="text-center w700">{{ pr.qty }}</td>
              <td>
                <div class="d-flex align-items-center">
                  <img
                    :src="pr.filename || `${publicPath}camera_360.png`"
                    alt=""
                    class="rounded-circle width-32 mr-2"
                  />
                  <div class="text-nowrap flex-grow-1">{{ pr.name ? pr.name.substring(0, 20) : '' }}</div>
                </div>
              </td>
              <td v-html="pr.description ? pr.description.substring(0, 50) : ''"></td>
              <td class="text-center" v-html="pr.description ? pr.description.substring(0, 50) : ''"></td>
              <td class="text-center">{{ pr.price }}K</td>
              <td class="text-center">
                <a target="_blank" :href="pr.link" class="btn btn-xs btn-link">
                  <icon-base
                    width="20"
                    height="17.58"
                    view-box="0 0 20 17.58"
                    icon-name="shopping-cart"
                  >
                    <icon-shopping-cart />
                  </icon-base>
                </a>
              </td>
            </tr>
            <tr v-for="(pr,key) in projectData.productselect" :key="key">
              <td class="text-center w700">{{ pr.qty }}</td>
              <td>
                <div class="d-flex align-items-center">
                  <img
                    :src="`${publicPath}camera_360.png`"
                    alt=""
                    class="rounded-circle width-32 mr-2"
                  />
                  <div class="text-nowrap flex-grow-1">{{ pr.text ? pr.text.substring(0, 20) : '' }}</div>
                </div>
              </td>
              <td v-html="pr.description ? pr.description.substring(0, 50) : ''"></td>
              <td class="text-center" v-html="pr.description ? pr.description.substring(0, 50) : ''"></td>
              <td class="text-center">{{ pr.price || '' }}</td>
              <td class="text-center" v-if="pr.link">
                <a target="_blank" :href="pr.link" class="btn btn-xs btn-link">
                  <icon-base
                    width="20"
                    height="17.58"
                    view-box="0 0 20 17.58"
                    icon-name="shopping-cart"
                  >
                    <icon-shopping-cart />
                  </icon-base>
                </a>
              </td>
            </tr>
            <tr v-if="projectCustomLines.length > 0">
              <td colspan="3" class="text-center">Design & Built by: {{ projectCompany[0].company_name }} (<a :href="projectCompany[0].company_url" target="_blank">{{ projectCompany[0].company_url }}</a>)</td>
              <td class="text-center">Total:</td>
              <td class="text-center">{{ projectPriceTotalCount }}K</td>
              <td></td>
            </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="stage-section">
        <h4 class="w500 t-20 roboto mb-3">Project Stage:</h4>
        <div class="project-stage-wrapper">
          <div class="custom-project-stage active" v-if="projectData.project_phase === 'P'">
            <p>Planning</p>
          </div>
          <div class="custom-project-stage" v-else>
            <p>Planning</p>
          </div>
          <div class="project-stage-icon">
            <svg width="26" height="30" viewBox="0 0 26 30" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M1.5 2.00962L24 15L1.5 27.9904L1.5 2.00962Z" fill="#F2A91C" stroke="#202C54" stroke-width="2"/>
            </svg>
          </div>
          <div class="custom-project-stage custom-project-stage-progress active" v-if="projectData.project_phase === 'IP'">
            <p>In-Progress</p>
          </div>
          <div class="custom-project-stage custom-project-stage-progress" v-else>
            <p>In-Progress</p>
          </div>
          <div class="project-stage-icon">
            <svg width="26" height="30" viewBox="0 0 26 30" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M1.5 2.00962L24 15L1.5 27.9904L1.5 2.00962Z" fill="#F2A91C" stroke="#202C54" stroke-width="2"/>
            </svg>
          </div>
          <div class="custom-project-stage custom-project-stage-complete active" v-if="projectData.project_phase === 'C'">
            <p>Complete</p>
          </div>
          <div class="custom-project-stage custom-project-stage-complete" v-else>
            <p>Complete</p>
          </div>
        </div>
      </div>
      <div class="description-section">
        <h4 class="w500 t-20 roboto w500">Introduction</h4>
        <div v-html="projectData.desc"></div>
      </div>
      <div class="project-desc-block">
        <div class="row">
          <div class="col-md-6">
            <div class="pdb-sec" v-if="projectData.project_goals != null">
              <div class="pbd-title">
                <strong>
                  Project Goals
                </strong>
              </div>
              <div v-if="projectData.project_goals != 'null'" v-html="projectData.project_goals" class="pdb-list"></div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="pdb-sec" v-if="projectData.service_upgrade_request != null">
              <div class="pbd-title">
                <strong>
                  Service/ Upgrade Requests
                </strong>
              </div>
              <div v-if="projectData.service_upgrade_request != 'null'" v-html="projectData.service_upgrade_request" class="pdb-list"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="media-section">
        <div class="row mx-0">
          <div class="col-md-5">
            <p class="t-20 w700">Documents</p>
            <div class="row mx-0">
              <div class="doc" v-for="(pdf,key) in projectPdf" :key="key"
                   v-if="pdf.filename != null">
                <a target="_blank" v-bind:href="pdf.filename">
                  <div class="doc-icon">
                    <img :src="`${publicPath}pdf_icon.png`" alt="">
                  </div>
                  <p class="t-18 t-color2 mt-2 doc-link">{{ pdf.info || 'Document' }}</p>
                </a>
              </div>
            </div>
          </div>
          <div class="col-md-7">
            <p class="t-20 w700">Videos</p>
            <div class="video-row row mx-0" v-if="projectData.link_youtube !== null && projectData.link_youtube !== 'null'">
              <iframe width="315" height="178" :src="`https://www.youtube.com/embed/${getEmbed(projectData.link_youtube)}`"
                      title="YouTube video player" frameborder="0"
                      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                      allowfullscreen></iframe>
            </div>
          </div>
        </div>
      </div>
      <div v-if="projectData.link_url !== 'null'" class="website-section">
        <h4 class="t-20 roboto w700 mb-2">Website Link</h4>
        <a class="website-link" target="_blank" v-bind:href="projectData.link_url">{{ projectData.link_url }}</a>
      </div>
      <div class="comments-section">
        <h2 class="w700 t-20 roboto w100">Comments</h2>
        <div class="row mx-0 comment" v-for="projectComment in projectData.reviews" :key="projectComment.id">
          <img :src="projectComment.user.profile_photo || defaultUserImgUrl"
               :alt="defaultUserImgUrl">
          <div style="margin-left: 15px">
            <strong>{{ projectComment.user ? projectComment.user.full_name : '' }}</strong>
            <p 
              class="t-color2 t-18 mb-0 text-break"
              v-html="projectComment.description"
              v-linkified >
            </p>
          </div>
        </div>
        <p class="t-18 text-black mb-0 mt-5">Leave a comment</p>
        <textarea v-model="commentText" placeholder="Write a comment" ref="commentText"></textarea>
        <button class="leave-comment" :disabled="postingComment" @click="addComment">
          <div v-if="postingComment" class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
          </div>
          <span v-else>Post comment</span>
        </button>
      </div>
    </div>
    <div v-if="!isLoading && relatedProjects.length" class="container" style="margin-top: 80px">
      <h4 class="t-42 w700 text-white mb-4">Related Projects</h4>
      <div class="row mx-0 project-grid">
        <div v-for="(project, i) in relatedProjects" :key="i" class="col-lg-3 col-sm-6 col-xs-12 mb-3">
          <SystemCard
            :name="project.name"
            :user_photo="project.creator.profile_photo"
            :creator_id="project.creator.id"
            :image_link="project.projectImagePropsArray.image_url"
            :description="project.desc"
            :slug="project.slug"
            :category="project.categoryname"
          />
        </div>
      </div>
    </div>
    <Footer style="margin-top: 138px" />
  </div>
</template>

<script>
import Vue from 'vue';
import Header from "../common/Header.vue";
import Footer from "../common/Footer.vue";
import IconStars from "../common/icons/IconStars.vue";
import IconBase from "../common/IconBase.vue";
import IconArrowRight from "../common/icons/IconArrowRight.vue";
import HourlyIcon from "./icons/HourlyPrice.vue";
import CalendarIcon from "./icons/CalendarIcon.vue";
import SliderRight from "./icons/SliderRight.vue";
import SliderLeft from "./icons/SliderLeft.vue";
import IconCancel from "../common/icons/IconCancel.vue";
import FixedPrice from "./icons/FixedPrice.vue";
import IconAngleRight2 from "../common/icons/IconAngleRight2.vue";
import IconShoppingCart from "../common/icons/IconShoppingCart.vue";
import { Swiper, SwiperSlide, directive } from "vue-awesome-swiper";
import UpvoteIcon from "./icons/UpvoteIcon";
import LikeOutlined from "./icons/LikeOutlined";
import LikeFilled from "./icons/LikeFilled";
import Loading from "vue-loading-overlay";
import appMixin from "../../appMixin";
import PhaseArrow from "./icons/PhaseArrow";
import DoneIcon from "./icons/DoneIcon";
import DotIcon from "./icons/DotIcon";
import ThumbsUp from "./icons/ThumbsUp";
import CommentIcon from "./icons/CommentIcon";
import SystemCard from "../common/SystemCard";
import linkify from 'vue-linkify'
Vue.directive('linkified', linkify)

import "swiper/css/swiper.css";

export default {
  name: "ProjectDetail",
  mixins: [appMixin],
  data() {
    return {
      defaultUserImgUrl: base_url + "images/default-user-avatar-sm.jpg",
      isAuthenticated: window.isAuthenticated,
      isLoading: true,
      logged_user_id: null,
      payment: null,
      publicPath: local_image_path,
      title: null,
      type: null,
      titles: {
        "details": "Proposal details",
        "pending-invite": "Invite Details",
        "archived-proposal": "Archived Proposal",
        "archived-invite": "Archived Invite",
        "waiting-for-accept": "Offer details",
        "in-progress": "Project in progress",
        "completed-project": "Project Completed"
      },
      swiperOptionTop: {
        slidesPerView: 1,
        spaceBetween: 30,
        navigation: {
          nextEl: ".swiper-btn-next",
          prevEl: ".swiper-btn-prev"
        }
      },
      liked: false,
      swiperOptionThumbs: {
        spaceBetween: 20,
        centeredSlides: true,
        allowTouchMove: false,
        slidesPerView: "auto",
        touchRatio: 0.2,
        slideToClickedSlide: true,
        breakpoints: {
          320: {
            spaceBetween: 10
          },
          576: {
            spaceBetween: 20
          }
        }
      },
      category_id: 0,
      relatedProjects: [],
      project_slug: "",
      projectData: "",
      projectTags: [],
      projectProducts: [],
      projectCustomLines: [],
      projectComments: [],
      projectImage: [],
      projectCompany: [],
      projectPdf: [],
      commentText: "",
      user_project_votes_count: 0,
      projectQty: 1,
      postingComment: false,
      projectPriceTotalCount: 0,
      defaultUserImgUrl: base_url + "images/default-user-avatar-sm.jpg",
    };
  },
  directives: {
    swiper: directive
  },
  components: {
    Header,
    Footer,
    IconStars,
    IconBase,
    IconCancel,
    HourlyIcon,
    CalendarIcon,
    SliderRight,
    SliderLeft,
    PhaseArrow,
    FixedPrice,
    IconArrowRight,
    IconAngleRight2,
    IconShoppingCart,
    Swiper,
    SwiperSlide,
    UpvoteIcon,
    LikeOutlined,
    LikeFilled,
    Loading,
    DoneIcon,
    DotIcon,
    ThumbsUp,
    CommentIcon,
    SystemCard
  },
  created() {
    document.title = this.$route.meta.title;
    this.project_slug = this.$route.params.slug;
  },
  async mounted() {
    // this.updateProjectReviews();
    this.logged_user_id = localStorage.getItem("logged_user_id");

    await this.loadProjectData();
    const swiperTop = this.$refs.swiperTop.$swiper;
    const swiperThumbs = this.$refs.swiperThumbs.$swiper;
    swiperTop.controller.control = swiperThumbs;
    swiperThumbs.controller.control = swiperTop;
    this.scrollToTop();
  },
  watch: {
      '$route': function(){
        this.project_slug = this.$route.params.slug;
        this.loadProjectData();
      }
  },
  methods: {
    scrollToTop() {
      window.scrollTo(0,0);
    },
    setAltProImg(event) {
      event.target.src = base_url + "images/emptyImg.png";
    },
    showArchiveDialog() {
      this.$modal.show("archive-proposal-dialog");
    },
    hideArchiveDialog() {
      this.$modal.hide("archive-proposal-dialog");
    },
    like(id) {
      this.items[id].liked = !this.items[id].liked;
    },
    // Contact modal form
    showQuoteDialog() {
      this.$modal.show("quote-modal-dialog");
    },
    hideQuoteDialog() {
      this.$modal.hide("quote-modal-dialog");
    },
    innerText(projQty, index) {
      if (index === this.selected) return projQty;
      // return false;
    },
    // async updateProjectReviews() {
    //   const res = await this.callApi(
    //     "post",
    //     window.api_path + "project/updateReviews",
    //     {
    //       project_id: this.projectData.id,
    //       user_id: this.logged_user_id,
    //     }
    //   );
    //   if(res.data.status){
    //     console.log(res.data.data);
    //   }
    // },
    async loadProjectData() {
      this.scrollToTop();
      const result = await this.callApi(
        "get",
        window.api_path + "project/" + this.project_slug + "/details/"+ this.logged_user_id,
        {}
      );
      if (result.status !== 200) {
        this.isLoading = false;
        this.$toast.error(result.data.message);
        this.projectData = null;
        return;
      }
      const {project, project_image, project_company, project_pdf, project_custom_lines, related_projects, user_project_votes_count} = result.data.data;
      this.projectData = project;
      this.category_id = project.category_id;
      this.projectImage = project_image;
      this.projectCompany = project_company;
      this.projectPdf = project_pdf;
      this.projectCustomLines = project_custom_lines
      this.relatedProjects = related_projects
      this.isLoading = false
      this.user_project_votes_count = user_project_votes_count

      if(project_custom_lines.length > 0){
        project_custom_lines.forEach((value, index) => {
          this.projectPriceTotalCount = parseInt(this.projectPriceTotalCount) + parseInt(value.price);
        });
      }
    },
    async loadProjectTags(project_id) {
      const result = await this.callApi(
        "get",
        window.api_path + "project/" + project_id + "/getTags",
        {}
      );
      if (result.status !== 200) {
        this.$toast.error(result.data.message);
        this.projectTags = [];
        return;
      }
      this.projectTags = result.data.projectTags;
    },
    async loadProjectProduct(project_id) {
      const result = await this.callApi(
        "get",
        window.api_path + "project/" + project_id + "/getProducts",
        {}
      );
      if (result.status !== 200) {
        this.$toast.error(result.data.message);
        this.projectProducts = [];
        return;
      }
      this.projectProducts = result.data.projectProducts;
      this.projectcustomLines = result.data.projectcustomLines;
    },
    getEmbed(url) {
      if (url) {
        const regExp =
          /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
        const match = url.match(regExp);
        let id;
        if (match && match[2].length === 11) {
          return match[2];
        }
      }
    },
    async addComment() {
      if (this.isAuthenticated !== true || this.logged_user_id == null) {
        this.$toast.error("You need to login first to add a comment !");
        return;
      }
      if (this.commentText.trim() == "") {
        this.$toast.error('Can not post an empty comment');
        this.commentText = "";
        this.$refs.commentText.focus();
        return false;
      }
      this.postingComment = true
      const res = await this.callApi(
        "post",
        window.api_path + "project/addratings",
        {
          project_id: this.projectData.id,
          description: this.commentText,
        }
      );
      this.postingComment = false
      if (res.data.code === 1) {
        this.$toast.success(res.data.message)
      } else {
        this.$toast.error(res.data.message)
      }
      this.commentText = "";
      await this.loadProjectData()
    },
    async addVote() {
      if (this.isAuthenticated !== true || this.logged_user_id == null) {
        this.$toast.error("You need to login first to add Vote !");
        return;
      }
      const result = await this.callApi(
        "post",
        window.api_path + "voteProject",
        {
          project_id: this.projectData.id,
          user_id: this.logged_user_id
        }
      );
      if (result.status !== 200) {
        this.$toast.error(result.data.message);
        this.projectData.is_already_voted = 0;
        return;
      }
      var isAlreadyVote = 1;
      if(this.projectData.is_already_voted == 1){
        isAlreadyVote = 0
        this.user_project_votes_count = this.user_project_votes_count -  1
      }else{
        this.user_project_votes_count = this.user_project_votes_count + 1
      }

      this.projectData.is_already_voted = isAlreadyVote;
    }
  }
};
</script>

<style lang="scss" scoped>
.skeleton {
  height: 1200px;
  width: 100%;
  margin-top: 40px;
  border-radius: 8px;
}
.spinner-border {
  width: 1rem;
  height: 1rem;
}
.project-stage-wrapper {
  display: flex;
  justify-content: flex-start;
  flex-wrap: wrap;
}
.project-stage-wrapper p {
  margin-bottom: 0;
}
.project-stage-wrapper > div {
  width: calc(33.33% - 54px);
  border: 2px solid #F2A91C;
  border-radius: 13px;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 10px 15px;
  font-weight: 500;
  font-size: 25px;
}
.project-stage-wrapper .project-stage-icon {
  width: 40px;
  text-align: center;
  margin: 0 20px;
  border: none;
  padding: 0;
}
.project-stage-wrapper > .custom-project-stage.active {
  background: #202C54;
  border-color: #f2a91c;
  color: #fff;
}
.pdb-sec {
  background: #FAFAFA;
  border-radius: 13px;
  height: 100%;
  padding: 15px 20px;
}
.pbd-title {
  font-weight: 700;
  font-size: 20px;
  margin-bottom: 15px;
}

.budget-badge {
    background: #FFFFFF;
    border-radius: 16px;
    padding: 20px 30px;
    display: inline-block;
    vertical-align: middle;
    position: absolute;
    right: 10px;
    bottom: 10px;
}

.budget-badge .budget-text {
    font-weight: 500;
    font-size: 25px;
    line-height: 24px;
    color: #000000;
}

.budget-badge .budget-price {
    color: #F2A91C;
    font-weight: 500;
    font-size: 25px;
    line-height: 24px;
    margin-left: 12px;
}


@media all and (max-width:991px){
  .custom-project-stage{
    font-size: 20px !important;
  }
  .project-stage-icon svg{
    width:20px;
    height:20px;
  }
  .budget-badge{
    padding: 10px 15px;
  }
  .budget-badge .budget-text{
    font-size: 20px;
    line-height: 22px;
  }
  .budget-badge .budget-price{
    font-size: 18px;
    line-height: 20px;
    margin-left: 6px;
  }
}
@media all and (max-width:991px){
  .project-stage-wrapper > div{
    width: calc(33.33% - 30px);
    padding: 10px 5px;
    font-size: 14px !important;
  }
  .project-stage-wrapper .project-stage-icon{
    width: 30px;
    margin: 0 7px;
  }
  .custom-table .table tr td,.custom-table .table tr th {
    white-space: nowrap;
    padding-left: 15px;
    padding-right: 15px;
  }
}
@media all and (max-width:767px){
  .dw-left {
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
  }
  .dw-left h1 {
      margin-top: 10px !important;
      font-size: 26px;
      margin-bottom: 0 !important;
      width: calc(100% - 110px);
  }
  .system-page .detail-wrapper {
      padding: 25px;
  }
  .dw-right {
      justify-content: space-between !important;
      width: 100% !important;
  }
  .dw-right .user-info {
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: space-between;
  }
  .dw-right .user-info > .row {
      flex-direction: column;
      margin-bottom:  0 !important;
  }
  .project-desc-block > .row > div{
    margin-bottom:20px;
  }
  .system-page .project-gallery-top .swiper-btn-prev,
  .system-page .project-gallery-top .swiper-btn-next{
    width: 40px;
    height: 58px;
  }
  .system-page .project-gallery-top .swiper-btn-prev .icon-w svg{
    height: 18px;
    width:14px;
  }
}
@media all and (max-width:575px){
  .project-stage-icon svg {
    width: 12px;
    height: 12px;
  }
  .project-stage-wrapper .project-stage-icon {
    width: 25px;
    margin: 0 3px;
  }
  .project-stage-wrapper > div{
    width: calc(33.33% - 21px);
  }
  .budget-badge .budget-text{
    
    font-size: 18px;
    line-height: 20px;

  }
  .budget-badge .budget-price{
    font-size: 16px;
    line-height: 18px;
  }
  .system-page .project-gallery-top .swiper-btn-prev,
   .system-page .project-gallery-top .swiper-btn-next{
    width: 30px;
    height: 38px;
  }
 
}
@media all and (max-width:480px){
  .project-stage-wrapper{
    flex-direction: column;
    justify-content: center;
    align-items: center;
  }
  .project-stage-wrapper > div {
    width: 50%;
    font-size:16px;
  }
  .project-stage-wrapper .project-stage-icon {
    width: 25px;
    margin: 10px 0px;
  }
  .project-stage-icon svg {
    width: 18px;
    height: 18px;
    transform: rotate(90deg);
  }
  .dw-right .user-info{
    flex-direction: column;
    justify-content: center;
    text-align:center;
  }
  .dw-right .user-info > .row {
    margin-bottom: 15px !important;
  }
  .dw-left .like-tag{
    height:auto;
  }
  .dw-left h1{
    font-size: 20px;
  }
  .budget-badge{
    padding: 7px 12px;
    border-radius: 8px;
  }
  .budget-badge .budget-price,
  .budget-badge .budget-text{
    font-size: 14px;
    line-height: 16px;
  }
}
</style>