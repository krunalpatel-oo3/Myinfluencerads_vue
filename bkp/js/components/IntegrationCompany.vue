<template>
  <div class="integration-company-page">
    <Header />
    <img class="wave-bg" :src="`${publicPath}wave-upload.png`" alt="">
    <img class="semi-circle-bg" :src="`${publicPath}semi-circle-bg.png`">
    <div v-if="isLoading" class="container skeleton"></div>
    <div v-else class="container detail-wrapper">
      <div class="row mx-0">
        <div class="col-lg-8 container-detail-upper">
          <div class="row mx-0">
            <h1 class="t-black t-36 w700" style="margin-top: 30px; margin-bottom: 10px">{{ company.name }}</h1>
            <img v-if="company_image_logo" :src="company_image_logo.filename" alt="" class="integration-company-logo">
          </div>
          <router-link to="" class="t-color1 t-24 w600 category-link" style="margin-top: 5.5px">{{ company.location }}</router-link>
          <!-- TODO: display projects -->
          <p class="t-18 t-color2 mb-2" style="margin-top: 10px">Projects: <span class="t-color1 w700">{{ company_projects.length }}</span></p>
          <div class="d-flex">
            <a v-if="company.facebook_url" :href="company.facebook_url" target="_blank" class="t-color2 t-18 w500 hover-link">Facebook Link</a>
            <a v-if="company.youtube_url" :href="company.youtube_url" target="_blank" class="t-color2 t-18 w500 ml-4 hover-link">Youtube Link</a>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="row w-100 d-flex justify-content-lg-end align-items-lg-start justify-content-center align-items-center h-100">
            <div class="user-info" style="margin-top: 30px;">
              <div class="row align-items-center justify-content-end mb-1 mx-0">
                <img :src="company.creator.profile_photo" width="40px" height="40px" alt="" style="border-radius: 50%">
                <router-link :to="{ name: 'userprofile', params: { slug: company.creator.id }}" class="w600 t-18 t-black my-0 link-hover" style="margin-left: 12px">{{ company.creator.full_name }}</router-link>
              </div>
              <div>
                <p class="t-14 t-black mb-0 w-100">{{ company.creator.full_name }}</p>
                <p class="t-14 t-black w-100 mb-1 text-lg-end text-center">{{ company.creator.title }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="project-gallery" style="margin-top: 13px;">
        <div class="row">
          <div class="col-12">
            <div class="project-gallery-top">
              <swiper class="swiper" :options="swiperOptionTop" ref="swiperTop">
                <swiper-slide
                  :key="index"
                  v-for="(img, index) in company_image"
                  v-if="img.filename"
                >
                  <img :src="img.filename" style="height: 462px; object-fit: cover" />
                </swiper-slide>
                <swiper-slide v-if="company.youtube_url !== 'null'">
                  <iframe width="100%" :src="`https://www.youtube.com/embed/${getEmbed(company.youtube_url)}`" frameborder="0" allowfullscreen></iframe>
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
                  :key="index"
                  v-for="(img, index) in company_image"
                  v-if="img.filename"
                >
                  <img :src="img.filename"/>
                </swiper-slide>
                <swiper-slide v-if="company.youtube_url !== 'null'">
                  <img
                    :src="getYoutubeImg(`${company.youtube_url}`)"
                    alt="">
                </swiper-slide>
              </swiper>
            </div>
          </div>
        </div>
      </div>
      <div class="tabs-section">
        <div class="description-section">
          <h4 class="w500 t-20 roboto w500">Company Description</h4>
          <p class="t-18" v-html="company.desc"></p>
        </div>
        <div class="brands-list" style="margin-top: 60px">
          <!-- TODO: List correctly brands (no name from api) -->
          <p class="t-20 w700 brands-h mb-0 pb-3">List of Brands</p>
          <div
            class="brand-list row mx-0 align-items-center"
            v-for="(b, index) in company.brand"
            :key="index"
          >
            <img :src="b.filename || `${publicPath}company-logo-01.png`" class="brand-logo mr-4" alt="">
            <router-link :to="{ name: 'Brand Page', params: { slug: b.slug }}" class="t-18 t-black mb-0 link-hover">{{ b.name }}</router-link>
          </div>
        </div>
      </div>
      <div class="media-section">
        <div class="row mx-0">
          <div class="col-lg-6 px-0 mb-5">
            <p class="t-20 w700">Documents</p>
            <div class="row mx-0 doc-block">
              <div class="doc" v-for="(pdf, index) in company_pdf" :key="index"
                   v-if="pdf.filename != null">
                <a target="_blank" :href="pdf.filename">
                  <div class="doc-icon">
                    <img :src="`${publicPath}pdf_icon.png`" alt="">
                  </div>
                  <p class="t-18 t-color2 mt-2 doc-link">{{ pdf.info || 'Document' }}</p>
                </a>
              </div>
            </div>
          </div>
          <div class="col-lg-6" v-if="company.youtube_url !== 'null'">
            <p class="t-20 w700">Videos</p>
            <div class="video-row row mx-0">
              <iframe width="315" height="178" :src="`https://www.youtube.com/embed/${getEmbed(company.youtube_url)}`"
                      title="YouTube video player" frameborder="0"
                      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                      allowfullscreen></iframe>
            </div>
          </div>
        </div>
      </div>
      <div v-if="company.web_url" class="website-section">
        <h4 class="t-20 roboto w700 mb-2">Website Link</h4>
        <a class="website-link" target="_blank" v-bind:href="company.web_url">{{ company.web_url }}</a>
      </div>
    </div>
    <!--TODO: Send associated projects via API-->
    <div v-if="company_projects.length" class="container" style="margin-top: 80px">
      <h4 class="t-42 w700 text-white mb-4">Associated Systems</h4>
      <div class="row mx-0">
        <div
          v-for="(p, index) in company_projects.slice(0, 3)"
          :key="index"
          class="col-lg-3 col-sm-6 col-xs-12 mb-4">
          <div class="card card-project streamgeeks-system-card-3">
            <div class="card-img-top">
              <router-link to="">
                <img :src="p.filename || `${publicPath}no-image.jpg`" alt="" />
                <!-- <img :src="`${publicPath}no-image.jpg`" alt="" /> -->
              </router-link>
            </div>
            <div class="card-body">
              <div class="card-title-vote">
                <div class="card-title mb-0">
                  <router-link :to="{ name: 'project', params: { slug: p.slug }}" class="link-hover">
                    {{ p.name }}
                  </router-link>
                </div>
              </div>
              <div class="card-category">
                <div class="label d-flex">
                  <!-- <router-link to="/">Music Category</router-link>
                  <span class="ml-auto text-white mr-2">10</span>
                  <CommentIcon /> -->
                </div>
              </div>
              <p class="card-text text-ellipse" v-html="p.desc"></p>
              <div class="card-price-more">
                <div class="projectby">
                  <!-- <span>Project by</span>
                  <router-link to="">
                    <img
                      :src="`${publicPath}user-avatar-lg.jpg`"
                      class="rounded-circle"
                    />
                  </router-link> -->
                </div>
                <div class="more">
                  <router-link :to="{ name: 'project', params: { slug: p.slug }}" class="btn btn-link btn-icon link-hover">
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
      </div>
    </div>
    <Footer style="margin-top: 138px" />
  </div>
</template>

<script>
import Header from "./common/Header.vue";
import Footer from "./common/Footer.vue";
import { Swiper, SwiperSlide, directive } from "vue-awesome-swiper";
import IconBase from "./common/IconBase";
import IconAngleRight2 from "./common/icons/IconAngleRight2.vue";
import IconShoppingCart from "./common/icons/IconShoppingCart.vue";
import ThumbsUp from "./rebranded/icons/ThumbsUp";
import DoneIcon from "./rebranded/icons/DoneIcon";
import DotIcon from "./rebranded/icons/DotIcon";
import IconArrowRight from "./common/icons/IconArrowRight";
import RatingStar from "./rebranded/icons/RatingStar";
import CommentIcon from "./rebranded/icons/CommentIcon";
// import appMixin from "../appMixin";
import Loading from "vue-loading-overlay"

import "swiper/css/swiper.css";

export default {
  name: "Integration Company Page",
  // mixins: [appMixin],
  data() {
    return {
      company: null,
      company_image: [],
      company_pdf: [],
      company_image_logo: null,
      company_projects: [],
      isAuthenticated: window.isAuthenticated,
      isLoading: false,
      publicPath: local_image_path,
      title: null,
      type: null,
      swiperOptionTop: {
        slidesPerView: 1,
        spaceBetween: 30,
        navigation: {
          nextEl: ".swiper-btn-next",
          prevEl: ".swiper-btn-prev"
        }
      },
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
      category_id: 0
    };
  },
  components: {
    Header,
    Footer,
    IconBase,
    IconAngleRight2,
    Swiper,
    SwiperSlide,
    IconShoppingCart,
    ThumbsUp,
    DoneIcon,
    DotIcon,
    IconArrowRight,
    RatingStar,
    CommentIcon,
    Loading
  },
  directives: {
    swiper: directive
  },
  methods: {
    async loadCompany () {
      this.isLoading = true
      const result = await this.callApi(
        "get",
        window.api_path + "company/" + this.$route.params.slug + "/details"
      )
      const res = result.data
      this.company = res.data.company
      this.company_image = res.data.company_image
      this.company_pdf = res.data.company_pdf
      this.company_image_logo = res.data.company_image_logo
      this.company_projects = res.data.ProjectCompany
      this.isLoading = false
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
    getYoutubeImg(src) {
      let id = src.match(/youtube\.com.*(\?v=|\/embed\/)(.{11})/).pop();
      if (id.length === 11) {
        return "//img.youtube.com/vi/" + id + "/0.jpg";
      }
      return "";
    }
  },
  async mounted() {
    await this.loadCompany()
    const swiperTop = this.$refs.swiperTop.$swiper;
    const swiperThumbs = this.$refs.swiperThumbs.$swiper;
    swiperTop.controller.control = swiperThumbs;
    swiperThumbs.controller.control = swiperTop;
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
  .overflow-clip {
    display: -webkit-box;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
  }
  .overflow-clip-1 {
    -webkit-line-clamp: 1;
  }
  .overflow-clip-2 {
    -webkit-line-clamp: 2;
  }
  .overflow-clip-3 {
    -webkit-line-clamp: 3;
  }

  .card-title a {
      height: 52px;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
      width: 100%;
  }
  
  @media all and (max-width:991px){
  .container-detail-upper > .row,
  .container-detail-upper > .row + a + .d-flex,
  .container-detail-upper > .row + a + p + .d-flex{
      justify-content: center;
  }

  .container-detail-upper {
      text-align: center;
  }
  .user-info {
      text-align: center;
  }
}
@media all and (max-width:575px){
  .container-detail-upper > .row h1 {
    font-size: 22px;
  }
   .container-detail-upper .integration-company-logo{
    margin-top: 30px;
    margin-left: 30px;
  }
  .container-detail-upper > .category-link{
    font-size: 18px !important;
  }
}
@media all and (max-width:420px){
   .detail-wrapper{
    padding:0 20px;
    padding-bottom: 28px;
  }
   .container-detail-upper .integration-company-logo{
    margin:20px 0 20px 6px;
  }
}
</style>

