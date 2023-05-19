<template>
  <div>
    <loading
      :active.sync="isLoading"
      :can-cancel="false"
      :is-full-page="fullPage"
      background-color="#000"
      color="#202c54"
    ></loading>

    <Header />

    <main class="main">
      <section class="section-edetail ">
        <!-- Education Detail Top -->
        <section
          v-if="educationImageProps"
          class="section-edetail-top overlay"
          :style="{ backgroundImage: 'url('+educationImageProps.image_url+')' }"
        >
          <div class="container">
            <div class="edetail-top-i">
              <h1>{{ educationData.title }}</h1>

              <div class="edetail-top-info" v-if="educationData">
                <span v-if="educationData.published_at_formatted">
                    Written by {{ educationData.author_id }} on {{ educationData.published_at_formatted }}
                </span>
              </div>

              <div class="edetail-top-share">
                <span>Share:</span>
            <a v-bind:href="'https://www.facebook.com/sharer/sharer.php?u='+sharing.url+'&description='+sharing.description+'&p[title]='+sharing.title" class="btn btn-link btn-icon" target="_blank">
                  <icon-base
                    width="9"
                    height="18"
                    view-box="0 0 9 18"
                    icon-name="facebook2"
                  >
                    <icon-facebook2 />
                  </icon-base>
                </a>
                <a v-bind:href="'https://twitter.com/intent/tweet?url='+sharing.url+'&text='+sharing.description" class="btn btn-link btn-icon" target="_blank">
                  <icon-base
                    width="28"
                    height="21"
                    view-box="0 0 28 21"
                    icon-name="twitter"
                  >
                    <icon-twitter />
                  </icon-base>
                </a>
                <!-- <a href="" class="btn btn-link btn-icon">
                  <icon-base
                    width="15"
                    height="18"
                    view-box="0 0 15 18"
                    icon-name="pinterest"
                  >
                    <icon-pinterest />
                  </icon-base>
                </a> -->
                 <a v-bind:href="'https://www.linkedin.com/shareArticle?url='+sharing.url+'&description='+sharing.description+'&p[title]='+sharing.title" class="btn btn-link btn-icon" target="_blank">
                  <icon-base
                    width="18.33"
                    height="18.33"
                    view-box="0 0 18.33 18.33"
                    icon-name="linkedin"
                  >
                    <icon-linkedin />
                  </icon-base>
                </a>

                <a v-bind:href="'https://api.whatsapp.com/send?text='+sharing.url+'&description='+sharing.description+'&p[title]='+sharing.title" class="btn btn-link btn-icon" target="_blank">
                  <icon-base
                    width="18"
                    height="18"
                    view-box="0 0 18 18"
                    icon-name="whatsapp"
                  >
                    <icon-whatsapp />
                  </icon-base>
                </a>

              </div>
            </div>
          </div>
        </section>
        <!-- End of Education Detail Top -->

        <div class="edetail-bottom">
          <div class="container">
            <div class="edetail-row" v-if="educationData">
              <div class="edetail-col edetail-col-content col-8 edu-left">
                <!-- Education Detail Content -->
                <section class="section-edetail-content wblock">
                  <div class="edetail-text" v-html="educationData.desc">
                  </div>
                  <div>
                    <hr>
                    <ul class="tags" v-if="educationTags.length > 0">
                      <li v-for="nextEducation in educationTags"
                          :key="nextEducation.id">
                        <a style="cursor: pointer;" @click.prevent="searchEducation(nextEducation.tag.title)" :class="['tag-'+nextEducation.tag.color, 'tag']" >{{ nextEducation.tag.title }}</a>
                      </li>
                    </ul>
                  </div>
                </section>
                <!-- End of Education Detail Content -->

                <div class="edetail-other wblock">
                  <h2>Other articles</h2>
                  <div class="edetail-other-list" v-if="educationOtherArticles.length">
                    <ul class="list-black">
                      <li
                        v-for="nextEducationOtherArticle in educationOtherArticles"
                        :key="nextEducationOtherArticle.id"
                      >

                        <router-link :to="{name: 'educationdetail', params: {slug: nextEducationOtherArticle.slug}}">
                       <span style="font-weight: bold; color: #000000; !important" v-html="nextEducationOtherArticle.title">
                        </span>

                        </router-link>
                         by
                        <span style="font-weight: bold;font-size: 15px; color: #f5bb4c; !important" v-if="nextEducationOtherArticle.author_id != null"> {{ nextEducationOtherArticle.author_id }}</span>
                      </li>
                    </ul>

                  </div>
                   <div class="edetail-other-list" v-else>
                     No articles found
                   </div>
                </div>
              </div>
              <div class="edetail-col edetail-col-sidebar col-4 edu-right">
                <div class="wblock">
                  <!-- Education Related -->
                  <div class="edetail-related">
                    <h3>Related Posts</h3>

                    <div class="edetail-related-list row" v-if="educationRelatedArticles.length">
                      <div class="col-md-4 col-xl-12"  v-for="nexteducationRelatedArticles in educationRelatedArticles" :key="nexteducationRelatedArticles.id">
                        <div class="card card-dark card-article">
                          <div class="card-img-top">
                            <router-link :to="{name: 'educationdetail', params: {slug: nexteducationRelatedArticles.slug}}">
                              <img :src="nexteducationRelatedArticles.educationRelatedItemImageProps.image_url" alt="" @error="setAltEduImg" />
                            </router-link>
                          </div>
                          <div class="card-body">
                            <div class="card-title">
                              <router-link :to="{name: 'educationdetail', params: {slug: nexteducationRelatedArticles.slug}}">
                                {{ nexteducationRelatedArticles.title }}
                              </router-link>
                            </div>

                            <p class="card-text">
                            {{ nexteducationRelatedArticles.short_desc }}
                            </p>
                            <div class="more">
                              <router-link :to="{name: 'educationdetail', params: {slug: nexteducationRelatedArticles.slug}}" class="btn btn-link btn-icon">
                                <span>Learn More</span>
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
                          </div>
                        </div>
                      </div>
                    </div>
                    <div v-else>
                      No Posts found
                    </div>
                  </div>
                  <!-- End of Education Related -->

                  <div class="edetail-search">
                    <h3>Search our Site</h3>
                    <div class="search-form-w">
                      <icon-base
                        width="23.5"
                        height="23.5"
                        view-box="0 0 16 16"
                        icon-name="search"
                        ><icon-search
                      /></icon-base>
                      <input
                        type="text"
                        class="form-control"
                        placeholder="Find Services" v-model="text_search" v-on:keyup.enter="searchEducationText()"
                      />
                    </div>
                  </div>

                  <div class="edetail-tags">
                    <h3>By Tags</h3>
                    <div class="btns tags-list">
                     <button class="btn btn-light btn-sm"  v-for="nextTags in tags"
                              :key="nextTags.id" @click.prevent="searchEducation(nextTags.title)"

                      >
                        + {{ nextTags.title }} </router-link>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <section class="section-edetail-books">
              <h2>You May Also like these books</h2>

              <div class="row" v-if="educationAlsoLikeBooks.length">
                <div class="col-lg-3 col-sm-6"
                     v-for="nextEducationAlsoLikeBook in educationAlsoLikeBooks"
                     :key="nextEducationAlsoLikeBook.id"
                >
                  <div class="bcard">
                    <div class="bcard-img-top" >
                        <img style="height:350px !important" :src="nextEducationAlsoLikeBook.educationBookItemImageProps.image_url" alt="" @error="setAltEduImg" />
                    </div>
                    <div class="bcard-body">
                      <div class="bcard-title" style="cursor: pointer;">
                       {{ nextEducationAlsoLikeBook.title.substring(0,30) }}
                      </div>

                      <p class="bcard-text" style="height: 50px">
                        {{ nextEducationAlsoLikeBook.short_desc.substring(0,80) }}
                      </p>
                      <a v-bind:href="nextEducationAlsoLikeBook.educationOtherArticleItemBookProps.book_url"
                      class="btn btn-outline-primary btn-sm" target='_blank'>
                      Download
                    </a>
                    </div>
                  </div>
                </div>
              </div>
              <!-- <div class="view-all">
                <router-link to="">View All</router-link>
              </div> -->
            </section>
          </div>
          <div class="education-bottom-bg"></div>
        </div>
      </section>
    </main>

    <Footer />
  </div>
