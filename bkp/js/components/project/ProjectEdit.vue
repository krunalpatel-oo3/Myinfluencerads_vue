<template>
  <div>
    <Header />

    <main class="main">
      <!-- Project Add -->
      <section class="section-systemadd">
        <div class="container">
          
          <div class="projectadd-container wblock">
            <header class="projectadd-header">
            <h1>Edit Project</h1>
          </header>
            <div class="projectadd-row">
              <div class="projectadd-media">
                <div class="projectadd-media-heading">
                  <h2>Edit Project thumbnail</h2>
                  <span class="projectadd-media-info"
                    >Up to {{ max_upload_files }}</span
                  >
                </div>
                <div class="projectadd-media-items">
                  <div
                    v-if="projectImage.length > 0"
                    class="projectadd-media-item"
                    v-for="(projectImage_item, val) in projectImage"
                    :key="val"
                  >
                    <div class="item-img" v-if="projectImage_item.filename">
                      <img
                        :src="projectImage_item.filename"
                        alt=""
                        class="rounded"
                      />
                      <div class="btns">
                        <button class="btn btn-white-icon-rounded" @click="deleteProjectImage(projectImage_item.id, projectImage_item.project_id, val)">
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
                          v-model="projectImage_item.info"
                          v-bind:id="projectImage_item.filename + '_caption'"
                        />
                      </div>
                    </div>
                    <div class="item-is-cover">
                      <div class="custom-radio-group">
                        <label class="custom-radio">
                          <input
                            type="radio"
                            :name="'project-is-cover-'+val"
                            v-model="selectedCoverImage"
                            :value="val + 1"
                            :checked="projectImage_item.is_main == 1"
                            v-bind:id="projectImage_item.filename + '_ismain'"
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
                        <button class="btn btn-white-icon-rounded" @click="delete_new_image(nextFile.id)">
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
                            :name="'project-is-cover-'+projectImage.length + 2 "
                            :value="projectImage.length + 2"
                            v-model="selectedCoverImage"
                            v-bind:id="nextFile.name + '_ismain'"
                          />
                          <span>Cover Image</span>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- <div class="projectadd-media-items"> -->

                <div v-show="imageFiles.length + projectImage.length >= max_upload_files">
                  <div class="">You reached maximum of files</div>
                </div>

                <div
                  v-show="imageFiles.length + projectImage.length < max_upload_files"
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
                      @input-file="inputFile"
                      :multiple="true"
                      :maximum="5 - projectImage.length"
                      :thread="5 - projectImage.length"
                      @input-filter="inputFilter"
                      >browse</file-upload
                    >
                    your image to upload
                  </div>
                </div>

                <div class="form-group project-video-add">
                  <label>Youtube Video Link</label>
                  <input
                    type="text"
                    v-model="projectData.link_youtube"
                    placeholder="www.youtube.com/streamgeeks"
                    class="form-control"
                    ref="link_youtube"
                  />
                </div>
                <div class="project-video-item"  v-if="projectData.link_youtube !== 'null' && projectData.link_youtube != null && projectData.link_youtube != ''">
                  <iframe
                    :src="`https://www.youtube.com/embed/${getEmbed(projectData.link_youtube)}`"
                    title="YouTube video player"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen
                  ></iframe>
                </div>
                <div class="add-project-video-btn custom-line-items border-0 text-center">
                  <button class="add-btn" @click="addYoutubeLink">
                    <AddIcon/>
                  </button>
                  <p class="add-btn-text">
                    Add YouTube Video
                  </p>
                </div>
              </div>
              <!-- End of Project Add Thumbnail -->

              <!-- Project Add Content -->
              <div class="projectadd-content">
                <div class="projectadd-form">
                  <div class="form-group">
                    <label>System Name</label>
                    <input
                      type="text"
                      class="form-control"
                      placeholder="Enter system name"
                      v-model="projectData.name"
                    />
                  </div>
                  <div class="form-group">
                    <label>Short Description</label>
                    <input
                      type="text"
                      class="form-control"
                      placeholder="Enter short description"
                      v-model="projectData.short_desc"
                    />
                  </div>
                  <div class="form-group">
                    <label>Category</label>
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
                      placeholder="Select Category"
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
                    <label>Products</label>
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
                  <div class="form-group">
                    <label>Custom Line Items</label>
                    <div class="custom-line-items">
                      <div class="row mx-0">
                        <div class="form-group col-md-3 mb-2">
                          <label>Item Name</label>
                          <input type="text" v-model="custom_name" placeholder="Enter name" class="form-control">
                        </div>
                        <div class="form-group col-md-6 mb-2">
                          <label>Description</label>
                          <input type="text" v-model="custom_description" placeholder="Enter description"
                                 class="form-control">
                        </div>
                        <div class="form-group col-md-3 mb-2">
                          <label>Brand</label>
                          <input type="text" v-model="custom_brand" placeholder="Enter brand" class="form-control">
                        </div>
                      </div>
                      <div class="row mx-0">
                        <div class="form-group col-md-4 mb-0">
                          <label>Price</label>
                          <input type="number" v-model="custom_price" placeholder="Enter price" class="form-control">
                        </div>
                        <div class="col-md-7 form-group mb-0">
                          <label>Link</label>
                          <input type="text" v-model="custom_link" placeholder="Enter link" class="form-control">
                        </div>
                        <div class="col-md-1 d-flex justify-content-end align-items-end pb-1">
                          <button class="add-btn" @click.prevent="customLineItem()">
                            <AddIcon/>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Part List</label>
                    <div class="part-list-wrapper">
                      <table class="part-list">
                        <thead>
                          <tr style="border-bottom: 1px solid #DDE0E6">
                            <th class="py-1" style="padding-left: 50px">QTY</th>
                            <th class="py-1">Product Name</th>
                            <th class="py-1">Description</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="(product,key) in selectedProducts" :key="key">
                            <td class="flex" style="padding-left: 27px">
                              <button class="qty-btn" @click="decrementQtyProd(key)">-</button>
                              <span style="margin: 0 7px">{{ product.qty ? product.qty : 1 }}</span>
                              <button class="qty-btn" @click="incrementQtyProd(key)">+</button>
                            </td>
                            <td><img
                              :src="`${publicPath}camera_360.png`"
                              alt=""
                              class="rounded-circle width-32 mr-2"
                            />{{ product.text.substring(0, 20) }}
                            </td>
                            <td class="t-color8">{{ product.description.substring(0, 20) }}</td>
                            <td class="pr-3">
                              <button class="bg-transparent border-0" @click="delete_product(key)">
                                <TrashCanIcon/>
                              </button>
                            </td>
                          </tr>
                          <tr v-for="(custom_line_item,key) in custom_line_items" :key="key">
                            <td class="flex" style="padding-left: 27px">
                              <button class="qty-btn" @click="decrementQtyCustom(key)">-</button>
                              <span style="margin: 0 7px">{{ custom_line_item.qty }}</span>
                              <button class="qty-btn" @click="incrementQtyCustom(key)">+</button>
                            </td>
                            <td><img
                              :src="`${publicPath}camera_360.png`"
                              alt=""
                              class="rounded-circle width-32 mr-2"
                            />{{ custom_line_item.name }}
                            </td>
                            <td class="t-color8">{{ custom_line_item.description }}</td>
                            <td class="pr-3">
                              <button class="bg-transparent border-0" @click="delete_custom_item(key)">
                                <TrashCanIcon/>
                              </button>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-6">
                      <label>Budget (Estimation)</label>
                      <input
                        type="number"
                        class="form-control"
                        placeholder="Add budget"
                        v-model="projectData.estimated_budget"
                      />
                    </div>
                    <div class="form-group col-md-6">
                      <label>Project Phase</label>
                      <div class="row mx-0 align-items-center justify-content-around"
                           style="color: #5D5D5D; height: 43px; border-radius: 0.25rem">
                        <div class="custom-radio-group">
                          <label class="custom-radio mb-0">
                            <input
                              type="radio"
                              name="project-is-cover"
                              v-model="projectData.project_phase" value="P"
                            />
                            <span>Planning</span>
                          </label>
                        </div>
                        <div class="custom-radio-group">
                          <label class="custom-radio mb-0">
                            <input
                              type="radio"
                              name="project-is-cover"
                              v-model="projectData.project_phase" value="IP"
                            />
                            <span>In-Progress</span>
                          </label>
                        </div>
                        <div class="custom-radio-group">
                          <label class="custom-radio mb-0">
                            <input
                              type="radio"
                              name="project-is-cover"
                              v-model="projectData.project_phase" value="C"
                            />
                            <span>Complete</span>
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Tags</label>
                    <div class="btns tag-btns">
                      <label
                        v-for="(tag, index) in filteredTagItems"
                        :key="index"
                        class="btn btn-sm btn-checkbox"
                        :class="selectedProjectTags.length > 0 && selectedProjectTags.includes(tag.id) ? 'btn-primary' : 'btn-light'"
                      >
                        <!-- :class="tag.checked ? 'btn-primary' : 'btn-light'" -->
                        <input
                          type="checkbox"
                          v-model="tag.checked"
                          :value="tag.id"
                          :checked="selectedProjectTags.length > 0 && selectedProjectTags.includes(tag.id) ? true : false"
                          @tags-changed="updateVueTagsInput"
                        />
                        <span>+ {{ tag.text }}</span>
                      </label>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Project Description</label>
                    <VueEditor v-model="projectData.desc" />
                  </div>

                  <div class="form-group">
                    <div class="accordion theme-accordian" id="accordionExample">
                      <div class="mb-3">
                        <div id="headingOne" class="theme-acco-heading">
                          <h2 class="mb-3 ">
                            <button class="btn btn-link btn-block text-left collapsed acc-btn" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                              <label>
                                Project Goals
                              </label>
                            </button>
                          </h2>
                        </div>
                        <div id="collapseOne" class="collapse">
                          <div>
                            <VueEditor v-model="projectData.project_goals" ref='project_goals'/>
                          </div>
                        </div>
                      </div>
                      <div class="mb-3">
                        <div id="headingTwo" class="theme-acco-heading">
                          <h2 class="mb-3">
                            <button class="btn btn-link btn-block text-left collapsed acc-btn" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                              <label>Service/ Upgrade Requests</label>
                             
                            </button>
                          </h2>
                        </div>
                        <div id="collapseTwo" class="collapse">
                          <div>
                            <VueEditor v-model="projectData.service_upgrade_request" ref='service_upgrade_request'/>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label>Associated Documents</label>
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
                        <!-- <document-upload
                          ref="docFiles"
                          post-action="/post.method"
                          put-action="/put.method"
                          :multiple="true"
                          >browse
                        </document-upload> -->
                        <file-upload 
                          :extensions="['pdf']" 
                          input-id="files2" 
                          :value="files2" 
                          @input="updatetValue"
                          :multiple="true">browse
                        </file-upload>
                        your documents in PDF to upload
                      </div>
                    </div>
                    <div class="file-list">
                      <div
                        class="file-item"
                        v-for="(projectPdf_item, ind) in projectPdf"
                        :key="ind"
                      >
                        <div class="file-w">
                          <img :src="`${publicPath}pdf.png`" alt="" />
                          <div class="btns">
                            <button
                              class="btn btn-white-icon-rounded btn-sm"
                              @click="
                                delete_image(
                                  projectPdf_item.id,
                                  projectPdf_item.project_id
                                )
                              "
                            >
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
                          v-bind:id="projectPdf_item.info"
                          class="form-control form-control-sm"
                          placeholder="Enter caption"
                          v-model="projectPdf_item.info"
                        />
                      </div>
                    </div>

                    <div class="file-list">
                      <div
                        class="file-item"
                        v-for="nextFilePdf in files2"
                        :key="nextFilePdf"
                        v-if="nextFilePdf.type == 'application/pdf'"
                      >
                        <div class="file-w">
                          <img :src="`${publicPath}pdf.png`" alt="" />
                          <div class="btns">
                            <button class="btn btn-white-icon-rounded btn-sm"  @click="delete_pdf(nextFilePdf.id)">
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
                    <label>Project Website Link</label>
                    <input
                      type="text"
                      class="form-control"
                      v-model="projectData.link_url"
                      placeholder="https://www.streamgeeks.com"
                    />
                  </div>
                </div>
                <div class="projectadd-btns">
                  <div class="custom-checkbox-group mb-4">
                    <label class="custom-checkbox">
                      <input type="checkbox" checked v-model="projectData.featured"/>
                      <span>As a Pro Member you can set your new project as featured</span>
                    </label>
                  </div>
                  <div class="btns">
                    <button
                      class="btn btn-primary btn-wide"
                      @click.prevent="publishProject()"
                      :disabled="isDisabled"
                    >
                      Update
                    </button>
                    <!-- <button class="btn btn-outline-primary btn-wide">
                      Save as draft
                    </button> -->
                  </div>
                </div>
              </div>
              <!-- Project Add Content -->
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
import { VueEditor } from "vue2-editor";
import Header from "./../common/Header.vue";
import Footer from "./../common/Footer.vue";
import IconBase from "./../common/IconBase.vue";
import IconPencil from "./../common/icons/IconPencil.vue";
import IconAngleDown from "./../common/icons/IconAngleDown.vue";
import IconTrash from "./../common/icons/IconTrash.vue";
import AddIcon from "../rebranded/icons/AddIcon.vue";
import TrashCanIcon from "../rebranded/icons/TrashCanIcon";

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
const TOKEN = localStorage.getItem("sgtoken")
  const headers = {
    "Content-Type": "multipart/form-data",
    Authorization: `Bearer ${TOKEN}`
  };
