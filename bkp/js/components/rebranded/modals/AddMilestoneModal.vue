<template>
  <modal
    name="add-milestone-dialog"
    :width="824"
    height="auto"
    :scrollable="true"
    :adaptive="true"
    transition=""
    class="section-modal section-modal-archive"
  >
    <div
      class="modal-close"
      @click="$modal.hide('add-milestone-dialog')"
    >
      <CloseIcon />
    </div>
    <div class="row">
      <h2 class="w700 poppins t-33 w-100" style="margin-bottom: 17px">Add a milestone</h2>
      <div class="col-12">
        <p class="w700 t-18 mb-1">Name</p>
        <input type="text" placeholder="Name of the milestone">
        <p class="w700 t-18 mb-1 mt-2">Description</p>
        <textarea placeholder="Add description"/>
        <p class="w700 t-18 mb-1 mt-2">Due Date</p>
        <input type="date" placeholder="Name of the milestone">
        <p class="w700 t-18 mb-1 mt-2">Amount</p>
        <input type="number" placeholder="$0.00">
        <div class="btns mb-2">
          <button class="btn btn-primary roboto">Submit</button>
        </div>
      </div>
    </div>

  </modal>
</template>

<script>
import CloseIcon from "../icons/CloseIcon.vue";

export default {
  name: "AddMilestoneModal",
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
    }
  }
  h2 {
    width: 100%;
    text-align: center;
    line-height: 54px;
  }
}
input {
  &::placeholder {
    color: #333333;
  }
  height: 50px;
  width: 100%;
  background: #E5E5E5;
  border-radius: 5px;
  padding-left: 20px;
  font-size: 18px;
  color: #333333;
  border: none;
}
textarea {
  height: 140px;
  width: 100%;
  background: #E5E5E5;
  border-radius: 5px;
  padding-left: 20px;
  font-size: 18px;
  color: #333333;
  border: none;
  padding-top: 20px;
  &::placeholder {
    color: #333333;
  }
}
</style>
