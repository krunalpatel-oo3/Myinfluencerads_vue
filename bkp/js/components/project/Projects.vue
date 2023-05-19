<template>
  <div class="wrapper projects-catalog">
    <Header />

    <main class="main">
      <!-- Create Project Hero -->
      <section class="section-createproject-hero" style="margin-top: 20px">
        <div class="container">
          <h1 class="text-center" style="margin-bottom: 50px">Find Streaming Projects</h1>
        </div>
        <div class="createproject-hero-bg"></div>
      </section>

      <!-- Search -->
      <section class="section-search section-search-projects">
        <div class="section-search-form">
          <label class="custom-label">Search</label>
          <div class="search-form-w">
            <icon-base
              width="23.5"
              height="23.5"
              view-box="0 0 16 16"
              icon-name="search"
            >
              <icon-search
              />
            </icon-base>
            <input
              type="text"
              class="form-control"
              v-model="searchText"
              placeholder="Find Projects"
              @keyup.enter="getProjects"
            />
            <button
              type="submit"
              @click.prevent="getProjects"
              class="btn btn-secondary"
              :disabled="isLoading"
            >
              <div v-if="isLoading" class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
              </div>
              <span v-else class="text">Search</span>
              <icon-base
                width="23.5"
                height="23.5"
                view-box="0 0 16 16"
                icon-name="search"
              >
                <icon-search
                />
              </icon-base>
            </button>
          </div>
          <div class="search-tags custom-search">
            <label class="custom-label">Tags</label>
            <vue-tags-input
              v-model="searchServiceTag"
              :tags="searchServiceTags"
              :autocomplete-items="filteredTags"
              placeholder="Tags"
              @tags-changed="
                (newSearchServiceTags) =>
                  (searchServiceTags = newSearchServiceTags)
              "
            />
          </div>
          <div class="search-params row">
            <div class="form-group col-md-6">
              <label class="custom-label">Category</label>
              <v-select
                v-model="searchServiceCategory"
                label="text"
                code="id"
                item-text="text"
                :options="categories"
                :clearable="true"
                :searchable="true"
                class="form-control v-select-lg"
                placeholder="Category"
              >
                <template #open-indicator="{ attributes }">
                  <span v-bind="attributes">
                    <icon-base
                      width="14.42"
                      height="10.5"
                      view-box="0 0 14.42 10.5"
                      icon-name="triangle-3"
                    >
                      <icon-triangle-3 />
                    </icon-base>
                  </span></template
                >
              </v-select>
            </div>
            <div class="form-group col-md-3">
              <label class="custom-label">Min Budget</label>
              <input
                type="text"
                class="form-control form-control-lg"
                v-model="min_budget"
                placeholder="Min Budget"
              />
            </div>
            <div class="form-group col-md-3">
              <label class="custom-label">Max Budget</label>
              <input
                type="text"
                class="form-control form-control-lg"
                v-model="max_budget"
                placeholder="Max Budget"
              />
            </div>
          </div>
        </div>
      </section>
      <!-- End of Search -->

      <!-- Projects -->
      <section class="section-projects section-projects-list">
        <div class="container">
          <h2 class="section-h">{{ heading[tab] }}</h2>
          <div class="row mx-0 custom-row align-items-center" style="margin-bottom: 40px">
            <div class="col-md-6 custom-cat-btn">
              <button class="badge-category" @click="loadCatalog">ALL</button>
              <div class="form-group">
                <v-select
                  v-model="selectCategory"
                  label="text"
                  item-text="text"
                  :options="categories"
                  :clearable="true"
                  :searchable="true"
                  @input="changeCategory($event)"
                  class="form-control v-select-lg custom-select-box"
                  placeholder="Category"
                >
                  <template #open-indicator="{ attributes }">
                    <span v-bind="attributes">
                      <icon-base
                        width="14.42"
                        height="10.5"
                        view-box="0 0 14.42 10.5"
                        icon-name="triangle-3"
                      >
                      <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5.99996 6.92017C5.78489 6.92017 5.56986 6.83805 5.40589 6.67417L0.246169 1.51439C-0.0820564 1.18616 -0.0820564 0.653997 0.246169 0.325904C0.574262 -0.00218935 1.10632 -0.00218935 1.43457 0.325904L5.99996 4.89156L10.5654 0.326063C10.8936 -0.00202989 11.4256 -0.00202989 11.7537 0.326063C12.0821 0.654157 12.0821 1.18632 11.7537 1.51455L6.59403 6.67433C6.42998 6.83824 6.21494 6.92017 5.99996 6.92017Z" fill="white"/>
                      </svg>
                      </icon-base>
                    </span>
                  </template>
                </v-select>
              </div>
            </div>
            <div class="col-md-6 text-right">
              <button class="add-system-btn" @click="$router.push({ name: 'projectadd' })">
                <svg style="margin-right: 10px" width="13" height="13" viewBox="0 0 13 13" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                  <path d="M12.24 7.056H7.128V12.24H5.088V7.056H0V5.208H5.088V0H7.128V5.208H12.24V7.056Z" fill="white" />
                </svg>
                Add A System
              </button>
            </div>
          </div>
          <div class="row mx-0 projects-nav">
            <a @click="changeTab(t)" v-for="t in tabs" :class="tab === t ? 'active-link' : ''">{{ t }}</a>
          </div>
          <div v-if="isLoading" class="catalog-skeleton">
            <div class="skeleton" v-for="i in 5" :key="i"></div>
          </div>
          <div v-else :class="customClass">
            <div v-if="projects.length <= 0" class="notification notice closeable w-100"><h3 class="mt-3 text-center text-white">No record found..</h3></div>
            <ProjectCatalogCard
              v-for="(project, index) in projects"
              :key="index"
              :project="project"
              :type="tab.toLowerCase()"
              @vote="voteProject"
              :getProjects="getProjects"
            />
            <paginate
              v-if="projects.length > 0"
              v-model="page"
              :page-count="totalPages"
              :page-range="3"
              :margin-pages="2"
              :prev-text="'Prev'"
              :next-text="'Next'"
              :container-class="'pagination'"
              :page-class="'page-item'"
            >
            </paginate>
          </div>
        </div>
      </section>
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
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import IconBase from "../common/IconBase.vue";
import IconTriangle3 from "../common/icons/IconTriangle3.vue";
import IconPlus from "../common/icons/IconPlus.vue";
import IconSearch from "../common/icons/IconSearch.vue";
import IconLike4 from "../common/icons/IconLike4.vue";
import IconLike5 from "../common/icons/IconLike5.vue";
import IconArrowRight from "../common/icons/IconArrowRight.vue";
import IconAngleDown from "../common/icons/IconAngleDown";
import ArrowRight from "../rebranded/icons/ArrowRight.vue";
import ThumbsUp from "../rebranded/icons/ThumbsUp.vue";
import DoneIcon from "../rebranded/icons/DoneIcon.vue";
import CommentIcon from "../rebranded/icons/CommentIcon.vue";
import DiamondIcon from "../rebranded/icons/DiamondIcon.vue";
import StarIcon from "../rebranded/icons/StarIcon.vue";
import ProjectCatalogCard from "./ProjectCatalogCard"

