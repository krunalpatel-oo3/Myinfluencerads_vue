<template>
  <div class="container payment-page">
    <div class="row align-items-center" style="margin-top: 51px">
      <router-link to="" class="t-24 t-black w400 back"><ArrowLeft style="margin-right: 20px"/>Back</router-link>
    </div>
    <div class="row main-row">
      <div v-if="payment === 'hourly'" class="col-5">
        <h1 class="mb-0 t-36 w700 h-under">Put money on Escrow</h1>
        <div class="row align-content-center mt-2">
          <div class="row mx-0 align-items-center">
            <p class="w500 t-24 mb-0">Total amount to fund:</p>
            <p class="mb-0 w400 t-36" style="margin-left: 21px">$440.00</p>
          </div>
        </div>
        <div class="per-hour d-flex align-items-center">
          <HourlyIcon :width="'30'" :height="'30'" style="margin-right: 11px" />
          <p class="t-black w500 t-22 mb-0 lh-54">$22 hourly rate</p>
        </div>
        <div class="hours d-flex align-items-center">
          <CalendarIcon
            :width="'30'"
            :height="'30'"
            style="margin-right: 11px"
          />
          <p class="t-black w500 t-22 mb-0 lh-54">20hrs weekly limit</p>
        </div>
        <div class="row mx-0 align-items-center">
          <p class="w500 t-24 mb-0">Balance:</p>
          <p class="mb-0 w400 t-36" style="margin-left: 21px">$200.00</p>
        </div>
        <div class="row mx-0 align-items-center" style="margin-top: 15px">
          <p class="w500 t-24 mb-0" style="width: 130px; line-height: 24px">
            Amount to fund more:
          </p>
          <p class="mb-0 w400 t-36" style="margin-left: 21px">$220.00</p>
        </div>
        <h3 class="w700 t-28 lh-54 mb-0" style="margin-top: 18px">
          Name of the Project
        </h3>
        <p class="t-24 w500" style="color: #f2a91c">Music Category</p>
        <p class="t-16 t-color2" style="padding-right: 170px">
          Sed feugiat luctus ac quam purus. Lorem ipsum dolor sit amet, eu
          porttitor eu. Libero sed feugiat luctus ac quam purus
        </p>
      </div>
      <div v-if="payment === 'fixed'" class="col-5">
        <h1 class="mb-0 t-36 w700 h-under roboto">Activate Milestone 1</h1>
        <h4 class="t-24 w500 mb-0" style="margin-top: 23px">Leave</h4>
        <p class="t-36">$1200.00</p>
        <h4 class="t-24 lh-54 w500 roboto mb-0" style="margin-top: 25px">Milestone description</h4>
        <p class="t-24 lh-37" style="width: 80%">Lorem Ipsum dolor sit amet agna finibus risus</p>
        <h4 class="t-24 lh-54 w500 roboto mb-0" style="margin-top: 13px">Due Date</h4>
        <p class="t-24 lh-37">Nov 10, 2021</p>
        <h2 class="t-28 w700 lh-54 mb-0" style="margin-top: 7px">Name of the Project</h2>
        <a href="" class="t-24 t-color1 hov-under" style="margin-top: 10px">Music Category</a>
        <p class="t-16 t-color2" style="margin-top: 10px; width: 80%">Sed feugiat luctus ac quam purus. Lorem ipsum dolor sit amet, eu porttitor eu. Libero sed feugiat luctus ac quam purus</p>
      </div>
      <div class="col-7">
        <div class="info-card">
          <h2 class="w700 t-16" style="margin-bottom: 20px">Billing Address</h2>
          <div class="row mx-0" style="margin-bottom: 16px">
            <div class="group-input">
              <label>First Name</label>
              <input type="text" class="billing-input" />
            </div>
            <div class="group-input ml-auto">
              <label>Last Name</label>
              <input type="text" class="billing-input" />
            </div>
          </div>
          <div class="row mx-0" style="margin-bottom: 16px">
            <div class="group-input ml-auto w-100">
              <label>Email Address</label>
              <input type="email" class="billing-input" />
            </div>
          </div>
          <div class="row mx-0" style="margin-bottom: 16px">
            <div class="group-input ml-auto w-100">
              <label>Street Address</label>
              <input type="text" class="billing-input" />
            </div>
          </div>
          <div class="row mx-0" style="margin-bottom: 16px">
            <div class="group-input">
              <label>State/Province</label>
              <select class="billing-input">
                <option selected>California</option>
              </select>
            </div>
            <div class="group-input ml-auto">
              <label>City</label>
              <input type="text" class="billing-input" />
            </div>
          </div>
          <div class="row mx-0" style="margin-bottom: 16px">
            <div class="group-input">
              <label>Zip/Postal Code</label>
              <input type="text" class="billing-input" />
            </div>
            <div class="group-input ml-auto">
              <label>Phone</label>
              <input type="text" class="billing-input" />
            </div>
          </div>
          <div class="row mx-0 align-items-center">
            <input
              type="checkbox"
              id="address"
              name="address"
              style="height: 12px; margin-right: 8px"
            />
            <label class="t-14 mb-0" style="color: #4f4f4f" for="address"
              >My billing and shipping address are the same</label
            >
          </div>
          <div class="row mx-0 align-items-center" style="margin-top: 10px">
            <input
              checked
              type="checkbox"
              id="account"
              name="account"
              style="height: 12px; margin-right: 8px"
            />
            <label class="t-14 mb-0" style="color: #4f4f4f" for="account"
              >Create an account for later use</label
            >
          </div>
          <div class="row mx-0" style="margin-top: 16px; margin-bottom: 12px">
            <div class="group-input">
              <label>Password</label>
              <input type="password" class="billing-input" />
            </div>
            <div class="group-input ml-auto">
              <label>Confirm Password</label>
              <input type="password" class="billing-input" />
            </div>
          </div>
          <p class="t-12 t-color4">
            Already have an account?
            <a href="" style="color: #1660cf; text-decoration: underline"
              >Sign in here</a
            >
          </p>
        </div>
        <div class="payment-card" style="margin-top: 54px; margin-bottom: 80px">
          <h2 class="w700 t-16" style="margin-bottom: 20px">Payment Method</h2>
          <div class="row mx-0 paypal align-items-start">
            <input
              type="radio"
              id="paypal-radio"
              name="paypal-radio"
              style="margin-top: 4px"
            />
            <label
              for="paypal-radio"
              class="w600 t-16 mb-0"
              style="margin-left: 8px"
              >PayPal</label
            >
            <p
              class="t-14 mb-0 t-color4"
              style="width: 330px; margin-left: 21px"
            >
              You will be redirected to the PayPal website after submitting your
              order
            </p>
            <PaypalLogo class="ml-auto" />
          </div>
          <div class="credit-card">
            <div class="row mx-0 align-items-center">
              <input type="radio" id="credit-radio" name="credit-radio" />
              <label
                for="credit-radio"
                class="t-16 w600 mb-0"
                style="margin-left: 8px"
                >Pay with Credit Card</label
              >
              <div class="ml-auto">
                <img :src="`${publicPath}Visa.png`" alt="" />
                <img :src="`${publicPath}Discover.png`" alt="" />
                <img :src="`${publicPath}Maestro.png`" alt="" />
                <img :src="`${publicPath}Mastercard.png`" alt="" />
              </div>
            </div>
            <div class="row mx-0 w-100" style="margin-bottom: 16px; margin-top: 11px">
              <div class="group-input">
                <label>Card number</label>
                <input type="text" class="billing-input" />
              </div>
              <div class="group-input ml-auto">
                <label>Expiration Date</label>
                <input type="date" class="billing-input" />
              </div>
            </div>
            <div class="row mx-0 w-100" style="margin-bottom: 16px">
              <div class="group-input">
                <label>Card Security Code</label>
                <input type="password" class="billing-input" />
              </div>
              <div class="group-input d-flex ml-auto hov-under align-items-center">
                <a href="" class="t-12" style="color: #2F80ED">What is this?</a>
              </div>
            </div>
          </div>
          <p class="t-12" style="color: #828282; margin-top: 20px">Fund escrow for the first week.</p>
          <p class="t-12" style="color: #828282; margin-top: 10px"><LockIcon style="margin-right: 10px" />We protect your payment information using encryption to provide bank-level security.</p>
          <div class="row mx-0 w-100 justify-content-center">
            <button @click="$modal.show('payment-success-dialog')" class="pay-btn">Pay $500.00</button>
          </div>
        </div>
      </div>
    </div>
    <PaymentSuccessfulModal />
  </div>
