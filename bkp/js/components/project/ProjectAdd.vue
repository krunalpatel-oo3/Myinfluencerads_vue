<template>
  <div>
    <Header/>

    <main class="main">
      <!-- Project Add -->
      <section class="section-systemadd">
        <div class="container">
          
          <div class="projectadd-container wblock">
            <header class="projectadd-header">
            <h1>New System</h1>
          </header>
            <div class="projectadd-row">
              <!-- Project Add Thumbnail -->
              <div class="projectadd-media">
                <div class="projectadd-media-heading">
                  <div class="cus-title" >Project thumbnail</div>
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
                          @click="delete_image(nextFile.id)"
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
                      :maximum="5"
                      :thread="5"
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
                    v-model="link_youtube"
                    placeholder="www.youtube.com/streamgeeks"
                    class="form-control"
                    ref="link_youtube"
                  />
                </div>
                <div class="project-video-item" v-if="link_youtube != ''">
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
                      v-model="project_title"
                      ref='project_title'
                    />
                  </div>
                  <div class="form-group">
                    <label>Short Description</label>
                    <input
                      type="text"
                      class="form-control"
                      placeholder="Enter short description"
                      v-model="project_subtitle"
                      ref='project_subtitle'
                    />
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group">
                        <label>Category</label>

                        <v-select
                          v-model="searchServiceCategory"
                          label="text"
                          code="id"
                          item-text="text"
                          :options="categories"
                          :clearable="true"
                          :searchable="true"
                          class="form-control v-select-light"
                          placeholder="Select Category"
                          ref='searchServiceCategory'
                        >
                          <template #open-indicator="{ attributes }">
                            <span v-bind="attributes">
                              <icon-base
                                width="12"
                                height="6.84"
                                view-box="0 0 12 6.84"
                                icon-name="angle-down"
                              >
                                <icon-angle-down/>
                              </icon-base>
                            </span></template
                          >
                        </v-select>
                      </div>
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
                              v-model="pick" value="P"
                            />
                            <span>Planning</span>
                          </label>
                        </div>
                        <div class="custom-radio-group">
                          <label class="custom-radio mb-0">
                            <input
                              type="radio"
                              name="project-is-cover"
                              v-model="pick" value="IP"
                            />
                            <span>In-Progress</span>
                          </label>
                        </div>
                        <div class="custom-radio-group">
                          <label class="custom-radio mb-0">
                            <input
                              type="radio"
                              name="project-is-cover"
                              v-model="pick" value="C"
                            />
                            <span>Complete</span>
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- <div class="form-group">
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
                            {{ props.item.short_desc }}
                          </p>
                        </div>
                      </template>
                    </vue-tags-input>
                  </div> -->

                  <div class="form-group search-tags custom-search">
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
                          <p style="font-size: 14px;margin-bottom: 3px;color: black;">
                            {{ props.item.text }}
                          </p>
                          <p style="color: rgba(0, 0, 0, 0.3);line-height: 23px;margin-bottom: 0;">
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
                          <input type="text" v-model="custom_name" placeholder="Enter name" class="form-control" ref="custom_name">
                        </div>
                        <div class="form-group col-md-6 mb-2">
                          <label>Description</label>
                          <input type="text" v-model="custom_description" placeholder="Enter description"
                                 class="form-control" ref="custom_description">
                        </div>
                        <div class="form-group col-md-3 mb-2">
                          <label>Brand</label>
                          <input type="text" v-model="custom_brand" placeholder="Enter brand" class="form-control" ref="custom_brand">
                        </div>
                      </div>
                      <div class="row mx-0">
                        <div class="form-group col-md-4 mb-0">
                          <label>Price</label>
                          <input type="number" v-model="custom_price" placeholder="Enter price" class="form-control" ref="custom_price">
                        </div>
                        <div class="col-md-7 form-group mb-0">
                          <label>Link</label>
                          <input type="text" v-model="custom_link" placeholder="Enter link" class="form-control" ref="custom_link">
                        </div>
                        <div class="col-md-1 d-flex justify-content-end align-items-end pb-1 mt-md-0 mt-2">
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
                          <th class="py-1" style="padding-left: 20px">QTY</th>
                          <th class="py-1">Product Name</th>
                          <th class="py-1">Description</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(product,key) in selectedProducts" :key="key">
                          <td class="flex" style="padding-left: 27px">
                            <button class="qty-btn" @click="decrementQtyProd(key)">-</button>
                            <span style="margin: 0 7px">{{ product.qty }}</span>
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
                            <!--                                   <button-->
                            <!--                          class="btn btn-white-icon-rounded"-->
                            <!--                          @click="delete_custom_item(key)"-->
                            <!--                        >-->
                            <!--                          <icon-base-->
                            <!--                            width="12"-->
                            <!--                            height="14.64"-->
                            <!--                            view-box="0 0 12 14.64"-->
                            <!--                            icon-name="trash"-->
                            <!--                          >-->
                            <!--                            <icon-trash />-->
                            <!--                          </icon-base>-->
                            <!--                        </button>-->
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
                    <div class="form-group col-md-6 pr-3">
                      <label>Budget (Estimation)</label>
                      <input
                        type="number"
                        class="form-control"
                        placeholder="Add budget"
                        v-model="project_budget"
                        ref='project_budget'
                      />
                    </div>

                    <div class="form-group col-md-6 p-0 pr-2">
                      <label>Associated Integration Company</label>
                      <v-select
                        v-model="integrationCompany"
                        code="code"
                        label="name"
                        :options="companies"
                        :clearable="false"
                        class="form-control v-select-light"
                        placeholder="Select integration company"
                      >
                        <template #open-indicator="{ attributes }">
                            <span v-bind="attributes">
                              <icon-base
                                width="12"
                                height="6.84"
                                view-box="0 0 12 6.84"
                                icon-name="angle-down"
                              >
                                <icon-angle-down/>
                              </icon-base>
                            </span></template
                        >
                      </v-select>
                      <label class="w300 mt-1 pl-2">Add Integration Company
                        <a @click.prevent="$modal.show('add-integration-dialog')"
                           class="w700 t-color1 link-underline">here</a></label>
                    </div>
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
                    <VueEditor v-model="project_desc" ref='project_desc'/>
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
                            <VueEditor v-model="project_goals" ref='project_goals'/>
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
                            <VueEditor v-model="service_upgrade_request" ref='service_upgrade_request'/>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label>Associated Documents</label>
                    <div
                      class="projectadd-media-add"
                      :class="$refs.upload && $refs.upload.dropActive && dragActive ? 'active' : ''"
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
                          :extensions="['pdf']"
                          :drop="true"
                          :multiple="true"
                        > -->
                        <file-upload 
                          :extensions="['pdf']" 
                          input-id="files2" 
                          :value="files2" 
                          @input="updatetValue"
                          :multiple="true">browse
                        </file-upload>
                        <!-- browse
                        </document-upload> -->
                        your documents in PDF to upload
                      </div>
                    </div>
                    <div class="file-list">
                      <div
                        class="file-item"
                        v-for="(nextFilePdf, ind) in files2"
                        v-if="nextFilePdf.type == 'application/pdf'"
                      >
                        <div class="file-w">
                          <img :src="`${publicPath}pdf.png`" alt=""/>
                          <div class="btns">
                            <button @click="delete_pdf(nextFilePdf.id)" class="btn btn-white-icon-rounded btn-sm">
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

                  <div class="form-group">
                    <label>Project Website Link</label>
                    <input
                      type="text"
                      class="form-control"
                      v-model="link_url"
                      placeholder="https://www.streamgeeks.com"
                    />
                  </div>
                </div>
                     <div class="custom-checkbox-group mb-4">
                <label class="custom-checkbox">
                  <input type="checkbox"  v-model="featured"/>
                  <span>As a Pro Member you can set your new project as featured</span>
                </label>
                <div class="projectadd-btns">
                  <div class="btns">
                    <button
                      class="btn btn-primary btn-wide"
                      :disabled="submitting"
                      @click.prevent="publishProject"
                    >
                      <div v-if="submitting" class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                      </div>
                      <span v-else>Publish</span>
                    </button>
                  </div>
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
    <AddIntegrationModal @loadCompanies="getLoadCompanies"/>

    <Footer/>
  </div>
