<template>
  <div>
    <Header />
    <main class="main">
      <!-- Brand Add -->
      <section class="section-systemadd">
        <div class="container">
          <FormulateForm
            @submit="updateBrand"
          >
          <div class="projectadd-container wblock">
            <header class="projectadd-header">
              <h1>Edit Brand</h1>
            </header>
            <div class="projectadd-row">
              <!-- Brand Add Thumbnail -->
              <div class="projectadd-media">
                <div class="projectadd-media-heading">
                  <h2>Product thumbnail</h2>
                  <span class="projectadd-media-info"
                  >Up to {{ max_upload_files }}</span
                  >
                </div>
                <!--                selectedCoverImage:{{ selectedCoverImage }}<br>-->
                <!--                max_upload_files:{{ max_upload_files }}<br>-->
                <!--                imageFiles.length::{{ imageFiles.length}}<br>-->
                <!--                imageFiles::{{ imageFiles}}<br>-->

                <div class="projectadd-media-items">
                  <div
                    class="projectadd-media-item"
                    v-for="(brandImage, val) in brandImage"
                    :key="brandImage.filename"
                  >
                    <div class="item-img" v-if="brandImage.filename">
                      <img
                        :src="
                          brandImage.filename
                        "
                        alt=""
                        class="rounded"
                      />
                      <div class="btns">
                        <button
                          class="btn btn-white-icon-rounded"
                          type="button"
                          @click="
                            deleteBrandImage(
                              brandImage.id,
                              brandImage.brand_id,
                            val
                            )
                          "
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
                          v-model="brandImage.info"
                          v-bind:id="brandImage.name + '_caption'"
                        />
                      </div>
                    </div>
                    <div class="item-is-cover">
                      <div class="custom-radio-group">
                        <label class="custom-radio">
                          <input
                            type="radio"
                            :name="'project-is-cover-'+val"
                           
                            :value="val+1"
                            :checked="brandImage.is_main == 1"
                            v-bind:id="brandImage.filename + '_ismain'"
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
                      <img :src="nextFile.blob" alt="" class="rounded" />
                      <div class="btns">
                        <!-- <button class="btn btn-white-icon-rounded">
                          <icon-base
                            width="12.53"
                            height="14"
                            view-box="0 0 12.53 14"
                            icon-name="pencil"
                          >
                            <icon-pencil />
                          </icon-base>
                        </button> -->
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
                            :name="'brand-is-cover-'+index"
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

                <div v-show="brandImage.length + imageFiles.length >= max_upload_files">
                  <div class="">You reached maximum of files</div>
                </div>

                <div
                  v-show="brandImage.length + imageFiles.length < max_upload_files"
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
                      :maximum="5 - brandImage.length"
                      :thread="5 - brandImage.length"
                      :multiple="true"
                      @input-filter="inputFilter"
                    >browse
                    </file-upload>
                    your image to upload
                  </div>
                </div>

                <div class="form-group brand-video-add">
                  <label>Add Youtube Video Link</label>
                  <input
                    type="text"
                    v-model="youtube_url"
                    placeholder="www.youtube.com/streamgeeks"
                    class="form-control"
                    ref="youtube_url"
                  />
                </div>
                <div class="brand-video-item" v-if="youtube_url != null && youtube_url != '' && youtube_url != 'null'">
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
              <!-- End of Brand Add Thumbnail -->

              <!-- Brand Add Content -->
              <div class="projectadd-content">
                <div class="projectadd-form">
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group">
                        <label>Brand Name</label>
                        <FormulateInput
                          type="text"
                          input-class="form-control"
                          validation="required"
                          placeholder="Enter brand name"
                          v-model="brandName"
                          ref="brandName"
                        />
                      </div>
                      <div class="form-group">
                        <label>Brand Website</label>
                        <FormulateInput
                          type="text"
                          input-class="form-control"
                          placeholder="Enter brand website"
                          validation="required"
                          v-model="brandWebsite"
                        />
                      </div>
                    </div>
                    <div class="col-6 pl-4">
                      <div class="form-group">
                        <label>Brand Logo</label>
                        <div
                          v-if="Object.keys(brandLogoUploaded).length == 0 && brandLogo.length == 0"
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
                          v-else-if="brandLogo.length != 0 && Object.keys(brandLogoUploaded).length == 0"
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
                        <div
                          v-else-if="brandLogoUploaded"
                          class="projectadd-media-item"
                        >
                          <div class="item-img" v-if="brandLogoUploaded.filename">
                            <img :src="brandLogoUploaded.filename" alt="">
                              <div class="btns">
                                  <button
                                    class="btn btn-white-icon-rounded"
                                    type="button"
                                    @click="
                                    deleteBrandImage(
                                      brandLogoUploaded.id,
                                      brandLogoUploaded.brand_id,
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
                    <label>Category</label>
                    <v-select
                      v-model="searchServiceCategory"
                      label="text"
                      code="id"
                      item-text="text"
                      :options="searchServiceCategories"
                      :clearable="false"
                      class="form-control v-select-light"
                      placeholder="Select Category"
                    >
                      <template #open-indicator="{ attributes }">
                        <span v-bind="attributes">
                          <icon-base
                            width="12"
                            height="6.84"
                            view-box="0 0 12 6.84"
                            icon-name="angle-down"
                          >
                            <IconAngleDown />
                          </icon-base>
                        </span></template
                      >
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
                      @tags-changed="newTags => selectedProjects = newTags"

                    >
                      <template v-slot:autocomplete-item="props">
                        <div
                          @click="selectProduct(props.item)"
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
                          input-class="form-control"
                          validation="required"
                          placeholder="Enter facebook page"
                          v-model="facebookPage"
                        />
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group">
                        <label>YouTube Page</label>
                        <FormulateInput
                          type="text"
                          input-class="form-control"
                          validation="required"
                          placeholder="Enter youtube page"
                          v-model="youtubePage"
                        />
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>About the Brand</label>
                    <FormulateInput
                      type="textarea"
                      v-model="brand_desc"
                      rows="4"
                      input-class="form-control"
                      validation="required"
                      placeholder="Enter brand description"
                    ></FormulateInput>
                  </div>
                  <div class="form-group">
                    <label>Add Associated Documents</label>
                    <div
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
                        v-for="(nextFilePdf, index) in brandPdf"
                        :key="index"
                      >
                        <div class="file-w">
                          <img :src="`${publicPath}pdf.png`" alt="" />
                          <div class="btns">
                            <button class="btn btn-white-icon-rounded btn-sm">
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
                          v-model="nextFilePdf.info"
                          class="form-control form-control-sm"
                          placeholder="Enter caption"
                        />
                      </div>
                      <div
                        class="file-item"
                        v-for="nextFilePdf in imageFiles"
                        :key="nextFilePdf"
                        v-if="nextFilePdf.type == 'application/pdf'"
                      >
                        <div class="file-w">
                          <img :src="`${publicPath}pdf.png`" alt="" />
                          <div class="btns">
                            <button class="btn btn-white-icon-rounded btn-sm">
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
                  <div class="projectadd-btns pt-0">
                    <div class="btns">
                      <FormulateInput
                        type="submit"
                        input-class="btn btn-primary btn-wide"
                        :disabled="!isLoading"
                      >
                        Edit Brand
                      </FormulateInput>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Brand Add Content -->
            </div>

          </div>
          </FormulateForm>
        </div>
      </section>
      <!-- End of Brand Add -->
    </main>

    <Footer />
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
import { bus } from "../app";

const VueUploadComponent = require("vue-upload-component");
Vue.component("file-upload", VueUploadComponent);
Vue.component("document-upload", VueUploadComponent);
var arr_image = [];
var arr_pdf = [];
var arr_image_preview = [];
var brand_logo = [];
const TOKEN = localStorage.getItem("sgtoken")
  const headers = {
    "Content-Type": "multipart/form-data",
    Authorization: `Bearer ${TOKEN}`
  };
export default {
  name: "Add Brand",
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
      brandId: null,
      brandLogo: [],
      brandLogoUploaded: [],
      brandImage: [],
      brandPdf: [],
      facebookPage: null,
      youtubePage: null,
      brandName: null,
      brandWebsite: null,
      companyLocation: null,
      selectedProducts: [],
      isLoading: false,
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
      web_url: null,
      youtube_url: null,
      imageFiles: [],
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
      brand_name: "",
      project_budget: "",
      project_stage: "",
      brand_desc: "",
      project_skill: "",
      project_subtitle: "",
      tagFilterValue: "",
      tag: [],
      selectedTags: [],
      selectedPlatforms: [],
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
      integrationCompany: ""
    };
  }, // data() {

  watch: {
    brandLogo(theFile) {
      theFile.forEach((file_arr, key) => {
        let image = new Image()
        image.src = file_arr.blob
        image.onload = function () {
          bus.$emit("imageUploadedEvent", this.width, this.height)
        }
        brand_logo[0] = file_arr.file
      })
    },
    imageFiles(theFile) {
      if (typeof theFile[0] === "undefined") return;
      var arr_image_count = 0;
      var arr_pdf_count = 0;
      arr_pdf = [];
      arr_image = [];
      theFile.forEach((file_arr, key) => {
        // console.log(file_arr);
        if (file_arr.file.type == "application/pdf") {
          arr_pdf[arr_pdf_count] = file_arr.file;
          arr_pdf_count += 1;
          this.pdfFilesCount = arr_pdf_count;
        }

        if (file_arr.file.type != "application/pdf") {
          let image = new Image();
          image.src = file_arr.blob;
          image.onload = function() {
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
    // searchServiceCategory(val) {
    //   this.loadTags(val.id);
    // }
  },

  created() {
    document.title = this.$route.meta.title;
    if (!this.isAuthenticated || !localStorage.getItem("logged_user_id")) {
      this.$toast.error("You need to authorize in order to access this page");
      this.$router.push({ name: "home" });
    }
    this.logged_user_id = localStorage.getItem("logged_user_id");
    this.loadProducts();
    this.loadCategoriesList();
    this.loadBrand();
    this.getUser();
  },

  methods: {
   
    async loadBrand () {
      const res = await this.callApi(
        "get",
        window.api_path + "brand/" + this.$route.params.slug + "/details/" + this.logged_user_id,
        {}
      )
      if (res.status !== 200) {
        this.$toast.error(res.data.message)
        return
      }
      const { brand, brand_image, brand_image_logo, brand_pdf, brand_products } = res.data.data
      const b = brand || {}
      this.brandId = b.id
      this.brandName = b.name || ''
      this.brand_desc = b.desc || ''
      this.brandWebsite = b.web_url || ''
      this.youtube_url = b.youtube_url !== 'null' ? b.youtube_url : null
      this.facebookPage = b.facebook_url !== 'null' ? b.facebook_url : null
      this.youtubePage = b.youtube_url !== 'null' ? b.youtube_url : null
      this.brandImage = brand_image || []
      this.brandLogoUploaded = brand_image_logo || []
      this.brandPdf = brand_pdf || []

      this.searchServiceCategory = b.category_name ? {id: b.category_name.category_id, text:b.category_name.title} : ''
      if (brand_products.length) {
        this.selectedProducts = brand_products.map(brand => {
          return {
            text: brand.name,
            id: brand.product_category,
            description: brand.desc,
            qty: 1
          }
        })
      }
    },
   
    selectProduct(product) {
      this.selectedProducts.push(product);
      this.productFilterValue = "";
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
    deletePrimayImage (key){
      delete this.brandLogo[key]
      this.brandLogo =  []; 
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
        this.isSeller = true;
      }
    },
    async delete_image(idx) {
      console.log(idx);
      // this.imageFiles.splice(idx, 1);
    },
    deleteBrandImage(imageId, brandId, key, type="thumbnail") {
      const data = new FormData();
      data.append("brand_id", brandId);
      data.append("id", imageId);
      axios.post(window.api_path + "brand/deletebrandimage", data, { headers })
        .then((res) => {
          if (res.status == 200) {
              this.$toast.success(res.data.message);
              if(type == "thumbnail"){
                delete this.brandImage[key]
                this.brandImage = {...this.brandImage}; 
              }else if(type == "logo"){
                  this.brandLogoUploaded = [];
              }
            return;
          }
          this.$toast.error('Error occurred. Please try again later');
        });

     
      // this.imageFiles.splice(idx, 1);
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
      // console.log("sfsdfsdfsfds");
    },

    inputFile(newFile, oldFile) {
      if (newFile && oldFile && !newFile.active && oldFile.active) {
        if (newFile.xhr) {
          // console.log("statusaa", newFile.xhr.status);
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
          // console.log(newFile.file);
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
    async updateBrand () {
      const regesYoutube = /^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
      if (!this.isAuthenticated || !localStorage.getItem("logged_user_id")) {
        this.$toast.error("To edit brand you need to login firstly!");
        return;
      }

      if (this.brandName == null) {
        this.$toast.error("Please enter the brand name");
        this.$refs.brandName.focus()
        return;
      }else if (this.brandName.length < 2 || this.brandName.length >= 55) {
        this.$toast.error("Please enter minimum 2 and maximum 55 characters in brand name");
        this.$refs.brandName.focus()
        return;
      }

      if (this.youtube_url != "" && this.youtube_url != null && !this.youtube_url.match(regesYoutube)) {
        this.$toast.error("Please enter valid youtube url link");
        this.$refs.youtube_url.focus();
        return;
      }
      const data = new FormData();
      data.append("id", this.brandId);
      data.append("name", this.brandName);
      data.append("brand_desc", this.brand_desc);
      data.append("web_url", this.brandWebsite);
      data.append("youtube_url", this.youtube_url);
      data.append("facebook_url", this.facebookPage);
      data.append("user_id", localStorage.getItem("logged_user_id"));
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
        if (arr_pdf[i]) {
          data.append("file_pdf_" + i, arr_pdf[i]);
          data.append(
            "file_pdf_caption_" + i,
            document.getElementById(arr_pdf[i].name).value
          );
        }
      }
   
      this.isLoading = true
      axios.post(window.api_path + "brand/updatebrand", data, { headers })
        .then((res) => {
          this.isLoading = false
          if (res.status == 200) {
             if (res.data.code == 0) {
                this.$toast.error(res.data.message)
                return
              }
            this.$toast.success(res.data.message);
            this.$router.push({ name: 'Brand Page', params: { slug: res.data.data.slug }})
            return;
          }
          this.$toast.error('Error occurred. Please try again later');
        });
    }
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
  }, 
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