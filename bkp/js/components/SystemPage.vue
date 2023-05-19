<template>
  <div class="system-page">
    <Header />
    <img class="wave-bg" :src="`${publicPath}wave-upload.png`" alt="">
    <img class="semi-circle-bg" :src="`${publicPath}semi-circle-bg.png`">
    <div class="container detail-wrapper">
      <div class="row mx-0">
        <div class="col-8">
          <div class="row mx-0">
            <h1 class="t-black t-36 w700" style="margin-top: 30px; margin-bottom: 10px">Name of the System</h1>
            <div @click="liked = !liked" :class="liked ? 'like-tag like-tag-active' : 'like-tag'">
              <ThumbsUp :fill="'#F2A91C'" :width="20" :height="20" style="margin-right: 5px; margin-top: -2px;" />
              <span>5</span>
            </div>
          </div>
          <router-link to="" class="t-color1 t-24 w600 category-link" style="margin-top: 5.5px">Music Category
          </router-link>
          <p class="t-18 t-color2" style="margin-top: 10px">Sed feugiat luctus ac quam purus. Lorem ipsum dolor sit
            amet, eu porttitor eu. Libero sed feugiat luctus ac quam purus. Sed feugiat luctus ac quam purus.</p>
        </div>
        <div class="col-4">
          <div class="row w-100 d-flex justify-content-end align-items-start h-100">
            <div class="user-info" style="margin-top: 30px">
              <div class="row align-items-center mb-3">
                <img :src="`${publicPath}user_info.png`" width="60px" height="60px" alt="">
                <router-link to="" class="w600 t-18 t-black my-0 link-hover" style="margin-left: 12px">James K
                </router-link>
              </div>
              <div>
                <p class="t-16 t-black w300 mb-0 w-100">Facebook/YouTube Streamer</p>
                <p class="t-14 t-color9 w-100 mb-1">De land Florida, USA</p>
                <button class="contact-project-btn">Contact about project</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="project-gallery" style="margin-top: 13px;">
        <div class="project-gallery-top">
          <swiper class="swiper" :options="swiperOptionTop" ref="swiperTop">
            <swiper-slide><img :src="`${publicPath}Slider_Image.png`" style="max-height: 462px; object-fit: cover" />
            </swiper-slide>
            <swiper-slide><img :src="`${publicPath}Slider_Image.png`" style="max-height: 462px; object-fit: cover" />
            </swiper-slide>
            <swiper-slide><img :src="`${publicPath}Slider_Image.png`" style="max-height: 462px; object-fit: cover" />
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
            <swiper-slide><img :src="`${publicPath}Slider_Image.png`" /></swiper-slide>
            <swiper-slide><img :src="`${publicPath}Slider_Image.png`" /></swiper-slide>
            <swiper-slide><img :src="`${publicPath}Slider_Image.png`" /></swiper-slide>
          </swiper>
        </div>
      </div>
      <div class="row equipments">
        <h2 class="w500 t-20 t-black roboto">Part List</h2>
        <table class="table table-align-middle">
          <thead>
          <tr>
            <th scope="col" class="text-center">QTY</th>
            <th scope="col" class="th-product-name">Product name</th>
            <th scope="col">Description</th>
            <th scope="col" class="text-center">Manufacturer</th>
            <th scope="col" class="text-center">Price</th>
            <th scope="col" class="text-center">Shop</th>
          </tr>
          </thead>
          <tbody>
          <tr>
            <td class="text-center w700">2</td>
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
            <td>Lorem Ipsum dolor sit amet agna finibus risus</td>
            <td class="text-center">Lorem Ipsum</td>
            <td class="text-center">400K</td>
            <td class="text-center">
              <a target="_blank" class="btn btn-xs btn-link">
                <icon-base
                  width="20"
                  height="17.58"
                  view-box="0 0 20 17.58"
                  icon-name="shopping-cart"
                >
                  <icon-shopping-cart />
                </icon-base>
              </a>
            </td>
          </tr>
          <tr>
            <td class="text-center w700">4</td>
            <td>
              <div class="d-flex align-items-center">
                <img
                  :src="`${publicPath}camera_360.png`"
                  alt=""
                  class="rounded-circle width-32 mr-2"
                />
                <div class="text-nowrap flex-grow-1">Display</div>
              </div>
            </td>
            <td>Lorem Ipsum dolor sit amet agna finibus risus</td>
            <td class="text-center">Lorem Ipsum</td>
            <td class="text-center">400K</td>
            <td class="text-center">
              <a target="_blank" class="btn btn-xs btn-link">
                <icon-base
                  width="20"
                  height="17.58"
                  view-box="0 0 20 17.58"
                  icon-name="shopping-cart"
                >
                  <icon-shopping-cart />
                </icon-base>
              </a>
            </td>
          </tr>
          <tr class="mt-3">
            <td colspan="3" class="mt-3">Design & Built by: Associated Company (Link)</td>
            <td class="t-18 w600 text-center">Total:</td>
            <td class="t-18 w600 text-center">800K</td>
          </tr>
          </tbody>
        </table>
      </div>
      <div class="stage-section">
        <h4 class="w500 t-20 roboto">Project Stage:</h4>
        <div class="row mx-0 w-100 justify-content-center mt-4">
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
      </div>
      <div class="description-section">
        <h4 class="w500 t-20 roboto w500">Introduction</h4>
        <p>Have you ever seen stars below the sky, on the earth? Yes, the spark of light emerging from the land. On a
          cold night, standing on a peak of the mountain, when you look down at the place, you feel darkness enlightened
          by the rays of light. The blow of the cold chilly wind will enlighten your spark and soul. The beauty of the
          night is among the stars above the sky to the stars below the sky. The streets with warm light and covered
          with trees and a water canal give the essence of fantasy. </p>
      </div>
      <div class="goals-section">
        <div class="row mx-0">
          <div class="col-6 pr-4">
            <div class="list">
              <p class="w700 t-20 mb-2">Project Goals</p>
              <p v-for="(i, index) in 6" class="t-18">
                <DotIcon style="margin-right: 10px" />
                Bullet Point {{ index + 1 }} (details about the project that is being posted)
              </p>
            </div>
          </div>
          <div class="col-6 pl-4">
            <div class="list">
              <p class="w700 t-20 mb-2">Service/ Upgrade Requests</p>
              <p v-for="(i, index) in 6" class="t-18">
                <DotIcon style="margin-right: 10px" />
                Bullet Point {{ index + 1 }} (details about the project that is being posted)
              </p>
            </div>
          </div>
        </div>
      </div>
      <div class="media-section">
        <div class="row mx-0">
          <div class="col-5">
            <p class="t-20 w700">Documents</p>
            <div class="row mx-0">
              <div class="doc">
                <a target="_blank">
                  <div class="doc-icon">
                    <img :src="`${publicPath}pdf_icon.png`" alt="">
                  </div>
                  <p class="t-18 t-color2 mt-2 doc-link">Document 1</p>
                </a>
              </div>
              <div class="doc">
                <a target="_blank">
                  <div class="doc-icon">
                    <img :src="`${publicPath}pdf_icon.png`" alt="">
                  </div>
                  <p class="t-18 t-color2 mt-2 doc-link">Document 2</p>
                </a>
              </div>
            </div>
          </div>
          <div class="col-7">
            <p class="t-20 w700">Videos</p>
            <div class="video-row row mx-0">
              <iframe width="315" height="178" src="https://www.youtube.com/embed/3fumku-teAI"
                      title="YouTube video player" frameborder="0"
                      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                      allowfullscreen></iframe>
              <iframe width="315" height="178" src="https://www.youtube.com/embed/3fumku-teAI"
                      title="YouTube video player" frameborder="0"
                      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                      allowfullscreen></iframe>
            </div>
          </div>
        </div>
      </div>
      <div class="website-section">
        <h4 class="t-20 roboto w700 mb-2">Website Link</h4>
        <a class="website-link">www.streamgeeks.com</a>
      </div>
      <div class="comments-section">
        <h2 class="w700 t-20 roboto w100">Comments</h2>
        <div class="row mx-0 comment">
          <img :src="`${publicPath}user_info.png`" alt="">
          <div style="margin-left: 10px">
            <router-link class="t-18 w600 mb-1 link-hover fit-content" to="">James K</router-link>
            <p class="t-color2 t-18 mb-0">Have you ever seen stars below the sky, on the earth? Yes, the spark of light
              emerging from the land. On a cold night, standing on a peak of the mountain, when you look down at the
              place.</p>
          </div>
        </div>
        <p class="t-18 text-black mb-0 mt-5">Leave a comment</p>
        <textarea placeholder="Write a comment"></textarea>
        <button class="leave-comment">Post comment</button>
      </div>
    </div>
    <div class="container" style="margin-top: 80px">
      <h4 class="t-42 w700 text-white mb-4">Related Projects</h4>
      <div class="row mx-0">
        <div v-for="(p, index) in 4" class="col-lg-3 col-sm-6 col-xs-12">
          <div class="card card-project">
            <div class="card-img-top">
              <router-link to="">
                <img :src="`${publicPath}gig-245.jpg`" alt="" />
              </router-link>
            </div>
            <div class="card-body">
              <div class="card-title-vote">
                <div class="card-title mb-0">
                  <router-link to="">
                    Project name here
                  </router-link>
                </div>
              </div>
              <div class="card-category">
                <div class="label d-flex">
                  <router-link to="/">Music Category</router-link>
                  <span class="ml-auto text-white mr-2">10</span>
                  <CommentIcon />
                </div>
              </div>
              <p class="card-text">
                Lorem ipsum dolor sit amet, habitant adipiscing elit. Fringilla
                habitant eu porttitor eu.
              </p>
              <div class="card-price-more">
                <div class="projectby">
                  <span>Project by</span>
                  <router-link to="">
                    <img
                      :src="`${publicPath}user-avatar-lg.jpg`"
                      class="rounded-circle"
                    />
                  </router-link>
                </div>
                <div class="more">
                  <router-link to="" class="btn btn-link btn-icon link-hover">
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
import CommentIcon from "./rebranded/icons/CommentIcon";

import "swiper/css/swiper.css";

export default {
  name: "System Page",
  data() {
    return {
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
      swiperGallery: [
        "/project-1-wide.jpg",
        "/project-2-wide.jpg",
        "/project-1-wide.jpg"
      ],
      bgimage: local_image_path + "single-job.jpg",
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
    CommentIcon
  },
  directives: {
    swiper: directive
  },
  async mounted() {
    this.logged_user_id = localStorage.getItem("logged_user_id");
    const swiperTop = this.$refs.swiperTop.$swiper;
    const swiperThumbs = this.$refs.swiperThumbs.$swiper;
    console.log("nextTick");
    console.log(swiperTop, swiperThumbs);
    swiperTop.controller.control = swiperThumbs;
    swiperThumbs.controller.control = swiperTop;
    console.log(swiperTop);
  }
};
</script>

<style lang="scss" scoped>
</style>

