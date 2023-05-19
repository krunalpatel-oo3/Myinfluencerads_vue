<template>
  <modal
    name="add-integration-dialog"
    :width="824"
    height="auto"
    :scrollable="true"
    :adaptive="true"
    transition=""
    class="section-modal section-modal-integration"
  >
    <div
      class="modal-close"
      @click="$modal.hide('add-integration-dialog')"
    >
      <CloseIcon />
    </div>
    <main class="main">
      <div class="section-systemadd">
        <div class="projectadd-container wblock">
          <header class="projectadd-header">
            <h1>New Integration Company</h1>
          </header>
          <div class="custom-pop-body">
              <div class="projectadd-row">
    
                <!-- Project Add Content -->
                <div class="projectadd-content">
                  <div class="projectadd-form">
                    <div class="row mx-0">
                      <div class="col-6 p-0">
                        <div class="form-group">
                          <label>Company Name</label>
                          <input
                            type="text"
                            class="form-control"
                            placeholder="Enter company name"
                            v-model="companyName"
                            name="Company name"
                            validation="required"
                            ref="companyName"
                          />
                        </div>
                        <div class="form-group">
                          <label>Company Website</label>
                          <input
                            type="text"
                            class="form-control"
                            placeholder="https://www.streamgeeks.com"
                            v-model="companyWebsite"
                            validation="required"
                          />
                        </div>
                      </div>
                      <div class="col-6 pl-4">
                        <div class="form-group">
                          <label>Company Logo</label>
                          <div
                            class="projectadd-media-add"
                                v-if="!companyLogo.length"
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
                                  input-id="logoFile"
                                  v-model="companyLogo"
                                  post-action="/post.method"
                                  put-action="/put.method"
                                  @input-file="inputFileCompany"
                                  :multiple="true"
                                  @input-filter="inputFilterCompany"
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
                        placeholder="Add projects"
                        @tags-changed="updateVueProjectsInput"
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
                        @tags-changed="updateVueBrandInput"
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
                    <div class="row mx-0">
                      <div class="col-6 p-0">
                        <div class="form-group">
                          <label>Facebook Page</label>
                          <input
                            type="text"
                            class="form-control"
                            placeholder="https://www.facebook.com"
                            v-model="facebookPage"
                          />
                        </div>
                      </div>
                      <div class="col-6 pl-4">
                        <div class="form-group">
                          <label>YouTube Page</label>
                          <input
                            type="text"
                            class="form-control"
                            placeholder="https://www.youtube.com"
                            v-model="youtubePage"
                          />
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label>About the Company</label>
                      <textarea
                        v-model="company_desc"
                        rows="4"
                        class="form-control"
                        placeholder="Enter company description"
                      ></textarea>
                    </div>
                    <div class="form-group">
                      <label>Company Location</label>
                      <input
                        type="text"
                        class="form-control"
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
                          <!-- <document-upload
                            ref="docFiles"  
                            post-action="/post.method"
                            put-action="/put.method"
                            :drop="true"
                            :multiple="true"
                          >browse
                          </document-upload> -->
                          <file-upload
                            ref="company_pdf_file"
                            v-model="companyFiles" 
                            :extensions="['pdf']" 
                            input-id="companyFiles" 
                            @input-file="companyPdfFile"
                            @input-filter="companyPdfFilter"
                            :multiple="true">browse
                          </file-upload>
                          your documents in PDF to upload
                        </div>
                      </div>
                      <div class="file-list mt-4">
                          <div
                            class="file-item"
                            v-for="nextFilePdf in companyFiles"
                            :key="nextFilePdf"
                            v-if="nextFilePdf.type === 'application/pdf'"
                          >
                            <div class="file-w">
                              <img :src="`${publicPath}pdf.png`" alt=""/>
                              <div class="btns">
                                <button  @click="delete_pdf(nextFilePdf.id)" class="btn btn-white-icon-rounded btn-sm">
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
                </div>
                <!-- Project Add Content -->
              </div>
              <div class="row mx-0 justify-content-start">
                <div class="col-6 p-0">
                  <label>Thumbnail <span class="ml-4" style="font-style: italic">Up to 5</span></label>
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
                      <file-upload
                        ref="file"
                        v-model="imageFiles"
                        post-action="/post.method"
                        put-action="/put.method"
                        input-id="company_file"
                        @input-file="inputFileCompany"
                        :maximum="5"
                        :thread="5"
                        :multiple="true"
                        @input-filter="inputFilterCompany"
                      >browse
                      </file-upload>
                      your image to upload
                    </div>
                  </div>
                </div>
                <div
                  class="projectadd-media-item col-6 pl-2"
                  v-for="(nextFile, index) in imageFiles"
                  :key="nextFile.name"
                  v-if="nextFile.type != 'application/pdf'"
                >
                  <div class="item-img">
                    <img :src="nextFile.blob" alt="" class="rounded" />
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
                          <icon-trash />
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
                <div v-show="imageFiles.length >= max_upload_files">
                  <div class="">You reached maximum of files</div>
                </div>
              </div>
              <div class="row mx-0 justify-content-start">
                <div class="col-6 p-0">
                  <div class="form-group project-video-add">
                    <label>Add Youtube Video Link</label>
                    <input
                      type="text"
                      v-model="youtube_url"
                      placeholder="www.youtube.com/streamgeeks"
                      class="form-control"
                      ref="youtube_url"
                    />
                  </div>
                  <div class="project-video-item" v-if="youtube_url != null && youtube_url != ''">
                    <div class="project-video-item">
                    <iframe
                        :src="`https://www.youtube.com/embed/${getEmbed(
                          this.youtube_url
                        )}?controls=0`"
                        title="YouTube video player"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen
                        style="width: 100%; height: 200px"
                      ></iframe>
                  </div>
                  </div>
                </div>
                <!-- <div class="col-6 d-flex align-items-center justify-content-center add-video-link" style="min-height: 200px">
                  <div @click="videos.push({ link: '' })" class="d-flex justify-content-center" style="flex-wrap: wrap">
                    <svg width="36" height="35" viewBox="0 0 36 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <circle cx="18" cy="17.5" r="17.5" fill="#F2A91C"/>
                      <path d="M17.9996 25C17.4366 25 16.9805 24.5439 16.9805 23.9809V11.0191C16.9805 10.4562 17.4366 10 17.9996 10C18.5626 10 19.0187 10.4561 19.0187 11.0191V23.9809C19.0187 24.5437 18.5626 24.9999 17.9996 24.9999V25Z" fill="white"/>
                      <path d="M24.4809 18.5187H11.5191C10.9562 18.5187 10.5 18.0626 10.5 17.4996C10.5 16.9366 10.9561 16.4805 11.5191 16.4805H24.4809C25.0438 16.4805 25.5 16.9366 25.5 17.4996C25.4999 18.0626 25.0437 18.5187 24.4807 18.5187H24.4809Z" fill="white"/>
                    </svg>
                    <p class="t-16 t-color10 w-100 text-center mt-2">Add Youtube Video</p>
                  </div>
                </div> -->
              </div>
          </div>
        </div>

        <button
          class="btn btn-primary btn-wide mt-4"
          @click.prevent="publishCompany()"
          :disabled="isPublishing"
        >  
          <div v-if="isPublishing" class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
          </div>
          <span v-else>Add Integration Company</span>
        </button>

      </div>
    </main>
  </modal>
</template>

<script>
import VueTagsInput from "@johmun/vue-tags-input";
import CloseIcon from "../icons/CloseIcon.vue";
import IconBase from "../../common/IconBase";
import IconTrash from "../../common/icons/IconTrash.vue";
import { bus } from "../../../app";

import Vue from "vue";
import vSelect from "vue-select";

Vue.component("v-select", vSelect);

import "vue-select/dist/vue-select.css";

const VueUploadComponent = require("vue-upload-component");
Vue.component("file-upload", VueUploadComponent);
Vue.component("document-upload", VueUploadComponent);
var arr_image = [];
var arr_pdf = [];
var company_logo = [];
export default {
  name: "AcceptOfferModal",
  components: {
    CloseIcon,
    VueTagsInput,
    IconTrash,
    IconBase,
  },
  data() {
    return {
      facebookPage: null,
      youtubePage: null,
      companyName: null,
      companyWebsite: null,
      companyLocation: null,
      youtube_url: null,
      companyLogo : [],
      selectedProjects: [],
      autocompleteSelectedProjects: [],
      selectedBrands: [],
      brandFilterValue: "",
      isPublishing: false,
      images: [],
      videos: [{
        link: ''
      }],
      max_upload_files: 5,
      isAuthenticated: window.isAuthenticated,
      publicPath: local_image_path,
      dragActive: false,
      logged_user_id: null,

      imageFiles: [],
      imageFilesCount: 0,
      pdfFilesCount: 0,
      selectedCoverImage: 1,
      
      projectFilterValue: "",
      company_desc: null,
      autocompleteProjectItems: [],
      autocompleteBrandItems: [],
      isDisabledButton: true,
      integrationCompany: "",
      companyFiles: [],
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
      arr_image           = [];
      theFile.forEach((file_arr, key) => {
        if (file_arr.file.type !== "application/pdf") {
          let image = new Image();
          image.src = file_arr.blob;
          image.onload = function () {
            bus.$emit("imageUploadedEvent", this.width, this.height);
          };

          arr_image[arr_image_count] = file_arr.file;
          arr_image_count += 1;
          this.imageFilesCount = arr_image_count;
        }
      });
    },

    companyFiles(theFile) {
      if (typeof theFile[0] === "undefined") return;
      var arr_pdf_count = 0;
      arr_pdf           = [];
      theFile.forEach((file_arr, key) => {
        if (file_arr.file.type == "application/pdf") {
          arr_pdf[arr_pdf_count] = file_arr.file;
          arr_pdf_count += 1;
          this.pdfFilesCount = arr_pdf_count;
        }
      });
    },
    
  },
  methods: {
    deletePrimayImage (key){
      delete this.companyLogo[key]
      this.companyLogo =  []; 
    },
    async delete_image(idx) {
      this.imageFiles.splice(idx, 1);
    },
    delete_pdf(id) {
      this.companyFiles = this.companyFiles.filter(e => e.id !== id)
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
 

    inputFileCompany(newFile, oldFile) {
      if (newFile && oldFile && !newFile.active && oldFile.active) {
        if (newFile.xhr) {
          console.log("statusaa", newFile.xhr.status);
        }
      }
    },

    inputFilterCompany(newFile, oldFile, prevent) {
      if (newFile && !oldFile) {
        if (!/\.(jpeg|jpe|jpg|png|webp)$/i.test(newFile.name)) {
          this.$toast.error("Please select valid file!");
          return prevent();
        }
      }
      if(newFile.size > 1000000){
        this.$toast.error("You can not enter file more then 1 MB!");
        return prevent();
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

    companyPdfFile(newFile, oldFile) {
      if (newFile && oldFile && !newFile.active && oldFile.active) {
        if (newFile.xhr) {
          console.log("statusaa", newFile.xhr.status);
        }
      }
    },
    
    companyPdfFilter(newFile, oldFile, prevent) {
      if (newFile && !oldFile) {
        if (!/\.(pdf)$/i.test(newFile.name)) {
          this.$toast.error("Please select valid file!");
          return prevent();
        }
      }

      if(newFile.size > 2000000){
        this.$toast.error("You can not enter file more then 2 MB!");
        return prevent();
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
     updateVueProjectsInput(newProjects) {
      this.selectedProjects = newProjects;
    },
    updateVueBrandInput(newBrands) {
      this.selectedBrands = newBrands;
    },
    async publishCompany() {
      const regesYoutube = /^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
      if (this.companyName === null) {
        this.$toast.error("Please enter company name");
        return;
      }else if (this.companyName.length < 2 || this.companyName.length >= 55) {
        this.$toast.error("Please enter minimum 2 and maximum 55 characters in company name");
        this.$refs.companyName.focus()
        return;
      }

      if (this.companyWebsite === null) {
        this.$toast.error("Please enter company website");
        return;
      }
      if (this.facebookPage === null) {
        this.$toast.error("Please enter facebook page");
        return;
      }
      if (this.youtubePage === null) {
        this.$toast.error("Please enter youtube page");
        return;
      }
      if (this.company_desc === null) {
        this.$toast.error("Please enter about the company");
        return;
      }
      if (this.companyLocation === null) {
        this.$toast.error("Please enter company location");
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
      if (this.youtube_url != "" && this.youtube_url != null && !this.youtube_url.match(regesYoutube)) {
        this.youtube_url = "";
        this.$toast.error("Please enter valid youtube url link");
        this.$refs.youtube_url.focus();
        return;
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
             if (res.data.code === 0) {
              this.$toast.error(res.data.message);
              return;
            } 
            this.resetForm();
            this.$toast.success(res.data.message);
            this.$emit('loadCompanies')
            
            // this.$router.push({ name: 'Integration Company', params: { slug: res.data.data.slug }})
          } else {
            this.$toast.error('Fill all the required fields');
          }
        })
        .finally(() => {
          this.isPublishing = false;
        });
    },
     resetForm(){
      this.companyName = null;
      this.companyWebsite = null;
      this.company_desc = null;
      this.companyLocation = null;
      this.youtubePage = null;
      this.youtube_url = null;
      this.facebookPage = null;
      this.imageFilesCount= 0;
      this.pdfFilesCount= 0;
      this.selectedBrands = [];
      this.selectedProjects = [];
      this.companyLogo = [],
      this.autocompleteSelectedProjects= [],
      this.brandFilterValue = "",
      this.images = [],
      this.max_upload_files= 5,
      this.imageFiles = [],
      this.projectFilterValue = "",
      // this.autocompleteProjectItems = [],
      // this.autocompleteBrandItems= [],
      this.integrationCompany = ""
      arr_image = [];
      arr_pdf = [];
      company_logo = [];
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
  },
  mounted() {
     this.logged_user_id = localStorage.getItem("logged_user_id");
    this.loadProjects();
    this.loadBrands();
  },
    computed: {
    // isDisabled: function () {
    //   return !this.isDisabledButton;
    // },
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
.modal-close {
  padding: 0 !important;
  top: 31px !important;
  right: 31px !important;
}
.add-video-link {
  cursor: pointer;
  &:hover {
    filter: brightness(1.3);
    p {
      color: #F2A91C;
    }
  }
}
.row {
  margin: 10px 20px 0px 20px;
  display: flex;
  justify-content: center;
  flex-wrap: wrap;

  // .btns {
  //   width: 100%;
  //   display: flex;
  //   justify-content: center;
  //   margin-top: 44px;

  //   .btn {
  //     margin: 0 !important;
  //     height: 83.34px;
  //     width: 284.25px;
  //     background: #F2A91C;
  //     border-radius: 15px;
  //     font-size: 24px;
  //     border: none;
  //     color: #000000;
  //     font-weight: 500;
  //   }
  // }

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

.wblock {
  background: white;
  box-shadow: none;
  padding: 0;
}

.projectadd-content {
  border: none !important;
  padding: 0 !important;
}

.section-systemadd {
  padding: 20px 0;
  background: none;
}
.custom-pop-body {
    height: calc(100vh - 300px);
    overflow-y: auto;
}

.custom-pop-body::-webkit-scrollbar {
    width: 5px;
}
 
.custom-pop-body::-webkit-scrollbar-track {
    background-color: #ebebeb;
    -webkit-border-radius: 10px;
    border-radius: 10px;
}

.custom-pop-body::-webkit-scrollbar-thumb {
    -webkit-border-radius: 10px;
    border-radius: 10px;
    background: #202c54; 
}

</style>

