<template>
  <div>
    <Header/>
    <main class="main">
      <!-- Project Add -->
      <section class="section-systemadd">
        <div class="container">
          <FormulateForm
            @submit="updateCompany"
          >
            <div class="projectadd-container wblock">
              <header class="projectadd-header">
                <h1>Edit Integration Company</h1>
              </header>
              <div class="projectadd-row">
                <!-- Project Add Thumbnail -->
                <div class="projectadd-media">
                  <div class="projectadd-media-heading">
                    <h2>Integration company thumbnail</h2>
                    <span class="projectadd-media-info"
                    >Up to {{ max_upload_files }}</span
                    >
                  </div>
                  <div class="projectadd-media-items">
                    <div
                      class="projectadd-media-item"
                      v-for="(img, index) in companyImages"
                      :key="index"
                    >
                      <div class="item-img" v-if="img.filename">
                        <img :src="img.filename" alt="" class="rounded"/>
                        <div class="btns">
                          <button
                            class="btn btn-white-icon-rounded"
                            type="button"
                            @click="
                            deleteCompanyImage(
                              img.id,
                              img.company_id,
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
                      <div class="item-caption">
                        <div class="form-group">
                          <input
                            type="text"
                            class="form-control"
                            placeholder="Enter caption"
                            v-model="img.info"
                            v-bind:id="img.filename + '_caption'"
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
                              :checked="0 === 0"
                              :value="index + 1"
                            />
                            <span>Cover Image</span>
                          </label>
                        </div>
                      </div>
                    </div>
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

                  <div v-show="companyImages.length + imageFiles.length >= max_upload_files">
                    <div class="">You reached maximum of files</div>
                  </div>

                  <div
                    v-show="companyImages.length + imageFiles.length < max_upload_files"
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
                        :maximum="5 - companyImages.length"
                        :thread="5 - companyImages.length"
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
                      ref="youtube_url"
                    />
                  </div>
                  <div class="project-video-item" v-if="youtube_url != null && youtube_url != '' && youtube_url != 'null'">
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
                            ref="companyName"
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
                            v-if="Object.keys(companyUploadLogo).length == 0 && companyLogo.length == 0"
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
                            v-else-if="companyLogo.length != 0 && Object.keys(companyUploadLogo).length == 0"
                            v-for="(nextFile, index) in companyLogo"
                            :key="index" class="projectadd-media-item">
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
                          <div
                            v-else-if="companyUploadLogo"
                            class="projectadd-media-item"
                          >
                            <div class="item-img" v-if="companyUploadLogo.filename">
                              <img :src="companyUploadLogo.filename" alt="" class="rounded"/>
                              <div class="btns">
                                  <button
                                    class="btn btn-white-icon-rounded"
                                    type="button"
                                    @click="
                                    deleteCompanyImage(
                                      companyUploadLogo.id,
                                      companyUploadLogo.company_id,
                                      0,
                                      'logo'
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
                        @tags-changed="newTags => selectedProjects = newTags"

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
                        @tags-changed="newTags => selectedBrands = newTags"

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
                      <div class="file-list mt-3">
                        <div
                          class="file-item"
                          v-for="nextFilePdf in companyPDF"
                          :key="nextFilePdf"
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
                            class="form-control form-control-sm"
                            placeholder="Enter caption"
                          />
                        </div>
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
                    <div class="projectadd-btns pt-0">
                      <div class="btns">
                        <FormulateInput
                          type="submit"
                          input-class="btn btn-primary btn-wide"
                          :disabled="isDisabled"
                        >
                          Update Integration Company
                        </FormulateInput>
                      </div>
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
const TOKEN = localStorage.getItem("sgtoken")
  const headers = {
    "Content-Type": "multipart/form-data",
    Authorization: `Bearer ${TOKEN}`
  };
export default {
  name: "Edit Company",
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
      companyUploadLogo: [],
      selectedProjects: [],
      autocompleteSelectedProjects: [],
      selectedBrands: [],
      companyPDF: [],
      companyImages: [],
      company_id: null,
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
      integrationCompany: ""
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
    if (!this.isAuthenticated || !localStorage.getItem("logged_user_id")) {
      this.$toast.error("To open integration company you need to login firstly !");
      this.$router.push({name: "home"});
    }
    this.logged_user_id = localStorage.getItem("logged_user_id");
    this.loadProjects();
    this.loadBrands();
    this.loadCompany();
  },
  methods: {
    async delete_image(idx) {
      this.imageFiles.splice(idx, 1);
    },
    async loadCompany () {
      const res = await this.callApi(
        "get",
        `${window.api_path}company/${this.$route.params.slug}/details`,
        {}
      )
      if (res.status !== 200) {
        this.$toast.error(res.data.message)
        return
      }
      const { ProjectCompany, company, company_image, company_image_logo, company_pdf } = res.data.data

      const c = company
      this.company_id = c.id || ''
      this.companyName = c.name || ''
      this.companyWebsite = c.web_url || ''
      this.facebookPage = c.facebook_url !== 'null' ? c.facebook_url : null
      this.youtubePage = c.youtube_url !== 'null' ? c.youtube_url : null
      this.youtube_url = c.youtube_url !== 'null' ? c.youtube_url : null
      this.company_desc = c.desc || ''
      this.companyLocation = c.location || ''
      this.companyImages = company_image || []
      this.companyPDF = company_pdf || []
      this.companyUploadLogo = company_image_logo || []
      if (c.brand.length) {
        this.selectedBrands = c.brand.map(brand => {
          return {
            id: brand.id,
            text: brand.name,
          }
        })
      }

      if (ProjectCompany.length) {
        this.selectedProjects = ProjectCompany.map(p => {
          return {
            id: p.project_id,
            text: p.name,
          }
        })
      }
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

    updateVueProjectsInput(newProjects) {
      this.selectedProjects = newProjects;
    },
    updateVueBrandInput(newBrands) {
      this.selectedBrands = newBrands;
    },
    deletePrimayImage (key){
      delete this.companyLogo[key]
      this.companyLogo =  []; 
    },
    deleteCompanyImage(imageId, companyId, key, type="thumbnail") {
      const data = new FormData();
      data.append("company_id", companyId);
      data.append("id", imageId);
      axios.post(window.api_path + "company/deleteCompanyImage", data, { headers })
        .then((res) => {
          if (res.status == 200) {
              this.$toast.success(res.data.message);
              if(type == "thumbnail"){
                delete this.companyImages[key]
                this.companyImages = {...this.companyImages}; 
              }else if(type == "logo"){
                  this.companyUploadLogo = [];
              }
              
            return;
          }
          this.$toast.error('Error occurred. Please try again later');
        });

     
      // this.imageFiles.splice(idx, 1);
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
    
    async updateCompany() {
      const regesYoutube = /^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
      if (!this.isAuthenticated || !localStorage.getItem("logged_user_id")) {
        this.$toast.error("To publish company you need to login firstly !");
        return;
      }

      if (this.companyName === null) {
        this.$toast.error("Please enter company name");
        return;
      }else if (this.companyName.length < 2 || this.companyName.length >= 55) {
        this.$toast.error("Please enter minimum 2 and maximum 55 characters in company name");
        this.$refs.companyName.focus()
        return;
      }
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
      if (this.youtube_url != "" && this.youtube_url != null && !this.youtube_url.match(regesYoutube)) {
        this.$toast.error("Please enter valid youtube url link");
        this.$refs.youtube_url.focus();
        return;
      }
      const formData = new FormData();
      formData.append("id", this.company_id)
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
      this.isDisabledButton = false;
      axios
        .post(window.api_path + "company/updatecompany", formData, {headers})
        .then((res) => {
          if (res.status == 200 && res.data.slug != "") {
            this.$toast.success(res.data.message);
            this.$router.push({ name: 'Integration Company', params: { slug: res.data.data.slug }})
          }
          else if (res.status == 200 && res.data.status == "N") {
            this.$toast.success(res.data.message);
            this.$router.push({ name: 'Integration Company', params: { slug: res.data.data.slug }})
          } else {
            this.$toast.error('Fill all the required fields');
          }
        });
    },
    inputLogo(newFile, oldFile) {
      console.log('inputting logo file')
      console.log('newLogoFile', newFile)
      console.log('oldLogoFile', oldFile)
    }
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
<style scoped>
  @media all and (min-width:600px) and (max-width:991px){
    .projectadd-media-items{
      display:flex;
      flex-wrap:wrap;
    }
    .projectadd-media-items > div {
      width: calc(50% - 10px);
      margin-right: 10px;
    }
    .projectadd-media-items > div:last-child {
      margin-right: 0;
    }
    .projectadd-media-items > div > .item-img {
      width:100%;
      height: 250px;
      max-width: unset;
      overflow: hidden;
    }
    .projectadd-media-items > div > .item-img > img {
      object-fit: fill;
      object-position: top;
      width: 100%;
      height: 100%;
    }
  }

  @media all and (max-width:599px){
    .projectadd-media-items > div {
      width: 100%;
    }
    .projectadd-media-items > div > .item-img{
      height:auto;
      max-width:100%;
    }
    .projectadd-media-items > div > .item-img > img {
      width:100%;
    }
  }
</style>