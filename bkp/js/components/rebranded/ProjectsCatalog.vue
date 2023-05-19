<template>
  <div class="wrapper">
    <Header />

    <main class="main">
      <!-- Create Project Hero -->
      <section class="section-createproject-hero">
        <div class="container">
          <h1>Share a live streaming public systems</h1>
          <p>Input all the public system details and start streaming</p>
          <div class="btns">
            <router-link to="/" class="btn btn-primary btn-icon mx-auto">
              <icon-base
                width="13"
                height="13"
                view-box="0 0 13 13"
                icon-name="plus"
              ><icon-plus
              /></icon-base>
              <span>Share Public System</span>
            </router-link>
          </div>
          <h2 class="t-30 w700" style="margin-top: 68px;">Find Live Streaming Public Systems</h2>
          <section class="section-search section-search-projects">
            <div class="section-search-form">
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
                  placeholder="Find Services"
                />
                <button type="submit" class="btn btn-secondary">
                  <span class="text">Search</span>
                  <icon-base
                    width="23.5"
                    height="23.5"
                    view-box="0 0 16 16"
                    icon-name="search"
                  ><icon-search
                  /></icon-base>
                </button>
              </div>
              <div class="search-tags">
                <vue-tags-input
                  v-model="searchServiceTag"
                  :tags="searchServiceTags"
                  :autocomplete-items="filteredTags"
                  :add-only-from-autocomplete="true"
                  placeholder="Tags"
                  @tags-changed="
                newSearchServiceTags =>
                  (searchServiceTags = newSearchServiceTags)
              "
                />
              </div>
              <div class="search-params row">
                <div class="form-group col-md-6">
                  <v-select
                    v-model="searchServiceCategory"
                    label="label"
                    code="code"
                    item-text="label"
                    :options="searchServiceCategories"
                    :clearable="false"
                    :searchable="false"
                    class="form-control v-select-lg"
                    placeholder="Category"
                  ><template #open-indicator="{ attributes }">
                  <span v-bind="attributes">
                    <icon-base
                      width="14.42"
                      height="10.5"
                      view-box="0 0 14.42 10.5"
                      icon-name="triangle-3"
                    >
                      <icon-triangle-3 />
                    </icon-base>
                  </span> </template
                  ></v-select>
                </div>
                <div class="form-group col-md-3">
                  <input
                    type="text"
                    class="form-control form-control-lg"
                    placeholder="Min Budget"
                  />
                </div>
                <div class="form-group col-md-3">
                  <input
                    type="text"
                    class="form-control form-control-lg"
                    placeholder="Max Budget"
                  />
                </div>
              </div>
            </div>
          </section>
        </div>
        <div class="createproject-hero-bg"></div>
      </section>

      <!-- Projects -->
      <section class="section-projects section-projects-list">
        <div class="container">
          <ul class="nav nav-ctabs">
            <li
              class="nav-link"
              :class="projectsListTab == 1 ? 'active' : ''"
              @click="projectsListTab = 1"
            >
              Featured
            </li>
          </ul>

          <div class="tabs-content">
            <!-- Tab 1 -->
            <div class="tab-content">
              <div class="row" v-for="r in 5" :key="r" style="margin-bottom: 60px">
                <div v-for="i in 4" :key="i" class="col-lg-3 col-sm-6 col-xs-12">
                  <div class="card card-project">
                    <div class="card-img-top">
                      <router-link :to="{}">
                        <img :src="`${publicPath}no-image.jpg`" alt="" />
                        <span
                          class="is-featured"
                          :style="{
                            backgroundImage: `url(${publicPath}featured-bg.png)`
                          }"
                        >Featured</span
                        >
                      </router-link>
                    </div>
                    <div class="card-body">
                      <div class="card-title-vote">
                        <div class="card-title">
                          <router-link :to="{}">
                            Project name here
                          </router-link>
                        </div>
                        <button class="btn btn-link btn-icon btn-vote" @click="like((r * i) - 1)">
                          <LikeFilled v-if="items[(r * i) - 1].liked"/>
                          <LikeOutlined v-else />
                        </button>
                      </div>
                      <div class="card-category">
                        <div class="label">
                          <router-link to="/">Music Category</router-link>
                        </div>
                      </div>

                      <p class="card-text">
                        Lorem ipsum dolor sit amet, adipiscing elit. Fringilla
                        habitant eu porttitor eu. Libero sed feugiat luctus ac
                        quam purus.
                      </p>

                      <div class="card-price-more">
                        <div class="more">
                          <router-link to="/" class="btn btn-link btn-icon">
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
                        <div class="projectby">
                          <span>Public System by</span>
                          <router-link to="/projects/2">
                            <img
                              :src="`${publicPath}user-avatar-sm.jpg`"
                              alt=""
                              class="rounded-circle"
                            />
                          </router-link>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- End of Tab 1 -->
          </div>
        </div>
      </section>

      <!-- Search -->

      <!-- End of Search -->
    </main>

    <Footer />
  </div>
