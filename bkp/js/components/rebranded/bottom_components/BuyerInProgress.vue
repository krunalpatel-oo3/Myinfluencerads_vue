<template>
  <div class="row w-100" style="margin-top: 25px;">
    <h2 class="t-24 w700 roboto w-100 mb-0">Contract Details</h2>
    <div class="row mx-0 align-items-center w-100">
      <p class="d-text">Seller: <img :src="`${publicPath}seller-avatar.png`" style="margin-left: 10px; margin-right: 5px;" alt="">Kathryn Murphy</p>
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
    <div v-if="payment === 'hourly'" class="row mx-0 w-100" style="margin-top: 10px;">
      <p class="d-text">Hourly Rate: $30/hr</p>
      <p class="d-text" style="margin-left: 50px">Weekly Limit: 40hrs/week</p>
      <p class="d-text"style="margin-left: 50px">Total Spend: $1000</p>
    </div>
    <div class="row mx-0 w-100">
      <p class="d-text">Amount In Escrow: $1200</p>
    </div>
    <div v-if="payment === 'hourly'" class="row mx-0 w-100">
      <div class="row mx-0 w-100">
        <h3 class="w500 t-22 roboto mb-0">Transaction History:</h3>
        <button type="button" class="btn btn-dropdown" data-toggle="dropdown" aria-expanded="false">
          <MenuDots />
        </button>
        <div class="dropdown-menu">
          <a @click="$modal.show('open-dispute-dialog')" class="dropdown-item"><DisputeIcon style="margin-right: 10px;"/>File a dispute</a>
          <a @click="$modal.show('open-refund-dialog')" class="dropdown-item"><RefundIcon style="margin-right: 10px;"/>Request a refund</a>
          <a @click="$modal.show('open-bonus-dialog')" class="dropdown-item"><BonusIcon style="margin-right: 10px;"/>Give a bonus</a>
          <a @click="$modal.show('fund-escrow-dialog')" class="dropdown-item"><FundIcon style="margin-right: 10px;"/>Fund escrow</a>
        </div>
      </div>
      <table class="table">
        <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Description</th>
          <th scope="col">Date</th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <th scope="row">1</th>
          <td>Payment for 2021/10/25 - 2021/10/31 - 20hrs x $30/hr</td>
          <td>Nov 1, 2021</td>
        </tr>
        <tr>
          <th scope="row">2</th>
          <td>Bonus</td>
          <td>Nov 1, 2021</td>
        </tr>
        </tbody>
      </table>
    </div>
    <div v-if="payment === 'fixed'" class="row mx-0 w-100">
      <div class="row mx-0 w-100">
        <h3 class="w500 t-22 roboto mb-0">Transaction History:</h3>
        <button type="button" class="btn btn-dropdown" data-toggle="dropdown" aria-expanded="false">
          <MenuDots />
        </button>
        <div class="dropdown-menu">
          <a @click="$modal.show('open-dispute-dialog')" class="dropdown-item"><DisputeIcon style="margin-right: 10px;"/>File a dispute</a>
          <a @click="$modal.show('open-refund-dialog')" class="dropdown-item"><RefundIcon style="margin-right: 10px;"/>Request a refund</a>
          <a @click="$modal.show('open-bonus-dialog')" class="dropdown-item"><BonusIcon style="margin-right: 10px;"/>Give a bonus</a>
          <a @click="$modal.show('fund-escrow-dialog')" class="dropdown-item"><FundIcon style="margin-right: 10px;"/>Fund escrow</a>
        </div>
      </div>
      <table class="table">
        <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Description</th>
          <th scope="col">Date</th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <th scope="row">1</th>
          <td>Milestone1: Stream to youtube</td>
          <td>Nov 1, 2021</td>
        </tr>
        <tr>
          <th scope="row">2</th>
          <td>Milestone2: Stream to facebook</td>
          <td>Nov 1, 2021</td>
        </tr>
        </tbody>
      </table>
      <div class="row w-100 mx-0 justify-content-end">
        <h3 class="t-22 w500 w-100 text-right mb-0 roboto">Total spent: $1000</h3>
        <button @click="showAddMilestoneDialog" class="btn-hover btn-add-milestone">Add milestone</button>
      </div>
    </div>
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
      <table class="table">
        <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Description</th>
          <th scope="col">Date</th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <th scope="row">1</th>
          <td>Payment for 2021/10/25 - 2021/10/31 - 20hrs x $30/hr</td>
          <td>Nov 1, 2021</td>
        </tr>
        <tr>
          <th scope="row">2</th>
          <td>Bonus</td>
          <td>Nov 1, 2021</td>
        </tr>
        </tbody>
      </table>
    </div>
    <div v-if="payment === 'hourly'" class="row mx-0 w-100">
        <h3 class="w500 t-22 roboto mb-0" style="margin-right: 26px">Current Session: <span class="t-18 w400" style="font-style: italic">Started Nov 15th, 2021 8:23am</span></h3>
        <div class="timer w-100 d-flex justify-content-center">
          <div class="row">
            <div class="col">
              <div class="row">
                <div class="digit">0</div>
                <div class="digit mr-0">7</div>
              </div>
              <div class="row">
                <p class="w500 t-14 w-100 text-center mb-0" style="margin-top: 12px">DAYS</p>
              </div>
            </div>
            <div class="colon">:</div>
            <div class="col">
              <div class="row">
                <div class="digit">1</div>
                <div class="digit mr-0">0</div>
              </div>
              <div class="row">
                <p class="w500 t-14 w-100 text-center mb-0" style="margin-top: 12px">HOURS</p>
              </div>
            </div>
            <div class="colon">:</div>
            <div class="col">
              <div class="row">
                <div class="digit">2</div>
                <div class="digit mr-0">2</div>
              </div>
              <div class="row">
                <p class="w500 t-14 w-100 text-center mb-0" style="margin-top: 12px">MINUTES</p>
              </div>
            </div>
            <div class="colon">:</div>
            <div class="col">
              <div class="row">
                <div class="digit">2</div>
                <div class="digit mr-0">5</div>
              </div>
              <div class="row">
                <p class="w500 t-14 w-100 text-center mb-0" style="margin-top: 12px">SECONDS</p>
              </div>
            </div>
        </div>
      </div>
    </div>
    <div v-if="payment === 'hourly'" class="row mx-0 w-100 justify-content-end" style="margin-top: 30px;">
      <button @click="showPauseDialog" class="pause-btn btn-hover" style="margin-right: 26px">Pause contract</button>
      <button @click="showEndDialog" class="end-btn btn-hover">End contract</button>
    </div>
    <div v-if="payment === 'fixed'" class="row mx-0 w-100">
      <div class="row mx-0 w-100 align-items-center">
        <h3 class="w500 t-22 roboto mb-0" style="margin-right: 26px">Milestones</h3>
      </div>
      <table class="table">
        <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Name</th>
          <th scope="col">Description</th>
          <th scope="col">Due Date</th>
          <th scope="col">Amount</th>
          <th scope="col">Status</th>
          <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <th scope="row">1</th>
          <td>Lorem Ipsum dolor.</td>
          <td>Streamgeeks Rebranded Front End</td>
          <td>Nov 10, 2021</td>
          <td>$1200</td>
          <td style="color: #F2A91C">Active/submitted</td>
          <td>
            <button @click="showReviewDialog" class="table-btn btn-hover">Review work</button>
            <button @click="$modal.show('approve-milestone-dialog')" class="table-btn btn-hover">Pay now</button>
          </td>
        </tr>
        <tr>
          <th scope="row">2</th>
          <td>Lorem Ipsum dolor.</td>
          <td>Streamgeeks Rebranded Front End</td>
          <td>Nov 15, 2021</td>
          <td>$1000</td>
          <td style="color: #F2A91C"></td>
          <td>
            <button @click="$modal.show('edit-milestone-dialog')" class="table-btn btn-hover">Edit</button>
            <button @click="$modal.show('delete-milestone-dialog')" class="table-btn btn-hover">Remove</button>
          </td>
        </tr>
        </tbody>
      </table>
    </div>
    <div v-if="payment === 'fixed'" class="row mx-0 w-100 justify-content-end" style="margin-top: 30px;">
      <button @click="showPauseDialog" class="pause-btn btn-hover">End contract</button>
    </div>
    <PauseContractModal />
    <EndContractModal />
    <ReviewWorkModal />
    <AddMilestoneModal />
    <DisputeModal />
    <OpenRefundModal />
    <FundEscrowModal />
    <EditMilestoneModal />
    <ApproveMilestoneModal />
    <DeleteMilestoneModal />
  </div>
