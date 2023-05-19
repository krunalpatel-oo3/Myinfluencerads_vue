<template>
  <div>
    <Header />

    <main class="main">
      <div class="container">
        <!-- Community Detail -->
        <section class="section-cdetail">
          <div class="btns cdetail-back">
            <router-link to="/community" class="btn btn-icon btn-link">
              <icon-base
                width="26.7"
                height="20.03"
                view-box="0 0 26.7 20.03"
                icon-name="back"
                ><icon-back
              /></icon-base>
              <span>Back</span>
            </router-link>
          </div>

          <!-- Community Detail Question -->
          <section class="section-cdquestion" v-if="communityData">
            <h1 class="cdquestion-title" style="cursor: pointer;" v-html="communityData.title">
            </h1>
            <div class="cpost">
              <div class="cpost-body">
                <div class="cpost-text" v-html="communityData.desc"></div>
              </div>
              <div class="cpost-footer">
                <ul class="tags">
                  <li
                    v-for="nextCommunity in communityTags"
                    :key="nextCommunity.id"
                  ><a style="cursor: pointer;" @click.prevent="searchTags(nextCommunity.tag.title,nextCommunity.tag.id)"  :class="['tag-'+nextCommunity.tag.color, 'tag']">{{  nextCommunity.tag.title }}</a></li>
                </ul>
                <div class="cpost-info">
                  <div class="cpost-info-item">
                    <div class="num">
                      {{ nFormatter(userCommunityVotesCount, 1) }}
                    </div>
                    <!-- <div class="lbl" @click.prevent="voteCommunity" style="cursor: pointer;"> -->
                    <div class="lbl">
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
                      {{ nFormatter(totalCommunityAnswers, 1) }}
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
                      {{ nFormatter(totalUserCommunityViewedCount, 1) }}
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
          </section>
          <!-- End of Community Detail Question -->

          <!-- Community Detail Answers -->
          <section class="section-cdanswers" v-if="communityAnswers">
            <h2 class="cdanswers-title">
              {{ nFormatter(communityAnswers.length, 1) }} Answers:
            </h2>
            <div class="cdanswers-list">
              <div
                class="cdanswer"
                v-for="nextCommunityAnswer in communityAnswers"
                :key="nextCommunityAnswer.id"
              >
                <div class="cdanswer-content">
                  <div class="cdanswer-userpic" v-if="nextCommunityAnswer.creatorUserProfilePhotoImageProps">
                    <router-link :to="{
                      name: 'userprofile',
                      params: { slug: nextCommunityAnswer.creator.id }
                    }" style="cursor: pointer;">
                      <img
                        :src="
                          nextCommunityAnswer.creatorUserProfilePhotoImageProps
                            .image_url
                        "
                        class="rounded-circle"
                        alt=""
                      />
                    </router-link>
                  </div>
                  <div class="cdanswer-content-r">
                    <div class="cdanswer-info">
                      <div class="cdanswer-username">
                        <router-link :to="{
                      name: 'userprofile',
                      params: { slug: nextCommunityAnswer.creator.id }
                    }">{{
                          nextCommunityAnswer.creator.full_name
                        }}</router-link>
                      </div>
                      <div class="cdanswer-date">
                        {{
                          momentDatetime(
                            nextCommunityAnswer.created_at,
                            getJsMomentDatetimeFormat()
                          )
                        }}
                      </div>
                    </div>
                    <div
                      class="cdanswer-text text-break"
                      v-html="nextCommunityAnswer.answer_text"
                      v-linkified
                    ></div>
                  </div>
                </div>
                <div class="cdanswer-votes" style="cursor: pointer;">
                  <div class="num">0</div>
                  <div class="lbl" @click.prevent="voteCommunity">
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
              </div>

              <paginate
                v-if="totalPages > 1"
                :page-count="totalPages"
                :page-range="3"
                :margin-pages="2"
                :click-handler="clickCallback"
                :prev-text="'Prev'"
                :next-text="'Next'"
                :container-class="'pagination'"
                :page-class="'page-item'"
              >
              </paginate>
            </div>
            <!-- <div class="cdanswers-list"> -->

            <div class="cdanswer-form">
              <div class="form-group">
                <textarea
                  rows="4"
                  class="form-control"
                  placeholder="Enter your answer here.."
                  v-model="newCommunityAnswerText"
                  ref="newCommunityAnswerText"
                ></textarea>
              </div>
              <div class="btns justify-content-end">
                <button
                  class="btn btn-primary btn-100"
                  @click="replyNewCommunityAnswer"
                >
                  Reply
                </button>
              </div>
            </div>
          </section>
          <!-- End of Community Detail Answers -->

          <section class="section-cdetail-popular">
            <h3>Popular Questions</h3>
            <div class="cpost-list">
              <div class="cpost" v-for="nextCommunityPopularQuestion in communityPopularQuestions"
                :key="nextCommunityPopularQuestion.id"
              >
                <!-- <div class="cpost-body">
                  <div class="cpost-title">
                    <router-link :to="{name: 'communitydetail', params: {slug: nextCommunityPopularQuestion.slug}}"
                      >{{ nextCommunityPopularQuestion.title}}</router-link
                    >
                  </div>
                  <div class="cpost-text">
                  </div> -->



  <div class="cpost-body">

                <div class="cpost-title">
                  <router-link @click="loadCommunityData()" style="cursor: pointer;"
                    :to="{
                      name: 'communitydetail',
                      params: { slug: nextCommunityPopularQuestion.slug }
                    }"
                  >{{ nextCommunityPopularQuestion.title.substring(0,120) }}
                  </router-link>
                </div>

                <div class="cpost-footer">
                  <ul
                    class="tags"
                    v-if="
                      nextCommunityPopularQuestion.community_tag_tagged.length
                    "
                  >
                    <li
                      v-for="nextCommunityTagTagged in nextCommunityPopularQuestion.community_tag_tagged"
                      :key="nextCommunityTagTagged.id"
                    ><a style="cursor: pointer;" @click.prevent="searchTags(nextCommunityTagTagged.tag.title,nextCommunityTagTagged.tag.id)"  :class="['tag-'+nextCommunityTagTagged.tag.color, 'tag']">{{ nextCommunityTagTagged.tag.title }}</a></li>
                  </ul>

                  <div class="cpost-info">
                    <div class="cpost-info-item">
                      <div class="num">
                        {{
                          nFormatter(
                            nextCommunityPopularQuestion.user_community_vote_count,
                            1
                          )
                        }}
                      </div>
                      <div class="lbl" style="cursor: pointer;">
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
                        {{
                          nFormatter(
                            nextCommunityPopularQuestion.community_answer_count,
                            1
                          )
                        }}
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
                          nFormatter(
                            nextCommunityPopularQuestion.user_community_viewed_count,
                            1
                          )
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
            </div>
          </section>
        </section>
      </div>
    </main>

    <Footer />
  </div>
