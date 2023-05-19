<template>
  <div class="row w-100" style="margin-top: 41px">
    <h2 class="w700 t-24 roboto w-100 mb-0">Contract Details</h2>
    <div v-if="payment === 'hourly'" class="progress-hourly w-100">
      <div class="row mx-0 w-100">
        <div>
          <h4 class="w500 roboto t-22 my-0">Hourly Rate: $30/hr</h4>
          <h4 class="w500 roboto t-22 my-0">Amount In Escrow: $1200</h4>
        </div>
        <div style="margin-left: 53px">
          <h4 class="w500 roboto t-22 my-0 w-100">Weekly Limit: 40hrs/week</h4>
          <h4 class="w500 roboto t-22 my-0 w-100">Total Earnings: $1000</h4>
        </div>
        <button @click="showEndContractModal" class="btn end-contract-btn">End Contract</button>
      </div>
      <h2 class="t-22 w500 roboto my-0">Transaction History:</h2>
      <div class="row mx-0">
        <table class="table">
          <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Description</th>
            <th scope="col">Date</th>
            <th scope="col">Amount</th>
          </tr>
          </thead>
          <tbody>
          <tr>
            <th scope="row">1</th>
            <td>Payment for 2021/10/25 - 2021/10/31 - 20hrs x $30/hr</td>
            <td>Nov 1, 2021</td>
            <td>$600</td>
          </tr>
          <tr>
            <th scope="row">2</th>
            <td>Bonus</td>
            <td>Nov 1, 2021</td>
            <td>$400</td>
          </tr>
          </tbody>
        </table>
      </div>
      <div class="row mx-0 w-100" style="margin-top: 38px">
        <h2 class="t-22 w500 roboto my-0" style="margin-right: 30px">Work Diary:</h2>
        <select class="select">
          <option selected>Nov 1, 2021 - Nov 7, 2021</option>
        </select>
        <button @click="showAddTimeModal" class="btn add-time-btn">Add Manual Time</button>
      </div>
      <div class="row mx-0" style="margin-top: 7px">
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
      <div class="row mx-0">
        <h2 class="w500 t-22 roboto">Current Session:</h2><span class="w400 t-18" style="margin-left: 21px; font-style: italic; line-height: 54px">Started Nov 15th, 2021 8:23 am</span>
        <div class="timer w-100 d-flex justify-content-center">
          <div class="row">
            <div class="col">
              <div class="row">
                <div class="digit">0</div>
                <div class="digit mr-0">0</div>
              </div>
              <div class="row">
                <p class="w500 t-14 w-100 text-center mb-0" style="margin-top: 12px">DAYS</p>
              </div>
            </div>
            <div class="colon">:</div>
            <div class="col">
              <div class="row">
                <div class="digit">0</div>
                <div class="digit mr-0">0</div>
              </div>
              <div class="row">
                <p class="w500 t-14 w-100 text-center mb-0" style="margin-top: 12px">HOURS</p>
              </div>
            </div>
            <div class="colon">:</div>
            <div class="col">
              <div class="row">
                <div class="digit">0</div>
                <div class="digit mr-0">0</div>
              </div>
              <div class="row">
                <p class="w500 t-14 w-100 text-center mb-0" style="margin-top: 12px">MINUTES</p>
              </div>
            </div>
            <div class="colon">:</div>
            <div class="col">
              <div class="row">
                <div class="digit">0</div>
                <div class="digit mr-0">0</div>
              </div>
              <div class="row">
                <p class="w500 t-14 w-100 text-center mb-0" style="margin-top: 12px">SECONDS</p>
              </div>
            </div>
          </div>
        </div>
        <div class="row w-100 justify-content-center" style="margin-top: 51px">
          <button @click="showAddTimeModal" class="btn timer-start-btn">Start</button>
        </div>
      </div>
    </div>
    <div v-if="payment === 'fixed'" class="accept-fixed w-100" style="margin-bottom: 53px">
      <div class="row mx-0 w-100">
        <div>
          <h4 class="w500 roboto t-22 my-0">Amount In Escrow: $1200</h4>
        </div>
        <div style="margin-left: 53px">
          <h4 class="w500 roboto t-22 my-0 w-100">Total Earnings: $1000</h4>
        </div>
        <div style="margin-left: auto">
          <button @click="showDisputeModal" class="btn end-contract-btn" style="margin-right: 22px">File a Dispute</button>
          <button @click="showEndContractModal" class="btn end-contract-btn">End Contract</button>
        </div>
      </div>
      <h2 class="t-22 w500 roboto my-0">Transaction History:</h2>
      <div class="row mx-0">
        <table class="table">
          <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Description</th>
            <th scope="col">Date</th>
            <th scope="col">Amount</th>
          </tr>
          </thead>
          <tbody>
          <tr>
            <th scope="row">1</th>
            <td>Milestone1: Stream to youtube</td>
            <td>Nov 1, 2021</td>
            <td>$600</td>
          </tr>
          <tr>
            <th scope="row">2</th>
            <td>Milestone2: Stream to facebook</td>
            <td>Nov 1, 2021</td>
            <td>$400</td>
          </tr>
          </tbody>
        </table>
      </div>
      <div class="row mx-0 w-100" style="margin-top: 38px">
        <h2 class="t-22 w500 roboto my-0" style="margin-right: 30px">Milestones:</h2>
      </div>
      <div class="row mx-0" style="margin-top: 7px">
        <table class="table">
          <thead>
          <tr>
            <th scope="col">#</th>
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
            <td>Lorem Ipsum dolor sit amet agna finibus risus</td>
            <td>Nov 10, 2021</td>
            <td>$1200</td>
            <td>Active</td>
            <td>
              <button @click="showSubmitModal" class="btn submit-btn">Submit Work</button>
            </td>
          </tr>
          <tr>
            <th scope="row">2</th>
            <td>Lorem Ipsum dolor sit amet agna finibus risus</td>
            <td>Nov 15, 2021</td>
            <td>$1000</td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
    <AcceptOfferModal />
    <DeclineOfferModal />
    <AddTimeModal />
    <EndContractModal />
    <DisputeModal />
    <SubmitWorkModal />
  </div>
