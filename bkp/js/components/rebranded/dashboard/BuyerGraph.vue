<template>
  <div>
    <label class="t-18 w500">Select period</label>
    <v-select
      v-model="period"
      code="code"
      label="label"
      :options="periods"
      :clearable="false"
      class="form-control v-select-light"
      placeholder="Select option"
      style="width: 40%; margin-bottom: 15px"
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
                          </span> </template></v-select>
    <div class="seller-graph">
      <line-chart :height="600" :options="chartOptions" :chart-data="datacollection"></line-chart>
    </div>
    <div class="row w-100 justify-content-end" style="margin-top: 25px; margin-bottom: 20px;">
      <div slot="button-prev" class="prev-btn" style="margin-right: 35px;">
        <ArrowLeftSwiper />
      </div>
      <div slot="button-next" class="next-btn">
        <ArrowRightSwiper />
      </div>
    </div>
    <swiper class="swiper" ref="swiper" :options="swiperOption">
      <swiper-slide>
        <div class="swiper-card">
          <h3 class="w500 t-24" style="margin-bottom: 20px; min-height: 60px">
            Number of projects in progress
          </h3>
          <p class="w700" style="color: #F2A91C; line-height: 75px; font-size: 50px">5</p>
        </div>
      </swiper-slide>
      <swiper-slide>
        <div class="swiper-card">
          <h3 class="w500 t-24" style="margin-bottom: 20px; min-height: 60px">
            Number of proposals
          </h3>
          <p class="w700 mb-auto" style="color: #F2A91C; line-height: 75px; font-size: 50px">21</p>
        </div>
      </swiper-slide>
      <swiper-slide>
        <div class="swiper-card">
          <h3 class="w500 t-24" style="margin-bottom: 20px; min-height: 60px">
            Number of disputed
            projects
          </h3>
          <p class="w700 mt-auto" style="color: #F2A91C; line-height: 75px; font-size: 50px">30</p>
        </div>
      </swiper-slide>
    </swiper>
  </div>
</template>

<script>
import LineChart from "./LineChart.js";
import { Swiper, SwiperSlide } from 'vue-awesome-swiper'
import ArrowLeftSwiper from "../icons/ArrowLeftSwiper";
import ArrowRightSwiper from "../icons/ArrowRightSwiper";
import IconAngleDown from "../../common/icons/IconAngleDown.vue";
import IconBase from "../../common/IconBase.vue";
import Vue from "vue";
import vSelect from "vue-select";

Vue.component("v-select", vSelect);
import "vue-select/dist/vue-select.css";
import 'swiper/css/swiper.css'
export default {
  name: "BuyerGraph",
  components: {
    LineChart,
    Swiper,
    SwiperSlide,
    ArrowLeftSwiper,
    ArrowRightSwiper,
    IconAngleDown,
    IconBase
  },
  data() {
    return {
      publicPath: local_image_path,
      activePending: true,
      activeDiscussion: true,
      activeInvites: true,
      activeProposals: true,
      period: null,
      periods: [
        'Nov 9 - Nov 19, 2021',
        'Nov 19 - Nov 29, 2021',
        'Nov 29 - Dec 8, 2021'
      ],
      datacollection: {
        labels: [
          "week 1",
          "week 2",
          "week 3",
          "week 4",
        ],
        datasets: [
          {
            data: [86, 114, 106, 106],
            label: "Completed Projects",
            borderColor: "#738EE9",
            backgroundColor: '#DDE4FA',
            fill: true
          },
          {
            data: [100, 145, 160, 180],
            backgroundColor: '#B7DBD6',
            label: "Total Earned",
            borderColor: "#4AC06B",
            fill: true
          }
        ]
      },
      chartOptions: {
        backgroundColor: 'white',
        scales: {
          yAxes: [{
            display: true,
            ticks: {
              display: false
            },
            gridLines: {
              color: "rgba(0, 0, 0, 0)",
            }
          }],
          xAxes: [{
            display: true,
            ticks: {
              display: true,
              fontSize: 18,
              fontFamily: 'Poppins',
              fontColor: '#202C54'
            },
            grid: {
              display: false
            },
            gridLines: {
              color: "rgba(0, 0, 0, 0)",
            }
          }]
        },
        legend: {
          display: true,
          align: 'start',
          labels: {
            padding: 40,
            usePointStyle: true,
            fontColor: '#202C54',
            fontFamily: 'Poppins',
            fontSize: 22
          }
        },
        maintainAspectRatio: false
      },
      swiperOption: {
        slidesPerView: 'auto',
        freeMode: true,
        direction: 'horizontal',
        navigation: {
          nextEl: '.next-btn',
          prevEl: '.prev-btn'
        },
        on: {
          resize: () => {
            this.$refs.swiper.$swiper.changeDirection(
              window.innerWidth <= 960
                ? 'vertical'
                : 'horizontal'
            )
          }
        }
      },
    }
  },
  methods: {
    togglePending() {
      this.activePending = !this.activePending;
    },
    toggleDiscussion() {
      this.activeDiscussion = !this.activeDiscussion;
    },
    toggleInvites() {
      this.activeInvites = !this.activeInvites;
    },
    toggleProposals() {
      this.activeProposals = !this.activeProposals;
    }
  }
};
</script>

<style lang="scss" scoped>
.swiper-slide {
  width: 350px;
}
.swiper-card {
  padding-top: 26px;
  padding-left: 31px;
  height: 220px;
  width: 330px;
  background: #FFFFFF;
  border-radius: 16px;
  margin-right: 40px;
}
.small {
  margin: 150px auto;
}

.accordion {
  img {
    transition: .2s;
    transform: rotate(180deg);
  }
}
.line-chard {
  height: 100%;
}

.active-acc {
  img {
    transform: rotate(0deg);
  }
}
</style>
