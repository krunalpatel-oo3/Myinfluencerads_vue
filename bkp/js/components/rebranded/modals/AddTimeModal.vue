<template>
  <modal
    name="add-time-dialog"
    :width="824"
    height="auto"
    :scrollable="true"
    :adaptive="true"
    transition=""
    class="section-modal section-modal-archive"
  >
    <div
      class="modal-close"
      @click="$modal.hide('add-time-dialog')"
    >
      <CloseIcon />
    </div>
    <div class="row row-main">
      <h2 class="w700 t-33">Add Time</h2>
      <div class="row w-100 align-items-center">
        <p class="t-24 t-color3 mb-0" style="line-height: 28px; margin-right: 22px">Date:</p>
        <select class="date-input">
          <option>Saturday, November 6, 2021</option>
          <option>Sunday, November 7, 2021</option>
          <option>Monday, November 8, 2021</option>
          <option>Saturday, November 6, 2021</option>
          <option>Tuesday, November 9, 2021</option>
        </select>
      </div>
      <div class="row w-100" style="margin-top: 50px">
        <div class="col-6" style="padding-right: 10px">
          <div class="row align-items-center" style="margin-right: 30px">
            <p class="t-24 t-color3 mb-0" style="line-height: 28px; margin-right: 22px">Start Time:</p>
            <input type="time" class="time-input">
          </div>
        </div>
        <div class="col-6">
          <div class="row align-items-center">
            <p class="t-24 t-color3 mb-0" style="line-height: 28px; margin-right: 22px">End Time:</p>
            <input type="time" class="time-input">
          </div>
      </div>
      <div class="form-group" style="margin-top: 42px">
                <textarea
                  class="form-control roboto"
                  placeholder="Add message"
                ></textarea>
        <div class="btns">
          <button class="btn btn-primary roboto">Submit</button>
        </div>
      </div>
    </div>
    </div>
  </modal>
</template>

<script>
import CloseIcon from "../icons/CloseIcon.vue";

export default {
  name: "AcceptOfferModal",
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
.date-input {
  width: calc(100% - 80px);
  height: 57px;
  background: #E6E6E6;
  border-radius: 5px;
  border: none;
  font-size: 24px;
  color: #333333;
  padding-left: 20px;
}
.time-input {
  background: #E6E6E6;
  border-radius: 5px;
  height: 57px;
  border: none;
  font-size: 24px;
  color: #333333;
  padding-left: 20px;
  padding-right: 10px;
}
.row-main {
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
</style>

