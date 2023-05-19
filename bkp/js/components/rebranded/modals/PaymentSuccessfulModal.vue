<template>
  <modal
    name="payment-success-dialog"
    :width="824"
    height="auto"
    :scrollable="true"
    :adaptive="true"
    transition=""
    class="section-modal section-modal-archive"
  >
    <div
      class="modal-close"
      @click="$modal.hide('payment-success-dialog')"
    >
      <CloseIcon />
    </div>
    <div class="row">
      <PaymentSuccessIcon />
      <h2 class="w700 t-33" style="margin-top: 10px; color: rgba(37, 159, 70, 0.87)">Payment Successful</h2>
      <p class="t-24" style="color: #333333">Thank you! Your payment is complete</p>
      <div class="btns">
        <button class="btn btn-primary roboto btn-hover">Go back to Project</button>
      </div>
    </div>
  </modal>
</template>

<script>
import CloseIcon from "../icons/CloseIcon.vue";
import PaymentSuccessIcon from "../icons/PaymentSuccessIcon";

export default {
  name: "PaymentSuccessModal",
  components: {
    CloseIcon,
    PaymentSuccessIcon
  }
};
</script>

<style lang="scss" scoped>
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
    margin-top: 25px;
    margin-bottom: 10px;
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

  .form-group {
    width: 100%;

    textarea {
      background: #E6E6E6;
      border-radius: 5px;
      height: 194px;
      font-size: 24px;
      line-height: 28px;

      &::placeholder {
        color: #333333;
      }
    }
  }
}
</style>

