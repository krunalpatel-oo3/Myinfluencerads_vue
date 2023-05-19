<template>
  <div class="proposal-rebranded details-page">
    <Header />
    <div class="container">
      <h1 class="t-black t-36 w700" style="margin-top: 30px; margin-bottom: 10px">Hire a seller</h1>
      <div class="project-info">
        <div class="row">
          <div class="col-5">
            <h2 class="t-black w700 t-28" style="margin: 0">Name of the Project</h2>
            <router-link to="" class="t-color1 t-24 w600 category-link" style="margin-top: 5.5px">Music Category
            </router-link>
            <p style="margin-top: 10px">Sed feugiat luctus ac quam purus. Lorem ipsum dolor sit amet, eu porttitor eu.
              Libero sed feugiat luctus
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
      <div class="row mx-0 hero-row">
        <img :src="`${publicPath}project-1-wide.jpg`" alt="" />
        <div class="row see-more w-100 justify-content-center">
          <p class="w500 t-20 mb-0">See more
            <ArrowDown style="margin-left: 16px" />
          </p>
        </div>
      </div>
      <div class="row mx-0 tabs">
        <a v-for="(t, index) in tabs" :class="t === tab ? 'active-tab' : ''" @click="tab = t">{{ t }}</a>
      </div>
      <div v-if="tab === 'Proposals'" class="row mx-0 proposals align-items-center" style="margin-top: 25px">
        <p class="d-text"><img :src="`${publicPath}seller-avatar.png`" style="margin-right: 5px;" alt="">Kathryn Murphy
        </p>
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
        <div class="row mx-0">
          <div class="col-10 d-flex" style="flex-wrap: wrap">
            <p class="t-16 lh-23 t-color2 mt-1 w-100 mb-0">Have you ever seen stars below the sky, on the earth? Yes, the spark of
              light emerging from the land. On a cold night, standing on a peak of the mountain, when you look down at
              the place, you feel darkness enlightened by the rays of light.</p>
            <a href="" class="link-hover t-14 ml-auto" style="padding-right: 30px">Learn More <LinkRight style="margin-left: 11px"/></a>
          </div>
          <div class="col-2 d-flex align-content-center justify-content-end">
            <p class="t-28 w700">$40/hr</p>
          </div>
        </div>
      </div>
      <div v-if="tab === 'Search and invite'" class="search_invite" style="margin-top: 25px;">
        <div class="row mx-0">
          <div class="col-9">
            <div class="row mx-0 w-100 align-items-center" style="border: 1px solid #C3C5CC; border-radius: 3px; overflow: auto">
              <input type="text" class="search" placeholder="Search">
              <SearchIcon />
            </div>
            <div class="row mx-0 w-100" style="margin-top: 14px;">
              <vue-tags-input
                v-model="selectedTag"
                :tags="tags"
                class="w-100"
              />
            </div>
          </div>
          <div class="col-3">
            <v-select
              v-model="category"
              label="label"
              code="code"
              style="height: 47px; border: 1px solid #C3C5CC;"
              item-text="label"
              :options="categories"
              :clearable="false"
              class="form-control v-select-light"
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
                          </span> </template
            ></v-select>
          </div>
        </div>
        <div class="row mx-0">
          <div class="col-12">
            <div class="row mx-0 align-items-center" style="margin-top: 25px">
              <img :src="`${publicPath}streamer-avatar.png`" style="height: 40px; width: 40px" alt="">
              <div style="margin-left: 15px; width: 180px">
                <p class="t-20 w500 mb-0">Streamer Name</p>
                <p class="t-17 mb-0">DJ/ Visual Streaming</p>
              </div>
              <div class="badge">Pro</div>
              <div class="reviews-summary-rating" style="margin-right: 10px;">
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
              <button @click="$modal.show('send-invite-dialog')" class="btn send-invite-btn ml-auto btn-hover">Send an Invite</button>
            </div>
            <div class="row mx-0 align-items-center" style="margin-top: 25px">
              <img :src="`${publicPath}seller-avatar.png`" style="height: 40px; width: 40px" alt="">
              <div style="margin-left: 15px; width: 180px">
                <p class="t-20 w500 mb-0">Kathryn Murphy</p>
                <p class="t-17 mb-0">Visual Streamer</p>
              </div>
              <div class="badge">New</div>
              <div class="reviews-summary-rating" style="margin-right: 10px;">
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
              <span class="t-22 w500">5.0</span>
              <button @click="$modal.show('send-invite-dialog')" class="btn send-invite-btn ml-auto btn-hover">Send an Invite</button>
            </div>
          </div>
        </div>
      </div>
      <div v-if="tab === 'Pending Invites'" style="margin-top: 25px">
        <div class="row mx-0 align-items-center" style="margin-top: 25px">
          <img :src="`${publicPath}streamer-avatar.png`" style="height: 40px; width: 40px" alt="">
          <div style="margin-left: 15px; width: 180px">
            <p class="t-20 w500 mb-0">Streamer Name</p>
            <p class="t-17 mb-0">DJ/ Visual Streaming</p>
          </div>
          <div class="badge">Pro</div>
          <p class="t-16 lh-23 t-color2 mb-0" style="width: 652px">Have you ever seen stars below the sky, on the earth? Yes, the spark of light emerging from the land. On a cold night, standing on a peak of the mountain.</p>
        </div>
        <div class="row mx-0 align-items-center" style="margin-top: 25px">
          <img :src="`${publicPath}seller-avatar.png`" style="height: 40px; width: 40px" alt="">
          <div style="margin-left: 15px; width: 180px">
            <p class="t-20 w500 mb-0">Kathryn Murphy</p>
            <p class="t-17 mb-0">Visual Streamer</p>
          </div>
          <div class="badge">New</div>
            <p class="t-16 lh-23 t-color2 mb-0" style="width: 652px">Have you ever seen stars below the sky, on the earth? Yes, the spark of light emerging from the land. On a cold night, standing on a peak of the mountain.</p>
        </div>
      </div>
    </div>
    <SendInviteModal />
    <Footer style="margin-top: 138px" />
  </div>
