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
    <div class="row mx-0 w-100" style="margin-top: 10px;">
      <p class="d-text" v-if="payment === 'fixed'">Fixed price: $1500</p>
      <p class="d-text" v-if="payment === 'fixed'" style="margin-left: 50px">By Nov 15, 2021</p>
      <p class="d-text" v-if="payment === 'hourly'">Hourly Rate: $30/hr</p>
      <p class="d-text" v-if="payment === 'hourly'" style="margin-left: 50px">Weekly Limit: 40hrs/week</p>
    </div>
    <div class="row mx-0 w-100">
      <p class="d-text">Amount In Escrow: $1200</p>
    </div>
    <div v-if="payment === 'fixed'" class="row mx-0 w-100">
      <h3 class="w500 t-22 roboto mb-0">Milestones:</h3>
      <table class="table">
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
          <td>Stream to youtube</td>
          <td>Lorem Ipsum dolor sit amet agna finibus risus</td>
          <td>Nov 1, 2021</td>
          <td>$700</td>
          <td>Active</td>
        </tr>
        <tr>
          <th scope="row">2</th>
          <td>Stream to facebook</td>
          <td>Lorem Ipsum dolor sit amet agna finibus risus</td>
          <td>Nov 1, 2021</td>
          <td>$800</td>
          <td></td>
        </tr>
        <tr>
          <th scope="row">3</th>
          <td>Stream to Twitch</td>
          <td>Lorem Ipsum dolor sit amet agna finibus risus</td>
          <td>Nov 1, 2021</td>
          <td>$800</td>
          <td></td>
        </tr>
        </tbody>
      </table>
    </div>
    <div class="row mx-0 w-100 justify-content-end">
      <button @click="showRevokeDialog" class="btn revoke btn-hover">Revoke</button>
    </div>
    <RevokeModal />
  </div>
</template>

<script>
import IconStars from "../../common/icons/IconStars.vue";
import IconBase from "../../common/IconBase.vue";
import RevokeModal from "../modals/RevokeModal";
export default {
  name: "BuyerWaiting",
  components: {
    IconStars,
    IconBase,
    RevokeModal
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
      publicPath: local_image_path
    }
  },
  methods: {
    showRevokeDialog () {
      this.$modal.show("revoke-offer-dialog")
    }
  }
};
</script>

<style scoped>
.d-text {
  font-weight: 500;
  line-height: 45px;
  font-size: 22px;
  margin-bottom: 0;
}
.revoke {
  width: 204px;
  background: #F2A91C;
  border-radius: 4px;
  font-size: 18px;
  color: #202C54;
  font-weight: 700;
  height: 62px;

}
</style>
