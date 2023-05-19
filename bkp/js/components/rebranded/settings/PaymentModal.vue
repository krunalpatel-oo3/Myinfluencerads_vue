<template>
  <modal
    name="payment-dialog"
    :width="750"
    height="auto"
    :scrollable="true"
    :adaptive="true"
    transition=""
    class="section-modal add-payment-modal"
    @closed="onClose"
  >
    <div
      class="modal-close"
      @click="$modal.hide('payment-dialog')"
    >
      <CloseIcon />
    </div>
    <div class="row" v-if="step === 'initial'">
      <h2 class="w700 poppins t-33" style="margin-bottom: 17px">Add Payment</h2>
      <div class="row w-100 justify-content-around">
        <div class="pay-wrapper" @click="$emit('choosePaypal')">
          <div class="payment-card">
            <img :src="`${publicPath}paypal_icon.png`" alt="">
          </div>
          <p>Paypal Account</p>
        </div>
        <div class="pay-wrapper" @click="step = 'cc'">
          <div class="payment-card">
            <img :src="`${publicPath}CreditCard.png`" alt="">
          </div>
          <p>Credit / Debit Card</p>
        </div>
      </div>
    </div>
    <div class="w-100 px-4" v-else-if="step === 'cc'">
      <h4 class="mt-2 mb-5 t-33 text-center">Add a debit or credit card</h4>
      <div class="row">
        <div class="col-12">
          <div class="form-group">
            <label>Name on card:</label>
            <div class="input-group mb-0">
              <input ref="cardNameInput" :data-error="(cardErrors.cardName) ? true : false" v-model="cardName"
                     class="form-control" placeholder="Add complete name">
            </div>
            <div v-if="cardErrors.cardName" class="error">
              <small>{{ cardErrors.cardName }}</small>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="form-group">
            <label>Card Number:</label>
            <div class="input-group mb-0">
              <input ref="cardNumInput" :data-error="(cardErrors.cardNumber)?true:false" v-model="cardNumber" type="tel"
                     class="form-control" placeholder="0000 - 0000 - 0000 - 0000" v-cardformat:formatCardNumber>
              <div class="input-group-append">
            <span class="input-group-text" id="basic-addon1">
              <Visa v-show="cardBrandIcon === 'visa'" />
              <Amex v-show="cardBrandIcon === 'amex'" />
              <CreditCard v-show="cardBrandIcon === 'unknown'" />
              <DinersClub v-show="cardBrandIcon === 'dinersclub'" />
              <Discover v-show="cardBrandIcon === 'discover'" />
              <Jcb v-show="cardBrandIcon === 'jcb'" />
              <MasterCard v-show="cardBrandIcon === 'mastercard'" />
            </span>
              </div>
            </div>
            <div v-if="cardErrors.cardNumber" class="error">
              <small>{{ cardErrors.cardNumber }}</small>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-4">
          <div class="form-group">
            <label>Card Expiration:</label>
            <input ref="cardExpInput" id="card-exp" :data-error="(cardErrors.cardExpiry)?true:false"
                   v-model="cardExpiry" maxlength="10" class="form-control mb-1" v-cardformat:formatCardExpiry
                   placeholder="00/00">
            <div v-if="cardErrors.cardExpiry" class="error">
              <small>{{ cardErrors.cardExpiry }}</small>
            </div>
          </div>
        </div>
        <div class="col-8 pl-4">
          <div class="form-group">
            <label>Card CVC:</label>
            <input ref="cardCvcInput" :data-error="(cardErrors.cardCvc)?true:false" v-model="cardCvc"
                   class="form-control mb-1" v-cardformat:formatCardCVC placeholder="123">
            <div v-if="cardErrors.cardCvc" class="error">
              <small>{{ cardErrors.cardCvc }}</small>
            </div>
          </div>
        </div>
      </div>
      <div class="row justify-content-end align-items-center my-3">
        <button class="cancel-btn" @click="$modal.hide('payment-dialog')">Cancel</button>
        <button class="pay-btn" @click="payWithCC">Pay</button>
      </div>
    </div>
  </modal>
</template>

<script>
import CloseIcon from "../icons/CloseIcon.vue";
import VueCardFormat from "vue-credit-card-validation";
import Visa from "./icons/Visa";
import MasterCard from "./icons/MasterCard";
import Jcb from "./icons/Jcb";
import DinersClub from "./icons/DinersClub";
import CreditCard from "./icons/CreditCard";
import Discover from "./icons/Discover";
import Amex from "./icons/Amex";
import Vue from "vue";

