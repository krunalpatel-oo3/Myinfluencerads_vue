<template>
  <div class="wrapper projects-catalog">
    <Header />

    <main class="main">
      <!-- Create Project Hero -->
      <section class="section-createproject-hero" style="margin-top: 20px">
        <div class="container">
          <h1 class="text-center" style="margin-bottom: 50px">Find Streaming Products <br> by Category</h1>
          <section class="section-search section-search-projects">
            <div class="section-search-form">
              <label class="custom-label">Search</label>
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
                  placeholder="Find Products"
                  v-model="searchText"
                  @keyup.enter="getProducts"
                />
                <button
                  @click.prevent="getProducts"
                  type="submit"
                  class="btn btn-secondary"
                  :disabled="isLoading"
                >
                  <div v-if="isLoading" class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                  </div>
                  <span class="text" v-else>Search</span>
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
                <label class="custom-label">Tags</label>
                <vue-tags-input
                  v-model="searchServiceTag"
                  :tags="searchServiceTags"
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
                  <label class="custom-label">Category</label>
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
                  <label class="custom-label">Min Budget</label>
                  <input
                    v-model="minBudget"
                    type="number"
                    class="form-control form-control-lg"
                    placeholder="Min Budget"
                  />
                </div>
                <div class="form-group col-md-3">
                  <label class="custom-label">Max Budget</label>
                  <input
                    v-model="maxBudget"
                    type="number"
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

      <!-- Products -->
      <section class="section-projects section-projects-list section-product-page">
        <div class="container">
          <h2 class="section-h">{{ heading[tab] }}</h2>
          <div class="row custom-row align-items-center justify-content-between" style="margin-bottom: 40px">
            <div class="col-xl-10 col-lg-9 col-md-9 custom-cat-btn">
              <button class="badge-category" @click="loadCatalog">ALL</button>
              <!-- Add category dropdown -->
              <div class="form-group">
                <v-select
                  v-model="productCategory"
                  label="text"
                  code="id"
                  item-text="text"
                  :clearable="true"
                  :searchable="true"
                  :options="filterCategories"
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
                    </span></template
                  >
                </v-select>
              </div>
              <!-- Added sub-category dropdown -->
              <div class="form-group">
                <v-select
                v-model="productSubCategory"
                  label="text"
                  code="id"
                  item-text="text"
                  :clearable="true"
                  :searchable="true"
                  :options="productSubCategoryOptions"
                  @input="changeSubCategory($event)"
                  class="form-control v-select-lg custom-sub-category custom-select-box"
                  placeholder="Sub-Category"
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
                    </span></template
                  >
                </v-select>
              </div>
            </div>
            <div class="col-xl-2  col-lg-3 col-md-3 text-right">
              <button class="add-system-btn" @click="$router.push({ name: 'Add Product' })">
                  <svg style="margin-right: 10px" width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12.24 7.056H7.128V12.24H5.088V7.056H0V5.208H5.088V0H7.128V5.208H12.24V7.056Z" fill="white"/>
                  </svg>Add A Product</button>
            </div>
          </div>
          <div class="row mx-0 projects-nav">
            <a @click="changeTab(t)" v-for="t in tabs" :class="tab === t ? 'active-link' : ''">{{ t }}</a>
          </div>
          <div v-if="isLoading" class="catalog-skeleton">
            <div class="skeleton" v-for="i in 5" :key="i"></div>
          </div>
          <div v-else class="project-list">
            <div class="project-card" v-for="(prod, index) in products" :key="index">
              <div class="row mx-0" style="border-bottom: 1px solid #010A28; padding: 15px 11px">
                <div class="col-md-3 product-card-img">
                  <img class="popular-card-image" :src="prod.product_image ||`${publicPath}no-image.jpg`" style="width: 100%" alt="" @error="setAltProdImg">
                  <div class="row mx-0 mt-2 align-items-center">
                    <p class="text-white t-18 mb-0 w700">Product by</p>
                    <div class="ml-auto d-flex align-items-center">
                      <CommentIcon />
                      <span class="w500 text-white ml-3">{{ prod.reviews_count }}</span>
                    </div>
                  </div>
                  <div class="row mx-0 mt-2 align-items-center">
                    <img :src="prod.creator.profile_photo || `${publicPath}user-avatar-sm.jpg`" style="height: 30px; border-radius: 50%" alt="" @error="setAltUserImg">
                    <router-link :to="{ name: 'userprofile', params: { slug: prod.creator.id } }" class="text-white t-14 mb-0 ml-2 link-hover">{{ prod.creator.full_name }}</router-link>
                  </div>
                </div>
                <div class="col-md-9 project-right" style="padding-left: 30px">
                  <div class="row mx-0">
                    <div class="row mx-0 w-100 align-items-center">
                      <router-link :to="{ name: 'Product Page', params: { slug: prod.slug }}"
                                   class="card-project-title">{{ prod.name }}</router-link>
                      <div class="card-tag product-card-tag">
                        <ThumbsUp v-if="tab == 'Popular'" :fill="'#ffffff'" style="margin-right: 5px"/>
                        <DiamondIcon v-if="tab == 'Featured'" :fill="'#ffffff'" style="margin-right: 5px"/>
                        <NewestIcon v-if="tab == 'Newest'"/>
                        {{ tab.toUpperCase() }}
                      </div>
                      <div class="like-tag product-card-like-tag">
                        <ThumbsUp :fill="'#F2A91C'" style="margin-right: 5px"/>
                        <span>{{ prod.likes }}</span>
                      </div>
                    </div>
                    <router-link v-if="prod.manufacturer" to="" class="text-white t-18 mb-1 link-hover" style="margin-top: -5px;">
                      {{ prod.manufacturer }}
                    </router-link>
                    
                    <div class="row mx-0 w-100">
                      <router-link to="" class="category-link" v-if="prod.category">
                        {{ prod.category.title }}</router-link>
                      <span class="category-link" style="margin: 0 7px">|</span>
                      <router-link to="" class="category-link" v-if="prod.sub_category">{{ prod.sub_category.title }}</router-link>
                    </div>
                    <p class="t-18 t-color6 product-description" style="width: 100%; margin-top: 16px">
                      {{ prod.desc }}
                    </p>
                  </div>
                  <div class="row mx-0 mt-auto">
                    <h4 class="t-18 w500 text-white roboto pro-rating">Product rating:</h4>
                    <div class="row mx-0 w-100 rating-block">
                      <RatingStar v-for="i in prod.overall_ratings" :key="i" class="rating-star" :fill="'#FB8200'" />
                      <RatingStar v-for="i in (5 - prod.overall_ratings)" :key="i" class="rating-star" />
                    </div>
                  </div>
                  <div class="row mx-0 justify-content-end learnmore-btn">
                    <router-link :to="{ name: 'Product Page', params: { slug: prod.slug }}" class="text-white t-18 link-hover" style="margin-top: -25px">
                      Learn More <ArrowRight style="margin-left: 15px"/>
                   </router-link>
                  </div>
                </div>
              </div>
            </div>

            <!-- Pagination -->
            <paginate
              v-if="totalPages > 1"
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
import NewestIcon from "./rebranded/icons/NewestIcon";
import StarIcon from "./rebranded/icons/StarIcon";
import RatingStar from "./rebranded/icons/RatingStar";
import Paginate from "vuejs-paginate";