</template>

<script>
import Paginate from "vuejs-paginate";
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import Header from "./common/Header.vue";
import Footer from "./common/Footer.vue";
import IconBase from "./common/IconBase.vue";
import IconFacebook2 from "./common/icons/IconFacebook2.vue";
import IconTwitter from "./common/icons/IconTwitter.vue";
import IconPinterest from "./common/icons/IconPinterest.vue";
import IconLinkedin from "./common/icons/IconLinkedin.vue";
import IconWhatsapp from "./common/icons/IconWhatsapp.vue";
import IconSearch from "./common/icons/IconSearch.vue";
import IconArrowRight from "./common/icons/IconArrowRight.vue";
export default {
  name: "EducationDetail",
  components: {
    Header,
    Footer,
    Loading,
    Paginate,
    IconBase,
    IconFacebook2,
    IconTwitter,
    IconPinterest,
    IconLinkedin,
    IconWhatsapp,
    IconSearch,
    IconArrowRight
  },
  data() {
    return {
      education_slug: null,
      educationData: null,
      educationImageProps: null,
      text_search: null,
      educationOtherArticles: [],
      educationAlsoLikeBooks: [],
      educationRelatedArticles: [],
      educationTags: [],
      tags: [],
      isLoading: false,
      logged_user_id: null,
      fullPage: true,
      publicPath: local_image_path,
      sharing: {
        url: "https://dev.streamgeeks.com" + this.$route.fullPath,
        title: "",
        description: "",
        quote: "",
        hashtags: "",
        twitterUser: ""
      }
    };
  },
  created() {
    document.title = this.$route.meta.title;
    this.education_slug = this.$route.params.slug;
  },
  mounted() {
    this.scrollToTop();
    this.logged_user_id = localStorage.getItem("logged_user_id");
    this.loadEducationData();
  },
  watch: {
    $route(to, from) {
      this.$router.go();
    }
  },
  methods: {
    scrollToTop() {
      window.scrollTo(0,0);
    },
    setAltEduImg(event) {
      event.target.src = base_url + "images/emptyImg.png";
    },
    async searchEducation(tag) {
      this.$router.push({ name: "education", query: { tag: tag } });
    },
    async searchEducationText() {
      this.$router.push({
        name: "education",
        query: { key: this.text_search }
      });
    },
    async loadEducationData() {
      this.isLoading = true;
      const result = await this.callApi(
        "get",
        window.api_path + "education/" + this.education_slug,
        {}
      );
      if (result.status != 200) {
        this.$toast.error(result.data.message);
        this.educationData = null;
        this.educationImageProps = null;
        this.educationOtherArticles = null;
        this.educationAlsoLikeBooks = null;
        this.educationRelatedArticles = null;
        return;
      }
      this.educationData = result.data.education;
      this.sharing.title = this.educationData.title;
      this.sharing.description = this.educationData.short_desc;
      this.sharing.quote = this.educationData.short_desc;
      this.educationImageProps = result.data.educationImageProps;
      this.educationOtherArticles = result.data.educationOtherArticles;
      this.educationAlsoLikeBooks = result.data.educationAlsoLikeBooks;
      this.educationRelatedArticles = result.data.educationRelatedArticles;
      if (this.educationData) {
        this.loadEducationTags(this.educationData.id);
      }
      this.isLoading = false;
    }, // async loadEducationData() {
    async loadEducationTags(education_id) {
      const result = await this.callApi(
        "get",
        window.api_path + "education/" + education_id + "/getTags",
        {}
      );
      if (result.status != 200) {
        this.$toast.error(result.data.message);
        this.educationTags = [];
        return;
      }
      this.educationTags = result.data.educationTags;
      this.tags = result.data.tags;
    } // async loadEducationTags() {
  }
};
</script>
<style scoped>
.overlay {
  position: relative;
  z-index: 9;
}
.overlay:before {
  content: '';
  display: block;
  width: 100%;
  height: 100%;
  position: absolute;
  top: 0;
  right: 0;
  left: 0;
  bottom: 0;
  z-index:-1;
  background-color: rgba(0,0,0,0.5);
}
</style>
