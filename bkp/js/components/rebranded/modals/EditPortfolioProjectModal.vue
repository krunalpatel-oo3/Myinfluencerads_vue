<template>
  <modal
    name="edit-portfolio-dialog"
    :width="824"
    height="auto"
    :scrollable="true"
    :adaptive="true"
    transition=""
    class="section-modal edit-portfolio-modal"
  >
    <div class="modal-close" @click="$modal.hide('edit-portfolio-dialog')">
      <CloseIcon />
    </div>
    <div class="row">
      <h2 class="w700 poppins t-33" style="margin-bottom: 17px">
        Edit Project Description
        {{portfolio}}
      </h2>
      <div class="col-12">
        <label>Title</label>
        <input type="text" v-model="portfolio.title" placeholder="Add Title" />
        <label>Description</label>
        <textarea type="text" v-model="portfolio.description" placeholder="Description" />
        <label>Gallery</label>

        <div class="row mx-0 justify-content-start"
          style="margin-bottom: 20px"
        >
        <div v-for="(gallery_image, index) in portfolio.gallery_images" :key="gallery_image.image">
                    <div class="item-img" style="position: relative">
                      <img :src="gallery_image.image_url" alt="" class="rounded"  style="width: 104px; height: 104px;"/>
                      <button @click="deleteImagePortfolio(gallery_image.id,index)" class="btn img-delete-btn">
                        <ImageCloseIcon />
                      </button>
                    </div>
                  </div>
        </div>

        <div
          v-if="imageFiles.length"
          class="row mx-0 justify-content-start"
          style="margin-bottom: 20px"
        >

          <div v-for="(nextFile, index) in imageFiles" :key="nextFile.name">
            <div class="item-img" style="position: relative">
              <img :src="nextFile.blob" alt="" class="rounded"  style="width: 104px; height: 104px;"/>
              <button @click="deleteImage(index)" class="btn img-delete-btn">
                <ImageCloseIcon />
              </button>
            </div>
          </div>
        </div>
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
              :multiple="true"
              @input-filter="inputFilter"
              >browse</file-upload
            >
          </div>
        </div>
        <label>Skills</label>
        <!-- <vue-tags-input
          class="tag-input"
          v-model="productFilterValue"
          :tags="selectedProducts"
          :autocomplete-items="filteredProductItems"
          :add-only-from-autocomplete="true"
          placeholder="Add..."
          @tags-changed="updateVueProductsInput"
        /> -->
        <vue-tags-input
          class="tag-input"
          v-model="productFilterValue"
          :tags="portfolio.skills"
          :autocomplete-items="filteredProductItems"
          :add-only-from-autocomplete="true"
          placeholder="Add..."
          @tags-changed="updateVueProductsInput"
        />
        <div class="row mx-0">
          <div class="col-6 px-0">
            <label>From</label>
            <input v-model="portfolio.start_date" type="date" placeholder="From" />
          </div>
          <div class="col-6 pl-3">
            <label>To</label>
            <input
              type="date"
              v-model="portfolio.end_date"
              placeholder="To (or expected year)"
            />
          </div>
        </div>
      </div>
      <div class="btns">
        <button @click="edit_portfolio" class="btn btn-primary roboto">
          Submit
        </button>
      </div>
    </div>
  </modal>
</template>

<script>
import CloseIcon from "../icons/CloseIcon.vue";
import ImageCloseIcon from "../icons/ImageCloseIcon";
import VueTagsInput from "@johmun/vue-tags-input";
import Vue from "vue";

const VueUploadComponent = require("vue-upload-component");
Vue.component("file-upload", VueUploadComponent);