</template>

<script>
import HourlyIcon from "./icons/HourlyPrice.vue";
import CalendarIcon from "./icons/CalendarIcon.vue";
import PaypalLogo from "./icons/PaypalLogo.vue";
import LockIcon from "./icons/LockIcon.vue";
import ArrowLeft from "./icons/ArrowLeft.vue";
import PaymentSuccessfulModal from "./modals/PaymentSuccessfulModal";

export default {
  name: "PaymentPage",
  data() {
    return {
      publicPath: local_image_path,
      payment: null
    };
  },
  components: {
    HourlyIcon,
    CalendarIcon,
    PaypalLogo,
    LockIcon,
    ArrowLeft,
    PaymentSuccessfulModal
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

<style lang="scss" scoped>
.h-under {
  border-bottom: 6px solid #f2a91c;
  width: fit-content;
  line-height: 54px;
}
.main-row {
  margin-top: 40px;
}
.info-card,
.payment-card {
  box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.14);
  border-radius: 4px;
  padding: 19px 62px;
}
.billing-input {
  background: white;
  border: 1px solid #b2bcca;
  border-radius: 4px;
  height: 44px;
  padding-left: 14px;
  width: 100%;
}
.group-input {
  width: 47%;
  padding-top: 10px;
  position: relative;
  label {
    padding: 0 10px;
    background: white;
    top: 2px;
    color: #828282;
    font-size: 12px;
    position: absolute;
    left: 10px;
  }
}
.paypal {
  border: 1px solid #b2bcca;
  box-sizing: border-box;
  border-radius: 4px;
  padding: 17px 19px;
  margin-bottom: 15px;
}
.credit-card {
  border-radius: 4px;
  border: 1px solid #d2d5dd;
  background: #f8f9fa;
  padding: 17px 19px;
}
.pay-btn {
  width: 333px;
  height: 40px;
  box-shadow: 0px 4px 4px rgba(14, 53, 191, 0.25);
  background: #386eea;
  border-radius: 6px;
  font-weight: 700;
  color: #F6F6F6;
  font-size: 16px;
  border: none;
  transition: .2s;
  &:hover {
    filter: brightness(1.1);
  }
}
</style>
