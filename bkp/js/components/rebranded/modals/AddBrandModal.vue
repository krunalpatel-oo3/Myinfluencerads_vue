<template>
  <modal
    name="add-brand-dialog"
    :width="824"
    height="auto"
    :scrollable="true"
    :adaptive="true"
    transition=""
    class="section-modal section-modal-brand"
  >
    <div
      class="modal-close"
      @click="$modal.hide('add-brand-dialog')"
    >
      <CloseIcon />
    </div>
    <main class="main">
      <div class="section-systemadd">
        <div class="projectadd-container wblock">
          <header class="projectadd-header">
            <h1>New Brand</h1>
          </header>
          <div class="projectadd-row">
            <!-- Project Add Content -->
            <div class="projectadd-content">
              <div class="projectadd-form">
                <div class="row mx-0">
                  <div class="col-6 p-0">
                    <div class="form-group">
                      <label>Brand Name</label>
                      <input
                        type="text"
                        class="form-control"
                        placeholder="Enter brand name"
                        v-model="brandName"
                        ref="brandName"
                      />
                    </div>
                    <div class="form-group">
                      <label>Brand Website</label>
                      <input
                        type="text"
                        class="form-control"
                        placeholder="https://www.streamgeeks.com"
                        v-model="brandWebsite"
                        ref="brandWebsite"
                      />
                    </div>
                  </div>
                  <div class="col-6 pl-4">
                    <div class="form-group">
                      <label>Brand Logo</label>
                      <div
                            v-if="!brandLogo.length"
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
                                v-model="brandLogo"
                                post-action="/post.method"
                                put-action="/put.method"
                                input-id="logoFile"
                                @input-file="brandInputFile"
                                @input-filter="brandInputFilter"
                              >browse
                              </file-upload>
                              your image to upload
                            </div>
                          </div>
                          <div
                            v-else
                            v-for="(nextFile, index) in brandLogo"
                            :key="index"
                             class="projectadd-media-item"
                          >
                            <div class="item-img">
                              <img :src="nextFile.blob" alt="" class="rounded" />
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
                  <label>Category</label>
                  <v-select
                    v-model="searchServiceCategory"
                    label="text"
                    code="id"
                    item-text="text"
                    :options="searchServiceCategories"
                    :clearable="false"
                    class="form-control v-select-light"
                    placeholder="Select category"
                  >
                    <template #open-indicator="{ attributes }">
                            <span v-bind="attributes">
                              <icon-base
                                width="12"
                                height="6.84"
                                view-box="0 0 12 6.84"
                                icon-name="angle-down"
                              >
                                <icon-angle-down />
                              </icon-base>
                            </span></template>
                  </v-select>
                </div>
                <div class="form-group search-tags custom-search">
                  <label>Associated Products</label>
                  <vue-tags-input
                     v-model="productFilterValue"
                    :tags="selectedProducts"
                    :autocomplete-items="filteredProductItems"
                    :add-only-from-autocomplete="true"
                    placeholder="Add products"
                    class="advanced-tag"
                  >
                    <template v-slot:autocomplete-item="props">
                      <div
                        @click="selectedProducts.push(props.item)"
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
                        ref="facebookPage"
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
                        ref-="youtubePage"
                      />
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label>About the Brand</label>
                  <textarea
                    v-model="brand_desc"
                    rows="4"
                    class="form-control"
                    placeholder="Enter brand description"
                    ref="brand_desc"
                  ></textarea>
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
                        :multiple="true"
                      >browse
                      </document-upload> -->
                      <file-upload
                        ref="brand_pdf_file"
                        v-model="brandFiles" 
                        :extensions="['pdf']" 
                        input-id="brandFiles" 
                        @input-file="brandPdfFile"
                        @input-filter="brandPdfFilter"
                        :multiple="true">browse
                      </file-upload>
                      your documents in PDF to upload
                    </div>
                  </div>
                  <div class="file-list mt-3">
                    <div
                      class="file-item"
                      v-for="nextFilePdf in brandFiles"
                      :key="nextFilePdf"
                      v-if="nextFilePdf.type == 'application/pdf'"
                    >
                      <div class="file-w">
                        <img :src="`${publicPath}pdf.png`" alt="" />
                        <div class="btns">
                          <button @click="delete_pdf(nextFilePdf.id)" class="btn btn-white-icon-rounded btn-sm">
                            <icon-base
                              width="8.15"
                              height="10"
                              view-box="0 0 12 14.64"
                              icon-name="trash"
                            >
                              <icon-trash />
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
                v-show="brandImageFiles.length < max_upload_files"
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
                    ref="brand_file"
                    v-model="brandImageFiles"
                    post-action="/post.method"
                    put-action="/put.method"
                    input-id="brand_file"
                    @input-file="brandInputFile"
                    :multiple="true"
                    :maximum="5"
                    :thread="5"
                    @input-filter="brandInputFilter"
                  >browse
                  </file-upload>
                  your image to upload
                </div>
              </div>
            </div>
            <div
              class="projectadd-media-item col-6 pl-2"
              v-for="(nextFile, index) in brandImageFiles"
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
            <div v-show="brandImageFiles.length >= max_upload_files">
              <div class="">You reached maximum of files</div>
            </div>
          </div>
          <div class="row mx-0 justify-content-start">
            <!-- :class="'col-6 p-0' + (index % 2 === 1 ? ' pl-2' : 'pr-2')" v-for="(video, index) in videos" -->
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
              <div class="project-video-item" v-if="youtube_url != '' && youtube_url != null">
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

          <button
            class="btn btn-primary btn-wide mt-4"
            :disabled="submitting"
            @click.prevent="publishBrand()"
          >
            <div v-if="submitting" class="spinner-border" role="status">
              <span class="sr-only">Loading...</span>
            </div>
            Add Brand
          </button>

        </div>
      </div>
    </main>
  </modal>