</template>

<script>
import Header from "../common/Header.vue";
import Footer from "../common/Footer.vue";
import IconStars from "../common/icons/IconStars.vue";
import IconBase from "../common/IconBase.vue";
import HourlyIcon from "./icons/HourlyPrice.vue";
import CalendarIcon from "./icons/CalendarIcon.vue";
import SliderRight from "./icons/SliderRight.vue";
import IconCancel from "../common/icons/IconCancel.vue";
import FixedPrice from "./icons/FixedPrice.vue";
import ArrowDown from "./icons/ArrowDown";
import LinkRight from "./icons/LinkRight";
import SearchIcon from "./icons/SearchIcon";
import IconAngleDown from "./../common/icons/IconAngleDown.vue";
import VueTagsInput from "@johmun/vue-tags-input";
import Vue from "vue";
import vSelect from "vue-select";
import SendInviteModal from "./modals/SendInviteModal";

Vue.component("v-select", vSelect);

export default {
  name: "Project Detail",
  data() {
    return {
      payment: null,
      publicPath: local_image_path,
      title: null,
      type: null,
      titles: {
        "": "Proposal details",
        "archived": "Archived Project",
        "waiting": "Offer details",
        "in-progress": "Name of the Project",
        "completed": "Project Completed"
      },
      tab: "Proposals",
      category: null,
      categories: [
        'Category'
      ],
      tabs: [
        "Proposals",
        "Search and invite",
        "Pending Invites"
      ],
      selectedTag: [],
      tags: [
        'OBS Setup',
        'Tech Support'
      ]
    };
  },
  components: {
    VueTagsInput,
    Header,
    Footer,
    IconStars,
    IconBase,
    IconCancel,
    HourlyIcon,
    CalendarIcon,
    SliderRight,
    FixedPrice,
    ArrowDown,
    LinkRight,
    SearchIcon,
    IconAngleDown,
    SendInviteModal
  },
  mounted() {
    if (this.$route.query.payment === "fixed") {
      this.payment = "fixed";
    } else {
      this.payment = "hourly";
    }
    this.title = this.titles[this.$route.query.type];
  },
  computed: {
    filteredProductItems() {
      return this.autocompleteProductItems.filter(i => {
        return (
          i.text
            .toLowerCase()
            .indexOf(this.productFilterValue.toLowerCase()) !== -1
        );
      });
    },
    filteredTagItems() {
      return this.autocompleteTagItems.filter(i => {
        return (
          i.text.toLowerCase().indexOf(this.tagFilterValue.toLowerCase()) !== -1
        );
      });
    }
  }
};
</script>

<style lang="scss" scoped>
.d-text {
  line-height: 54px;
  font-size: 22px;
  font-weight: 500;
  margin-bottom: 0;
}
</style>
