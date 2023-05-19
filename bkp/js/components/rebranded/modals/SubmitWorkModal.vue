<template>
  <modal
    name="submit-work-dialog"
    :width="824"
    height="auto"
    :scrollable="true"
    :adaptive="true"
    transition=""
    class="section-modal section-modal-archive"
  >
    <div
      class="modal-close"
      @click="$modal.hide('submit-work-dialog')"
    >
      <CloseIcon />
    </div>
    <div class="row">
      <h2 class="w700 poppins t-33">Submit For Review</h2>
      <div class="form-group">
                <textarea
                  class="form-control roboto"
                  placeholder="Add milestone description"
                ></textarea>
        <h3 class="t-28 w700 poppins" style="line-height: 42px; margin-top: 15px">Attachments</h3>
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
            Drag and drop or
            <file-upload
              ref="upload"
              v-model="imageFiles"
              post-action="/post.method"
              put-action="/put.method"
              @input-file="inputFile"
              :multiple="true"
              @input-filter="inputFilter"
            >browse files</file-upload
            >
          </div>
        </div>
        <div class="row mx-0 justify-content-start">
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
        <div class="btns">
          <button class="btn btn-primary roboto">Submit</button>
        </div>
      </div>
    </div>

  </modal>
</template>

<script>
import AttachmentIcon from "../icons/AttachmentIcon";
import CloseIcon from "../icons/CloseIcon.vue";
import Vue from "vue";
import { bus } from "../../../app";
const VueUploadComponent = require("vue-upload-component");
Vue.component("file-upload", VueUploadComponent);
export default {
  name: "SubmitWorkModal",
  components: {
    CloseIcon,
    AttachmentIcon
  },
  data () {
    return {
      max_upload_files: 5,
      isAuthenticated: window.isAuthenticated,
      publicPath: local_image_path,
      dragActive: false,
      logged_user_id: null,
      categorySelectionItems: [
        "Category 1",
        "Category 2",
        "Category 3",
        "Something 1",
        "Something 2"
      ],
      selection_category_id: null,

      platformSelectionItems: ["Item 1", "Item 2", "Item 3", "Item 4"],
      selection_platform_id: null,

      imageFiles: [],
      selectedCoverImage: "",

      pdfFiles: [],
      productFilterValue: "",
      project_title: "",
      project_subtitle: "",
      tagFilterValue: "",
      selectedTags: [],
      selectedProducts: [
        {
          text: "CSS"
        },
        {
          text: "Website Design"
        }
      ],
      autocompleteTagItems: [
        {
          text: "MySQL Administration"
        },
        {
          text: "API Integration"
        },
        {
          text: "MongoDB"
        }
      ],
      autocompleteProductItems: [
        {
          text: "Website Design"
        },
        {
          text: "PSD to HTML"
        },
        {
          text: "CSS"
        },
        {
          text: "MySQL"
        },
        {
          text: "Javascript"
        }
      ]
    }
  },
  watch: {
    imageFiles(theFile) {
      console.log("watch theFile::");
      console.log(theFile);

      if (typeof theFile[0] === "undefined") return;

      console.log("watch +++theFile::");
      console.log(theFile);
      let image = new Image();

      image.src = theFile[0].blob;
      console.log("watch image::");
      console.log(image);
      image.onload = function() {
        console.log("imageUploadedEvent this::");
        console.log(this);
        bus.$emit("imageUploadedEvent", this.width, this.height);
      };
    }
  },
  methods: {
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
    inputFile(newFile, oldFile) {
      if (newFile && oldFile && !newFile.active && oldFile.active) {
        if (newFile.xhr) {
          console.log("status", newFile.xhr.status);
        }
      }
    },
    dragEnter() {
      this.dragActive = true;
    },
    dragLeave() {
      this.dragActive = false;
    },
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
.custom-file {
  width: 164px;
  transition: .2s;
  cursor: pointer;
  &:hover {
    .custom-file-label::after {
      background: #eee;
    }
  }
}
.custom-file-label::after {
  border: none;
  width: 100%;
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  z-index: 3;
  height: 49px;
  font-size: 24px;
  line-height: 28px;
  paddin-top: 2px !important;
  text-align: center;
  color: #000;
  content: "Add" !important;
  background: #e9ecef;
  border-left: inherit;
  border-radius: 0 0.25rem 0.25rem 0;
  cursor: pointer;
  transition: .2s;
  &:hover {
    background: #eee;
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
