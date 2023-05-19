<template>
  <div class="product-page">
    <Header />
    <img class="wave-bg" :src="`${publicPath}wave-upload.png`" alt="">
    <img class="semi-circle-bg" :src="`${publicPath}semi-circle-bg.png`">
    <div v-if="isLoading" class="container skeleton"></div>
    <div v-else class="container detail-wrapper theme-detail-wrapper">
      <div class="project-info theme-project-info">
        <div class="row">
          <div class="col-12">
           <div class="product-wrapper">
             <h1 class="product-title">{{ product.name || "" }}</h1>
             <div @click="addVote" :class="product.liked ? 'like-tag like-tag-active' : 'like-tag'">
               <ThumbsUp :fill="'#F2A91C'" :width="20" :height="20" style="margin-right: 5px; margin-top: -2px;" />
               <span>{{ product.likes || 0 }}</span>
             
             </div>
           </div>
            
          </div>
        </div>
        <div class="row align-items-start product-detail-wrapper">
          <div class="col-md-8 col-sm-6">
            <div class="product-cats">
              <router-link to="" class="category-link">
                {{ product.product_category ? product.product_category.title : "" }}
                {{ product.product_sub_category ? (" | " + product.product_sub_category.title) : "" }}
              </router-link>
            </div>
            <div class="product-sku">
              <p class="t-18 t-color2">SKU: {{ product.sku || "" }}</p>
            </div>
          </div>
          <div class="col-md-4 col-sm-6">
            <div class="row w-100 d-flex justify-content-end align-items-start h-100">
              <div class="user-info product-user-info">
                <div class="add-by-label">
                  <strong>Added by</strong>
                </div>
                <div class="row align-items-center justify-content-end user-img-block">
                  <img :src="product.creator.profile_photo || defaultUserImgUrl" width="40px" height="40px" alt="">
                  <router-link :to="{ name: 'userprofile', params: { slug: product.creator.id } }" class="link-hover">
                    {{ product.creator.full_name || "" }}
                  </router-link>
                </div>
                <div class="prod-userTag">
                  <p>{{ product.creator.title || "" }}</p>
                  <p>{{ product.creator.location || "" }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="project-gallery" style="margin-top: 13px;">
        <div class="row">
          <div class="col-md-6 project-gallery-left">
            <div class="project-gallery-top">
              <swiper class="swiper" :options="swiperOptionTop" ref="swiperTop">
                <swiper-slide v-for="img in product.images">
                  <img :src="img.path || `${publicPath}Slider_Image.png`" style="height: 462px; object-fit: cover" @error="setAltProdImg" />
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
                <swiper-slide v-for="img in product.images">
                  <img :src="img.path || `${publicPath}Slider_Image.png`" @error="setAltProdImg" />
                </swiper-slide>
              </swiper>
            </div>
          </div>
          <div class="col-md-6 project-gallery-right">
            <div class="prod-pric-block">
              <span class="prod-label">Price:</span>
              <span class="prod-price">$ {{ product.price || 0 }}</span>
              
            </div>
            <div class="prod-rating-block">
              <div class="prod-label">
                User Rating: 
              </div>
              <div class="prod-stars">
                <RatingStar
                v-for="i in product.overallratings"
                :key="i"
                :fill="'#F2A91C'"
              />
              <RatingStar
                v-for="j in (5 - product.overallratings)"
                :key="j"
              />
                <span class="prod-overall-ratings">
                  {{ product.overallratings }}
                </span>
              </div>
            </div>
            
            <div class="list-characteristics">
              <div v-if="product.short_desc != null && product.short_desc != 'null'" class="pdb-list" v-html=" product.short_desc || ''">
              </div>
            </div>
            <p class="t-24 w700 mb-0 mt-3">Brand:
              <router-link :to="{ name: 'Brand Page', params: { slug: product.productbrand.slug }}">
                {{ product.productbrand ? product.productbrand.name : "" }}
              </router-link>
            </p>
            <img :src="product.productbrand.image || `${publicPath}PTZOptics LOGO WEB 1.png`" alt=""
                 style="max-height: 200px">

            <div class="mt-4">
              <span class="prod-label">Tags:</span>
              <div class="mt-3">
                <button v-if="product.product_tags.length > 0" class="product-tags" v-for="(tag, index) in product.product_tags" :key="index">{{ tag.tag_title }}</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="tabs-section">
        <div class="description-section">
          <h4 class="w500 t-20 roboto w500">Product Description</h4>
          <div class="prod-desc-block">{{ product.desc || '' }}</div>
        </div>
        <div class="row equipments" style="margin-top: 60px">
          <div class="row mx-0 equipment-tab w-100">
            <a @click="equipmentTab = 'Compatibility'" :class="equipmentTab === 'Compatibility' ? 'tab-active' : ''">Compatibility</a>
            <a @click="equipmentTab = 'Accessories'" :class="equipmentTab === 'Accessories' ? 'tab-active' : ''">Accessories</a>
          </div>
          <div class="table-responsive">
            <table v-if="equipmentTab === 'Compatibility'" class="table table-align-middle">
              <thead>
              <tr>
                <th scope="col" class="text-center">#</th>
                <th scope="col" class="th-product-name">Product name</th>
                <th scope="col">Description</th>
                <th scope="col" class="text-center">Price</th>
              </tr>
              </thead>
              <tbody>
              <tr
                v-for="(pr, index) in product.compatibleproducts"
                :key="index"
              >
                <td class="text-center w700">{{ index + 1 }}</td>
                <td>
                  <div class="d-flex align-items-center flex-wrap">
                    <img :src="pr.product_image || `${publicPath}no-image.jpg`" alt="" class="rounded-circle width-32 mr-2" />
                    <div class="text-nowrap flex-grow-1">{{ pr.product_name }}</div>
                  </div>
                </td>
                <td>{{ pr.product_description }}</td>
                <td class="text-center">{{ pr.product_price }}</td>
              </tr>
              </tbody>
            </table>
            <table v-if="equipmentTab === 'Accessories'" class="table table-align-middle">
              <thead>
              <tr>
                <th scope="col" class="text-center">#</th>
                <th scope="col" class="th-product-name">Product name</th>
                <th scope="col">Description</th>
                <th scope="col" class="text-center">Price</th>
              </tr>
              </thead>
              <tbody>
              <tr
                v-for="(acc, index) in product.accessoriesproducts"
                :key="index"
              >
                <td class="text-center w700">{{ index + 1 }}</td>
                <td>
                  <div class="d-flex align-items-center flex-wrap">
                    <img
                      :src="acc.product_image || `${publicPath}no-image.jpg`" alt="" class="rounded-circle width-32 mr-2"
                    />
                    <div class="text-nowrap flex-grow-1">{{ acc.product_name }}</div>
                  </div>
                </td>
                <td>{{ acc.product_description }}</td>
                <td class="text-center">{{ acc.product_price }}</td>
              </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="media-section">
        <div class="row">
          <div class="col-lg-5 col-md-6 col-12">
            <p class="t-20 w700">Documents</p>
            <div class="row">
              <div class="doc" v-for="(doc, index) in product.documents" :key="index">
                <a target="_blank" v-bind:href="doc.document_name">
                  <div class="doc-icon">
                    <img :src="`${publicPath}pdf_icon.png`" alt="">
                  </div>
                  <p class="t-18 t-color2 mt-2 doc-link">{{ doc.document_caption }}</p>
                </a>
              </div>
            </div>
          </div>
          <div class="col-lg-7 col-md-6 col-12">
            <p class="t-20 w700">Videos</p>
            <div class="video-row row">
              <iframe
                v-if="product.youtube_link"
                :src="`https://www.youtube.com/embed/${getEmbed(product.youtube_link)}`"
                width="315" height="178"
                title="YouTube video player"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture;"
                frameborder="0" allowfullscreen></iframe>
              <iframe
                v-if="product.youtube_link2"
                :src="`https://www.youtube.com/embed/${getEmbed(product.youtube_link2)}`"
                width="315" height="178"
                src="https://www.youtube.com/embed/3fumku-teAI"
                title="YouTube video player" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; fullscreen"
                allowfullscreen></iframe>
            </div>
          </div>
        </div>
      </div>
      <div v-if="product.website_link" class="website-section">
        <h4 class="t-20 roboto w700 mb-2">Website Link</h4>
        <a class="website-link text-break" :href="product.website_link" target="_blank">
          {{ product.website_link }}
        </a>
      </div>
      <div class="comments-section">
        <h2 class="w700 t-20 roboto w100">Reviews</h2>
        <div
          v-for="(comment, index) in product.reviews"
          :key="index"
          class="row mx-0 comment"
        >
          <img :src="comment.user_profile_photo || defaultUserImgUrl" alt="">
          <div style="margin-left: 10px">
            <div class="row mx-0 align-items-center">
              <p class="t-18 w600 mb-0 mr-3">{{ comment.user_name }}</p>
              <RatingStar
                :fill="'#F2A91C'"
                :height="19"
                :width="22"
                v-for="i in comment.ratings"
                :key="i"
              />
              <RatingStar
                :height="19"
                :width="22"
                v-for="j in (5 - comment.ratings)"
                :key="j"
              />
            </div>
            <!-- <p class="t-color2 t-18 mb-0 text-break">{{ comment.description || "" }}</p> -->
            <div class="t-color2 t-18 mb-0 text-break" v-html="comment.description" v-linkified></div>
          </div>
        </div>
        <div class="row mx-0 mt-5 align-items-center mb-2">
          <p class="t-18 text-black mb-0 mr-4">Leave a review</p>
          <star-rating v-model="rating" :star-size="30" active-color="#F2A91C"></star-rating>
        </div>
        <textarea v-model="review" placeholder="Write a comment" ref="review"></textarea>
        <button @click="postReview" class="leave-comment" :disabled="posting">
          <div v-if="posting" class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
          </div>
          <span v-else>Post review</span>
        </button>
      </div>
    </div>
    <div v-if="!isLoading" class="container" style="margin-top: 80px">
      <h4 class="t-42 w700 text-white mb-4">Related Products</h4>
      <div class="row mx-0" style="margin-bottom: 60px">
        <div v-for="(p, index) in product.relatedproducts.slice(0, 4)" :key="index"
             class="col-lg-3 col-sm-6 col-xs-12">
          <ProductCard
            :name="p.product_name"
            :category="p.product_category.title"
            :description="p.product_desc"
            :image_link="p.product_image.image_url"
            :rating="p.product_over_all_rating"
            :slug="p.product_slug"
            :user_photo="p.user_profile_photo"
            :creator_id="p.user_id"
          />
        </div>
      </div>
    </div>
    <Footer style="margin-top: 138px" />
  </div>
</template>

<script>
import Vue from 'vue';
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
import StarRating from "vue-star-rating";
import CommentIcon from "./rebranded/icons/CommentIcon";
import Loading from "vue-loading-overlay";
import ProductCard from "./common/ProductCard";
import linkify from 'vue-linkify'

Vue.directive('linkified', linkify)

import "swiper/css/swiper.css";

export default {
  name: "Product Page",
  data() {
    return {
      defaultUserImgUrl: base_url + "images/default-user-avatar-sm.jpg",
      product: null,
      isLoading: true,
      isCommentLoading: false,
      rating: null,
      review: "",
      equipmentTab: "Compatibility",
      tab: "Overview",
      isAuthenticated: window.isAuthenticated,
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
      category_id: 0,
      posting: false
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
    StarRating,
    CommentIcon,
    Loading,
    ProductCard
  },
  directives: {
    swiper: directive
  },
  async mounted() {
    this.logged_user_id = localStorage.getItem("logged_user_id");
    await this.loadProduct();
    const swiperTop = this.$refs.swiperTop.$swiper;
    const swiperThumbs = this.$refs.swiperThumbs.$swiper;
    swiperTop.controller.control = swiperThumbs;
    swiperThumbs.controller.control = swiperTop;
    this.scrollToTop();
  },
  methods: {
    scrollToTop() {
      window.scrollTo(0,0);
    },
    setAltProdImg(event) {
        event.target.src = base_url + "images/emptyImg.png";
    },
    async addVote() {
      if (this.isAuthenticated !== true || this.logged_user_id == null) {
        this.$toast.error("You need to login add Vote !");
        return;
      }
         var isAlreadyVote = 1;
        if(this.product.liked == 1){
          isAlreadyVote = 0
          this.product.likes = this.product.likes -  1
        }else{
            this.product.likes = this.product.likes +  1
        }

      this.product.liked = isAlreadyVote;

      const result = await this.callApi(
        "post",
        window.api_path + "product/like",
        {
          product_id: this.product.product_id,
          type : isAlreadyVote

        }
      );
      if (result.status !== 200) {
        this.$toast.error(result.data.message);
        // this.projectData.is_already_voted = 0;
        return;
      }
   
    },

    async postReview() {
      
      if(this.rating == null){
        this.$toast.error('Please select review rating!');
        return false;
      }
      
      if (this.review.trim() === "") {
        this.$toast.error('Please enter review comment!');
        this.review = "";
        this.$refs.review.focus()
        return false;
      }
      this.isCommentLoading = true;

      
      const d = new FormData();
      d.append("user_id", localStorage.getItem("logged_user_id"));
      d.append("product_id", this.product.product_id);
      d.append("ratings", this.rating);
      d.append("description", this.review);
      const res = await axios.post(
        window.api_path + "product/addratings",
        d
      );
            this.isCommentLoading = false;

      if (res.status !== 200) {
        this.$toast.error("Error occurred on the server. Please try again");
        return;
      }
      if(res.data.code == 0){
          this.$toast.error(res.data.message);
          return
        }
      this.rating = 0;
      this.review = "";
      this.posting = true;
      this.$toast.success("Review is posted successfully");
      await this.loadProduct();
      this.posting = false;
    },
    async loadProduct() {
      const res = await this.callApi(
        "get",
        window.api_path + "product/getproduct/" + this.$route.params.slug,
        {}
      );
      this.isLoading = false;
      if (res.data.data.product) {
        this.product = res.data.data.product;
        return;
      }
      this.$toast("Error occurred during execution. Please try again");
      await this.$router.push({ name: "Home" });
    },
  },
  watch: {
    "$route.params.slug": {
      handler() {
        this.isLoading = true;
        this.loadProduct();
      },
      deep: true
    }
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

.spinner-border {
  width: 1rem;
  height: 1rem;
}

.product-tags {
  background: #e5e5e5;
  border-radius: 5px;
  height: 40px;
  border: none;
  padding: 0 20px;
  font-size: 12px;
  margin-right: 14px;
  margin-bottom: 29px;
}
</style>

