<template>
  <div class="brand-page">
    <Header />
    <img class="wave-bg" :src="`${publicPath}wave-upload.png`" alt="">
    <img class="semi-circle-bg" :src="`${publicPath}semi-circle-bg.png`">
    <div v-if="isLoading" class="container skeleton"></div>
    <div v-else class="container detail-wrapper">
      <div class="row mx-0">
        <div class="col-lg-8 container-detail-upper">
          <div class="row mx-0">
            <h1 class="t-black t-36 w700" style="margin-top: 30px; margin-bottom: 10px">{{ brand.name }}</h1>
            <img v-if="brand_image_logo" :src="brand_image_logo.filename" alt="" class="integration-company-logo">
          </div>
          <router-link to="" class="t-color1 t-24 w600 category-link" style="margin-top: 5.5px">Brand Category</router-link>
          <div class="d-flex mt-4">
            <a v-if="brand.facebook_url" :href="brand.facebook_url" class="t-color2 t-18 w500 hover-link" target="_blank">Facebook Link</a>
            <a v-if="brand.youtube_url !== 'null'" :href="brand.youtube_url" class="t-color2 t-18 w500 ml-4 hover-link" target="_blank">Youtube Link</a>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="row w-100 d-flex justify-content-lg-end align-items-lg-start justify-content-center align-items-center h-100">
            <div class="user-info" style="margin-top: 30px;">
              <div v-if="brand.creator" class="row align-items-center justify-content-end mb-1 mx-0">
                <img :src="brand.creator.profile_photo" width="40px" height="40px" style="border-radius: 50%" alt="">
                <router-link :to="{ name: 'userprofile', params: { slug: brand.creator.id }}"
                             class="w600 t-18 t-black my-0 link-hover" style="margin-left: 12px">{{ brand.creator.full_name }}</router-link>
              </div>
              <div>
                <p class="t-14 t-black mb-0 w-100">{{ brand.creator.title }}</p>
                <p class="t-14 t-black w-100 mb-1 text-end">{{ brand.creator.location }}</p>
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
                  v-for="(img, index) in brand_image"
                  v-if="img.filename"
                ><img :src="img.filename" style="height: 462px; object-fit: cover" />
                </swiper-slide>
                <swiper-slide v-if="brand.youtube_url !== 'null'">
                  <iframe width="100%" style="min-height: 400px" :src="`https://www.youtube.com/embed/${getEmbed(brand.youtube_url)}`" frameborder="0" allowfullscreen></iframe>
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
                  v-for="(img, index) in brand_image"
                  v-if="img.filename"
                ><img :src="img.filename"/></swiper-slide>
                <swiper-slide v-if="brand.youtube_url && brand.youtube_url !== 'null'">
                  <img
                    :src="getYoutubeImg(`${brand.youtube_url}`)"
                    alt="">
                </swiper-slide>
              </swiper>
            </div>
          </div>
        </div>
      </div>
      <div class="tabs-section">
        <div class="description-section">
          <h4 class="w500 t-20 roboto w500">Brand Description</h4>
          <p class="t-18" v-html="brand.desc"></p>
        </div>
        <div v-if="brand.product" class="product-line" style="margin-top: 60px">
          <p class="t-20 w700 product-line-h mb-1 pb-1" style="border-bottom: 2px solid rgba(32, 44, 84, 0.17)">Product Line</p>
          <table class="table table-align-middle">
            <thead>
            <tr>
              <th scope="col" class="text-center">#</th>
              <th scope="col" class="th-product-name">Product name</th>
              <th scope="col">Description</th>
              <th scope="col" class="text-center">Price</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(product, index) in brand.product" :key="index">
              <td class="text-center w700">{{ index + 1 }}</td>
              <td>
                <div class="d-flex align-items-center">
                  <img
                    :src="`${publicPath}camera_360.png`"
                    alt=""
                    class="rounded-circle width-32 mr-2"
                  />
                  <div class="text-nowrap flex-grow-1">
                    <router-link :to="{ name: 'Product Page', params: { slug: product.slug }}">
                      {{ product.name.substring(0, 20) }}
                    </router-link>
                  </div>
                </div>
              </td>
              <td class="px-4" v-html="product.desc.substring(0, 100) + '....'"></td>
              <td class="text-center">{{ product.price }} $</td>
            </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="media-section">
        <div class="row mx-0">
          <div v-if="brand_pdf" class="col-lg-6 px-0 mb-5">
            <p class="t-20 w700">Documents</p>
            <div class="row mx-0 doc-block">
              <div
                class="doc"
                v-for="(pdf, index) in brand_pdf"
                :key="index"
                v-if="pdf.filename"
              >
                <a target="_blank" :href="pdf.filename">
                  <div class="doc-icon">
                    <img :src="`${publicPath}pdf_icon.png`" alt="">
                  </div>
                  <p class="t-18 t-color2 mt-2 doc-link">{{ pdf.info || 'Document' }}</p>
                </a>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <p class="t-20 w700">Videos</p>
            <div class="video-row row mx-0" v-if="brand.youtube_url !== 'null' && brand.youtube_url != undefined">
              <iframe width="315" height="178" :src="`https://www.youtube.com/embed/${getEmbed(brand.youtube_url)}`"
                      title="YouTube video player" frameborder="0"
                      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                      allowfullscreen></iframe>
            </div>
          </div>
        </div>
      </div>
      <div v-if="brand.web_url" class="website-section">
        <h4 class="t-20 roboto w700 mb-2">Website Link</h4>
        <a class="website-link" target="_blank" v-bind:href="brand.web_url">{{ brand.web_url }}</a>
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
import Loading from "vue-loading-overlay";

