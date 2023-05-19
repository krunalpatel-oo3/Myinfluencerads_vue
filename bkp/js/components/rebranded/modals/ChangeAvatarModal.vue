<template>
  <modal
    name="change-avatar-dialog"
    :width="824"
    height="auto"
    :scrollable="true"
    :adaptive="true"
    transition=""
    class="section-modal section-modal-archive change-img-modal"
  >
    <div class="modal-close" @click="$modal.hide('change-avatar-dialog')">
      <CloseIcon />
    </div>
    <div class="row">
      <h2 class="w700 poppins t-33 title-modal">Change Avatar</h2>
      <div v-for="(nextFile, index) in imageFiles" :key="nextFile.name" class="pop-modal-body">
        <div class="item-img" style="position: relative">
          <button @click="deleteImage(index)" class="btn img-delete-btn">
            <ImageCloseIcon />
          </button>
          <cropper
            ref="cropper"
            class="cropper"
            :src="nextFile.blob"
            stencil-component="circle-stencil"
            :stencil-props="{
              aspectRatio: 10 / 12
            }"
            @change="onChange"
          ></cropper>
        </div>
        <!--        <div class="item-img" style="position: relative">-->
        <!--          <img :src="nextFile.blob" alt="" style="min-width: 100px"/>-->

        <!--        </div>-->
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
              :drop="imageFiles.length < max_upload_files"
              :drop-directory="imageFiles.length < max_upload_files"
              @input-file="inputFile"
              @input-filter="inputFilter"
              >browse
            </file-upload>
          </div>
        </div>
        <div class="btns">
          <button @click="upload_profile_image" :disabled="submitting" class="btn btn-primary roboto">
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

const VueUploadComponent = require("vue-upload-component");
import ImageCloseIcon from "../icons/ImageCloseIcon";
import Vue from "vue";
import "vue-advanced-cropper/dist/style.css";
import { Cropper } from "vue-advanced-cropper";

Vue.component("file-upload", VueUploadComponent);
export default {
  name: "ChangeAvatarModal",
  props: ["userProfile"],
  components: {
    Cropper,
    CloseIcon,
    ImageCloseIcon
  },
  data() {
    return {
      imageFiles: [],
      publicPath: local_image_path,
      max_upload_files: 1,
      dragActive: false,
      logged_user_id: null,
      cropped_img: null,
      submitting: false
    };
  },
  methods: {
    deleteImage(idx) {
      this.imageFiles.splice(idx, 1);
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
    onChange({ coordinates, canvas }) {
      this.cropped_img = canvas.toDataURL();
    },
    inputFilter(newFile, oldFile, prevent) {
      if (newFile && !oldFile) {
        if (!/\.(jpeg|jpe|jpg|gif|png|webp)$/i.test(newFile.name)) {
          return prevent();
        }
      }

      newFile.blob = "";
      let URL = window.URL || window.webkitURL;
      if (URL && URL.createObjectURL) {
        newFile.blob = URL.createObjectURL(newFile.file);
      }
    },
    async upload_profile_image() {
      this.submitting = true;
      const formData = new FormData();
      formData.append("user_id", localStorage.logged_user_id);
      let Blob;
      const { canvas } = this.$refs.cropper[0].getResult();
      if (canvas) {
        canvas.toBlob((blob) => {
          Blob = new File([blob], "avatar.jpg", { type: "image/jpeg" });
          formData.append("profilephoto", Blob);
          var token = "";
          if (localStorage.sgtoken != null) {
            token = localStorage.sgtoken;
          }
          const headers = {
            "Content-Type": "multipart/form-data",
            Authorization: `Bearer ${token}`
          };

          axios
            .post(window.api_path + "profile/imageupdate", formData, {
              headers
            })
            .then((res) => {
              let self = this;
              console.log(res);
              if (res.data.code == 1) {
                self.$toast.success(res.data.data);
                this.$modal.hide("change-avatar-dialog");
                this.$emit("update-image", res.data.data);
              } else {
                this.$toast.error(res.data.message);
              }
              this.submitting = false;
            });
        }, "image/jpeg");
      }
    }
  },
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
      background: #f2a91c;
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
      background: #e6e6e6;
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
  background: #e6e6e6;
  padding: 0;
  position: absolute;
  top: -13px;
  right: -13px;
  z-index: 10;
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
