<template>
  <div class="proposal-rebranded">
    <Header />
    <div class="container">
      <h1 class="t-black t-36 w700" style="margin-top: 30px; margin-bottom: 10px">{{ title }}</h1>
      <div class="project-info">
        <div class="row">
          <div class="col-5">
            <h2 class="t-black w700 t-28" style="margin: 0">Name of the Project</h2>
            <router-link to="" class="t-color1 t-24 w600 category-link" style="margin-top: 5.5px">Music Category</router-link>
            <p style="margin-top: 10px">Sed feugiat luctus ac quam purus. Lorem ipsum dolor sit amet, eu porttitor eu. Libero sed feugiat luctus
              ac quam purus</p>
            <div class="row mx-0">
              <div v-if="payment === 'hourly'" class="per-hour d-flex" style="margin-right: 25px">
                <HourlyIcon :width="'30'" :height="'30'" style="margin-right: 11px" />
                <p class="t-black w700 t-22 mb-0">$22-$33/hr</p>
              </div>
              <div v-if="payment === 'hourly'" class="hours d-flex">
                <CalendarIcon :width="'30'" :height="'30'" style="margin-right: 11px" />
                <p class="t-black w700 t-22 mb-0">20 hrs - 30 hrs / week</p>
              </div>
              <div v-if="payment === 'fixed'" class="hours d-flex">
                <FixedPrice style="margin-right: 11px" />
                <p class="t-black w700 t-22 mb-0">$ 1,500</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="project-gallery" style="margin-top: 13px;">
        <div class="project-gallery-top">
          <swiper @slideChange="slideChange" class="swiper" :options="swiperOptionTop" ref="swiperTop">
            <swiper-slide>
              <iframe ref="video" width="100%" src="https://www.youtube.com/embed/NCN8b1MvBGU" frameborder="0"></iframe>
            </swiper-slide>
            <swiper-slide
              :key="index"
              v-for="(imgpath, index) in swiperGallery"
            ><img :src="publicPath + imgpath"
            /></swiper-slide>
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
            <swiper-slide>
              <img :src="getYoutubeImg('https://www.youtube.com/embed/NCN8b1MvBGU')" alt="">
            </swiper-slide>
            <swiper-slide
              :key="index"
              v-for="(imgpath, index) in swiperGallery"
            ><img :src="publicPath + imgpath"
            /></swiper-slide>
          </swiper>
        </div>
      </div>
      <div class="row equipments">
        <h2 class="w700 t-24 t-black roboto">Equipments</h2>
        <table class="table table-align-middle">
          <thead>
          <tr>
            <th scope="col" class="text-center">#</th>
            <th scope="col" class="th-product-name">Product name</th>
            <th scope="col">Description</th>
            <th scope="col" class="text-center">Manufacturer</th>
            <th scope="col" class="text-center">Price</th>
            <th scope="col" class="text-center">Shop</th>
          </tr>
          </thead>
          <tbody>
          <tr>
            <td class="text-center">1</td>
            <td>
              <div class="d-flex align-items-center">
                <img
                  :src="`${publicPath}camera_360.png`"
                  alt=""
                  class="rounded-circle width-32 mr-2"
                />
                <div class="text-nowrap flex-grow-1">Camera 360</div>
              </div>
            </td>
            <td>
              Lorem Ipsum dolor sit amet agna finibus risus
            </td>
            <td class="text-center">
              Lorem Ipsum
            </td>
            <td class="text-center">400K</td>
            <td class="text-center">
              <router-link to="/purchase" class="btn btn-xs btn-link">
                <icon-base
                  width="20"
                  height="17.58"
                  view-box="0 0 20 17.58"
                  icon-name="shopping-cart"
                >
                  <icon-shopping-cart />
                </icon-base>
              </router-link>
            </td>
          </tr>
          <tr>
            <td class="text-center">1</td>
            <td>
                      <span class="d-flex align-items-center">
                        <img
                          :src="`${publicPath}camera_360.png`"
                          alt=""
                          class="rounded-circle width-32 mr-2"
                        />
                        <span class="text-nowrap flex-grow-1">Camera 360</span>
                      </span>
            </td>
            <td>
              Lorem Ipsum dolor sit amet agna finibus risus
            </td>
            <td class="text-center">
              Lorem Ipsum
            </td>
            <td class="text-center">400K</td>
            <td class="text-center">
              <router-link to="/purchase" class="btn btn-xs btn-link">
                <icon-base
                  width="20"
                  height="17.58"
                  view-box="0 0 20 17.58"
                  icon-name="shopping-cart"
                >
                  <icon-shopping-cart />
                </icon-base>
              </router-link>
            </td>
          </tr>
          </tbody>
        </table>
      </div>
      <div class="row project-description">
        <h2 class="w700 t-24 t-black roboto" style="margin-bottom: 9.5px">Project Description</h2>
        <div class="paragraph">
          Have you ever seen stars below the sky, on the earth? Yes, the spark of light emerging from the land. On a
          cold night, standing on a peak of the mountain, when you look down at the place, you feel darkness enlightened
          by the rays of light. The blow of the cold chilly wind will enlighten your spark and soul. The beauty of the
          night is among the stars above the sky to the stars below the sky. The streets with warm light and covered
          with trees and a water canal give the essence of fantasy.
        </div>
        <div class="paragraph">
          Have you ever seen stars below the sky, on the earth? Yes, the spark of light emerging from the land. On a
          cold night, standing on a peak of the mountain, when you look down at the place, you feel darkness enlightened
          by the rays of light. The blow of the cold chilly wind will enlighten your spark and soul. The beauty of the
          night is among the stars above the sky to the stars below the sky. The streets with warm light and covered
          with trees and a water canal give
          the essence of fantasy.
        </div>
        <img :src="`${publicPath}proposal-description.png`" alt="">
      </div>
      <div class="row docs">
        <div class="col-6">
          <h2 class="t-24 t-black w700 roboto mb-0">Documents</h2>
          <div class="row mx-0">
            <div class="doc">
              <a href="">
                <div class="doc-icon">
                  <img :src="`${publicPath}pdf_icon.png`" alt="">
                </div>
                <p class="t-12 doc-link" style="margin-top: 12px; color: rgba(0, 0, 0, 0.3)">Lorem Ipsum dolor</p>
              </a>
            </div>
            <div class="doc">
              <a href="">
                <div class="doc-icon">
                  <img :src="`${publicPath}pdf_icon.png`" alt="">
                </div>
                <p class="t-12 doc-link" style="margin-top: 12px; color: rgba(0, 0, 0, 0.3)">Lorem Ipsum dolor</p>
              </a>
            </div>
          </div>
        </div>
        <div class="col-6">
          <h2 class="t-24 t-black w700 roboto mb-0">Website Link</h2>
          <a href="#" class="w400 t-16 website-link" style="color: rgba(0, 0, 0, 0.8)">www.streamgeeks.com</a>
        </div>
      </div>
      <div class="row tags">
        <h2 class="t-24 w700 text-black roboto" style="margin-bottom: 8px">Tags</h2>
        <div class="col-12">
          <div class="row">
            <button class="tag">
              MySQL Administration
            </button>
            <button class="tag">
              API Integration
            </button>
            <button class="tag">
              MongoDB
            </button>
            <button class="tag">
              Bootstrap
            </button>
            <button class="tag">
              React.js
            </button>
            <button class="tag">
              CSS
            </button>
            <button class="tag">
              jQuery
            </button>
            <button class="tag">
              eCommerce Website
            </button>
            <button class="tag">
              Custom PHP
            </button>
            <button class="tag">
              CRM
            </button>

          </div>
        </div>
      </div>
      <BuyerWaiting v-if="type === 'waiting-for-accept'"/>
      <BuyerInProgress v-if="type === 'in-progress'"/>
      <BuyerCompleted v-if="type === 'completed'"/>
      <HireBottom v-if="type === 'hire'"/>
    </div>
    <Footer style="margin-top: 138px"/>
  </div>