</template>

<script>
import Vue from 'vue';
import Paginate from "vuejs-paginate";
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import Header from "./common/Header.vue";
import appMixin from "../appMixin";
import Footer from "./common/Footer.vue";
import IconBase from "./common/IconBase.vue";
import IconBack from "./common/icons/IconBack.vue";
import IconLike from "./common/icons/IconLike.vue";
import IconAnswers from "./common/icons/IconAnswers.vue";
import IconViews from "./common/icons/IconViews.vue";
import linkify from 'vue-linkify'

Vue.directive('linkified', linkify)

export default {
  name: "CommunityDetail",
  components: {
    Header,
    Footer,
    Loading,
    Paginate,
    IconBase,
    IconBack,
    IconLike,
    IconAnswers,
    IconViews
  },

  mixins: [appMixin],

  data() {
    return {
      isAuthenticated: window.isAuthenticated,
      community_slug: null,
      communityData: null,
      communityTags: [],
      communityPopularQuestions: [],
      totalCommunityAnswers: [],
      communityAnswers: [],
      community_answers_on_community: 0,
      currentCommunityAnswerPageNum: 1,
      userCommunityVotesCount: 0,
      totalPages: 0,
      loggedUserCommunityVotesCount: 0,
      totalUserCommunityViewedCount: 0,
      is_already_voted: false,

      newCommunityAnswerText: null,
      logged_user_id: null
    };
  },
   watch: {
    '$route' (to, from) {
      this.loadCommunityData();
   this.$router.go()

    }
   },
  created() {
    document.title = this.$route.meta.title;
    this.community_slug = this.$route.params.slug;
  },
  mounted() {
    this.logged_user_id = localStorage.getItem("logged_user_id");
    this.loadCommunityData();
    this.scrollToTop();
  }, // mounted() {
//  beforeRouteUpdate (to, from, next) {
//     this.community_slug= to.params.slug;
//     this.$router.push({ path: '/communitydetail/'+this.community_slug})
//     console.log(this.community_slug);
//     this.loadCommunityData();
//   },
  methods: {
    async searchTags(tag,id) {
      this.$router.push({ path: '/community', query: { tag:tag }})

    },
    scrollToTop() {
      window.scrollTo(0,0);
    },

    async voteCommunity() {
      if (!this.isAuthenticated || !localStorage.getItem("logged_user_id")) {
        this.$toast.error("To vote you need to login first !");
        return;
      }
      if (this.is_already_voted) {
        this.$toast.warning("You have already voted for this community !");
        return;
      }
      const result = await this.callApi(
        "post",
        window.api_path + "voteCommunity",
        {
          community_id: this.communityData.id,
          user_id: localStorage.getItem("logged_user_id")
        }
      );

      let self = this;
      if (result.status == 200) {
        self.$toast.success(result.data.message);
        self.is_already_voted = true;
        self.userCommunityVotesCount++;
        self.loggedUserCommunityVotesCount++;
        return;
      }
      this.$toast.error(result.data.message);
    }, // async voteProject(project_id) {

    clickCallback(page) {
      this.loadCommunityAnswers(this.communityData.id, page);
    },

    async loadCommunityData() {
      const result = await this.callApi(
        "get",
        window.api_path +
          "community/" +
          this.community_slug +
          "/details/" +
          this.logged_user_id,
        {}
      );
      if (result.status != 200) {
        this.$toast.error(result.data.message);
        this.communityData = null;
        return;
      }
      this.communityData = result.data.community;
      this.userCommunityVotesCount = result.data.userCommunityVotesCount;
      this.totalUserCommunityViewedCount =
        result.data.totalUserCommunityViewedCount;
      this.loggedUserCommunityVotesCount =
        result.data.loggedUserCommunityVotesCount;
      this.is_already_voted = this.loggedUserCommunityVotesCount > 0;
      if (this.communityData) {
        this.loadCommunityTags(this.communityData.id);
        this.loadCommunityPopularQuestions(this.communityData.id);
        this.loadCommunityAnswers(
          this.communityData.id,
          this.currentCommunityAnswerPageNum
        );
      }
    }, // async loadCommunityData() {

    async loadCommunityTags(community_id) {
      const result = await this.callApi(
        "get",
        window.api_path + "community/" + community_id + "/getTags",
        {}
      );
      if (result.status != 200) {
        this.$toast.error(result.data.message);
        this.communityTags = [];
        return;
      }

      this.communityTags = result.data.communityTags;
    }, // async loadCommunityTags() {

    async loadCommunityPopularQuestions(community_id) {
      const result = await this.callApi(
        "get",
        window.api_path + "community/" + community_id + "/getPopularQuestions",
        {}
      );
      if (result.status != 200) {
        this.$toast.error(result.data.message);
        this.communityPopularQuestions = [];
        return;
      }

      this.communityPopularQuestions = result.data.communityPopularQuestions;
    }, // async loadCommunityPopularQuestions() {

    async loadCommunityAnswers(community_id, pageNum) {
      const result = await this.callApi(
        "post",
        window.api_path + "community/" + community_id + "/getAnswers",
        {
          page: pageNum
        }
      );

      if (result.status != 200) {
        this.$toast.error(result.data.message);
        this.communityAnswers = [];
        this.totalCommunityAnswers = 0;
        this.currentCommunityAnswerPageNum = 1;
        this.community_answers_on_community = 0;
        this.totalPages = 0;
        return;
      }

      this.currentCommunityAnswerPageNum = pageNum;
      this.community_answers_on_community =
        result.data.community_answers_on_community;
      this.totalPages = result.data.totalPages;
      this.communityAnswers = result.data.communityAnswers;
      this.totalCommunityAnswers = result.data.totalCommunityAnswers;
    }, // async loadCommunityAnswers() {

    async replyNewCommunityAnswer() {
      if (!this.isAuthenticated || !localStorage.getItem("logged_user_id")) {
        this.$toast.error("To add an answer, you must first log in.");
        return;
      }
      
      if(this.newCommunityAnswerText.trim() === ""){
        this.$toast.warning("Only blank space not allow!");
        this.newCommunityAnswerText = null;
        this.$refs.newCommunityAnswerText.focus();
        return;
      } else if (
        !this.newCommunityAnswerText ||
        this.newCommunityAnswerText.length <= 5
      ) {
        this.$toast.warning("Answer text too short! ");
        return;
      }

      const result = await this.callApi(
        "post",
        window.api_path + "community/" + this.communityData.id + "/answer/add",
        {
          community_id: this.communityData.id,
          user_id: this.logged_user_id,
          answer_text: this.newCommunityAnswerText
        }
      );

      if (result.status != 200) {
        this.$toast.error(result.data.message);
        return;
      }
      this.newCommunityAnswerText = "";
      this.$toast.success("Your reply was sent successfully");
      this.loadCommunityAnswers(this.communityData.id);
    }
  }
};
</script>
