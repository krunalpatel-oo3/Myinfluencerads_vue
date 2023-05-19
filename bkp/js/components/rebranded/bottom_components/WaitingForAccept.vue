<template>
  <div class="row w-100" style="margin-top: 41px">
    <h2 class="w700 t-24 roboto w-100 mb-0">Contract Details</h2>
    <div v-if="payment === 'hourly'" class="accept-hourly" style="margin-bottom: 30px">
      <div class="row mx-0">
        <h4 class="w500 roboto t-22 my-0">Hourly Rate: $30/hr</h4>
        <h4 class="w500 roboto t-22" style="margin-left: 78px">Weekly Limit: 40hrs/week</h4>
      </div>
      <h4 class="w500 roboto t-22 my-0 w-100">Amount In Escrow: $1200</h4>
    </div>
    <div v-if="payment === 'fixed'" class="accept-fixed w-100" style="margin-bottom: 30px">
      <div class="row mx-0">
        <h4 class="w500 roboto t-22 my-0">Fixed price: $1500</h4>
        <h4 class="w500 roboto t-22" style="margin-left: 78px">By Nov 15, 2021</h4>
      </div>
      <h4 class="w500 roboto t-22 my-0 w-100">Amount In Escrow: $1000</h4>
      <h4 class="w500 roboto t-22 my-0 w-100">Milestones:</h4>
      <div class="row mx-0" style="padding-right: 70px">
        <table class="table equipment_table">
          <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Description</th>
            <th scope="col">Due Date</th>
            <th scope="col">Amount</th>
            <th scope="col">Status</th>
          </tr>
          </thead>
          <tbody>
          <tr>
            <th scope="row">1</th>
            <td>Stream to Youtube</td>
            <td>Lorem Ipsum dolor sit amet agna finibus risus</td>
            <td>Nov 10, 2021</td>
            <td>$500</td>
            <td>Active</td>
          </tr>
          <tr>
            <th scope="row">2</th>
            <td>Stream to Facebook</td>
            <td>Lorem Ipsum dolor sit amet agna finibus risus</td>
            <td>Nov 15, 2021</td>
            <td>$500</td>
            <td></td>
          </tr>
          <tr>
            <th scope="row">3</th>
            <td>Stream to Twitch</td>
            <td>Lorem Ipsum dolor sit amet agna finibus risus</td>
            <td>Nov 15, 2021</td>
            <td>$500</td>
            <td></td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="row mx-0 d-flex w-100 justify-content-end" style="padding-right: 70px">
      <button @click="showAcceptDialog" class="accept-btn">Accept</button>
      <button @click="showDeclineDialog" class="decline-btn">Decline</button>
    </div>
    <AcceptOfferModal />
    <DeclineOfferModal />
  </div>
</template>

<script>
import AcceptOfferModal from "../modals/AcceptOfferModal";
import DeclineOfferModal from "../modals/DeclineOfferModal";
export default {
  name: "WaitingForAccept",
  data () {
    return {
      payment: null
    }
  },
  components: {
    AcceptOfferModal,
    DeclineOfferModal
  },
  methods: {
    showAcceptDialog () {
      this.$modal.show("accept-offer-dialog")
    },
    showDeclineDialog () {
      this.$modal.show("decline-offer-dialog")
    }
  },
  mounted () {
    if (this.$route.query.payment === 'fixed') {
      this.payment = 'fixed'
    } else {
      this.payment = 'hourly'
    }
  }
};
</script>

<style scoped>
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
</style>
