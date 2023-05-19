<template>
    <modal
      name="delete-community-dialog"
      :width="824"
      height="auto"
      :scrollable="true"
      :adaptive="true"
      transition=""
      class="section-modal section-modal-archive"
    >
      <div
        class="modal-close"
        @click="$modal.hide('delete-community-dialog')"
      >
        <CloseIcon />
      </div>
      <div class="row">
        <div class="col-12">
          <p class="t-22 w500 mb-0 text-center">Are you sure to Delete <strong class="w700">{{ community_name }}</strong> community?</p>
        </div>
        <div class="row w-100 justify-content-center mt-4 btns mb-2 btn-delete-wrap">
          <button class="btn btn-fund" @click="deleteCommunity(community_id)">Yes</button>
          <button class="btn btn-fund mr-3" @click="$modal.hide('delete-community-dialog')">No</button>
        </div>
      </div>
    </modal>
  </template>
  
  <script>
  import CloseIcon from "../icons/CloseIcon.vue";
  
  export default {
    name: "DeleteCommunityModal",
    props: ["community_id", "community_name", "user"],
    components: {
      CloseIcon
    },
    methods: {
      async deleteCommunity (id) {
        const res = await this.callApi("post", window.api_path + "community/delete", {id})
        if (res.status !== 200) {
            this.$toast.error("Error occurred. Please try again")
            return
        }
        this.$toast.success(res.data.message)
        this.$modal.hide("delete-community-dialog")
        this.user.communities = this.user.communities.filter(e => e.id !== id)
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
  .btn-delete-wrap .btn{
    height: auto !important;
    padding: 25px 20px;
    min-height: unset !important;
    max-width: 284px !important;
    line-height: normal !important;
    width: 100% !important;
    margin-right: 50px !important;
  }
  </style>  