</template>

<script>
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
import BuyerWaiting from "./bottom_components/BuyerWaiting";
import BuyerInProgress from "./bottom_components/BuyerInProgress";
import BuyerCompleted from "./bottom_components/BuyerCompleted";
import HireBottom from "./bottom_components/HireBottom";

import "swiper/css/swiper.css";

export default {
  name: "BuyerProposalPage",
  data() {
    return {
      payment: null,
      publicPath: local_image_path,
      title: null,
      type: null,
      titles: {
        '' : 'Proposal details',
        'archived': 'Archived Project',
        'waiting-for-accept': 'Offer details',
        'in-progress': 'Project in progress',
        'completed': 'Project Completed',
        'hire': 'Proposal details'
      },
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
      swiperOptionThumbs: {
        // loop: true,
        // loopedSlides: 3, // looped slides should be the same
        spaceBetween: 20,
        centeredSlides: true,
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
      swiperGallery: [
        "/project-1-wide.jpg",
        "/project-2-wide.jpg",
        "/project-1-wide.jpg"
      ],
      bgimage: local_image_path + "single-job.jpg"
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
    FixedPrice,
    BuyerWaiting,
    IconArrowRight,
    IconAngleRight2,
    IconShoppingCart,
    Swiper,
    SwiperSlide,
    BuyerInProgress,
    BuyerCompleted,
    HireBottom
  },
  methods: {
    showArchiveDialog () {
      this.$modal.show("archive-proposal-dialog")
    },
    hideArchiveDialog () {
      this.$modal.hide("archive-proposal-dialog")
    },
    getYoutubeImg (src) {
      let id = src.match(/youtube\.com.*(\?v=|\/embed\/)(.{11})/).pop()
      if (id.length === 11) {
        return '//img.youtube.com/vi/' + id + '/0.jpg'
      }
      return ''
    },
    slideChange () {
      let src = this.$refs.video.src
      this.$refs.video.src = src
    }
  },
  mounted () {
    if (this.$route.query.payment === 'fixed') {
      this.payment = 'fixed'
    } else {
      this.payment = 'hourly'
    }
    if (this.$route.query.type) {
      this.type = this.$route.query.type
    } else {
      this.type = ''
    }
    this.title = this.titles[this.$route.query.type]
    this.$nextTick(() => {
      const swiperTop = this.$refs.swiperTop.$swiper;
      const swiperThumbs = this.$refs.swiperThumbs.$swiper;
      console.log("nextTick");
      console.log(swiperTop, swiperThumbs);
      swiperTop.controller.control = swiperThumbs;
      swiperThumbs.controller.control = swiperTop;
    });
  }
};
</script>

<style lang="scss" scoped>
</style>
