<template>
    <modal
      name="send-user-email-dialog"
      :width="824"
      height="auto"
      :scrollable="true"
      :adaptive="true"
      transition=""
      class="section-modal send-user-email-dialog"
    >
      <div
        class="modal-close"
        @click="$modal.hide('send-user-email-dialog')"
      >
        <CloseIcon />
      </div>
      <div class="row">
        <h2 class="w700 poppins t-33" style="margin-bottom: 17px">Send Mail</h2>
        <div class="col-12">
          <label>Subject</label>
          <input type="text" v-model="subject" ref="subject" placeholder="Enter subject">
          <label>Title</label>
          <input type="text" v-model="title" ref="title" placeholder="Enter title">
          <label>Description</label>
          <textarea cols="20" rows="6" v-model="description" ref="description" placeholder="Enter description"></textarea>
        </div>
        <div class="btns">
          <button @click="sendEmail" :disabled="submitting" class="btn roboto btn-hover">
            <div v-if="submitting" class="spinner-border" role="status">
              <span class="sr-only">Loading...</span>
            </div>
            Send
          </button>
        </div>
      </div>
    </modal>
  </template>
  
  <script>
  import CloseIcon from "../icons/CloseIcon.vue";
  
  export default {
    name: "SendUserEmailModal",
    props: ["useremail", "username", "submitting"],
    components: {
      CloseIcon
    },
    data () {
      return {
        title: "",
        subject: "",
        description: "",
        username: username,
        useremail: useremail,
      };
    },
    methods: {
      async sendEmail() {
        if (!this.title) {
          this.$toast.error("Title is required!");
          this.$refs.title.focus()
          return;
        }
        if (!this.subject) {
          this.$toast.error("Subject is required!");
          this.$refs.subject.focus()
          return;
        }
        if (!this.description) {
          this.$toast.error("Description is required!");
          this.$refs.description.focus()
          return;
        }
        this.submitting = true;
        const result = await this.callApi(
          "post",
          window.api_path + "sendMailUser",
          {
            title: this.title,
            subject: this.subject,
            description: this.description,
            username: this.username,
            useremail: this.useremail,
          }
        );
        
        if (result.data.status) {
          this.title = "";
          this.subject = "";
          this.description = "";
          this.$toast.success(result.data.message);
          this.$modal.hide('send-user-email-dialog');
        }else{
          this.$toast.error('Something went wrong while sending mail!');
        }
        this.submitting = false;
      }
    }
  };
  </script>
  
  <style lang="scss" scoped>
    label {
      font-size: 26px;
      line-height: 30px;
      color: #000000;
      font-weight: 700;
    }
    
    input, textarea {
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
    
    textarea {
      padding: 20px;
      height: 150px;
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
    