Vue.component("paginate", Paginate);
Vue.component("v-select", vSelect);
import "vue-select/dist/vue-select.css";

export default {
  name: "Projects",
  components: {
    Header,
    Footer,
    VueTagsInput,
    IconBase,
    Loading,
    IconTriangle3,
    IconPlus,
    IconSearch,
    IconLike4,
    IconLike5,
    IconArrowRight,
    ArrowRight,
    ThumbsUp,
    DoneIcon,
    CommentIcon,
    DiamondIcon,
    StarIcon,
    IconAngleDown,
    ProjectCatalogCard
  },
  data() {
    return {
      heading: {
        Popular: "Most Popular Systems",
        Featured: "Featured Systems",
        Newest: "Newest Systems"
      },
      category: "Select Category",
      categories: [],
      tabs: [
        "Popular",
        "Featured",
        "Newest"
      ],
      tab: "Popular",
      isLoading: true,
      isAuthenticated: window.isAuthenticated,
      logged_user_id: null,
      publicPath: local_image_path,
      searchServiceTag: "",
      searchServiceTags: [],
      autocompleteTagItems: [],
      autocompleteServiceTags: [],
      searchServiceCategory: "",
      searchServiceCategories: [],
      totalPages: 0,
      projects: [],
      page: 1,
      limit: 5,
      searchText: '',
      min_budget: "",
      max_budget: "",
      customClass: "project-list",
      selectedId: '',
      selectCategory: null,
    };
  },

  created() {
    document.title = this.$route.meta.title;
  },

  mounted() {
    this.loadCatalog();
    this.scrollToTop();
  },

  methods: {
    scrollToTop() {
      window.scrollTo(0,0);
    },
    // Filter data on change category start here
    changeCategory(e){
      if(e == null){
        this.selectedId = null;
        this.getProjects();
        return;
      }else{
        this.selectedId = e.id;
        this.getProjects();
        return;
      }
    },
    // Filter data on change category end here
    async loadCatalog() {
      this.selectCategory = null
      this.isLoading = true
      const res = await Promise.all([
        this.callApi("post", window.api_path + "getTagsList", { mode: "only_title" }),
        this.callApi("post", window.api_path + "getCategoriesList", { mode: "selection" }),
        this.callApi("post", window.api_path + "project/publiclist", { limit: this.limit })
      ])
      this.autocompleteTagItems = res[0].data.tags
      this.categories = res[1].data.categories
      this.projects = res[2].data.data.projects
      this.totalPages = res[2].data.data.totalPages
      this.isLoading = false
    },
    async getProjects () {
      this.isLoading = true
      console.log("test: ", this.searchServiceCategory);
      var category_id = this.selectedId != "" && this.selectedId != null ? this.selectedId : (this.searchServiceCategory != null ? this.searchServiceCategory.id : "");
      const res = await this.callApi("post",
      window.api_path + "project/publiclist",
        {
          page: this.page,
          limit: this.limit,
          data_type: this.tab.toLocaleLowerCase(),
          search_text: this.searchText,
          min_budget: this.min_budget,
          max_budget: this.max_budget,
          category: category_id
        })
      this.scrollToTop();
      this.projects = res.data.data.projects
      this.page = res.data.data.page
      this.totalPages = res.data.data.totalPages
      this.isLoading = false
    },
    changeTab (tabName) {
      this.customClass = tabName == "Featured" || tabName == "Newest" ? "project-grid" : "project-list";
      this.limit = tabName == "Featured" || tabName == "Newest" ? 4 : 5;
      this.tab = tabName
      tabName = tabName.toLocaleLowerCase()
      if (this.page === 1) {
        this.getProjects()
        return
      }
      this.page = 1
    },
    async voteProject({ project_id, type }) {
      if (!this.isAuthenticated || !localStorage.getItem("logged_user_id")) {
        this.$toast.error("To vote you need to login firstly !");
        return;
      }
      const result = await this.callApi(
        "post",
        window.api_path + "voteProject",
        {
          project_id: project_id,
          user_id: localStorage.getItem("logged_user_id")
        }
      );
      if (result.status === 200) {
        this.$toast.success(result.data.message);
        [...this.projects_new, ...this.projects_popular, ...this.projects_featured].forEach(project => {
          if (project_id === project.id) {
            if (type === 'new' && !this.projects_new.find(el => el.id === project_id).is_already_voted) {
              this.projects_new.find(el => el.id === project_id).project_votes_count++
              this.projects_new.find(el => el.id === project_id).is_already_voted = true
            } else if (type === 'featured' && !this.projects_featured.find(el => el.id === project_id).is_already_voted) {
              this.projects_featured.find(el => el.id === project_id).project_votes_count++
              this.projects_featured.find(el => el.id === project_id).is_already_voted = true
            } else if (type === 'popular' && !this.projects_popular.find(el => el.id === project_id).is_already_voted) {
              this.projects_popular.find(el => el.id === project_id).project_votes_count++
              this.projects_popular.find(el => el.id === project_id).is_already_voted = true
            }
          }
        })
        return
      }
      [...this.projects_new, ...this.projects_popular, ...this.projects_featured].forEach(project => {
        if (project_id === project.id) {
          if (type === 'new' && this.projects_new.find(el => el.id === project_id).is_already_voted) {
            this.projects_new.find(el => el.id === project_id).project_votes_count--
            this.projects_new.find(el => el.id === project_id).is_already_voted = false
          } else if (type === 'featured' && this.projects_featured.find(el => el.id === project_id).is_already_voted) {
            this.projects_featured.find(el => el.id === project_id).project_votes_count--
            this.projects_featured.find(el => el.id === project_id).is_already_voted = false
          } else if (type === 'popular' && this.projects_popular.find(el => el.id === project_id).is_already_voted) {
            this.projects_popular.find(el => el.id === project_id).project_votes_count--
            this.projects_popular.find(el => el.id === project_id).is_already_voted = false
          }
        }
      })
      this.$toast.error(result.data.message);
    },
    async loadTags() {
      const result = await this.callApi(

      );
      if (result.status != 200) {
        this.$toast.error(result.data.message);
        this.autocompleteTagItems = [];
        return;
      }
      //
      this.autocompleteTagItems = result.data.tags;
    },
    async loadCategoriesList() {
      const result = await this.callApi(
        "post",
        window.api_path + "getCategoriesList",
        { mode: "selection" }
      );
      if (result.status !== 200) {
        this.$toast.error(result.data.message);
        this.categories = [];
        return;
      }
      this.searchServiceCategories = result.data.categories;
      this.categories = result.data.categories;
    }
  },
  watch: {
    page () {
      this.getProjects()
    }
  },
  computed: {
    filteredTags() {
      return this.autocompleteTagItems.filter((i) => {
        return (
          i.text.toLowerCase().indexOf(this.searchServiceTag.toLowerCase()) !==
          -1
        );
      });
    },
  }
};
</script>
<style lang="scss" scoped>

  html,body{
    overflow-x:hidden;
  }
  
  .section-search-projects {
    margin-top: 0px;
    margin-bottom: -80px;
  }

  .section-createproject-hero {
    padding-bottom: 0;
  }

  .section-projects {
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
    // height: 49px;
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

    
  }
  .active-link {
      border-bottom: 4px solid #F2A91C !important;
      color: white;
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

    img {
      border-radius: 4px;
      height: 171px;
      object-fit: cover;
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
  .spinner-border {
    width: 1rem;
    height: 1rem;
  }
  .project-grid {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: start;
    -ms-flex-pack: start;
    justify-content: flex-start;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    margin-top: 80px;
  }

.project-grid > div{
    width: calc(25% - 12px);
    margin-left:15px;
    margin-bottom: 60px;
}

.project-grid > div:nth-child(4n + 1){
    margin-left:0;
}

.project-grid .pagination {
    width: 100%;
}

.project-grid .card .card-category {
    margin: 10px 0;
    text-transform: capitalize;
}

.project-grid .card .card-body .card-price-more{
    padding:11px 15px;
}

.project-grid .card .card-body .more a{
    font-size: 12px;
    margin: 0;
}

.project-grid .card-body .proj-descs{
    font-size:14px;
}   

html{
  overflow-x: hidden;
}

@media all and (max-width:1024px){
  .project-grid > div{
    width: calc(33.33% - 12px);
  }
  .project-grid > div:nth-child(4n+1){
    margin-left:15px;
  }
  .project-grid > div:nth-child(3n+1){
    margin-left:0px;
  } 
}
@media all and (max-width:767px){
  .project-grid > div{
    width: calc(50% - 12px);
  }
  .project-grid > div:nth-child(3n+1){
    margin-left:15px;
  }
  .project-grid > div:nth-child(2n+1){
    margin-left:0px;
  }
}
@media all and (max-width:767px){
  .project-grid > div{
    width: 100%;
    margin-left:0 !important;
    margin-bottom:20px;
  }
  .add-system-btn{
    width: 100%;
  }
}
</style>