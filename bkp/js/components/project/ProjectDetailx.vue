<template>
  <div class="wrapper">
    <Header />

    <main class="main">
      <div class="container">
        <!-- Project Details -->
        <section class="section-project" v-if="projectData">
          <header class="project-h">
            <div class="project-h-info">
              <div class="project-headline">
                <h1 v-html="projectData.name"></h1>
                <span class="project-type">{{projectData.plateform.title}}</span>
                <!-- <button class="btn btn-primary btn-icon btn-download">
                  <span>Download Project</span>
                  <icon-base
                    width="24"
                    height="25.31"
                    view-box="0 0 24 25.31"
                    icon-name="pdf"
                  >
                    <icon-pdf />
                  </icon-base>
                </button> -->
              </div>
              <div class="project-cat" >{{projectData.category.title}}</div>
              <div class="project-short-desc" v-html="projectData.short_desc">

              </div>
            </div>

            <div class="project-h-authorinfo">
              <div class="project-author">
                <div class="userpic">
                  <router-link to="/projects/2">
                    <img
                      class="rounded-circle"
                      :src="projectData.creatorUserProfilePhotoImageProps.image_url"
                      alt=""
                    />
                  </router-link>
                </div>
                <div class="username">
                  <router-link to="">
                  {{ projectData.creator.full_name}}
                  </router-link>
                </div>
              </div>
              <div class="btns">
                <router-link to="" class="btn btn-outline-blue btn-xs btn-icon">
                  <icon-base
                    width="12"
                    height="11.2"
                    view-box="0 0 12 11.2"
                    icon-name="like2"
                  >
                    <icon-like2 />
                  </icon-base>
                  <span>Upvote</span>
                </router-link>
              </div>
            </div>
          </header>



          <div class="project-gallery">
            <div class="project-gallery-top">
              <swiper class="swiper" :options="swiperOptionTop" ref="swiperTop">
                <swiper-slide
                  :key="index"
                  v-for="(imgpath, index) in projectImage"
                  ><img :src="imgpath.projectImagePropsArray.image_url"
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
              <span
                class="btn btn-light-secondary btn-xl btn-featured rounded-xl" v-html="'$'+projectData.estimated_budget"
                ></span
              >
            </div>

            <div class="project-gallery-thumbs">
              <swiper
                class="swiper gallery-thumbs"
                :options="swiperOptionThumbs"
                ref="swiperThumbs"
              >
                <swiper-slide
                  :key="index"
                  v-for="(imgpath, index) in projectImage"
                  ><img :src="imgpath.projectImagePropsArray.image_url"
                /></swiper-slide>
              </swiper>
            </div>
          </div>

          <div class="project-equip">
            <div class="label">Equipments</div>
            <table class="table table-responsive-md table-align-middle">
              <thead>
                <tr>
                  <th scope="col" class="text-center">#</th>
                  <th scope="col">Product name</th>
                  <th scope="col">Description</th>
                  <th scope="col" class="text-center">Manufacturer</th>
                  <!-- <th scope="col" class="text-center">Price</th>
                  <th scope="col" class="text-center">Action</th> -->
                </tr>
              </thead>
              <tbody v-if="projectProducts" >
                <tr v-for="nextprojectProduct in projectProducts" :key="nextprojectProduct.id">
                  <td class="text-center">1</td>
                  <td>{{nextprojectProduct.product.name}}</td>
                  <td>
                   {{nextprojectProduct.product.short_desc}}
                  </td>
                  <td class="text-center">
                     {{nextprojectProduct.product.manufacturer}}
                  </td>
                  <!-- <td class="text-center">{{nextprojectProduct.product.price}}</td>
                  <td class="text-center">
                    <router-link to="" class="btn btn-xs btn-link">
                      <icon-base
                        width="20"
                        height="17.58"
                        view-box="0 0 20 17.58"
                        icon-name="shopping-cart"
                      >
                        <icon-shopping-cart />
                      </icon-base>
                    </router-link>
                  </td> -->
                </tr>

              </tbody>
            </table>
          </div>

          <div class="project-content project-desc">
            <h2>Introduction</h2>

            <div class="text">
              <p v-html="projectData.desc">
              </p>


              <!-- <img
                :src="`${publicPath}project-2-wide.jpg`"
                class="rounded-lg mb-5"
                alt=""
              /> -->


            </div>
          </div>

          <div class="project-content project-files">
            <h2>Documents</h2>
            <div class="file-list">
              <div class="file-item"  v-for="nextprojectPdf in projectPdf" :key="nextprojectPdf.id">
                 <a v-bind:href="nextprojectPdf.projectPdfPropsArray.image_url"
                       target='_blank'>
                <!-- <router-link :to="nextprojectPdf.projectPdfPropsArray.image_url" class="file-icon"> -->
                  <img :src="`${publicPath}pdf.png`" alt="" />
                <!-- </router-link> -->
                 </a>
                <div class="span file-name">{{nextprojectPdf.info}}</div>
              </div>
              <!-- <div class="file-item">
                <router-link to="" class="file-icon">
                  <img :src="`${publicPath}pdf.png`" alt="" />
                </router-link>
                <div class="file-name">Lorem Ipsum dolor</div>
              </div> -->
            </div>
          </div>

          <div class="project-content project-desc">
            <h2>Website Link</h2>
            <div class="text">
              <a href="" v-html="projectData.link_url"></a>
            </div>
          </div>

          <div class="project-author-b">
            <div class="userpic">
              <router-link to="/projects/2">
                <img
                  class="rounded-circle"
                  :src="`${publicPath}userpic-60.jpg`"
                  alt=""
                />
              </router-link>
            </div>
            <div class="author-info">
              <div class="username">
                <router-link to="">
                  James K
                </router-link>
              </div>
              <div class="author-desc">
                Have you ever seen stars below the sky, on the earth? Yes, the
                spark of light emerging from the land. On a cold night, standing
                on a peak of the mountain, when you look down at the place.
              </div>
            </div>
          </div>
        </section>
        <!-- End of Project Details -->

        <!-- Comments -->
        <section class="project-comments">
          <h2 class="comments-h">Comments</h2>

          <div class="comments-list"></div>

          <div class="comments-form">
            <div class="form-group">
              <label>Leave a comment</label>
              <textarea
                name=""
                rows="5"
                class="form-control"
                placeholder="Post your comment here"
              ></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Post</button>
          </div>
        </section>
        <!-- End of Comments -->

        <div class="project-quote">
          <!-- Send Quote Modal -->
          <button class="btn btn-secondary" @click="showQuoteDialog">
            Send a Quote
          </button>

          <modal
            name="quote-modal-dialog"
            :width="1160"
            height="auto"
            :scrollable="true"
            :adaptive="true"
            transition=""
            class="section-modal section-modal-quote"
          >
            <div class="modal-close" @click="hideQuoteDialog">
              <icon-base
                width="21"
                height="21"
                viewBox="0 0 7 7"
                icon-name="cancel"
                ><icon-cancel
              /></icon-base>
            </div>
            <h2 class="h1">Send a Quote</h2>
            <div class="form-group">
              <textarea
                rows="14"
                class="form-control"
                placeholder="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."
              ></textarea>
            </div>
            <div
              class="form-row align-items-center justify-content-end budget-row"
            >
              <div class="col-auto">
                <label>Budget:</label>
              </div>
              <div class="col-auto">
                <input type="text" class="form-control form-control" />
              </div>
            </div>
            <div class="btns">
              <button class="btn btn-primary ml-auto">Send</button>
            </div>
          </modal>
          <!-- End of Send Quote Modal -->
        </div>

        <!-- Other Projects -->
        <section class="section-similar">
          <h2 class="h1">Related Projects</h2>

          <div class="row">
            <div class="col-lg-3 col-sm-6 col-xs-12">
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
                    <button class="btn btn-link btn-icon btn-vote">
                      <icon-base
                        width="18"
                        height="17.25"
                        view-box="0 0 18 17.25"
                        icon-name="like-4"
                      >
                        <icon-like-4 />
                      </icon-base>
                    </button>
                  </div>
                  <div class="card-category">
                    <div class="label">
                      <router-link to="/">Music Category</router-link>
                    </div>
                  </div>

                  <p class="card-text">
                    Lorem ipsum dolor sit amet, adipiscing elit. Fringilla
                    habitant eu porttitor eu. Libero sed feugiat luctus ac quam
                    purus.
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
                      <span>Project by</span>
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
            <div class="col-lg-3 col-sm-6 col-xs-12">
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
                    <button class="btn btn-link btn-icon btn-vote">
                      <icon-base
                        width="18"
                        height="17.25"
                        view-box="0 0 18 17.25"
                        icon-name="like-4"
                      >
                        <icon-like-4 />
                      </icon-base>
                    </button>
                  </div>
                  <div class="card-category">
                    <div class="label">
                      <router-link to="/">Music Category</router-link>
                    </div>
                  </div>

                  <p class="card-text">
                    Lorem ipsum dolor sit amet, adipiscing elit. Fringilla
                    habitant eu porttitor eu. Libero sed feugiat luctus ac quam
                    purus.
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
                      <span>Project by</span>
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
        </section>
        <!-- End of Other Projects -->
      </div>
    </main>

    <Footer />
  </div>
