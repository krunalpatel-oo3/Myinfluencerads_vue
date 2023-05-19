<template>
  <modal
    name="add-payment-dialog"
    :width="824"
    height="auto"
    :scrollable="true"
    :adaptive="true"
    transition=""
    class="section-modal add-payment-modal"
  >
    <div
      class="modal-close"
      @click="$modal.hide('add-payment-dialog')"
    >
      <CloseIcon />
    </div>
    <div class="row">
      <h2 class="w700 poppins t-33" style="margin-bottom: 17px">Add Payment</h2>
      <div class="row w-100 justify-content-between">
        <div class="pay-wrapper">
          <div class="payment-card">
            <img :src="`${publicPath}paypal_icon.png`" alt="">
          </div>
          <p>Paypal Account</p>
        </div>
        <div class="pay-wrapper">
          <div class="payment-card">
            <img :src="`${publicPath}payoneer_icon.png`" alt="">
          </div>
          <p>Payoneer Account</p>
        </div>
        <div class="pay-wrapper" @click="payment = 'Bank'">
          <div class="payment-card">
            <img :src="`${publicPath}bank_icon.png`" alt="">
          </div>
          <p>Bank Account</p>
        </div>
      </div>
    </div>
    <div v-if="payment === 'Paypal'" class="row">
      <h2 class="w700 poppins t-33" style="margin-bottom: 17px">Add Paypal Account</h2>
      <div class="col-12">
        <label>Email</label>
        <input type="text" placeholder="Enter email">
      </div>
      <div class="btns">
        <button class="btn roboto btn-hover">Connect to Paypal</button>
      </div>
    </div>
    <div v-if="payment === 'Payoneer'" class="row">
      <h2 class="w700 poppins t-33" style="margin-bottom: 17px">Add Payoneer Account</h2>
      <div class="col-12">
        <label>Email</label>
        <input type="text" placeholder="Enter email">
      </div>
      <div class="btns">
        <button class="btn roboto btn-hover">Connect to Payoneer</button>
      </div>
    </div>
    <div v-if="payment === 'Bank'" class="row">
      <h2 class="w700 poppins t-33" style="margin-bottom: 17px">Add Bank Account</h2>
      <div class="col-12">
        <label>Swift Code</label>
        <input type="text" placeholder="Enter swift">
        <label>Bank</label>
        <input type="text" placeholder="Enter bank name">
        <label>Name of the Account</label>
        <input type="text" placeholder="Account">
      </div>
      <div class="btns">
        <button class="btn roboto btn-hover">Submit</button>
      </div>
    </div>
  </modal>
</template>

<script>
import CloseIcon from "../icons/CloseIcon.vue";

export default {
  name: "AddPaymentModal",
  data () {
    return {
      payment: null,
      publicPath: local_image_path,
    }
  },
  components: {
    CloseIcon
  },
  methods: {
    close_modal () {
      this.$modal.hide('add-payment-dialog')
      this.payment = null
    },
  }
};
</script>

<style lang="scss" scoped>
.pay-wrapper {
  width: 33%;
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  &:hover {
    p {
      color: #F2A91C;
    }
  }
  .payment-card {
    height: 180px;
    width: 180px;
    display: flex;
    align-items: center;
    background: #E5E5E5;
    border-radius: 10px;
    justify-content: center;
    cursor: pointer;
  }
  p {
    cursor: pointer;
    font-size: 25px;
    font-weight: 500;
    line-height: 54px;
  }
}

label {
  font-size: 26px;
  line-height: 30px;
  color: #000000;
  font-weight: 700;
}
input {
  margin-bottom: 20px;
  width: 100%;
  height: 73px;
  background: #E5E5E5;
  border-radius: 5px;
  font-size: 22px;
  padding: 0 17px;
  color: #333333;
  &::placeholder {
    font-size: 22px;
    font-weight: 500;
    color: #333333;
  }
  border: none;
}
.modal-close {
  padding: 0 !important;
  top: 31px !important;
  right: 31px !important;
}

.row {
  margin: 10px 20px 0px 20px;
  display: flex;
  justify-content: center;
  flex-wrap: wrap;

  .btns {
    width: 100%;
    display: flex;
    justify-content: center;
    margin-top: 10px;
    margin-bottom: 20px;

    .btn {
      margin: 0 !important;
      height: 83.34px;
      width: 284.25px;
      background: #F2A91C;
      border-radius: 15px;
      font-size: 24px;
      border: none;
      color: #000000;
      font-weight: 500;
    }
  }

  h2 {
    width: 100%;
    text-align: center;
    line-height: 54px;
  }
}
</style>

