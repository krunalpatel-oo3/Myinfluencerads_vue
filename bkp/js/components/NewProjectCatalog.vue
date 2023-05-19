<template>
  <div class="wrapper projects-catalog">
    <Header />

    <main class="main">
      <!-- Create Project Hero -->
      <section class="section-createproject-hero" style="margin-top: 20px">
        <div class="container">
          <h1 style="margin-bottom: 50px">Find Streaming Projects</h1>
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
                <button type="submit" 
                class="btn btn-secondary">
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
      <section class="section-projects section-projects-list" style="margin-top: 60px">
        <div class="container">
          <h2 class="section-h">{{ heading[tab] }}</h2>
          <div class="row mx-0" style="margin-bottom: 40px">
            <div class="badge-category">ALL</div>
            <v-select
              v-model="category"
              label="text"
              code="code"
              item-text="label"
              :options="categories"
              :clearable="false"
              class="form-control v-select-light pr-catalog-category-select"
              placeholder="Select option"
            ><template #open-indicator="{ attributes }">
                            <span v-bind="attributes">
                              <icon-base
                                width="12"
                                height="6.84"
                                view-box="0 0 12 6.84"
                                icon-name="angle-down"
                              >
                                <icon-angle-down />
                              </icon-base>
                            </span> </template>
            </v-select>
            <button class="add-system-btn" @click="$router.push({ name: 'Add System' })">
                <svg style="margin-right: 10px" width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M12.24 7.056H7.128V12.24H5.088V7.056H0V5.208H5.088V0H7.128V5.208H12.24V7.056Z" fill="white"/></svg>Add A System</button>
          </div>
          <div class="row mx-0 projects-nav">
            <a @click="tab = t" v-for="t in tabs" :class="tab === t ? 'active-link' : ''">{{ t }}</a>
          </div>
          <div v-if="tab === 'Popular'" class="project-list">
            <div class="project-card" v-for="(project, index) in popularProjects">
              <div class="row mx-0" style="border-bottom: 1px solid #010A28; padding: 15px 11px">
                <div class="col-3">
                  <img :src="`${publicPath}Rectangle 3665.png`" style="width: 100%" alt="">
                  <div class="row mx-0 mt-2 align-items-center">
                    <p class="text-white t-18 mb-0 w700">Project by</p>
                    <div class="ml-auto d-flex align-items-center">
                      <CommentIcon />
                      <span class="w500 text-white ml-1">10</span>
                    </div>
                  </div>
                  <div class="row mx-0 mt-2 align-items-center">
                    <img :src="`${publicPath}pexels-italo-melo-2379004.png`" style="height: 30px; border-radius: 50%" alt="">
                    <router-link to="" class="text-white t-14 mb-0 ml-2 link-hover">First and last name</router-link>
                  </div>
                </div>
                <div class="col-9" style="padding-left: 30px">
                  <div class="row mx-0">
                    <div class="row mx-0 w-100">
                      <router-link to="" class="card-project-title">Project name here</router-link>
                      <div class="card-tag"> <ThumbsUp /> POPULAR</div>
                      <div @click="like(index, 'popular')" :class="project.liked ? 'like-tag like-tag-active' : 'like-tag'">
                        <ThumbsUp :fill="'#F2A91C'" style="margin-right: 5px"/>
                        <span>5</span>
                      </div>
                    </div>
                    <router-link to="" class="category-link">Music Category</router-link>
                    <p class="t-18 t-color6" style="width: 100%; margin-top: 16px">Lorem ipsum dolor sit amet, adipiscing elit. Fringilla
                      habitant eu porttitor eu. Libero sed feugiat luctus ac quam purus. Lorem ipsum dolor sit amet, adipiscing elit. Fringilla
                      habitant eu porttitor eu. </p>
                  </div>
                  <h4 class="t-18 w500 text-white roboto">Project Stage:</h4>
                  <!-- <div class="row mx-0 align-items-center" style="width: 80%; padding-left: 12px">
                    <div class="project-stage project-stage-progress">
                      <div class="row mx-0 align-items-center">
                        <div class="project-icon">
                          <div class="progress-circle"></div>
                        </div>
                        <div class="stage-line stage-line-inactive"></div>
                      </div>
                      <p>Planning</p>
                    </div>
                    <div class="project-stage project-stage-progress">
                      <div class="row mx-0 align-items-center w-100">
                        <div class="project-icon">
                        </div>
                        <div class="stage-line stage-line-inactive"></div>
                      </div>
                      <p>In-Progress</p>
                    </div>
                    <div class="project-stage project-stage-complete">
                      <div class="row mx-0 align-items-center w-100">
                        <div class="project-icon">
                        </div>
                      </div>
                      <p>Complete</p>
                    </div>
                  </div> -->
                  <div class="row mx-0 align-items-center" style="width: 80%; padding-left: 12px">
                    <div class="project-stage">
                      <div class="row mx-0 align-items-center">
                        <div class="project-icon">
                          <DoneIcon />
                        </div>
                        <div class="stage-line stage-line-active"></div>
                      </div>
                      <p>Planning</p>
                    </div>
                    <div class="project-stage project-stage-progress">
                      <div class="row mx-0 align-items-center w-100">
                        <div class="project-icon">
                          <div class="progress-circle"></div>
                        </div>
                        <div class="stage-line stage-line-inactive"></div>
                      </div>
                      <p>In-Progress</p>
                    </div>
                    <div class="project-stage project-stage-complete">
                      <div class="row mx-0 align-items-center w-100">
                        <div class="project-icon">
                        </div>
                      </div>
                      <p>Complete</p>
                    </div>
                  </div>
                  <!-- <div v-else-if="project.project_phase == 'C'" class="row mx-0 align-items-center" style="width: 80%; padding-left: 12px">
                    <div class="project-stage">
                      <div class="row mx-0 align-items-center">
                        <div class="project-icon">
                          <DoneIcon />
                        </div>
                        <div class="stage-line stage-line-active"></div>
                      </div>
                      <p>Planning</p>
                    </div>
                    <div class="project-stage">
                      <div class="row mx-0 align-items-center w-100">
                        <div class="project-icon">
                          <DoneIcon />
                        </div>
                        <div class="stage-line stage-line-active"></div>
                      </div>
                      <p>In-Progress</p>
                    </div>
                    <div class="project-stage ">
                      <div class="row mx-0 align-items-center w-100">
                        <div class="project-icon">
                          <DoneIcon />
                        </div>
                      </div>
                      <p>Complete</p>
                    </div>
                  </div> -->
                  <div class="row mx-0 justify-content-end">
                    <router-link to="" class="text-white t-18 link-hover" style="margin-top: -25px">Learn More <ArrowRight style="margin-left: 15px"/></router-link>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div v-if="tab === 'Featured'" class="project-list">
            <div class="project-card" v-for="(project, index) in featuredProjects">
              <div class="row mx-0" style="border-bottom: 1px solid #010A28; padding: 15px 11px">
                <div class="col-3">
                  <img :src="`${publicPath}Rectangle 3665.png`" style="width: 100%" alt="">
                  <div class="row mx-0 mt-2 align-items-center">
                    <p class="text-white t-18 mb-0 w700">Project by</p>
                    <div class="ml-auto d-flex align-items-center">
                      <CommentIcon />
                      <span class="w500 text-white ml-1">10</span>
                    </div>
                  </div>
                  <div class="row mx-0 mt-2 align-items-center">
                    <img :src="`${publicPath}pexels-italo-melo-2379004.png`" 
                     style="height: 30px; border-radius: 50%" alt="">
                    <router-link to="" class="text-white t-14 mb-0 ml-2 link-hover">First and last name</router-link>
                  </div>
                </div>
                <div class="col-9" style="padding-left: 30px">
                  <div class="row mx-0">
                    <div class="row mx-0 w-100">
                      <router-link to="" class="card-project-title">>Project name here</router-link>
                      <div class="card-tag"> <DiamondIcon /> FEATURED</div>
                      <div @click="like(project.id, 'featured')" :class="project.liked ? 'like-tag like-tag-active' : 'like-tag'">
                        <ThumbsUp :fill="'#F2A91C'" style="margin-right: 5px"/>
                        <span>5</span>
                      </div>
                    </div>
                    <router-link to="" 
                    class="category-link">Music Category</router-link>
                    <p class="t-18 t-color6" style="width: 100%; margin-top: 16px">Lorem ipsum dolor sit amet, adipiscing elit. Fringilla
                      habitant eu porttitor eu. Libero sed feugiat luctus ac quam purus. Lorem ipsum dolor sit amet, adipiscing elit. Fringilla
                      habitant eu porttitor eu. </p>
                  </div>
                  <h4 class="t-18 w500 text-white roboto">Project Stage:</h4>
                  <div class="row mx-0 align-items-center" style="width: 80%; padding-left: 12px">
                    <div class="project-stage">
                      <div class="row mx-0 align-items-center">
                        <div class="project-icon">
                          <DoneIcon />
                        </div>
                        <div class="stage-line stage-line-active"></div>
                      </div>
                      <p>Planning</p>
                    </div>
                    <div class="project-stage project-stage-progress">
                      <div class="row mx-0 align-items-center w-100">
                        <div class="project-icon">
                          <div class="progress-circle"></div>
                        </div>
                        <div class="stage-line stage-line-inactive"></div>
                      </div>
                      <p>In-Progress</p>
                    </div>
                    <div class="project-stage project-stage-complete">
                      <div class="row mx-0 align-items-center w-100">
                        <div class="project-icon">
                        </div>
                      </div>
                      <p>Complete</p>
                    </div>
                  </div>
                  <div class="row mx-0 justify-content-end">
                    <router-link to="" class="text-white t-18 link-hover" style="margin-top: -25px">Learn More <ArrowRight style="margin-left: 15px"/></router-link>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div v-if="tab === 'Newest'" class="project-list">
            <div class="project-card" v-for="(project, index) in newestProjects">
              <div class="row mx-0" style="border-bottom: 1px solid #010A28; padding: 15px 11px">
                <div class="col-3">
                  <img :src="`${publicPath}Rectangle 3665.png`" style="width: 100%" alt="">
                  <div class="row mx-0 mt-2 align-items-center">
                    <p class="text-white t-18 mb-0 w700">Project by</p>
                    <div class="ml-auto d-flex align-items-center">
                      <CommentIcon />
                      <span class="w500 text-white ml-1">10</span>
                    </div>
                  </div>
                  <div class="row mx-0 mt-2 align-items-center">
                    <img :src="`${publicPath}pexels-italo-melo-2379004.png`" style="height: 30px; border-radius: 50%" alt="">
                    <router-link to="" class="text-white t-14 mb-0 ml-2 link-hover">First and last name</router-link>
                  </div>
                </div>
                <div class="col-9" style="padding-left: 30px">
                  <div class="row mx-0">
                    <div class="row mx-0 w-100">
                      <router-link to="" class="card-project-title">Project name here</router-link>
                      <div class="card-tag"> <StarIcon /> NEW</div>
                      <div @click="like(project.id, 'featured')" :class="project.liked ? 'like-tag like-tag-active' : 'like-tag'">
                        <ThumbsUp :fill="'#F2A91C'" style="margin-right: 5px"/>
                        <span>5</span>
                      </div>
                    </div>
                    <router-link to="" class="category-link">Music Category</router-link>
                    <p class="t-18 t-color6" style="width: 100%; margin-top: 16px">Lorem ipsum dolor sit amet, adipiscing elit. Fringilla
                      habitant eu porttitor eu. Libero sed feugiat luctus ac quam purus. Lorem ipsum dolor sit amet, adipiscing elit. Fringilla
                      habitant eu porttitor eu. </p>
                  </div>
                  <h4 class="t-18 w500 text-white roboto">Project Stage:</h4>
                  <div class="row mx-0 align-items-center" style="width: 80%; padding-left: 12px">
                    <div class="project-stage">
                      <div class="row mx-0 align-items-center">
                        <div class="project-icon">
                          <DoneIcon />
                        </div>
                        <div class="stage-line stage-line-active"></div>
                      </div>
                      <p>Planning</p>
                    </div>
                    <div class="project-stage project-stage-progress">
                      <div class="row mx-0 align-items-center w-100">
                        <div class="project-icon">
                          <div class="progress-circle"></div>
                        </div>
                        <div class="stage-line stage-line-inactive"></div>
                      </div>
                      <p>In-Progress</p>
                    </div>
                    <div class="project-stage project-stage-complete">
                      <div class="row mx-0 align-items-center w-100">
                        <div class="project-icon">
                        </div>
                      </div>
                      <p>Complete</p>
                    </div>
                  </div>
                  <div class="row mx-0 justify-content-end">
                    <router-link to="" class="text-white t-18 link-hover" style="margin-top: -25px">Learn More <ArrowRight style="margin-left: 15px"/></router-link>
                  </div>
                </div>
              </div>
            </div>
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
import Header from "./common/Header.vue";
import Footer from "./common/Footer.vue";
import Paginate from "vuejs-paginate";
import IconBase from "./common/IconBase.vue";
import IconTriangle3 from "./common/icons/IconTriangle3.vue";
import IconPlus from "./common/icons/IconPlus.vue";
import IconSearch from "./common/icons/IconSearch.vue";
import IconLike4 from "./common/icons/IconLike4.vue";
import IconLike5 from "./common/icons/IconLike5.vue";
import IconAngleDown from './common/icons/IconAngleDown';
import LikeFilled from "./rebranded/icons/LikeFilled";
import LikeOutlined from "./rebranded/icons/LikeOutlined";
import ThumbsUp from "./rebranded/icons/ThumbsUp";
import DoneIcon from "./rebranded/icons/DoneIcon";
import CommentIcon from "./rebranded/icons/CommentIcon";
import ArrowRight from "./rebranded/icons/ArrowRight";
import IconArrowRight from "./common/icons/IconArrowRight.vue";
import DiamondIcon from "./rebranded/icons/DiamondIcon";
import StarIcon from "./rebranded/icons/StarIcon";