</template>

<script>
// import Vue from "vue";
// import {
//   Swiper as SwiperClass,
//   Pagination,
//   Navigation,
//   Mousewheel,
//   Autoplay
// } from "swiper/swiper.esm";
// import getAwesomeSwiper from "vue-awesome-swiper/dist/exporter";
import { Swiper, SwiperSlide, directive } from "vue-awesome-swiper";
import "vue-loading-overlay/dist/vue-loading.css";

import Header from "../common/Header.vue";
import Footer from "../common/Footer.vue";
import IconBase from "../common/IconBase.vue";
import IconLike2 from "../common/icons/IconLike2.vue";
import IconLink from "../common/icons/IconLink.vue";
import IconShoppingCart from "../common/icons/IconShoppingCart.vue";
import IconPdf from "../common/icons/IconPdf.vue";
import IconArrowRight from "../common/icons/IconArrowRight.vue";
import IconAngleRight2 from "../common/icons/IconAngleRight2.vue";
import IconCancel from "../common/icons/IconCancel.vue";
import IconLike4 from "../common/icons/IconLike4.vue";
import IconLike5 from "../common/icons/IconLike5.vue";

// SwiperClass.use([Pagination, Mousewheel, Navigation, Autoplay]);
// Vue.use(getAwesomeSwiper(SwiperClass));
// const { Swiper, SwiperSlide } = getAwesomeSwiper(SwiperClass);
// import "swiper/swiper-bundle.min.css";

