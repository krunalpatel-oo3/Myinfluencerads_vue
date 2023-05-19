<template>
  <div class="proposal-rebranded">
    <Header />
    <div class="container">
      <h1 class="t-black t-36 w700" style="margin-top: 30px; margin-bottom: 10px">Hire a seller</h1>
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
          <swiper class="swiper" :options="swiperOptionTop" ref="swiperTop">
            <swiper-slide>
              <iframe width="100%" src="https://www.youtube.com/embed/5qap5aO4i9A" frameborder="0"></iframe>
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
              <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ2Jv2IZWtzbA6YC6m_mdZwr1NiLag34ebipQ&usqp=CAU" alt="">
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
        <h2 class="w700 t-24 t-black roboto" style="margin-bottom: 9.5px">Public System Description</h2>
        <div class="paragraph">
          Have you ever seen stars below the sky, on the earth? Yes, the spark of light emerging from the land. On a
          cold night, standing on a peak of the mountain, when you look down at the place, you feel darkness enlightened
          by the rays of light. The blow of the cold chilly wind will enlighten your spark and soul. The beauty of the
          night is among the stars above the sky to the stars below the sky. The streets with warm light and covered
          with trees and a water canal give the essence of fantasy.
        </div>
      </div>
      <div class="row justify-content-center align-items-center">
        <div class="see-more">
          <p class="w500 t-20">See more <ArrowDown style="margin-left: 10px"/></p>
        </div>
      </div>
      <div class="row contract-details">
        <h2 class="t-24 w700 roboto w-100 mb-0">Contract Details</h2>
        <div class="row mx-0 align-items-center w-100">
          <p class="d-text">Seller: <img :src="`${publicPath}seller-avatar.png`"
                                         style="margin-left: 10px; margin-right: 5px;" alt="">Kathryn Murphy</p>
          <div class="reviews-summary-rating" style="margin-left: 18px; margin-right: 10px;">
            <div class="rating-val-w">
              <div class="rating rating-lg">
                <div class="rating-current" style="width: 95%;">
                  <icon-base
                    width="68.01"
                    height="11"
                    view-box="0 0 68.01 10.57"
                    icon-name="stars"
                  >
                    <icon-stars />
                  </icon-base>
                </div>
                <div class="rating-total">
                  <icon-base
                    width="127"
                    height="20.5"
                    view-box="0 0 68.01 10.57"
                    icon-name="stars"
                  >
                    <icon-stars />
                  </icon-base>
                </div>
              </div>
            </div>
          </div>
          <span class="t-22 w500">4.9</span>
        </div>
        <h2 class="w500 roboto t-22 mb-1">Terms:</h2>
        <div class="row mx-0 align-items-center w-100">
          <p class="t-16 w600 mb-0" style="margin-right: 32px;">Contract Type:</p>
          <span class="w600 t-14" style="margin-right: 11px">Seller</span>
          <div class="custom-switch custom-switch-y">
            <input
              type="checkbox"
              class="custom-control-input"
              id="twoFactorRecommeded"
              checked
            />
            <label for="twoFactorRecommeded"></label>
          </div>
          <span class="w600 t-14" style="margin-left: 11px">Buyer</span>
          <p class="t-16 w600 mb-0" style="margin-left: 180px; margin-right: 35px;">Hourly Rate:</p>
          <input type="number" placeholder="$0.00">
          <p class="t-16 w600 mb-0" style="margin-left: auto; margin-right: 35px;">Weekly Limit:</p>
          <input type="number" placeholder="$0.00">
        </div>
        <div class="row w-100 justify-content-end mx-0" style="margin-top: 40px;">
            <button @click="$modal.show('fund-escrow-dialog')" class="btn btn-offer btn-hover">Send offer</button>
        </div>
      </div>
    </div>
    <FundEscrowModal />
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
import ArrowDown from "./icons/ArrowDown";
import FundEscrowModal from "./modals/FundEscrowModal";

import "swiper/css/swiper.css";

export default {
  name: "BuyerProposalPage",
  data() {
    return {
      payment: null,
      publicPath: local_image_path,
      type: null,
      titles: {
        '' : 'Proposal details',
        'archived': 'Archived Public System',
        'waiting': 'Offer details',
        'in-progress': 'Name of the Public System',
        'completed': 'Public System Completed'
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
    IconArrowRight,
    IconAngleRight2,
    IconShoppingCart,
    Swiper,
    SwiperSlide,
    ArrowDown,
    FundEscrowModal
  },
  mounted () {
    if (this.$route.query.payment === 'fixed') {
      this.payment = 'fixed'
    } else {
      this.payment = 'hourly'
    }
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
.d-text {
  font-weight: 500;
  line-height: 45px;
  font-size: 22px;
  margin-bottom: 0;
}
input {
  height: 43px;
  border: 1px solid #DDE0E6;
  border-radius: 4px;
  font-size: 14px;
  padding-left: 16px;
  width: 100px;
}
.btn-offer {
  background: #F2A91C;
  height: 62px;
  width: 204px;
  color: #202C54;
  font-size: 18px;
  font-weight: 700;
}
</style>