</template>

<script>
import AcceptOfferModal from "../modals/AcceptOfferModal";
import DeclineOfferModal from "../modals/DeclineOfferModal";
import AddTimeModal from "../modals/AddTimeModal";
import EndContractModal from "../modals/EndContractModal";
import DisputeModal from "../modals/DisputeModal.vue";
import SubmitWorkModal from "../modals/SubmitWorkModal";

export default {
  name: "ProjectInProgress",
  data() {
    return {
      payment: null
    };
  },
  components: {
    AcceptOfferModal,
    DeclineOfferModal,
    AddTimeModal,
    EndContractModal,
    DisputeModal,
    SubmitWorkModal
  },
  methods: {
    showSubmitModal () {
      this.$modal.show("submit-work-dialog")
    },
    showDisputeModal () {
      this.$modal.show("open-dispute-dialog")
    },
    showAddTimeModal () {
      this.$modal.show("add-time-dialog")
    },
    showEndContractModal () {
      this.$modal.show("end-contract-dialog")
    },
    showAcceptDialog() {
      this.$modal.show("accept-offer-dialog");
    },
    showDeclineDialog() {
      this.$modal.show("decline-offer-dialog");
    }
  },
  mounted() {
    if (this.$route.query.payment === "fixed") {
      this.payment = "fixed";
    } else {
      this.payment = "hourly";
    }
  }
};
</script>

<style lang="scss" scoped>
.accept-btn, .decline-btn {
  background: #F2A91C;
  border-radius: 4px;
  width: 204px;
  height: 62px;
  font-weight: 700;
  font-size: 18px;
  color: #202C54;
  border: none;
}

.accept-btn {
  margin-right: 45px;
}

.btn {
  background: #F2A91C;
  border-radius: 4px;
  font-size: 18px;
  font-weight: 700;
  color: #202C54;
}

.end-contract-btn {
  height: 54px;
  width: 226px;
  margin-left: auto;
}

.select {
  width: 266px;
  height: 43px;
  border: 1px solid #DDE0E6;
  border-radius: 4px;
  background: white;
  box-sizing: border-box;
  padding-left: 12px;
  margin-top: 5px;
}

.add-time-btn {
  height: 54px;
  width: 226px;
  margin-left: auto;
}
.timer-start-btn {
  height: 62px;
  width: 204px;

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
.submit-btn {
  width: 138px;
  height: 33px;
  font-size: 16px;
  padding: 0px !important;
  paddint-top: 15px;
}
</style>
