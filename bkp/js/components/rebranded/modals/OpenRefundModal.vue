<template>
  <modal
    name="open-refund-dialog"
    :width="824"
    height="auto"
    :scrollable="true"
    :adaptive="true"
    transition=""
    class="section-modal section-modal-archive open-refund-modal"
  >
    <div
      class="modal-close"
      @click="$modal.hide('open-refund-dialog')"
    >
      <CloseIcon />
    </div>
    <div class="row">
      <h2 class="w700 poppins t-33" style="margin-bottom: 17px">Request a refund</h2>
      <div class="form-group">
        <h3 class="w700 t-28 poppins" style="margin-bottom: 5px">Reason</h3>
        <textarea
          class="form-control roboto"
          placeholder="Add reason for pausing"
          style="padding: 20px"
        ></textarea>
        <h3 class="w700 t-28 poppins mt-2 mb-0">Choose an invoice</h3>
        <v-select
          style="border: 2px solid #C3C5CC; border-radius: 8px"
          v-model="invoice"
          label="text"
          code="code"
          item-text="label"
          :options="invoices"
          :clearable="false"
          class="form-control v-select-light invoice-select"
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
                            </span> </template>
        <template #option="{ text, amount}">
          <li @click="invoice = text" class="v-select-option"><span>{{ text }}</span> <span class="ml-auto">{{ amount }}</span></li>
        </template>
        </v-select>
        <div class="btns">
          <button class="btn btn-primary roboto">Submit</button>
        </div>
      </div>
    </div>

  </modal>
</template>

<script>
import CloseIcon from "../icons/CloseIcon.vue";
import Vue from "vue";
import vSelect from "vue-select";
import IconBase from "../../common/IconBase.vue";
import IconAngleDown from "../../common/icons/IconAngleDown.vue";

Vue.component("v-select", vSelect);
import "vue-select/dist/vue-select.css";

export default {
  name: "OpenRefundModal",
  components: {
    CloseIcon,
    IconBase,
    IconAngleDown
  },
  data () {
    return {
      invoice: null,
      invoices: [
        { text: 'Invoice 1. Lorem Ipsum dolor sit amet.', amount: 'Amount: $1200' },
        { text: 'Invoice 2. Lorem Ipsum dolor sit amet.', amount: 'Amount: $1000' },
        { text: 'Invoice 3. Lorem Ipsum dolor sit amet.', amount: 'Amount: $1300' },
        { text: 'Invoice 4. Lorem Ipsum dolor sit amet.', amount: 'Amount: $1500' }
      ]
    }
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
.v-select-option {
  display: flex;
  span {
    font-size: 15px;
    line-height: 40px;
    color: #333333;
    padding: 7px 40px;
  }
}
</style>
