<template>
  <div>
    <Header/>
    <main class="main">
      <!-- Project Add -->
      <section class="section-systemadd">
        <div class="container">
          <FormulateForm
            @submit="publishCompany"
          >
          <div class="projectadd-container wblock">
            <header class="projectadd-header">
              <h1>New Integration Company</h1>
            </header>
            <div class="projectadd-row">
              <!-- Project Add Thumbnail -->
              <div class="projectadd-media">
                <div class="projectadd-media-heading">
                  <h2>Company thumbnail</h2>
                  <span class="projectadd-media-info"
                  >Up to {{ max_upload_files }}</span
                  >
                </div>
                <div class="projectadd-media-items">
                  <div
                    class="projectadd-media-item"
                    v-for="(nextFile, index) in imageFiles"
                    :key="nextFile.name"
                    v-if="nextFile.type != 'application/pdf'"
                  >
                    <div class="item-img">
                      <img :src="nextFile.blob" alt="" class="rounded"/>
                      <div class="btns">
                        <button
                          class="btn btn-white-icon-rounded"
                          @click="delete_image(key)"
                        >
                          <icon-base
                            width="12"
                            height="14.64"
                            view-box="0 0 12 14.64"
                            icon-name="trash"
                          >
                            <icon-trash/>
                          </icon-base>
                        </button>
                      </div>
                    </div>
                    <div class="item-caption">
                      <div class="form-group">
                        <input
                          type="text"
                          class="form-control"
                          placeholder="Enter caption"
                          v-model="nextFile.coverImageCaption"
                          v-bind:id="nextFile.name + '_caption'"
                        />
                      </div>
                    </div>
                    <div class="item-is-cover">
                      <div class="custom-radio-group">
                        <label class="custom-radio">
                          <input
                            type="radio"
                            :name="'project-is-cover-'+index"
                            v-model="selectedCoverImage"
                            :checked="0 == 0"
                            :value="index + 1"
                            v-bind:id="nextFile.name + '_ismain'"
                          />
                          <span>Cover Image</span>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- <div class="projectadd-media-items"> -->

                <div v-show="imageFiles.length >= max_upload_files">
                  <div class="">You reached maximum of files</div>
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
                    <div class="upload-icon">
                       <img :src="`${publicPath}upload.png`" alt="" />
                    </div>
                    <div class="upload-text">
                           Drag and Drop
                    </div>
                    or
                    <!-- <input type="file" @change="uploadFile" ref="file"> -->
                    <file-upload
                      ref="file"
                      v-model="imageFiles"
                      post-action="/post.method"
                      put-action="/put.method"
                      @input-file="inputFile"
                      :multiple="true"
                      @input-filter="inputFilter"
                    >browse
                    </file-upload>
                     your image to upload
                  </div>
                </div>

                <div class="form-group project-video-add">
                  <label>Add Youtube Video Link</label>
                  <input
                    type="text"
                    v-model="youtube_url"
                    placeholder="www.youtube.com/streamgeeks"
                    class="form-control"
                  />
                </div>
                <div class="project-video-item">
                  <iframe
                    :src="`https://www.youtube.com/embed/${getEmbed(
                      this.youtube_url
                    )}?controls=0`"
                    title="YouTube video player"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen
                  ></iframe>
                </div>
              </div>
              <!-- End of Project Add Thumbnail -->

              <!-- Project Add Content -->
              <div class="projectadd-content">
                <div class="projectadd-form">
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group">
                        <label>Company Name</label>
                        <FormulateInput
                          type="text"
                          input-class="form-control"
                          placeholder="Enter company name"
                          v-model="companyName"
                          validation="required"
                        />
                      </div>
                      <div class="form-group">
                        <label>Company Website</label>
                        <FormulateInput
                          type="text"
                          input-class="form-control"
                          placeholder="Enter company website"
                          v-model="companyWebsite"
                          validation="required"
                        />
                      </div>
                    </div>
                    <div class="col-6 pl-4">
                      <div class="form-group">
                        <label>Company Logo</label>
                        <div
                          v-if="!companyLogo.length"
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
                           <div class="upload-icon">
                              <img :src="`${publicPath}upload.png`" alt="" />
                            </div>
                            <div class="upload-text">
                                  Drag and Drop
                            </div>
                          or
                            <file-upload
                              ref="logoFile"
                              v-model="companyLogo"
                              post-action="/post.method"
                              put-action="/put.method"
                              :multiple="true"
                              input-id="logoFile"
                              @input-file="inputFile"
                              @input-filter="inputFilter"
                            >browse
                            </file-upload>
                            your image to upload
                          </div>
                        </div>
                        <div
                          v-else
                          v-for="(nextFile, index) in companyLogo"
                          :key="nextFile.name"
                          class="projectadd-media-item">
                          <div class="item-img">
                            <img :src="nextFile.blob" alt="" class="rounded"/>
                            <div class="btns">
                                  <button
                                    class="btn btn-white-icon-rounded"
                                    type="button"
                                    @click="
                                    deletePrimayImage(
                                      index
                                    )
                                  "
                                  >
                                    <icon-base
                                      width="12"
                                      height="14.64"
                                      view-box="0 0 12 14.64"
                                      icon-name="trash"
                                    >
                                      <icon-trash/>
                                    </icon-base>
                                  </button>
                                </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Associated Projects</label>
                    <vue-tags-input
                      v-model="projectFilterValue"
                      :tags="selectedProjects"
                      :autocomplete-items="filteredProjectItems"
                      :add-only-from-autocomplete="true"
                      placeholder="Add projects"
                      class="advanced-tag"
                    >
                      <template v-slot:autocomplete-item="props">
                        <div
                          @click="selectedProjects.push(props.item)"
                          style="padding: 10px 15px !important"
                        >
                          <p
                            style="
                              font-size: 14px;
                              margin-bottom: 3px;
                              color: black;
                            "
                          >
                            {{ props.item.text }}
                          </p>
                          <p
                            style="
                              color: rgba(0, 0, 0, 0.3);
                              line-height: 23px;
                              margin-bottom: 0;
                            "
                          >
                            {{ props.item.description }}
                          </p>
                        </div>
                      </template>
                    </vue-tags-input>
                  </div>
                  <div class="form-group">
                    <label>Associated Brands</label>
                    <vue-tags-input
                      v-model="brandFilterValue"
                      :tags="selectedBrands"
                      :autocomplete-items="filteredBrandItems"
                      :add-only-from-autocomplete="true"
                      placeholder="Add brands"
                      class="advanced-tag"
                    >
                      <template v-slot:autocomplete-item="props">
                        <div
                          @click="selectedBrands.push(props.item)"
                          style="padding: 10px 15px !important"
                        >
                          <p
                            style="
                              font-size: 14px;
                              margin-bottom: 3px;
                              color: black;
                            "
                          >
                            {{ props.item.text }}
                          </p>
                          <p
                            style="
                              color: rgba(0, 0, 0, 0.3);
                              line-height: 23px;
                              margin-bottom: 0;
                            "
                          >
                            {{ props.item.description }}
                          </p>
                        </div>
                      </template>
                    </vue-tags-input>
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group">
                        <label>Facebook Page</label>
                        <FormulateInput
                          type="text"
                          validation="required"
                          input-class="form-control"
                          placeholder="Enter facebook page"
                          v-model="facebookPage"
                        />
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group">
                        <label>YouTube Page</label>
                        <FormulateInput
                          validation="required"
                          type="text"
                          input-class="form-control"
                          placeholder="Enter youtube page"
                          v-model="youtubePage"
                        />
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>About the Company</label>
                    <FormulateInput
                      v-model="company_desc"
                      rows="4"
                      type="textarea"
                      validation="required"
                      input-class="form-control"
                      placeholder="Enter company description"
                    ></FormulateInput>
                  </div>
                  <div class="form-group">
                    <label>Company Location</label>
                    <FormulateInput
                      validation="required"
                      type="text"
                      input-class="form-control"
                      placeholder="Enter company location"
                      v-model="companyLocation"
                    />
                  </div>
                  <div class="form-group mb-0">
                    <label>Add Associated Documents</label>
                    <div
                      class="projectadd-media-add mb-0"
                      :class="
                        $refs.upload && $refs.upload.dropActive && dragActive
                          ? 'active'
                          : ''
                      "
                      @dragenter="dragEnter"
                      @dragleave="dragLeave"
                    >
                      <div class="add-text">
                       <div class="upload-icon">
                              <img :src="`${publicPath}upload.png`" alt="" />
                            </div>
                            <div class="upload-text">
                                  Drag and Drop
                            </div>
                          or
                        <document-upload
                          ref="docFiles"
                          post-action="/post.method"
                          put-action="/put.method"
                          :multiple="true"
                        >browse
                        </document-upload>
                        your documents in PDF to upload
                      </div>
                    </div>
                    <div class="file-list">
                      <div
                        class="file-item"
                        v-for="nextFilePdf in imageFiles"
                        :key="nextFilePdf"
                        v-if="nextFilePdf.type === 'application/pdf'"
                      >
                        <div class="file-w">
                          <img :src="`${publicPath}pdf.png`" alt=""/>
                          <div class="btns">
                            <button class="btn btn-white-icon-rounded btn-sm">
                              <icon-base
                                width="8.15"
                                height="10"
                                view-box="0 0 12 14.64"
                                icon-name="trash"
                              >
                                <icon-trash/>
                              </icon-base>
                            </button>
                          </div>
                        </div>
                        <input
                          type="text"
                          v-bind:id="nextFilePdf.name"
                          class="form-control form-control-sm"
                          placeholder="Enter caption"
                        />
                      </div>
                    </div>
                  </div>
                </div>
                <div class="projectadd-btns pt-0">
                  <div class="btns">
                    <FormulateInput
                      type="submit"
                      input-class="btn btn-primary btn-wide"
                      :disabled="isPublishing"
                    >
                      <div v-if="isPublishing" class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                      </div>
                      <span v-else>Add Integration Company</span>
                    </FormulateInput>
                  </div>
                </div>
              </div>
              <!-- Project Add Content -->
            </div>

          </div>
          </FormulateForm>
        </div>
      </section>
      <!-- End of Project Add -->
    </main>

    <Footer/>
  </div>
</template>

<script>
import VueTagsInput from "@johmun/vue-tags-input";
// import FileUpload from "vue-upload-component";
import Header from "./common/Header.vue";
import Footer from "./common/Footer.vue";
import IconBase from "./common/IconBase.vue";
import IconPencil from "./common/icons/IconPencil.vue";
import IconAngleDown from "./common/icons/IconAngleDown.vue";
import IconTrash from "./common/icons/IconTrash.vue";
import AddIcon from "./rebranded/icons/AddIcon";
import TrashCanIcon from "./rebranded/icons/TrashCanIcon";

import Vue from "vue";
import vSelect from "vue-select";

Vue.component("v-select", vSelect);
import "vue-select/dist/vue-select.css";
import {bus} from "../app";

const VueUploadComponent = require("vue-upload-component");
Vue.component("file-upload", VueUploadComponent);
Vue.component("document-upload", VueUploadComponent);
var arr_image = [];
var arr_pdf = [];
var company_logo = [];
var arr_image_preview = [];
export default {
  name: "Add Integration Company",
  components: {
    VueTagsInput,
    // FileUpload,
    Header,
    Footer,
    IconBase,
    IconPencil,
    IconAngleDown,
    IconTrash,
    AddIcon,
    TrashCanIcon
  },
  data() {
    return {
      facebookPage: '',
      youtubePage: '',
      companyName: '',
      companyWebsite: '',
      companyLocation: '',
      companyLogo: [],
      selectedProjects: [],
      autocompleteSelectedProjects: [],
      selectedBrands: [],
      brandFilterValue: "",
      max_upload_files: 5,
      isAuthenticated: window.isAuthenticated,
      publicPath: local_image_path,
      dragActive: false,
      logged_user_id: null,
      images: [],
      Epiphan: null,
      youtube_url: null,
      imageFiles: [],
      imageFilesPreview: [],
      imageFilesCount: 0,
      pdfFiles: [],
      pdfFilesCount: 0,
      caption_pdf: [],
      caption_image: [],
      selectedCoverImage: 1,
      projectFilterValue: "",
      company_desc: "",
      autocompleteProjectItems: [],
      autocompleteBrandItems: [],
      isDisabledButton: true,
      integrationCompany: "",
      isPublishing: false,
    };
  },
  watch: {
    companyLogo(theFile) {
      theFile.forEach((file_arr, key) => {
        let image = new Image()
        image.src = file_arr.blob
        image.onload = function () {
          bus.$emit("imageUploadedEvent", this.width, this.height)
        }
        company_logo[0] = file_arr.file
      })
    },
    imageFiles(theFile) {
      if (typeof theFile[0] === "undefined") return;
      var arr_image_count = 0;
      var arr_pdf_count = 0;
      arr_pdf = [];
      arr_image = [];
      theFile.forEach((file_arr, key) => {
        console.log(file_arr);
        if (file_arr.file.type == "application/pdf") {
          arr_pdf[arr_pdf_count] = file_arr.file;
          arr_pdf_count += 1;
          this.pdfFilesCount = arr_pdf_count;
        }

        if (file_arr.file.type !== "application/pdf") {
          let image = new Image();
          image.src = file_arr.blob;
          image.onload = function () {
            bus.$emit("imageUploadedEvent", this.width, this.height);
          };

          //    console.log(theFile[this.imageFilesCount].file);
          arr_image[arr_image_count] = file_arr.file;
          arr_image_count += 1;

          this.imageFilesCount = arr_image_count;
        }
        console.log(arr_pdf);
        console.log(arr_image);
      });

      ///console.log(theFile[this.imageFilesCount].file.type);
    },
    searchServiceCategory(val) {
      console.log("service search" + val);
      this.loadTags(val.id);
    }
  },

  created() {
    document.title = this.$route.meta.title;
  },

  mounted() {
    if (!this.isAuthenticated || !localStorage.getItem("logged_user_id")) {
      this.$toast.error("To open integration company you need to login firstly !");
      this.$router.push({name: "home"});
    }
    this.logged_user_id = localStorage.getItem("logged_user_id");
    this.loadProjects();
    this.loadBrands();
  },
  methods: {
    async delete_image(idx) {
      this.imageFiles.splice(idx, 1);
    },
    getEmbed(url) {
      if (url) {
        const regExp =
          /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
        const match = url.match(regExp);
        let id;
        if (match && match[2].length === 11) {
          return match[2];
        }
      }
    },
    deletePrimayImage (key){
      delete this.companyLogo[key]
      this.companyLogo =  []; 
    },
    updateVueProjectsInput(newProjects) {
      this.selectedProjects = newProjects;
    },
    updateVueBrandInput(newBrands) {
      this.selectedBrands = newBrands;
    },

    async loadProjects() {
      const result = await this.callApi(
        "post",
        window.api_path + "getProjectsList",
        {mode: "only_name"}
      );
      if (result.status != 200) {
        this.$toast.error(result.data.message);
        this.autocompleteProjectItems = [];
        return;
      }
      this.autocompleteProjectItems = result.data.projects;
    },
    async loadBrands() {
      const result = await this.callApi(
        "post",
        window.api_path + "getBrandsList",
        {mode: "only_name"}
      );
      if (result.status != 200) {
        this.$toast.error(result.data.message);
        this.autocompleteBrandItems = [];
        return;
      }
      this.autocompleteBrandItems = result.data.brands;
    },
    inputFile(newFile, oldFile) {
      if (newFile && oldFile && !newFile.active && oldFile.active) {
        if (newFile.xhr) {
          console.log("statusaa", newFile.xhr.status);
        }
      }
    },

    inputFilter(newFile, oldFile, prevent) {
      if (newFile && !oldFile) {
        if (!/\.(jpeg|jpe|jpg|gif|png|webp|pdf)$/i.test(newFile.name)) {
          return prevent();
        }
      }
      if (newFile.file.type != "application/pdf") {
        newFile.blob = "";
        let URL = window.URL || window.webkitURL;
        if (URL && URL.createObjectURL) {
          console.log(newFile.file);
          newFile.blob = URL.createObjectURL(newFile.file);
        }
      }
    },

    pdfFilter(newFile, oldFile, prevent) {
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

    dragEnter() {
      this.dragActive = true;
    },
    dragLeave() {
      this.dragActive = false;
    },
    async publishCompany() {
      if (this.searchServiceCategory === null) {
        this.$toast.error("Please select category");
        return;
      }
      if (this.selectedProjects == "") {
        this.$toast.error("Please enter associated projects");
        return;
      }
      if (this.selectedBrands == "") {
        this.$toast.error("Please enter associated brands");
        return;
      }
      if (!this.imageFilesCount) {
        this.$toast.error('Upload at least one image');
        return
      }
      if (!this.companyLogo) {
        this.$toast.error('Upload company logo');
        return
      }
      this.isPublishing = true;

      const formData = new FormData();
      formData.append("user_id", localStorage.getItem("logged_user_id"));
      formData.append("name", this.companyName);
      formData.append("web_url", this.companyWebsite);
      formData.append("brands", JSON.stringify(this.selectedBrands));
      formData.append("projects", JSON.stringify(this.selectedProjects));
      formData.append("company_desc", this.company_desc);
      formData.append("company_location", this.companyLocation);
      formData.append("image_files_count", this.imageFilesCount);
      formData.append("pdf_files_count", this.pdfFilesCount);
      formData.append("youtube_page", this.youtubePage);
      formData.append("youtube_url", this.youtube_url);
      formData.append("facebook_url", this.facebookPage);
      if (company_logo.length) formData.append("file_logo", company_logo[0])
      if (arr_image[0]) {
        formData.append("file_" + 0, arr_image[0]);
        formData.append(
          "file_image_caption_" + 0,
          document.getElementById(arr_image[0].name + "_caption").value
        );
        formData.append(
          "file_ismain_" + 0,
          document.getElementById(arr_image[0].name + "_ismain").checked
        );
      }
      if (arr_image[1]) {
        formData.append("file_" + 1, arr_image[1]);
        formData.append(
          "file_image_caption_" + 1,
          document.getElementById(arr_image[1].name + "_caption").value
        );
        formData.append(
          "file_ismain_" + 1,
          document.getElementById(arr_image[1].name + "_ismain").checked
        );
      }
      if (arr_image[2]) {
        formData.append("file_" + 2, arr_image[2]);
        formData.append(
          "file_image_caption_" + 2,
          document.getElementById(arr_image[2].name + "_caption").value
        );
        formData.append(
          "file_ismain_" + 2,
          document.getElementById(arr_image[2].name + "_ismain").checked
        );
      }
      if (arr_image[3]) {
        formData.append("file_" + 3, arr_image[3]);
        formData.append(
          "file_image_caption_" + 3,
          document.getElementById(arr_image[3].name + "_caption").value
        );
        formData.append(
          "file_ismain_" + 3,
          document.getElementById(arr_image[3].name + "_ismain").checked
        );
      }
      if (arr_image[4]) {
        formData.append("file_" + 4, arr_image[4]);
        formData.append(
          "file_image_caption_" + 4,
          document.getElementById(arr_image[4].name + "_caption").value
        );
        formData.append(
          "file_ismain_" + 4,
          document.getElementById(arr_image[4].name + "_ismain").checked
        );
      }
      // console.log(arr_pdf);
      if (arr_pdf[0]) {
        formData.append("file_pdf_" + 0, arr_pdf[0]);
        formData.append(
          "file_pdf_caption_" + 0,
          document.getElementById(arr_pdf[0].name).value
        );
      }
      if (arr_pdf[1]) {
        formData.append("file_pdf_" + 1, arr_pdf[1]);
        formData.append(
          "file_pdf_caption_" + 1,
          document.getElementById(arr_pdf[1].name).value
        );
      }
      if (arr_pdf[2]) {
        formData.append("file_pdf_" + 2, arr_pdf[2]);
        formData.append(
          "file_pdf_caption_" + 2,
          document.getElementById(arr_pdf[2].name).value
        );
      }
      if (arr_pdf[3]) {
        formData.append("file_pdf_" + 3, arr_pdf[3]);
        formData.append(
          "file_pdf_caption_" + 3,
          document.getElementById(arr_pdf[3].name).value
        );
      }
      if (arr_pdf[4]) {
        formData.append("file_pdf_" + 4, arr_pdf[4]);
        formData.append(
          "file_pdf_caption_" + 4,
          document.getElementById(arr_pdf[4].name).value
        );
      }
      const TOKEN = localStorage.getItem("sgtoken")
      const headers = {
        "Content-Type": "multipart/form-data",
        Authorization: `Bearer ${TOKEN}`
      };
      axios
        .post(window.api_path + "company/publishcompany", formData, {headers})
        .then((res) => {
          if (res.status == 200) {
            this.$toast.success(res.data.message);
            this.$router.push({ name: 'Integration Company', params: { slug: res.data.data.slug }})
          } else {
            this.$toast.error('Fill all the required fields');
          }
        })
        .finally(() => {
          this.isPublishing = false;
        });
    },
  },
  computed: {
    isDisabled: function () {
      return !this.isDisabledButton;
    },
    filteredProjectItems() {
      return this.autocompleteProjectItems.filter((i) => {
        return (
          i.text
            .toLowerCase()
            .indexOf(this.projectFilterValue.toLowerCase()) !== -1
        );
      });
    },

    filteredBrandItems() {
      return this.autocompleteBrandItems.filter((i) => {
        return (
          i.text
            .toLowerCase()
            .indexOf(this.brandFilterValue.toLowerCase()) !== -1
        );
      });
    },
  }
};
</script>

<style lang="scss" scoped>
.spinner-border {
  width: 1rem;
  height: 1rem;
}
</style>