</template>

<script>
import Vue from "vue";
import VueTagsInput from "@johmun/vue-tags-input";
import vSelect from "vue-select";
import Header from "../common/Header.vue";
import Footer from "../common/Footer.vue";
import Paginate from "vuejs-paginate";
import IconBase from "../common/IconBase.vue";
import IconTriangle3 from "../common/icons/IconTriangle3.vue";
import IconPlus from "../common/icons/IconPlus.vue";
import IconSearch from "../common/icons/IconSearch.vue";
import IconLike4 from "../common/icons/IconLike4.vue";
import IconLike5 from "../common/icons/IconLike5.vue";
import LikeFilled from "./icons/LikeFilled";
import LikeOutlined from "./icons/LikeOutlined";

import IconArrowRight from "../common/icons/IconArrowRight.vue";

Vue.component("paginate", Paginate);
Vue.component("v-select", vSelect);
import "vue-select/dist/vue-select.css";

export default {
  name: "Projects Catalog",
  components: {
    Header,
    Footer,
    VueTagsInput,
    IconBase,
    IconTriangle3,
    IconPlus,
    IconSearch,
    IconLike4,
    IconLike5,
    LikeFilled,
    LikeOutlined,
    IconArrowRight
  },
  data() {
    return {
      items: [
        { liked: false },
        { liked: false },
        { liked: false },
        { liked: false },
        { liked: false },
        { liked: false },
        { liked: false },
        { liked: false },
        { liked: false },
        { liked: false },
        { liked: false },
        { liked: false },
        { liked: false },
        { liked: false },
        { liked: false },
        { liked: false },
        { liked: false },
        { liked: false },
        { liked: false },
        { liked: false }
      ],
      publicPath: local_image_path,
      searchServiceTag: "",
      searchServiceTags: [],

      autocompleteServiceTags: [
        {
          text: "OBS Setup"
        },
        {
          text: "Twitch Channel Setup"
        },
        {
          text: "Tech Support"
        },
        {
          text: "vMix Setup"
        },
        {
          text: "Lorem ipsum dolor"
        },
        {
          text: "Service sit amet consectetur"
        },
        {
          text: "NDI Configuration"
        }
      ],
      searchServiceCategory: "",
      searchServiceCategories: [
        {
          label: "Category 1"
        },
        {
          label: "Category 2"
        },
        {
          label: "Category 3"
        }
      ],
      sidebar_category: [
        { value: 0, text: "CHANGE ME!" }
        /*
        { value: 1, text: "Software" },
        { value: 2, text: "Computer" },
        { value: 3, text: "Cameras" },
        { value: 4, text: "Audio" },
        { value: 5, text: "Video Switcher" },
        { value: 6, text: "Converters" },
        { value: 7, text: "Other" },
*/
      ],
      sidebar_type: [
        { value: 0, text: "CHANGE ME!" }
        // { value: 1, text: "Church" },
        // { value: 2, text: "Business" },
        // { value: 3, text: "Sports" },
      ],
      sidebar_sort: [
        { value: 0, text: "CHANGE ME!" }
        // { value: 1, text: "Relevance" },
        // { value: 2, text: "Newest" },
        // { value: 3, text: "Oldest" },
        // { value: 4, text: "Random" },
      ],
      sidebar: {
        category: 0,
        type: 0,
        sort: 0
      },
      projectsListTab: 1
    };
  },

  created() {
    document.title = this.$route.meta.title;
  },

  mounted() {},

  methods: {
    clickCallback(page) {
      console.log("clickCallback page::");
      console.log(page);
    },
    like (id) {
      this.items[id].liked = !this.items[id].liked
    }
  }, // methods: {
  computed: {
    filteredTags() {
      return this.autocompleteServiceTags.filter(i => {
        return (
          i.text.toLowerCase().indexOf(this.searchServiceTag.toLowerCase()) !==
          -1
        );
      });
    }
  }
};
</script>
<style lang="scss" scoped>
.section-search-projects {
  margin-top: 0px;
  margin-bottom: -80px;
}
.section-createproject-hero {
  padding-bottom: 0;
}
.section-projects {
  padding-top: 150px;
  padding-bottom: 80px;
}
</style>