</template>

<script>
import VueTagsInput from "@johmun/vue-tags-input";
import CloseIcon from "../icons/CloseIcon.vue";
import IconBase from "../../common/IconBase";
import IconTrash from "../../common/icons/IconTrash.vue";
import IconAngleDown from "../../common/icons/IconAngleDown.vue";

import Vue from "vue";
import vSelect from "vue-select";
import { bus } from "../../../app";

Vue.component("v-select", vSelect);

import "vue-select/dist/vue-select.css";

const VueUploadComponent = require("vue-upload-component");
Vue.component("file-upload", VueUploadComponent);
Vue.component("document-upload", VueUploadComponent);
var brand_logo = [];
var arr_image = [];
var arr_pdf = [];
export default {
  name: "Add Brand Modal",
  components: {
    CloseIcon,
    IconTrash,
    VueTagsInput,
    IconBase,
    IconAngleDown
  },
  data() {
    return {
       brandName: null,
      brandWebsite: null,
      videos: [{
        link: ''
      }],
      productCategory: null,
      productCategoryOptions: [
        "Category 1",
        "Category 2",
        "Category 3"
      ],
      productSubCategory: null,
      productSubCategoryOptions: [
        "Category 1",
        "Category 2",
        "Category 3"
      ],
      product: "",
      facebookPage: null,
      youtubePage: null,
      companyName: null,
      companyWebsite: null,
      companyLocation: null,
      selectedProducts: [],
      autocompleteSelectedProducts: [
        {
          description: "Et distinctio occaecati sint inventore fuga enim. Mollitia debitis magnam quos ipsam.",
          id: 6,
          text: "Product Cum culpa rerum consequuntur labore."
        },
        {
          description: "Lorom ipsum dolor amet",
          id: 1,
          text: "Example 1"
        }
      ],
      accessory: "",
      selectedAccessories: [],
      autocompleteSelectedAccessories: [
        {
          description: "Et distinctio occaecati sint inventore fuga enim. Mollitia debitis magnam quos ipsam.",
          id: 6,
          text: "Product Cum culpa rerum consequuntur labore."
        },
        {
          description: "Lorom ipsum dolor amet",
          id: 1,
          text: "Example 1"
        }
      ],
      hour_rate: 0,
      weekly_limit: 0,
      fixed_due_date: null,
      fixed_payment: false,
      max_upload_files: 5,
      isAuthenticated: window.isAuthenticated,
      publicPath: local_image_path,
      dragActive: false,
      logged_user_id: null,
      categorySelectionItems: [],
      selection_category_id: null,
      autocompleteCategoryItems: [],
      autocompletePlatformItems: [],

      images: [],
      searchServiceCategory: "",
      searchServiceCategories: [],
      platformSelectionItems: [],
      selection_platform_id: null,
      Epiphan: null,
      link_url:'',
      link_youtube:'',
      youtube_url: null,
      brandImageFiles: [],
      imageFilesPreview: [],
      imageFilesCount: 0,
      pdfFiles: [],
      pdfFilesCount: 0,
      caption_pdf: [],
      caption_image: [],
      selectedCoverImage: 1,
      productFilterValue: "",
      categoryFilterValue: "",
      platformFilterValue: "",
      project_title: "",
      project_budget: "",
      project_stage: "",
      project_desc: "",
      project_skill: "",
      brand_desc: "",
      project_subtitle: "",
      tagFilterValue: "",
      tag: [],
      selectedTags: [],
      selectedPlatforms: [],
      brandLogo: [],
      selectedCategories: [],
      autocompleteTagItems: [
        { id: 1, checked: false, text: "MySQL" },
        { id: 2, checked: false, text: "HTML" },
        { id: 3, checked: false, text: "CSS" },
        { id: 4, checked: false, text: "JS" },
        { id: 5, checked: false, text: "API Docs" },
        { id: 6, checked: false, text: "Vue JS" },
        { id: 7, checked: false, text: "React JS" },
        { id: 8, checked: false, text: "Laravel" }
      ],
      autocompleteProductItems: [],
      isDisabledButton: true,
      integrationCompany: "",
      submitting: false,
      brandFiles: [],
    };
  },
   created() {
      
    this.logged_user_id = localStorage.getItem("logged_user_id");
    this.loadProducts();
    this.loadCategoriesList();
    this.getUser();
  },
  methods: {
    updatetBrandValue(value) {
      if (typeof value[0] === "undefined") return;
      var arr_pdf_count = 0;
      arr_pdf = [];
      value.forEach((file_arr, key) => {
        if (file_arr.file.type != "application/pdf") {
          value.splice(key,1);
          this.$toast.error("Please select only pdf file");
          return false;
        }
        if (file_arr.file.type == "application/pdf") {
          arr_pdf[arr_pdf_count] = file_arr.file;
          arr_pdf_count += 1;
          this.pdfFilesCount = arr_pdf_count;
        }
      })
      this.brandFiles = value
    },
    delete_pdf(id) {
      this.brandFiles = this.brandFiles.filter(e => e.id !== id)
    },
     deletePrimayImage (key){
      delete this.brandLogo[key]
      this.brandLogo =  []; 
    },
     async publishBrand() {
      const regexLinkURL = RegExp('(https?:\\/\\/)?((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|((\\d{1,3}\\.){3}\\d{1,3}))(\\:\\d+)?(\\/[-a-z\\d%_.~+@]*)*(\\?[;&a-z\\d%_.~+=-@]*)?(\\#[-a-z\\d_@]*)?$', 'i');
      const regesYoutube = /^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
      if (this.brandName == null) {
        this.$toast.error("Please enter the brand name");
        this.$refs.brandName.focus()
        return;
      }else if (this.brandName.length < 2 || this.brandName.length >= 55) {
        this.$toast.error("Please enter minimum 2 and maximum 55 characters in brand name");
        this.$refs.brandName.focus()
        return;
      }

      if (this.brandWebsite != "" && this.brandWebsite != null && !this.brandWebsite.match(regexLinkURL)) {
        this.$toast.error("Please enter the valid URL for Brand website");
        this.$refs.brandWebsite.focus();
        return false;
      }
      if (this.brandLogo.length <= 0) {
        this.$toast.error('Upload brand logo');
        return;
      }
      if (this.searchServiceCategory.id == undefined) {
        this.$toast.error("Please select the category");
        return;
      }
      if (this.facebookPage != "" && this.facebookPage != null && !this.facebookPage.match(regexLinkURL)) {
        this.$toast.error("Please enter the valid URL for Brand facebook page");
        this.$refs.facebookPage.focus();
        return false;
      }
      if (this.youtubePage != "" && this.youtubePage != null && !this.youtubePage.match(regexLinkURL)) {
        this.$toast.error("Please enter the valid URL for Brand yotube page");
        this.$refs.youtubePage.focus();
        return false;
      }
      if (!this.brand_desc) {
        this.$toast.error('Please enter About the Brand');
        this.$refs.brand_desc.focus();
        return
      }
      if (!this.imageFilesCount) {
        this.$toast.error('Upload at least one thumbnail image');
        return
      }
      if (this.youtube_url != "" && this.youtube_url != null && !this.youtube_url.match(regesYoutube)) {
        this.youtube_url = "";
        this.$toast.error("Please enter valid youtube url link");
        this.$refs.youtube_url.focus();
        return;
      }
      // if (this.brandWebsite != null && !this.youtube_url.match(regexLinkURL)) {
      //   this.$toast.error("Please enter the valid URL for Brand add yotube video link");
      //   this.$refs.youtube_url.focus();
      //   return false;
      // }
      this.submitting = true;
      this.isPublishing = true;
      const data = new FormData();
      data.append("name", this.brandName);
      data.append("brand_desc", this.brand_desc);
      data.append("web_url", this.brandWebsite);
      data.append("youtube_page", this.youtubePage || '');
      data.append("youtube_url", this.youtube_url || '');
      data.append("facebook_url", this.facebookPage || '');
      data.append("product", JSON.stringify(this.selectedProducts));
      data.append("category_id", this.searchServiceCategory.id);
      data.append("image_files_count", this.imageFilesCount);
      data.append("pdf_files_count", this.pdfFilesCount);
      if (brand_logo.length) data.append("file_logo", brand_logo[0]);
      for (let i = 0; i <= 4; i++) {
        if (arr_image[i]) {
          data.append("file_" + i, arr_image[i]);
          data.append(
            "file_image_caption_" + i,
            document.getElementById(arr_image[i].name + "_caption").value
          );
          data.append(
            "file_ismain_" + i,
            document.getElementById(arr_image[i].name + "_caption").checked
          );
        }
      }
      for (let i = 0; i <= 4; i++) {
        if (arr_pdf[i]) {
          data.append("file_pdf_" + i, arr_pdf[i]);
          data.append(
            "file_pdf_caption_" + i,
            document.getElementById(arr_pdf[i].name).value
          );
        }
      }
      const TOKEN = localStorage.getItem("sgtoken")
      const headers = {
        "Content-Type": "multipart/form-data",
        Authorization: `Bearer ${TOKEN}`
      };
      axios.post(window.api_path + "brand/publishbrand", data, { headers })
        .then((res) => {
          if (res.data.code === 0) {
            this.$toast.error(res.data.message);
            return;
          } else if (res.data.code === 1) {
            this.resetForm();
            this.$toast.success(res.data.message);
            this.$emit('loadBrands')
            this.$modal.hide("add-brand-dialog")

          }
          this.submitting = false;
        })
        .catch((err) => {
          this.$toast.error(err)
        })
        .finally(() => {
          this.isPublishing = false;
          this.submitting = false;
        });
    },
     resetForm(){
      this.brandName = "";
      this.brand_desc = "";
      this.brandWebsite = "";
      this.productFilterValue = "";
      this.youtubePage = "";
      this.youtube_url = "";
      this.facebookPage = "";
      this.selectedProducts = [];
      this.searchServiceCategory = "";
      this.imageFilesCount= 0;
      this.pdfFilesCount= 0;
      this.brandImageFiles = [];
      this.imageFilesPreview = [];
      this.brandLogo = [];
      brand_logo = [];
      arr_image = [];
      arr_pdf = [];
    },
    async loadProducts() {
      const result = await this.callApi(
        "post",
        window.api_path + "getProductsList",
        { mode: "only_name" }
      );
      if (result.status != 200) {
        this.$toast.error(result.data.message);
        this.autocompleteProductItems = [];
        return;
      }
      this.autocompleteProductItems = result.data.products.map(p => {
        return { ...p, qty: 1 };
      });
    },
    async loadCategoriesList() {
      const result = await this.callApi(
        "post",
        window.api_path + "getCategoriesList",
        { mode: "selection" }
      );
      if (result.status != 200) {
        this.$toast.error(result.data.message);
        this.categories = [];
        return;
      }
      this.searchServiceCategories = result.data.categories;
    },
    async getUser() {
      this.isLoading = true;
      const result = await this.callApi(
        "get",
        window.api_path + "profile/" + this.logged_user_id + "/getUserProfile"
      );
      if (result.status != 200) {
        this.$toast.error(result.data.message);
        this.userprofile = [];
        this.isLoading = false;
        return;
      }
      this.userprofile = result.data;

      if (this.userprofile.User.user_type === "seller") {
        this.isPro = true;
      }
    },
    async delete_image(idx) {
      this.brandImageFiles.splice(idx, 1);
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
    selectCategory() {
      console.log("sfsdfsdfsfds");
    },

    brandInputFile(newFile, oldFile) {
      if (newFile && oldFile && !newFile.active && oldFile.active) {
        if (newFile.xhr) {
          console.log("statusaa", newFile.xhr.status);
        }
      }
    },

    brandInputFilter(newFile, oldFile, prevent) {
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

    brandPdfFile(newFile, oldFile) {
      if (newFile && oldFile && !newFile.active && oldFile.active) {
        if (newFile.xhr) {
          console.log("statusaa", newFile.xhr.status);
        }
      }
    },

    brandPdfFilter(newFile, oldFile, prevent) {
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
    
  },
  watch: {
    
    brandLogo(theFile) {
      theFile.forEach((file_arr, key) => {
        let image = new Image();
        image.src = file_arr.blob;
        image.onload = function() {
          bus.$emit("imageUploadedEvent", this.width, this.height);
        };
        brand_logo[0] = file_arr.file;
      });
    },
    brandImageFiles(theFile) {
      if (typeof theFile[0] === "undefined") return;
      var arr_image_count = 0;
      arr_image = [];
      theFile.forEach((file_arr, key) => {
        if (file_arr.file.type != "application/pdf") {
          let image = new Image();
          image.src = file_arr.blob;
          image.onload = function() {
            bus.$emit("imageUploadedEvent", this.width, this.height);
          };

          arr_image[arr_image_count] = file_arr.file;
          arr_image_count += 1;
          this.imageFilesCount = arr_image_count;
        }
      });
    },
    brandFiles(theFile) {
      if (typeof theFile[0] === "undefined") return;
      var arr_pdf_count = 0;
      arr_pdf = [];
      theFile.forEach((file_arr, key) => {
        if (file_arr.file.type == "application/pdf") {
          arr_pdf[arr_pdf_count] = file_arr.file;
          arr_pdf_count += 1;
          this.pdfFilesCount = arr_pdf_count;
        }
      });
    },
    searchServiceCategory(val) {
      // this.loadTags(val.id);
    },
   
  },
  mounted() {
    console.log("show");
  },
  computed: {
    
    isDisabled: function() {
      return !this.isDisabledButton;
    },
    filteredProductItems() {
      return this.autocompleteProductItems.filter((i) => {
        return (
          i.text
            .toLowerCase()
            .indexOf(this.productFilterValue.toLowerCase()) !== -1
        );
      });
    },

    filteredCategoryItems() {
      return this.autocompleteCategoryItems.filter((i) => {
        return (
          i.text
            .toLowerCase()
            .indexOf(this.categoryFilterValue.toLowerCase()) !== -1
        );
      });
    },
    filteredPlatformItems() {
      return this.autocompletePlatformItems.filter((i) => {
        return (
          i.text
            .toLowerCase()
            .indexOf(this.platformFilterValue.toLowerCase()) !== -1
        );
      });
    },

    filteredTagItems() {
      return this.autocompleteTagItems.filter((i) => {
        return (
          i.text.toLowerCase().indexOf(this.tagFilterValue.toLowerCase()) !== -1
        );
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
.form-control {
  height: 48px;
}
</style>

