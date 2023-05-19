<template>
  <div class="row w-100" style="margin-top: 25px;">
    <h2 class="t-24 w700 roboto w-100 mb-0">Feedback</h2>
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
    <div class="row mx-0 mt-2">
      <p class="t-16 w400" style="color: rgba(0, 0, 0, 0.8)">Have you ever seen stars below the sky, on the earth? Yes,
        the spark of light emerging from the land. On a cold night, standing on a peak of the mountain, when you look
        down at the place, you feel darkness enlightened by the rays of light. The blow of the cold chilly wind will
        enlighten your spark and soul. The beauty of the night is among the stars above the sky to the stars below the
        sky. The streets with warm light and covered with trees and a water canal give the essence of fantasy. </p>
    </div>
    <div class="row mx-0 mt-2 align-items-center">
      <p class="d-text">Your feedback:</p>
      <div class="reviews-summary-rating" style="margin-left: 18px; margin-right: 10px;">
        <div class="rating-val-w">
          <div class="rating rating-lg">
            <div class="rating-current" style="width: 60%;">
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
      <span class="t-22 w500">3.5</span>
    </div>
    <p class="t-16 mt-1 mb-4" style="color: rgba(0, 0, 0, 0.8)">Have you ever seen stars below the sky, on the earth?
      Yes, the spark of light emerging from the land. On a cold night, standing on a peak of the mountain, when you look
      down at the place, you feel darkness enlightened by the rays of light. </p>
    <div v-if="payment === 'hourly'" class="row mx-0 w-100">
      <div class="row mx-0 w-100 align-items-center">
        <h3 class="w500 t-22 roboto mb-0" style="margin-right: 26px">Work Diary:</h3>
        <v-select
          v-model="date"
          label="label"
          code="code"
          item-text="label"
          :options="dates"
          :clearable="false"
          class="form-control v-select-light"
          placeholder="Select option"
        >
          <template #open-indicator="{ attributes }">
                            <span v-bind="attributes">
                              <icon-base
                                width="12"
                                height="6.84"
                                view-box="0 0 12 6.84"
                                icon-name="angle-down"
                              >
                                <icon-angle-down />
                              </icon-base>
                            </span></template
          >
        </v-select>
        <button type="button" class="btn btn-dropdown" data-toggle="dropdown" aria-expanded="false">
          <MenuDots />
        </button>
        <div class="dropdown-menu">
          <a @click="$modal.show('open-dispute-dialog')" class="dropdown-item">
            <DisputeIcon style="margin-right: 10px;" />
            File a dispute</a>
          <a @click="$modal.show('open-refund-dialog')" class="dropdown-item">
            <RefundIcon style="margin-right: 10px;" />
            Request a refund</a>
        </div>
      </div>
      <table class="table">
        <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Memo</th>
          <th scope="col">Duration</th>
          <th scope="col">Time</th>
          <th scope="col">Date</th>
          <th scope="col">Amount</th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <th scope="row">1</th>
          <td>Streamgeeks Rebranded Front End</td>
          <td>4:29</td>
          <td>7:51 am - 12:20 pm</td>
          <td>Nov 1, 2021</td>
          <td>$134</td>
        </tr>
        <tr>
          <th scope="row">2</th>
          <td>Streamgeeks Rebranded Front End</td>
          <td>4:29</td>
          <td>7:51 am - 12:20 pm</td>
          <td>Nov 1, 2021</td>
          <td>$134</td>
        </tr>
        </tbody>
      </table>
    </div>
    <div class="row mx-0 w-100">
      <h3 class="w500 t-22 roboto mb-0">Transaction History:</h3>
      <button v-if="payment === 'fixed'" type="button" class="btn btn-dropdown" data-toggle="dropdown" aria-expanded="false">
        <MenuDots />
      </button>
      <div v-if="payment === 'fixed'" class="dropdown-menu">
        <a @click="$modal.show('open-dispute-dialog')" class="dropdown-item">
          <DisputeIcon style="margin-right: 10px;" />
          File a dispute</a>
        <a @click="$modal.show('open-refund-dialog')" class="dropdown-item">
          <RefundIcon style="margin-right: 10px;" />
          Request a refund</a>
      </div>
      <table class="table">
        <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Name</th>
          <th scope="col">Description</th>
          <th scope="col">Date</th>
          <th scope="col">Amount</th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <th scope="row">1</th>
          <td>Lorem Ipsum dolor.</td>
          <td>Payment for 2021/10/25 - 2021/10/31 - 20hrs x $30/hr</td>
          <td>Nov 1, 2021</td>
          <td>$600</td>
        </tr>
        <tr>
          <th scope="row">2</th>
          <td>Lorem Ipsum dolor.</td>
          <td>Bonus</td>
          <td>Nov 1, 2021</td>
          <td>$400</td>
        </tr>
        </tbody>
      </table>
      <h2 class="w-100 w700 t-24 roboto text-right mb-0">Total Amount Paid: $ 3,500</h2>
    </div>
    <DisputeModal />
    <OpenRefundModal />
  </div>
</template>

<script>
import Vue from "vue";
import vSelect from "vue-select";
import IconStars from "../../common/icons/IconStars.vue";
import IconBase from "../../common/IconBase.vue";
import IconAngleDown from "../../common/icons/IconAngleDown.vue";
import MenuDots from "../icons/MenuDots";
import FundIcon from "../icons/FundIcon";
import BonusIcon from "../icons/BonusIcon";
import RefundIcon from "../icons/RefundIcon";
import DisputeIcon from "../icons/DisputeIcon";
import DisputeModal from "../modals/DisputeModal";
import OpenRefundModal from "../modals/OpenRefundModal";
Vue.component("v-select", vSelect);
import "vue-select/dist/vue-select.css";

export default {
  name: "BuyerCompleted",
  components: {
    IconStars,
    IconBase,
    MenuDots,
    IconAngleDown,
    BonusIcon,
    RefundIcon,
    DisputeIcon,
    FundIcon,
    DisputeModal,
    OpenRefundModal,
  },
  mounted() {
    if (this.$route.query.payment === "fixed") {
      this.payment = "fixed";
    } else {
      this.payment = "hourly";
    }
  },
  data() {
    return {
      payment: null,
      publicPath: local_image_path,
      dates: ["Nov 1, 2021 - Nov 7, 2021", "Nov 7, 2021 - Nov 14, 2021"],
      date: "Nov 1, 2021 - Nov 7, 2021"
    };
  }
};
</script>

<style scoped>
.dropdown-item {
  padding: 10px 20px;
  cursor: pointer;
}

.pause-btn, .end-btn {
  background: #F2A91C;
  border-radius: 4px;
  width: 204px;
  height: 62px;
  border: none;
  font-weight: 700;
  font-size: 18px;
}

.v-select-light {
  width: 266px;
  height: 43px;
}

.btn-add-milestone {
  width: 138px;
  height: 32px;
  font-weight: 500;
  font-size: 16px;
  background: #F2A91C;
  border-radius: 4px;
  border: none;
}

.table-btn {
  height: 32px;
  border: none;
  background: #F2A91C;
  border-radius: 4px;
  font-size: 16px;
  font-weight: 500;
  margin: 0 5px;
  min-width: 80px;
}

.d-text {
  font-weight: 500;
  line-height: 45px;
  font-size: 22px;
  margin-bottom: 0;
}

.btn-dropdown {
  height: 43px;
  background: transparent;
  margin-left: auto;
}
</style>