</template>

<script>
import VueTagsInput from "@johmun/vue-tags-input";
import Header from "./../common/Header.vue";
import Footer from "./../common/Footer.vue";
import IconBase from "./../common/IconBase.vue";
import IconPencil from "./../common/icons/IconPencil.vue";
import IconAngleDown from "./../common/icons/IconAngleDown.vue";
import IconTrash from "./../common/icons/IconTrash.vue";
import AddIcon from "../rebranded/icons/AddIcon.vue";
import TrashCanIcon from "../rebranded/icons/TrashCanIcon";
import AddIntegrationModal from "./../rebranded/modals/AddIntegrationModal";
import {VueEditor} from "vue2-editor";


import Vue from "vue";
import vSelect from "vue-select";

Vue.component("v-select", vSelect);
import "vue-select/dist/vue-select.css";

const VueUploadComponent = require("vue-upload-component");
Vue.component("file-upload", VueUploadComponent);
Vue.component("document-upload", VueUploadComponent);
var arr_image = [];
var arr_pdf = [];
var arr_image_preview = [];
export default {
  name: "ProjectAdd",
  components: {
    VueTagsInput,
    Header,
    Footer,
    IconBase,
    IconPencil,
    IconAngleDown,
    IconTrash,
    AddIcon,
    TrashCanIcon,
    AddIntegrationModal,
    VueEditor
  },
  data() {
    return {
      max_upload_files: 5,
      isAuthenticated: window.isAuthenticated,
      publicPath: local_image_path,
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
      link_url:'',
      link_youtube:'',
      imageFiles: [],
      imageFilesPreview: [],
      imageFilesCount: 0,
      pdfFiles: [],
      pdfFilesCount: 0,
      caption_pdf: [],
      pick: "P",
      caption_image: [],
      selectedCoverImage: 1,
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
      // selectedPlatforms: [],
      selectedProducts: [],
      selectedCategories: [],
      autocompleteTagItems: [],
      autocompleteProductItems: [],
      isDisabledButton: true,
      integrationCompany: "",
      custom_name: "",
      custom_description: "",
      custom_brand: "",
      custom_price: "",
      custom_link: "",
      custom_line_item: [],
      custom_line_items: [],
      items_qty: [],
      item_count: 0,
      isFeatured: false,
      categories: [],
      products: [],
      companies: [],
      submitting: false,
      featured: false,
      platforms: [],
      files2: [],
    };
  },

  watch: {
    selectedProducts () {
      this.productFilterValue = ""
    },
    imageFiles(theFile) {
      if (typeof theFile[0] === "undefined") return;
      var arr_image_count = 0;
      // var arr_pdf_count = 0;
      // arr_pdf = [];
      arr_image = [];
      theFile.forEach((file_arr, key) => {
        // if (file_arr.file.type == "application/pdf") {
        //   arr_pdf[arr_pdf_count] = file_arr.file;
        //   arr_pdf_count += 1;
        //   this.pdfFilesCount = arr_pdf_count;
        // }

        if (file_arr.file.type != "application/pdf") {
          let image = new Image();
          image.src = file_arr.blob;
          arr_image[arr_image_count] = file_arr.file;
          arr_image_count += 1;
          this.imageFilesCount = arr_image_count;
        }
      });
    },
    searchServiceCategory(val) {
      this.getTags(val.id);
    }
  },

  created() {
    document.title = this.$route.meta.title;
  },

  mounted() {
    this.prepareForm();
    this.getLoadCompanies();
    this.scrollToTop();
  },

  methods: {
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
    scrollToTop() {
      window.scrollTo(0,0);
    },
    async prepareForm() {
      const res = await Promise.all([
        this.callApi("post", window.api_path + "getCategoriesList", {mode: "selection"}),
        this.callApi("post", window.api_path + "getProductsList", {mode: "only_name"}),
        // this.callApi("get", window.api_path + "platform/list")
      ])
      this.categories = res[0].data.categories
      if (res[1].data.products.length) {
        this.products = res[1].data.products.map(p => {
          return { ...p, qty: 1 }
        })
      }
     
      // if (res[3].data.data.platform.length) {
      //   this.platforms = res[3].data.data.platform
      // }
    },
     async getLoadCompanies () {
      this.$modal.hide("add-integration-dialog");
      const res = await this.callApi(
        "get",
        window.api_path + 'company/getAllCompanyData'
      )
   
       this.companies = res.data.data.companys
    },

    async getTags(categoryId) {
      const res = await this.callApi("post",
        window.api_path + "getTagsList",
        {mode: "only_title", category_id: categoryId}
      )
      this.autocompleteTagItems = res.data.tags
    },
    incrementQtyCustom (id) {
      this.custom_line_items[id].qty++
      this.$forceUpdate()
    },
    incrementQtyProd (id) {
      if(this.selectedProducts[id].qty >= 100) return;
      this.selectedProducts[id].qty++
      this.$forceUpdate()
    },
    decrementQtyCustom (id) {
      if (this.custom_line_items[id].qty <= 1) return
      this.custom_line_items[id].qty--
      this.$forceUpdate()
    },
    decrementQtyProd (id) {
      if (this.selectedProducts[id].qty <= 1) return
      this.selectedProducts[id].qty--
      this.$forceUpdate()
    },
    async delete_image(id) {
      this.imageFiles = this.imageFiles.filter(e => e.id !== id)
    },
    delete_pdf(id) {
      this.files2 = this.files2.filter(e => e.id !== id)
      // this.files2.splice(id, 1)
    },
    delete_custom_item(idx) {
      this.custom_line_items.splice(idx, 1);
      this.item_count--;
    },
    delete_product(idx) {
      this.selectedProducts.splice(idx, 1);
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
    updateVueProductsInput(newProducts) {
      this.selectedProducts = newProducts;
    },
    updateVueCategoriesInput(newCategories) {
      this.selectedCategories = newCategories;
    },
    updateVueTagsInput(newTags) {
      this.selectedTags = newTags;
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
        if (!/\.(jpeg|jpe|jpg|png|webp)$/i.test(newFile.name)) {
          this.$toast.error("Please select valid file");
          return prevent();
        }
      }
      if(newFile.size > 1000000){
        this.$toast.error("You can not enter file more then 1 MB!");
        return prevent();
      }
      if (newFile.file.type != "application/pdf" && newFile && newFile.error === "" && newFile.file && (!oldFile || newFile.file !== oldFile.file)) {
      // if (newFile.file.type != "application/pdf") {
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
      console.log('drag enter');
      this.dragActive = true;
    },
    dragLeave() {
      console.log('drag leave');
      this.dragActive = false;
    },
    addYoutubeLink(){
      this.$refs.link_youtube.focus();
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
        // alert(JSON.stringify(this.custom_line_items));
        console.log("aa: ",this.custom_line_items);
        this.item_count++;
        this.custom_name = "";
        this.custom_description = "";
        this.custom_brand = "";
        this.custom_price = "";
        this.custom_link = "";
            this.$forceUpdate()
      }


    },

    async publishProject() {
      const regesYoutube = /^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
      var arr_tags = [];
      var arr_tags_count = 0;
      for (var i = 0; i < this.filteredTagItems.length; i++) {
        if (this.filteredTagItems[i]["checked"] !== undefined) {
          arr_tags[arr_tags_count] = this.filteredTagItems[i];
          arr_tags_count += 1;
        }
      }
      if (this.project_title === "") {
        this.$toast.error("Please enter public system name");
        this.$refs.project_title.focus()
        return;
      }else if (this.project_title.length < 2 || this.project_title.length >= 55) {
        this.$toast.error("Please enter minimum 2 and maximum 55 characters in system name");
        this.$refs.project_title.focus()
        return;
      }

      if (this.project_subtitle === "") {
        this.$toast.error("Please enter public system short description");
        this.$refs.project_subtitle.focus()
        return;
      }else if (this.project_subtitle.length >= 255) {
        this.$toast.error("Please enter maximum 255 characters in short description");
        this.$refs.project_subtitle.focus()
        return;
      }

      if (this.searchServiceCategory === null) {
        this.$toast.error("Please select category");
        this.$refs.searchServiceCategory.focus()
        return;
      }
      if (this.project_budget === "") {
        this.$toast.error("Please enter public system budget (estimation)");
        this.$refs.project_budget.focus();
        return;
      }else if(Math.sign(this.project_budget) == -1){
        this.$toast.error("Please enter positive value in public system budget (estimation)");
        this.$refs.project_budget.focus();
        return false;
      }
      if (this.pick === "") {
        this.$toast.error("Please select public system phase");
        this.$refs.pick.focus();
      }
      if (this.project_desc === "") {
        this.$toast.error("Please enter public system project descrption");
        this.$refs.project_desc.focus();
        return;
      }
      if (this.selectedProducts === "") {
        this.$toast.error("Please enter public system product");
        this.$refs.selectedProducts.focus();
        return;
      }

      if (this.link_youtube != "" && this.link_youtube != null && !this.link_youtube.match(regesYoutube)) {
        this.link_youtube = "";
        this.$toast.error("Please enter valid youtube url link");
        this.$refs.link_youtube.focus();
        return;
      }
      
      // else if(this.selectedProducts.length <= 0){
      //   this.$toast.error("You can not add product select only from autocomplete.");
      //   this.$refs.selectedProducts.focus();
      //   return;
      // }

      this.submitting = true

      const formData = new FormData();
      formData.append("title", this.project_title);
      formData.append("subtitle", this.project_subtitle);
      formData.append("project_desc", this.project_desc);
      formData.append("project_goals", this.project_goals);
      formData.append("service_upgrade_request", this.service_upgrade_request);
      formData.append("project_budget", this.project_budget);
      formData.append("pick", this.pick || '');
      formData.append("link_url", this.link_url || '');
      formData.append("link_youtube", this.link_youtube || '');
      formData.append("user_id", localStorage.getItem("logged_user_id"));
      formData.append("tags", JSON.stringify(arr_tags));
      formData.append("category", JSON.stringify(this.searchServiceCategory));
      formData.append("company", JSON.stringify(this.integrationCompany));
      // formData.append("platform", JSON.stringify(selectedPlatforms));
      formData.append("is_featured", this.featured);
      formData.append("products", JSON.stringify(this.selectedProducts));
      formData.append("image_files_count", this.imageFilesCount);
      formData.append("pdf_files_count", this.pdfFilesCount);
      formData.append("custom_line_items", JSON.stringify(this.custom_line_items));
      for (let i = 0; i < 5; i++) {
        if (arr_image[i]) {
          formData.append("file_" + i, arr_image[i]);
          formData.append("file_image_caption_" + i, document.getElementById(arr_image[i].name + "_caption").value);
          formData.append("file_ismain_" + i, document.getElementById(arr_image[i].name + "_ismain").checked);
        }
      }
      for (let i = 0; i < 5; i++) {
        if (arr_pdf[i]) {
          formData.append("file_pdf_" + i, arr_pdf[i])
          formData.append(
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
      axios
        .post(window.api_path + "publishProject", formData, {headers})
        .then((res) => {
          if (res.data.code === 1) {
            this.$toast.success(res.data.message)
            setTimeout(() => {
              this.$router.push({ name: 'project', params: { slug: res.data.data.slug }})
            }, 1000);
          } else {
          
            this.$toast.error(res.data.message)
          }
        }).
      finally(() => {
        this.submitting = false;
      });
    }
  },
  computed: {
    // isDisabled: function () {
    //   return !this.isDisabledButton;
    // },
    filteredProductItems() {
      if (this.products.length) {
        return this.products.filter((i) => {
          return (
            i.text
              .toLowerCase()
              .indexOf(this.productFilterValue.toLowerCase()) !== -1
          );
        });
      }
      return []
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
.spinner-border {
  width: 1rem;
  height: 1rem;
}
.form-control {
    height: 48px;
}
.cus-title{
  font-weight: 400;
    font-size: 18px;
}
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

