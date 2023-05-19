<template>
  <div>
    <Header />
    <main class="main">
      <!-- Brand Add -->
      <section class="section-systemadd">
        <div class="container">
          <FormulateForm
            @submit="publishBrand"
          >
          <div class="projectadd-container wblock">
            <header class="projectadd-header">
              <h1>New Brand</h1>
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
                <div class="brand-video-item" v-if="youtube_url != null && youtube_url != ''">
                  <iframe
                    :src="`https://www.youtube.com/embed/${getEmbed(
                      this.youtube_url
                    )}`"
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
                            v-model="brandName"
                            validation="required"
                            input-class="form-control"
                            placeholder="Enter brand name"
                          ></FormulateInput>
                        </div>
                        <div class="form-group">
                          <label>Brand Website</label>
                          <FormulateInput
                            type="text"
                            validation="required"
                            input-class="form-control"
                            placeholder="Enter brand website"
                            v-model="brandWebsite"
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
                            placeholder="Enter facebook page"
                            v-model="facebookPage"
                            validation="required"
                          />
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-group">
                          <label>YouTube Page</label>
                          <FormulateInput
                            type="text"
                            validation="required"
                            input-class="form-control"
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
                        validation="required"
                        input-class="form-control"
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
                            :maximum="5"
                            :thread="5"
                            :multiple="true">browse
                          </file-upload>
                          your documents in PDF to upload
                        </div>
                      </div>
                      <div class="file-list">
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
                  <div class="projectadd-btns">
                    <div class="btns">
                      <FormulateInput
                        type="submit"
                        input-class="btn btn-primary btn-wide"
                        :disabled="isPublishing"
                      >
                        <div v-if="isPublishing" class="spinner-border" role="status">
                          <span class="sr-only">Loading...</span>
                        </div>
                        <span v-else>Add Brand</span>
                      </FormulateInput>
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
      productSubCategory: null,
      product: "",
      brandLogo: [],
      facebookPage: null,
      youtubePage: null,
      brandName: null,
      brandWebsite: null,
      companyLocation: null,
      selectedProducts: [],
      accessory: "",
      selectedAccessories: [],
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
      autocompleteProductItems: [],
      isDisabledButton: true,
      integrationCompany: "",
      isPublishing: false,
      brandFiles: [],
    };
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
    imageFiles(theFile) {
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
      arr_pdf           = [];
      theFile.forEach((file_arr, key) => {
        if (file_arr.file.type == "application/pdf") {
          arr_pdf[arr_pdf_count] = file_arr.file;
          arr_pdf_count += 1;
          this.pdfFilesCount = arr_pdf_count;
        }
      });
    },
    searchServiceCategory(val) {
      this.loadTags(val.id);
    }
  },

  created() {
    document.title = this.$route.meta.title;
    this.logged_user_id = localStorage.getItem("logged_user_id");
    this.loadProducts();
    this.loadCategoriesList();
    this.getUser();
  },

  methods: {
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
      this.imageFiles.splice(idx, 1);
    },
    delete_pdf(id) {
      this.brandFiles = this.brandFiles.filter(e => e.id !== id)
    },
    deletePrimayImage (key){
      delete this.brandLogo[key]
      this.brandLogo =  []; 
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
          // console.log(newFile.file);
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
    async publishBrand() {

      if (!this.imageFilesCount) {
        this.$toast.error('Upload at least one image');
        return
      }
      if (!this.brandLogo) {
        this.$toast.error('Upload brand logo');
        return
      }
      this.isPublishing = true;
      const data = new FormData();
      data.append("name", this.brandName);
      data.append("brand_desc", this.brand_desc);
      data.append("web_url", this.brandWebsite);
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
            this.$toast.error(res.data.data);
            return;
          } else if (res.data.code === 1) {
            this.$toast.success(res.data.message);
            this.$router.push({ name: 'Brand Page', params: { slug: res.data.data.slug }})
          }
        })
        .catch((err) => {
          this.$toast.error(err)
        })
        .finally(() => {
          this.isPublishing = false;
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
</style>
