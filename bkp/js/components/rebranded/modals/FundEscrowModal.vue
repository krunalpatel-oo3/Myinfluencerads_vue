<template>
  <modal
    name="fund-escrow-dialog"
    :width="691"
    height="auto"
    :scrollable="true"
    :adaptive="true"
    transition=""
    class="section-modal section-modal-archive"
  >
    <div
      class="modal-close"
      @click="$modal.hide('fund-escrow-dialog')"
    >
      <CloseIcon />
    </div>
    <div class="row">
      <h2 class="w700 poppins t-33" style="margin-bottom: 17px">Fund Escrow</h2>
      <p class="t-18 w-100 text-center" style="color: #CF3C3C">You must fund escrow for the first week.</p>
      <div class="col-12">
        <p class="t-22 w500">Hourly rate: <span class="w400">$22</span></p>
        <p class="t-22 w500">Weekly limit: <span class="w400">30 hours</span></p>
        <p class="t-22 w500">Total amount to fund: <span class="w400">$660</span></p>
      </div>
      <div class="row w-100 justify-content-center mt-2 btns mb-2">
        <router-link :to="{ name: 'Rebranded Payment Page' }" class="btn btn-fund">Fund</router-link>
      </div>
    </div>
  </modal>
</template>

<script>
import CloseIcon from "../icons/CloseIcon.vue";

export default {
  name: "FundEscrowModal",
  components: {
    CloseIcon
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
    margin-top: 44px;
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
      padding-top: 24px;
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

