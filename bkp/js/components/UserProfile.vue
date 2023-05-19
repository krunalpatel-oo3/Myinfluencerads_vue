<template>
  <div>
    <Header />

    <!-- User Profile -->
    <section class="section-userprofile">
      <div
        v-if="userProfileData.cover_image != null"
        class="userprofile-img-top"
        :style="{ backgroundImage: `url(${userProfileData.cover_image})` }"
      ></div>
      <div
        v-else
        class="userprofile-img-top"
        :style="{ backgroundImage: `url(${publicPath}profile-bg-1.jpg)` }"
      ></div>

      <div class="container">
        <header class="userprofile-h">
          <div class="userprofile-h-info">
            <div class="userpic">
              <img
                v-if="userProfileData.profile_photo != null"
                class="rounded-circle"
                :src="userProfileData.profile_photo"
                alt=""
              />
              <img
                v-else
                class="rounded-circle"
                :src="defaultUserImgUrl"
                alt=""
              />
            </div>
            <div class="userinfo">
              <div class="username">{{ userProfileData.full_name }}</div>
              <!-- <div class="position">DJ / Visual Streaming</div> -->
            </div>
          </div>
          <div class="userprofile-h-contact">
            <!-- Contact-modal-dialog -->
            <button v-if="this.logged_user_id != userProfileData.id" class="btn btn-secondary" @click="showContactDialog">
              Contact
            </button>
            <modal
              name="contact-modal-dialog"
              :width="1160"
              height="auto"
              :scrollable="true"
              :adaptive="true"
              transition=""
              class="section-modal section-modal-contact"
            >
              <div
                class="modal-close"
                @click="$modal.hide('contact-modal-dialog')"
              >
                <icon-base
                  width="21"
                  height="21"
                  viewBox="0 0 7 7"
                  icon-name="cancel"
                  ><icon-cancel
                /></icon-base>
              </div>
              <h2 class="h1">Contact Streamer</h2>
              <div class="form-group">
                <textarea
                  rows="14"
                  class="form-control"
                  placeholder="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."
                ></textarea>
              </div>
              <div class="btns">
                <button class="btn btn-primary ml-auto">Send</button>
              </div>
            </modal>
            <!-- End of contact-modal-dialog -->
          </div>
        </header>

        <ul class="nav nav-ptabs">
          <li
            class="nav-link"
            :class="userprofileTab == 1 ? 'active' : ''"
            @click="userprofileTab = 1"
          >
            About
          </li>
          <!-- <li
            class="nav-link"
            :class="userprofileTab == 2 ? 'active' : ''"
            @click="userprofileTab = 2"
          >
            Gigs
          </li> -->
          <li
            class="nav-link"
            :class="userprofileTab == 3 ? 'active' : ''"
            @click="userprofileTab = 3"
          >
            Community
          </li>
          <li
            class="nav-link"
            :class="userprofileTab == 4 ? 'active' : ''"
            @click="userprofileTab = 4"
          >
            Projects
          </li>
        </ul>
      </div>

      <div class="tabs-content">
        <!-- About -->
        <div class="tab-content tab-content-1" v-if="userprofileTab == 1">
          <div class="container">
            <div class="userprofile-t">
              <div class="username">{{ userProfileData.full_name }}</div>
              <!-- <div class="userstreams">253 Streams</div> -->
            </div>
            <div class="userprofile-desc">
              <h3>Description</h3>
              <div class="text">
                <p>
                  {{ userProfileData.description }}
                </p>
              </div>
            </div>

            <div class="userprofile-details-blocks">
              <div
                class="userprofile-details-block userprofile-details-block-1"
              >
                <div class="userprofile-details-line">
                  <span class="label">Email:</span>
                  <span class="val">{{ userProfileData.email }}</span>
                </div>
                <div class="userprofile-details-line">
                  <span class="label">Twitter:</span>
                  <span class="val">{{ userProfileData.twitter_name ?? '-' }}</span>
                </div>
                <div class="userprofile-details-line">
                  <span class="label">Linkedin:</span>
                  <span class="val">{{ userProfileData.linkedin_name ?? '-' }}</span>
                </div>
                <div class="userprofile-details-line">
                  <span class="label h5">Instagram:</span>
                  <span class="val">{{ userProfileData.instagram_name ?? '-' }}</span>
                </div>
              </div>
              <div
                class="userprofile-details-block userprofile-details-block-2"
              >
                <h3>Skills</h3>

                <div v-for="(category, index) in userCategories" :key="index">
                  <div class="row mx-0">
                    <div class="w-100">
                      <div class="d-flex align-items-center justify-content-between">
                          <div class="d-left">
                            <h4 class="mb-0 t-18 w500 lh-54">{{ category.title }}</h4>
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
              </div>

              <div
                class="userprofile-details-block userprofile-details-block-3"
              >
                <h3>Services</h3>

              <div class="custom-checkbox-group mt-3">
                <label class="custom-checkbox custom-checkbox-dark">
                  <input v-if="userProfileData.services != null && userProfileData.services.split(',').includes('on-site')" checked type="checkbox" value="on-site" id="on-site" disabled>
                  <input v-else type="checkbox" value="on-site" id="on-site" disabled>
                  <span>On-site event streaming</span>
                </label>
              </div>
              <div class="custom-checkbox-group">
                <label class="custom-checkbox custom-checkbox-dark">
                  <input v-if="userProfileData.services != null && userProfileData.services.split(',').includes('remote-production')" checked type="checkbox" value="remote-production" id="remote-production" disabled>
                  <input v-else type="checkbox" value="remote-production" id="remote-production" disabled>
                  <span>Remote Production</span>
                </label>
              </div>
              <div class="custom-checkbox-group">
                <label class="custom-checkbox custom-checkbox-dark">
                  <input v-if="userProfileData.services != null && userProfileData.services.split(',').includes('post-production')" checked type="checkbox" value="post-production" id="post-production" disabled>
                  <input v-else type="checkbox" value="post-production" id="post-production" disabled>
                  <span>Post production</span>
                </label>
              </div>
              <div class="custom-checkbox-group">
                <label class="custom-checkbox custom-checkbox-dark">
                  <input v-if="userProfileData.services != null && userProfileData.services.split(',').includes('consulting')" checked type="checkbox" value="consulting" id="consulting" disabled>
                  <input v-else type="checkbox" value="consulting" id="consulting" disabled>
                  <span>Consulting</span>
                </label>
              </div>
              <div class="custom-checkbox-group">
                <label class="custom-checkbox custom-checkbox-dark">
                  <input v-if="userProfileData.services != null && userProfileData.services.split(',').includes('video-production')" checked type="checkbox" value="video-production" id="video-production" disabled>
                  <input v-else type="checkbox" value="video-production" id="video-production" disabled>
                  <span>Video Production</span>
                </label>
              </div>
              </div>
            </div>

            <!-- UserProfile Reviews -->
            <div class="userprofile-reviews">
              <div class="reviews-list">
                <h3 class="mb-4">Most Recent Comments</h3>
                <div v-if="mostRecentComments.length > 0" class="review" v-for="(comment, ind) in mostRecentComments" :key="ind">
                  <div class="userpic">
                    <img
                      v-if="comment.product_image != null"
                      :src="comment.product_image"
                      class="rounded rounded-circle"
                      alt=""
                    />
                    <img
                      v-else
                      :src="`${publicPath}no-image.jpg`"
                      class="rounded rounded-circle"
                      alt=""
                    />
                  </div>
                  <div class="review-r">
                    <div class="review-author-t">
                      <div class="author-name">
                        <router-link :to="{ name: 'userprofile', params: { slug: comment.user_id } }">{{ comment.user_name }}</router-link>
                      </div>
                      <div class="author-rating">
                        <div class="num">{{ comment.ratings }}</div>
                        <icon-base
                          width="16"
                          height="15"
                          view-box="0 0 11 10.54"
                          icon-name="star"
                        >
                          <icon-star />
                        </icon-base>
                      </div>
                    </div>
                    <div class="review-author-location">{{ comment.product_name }}</div>
                    <div class="review-text">
                      <p>
                        {{ comment.description }}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- End of UserProfile Reviews -->
          </div>
        </div>
        <!-- End of About -->

        <!-- Community -->
        <div class="tab-content tab-content-3" v-if="userprofileTab == 3">
          <div class="container">
            <div class="cpost-list">
              <div v-for="nextCommunity in communitiesList" :key="nextCommunity.id" class="cpost">
                <div class="cpost-body">
                  <div class="cpost-title">
                    <router-link style="cursor: pointer;"
                      :to="{
                        name: 'communitydetail',
                        params: { slug: nextCommunity.slug }
                      }"
                      >{{ nextCommunity.title.substring(0, 120) }}
                    </router-link>
                  </div>
                  <div
                    class="cpost-text"
                    v-html="nextCommunity.desc.substring(0, 250) + '...'"
                  ></div>
                </div>
                <div class="cpost-footer">
                  <ul class="tags" v-if="nextCommunity.community_tag_tagged.length > 0">
                    <li v-for="nextCommunityTagTagged in nextCommunity.community_tag_tagged"
                        :key="nextCommunityTagTagged.id">
                      <a style="cursor: pointer;" @click.prevent="searchTags(nextCommunityTagTagged.tag.title,nextCommunityTagTagged.tag.id)" :class="['tag-'+nextCommunityTagTagged.tag.color, 'tag']" >{{ nextCommunityTagTagged.tag.title }}</a>
                    </li>
                  </ul>

                  <div class="cpost-info">
                    <div class="cpost-info-item">
                      <div class="num">
                        {{
                          nFormatter(nextCommunity.user_community_vote_count, 1)
                        }}
                      </div>
                      <div
                        class="lbl"
                      >
                        <icon-base
                          width="14"
                          height="13.07"
                          view-box="0 0 20 18.67"
                          icon-name="like"
                        >
                          <icon-like />
                        </icon-base>
                        <span>Votes</span>
                      </div>
                    </div>
                    <div class="cpost-info-item">
                      <div class="num">
                        {{ nFormatter(nextCommunity.community_answer_count, 1) }}
                      </div>
                      <div class="lbl">
                        <icon-base
                          width="14"
                          height="14"
                          view-box="0 0 19 18.96"
                          icon-name="answers"
                        >
                          <icon-answers />
                        </icon-base>
                        <span>Answers</span>
                      </div>
                    </div>
                    <div class="cpost-info-item">
                      <div class="num">
                        {{
                          nFormatter(nextCommunity.user_community_viewed_count, 1)
                        }}
                      </div>
                      <div class="lbl">
                        <icon-base
                          width="14.57"
                          height="9.38"
                          view-box="0 0 19.23 12.38"
                          icon-name="views"
                        >
                          <icon-views />
                        </icon-base>
                        <span>Views</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <paginate
              v-model="communityPage"
              :page-count="totalCommunityPages"
              :page-range="3"
              :margin-pages="2"
              :prev-text="'Prev'"
              :next-text="'Next'"
              :container-class="'pagination pagination-dark'"
              :page-class="'page-item'"
            >
            </paginate>
          </div>

          <div class="tab-bg"></div>
        </div>
        <!-- End of Community -->

        <!-- Projects -->
        <div class="tab-content tab-content-4" v-if="userprofileTab == 4">
          <div class="container">
            <div class="row">
              <div class="col-lg-3 col-sm-6 col-xs-12" v-for="(project, index) in projects" :key="index">
                <div class="card card-project">
                  <div class="card-img-top">
                    <router-link :to="{}">
                      <img :src="project.projectImagePropsArray.image_url || `${publicPath}no-image.jpg`" alt="" />
                      <span
                        class="is-featured"
                        :style="{
                          backgroundImage: `url(${publicPath}featured-bg.png)`
                        }"
                        >Popular</span
                      >
                    </router-link>
                  </div>
                  <div class="card-body">
                    <div class="card-title-vote">
                      <div class="card-title">
                        <router-link :to="{ name: 'project', params: { slug: project.slug } }">
                          {{ project.name }}
                        </router-link>
                      </div>
                      <button class="btn btn-link btn-icon btn-vote">
                        <icon-base
                          width="18"
                          height="17.25"
                          view-box="0 0 18 17.25"
                          icon-name="like-4"
                        >
                          <icon-like-4 />
                        </icon-base>
                      </button>
                    </div>
                    <div class="card-category">
                      <div class="label">
                        <router-link to="/">{{ project.categoryname }}</router-link>
                      </div>
                    </div>

                    <p class="card-text" v-html="project.desc ? project.desc.substring(0, 120) : ''" style="width: 100%;"></p>

                    <div class="card-price-more">
                      <div class="more">
                        <router-link :to="{ name: 'project', params: { slug: project.slug } }" class="btn btn-link btn-icon">
                          <span class="profile-learn-more">Learn More</span>
                          <icon-base
                            width="18"
                            height="8.72"
                            view-box="0 0 18 8.72"
                            icon-name="arrow-right"
                          >
                            <icon-arrow-right />
                          </icon-base>
                        </router-link>
                      </div>
                      <div class="projectby">
                        <span>Project by</span>
                        <router-link :to="{ name: 'userprofile', params: { slug: project.creator.id } }" style="cursor: pointer;">
                          <img v-if="project.creator.profile_photo != null" :src="project.creator.profile_photo" class="rounded-circle" alt=""></img>
                          <img v-else :src="`${publicPath}user-avatar-sm.jpg`" class="rounded-circle" alt="" />
                        </router-link>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <paginate
              v-model="page"
              :page-count="totalPages"
              :page-range="3"
              :margin-pages="2"
              :prev-text="'Prev'"
              :next-text="'Next'"
              :container-class="'pagination pagination-dark'"
              :page-class="'page-item'"
            >
            </paginate>

          </div>
          <div class="tab-bg"></div>
        </div>
        <!-- End of Projects -->
      </div>
    </section>
    <Footer />
    <SendUserEmailModal 
      :username="userProfileData.full_name" 
      :useremail="userProfileData.email"
      :submitting="submitting"
    />
  </div>