</template>

<script>
import Vue from "vue";
import vSelect from "vue-select";
import IconStars from "../../common/icons/IconStars.vue";
import RevokeModal from "../modals/RevokeModal";
import IconBase from "../../common/IconBase.vue";
import IconAngleDown from "../../common/icons/IconAngleDown.vue";
import MenuDots from "../icons/MenuDots";
import PauseContractModal from "../modals/PauseContractModal";
import EndContractModal from "../modals/EndContractModal";
import ReviewWorkModal from "../modals/ReviewWorkModal";
import AddMilestoneModal from "../modals/AddMilestoneModal";
import FundIcon from "../icons/FundIcon";
import BonusIcon from "../icons/BonusIcon";
import RefundIcon from "../icons/RefundIcon";
import DisputeIcon from "../icons/DisputeIcon";
import DisputeModal from "../modals/DisputeModal";
import OpenRefundModal from "../modals/OpenRefundModal";
import FundEscrowModal from "../modals/FundEscrowModal";
import EditMilestoneModal from "../modals/EditMilestoneModal";
import ApproveMilestoneModal from "../modals/ApproveMilestoneModal";
import DeleteMilestoneModal from "../modals/DeleteMilestoneModal";
Vue.component("v-select", vSelect);
import "vue-select/dist/vue-select.css";
export default {
  name: "BuyerInProgress",
  components: {
    IconStars,
    IconBase,
    RevokeModal,
    MenuDots,
    IconAngleDown,
    PauseContractModal,
    EndContractModal,
    ReviewWorkModal,
    AddMilestoneModal,
    BonusIcon,
    RefundIcon,
    DisputeIcon,
    FundIcon,
    DisputeModal,
    OpenRefundModal,
    FundEscrowModal,
    EditMilestoneModal,
    ApproveMilestoneModal,
    DeleteMilestoneModal
  },
  mounted () {
    if (this.$route.query.payment === 'fixed') {
      this.payment = 'fixed'
    } else {
      this.payment = 'hourly'
    }
  },
  data () {
    return {
      payment: null,
      publicPath: local_image_path,
      dates: ["Nov 1, 2021 - Nov 7, 2021", "Nov 7, 2021 - Nov 14, 2021"],
      date: "Nov 1, 2021 - Nov 7, 2021",
    }
  },
  methods: {
    showPauseDialog () {
      this.$modal.show("pause-contract-dialog")
    },
    showEndDialog () {
      this.$modal.show("end-contract-dialog")
    },
    showReviewDialog () {
      this.$modal.show("review-work-dialog")
    },
    showAddMilestoneDialog () {
      this.$modal.show("add-milestone-dialog")
    }
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
.digit {
  background: #FFFFFF;
  box-shadow: 0px 4px 26px rgba(0, 0, 0, 0.08);
  border-radius: 4px;
  font-size: 34px;
  font-weight: 500;
  padding: 15px;
  margin-right: 10px;
}

.colon {
  font-size: 34px;
  font-weight: 500;
  padding: 15px;
  margin-right: 10px;
}
</style>