Vue.component("paginate", Paginate);
Vue.component("v-select", vSelect);
import "vue-select/dist/vue-select.css";

export default {
  name: "ProductsCatalog",
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
    NewestIcon,
    StarIcon,
    RatingStar,
    Paginate
  },
  data() {
    return {
      heading: {
        Popular: 'Most Popular Products',
        Featured: 'Featured Products',
        Newest: 'Newest Products'
      },
      category: 'Category',
      subCategory: 'Sub-Category',
      tabs: [
        'Popular',
        'Featured',
        'Newest'
      ],
      tab: 'Popular',
      publicPath: local_image_path,
      searchServiceTag: "",
      searchServiceCategory: "",
      searchServiceCategories: [],
      filterCategories: [],
      productSubCategoryOptions: [],
      searchServiceTags: [],
      isLoading: true,
      products: [],
      totalPages: 0,
      page: 1,
      searchText: '',
      minBudget: '',
      maxBudget: '',
      productCategory: null,
      productSubCategory: null,
      selectedId: null,
      selectedSubCatId: null
    };
  },

  created() {
    document.title = this.$route.meta.title;
  },

  mounted() {
    this.getProducts();
    this.loadCategories();
    this.scrollToTop();
  },

  methods: {
    setAltProdImg(event) {
        event.target.src = base_url + "images/emptyImg.png";
    },
    setAltUserImg(event) {
        event.target.src = base_url + "default-user-avatar-sm.jpg";
    },
    scrollToTop() {
      window.scrollTo(0,0);
    },
    // Filter data on change category start here
    changeCategory(e){
      this.productSubCategory = null;
      this.productSubCategoryOptions = [];
      if(e == null){
        this.selectedId = null;
        this.selectedSubCatId = null;
        this.getProducts();
        return;
      }else{
        this.selectedId = e.id;
        this.getProducts();
        return;
      }
    },
    changeSubCategory(e){
      if(e == null){
        this.selectedSubCatId = null;
        this.productSubCategory = null;
        this.getProducts();
        return;
      }else{
        this.selectedSubCatId = e.id;
        this.getProducts();
        return;
      }
    },
    // Filter data on change category end here
    async loadCatalog() {
      this.selectedId = null;
      this.selectedSubCatId = null;
      this.productCategory = null;
      this.productSubCategory = null;
      this.productSubCategoryOptions = [];
      if (!this.isLoading) this.isLoading = true
      const res = await Promise.all([
        this.callApi("post", window.api_path + "product/getProductList")
      ])
      this.products = res[0].data.data.products
      this.totalPages = res[0].data.data.totalPage
      this.isLoading = false
    },
    async getProducts () {
      window.scrollTo(0,0);
      this.isLoading = true
      const res = await this.callApi("post",
        window.api_path + "product/getProductList",
        {
          page: this.page,
          data_type: this.tab.toLocaleLowerCase(),
          search_text: this.searchText,
          min_budget: this.minBudget,
          max_budget: this.maxBudget,
          category: this.selectedId,
          sub_category: this.selectedSubCatId
        })
      this.products = res.data.data.products
      this.page = res.data.data.page
      this.totalPages = res.data.data.totalPages
      this.isLoading = false
    },
    changeTab (tabName) {
      this.tab = tabName
      tabName = tabName.toLowerCase()
      if (this.page === 1) {
        this.getProducts()
        return
      }
      this.page = 1
    },
    async loadSubcategories (id) {
      const res = await this.callApi(
        "get",
        window.api_path + "product/getproductsubcategories/" + id
      )
      if (res.status !== 200) {
        this.$toast.error(res.data.message);
        return;
      }
      if (res.data.data.productsubcategories) {
        this.productSubCategoryOptions = []
        Object.keys(res.data.data.productsubcategories).forEach(cat => {
          this.productSubCategoryOptions.push({
            id: cat,
            text: res.data.data.productsubcategories[cat]
          })
        })
      }
    },
    async loadCategories() {
      const res = await this.callApi(
        "get",
        window.api_path + "product/getproductcategories"
      );
      if (res.status !== 200) {
        this.$toast.error(res.data.message);
        this.isLoading = false;
        return;
      }
      if (res.data.data.productcategories) {
        Object.keys(res.data.data.productcategories).forEach(cat => {
          this.filterCategories.push({
            id: cat,
            text: res.data.data.productcategories[cat]
          })
        })
      }
    },
  },
  watch: {
    page () {
      this.getProducts()
    },
    productCategory (val) {
      if (val.id) {
        this.loadSubcategories(val.id)
      }
    },
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
  // padding-top: 150px;
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
.rating-star {
  margin-right: 2px;
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
  z-index: 999;
  &:hover {
    filter: brightness(1.1);
  }
}
.add-system-btn {
  background: #202C54;
  border-radius: 4px;
  width: 100%;
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
    width: fit-content;
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
    cursor: pointer;
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
.product-description{
  display: -webkit-box;
    -webkit-line-clamp: 4;
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: 88px;
    line-height: 22px;
}

.product-card-img img {
    height: 171px;
     object-fit: cover;
    object-position: center;
}


@media all and (min-width:768px){
  .product-description{
    display: -webkit-box;
    -webkit-line-clamp: 4;
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: 88px;
  }
}

@media all and (max-width:767px){
  .popular-card-image {
    margin-bottom: 20px;
    height: 250px !important;
  }
  .project-right {
    padding-left: 7px !important;
    margin-top: 15px;
  }
  .rating-block svg {
    width: 25px;
  }
  .pro-rating{
    font-size: 16px !important;
  }
  .learnmore-btn a {
    font-size: 16px !important;
}

.learnmore-btn a svg {
    width: 18px;
}
}

@media all and (max-width:575px){
  .card-tag.product-card-tag {
    order: 2;
    width: 100%;
    margin: 15px auto !important;
    text-align: center;
  }
  .rating-block svg {
    width: 20px;
  }


}

</style>