export default {
  name: "EditPortfolioProjectModal",
  props: ["portfolio"],
  data() {
    return {
      imageFiles: [],
      publicPath: local_image_path,
      max_upload_files: 5,
      dragActive: false,
      title: "",
      description: "",
      start_date: "",
      end_date: "",
      selectedTags: [],
      productFilterValue: "",
      selectedProducts: [

      ],
      autocompleteTagItems: [
        {
          text: "OBS Setup"
        },
        {
          text: "Tech Support"
        },
        {
          text: "Twitch Channel Setup"
        }
      ],
      autocompleteProductItems: []
    };
  },
  components: {
    CloseIcon,
    ImageCloseIcon,
    VueTagsInput
  },
  mounted() {
    this.loadSkillList();
    this.title = this.portfolio ? this.portfolio.title : '';
    this.description = this.portfolio ? this.portfolio.description : '';
    this.start_date = this.portfolio ? this.portfolio.start_date : '';
    this.end_date = this.portfolio ? this.portfolio.end_date : '';
    //this.title = portfolio.title;
  },
  computed: {
    filteredProductItems() {
      console.log(this.autocompleteProductItems);
      return this.autocompleteProductItems.filter((i) => {
        return (
          i.text
            .toLowerCase()
            .indexOf(this.productFilterValue.toLowerCase()) !== -1
        );
      });
    }
  },
  methods: {

    async deleteImagePortfolio(id,index) {
      this.portfolio.gallery_images.splice(index, 1);

      const result = await this.callApi(
        "post",
        window.api_path + "DeletePortfolioImage",
        {
          id: id
        }
      );

      if (result.status != 200) {
        this.$toast.error(result.data.message);
        return;
      }
      //this.loadProjectData();
      this.$toast.success("file was deleted successfully");
    },
    async loadSkillList() {
      const result = await this.callApi(
        "post",
        window.api_path + "getSkillList",
        { mode: "selection" }
      );
      if (result.status != 200) {
        this.$toast.error(result.data.message);
        this.skills = [];
        return;
      }
      this.autocompleteProductItems = result.data.skills;
    },
    dragEnter() {
      this.dragActive = true;
    },
    dragLeave() {
      this.dragActive = false;
    },
    inputFile(newFile, oldFile) {
      console.log("input file");
      if (newFile && oldFile && !newFile.active && oldFile.active) {
        if (newFile.xhr) {
          console.log("status", newFile.xhr.status);
        }
      }
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
    deleteImage(idx) {
      this.imageFiles.splice(idx, 1);
    },
    updateVueProductsInput(newProducts) {
      console.log("updateVueProductsInput newProducts::");
      console.log(newProducts);
      this.portfolio.skills = newProducts;
    },
    async edit_portfolio() {
      // if (!this.isAuthenticated || !localStorage.getItem("logged_user_id")) {
      //   this.$toast.error("To publish project you need to login firstly !");
      //   return;
      // }

     // console.log(this.imageFiles[0].file);
      const formData = new FormData();
      formData.append("id", this.portfolio.id);
      formData.append("title", this.portfolio.title);
      formData.append("description", this.portfolio.description);
      formData.append("start_date", this.portfolio.start_date);
      formData.append("end_date", this.portfolio.end_date);
      formData.append("skill", JSON.stringify(this.portfolio.skills));

      formData.append("user_id", localStorage.logged_user_id);
      if(this.imageFiles[0]){
        formData.append('gallery_image[0]', this.imageFiles[0].file);
      }
       if(this.imageFiles[1]){
        formData.append('gallery_image[1]', this.imageFiles[1].file);
      }
       if(this.imageFiles[2]){
        formData.append('gallery_image[2]', this.imageFiles[2].file);
      }
       if(this.imageFiles[3]){
        formData.append('gallery_image[3]', this.imageFiles[3].file);
      }
       if(this.imageFiles[4]){
        formData.append('gallery_image[4]', this.imageFiles[4].file);
      }

      var token = "";
      if (localStorage.sgtoken != null) {
        token = localStorage.sgtoken;
      }
      const headers = {
        "Content-Type": "multipart/form-data",
        Authorization: `Bearer ${token}`
      };
      axios
        .post(window.api_path + "profile/updateportfolio", formData, { headers })
        .then((res) => {
          let self = this;
          if (res.data.code == 1 && res.data.data != "") {
            console.log(res.data);
            this.$emit("update-portfolio", res.data.data);
            this.$modal.hide('edit-portfolio-dialog');
             self.$toast.success(res.data.data);
          } else {
            this.$toast.error(res.data.data);
          }
        });
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

input,
textarea {
  margin-bottom: 20px;
  width: 100%;
  height: 73px;
  background: #e5e5e5;
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
  height: 100px;
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
}
</style>

