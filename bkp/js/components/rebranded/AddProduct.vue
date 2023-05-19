<template>
  <div>
    <Header />

    <main class="main">
      <!-- Product Add -->
      <section class="section-projectadd">
        <div class="container">
          <header class="projectadd-header">
            <h1>Add new product</h1>
          </header>
          <div class="projectadd-container wblock">
            <div class="projectadd-row">
              <!-- Project Add Thumbnail -->
              <div class="projectadd-media">
                <div class="projectadd-media-heading">
                  <h2>Add product thumbnail</h2>
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
                            name="project-is-cover"
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
                    Drag images here or
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
                  </div>
                </div>

                <div class="form-group project-video-add">
                  <label>Youtube Video Link</label>
                  <input
                    type="text"
                    v-model="link_youtube"
                    placeholder="www.youtube.com/streamgeeks"
                    class="form-control"
                  />
                </div>
                <div class="project-video-item">
                  <iframe
                    :src="`https://www.youtube.com/embed/${getEmbed(
                      this.link_youtube
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
                    <div class="form-group col-md-6">
                      <label>Title</label>
                      <input
                        type="text"
                        class="form-control"
                        placeholder="Write project title"
                        v-model="product_title"
                      />
                    </div>
                    <div class="form-group col-md-6">
                      <label>SKU (Part Number)</label>
                      <input
                        type="text"
                        class="form-control"
                        placeholder="Enter the SKU"
                        v-model="product_sku"
                      />
                    </div>
                    <!-- <div class="form-group col-md-6">
                      <label>Add Video link</label>
                      <input
                        type="text"
                        class="form-control"
                        placeholder="https://"
                      />
                    </div> -->
                  </div>
                  <div class="form-group">
                    <label>Sub title</label>
                    <input
                      type="text"
                      class="form-control"
                      placeholder="Write project subtitle"
                      v-model="project_subtitle"
                    />
                  </div>
                  <div class="form-group">
                    <label>Add category</label>

                    <v-select
                      v-model="searchServiceCategory"
                      label="text"
                      code="id"
                      item-text="text"
                      :options="searchServiceCategories"
                      :clearable="true"
                      :searchable="true"
                      v-on:change="selectCategory()"
                      class="form-control v-select-lg"
                      placeholder="Add Category"
                    ><template #open-indicator="{ attributes }">
                        <span v-bind="attributes">
                          <icon-base
                            width="12"
                            height="6.84"
                            view-box="0 0 12 6.84"
                            icon-name="angle-down"
                          >
                            <icon-triangle-3 />
                          </icon-base>
                        </span> </template
                    ></v-select>
                  </div>
                  <div class="form-group">
                    <label>Add Platforms</label>
                    <vue-tags-input
                      v-model="platformFilterValue"
                      :tags="selectedPlatforms"
                      :autocomplete-items="filteredPlatformItems"
                      :add-only-from-autocomplete="true"
                      placeholder="Add..."
                      @tags-changed="updateVuePlatformsInput"
                      class="advanced-tag"
                    >
                      <template v-slot:autocomplete-item="props">
                        <div
                          @click="selectedPlatforms.push(props.item)"
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
                    <label>Add products</label>
                    <vue-tags-input
                      v-model="productFilterValue"
                      :tags="selectedProducts"
                      :autocomplete-items="filteredProductItems"
                      :add-only-from-autocomplete="true"
                      placeholder="Add..."
                      @tags-changed="updateVueProductsInput"
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
                  <div class="row">
                    <div class="form-group col-md-6">
                      <label>Add Budget</label>
                      <input
                        type="text"
                        class="form-control"
                        placeholder="Add Budget"
                        v-model="project_budget"
                      />
                    </div>
                    <div class="form-group col-md-6">
                      <label>Project Phase</label>
                      <div class="row mx-0 align-items-center justify-content-around"
                           style="color: #5D5D5D; height: 43px; border: 1px solid #DDE0E6; border-radius: 0.25rem">
                        <div class="custom-radio-group">
                          <label class="custom-radio mb-0">
                            <input
                              type="radio"
                              name="project-is-cover"
                            />
                            <span>Planning</span>
                          </label>
                        </div>
                        <div class="custom-radio-group">
                          <label class="custom-radio mb-0">
                            <input
                              type="radio"
                              name="project-is-cover"
                            />
                            <span>In-Progress</span>
                          </label>
                        </div>
                        <div class="custom-radio-group">
                          <label class="custom-radio mb-0">
                            <input
                              type="radio"
                              name="project-is-cover"
                            />
                            <span>Complete</span>
                          </label>
                        </div>
                      </div>
                    </div>
                    <!-- <div class="form-group col-md-6">
                      <label>Add Video link</label>
                      <input
                        type="text"
                        class="form-control"
                        placeholder="https://"
                      />
                    </div> -->
                  </div>
                  <div class="form-group">
                    <label>Tags</label>
                    <div class="btns tag-btns">
                      <label
                        v-for="(tag, index) in filteredTagItems"
                        :key="index"
                        class="btn btn-sm btn-checkbox"
                        :class="tag.checked ? 'btn-primary' : 'btn-light'"
                      >
                        <input
                          type="checkbox"
                          v-model="tag.checked"
                          :value="tag.id"
                          @tags-changed="updateVueTagsInput"
                        />
                        <span>+ {{ tag.text }}</span>
                      </label>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Project Description</label>
                    <textarea
                      v-model="project_desc"
                      rows="4"
                      class="form-control"
                      placeholder="Start writing your description..."
                    ></textarea>
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
                        Drag or
                        <document-upload
                          ref="docFiles"
                          post-action="/post.method"
                          put-action="/put.method"
                          :multiple="true"
                        >browse
                        </document-upload>
                        documents in PDF
                      </div>
                    </div>
                    <div class="file-list">
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

                  <div class="form-group">
                    <label>Add link to website for project</label>
                    <input
                      type="text"
                      class="form-control"
                      v-model="link_url"
                      placeholder="https://www.streamgeeks.com"
                    />
                  </div>
                </div>
              </div>
              <!-- Project Add Content -->
            </div>

            <div class="projectadd-btns">
              <!-- <div class="btns mb-5">
                <button class="btn btn-primary">Next</button>
                <button class="btn btn-outline-primary">Previous</button>
              </div> -->

              <div>
                <!-- <input type="file" @change="uploadFile" ref="file">
                <button @click="submitFile">Upload!</button> -->
              </div>

              <div class="custom-checkbox-group mb-4">
                <label class="custom-checkbox">
                  <input type="checkbox" checked />
                  <span
                  >As Gold Member you can set your new project as
                    featured</span
                  >
                </label>
              </div>
              <div class="btns">
                <button
                  class="btn btn-primary btn-wide"
                  :disabled="isDisabled"
                  @click.prevent="publishProject()"
                >
                  Publish
                </button>
                <button class="btn btn-outline-primary btn-wide">
                  Save as draft
                </button>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- End of Project Add -->
    </main>

    <Footer />
  </div>
