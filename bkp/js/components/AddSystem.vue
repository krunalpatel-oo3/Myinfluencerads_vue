<template>
  <div>
    <Header />
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
                  <h2>Add public system thumbnail</h2>
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
                  <label>Add Youtube Video Link</label>
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
                  <div class="form-group">
                    <label>System Name</label>
                    <input
                      type="text"
                      class="form-control"
                      placeholder="Enter system name"
                      v-model="project_title"
                    />
                  </div>
                  <div class="form-group">
                    <label>Short Descriptions</label>
                    <input
                      type="text"
                      class="form-control"
                      placeholder="Enter short description"
                      v-model="project_subtitle"
                    />
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group">
                        <label>Add category</label>
                        <v-select
                          v-model="systemCategory"
                          code="code"
                          label="label"
                          :options="systemCategoryOptions"
                          :clearable="false"
                          class="form-control v-select-light"
                          placeholder="Select option"
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
                            </span></template
                          >
                        </v-select>
                      </div>
                    </div>
                    <div class="form-group col-md-6">
                      <label>Public System Phase</label>
                      <div class="row mx-0 align-items-center justify-content-around"
                           style="color: #5D5D5D; height: 43px; border: 1px solid #DDE0E6; border-radius: 0.25rem">
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
                  <div class="form-group">
                    <label>Products</label>
                    <vue-tags-input
                      v-model="product"
                      :tags="selectedProducts"
                      :autocomplete-items="autocompleteSelectedProducts"
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
                  <div class="form-group">
                    <label>Custom Line Items</label>
                    <div class="custom-line-items">
                      <div class="row mx-0">
                        <div class="form-group col-md-3 mb-2">
                          <label>Item Name</label>
                          <input type="text" placeholder="Enter name" class="form-control">
                        </div>
                        <div class="form-group col-md-6 mb-2">
                          <label>Description</label>
                          <input type="text" placeholder="Enter description" class="form-control">
                        </div>
                        <div class="form-group col-md-3 mb-2">
                          <label>Brand</label>
                          <input type="text" placeholder="Enter brand" class="form-control">
                        </div>
                      </div>
                      <div class="row mx-0">
                        <div class="form-group col-md-4 mb-0">
                          <label>Price</label>
                          <input type="text" placeholder="Enter price" class="form-control">
                        </div>
                        <div class="col-md-7 form-group mb-0">
                          <label>Link</label>
                          <input type="text" placeholder="Enter link" class="form-control">
                        </div>
                        <div class="col-md-1 d-flex justify-content-end align-items-end pb-1">
                          <button class="add-btn">
                            <AddIcon />
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
                        <tr>
                          <td class="flex" style="padding-left: 27px">
                            <button class="qty-btn">-</button>
                            <span style="margin: 0 7px">1</span>
                            <button class="qty-btn">+</button>
                          </td>
                          <td><img
                            :src="`${publicPath}camera_360.png`"
                            alt=""
                            class="rounded-circle width-32 mr-2"
                          />Display
                          </td>
                          <td class="t-color8">Lorem Ipsum dolor sit amet agna finibus risus.</td>
                          <td class="pr-3">
                            <TrashCanIcon />
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
                        type="text"
                        class="form-control"
                        placeholder="Add Budget"
                        v-model="project_budget"
                      />
                    </div>
                    <div class="form-group col-md-6 p-0 pr-2">
                      <label>Associated Integration Company</label>
                      <v-select
                        v-model="integrationCompany"
                        code="code"
                        label="label"
                        :options="systemCategoryOptions"
                        :clearable="false"
                        class="form-control v-select-light"
                        placeholder="Select option"
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
                            </span></template
                        >
                      </v-select>
                      <label class="w300 mt-1 pl-2">Add Integration Company <a @click.prevent="openDialog"
                                                                               class="w700 t-color1 link-underline">here</a></label>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Tags</label>
                    <div class="btns tag-btns">
                      <label
                        v-for="(tag, index) in autocompleteTagItems"
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
                    <label>Public System Description</label>
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
                    <label>Add link to website for public system</label>
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
                  >As a Pro Member you can set your new project as featured</span
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
              </div>
            </div>
          </div>
        </div>
      </section>
      <Footer />
      <AddIntegrationModal />
    </main>
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
import AddIntegrationModal from "./rebranded/modals/AddIntegrationModal";

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
export default {
  name: "ProjectAdd",
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
    TrashCanIcon,
    AddIntegrationModal
  },
  data() {
    return {
      systemCategory: null,
      systemCategoryOptions: [
        "Category 1",
        "Category 2",
        "Category 3"
      ],
      product: "",
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
      project_title: "",
      project_budget: "",
      project_stage: "",
      project_desc: "",
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
      integrationCompany: "",
      pick: "P"
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
          image.onload = function() {
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
    // document.title = this.$route.meta.title;
  },

  methods: {
    openDialog() {
      this.$modal.show("add-integration-dialog");
    },
    async delete_image(idx) {
      this.imageFiles.splice(idx, 1);
    },
    updateVueTagsInput(newTags) {
      console.log("updateVueTagsInput newTags::");
      console.log(newTags);
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
  }
};
</script>