export default {
  name: "ProjectEdit",
  components: {
    VueTagsInput,
    // FileUpload,
    Header,
    Footer,
    IconBase,
    IconPencil,
    IconAngleDown,
    IconTrash,
    VueEditor,
    AddIcon,
    TrashCanIcon
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
      searchServiceCategory: [],
      searchServiceCategories: [],
      platformSelectionItems: [],
      selection_platform_id: null,
      Epiphan: null,
      link_url:'',
      link_youtube: '',
      imageFiles: [],
      imageFilesPreview: [],
      imageFilesCount: 0,
      pdfFiles: [],
      pdfFilesCount: 0,
      caption_pdf: [],
      caption_image: [],
      selectedCoverImage: 2,
      productFilterValue: "",
      categoryFilterValue: "",
      platformFilterValue: "",
      project_title: "",
      project_budget: "",
      project_stage: "",
      project_desc: "",
      project_goals: "",
      service_upgrade_request: "",
      project_skill: "",
      project_subtitle: "",
      tagFilterValue: "",
      tag: [],
      selectedTags: [],
      selectedProducts: [],
      selectedCategories: [],
      autocompleteTagItems: [],
      autocompleteProductItems: [],
      projectData: "",
      project_slug: "",
      projectImage: "",
      projectPdf: "",
      isDisabledButton: true,
      custom_name: "",
      custom_description: "",
      custom_brand: "",
      custom_price: "",
      custom_link: "",
      custom_line_item: [],
      custom_line_items: [],
      items_qty: [],
      item_count: 0,
      isPro: false,
      userprofile: null,
      isFeatured: false,
      files2: [],
      selectedProjectTags: [],
    };
  },

  watch: {
    imageFiles(theFile) {
      if (typeof theFile[0] === "undefined") return;
      var arr_image_count = 0;
      var arr_pdf_count = 0;
      arr_pdf = [];
      arr_image = [];
      theFile.forEach((file_arr, key) => {
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
          arr_image[arr_image_count] = file_arr.file;
          arr_image_count += 1;

          this.imageFilesCount = arr_image_count;
        }
    
      });
    },
    searchServiceCategory(val) {
      console.log(val);
      this.loadTags(val.id);
    }
  },

  created() {
    document.title = this.$route.meta.title;
    this.project_slug = this.$route.params.slug;
  },

  mounted() {
    this.scrollToTop();
    if (!this.isAuthenticated || !localStorage.getItem("logged_user_id")) {
      this.$toast.error("You need to login firstly!");
      this.$router.push({ name: "home" });
    }
    this.logged_user_id = localStorage.getItem("logged_user_id");
    this.loadCategoriesList();
    this.loadProducts();
    this.loadProjectData();
    this.getUser()
  },

  methods: {
    scrollToTop() {
      window.scrollTo(0,0);
    },
    addYoutubeLink(){
      this.$refs.link_youtube.focus();
    },
    updatetValue(value) {
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
      this.files2 = value
    },
    async getUser () {
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
      if (this.userprofile.User.user_type == "seller") {
        this.isPro = true;
      }
    },
    incrementQtyCustom (id) {
      this.custom_line_items[id].qty++
      this.$forceUpdate()
    },
    incrementQtyProd (id) {
      if(typeof this.selectedProducts[id].qty == "undefined"){
          this.selectedProducts[id].qty = 1;
      }
      this.selectedProducts[id].qty++
      this.$forceUpdate()
    },
    decrementQtyCustom (id) {
      if (this.custom_line_items[id].qty <= 1) return
      this.custom_line_items[id].qty--
      this.$forceUpdate()
    },
    decrementQtyProd (id) {
      if(typeof this.selectedProducts[id].qty == "undefined"){
          this.selectedProducts[id].qty = 1;
      }
      if (this.selectedProducts[id].qty <= 1) return
      this.selectedProducts[id].qty--
      this.$forceUpdate()
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
    delete_custom_item(idx) {
      this.custom_line_items.splice(idx, 1);
    },

    delete_product(idx) {
      this.selectedProducts.splice(idx, 1);
    },

    initDummy() {

      this.selection_platform_id = { code: 2, label: this.Epiphan };

      // this.selection_platform_id: null,

      this.project_title = "A";
      this.project_subtitle = "B";
    },

    async loadProjectData() {
      this.isLoading = true;
      const result = await this.callApi(
        "get",
        window.api_path +
          "project/" +
          this.project_slug +
          "/details/" +
          this.logged_user_id,
        {}
      );
     
      if (result.status != 200) {
        this.isLoading = false;
        this.$toast.error(result.data.message);
        this.projectData = null;
        return;
      }
      const {project, project_image, project_pdf, project_custom_lines, project_tags} = result.data.data;

      this.isLoading = false;
      for (let key in project) {
        if (project[key] === 'null') {
            project[key] = null
        }
      }
      this.projectData = project;
      this.category_id = project.category_id;
      this.projectImage = project_image;
      this.projectPdf = project_pdf;
      this.searchServiceCategory =  project.categoryselect;
      // this.selectedPlatforms = project.platformselect;
      this.selectedProducts = project.productselect;
      this.custom_line_items = project_custom_lines;
      this.selectedProjectTags = project_tags;
    },
    async loadProjectTags(project_id) {
      const result = await this.callApi(
        "get",
        window.api_path + "project/" + project_id + "/getTags",
        {}
      );
      if (result.status != 200) {
        this.$toast.error(result.data.message);
        this.projectTags = [];
        return;
      }

      this.projectTags = result.data.projectTags;
    },
    async loadProjectProduct(project_id) {
      const result = await this.callApi(
        "get",
        window.api_path + "project/" + project_id + "/getProducts",
        {}
      );
      if (result.status != 200) {
        this.$toast.error(result.data.message);
        this.projectProducts = [];
        return;
      }
      this.projectProducts = result.data.projectProducts;
    },

    updateVueProductsInput(newProducts) {
      this.selectedProducts = newProducts;
    },
    updateVueCategoriesInput(newCategories) {
      this.selectedCategories = newCategories;
    },
    updateVueTagsInput(newTags) {
      this.selectedTags = newTags;
    },
     async customLineItem() {
      const regexCustomLinkURL = RegExp('(https?:\\/\\/)?((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|((\\d{1,3}\\.){3}\\d{1,3}))(\\:\\d+)?(\\/[-a-z\\d%_.~+@]*)*(\\?[;&a-z\\d%_.~+=-@]*)?(\\#[-a-z\\d_@]*)?$', 'i');
      if (this.custom_name.trim() === "") {
        this.$toast.error("Please enter custom line item name");
        this.$refs.custom_name.focus()
        return;
      }else if (this.custom_name.length < 2 || this.custom_name.length >= 55) {
        this.$toast.error("Please enter minimum 2 and maximum 55 characters in custom line item name");
        this.$refs.custom_name.focus()
        return;
      }

      if (this.custom_description.trim() === "") {
        this.$toast.error("Please enter custom line description");
        this.$refs.custom_description.focus()
        return;
      }

      if (this.custom_brand.trim() === "") {
        this.$toast.error("Please enter custom line brand");
        this.$refs.custom_brand.focus()
        return;
      }else if (this.custom_brand.length < 2 || this.custom_brand.length >= 55) {
        this.$toast.error("Please enter minimum 2 and maximum 55 characters in custom line brand");
        this.$refs.custom_brand.focus()
        return;
      }

      if (this.custom_price.trim() === "") {
        this.$toast.error("Please enter custom line price");
        this.$refs.custom_price.focus()
        return;
      }else if(Math.sign(this.custom_price.trim()) == -1){
        this.$toast.error("Please enter positive value in custom line price");
        this.$refs.custom_price.focus();
        return false;
      }
      if (this.custom_link.trim() != "" && !this.custom_link.match(regexCustomLinkURL)) {
        this.$toast.error("Please enter valid custom line link url");
        this.$refs.custom_link.focus();
        return false;
      }

      if(this.custom_name &&  this.custom_description && this.custom_brand && this.custom_price){
        let custom_line_item = {};
        custom_line_item['name'] = this.custom_name;
        custom_line_item['description'] = this.custom_description;
        custom_line_item['brand'] = this.custom_brand;
        custom_line_item['price'] = this.custom_price;
        custom_line_item['link'] = this.custom_link;
        custom_line_item['qty'] = 1;
        this.custom_line_items[this.item_count] = custom_line_item;
        this.item_count++;
        this.custom_name = "";
        this.custom_description = "";
        this.custom_brand = "";
        this.custom_price = "";
        this.custom_link = "";
        this.$forceUpdate()
      }
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
    async loadTags(category_id) {
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
      this.autocompleteTagItems = result.data.tags;
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
      this.autocompleteProductItems = result.data.products;
    },

    inputFile(newFile, oldFile) {
      if (newFile && oldFile && !newFile.active && oldFile.active) {
        if (newFile.xhr) {
        }
      }
    },

    inputFilter(newFile, oldFile, prevent) {
      if (newFile && !oldFile) {
        if (!/\.(jpeg|jpe|jpg|png|webp)$/i.test(newFile.name)) {
          this.$toast.error("Please select valid file");
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
    async delete_image(id, project_id) {
      const result = await this.callApi(
        "post",
        window.api_path + "DeleteProjectImage",
        {
          project_id: project_id,
          id: id
        }
      );

      if (result.status != 200) {
        this.$toast.error(result.data.message);
        return;
      }
      this.loadProjectData();
      this.$toast.success("file was deleted successfully");
    },
    async delete_new_image(id){
      // this.imageFiles.splice(idx, 1);
      this.imageFiles = this.imageFiles.filter(e => e.id !== id)
    },
    delete_pdf(id) {
      this.files2 = this.files2.filter(e => e.id !== id)
    },
    async deleteProjectImage(id, project_id, key) {
      const result = await this.callApi(
        "post",
        window.api_path + "DeleteProjectImage",
        {
          project_id: project_id,
          id: id
        }
      );

      if (result.status != 200) {
        this.$toast.error(result.data.message);
        return;
      }
      this.loadProjectData();
      this.$toast.success("File deleted successfully");
    },
    async publishProject(project_id) {
      const regesYoutube = /^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
      var arr_tags = [];
      var arr_tags_count = 0;
      for (var i = 0; i < this.filteredTagItems.length; i++) {
        if (this.filteredTagItems[i]["checked"] !== undefined) {
          arr_tags[arr_tags_count] = this.filteredTagItems[i];
          arr_tags_count += 1;
        }
      }
      if (!this.isAuthenticated || !localStorage.getItem("logged_user_id")) {
        this.$toast.error("To publish public system you need to login firstly !");
        return;
      }
      if (this.projectData.name == "") {
        this.$toast.error("Please enter public system name");
        return;
      }else if (this.projectData.name.length < 2 || this.projectData.name.length >= 55) {
        this.$toast.error("Please enter minimum 2 and maximum 55 characters in system name");
        return;
      }

      if (this.projectData.short_desc == "") {
        this.$toast.error("Please enter public system short description");
        return;
      }else if (this.projectData.short_desc.length >= 255) {
        this.$toast.error("Please enter maximum 255 characters in short description");
        return;
      }

      if (this.projectData.categoryselect === null) {
        this.$toast.error("Please select category");
        return;
      }
      if (this.projectData.estimated_budget == "") {
        this.$toast.error("Please enter public system budget");
        return;
      }
      if(this.projectData.project_phase == ""){
        this.$toast.error("Please enter public system phase");
        return;
      }
      if (this.projectData.desc == "") {
        this.$toast.error("Please enter public system descrption");
        return;
      }
      if (this.selectedProducts == "") {
        this.$toast.error("Please enter public system product");
        return;
      }
      if (this.projectData.link_youtube != "" && this.projectData.link_youtube != null && !this.projectData.link_youtube.match(regesYoutube)) {
        this.projectData.link_youtube = "";
        this.$toast.error("Please enter valid youtube url link");
        this.$refs.link_youtube.focus();
        return;
      }

      const formData = new FormData();
      formData.append("user_id", localStorage.getItem("logged_user_id"));
      formData.append("id", this.projectData.id);
      formData.append("title", this.projectData.name);
      formData.append("subtitle", this.projectData.short_desc);
      formData.append("category", JSON.stringify(this.searchServiceCategory)); //this.selection_category_id.code);
      formData.append("products", JSON.stringify(this.selectedProducts));
      formData.append("tags", JSON.stringify(arr_tags));
      formData.append("project_budget", this.projectData.estimated_budget);
      formData.append("project_stage", this.projectData.project_phase);
      formData.append("project_desc", this.projectData.desc);
      formData.append("project_goals", this.projectData.project_goals);
      formData.append("service_upgrade_request", this.projectData.service_upgrade_request);
      formData.append("project_skill", this.project_skill);
      formData.append("image_files_count", this.imageFilesCount);
      formData.append("pdf_files_count", this.pdfFilesCount);
      formData.append("link_url", this.projectData.link_url);
      formData.append("link_youtube", this.projectData.link_youtube);
      formData.append("fixed_payment", this.fixed_payment);
      formData.append("is_featured", this.projectData.featured ? true : false)
      formData.append("hour_rate", this.hour_rate);
      formData.append("weekly_limit", this.weekly_limit);
      formData.append("fixed_due_date", this.fixed_due_date);
      formData.append("selected_cover_img", this.selectedCoverImage);

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
        .post(window.api_path + "UpdateProject", formData, { headers })
        .then((res) => {
          let self = this;
          if (res.status == 200 && res.data.slug != "") {

             if (res.data.code == 0) {
                this.isDisabledButton = true;
                this.$toast.error(res.data.message)
                return
              }
                if (res.data.code == 0) {
                // this.isDisabledButton = true;
                this.$toast.error(res.data.message)
                return
              }
              
            self.$toast.success(res.data.message);
 
            //this.$router.push({ name: "dashboard" });
            this.$router.push("/project/" + res.data.data.slug);
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
    // filteredPlatformItems() {
    //   return this.autocompletePlatformItems.filter((i) => {
    //     return (
    //       i.text
    //         .toLowerCase()
    //         .indexOf(this.platformFilterValue.toLowerCase()) !== -1
    //     );
    //   });
    // },

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
