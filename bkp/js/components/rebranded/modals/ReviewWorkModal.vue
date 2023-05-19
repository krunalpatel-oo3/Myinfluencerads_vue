<template>
  <modal
    name="review-work-dialog"
    :width="824"
    height="auto"
    :scrollable="true"
    :adaptive="true"
    transition=""
    class="section-modal section-modal-archive"
  >
    <div
      class="modal-close"
      @click="$modal.hide('review-work-dialog')"
    >
      <CloseIcon />
    </div>
    <div class="row">
      <h2 class="w700 poppins t-33 w-100" style="margin-bottom: 17px">Review submitted work</h2>
      <div class="col-12">
        <p class="t-22 w500 mb-2">Name: <span class="w400">Stream to youtube</span></p>
        <p class="t-22 w500 mb-0">Description:</p>
        <p class="t-19 w400 mb-2">Lorem Ipsum dolor sit amet agna finibus risus. Lorem Ipsum dolor sit amet agna finibus risus. Lorem Ipsum dolor sit amet agna finibus risus</p>
        <p class="t-22 w500 mb-2">Amount: <span class="w400">$1,500</span></p>
        <p class="t-22 w500 mb-4">Due Date: <span class="w400">Nov 19th, 2021</span></p>
        <p class="t-22 w500">Attachments</p>
        <div class="row mx-0 mt-0 justify-content-start">
          <div class="attachment">
            <a href="">
              <AttachmentIcon />
              <span>File Name.ppt</span>
            </a>
          </div>
          <div class="attachment">
            <a href="">
              <AttachmentIcon />
              <span>File Name.ppt</span>
            </a>
          </div>
        </div>
        <div class="btns mb-2">
          <button class="btn btn-primary roboto">Request Changes</button>
        </div>
      </div>
    </div>

  </modal>
</template>

<script>
import CloseIcon from "../icons/CloseIcon.vue";
import AttachmentIcon from "../icons/AttachmentIcon";

export default {
  name: "ReviewWorkModal",
  components: {
    CloseIcon,
    AttachmentIcon
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
.attachment {
  margin-right: 25px;
  a {
    color: black;
    span {
      margin-left: 5px;
    }
  }
}
</style>