import "swiper/css/swiper.css";

export default {
  name: "ProjectDetail",
  components: {
    Header,
    Footer,
    IconBase,
    IconLike2,
    IconLike4,
    IconLike5,
    IconLink,
    IconShoppingCart,
    IconPdf,
    IconCancel,
    IconArrowRight,
    IconAngleRight2,
    Swiper,
    SwiperSlide
  },
  data() {
    return {
      isAuthenticated: window.isAuthenticated,
      publicPath: local_image_path,
      totalPages: 0,
      is_already_voted: false,
      logged_user_id : null,
       isLoading: false,
      projectData :'',
      projectTags:[],
      projectProducts:[],
      projectImage:[],
      projectPdf:[],
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
        project_slug:null,

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
  created() {
    document.title = this.$route.meta.title;
    this.project_slug = this.$route.params.slug;


  },
   mounted() {
    this.$nextTick(() => {
      const swiperTop = this.$refs.swiperTop.$swiper;
      const swiperThumbs = this.$refs.swiperThumbs.$swiper;
      console.log("nextTick");
      console.log(swiperTop, swiperThumbs);
      swiperTop.controller.control = swiperThumbs;
      swiperThumbs.controller.control = swiperTop;
    });
    this.logged_user_id = localStorage.getItem("logged_user_id");
    this.loadProjectData();
  },
  methods: {
    // Contact modal form
    showQuoteDialog() {
      this.$modal.show("quote-modal-dialog");
    },
    hideQuoteDialog() {
      this.$modal.hide("quote-modal-dialog");
    },

    async loadProjectData() {
       this.isLoading= true
      const result = await this.callApi(
        'get',
        window.api_path + 'project/' + this.project_slug + '/details/' + this.logged_user_id,
        {}
      );
      if (result.status != 200) {
         this.isLoading= false;
        this.$toast.error(result.data.message);
        this.projectData = null;
        return;
      }
       this.isLoading= false;
      this.projectData  = result.data.project;
      this.projectImage = result.data.project_image;
      this.projectPdf   = result.data.project_pdf;
       console.log(this.projectImage);
//       this.projectImage .forEach(function(images) {
//         this.swiperGallery.push(projectImage.projectImagePropsArray.image_url);
//     console.log(this.swiperGallery);
// });

     if (this.projectData) {
       this.loadProjectTags(this.projectData.id);
       this.loadProjectProduct(this.projectData.id);
        console.log(this.projectTags);
      }
    },
    async loadProjectTags(project_id) {
      const result = await this.callApi(
        'get',
        window.api_path + 'project/' + project_id + '/getTags',
        {}
      );
      if (result.status != 200) {
        this.$toast.error(result.data.message);
        this.projectTags = [];
        return;
      }

      this.projectTags = result.data.projectTags;
    },
     async loadProjectProduct(project_id) {
      const result = await this.callApi(
        'get',
        window.api_path + 'project/' + project_id + '/getProducts',
        {}
      );
      if (result.status != 200) {
        this.$toast.error(result.data.message);
        this.projectProducts = [];
        return;
      }

      this.projectProducts = result.data.projectProducts;
      //console.log(this.projectProducts);
    },
  },
  directives: {
    swiper: directive
  },

};
</script>
