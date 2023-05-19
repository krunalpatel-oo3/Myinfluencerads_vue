<template>
  <modal
    name="send-proposal-dialog"
    :width="794"
    height="auto"
    :scrollable="true"
    :adaptive="true"
    transition=""
    class="section-modal section-modal-archive"
  >
    <div
      class="modal-close"
      @click="$modal.hide('send-proposal-dialog')"
    >
      <CloseIcon />
    </div>
    <div class="row">
      <h2 class="w700 poppins t-33 w-100" style="margin-bottom: 17px">Send Proposal</h2>
      <div class="col-12">
        <p class="w700 t-27 mb-1 mt-2">Cover letter</p>
        <textarea placeholder="Add cover letter"/>
        <div v-if="payment === 'hourly'">
          <p class="w700 t-27 mb-1 mt-2">Hourly Rate</p>
          <input placeholder="$0.00">
        </div>
        <div v-else>
          <p class="w700 t-27 mb-1 mt-2">Project Price</p>
          <input placeholder="$1000">
        </div>

        <div
          v-show="pdfFiles.length < max_upload_files"
          class="projectadd-media-add"
          :class="
                    $refs.upload && $refs.upload.dropActive && dragActive
                      ? 'active'
                      : ''
                  "
          @dragenter="dragEnter"
          @dragleave="dragLeave"
          style="margin-top: 30px"
        >
          <div class="add-text">
            Drag or
            <file-upload
              input-id="img-file"
              ref="upload"
              v-model="pdfFiles"
              post-action="/post.method"
              put-action="/put.method"
              @input-file="inputFile"
              :multiple="true"
              @input-filter="inputFilter"
            >browse </file-upload
            > documents in PDF
          </div>
        </div>
        <div v-if="pdfFiles.length" class="row mx-0 justify-content-start">
          <div v-for="pdf in pdfFiles" :key="pdf.name" class="attachment">
            <a class="link-hover">
              <AttachmentIcon style="margin-right: 8px;" />
              <span>{{ pdf.name}}</span>
            </a>
          </div>
        </div>
        <div class="btns mb-2">
          <button class="btn btn-primary roboto">Submit</button>
        </div>
      </div>
    </div>
  </modal>
</template>

<script>
import CloseIcon from "../icons/CloseIcon.vue";
import Vue from "vue";
const VueUploadComponent = require("vue-upload-component");
import AttachmentIcon from "../icons/AttachmentIcon";

Vue.component("file-upload", VueUploadComponent);

export default {
  name: "SendProposalModal",
  components: {
    CloseIcon,
    AttachmentIcon
  },
  data () {
    return {
      publicPath: local_image_path,
      max_upload_files: 5,
      dragActive: false,
      pdfFiles: [],
      payment: null
    }
  },
  methods: {
    dragEnter() {
      this.dragActive = true;
    },
    dragLeave() {
      this.dragActive = false;
    },
    inputFile(newFile, oldFile) {
      console.log('input file')
      if (newFile && oldFile && !newFile.active && oldFile.active) {
        if (newFile.xhr) {
          console.log("status", newFile.xhr.status);
        }
      }
    },

    inputFilter(newFile, oldFile, prevent) {
      if (newFile && !oldFile) {
        if (!/\.(pdf)$/i.test(newFile.name)) {
          return prevent();
        }
      }

      newFile.blob = "";
      let URL = window.URL || window.webkitURL;
      if (URL && URL.createObjectURL) {
        newFile.blob = URL.createObjectURL(newFile.file);
      }
    },
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
  height: 70px;
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
