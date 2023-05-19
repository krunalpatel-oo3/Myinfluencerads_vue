<template>
  <modal
    name="change-cover-dialog"
    :width="824"
    height="auto"
    :scrollable="true"
    :adaptive="true"
    transition=""
    class="section-modal section-modal-archive change-img-modal"
  >
    <div
      class="modal-close"
      @click="$modal.hide('change-cover-dialog')"
    >
      <CloseIcon />
    </div>
    <div class="row">
      <h2 class="w700 poppins t-33 title-modal">Change Cover Image</h2>
      <div
        v-for="(nextFile, index) in imageFiles"
        :key="nextFile.name"
        class="pop-modal-body"
      >
        <div class="item-img" style="position: relative">
          <img :src="nextFile.blob" alt="" style="min-width: 100px"/>
          <button @click="deleteImage(index)" class="btn img-delete-btn">
            <ImageCloseIcon />
          </button>
        </div>
      </div>
      <div class="form-group">
        <div
          v-show="imageFiles.length < max_upload_files"
          class="projectadd-media-add"
          :class="
                    $refs.upload && $refs.upload.dropActive && dragActive
                      ? 'active'
                      : ''
                  "
          @dragenter="dragEnter"
          @dragleave="dragLeave"
        >
          <div class="add-text">
            Drag images here or
            <file-upload
              input-id="img-file"
              ref="upload"
              v-model="imageFiles"
              post-action="/post.method"
              put-action="/put.method"
              @input-file="inputFile"
              :drop="imageFiles.length < max_upload_files"
              @input-filter="inputFilter"
            >browse</file-upload
            >
          </div>
        </div>
        <div class="btns pop-btns">
          <button @click="upload_cover_image" :disabled="submitting" class="btn btn-primary roboto">
            <div v-if="submitting" class="spinner-border" role="status">
              <span class="sr-only">Loading...</span>
            </div>
            Submit
          </button>
        </div>
      </div>
    </div>
  </modal>
</template>

<script>
import CloseIcon from "../icons/CloseIcon.vue";
import Vue from "vue";
const VueUploadComponent = require("vue-upload-component");
import ImageCloseIcon from "../icons/ImageCloseIcon";

Vue.component("file-upload", VueUploadComponent);
export default {
  name: "ChangeAvatarModal",
  components: {
    CloseIcon,
    ImageCloseIcon
  },
  data () {
    return {
      imageFiles: [],
      publicPath: local_image_path,
      max_upload_files: 1,
      dragActive: false,
      logged_user_id: null,
      submitting: false,
    }
  },
  methods: {
    onChange() {
      this.imageFiles = [...this.$refs.upload.files];
    },
    dragover(event) {
      event.preventDefault();
    },
    drop (e){
      e.preventDefault();
      this.imageFiles = e.dataTransfer.files;
    },
    deleteImage (idx) {
      this.imageFiles.splice(idx, 1)
    },
    dragEnter() {
      this.dragActive = true;
    },
    dragLeave() {
      this.dragActive = false;
    },
    inputFile(newFile, oldFile) {
      if (newFile && oldFile && !newFile.active && oldFile.active) {
        if (newFile.xhr) {
          console.log("status", newFile.xhr.status);
        }
      }
    },

    inputFilter(newFile, oldFile, prevent) {
      if (newFile && !oldFile) {
        if (!/\.(jpeg|jpe|jpg|gif|png|webp)$/i.test(newFile.name)) {
          this.$toast.error('Only jpeg, jpe, jpg, gif, png and webp files are allow!');
          return prevent();
        }
      }
      newFile.blob = "";
      let URL = window.URL || window.webkitURL;
      if (URL && URL.createObjectURL) {
        newFile.blob = URL.createObjectURL(newFile.file);
      }
    },
    async upload_cover_image() {
      this.submitting = true;
      const formData = new FormData();
      formData.append('user_id', localStorage.logged_user_id);
      formData.append('coverphoto', this.imageFiles[0].file);

      var token = "";
      if (localStorage.sgtoken != null) {
        token = localStorage.sgtoken;
      }
      const headers = { 'Content-Type': 'multipart/form-data',  Authorization: `Bearer ${token}` };

      axios.post(window.api_path + "profile/coverimageupdate", formData, { headers }).then((res) => {
          let self = this;
          if (res.data.code == 1 && res.data.data != '') {
            self.$toast.success(res.data.data);
            this.$modal.hide('change-cover-dialog');

            this.$emit('update-cover', res.data.data);
            this.imageFiles = [];

          }else{
            this.$toast.error(res.data.data);
          }
          this.submitting = false;
      });
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
    margin-top: 30px;
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
.img-delete-btn {
  width: 35px;
  height: 35px;
  border-radius: 50%;
  background: #E6E6E6;
  padding: 0;
  position: absolute;
  top: -13px;
  right: -13px;
}

@media all and (max-width:1024px){
  .title-modal {
      font-size: 26px;
  }
  .pop-modal-body label {
      font-size: 20px;
  }
  .pop-modal-body input {
    height: auto;
    padding: 10px 15px;
    line-height: normal;
  }
  .pop-modal-body input::-webkit-input-placeholder{
      font-size:16px !important;
  }
  .pop-modal-body input::-moz-placeholder{
      font-size:16px !important;
  }
  .pop-modal-body input:-ms-input-placeholder{
      font-size:16px !important;
  }
  .pop-modal-body input::-ms-input-placeholder{
      font-size:16px !important;
  }
  .pop-modal-body input::placeholder{
      font-size:16px !important;
  }
  .pop-btns .btn {
    height: auto !important;
    padding: 10px 15px !important;
    width: 100% !important;
    max-width: 170px !important;
    font-size: 18px !important;
  }
}

@media all and (max-width:767px){
  .modal-close {
    top: 20px !important;
    right: 20px !important;
  }
  .modal-close svg {
    width: 30px;
    height: 30px;
  }
}

@media all and (max-width:575px){
  .title-modal{
    font-size: 22px;
    line-height:normal;
  }
}
</style>