</template>

<script>
import VueTagsInput from "@johmun/vue-tags-input";
// import FileUpload from "vue-upload-component";
import Header from "./../common/Header.vue";
import Footer from "./../common/Footer.vue";
import IconBase from "./../common/IconBase.vue";
import IconPencil from "./../common/icons/IconPencil.vue";
import IconAngleDown from "./../common/icons/IconAngleDown.vue";
import IconTrash from "./../common/icons/IconTrash.vue";

import Vue from "vue";
import vSelect from "vue-select";

Vue.component("v-select", vSelect);
import "vue-select/dist/vue-select.css";
import { bus } from "../../app";

const VueUploadComponent = require("vue-upload-component");
Vue.component("file-upload", VueUploadComponent);
Vue.component("document-upload", VueUploadComponent);
var arr_image = [];
var arr_pdf = [];
var arr_image_preview = [];
export default {
  name: "Add Product",
  components: {
    VueTagsInput,
    // FileUpload,
    Header,
    Footer,
    IconBase,
    IconPencil,
    IconAngleDown,
    IconTrash
  },
  data() {
    return {
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
      product_title: "",
      product_sku: "",
      project_budget: "",
      project_desc: "",
      project_skill: "",
      project_subtitle: "",
      tagFilterValue: "",
      tag: [],
      selectedTags: [],
      selectedPlatforms: [],
      selectedProducts: [],
      selectedCategories: [],
      autocompleteTagItems: [],
      autocompleteProductItems: [],
      isDisabledButton: true
    };
  }, // data() {

  watch: {
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

        if (file_arr.file.type != "application/pdf") {
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
      console.log(val);
      this.loadTags(val.id);
    }
  },

  created() {
    document.title = this.$route.meta.title;
  },

  mounted() {
    if (!this.isAuthenticated || !localStorage.getItem("logged_user_id")) {
      this.$toast.error("To open buyer you need to login firstly !");
      this.$router.push({ name: "home" });
    }
    this.logged_user_id = localStorage.getItem("logged_user_id");
    this.loadCategoriesList();
    this.loadPlatformsList();
    // this.loadTags();
    this.loadProducts();
    // this.initDummy();
  }, // mounted() {

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
    selectCategory() {
      console.log("sfsdfsdfsfds");
    },
    
    // uploadFile() {

    //    //  if (typeof this.$refs.file.files[0] === "undefined") return;
    //     let image = new Image();
    //     console.log(image);
    //       image.src = URL.createObjectURL(this.$refs.file.files[0]);
    //       image.onload = function() {
    //        bus.$emit("imageUploadedEvent", this.width, this.height);
    //       };

    //    // arr_image_preview[this.imageFilesCount]['name'] = "sf";
    //     // arr_image_preview[this.imageFilesCount]['blob'] = URL.createObjectURL(this.$refs.file.files[0]);
    //     //     console.log(arr_image_preview);

    //         arr_image[this.imageFilesCount] = this.$refs.file.files[0];
    // console.log( arr_image);

    //         if(this.imageFilesCount !=0){
    //          this.imageFilesCount= this.imageFilesCount+1;
    //         }else{
    //          this.imageFilesCount=1;
    //         }
    //        // console.log(this.Images);
    //       },

    initDummy() {
      // this.selection_category_id = {
      //   id: 3,
      //   text: "Collaboration"
      // };

      this.selection_platform_id = { code: 2, label: this.Epiphan };

      // this.selection_platform_id: null,

      this.project_title = "A";
      this.project_subtitle = "B";
    },

    updateVueProductsInput(newProducts) {
      console.log("updateVueProductsInput newProducts::");
      console.log(newProducts);
      this.selectedProducts = newProducts;
    },
    updateVueCategoriesInput(newCategories) {
      console.log("updateVueCategoriesInput newCategories::");
      console.log(newCategories);
      this.selectedCategories = newCategories;
    },
    updateVuePlatformsInput(newPlatforms) {
      console.log("updateVuePlatformsInput newPlatforms::");
      console.log(newPlatforms);
      this.selectedPlatforms = newPlatforms;
    },

    updateVueTagsInput(newTags) {
      console.log("updateVueTagsInput newTags::");
      console.log(newTags);
      this.selectedTags = newTags;
    },

    async loadPlatformsList() {
      const result = await this.callApi(
        "post",
        window.api_path + "getPlatformsList",
        { mode: "selection" }
      );
      if (result.status != 200) {
        this.$toast.error(result.data.message);
        this.platforms = [];
        return;
      }
      this.platformSelectionItems = result.data.platforms;
      this.autocompletePlatformItems = result.data.platforms;
    }, // async loadPlatformsList() {
    async loadCategoriesList() {
      // console.log(' loadCategoriesList:')
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
      // console.log('result.data::')
      // console.log(result.data)
      this.searchServiceCategories = result.data.categories;
    },
    // async loadCategoriesList() {
    //   // console.log(' loadCategoriesList:')
    //   const result = await this.callApi(
    //     "post",
    //     window.api_path + "getCategoriesList",
    //     { mode: "selection" }
    //   );
    //   if (result.status != 200) {
    //     this.$toast.error(result.data.message);
    //     this.categories = [];
    //     return;
    //   }
    //   // console.log('result.data::')
    //   // console.log(result.data)
    //   this.categorySelectionItems = result.data.categories;
    //  // this.autocompleteCategoryItems = result.data.categories;

    // }, // async loadCategoriesList() {

    async loadTags(category_id) {
      // console.log(' loadTags this.selection_category_id::')
      // console.log(this.selection_category_id)
      const result = await this.callApi(
        "post",
        window.api_path + "getTagsList",
        { mode: "only_title", category_id: category_id }
      );
      if (result.status != 200) {
        this.$toast.error(result.data.message);
        this.autocompleteTagItems = [];
        return;
      }
      // console.log('this.autocompleteTagItems')
      // console.log(this.autocompleteTagItems)
      //
      this.autocompleteTagItems = result.data.tags;
    }, // async loadTags() {

    async loadProducts() {
      // console.log(' loadProducts ::')
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
      // console.log('result.data::')
      // console.log(result.data)
      this.autocompleteProductItems = result.data.products;
    }, // async loadProducts() {

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

    async publishProject(project_id) {
      //  console.log(this.filteredTagItems);
      var arr_tags = [];
      var arr_tags_count = 0;
      for (var i = 0; i < this.filteredTagItems.length; i++) {
        if (this.filteredTagItems[i]["checked"] !== undefined) {
          arr_tags[arr_tags_count] = this.filteredTagItems[i];
          arr_tags_count += 1;
        }
      }
      if (!this.isAuthenticated || !localStorage.getItem("logged_user_id")) {
        this.$toast.error("To publish project you need to login firstly !");
        return;
      }
      //console.log("this.selection_category_id::");
      //console.log(this.selectedTags);

      if (this.project_title == "") {
        this.$toast.error("Please enter project title");
        return;
      }
      if (this.project_subtitle == "") {
        this.$toast.error("Please enter project subtitle");
        return;
      }
      if (this.searchServiceCategory === null) {
        this.$toast.error("Please select category");
        return;
      }
      if (this.selectedPlatforms === null) {
        this.$toast.error("Please select platform");
        return;
      }
      if (this.project_budget == "") {
        this.$toast.error("Please enter project budget");
        return;
      }
      if (this.project_desc == "") {
        this.$toast.error("Please enter project descrption");
        return;
      }
      if (this.selectedProducts == "") {
        this.$toast.error("Please enter project product");
        return;
      }

      const formData = new FormData();
      formData.append("user_id", localStorage.getItem("logged_user_id"));
      formData.append("title", this.project_title);
      formData.append("subtitle", this.project_subtitle);
      formData.append("category", JSON.stringify(this.searchServiceCategory)); //this.selection_category_id.code);
      formData.append("platform", JSON.stringify(this.selectedPlatforms)); // this.selection_platform_id.code);
      formData.append("products", JSON.stringify(this.selectedProducts));
      formData.append("tags", JSON.stringify(arr_tags));
      formData.append("project_budget", this.project_budget);
      formData.append("project_desc", this.project_desc);
      formData.append("project_skill", this.project_skill);
      formData.append("image_files_count", this.imageFilesCount);
      formData.append("pdf_files_count", this.pdfFilesCount);
      formData.append("link_url", this.link_url);
      formData.append("link_youtube", this.link_youtube);
      formData.append("fixed_payment", this.fixed_payment);

      formData.append("hour_rate", this.hour_rate);
      formData.append("weekly_limit", this.weekly_limit);
      formData.append("fixed_due_date", this.fixed_due_date);

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
      console.log(arr_pdf);
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
      const headers = { "Content-Type": "multipart/form-data" };
      axios
        .post(window.api_path + "publishProject", formData, { headers })
        .then((res) => {
          let self = this;
          if (res.status == 200 && res.data.slug != "") {
            self.$toast.success(res.data.message);

            //this.$router.push({ name: "dashboard" });
            this.$router.push("/project/" + res.data.slug);
          } else {
            this.$toast.error(res.data.message);
          }

          // res.data.files; // binary representation of the file
          // res.status; // HTTP status
        });
    } // async publishProject(project_id) {
  },
  computed: {
    isDisabled: function () {
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