Vue.use(VueCardFormat);
export default {
  name: "AddPaymentModal",
  data() {
    return {
      payment: null,
      publicPath: local_image_path,
      cardName: null,
      cardNumber: null,
      cardExpiry: null,
      cardCvc: null,
      cardPostal: null,
      cardErrors: {},
      // declaring card-brand in data{} enables card brand name/classes.
      cardBrand: null,
      brand: null,
      step: "initial"
    };
  },
  components: {
    CloseIcon,
    Visa,
    Amex,
    CreditCard,
    DinersClub,
    Discover,
    Jcb,
    MasterCard
  },
  methods: {
    close_modal() {
      this.$modal.hide("add-payment-dialog");
    },
    payWithCC() {
      if (!this.validate()) {
        return;
      }
      this.$emit("payWithCC", this.cardName, this.cardNumber, this.cardExpiry, this.cardCvc);
    },
    reset: function() {
      this.cardErrors = {};
      this.cardName = null;
      this.cardNumber = null;
      this.cardExpiry = null;
      this.cardCvc = null;
      this.cardPostal = null;
      this.$refs.cardNumInput.focus();
    },
    getBrand: function(brand) {
      return brand || "unknown";
    },
    onClose() {
      this.step = "initial";
      this.payment = null;
      this.cardName = null;
      this.cardNumber = null;
      this.cardExpiry = null;
      this.cardCvc = null;
      this.cardPostal = null;
      this.cardErrors = {};
      this.cardBrand = null;
      this.brand = null;
    },
    validate: function() {
      // init
      this.cardErrors = {};
      let passCard = true;

      // validate card name
      if (this.cardName == "") {
        this.cardErrors.cardName = "Invalid Credit Card Name.";
        passCard = false;
      }

      // validate card number
      if (!this.$cardFormat.validateCardNumber(this.cardNumber)) {
        this.cardErrors.cardNumber = "Invalid Credit Card Number.";
        passCard = false;
      }

      // validate card expiry
      if (!this.$cardFormat.validateCardExpiry(this.cardExpiry)) {
        this.cardErrors.cardExpiry = "Invalid Expiration Date.";
        passCard = false;
      }

      // validate card CVC
      if (!this.$cardFormat.validateCardCVC(this.cardCvc)) {
        this.cardErrors.cardCvc = "Invalid CVC.";
        passCard = false;
      }
      return passCard;
    }
  },
  watch: {
    cardNumber: function(val) {
      if (this.$cardFormat.validateCardNumber(val)) {
        this.$refs.cardExpInput.focus();
      }
    },
    cardExpiry: function(val) {
      if (this.$cardFormat.validateCardExpiry(val)) {
        this.$refs.cardCvcInput.focus();
      }
    }
  },
  computed: {
    cardBrandIcon() {
      return this.getBrand(this.cardBrand);
    }
  }
};
</script>

<style lang="scss" scoped>
.pay-btn {
  background: #F2A91C;
  border-radius: 15px;
  height: 80px;
  font-size: 24px;
  color: #000000;
  width: 280px;
  font-weight: 500;
  border: none;

  &:hover {
    filter: brightness(1.2);
  }
}

.error {
  color: red;
}

.cancel-btn {
  height: 56px;
  width: 120px;
  margin-right: 40px;
  font-size: 24px;
  background: transparent;
  border: none;
  font-weight: 500;
  border-radius: 5px;

  &:hover {
    background: #DDE2F3;
  }

}

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
  color: #170F49;
  font-weight: 700;
}

input {
  margin-bottom: 20px;
  width: 100%;
  height: 66px;
  background: #E5E5E5;
  border-radius: 5px;
  font-size: 22px;
  padding: 0 17px;
  color: #170F49;

  &:focus {
    background: #DDE2F3;
  }

  &:hover {
    background: #DDE2F3;
  }

  &::placeholder {
    font-size: 22px;
    font-weight: 500;
    color: #AFAFAF;
  }

  border: none;
}

.modal-close {
  padding: 0 !important;
  top: 31px !important;
  right: 31px !important;
}

.row {
  margin-top: 10px;
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