</template>

<script>
import Vue from "vue";
import vSelect from "vue-select";
import Paginate from "vuejs-paginate";
import Header from "./common/Header.vue";
import Footer from "./common/Footer.vue";
import IconBase from "./common/IconBase.vue";
import IconAngleDown from "./common/icons/IconAngleDown.vue";
import IconStars from "./common/icons/IconStars.vue";
import IconStar from "./common/icons/IconStar.vue";
import IconLike from "./common/icons/IconLike.vue";
import IconArrowRight from "./common/icons/IconArrowRight.vue";
import IconLike2 from "./common/icons/IconLike2.vue";
import IconAnswers from "./common/icons/IconAnswers.vue";
import IconCancel from "./common/icons/IconCancel.vue";
import IconViews from "./common/icons/IconViews.vue";
import appMixin from "../appMixin";
import SendUserEmailModal from "./rebranded/modals/SendUserEmailModal";
import RatingStar from "./rebranded/icons/RatingStar";

Vue.component("v-select", vSelect);
Vue.component("paginate", Paginate);
import "vue-select/dist/vue-select.css";

export default {
  name: "UserProfile",
  components: {
    Header,
    Footer,
    Paginate,
    IconBase,
    IconArrowRight,
    IconAngleDown,
    IconStars,
    IconStar,
    IconLike,
    IconLike2,
    IconAnswers,
    IconCancel,
    IconViews,
    RatingStar,
    SendUserEmailModal
  },
  mixins: [appMixin],
  data() {
    return {
      isAuthenticated: window.isAuthenticated,
      publicPath: local_image_path,
      userprofileTab: 1,
      loggedUser: null,
      loggedUserProfilePhotoImageProps: null,
      gigs: [],
      logged_user_id: null,
      currentHomepageProjectsPageNum: 1,
      totalPages: 0,
      page: 1,
      reviewsSort: "Most Recent",
      userProfileData: "",
      projects: [],
      slugValue: this.$route.params.slug,
      defaultUserImgUrl: base_url + "images/default-user-avatar-sm.jpg",
      reviewsSortOptions: [
        {
          label: "Most Recent"
        },
        {
          label: "Most Popular"
        }
      ],
      communitiesList: [],
      totalCommunityPages: 0,
      communityPage: 1,
      userCategories: [],
      totalReviews: 0,
      avgRating: 0,
      avgRating1: 0,
      reviewPer5Star: 0,
      reviewPer4Star: 0,
      reviewPer3Star: 0,
      reviewPer2Star: 0,
      reviewPer1Star: 0,
      mostRecentComments: [],
      submitting: false,
    };
  },
  created() {
    document.title = this.$route.meta.title;
    this.logged_user_id = localStorage.getItem("logged_user_id");
  },

  mounted() {
    this.scrollToTop();
    this.loadUserProfileData();
  },

  methods: {
    scrollToTop() {
      window.scrollTo(0,0);
    },
    showContactDialog() {
      this.$modal.show("send-user-email-dialog");
    },
    hideContactDialog() {
      this.$modal.hide("send-user-email-dialog");
    },

    async loadUserProfileData() {
      const result = await this.callApi("post", window.api_path + "getProfile/" + this.slugValue, { page: this.page, communityPage: this.communityPage });
      // console.log(result);
      // User profile data
      this.userProfileData = result.data.userProfileData;
      // Get user category and skill data
      this.userCategories = result.data.categories;

      // Get user project data
      this.projects   = result.data.projectData;
      this.totalPages = result.data.totalPages;
      this.page       = result.data.page;

      // Get user community data
      this.communitiesList      = result.data.communityData;
      this.totalCommunityPages  = result.data.totalCommunityPages;
      this.communityPage        = result.data.communityPage;

      // Get total reviews
      // this.totalReviews     = result.data.totalReviews;
      // this.avgRating        = result.data.avgRating;
      // this.avgRating1       = (5 - result.data.avgRating);
      // this.reviewPer5Star   = result.data.reviewPer5Star;
      // this.reviewPer4Star   = result.data.reviewPer4Star;
      // this.reviewPer3Star   = result.data.reviewPer3Star;
      // this.reviewPer2Star   = result.data.reviewPer2Star;
      // this.reviewPer1Star   = result.data.reviewPer1Star;

      // Get most recent comments
      this.mostRecentComments = result.data.mostRecentComments;
    },
    async loadLoggedUserProfileData() {
      const result = await this.callApi("get", window.api_path + "profile", {});
      this.loggedUser = result.data.loggedUser;
      this.loggedUserProfilePhotoImageProps =
        result.data.loggedUserProfilePhotoImageProps;
    },

    async loadLoggedUserGigs(page) {
      // console.log('loadLoggedUserGigs page::')
      // console.log(page)
      const result = await this.callApi(
        "post",
        window.api_path + "profile/" + this.logged_user_id + "/getFilteredGigs",
        {
          page: page
        }
      );
      if (result.status != 200) {
        this.$toast.error(result.data.message);
        this.currentGigsPage = 1;
        this.totalPages = 1;
        this.gigs = [];
        return;
      }

      this.currentGigsPage = page;
      this.totalPages = result.data.totalPages;
      this.gigs = result.data.gigs;
    } // async loadLoggedUserGigs(page) {
  },
  watch: {
    page () {
      this.loadUserProfileData()
    },
    communityPage () {
      this.loadUserProfileData()
    }
  },
};
</script>
<style scopped>
  .profile-learn-more {
    color: #202c54 !important;
  }
  .section-userprofile .skill {
    background: #F8F9FA;
    border-radius: 5px;
    height: 40px;
    border: none;
    padding: 0 20px;
    font-size: 12px;
    margin-right: 14px;
    margin-bottom: 29px;
  }
  .section-userprofile .skill:hover {
    background: #eee;
  }
  .rating-lg svg{
    width: 22px;
    height: 22px;
  }
  .userprofile-reviews{
    border-top: 1px solid #d2d5dd;
    padding: 24px 0;
  }
</style>