import "swiper/css/swiper.css";
export default {
  name: "Brand Page",
  data() {
    return {
      brand: null,
      brand_image: [],
      brand_pdf: [],
      brand_products: [],
      brand_image_logo: null,
      equipmentTab: "Compatibility",
      tab: "Overview",
      isAuthenticated: window.isAuthenticated,
      isLoading: false,
      logged_user_id: null,
      payment: null,
      publicPath: local_image_path,
      title: null,
      type: null,
      swiperOptionTop: {
        slidesPerView: 1,
        spaceBetween: 30,
        // loop: true,
        // loopedSlides: 3, // looped slides should be the same
        navigation: {
          nextEl: ".swiper-btn-next",
          prevEl: ".swiper-btn-prev"
        }
      },
      liked: false,
      swiperOptionThumbs: {
        // loop: true,
        // loopedSlides: 3, // looped slides should be the same
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
    Loading
  },
  directives: {
    swiper: directive
  },
  methods: {
    async loadBrand () {
      this.isLoading = true
      const res = await this.callApi(
        "get",
        window.api_path + "brand/" + this.$route.params.slug + "/details",
        {}
      )
      if (res.status !== 200) {
        this.isLoading = false
        this.$toast.error(res.data.message)
        return
      }
      const { brand, brand_image, brand_image_logo, brand_pdf, brand_products } = res.data.data
      this.brand = brand
      this.brand_image = brand_image
      this.brand_image_logo = brand_image_logo
      this.brand_pdf = brand_pdf
      this.brand_products = brand_products
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
    this.logged_user_id = localStorage.getItem("logged_user_id");
    await this.loadBrand();
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
@media all and (max-width:991px){
  .container-detail-upper > .row,
  .container-detail-upper > .row + a + .d-flex{
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
  .brand-page .container-detail-upper .integration-company-logo{
    margin-top: 30px;
    margin-left: 30px;
  }
  .container-detail-upper > .category-link{
    font-size: 18px !important;
  }
}
@media all and (max-width:420px){
  .brand-page .detail-wrapper{
    padding:0 20px;
    padding-bottom: 28px;
  }
  .brand-page .container-detail-upper .integration-company-logo{
    margin:20px 0 20px 6px;
  }
}
</style>