Vue.component("paginate", Paginate);
Vue.component("v-select", vSelect);
import "vue-select/dist/vue-select.css";

export default {
  name: "New Projects Catalog",
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
    IconArrowRight,
    IconAngleDown,
    ThumbsUp,
    DoneIcon,
    CommentIcon,
    ArrowRight,
    DiamondIcon,
    StarIcon
  },
  data() {
    return {
      heading: {
        Popular: 'Most Popular Systems',
        Featured: 'Featured Systems',
        Newest: 'Newest Systems'
      },
      category: 'Select Category',
      categories: [
        'example 1',
        'example 2',
        'example 3'
      ],
      tabs: [
        'Popular',
        'Featured',
        'Newest'
      ],
      tab: 'Popular',
      popularProjects: [
        { liked: false },
        { liked: false },
        { liked: false },
        { liked: false },
        { liked: false }
      ],
      featuredProjects: [
        { liked: false },
        { liked: false },
        { liked: false },
        { liked: false },
        { liked: false }
      ],
      newestProjects: [
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
    like (id, type) {
      if (type === 'featured') {
        this.featuredProjects[id].liked = !this.featuredProjects[id].liked;
      } else if (type === 'new') {
        this.newestProjects[id].liked = !this.newestProjects[id].liked;
      } else if (type === 'popular') {
        this.popularProjects[id].liked = !this.popularProjects[id].liked;
      }
    },
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
.section-projects-list {
  background: #000927;
  clip-path: polygon(0 0, 100% 8%, 100% 100%, 0 100%);
}
.section-h {
  font-weight: 700;
  font-size: 42px;
  color: #FFFFFF;
  font-family: Poppins;
  margin-top: 60px;
}
.badge-category {
  height: 49px;
  width: 173px;
  border-radius: 14px;
  background: #F2A91C;
  font-size: 18px;
  font-weight: 700;
  border: none;
  color: white;
  display: flex;
  justify-content: center;
  align-items: center;
  cursor: pointer;
  &:hover {
    filter: brightness(1.1);
  }
}
.add-system-btn {
  background: #202C54;
  border-radius: 4px;
  width: 162px;
  height: 42px;
  margin-left: auto;
  font-size: 14px;
  color: white;
  border: none;
  cursor: pointer;
  &:hover {
    filter: brightness(1.3);
  }
}
.projects-nav {
  border-bottom: 2px solid rgba(255, 255, 255, 0.17);
  a {
    font-size: 18px;
    line-height: 54px;
    cursor: pointer;
    color: rgba(255, 255, 255, 0.53);
    padding: 0 20px;
    font-weight: 500;
    border-bottom: 4px solid transparent;
    &:hover {
      color: white;
    }
  }
  .active-link {
    border-bottom: 4px solid #F2A91C;
    color: white;
  }
}
.project-card {
  background: #202C54;
  border-radius: 8px;
  box-shadow: 0px 4px 26px rgba(0, 0, 0, 0.08);
  margin-top: 30px;
  .card-tag {
    margin-left: 15px;
    background: #F2A91C;
    border-radius: 8px;
    color: white;
    font-weight: 600;
    font-size: 13px;
    letter-spacing: 0.23em;
    padding: 2px 10px;
    line-height: 21px;
    height: 27px;
  }
  .category-link {
    width: 100%;
    color: #F2A91C;
  }
  .like-tag {
    cursor: pointer;
    border-radius: 8px;
    border: 2px solid #F2A91C;
    padding: 5px 10px;
    margin-left: auto;
    span {
      padding-left: 10px;
      font-size: 14px;
      color: white;
      border-left: 1px solid #FFFFFF;
    }
  }
  .card-project-title {
    font-size: 20px;
    font-weight: 700;
    color: white;
    cursor: pointer;
    &:hover {
      color: #F2A91C !important;
    }
  }
}
.stage-line {
  width: 150px;
  height: 3px;
  border-radius: 5px;
  margin-left: 5px;
}
.stage-line-active {
  background: #F2A91C;
}
.stage-line-inactive {
  background: #18213D;
}
.project-stage {
  width: 195px;
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  .project-icon {
    width: 35px;
    height: 35px;
    border: 2px solid #F2A91C;
    background: #F2A91C;
    color: white;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
  }
  p {
    width: 100%;
    margin-left: -12px;
    margin-bottom: 0;
    font-weight: 500;
    font-size: 16px;
    color: white;
    margin-top: 6px;
  }
}
.project-stage-progress {
  .project-icon {
    background: transparent;
    .progress-circle {
      width: 25px;
      height: 25px;
      border-radius: 50%;
      background: #F2A91C;
    }
  }
  p {
    margin-left: -23px;
  }
}
.project-stage-complete {
  .project-icon {
    border: 2px solid #F2A91C;
    background: #18213D;
  }
  p {
    margin-left: -14px;
  }
}
.project-stage-active {
  background: #F2A91C !important;
  border: 2px solid #FFFFFF !important;
}
.project-votes {
  height: 83px;
  width: 76px;
  border: 2px solid #F2A91C;
  border-radius: 8px;
  margin-right: 30px;
  margin-top: 20px;
}
.c-pointer {
  cursor: pointer;
}
.project-title {
  cursor: pointer;
  &:hover {
    color: #F2A91C !important;
  }
}
.project-cards-row {
  .card-project {
    background: #202C54;
  }
  margin-top: 40px;
  .col-3 {
    padding-left: 15px !important;
    &:nth-of-type(1) {
      padding-left: 0 !important;
    }
  }
}
.learn-more {
  height: 31px;
  width: 107px;
  border: 1px solid #F2A91C;
  background: transparent;
  font-size: 12px;
  color: white;
  border-radius: 8px;
  margin: 10px 0;
  &:hover {
    background: #F2A91C;
  }
}
</style>

