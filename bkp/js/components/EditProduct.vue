<template>
  <div>
    <Header />

    <main class="main">
      <!-- Project Add -->
      <section class="section-systemadd">
        <div class="container">
          <div v-if="isLoading" class="skeleton"></div>
          <FormulateForm
            v-else
            @submit="publishProduct"
          >
            <div class="projectadd-container wblock">
              <header class="projectadd-header">
                <h1>Edit Product</h1>
              </header>
              <div class="projectadd-row">
                <!-- Project Add Thumbnail -->
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
                    v-for="(productImage, val) in productImages"
                    :key="val"
                  >
                    <div class="item-img" v-if="productImage.path">
                      <img
                        :src="
                          productImage.path
                        "
                        alt=""
                        class="rounded"
                      />
                      <div class="btns">
                        <button
                          class="btn btn-white-icon-rounded"
                          type="button"
                          @click="
                            deleteProductImage(
                              productImage.id,
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
                          v-model="productImage.image_caption"
                          v-bind:id="productImage.name + '_caption'"
                        />
                      </div>
                    </div>
                    <div class="item-is-cover">
                      <div class="custom-radio-group">
                        <label class="custom-radio">
                          <input
                            type="radio"
                             v-bind:id="productImage.name + '_ismain'"
                            :name="'project-is-cover-'+val"
                            :checked="productImage.image_type == 1"
                            :value="val+1"
                            v-model="selectedCoverImage"
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

                  <div v-show="productImages.length + imageFiles.length >= max_upload_files">
                    <div class="">You reached maximum of files</div>
                  </div>

                  <div
                    v-show="productImages.length + imageFiles.length < max_upload_files"
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
                        :maximum="5 - productImages.length"
                        :thread="5 - productImages.length"
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
                      v-model="link_youtube"
                      placeholder="www.youtube.com/streamgeeks"
                      class="form-control"
                      ref="link_youtube"
                    />
                  </div>
                  <div class="project-video-item" v-if="link_youtube != null && link_youtube != '' && link_youtube != 'null'">
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
                      <div class="col-6">
                        <div class="form-group">
                          <label>Product Title</label>
                          <FormulateInput
                            type="text"
                            input-class="form-control"
                            placeholder="Enter product title"
                            v-model="product_title"
                            validation="required"
                          />
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-group">
                          <label>SKU (Part Number)</label>
                          <FormulateInput
                            type="text"
                            input-class="form-control"
                            placeholder="Enter SKU"
                            v-model="product_sku"
                            validation="required"
                          />
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-6">
                        <div class="form-group">
                          <label>Category</label>
                          <v-select
                            v-model="productCategory"
                            code="id"
                            label="text"
                            item-text="text"
                            :options="productCategoryOptions"
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
                      </div>
                      <div class="col-6">
                        <div class="form-group">
                          <label>Sub-Category</label>
                          <v-select
                            v-model="productSubCategory"
                            code="id"
                            label="text"
                            item-text="text"
                            :options="productSubCategoryOptions"
                            :clearable="false"
                            class="form-control v-select-light"
                            placeholder="Select sub-category"
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
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-6">
                        <div class="form-group">
                          <label>Price</label>
                          <FormulateInput
                            type="text"
                            validation="required"
                            input-class="form-control"
                            placeholder="Add price"
                            v-model="product_price"
                          />
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-group">
                          <label>Brand</label>
                          <v-select
                            v-model="product_brand"
                            code="id"
                            label="text"
                            :options="brandList"
                            :clearable="false"
                            class="form-control v-select-light"
                            placeholder="Select brand"
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
                          <p class="t-15 w300 mt-1 mb-0">Add Brand <a @click="openDialog"
                                                                      class="t-color1 w700 link-underline">here</a></p>
                        </div>
                      </div>
                    </div>
                    <div class="form-group search-tags custom-search">
                      <label>Compatible Products</label>
                      <vue-tags-input
                        v-model="compatible"
                        :tags="compatibles"
                        :autocomplete-items="filteredCompatibles"
                        placeholder="Add products"
                        @tags-changed="updateVueComaptibleInput"
                        class="advanced-tag"
                      >
                        <template v-slot:autocomplete-item="props">
                          <div
                            @click="compatibles.push(props.item)"
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
                    <div class="form-group search-tags custom-search">
                      <label>Accessories</label>
                      <vue-tags-input
                        v-model="accessory"
                        :tags="accessories"
                        :autocomplete-items="filteredAccessories"
                        placeholder="Add products"
                        @tags-changed="updateVueAccessoriesInput"
                        class="advanced-tag"
                      >
                        <template v-slot:autocomplete-item="props">
                          <div
                            @click="accessories.push(props.item)"
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
                      <label>Product Description</label>
                      <FormulateInput
                        v-model="product_desc"
                        type="textarea"
                        rows="4"
                        input-class="form-control"
                        validation="required"
                        placeholder="Enter product description"
                      ></FormulateInput>
                    </div>
                    <div class="form-group">
                      <label>Technical Specification</label>
                      <VueEditor v-model="product_specs" ref='product_specs'/>
                      <!-- <FormulateInput
                        v-model="product_specs"
                        rows="4"
                        type="textarea"
                        input-class="form-control"
                        validation="required"
                        placeholder="Enter technical specification"
                      ></FormulateInput> -->
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
                      <label>Add link to product page</label>
                      <FormulateInput
                        type="text"
                        validation="required"
                        input-class="form-control"
                        v-model="link_url"
                        placeholder="https://www.streamgeeks.com"
                      />
                    </div>
                  </div>
                  <div class="projectadd-btns">
                   <div class="custom-checkbox-group mb-4">
                     <label class="custom-checkbox">
                       <input type="checkbox" v-model="markedFeatured"/>
                       <span>As a Brand Member you can set your new project as featured</span
                       >
                     </label>
                   </div>
                    <div class="btns">
                      <FormulateInput
                        type="submit"
                        input-class="btn btn-primary btn-wide"
                        :disabled="submitting"
                      >
                        <div v-if="submitting" class="spinner-border" role="status">
                          <span class="sr-only">Loading...</span>
                        </div>
                        <span v-else>Update</span>
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
     <AddBrandModal @loadBrands="getLoadBrands" />
      <Footer />
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
import AddBrandModal from "./rebranded/modals/AddBrandModal";
import {VueEditor} from "vue2-editor";

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
const TOKEN = localStorage.getItem("sgtoken")
      const headers = {
        "Content-Type": "multipart/form-data",
        Authorization: `Bearer ${TOKEN}`
      };
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
    AddBrandModal,
    VueEditor,
  },
  data() {
    return {
      productId: '',
      accessory: '',
      accessories: [],
      selectedAccessories: null,
      autocompleteSelectedAccessories: null,
      compatible: '',
      compatibles: [],
      productImages: [],
      productPdf: [],
      product_accessory: null,
      product_title: null,
      product_specs: null,
      product_sku: null,
      product_price: null,
      product_brand: null,
      product_desc: null,
      productCategory: null,
      productCategoryOptions: [],
      productSubCategory: null,
      productSubCategoryOptions: [],
      productList: [],
      product: "",
      brandList: [],
      selectedProducts: [],
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
      tagFilterValue: "",
      tag: [],
      selectedPlatforms: [],
      selectedCategories: [],
      autocompleteProductItems: [],
      isDisabledButton: true,
      integrationCompany: "",
      isLoading: true,
      submitting: false,
      autocompleteTagItems: [],
      selectedTags: [],
      markedFeatured:false
    };
  },

  watch: {
    productCategory (val) {
      if (val.id) {
        this.loadSubcategories(val.id)
        this.getTags(val.id);
        }
    },
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
      this.loadTags(val.id);
    }
  },

  async created() {
    this.isLoading = true
    document.title = this.$route.meta.title;
    this.logged_user_id = localStorage.getItem("logged_user_id");
    await this.loadCategories();
    await this.getLoadProductList();
    await this.getLoadBrands();
    await this.loadProduct();
    this.isLoading = false
  },

  mounted() {
    this.scrollToTop();
  },

  methods: {
    scrollToTop() {
      window.scrollTo(0,0);
    },
    updateVueComaptibleInput(newCompatibles) {
      this.compatibles = newCompatibles;
    },
    updateVueAccessoriesInput(newAccessories) {
      this.accessories = newAccessories;
    },
    async loadProduct() {
      const res = await this.callApi(
        "get",
        window.api_path + "product/getproduct/" + this.$route.params.slug,
        {}
      );
     const {product} = res.data.data;
      
      this.productId = product.product_id
      this.product_title = product.name || ''
      this.product_sku = product.sku || ''
      this.product_price = product.price || ''
      this.link_url = product.website_link || ''
      this.product_desc = product.desc || ''
      this.product_specs = product.short_desc || ''
      this.link_youtube = product.youtube_link || ''
      this.productCategory = product.product_category !=0 ? {id: product.product_category.id, text:product.product_category.title} : ''
      this.product_brand = product.productbrand !=0 ? {id: product.productbrand.id, text:product.productbrand.name} : ''
      this.productSubCategory = product.product_sub_category.length !=0 ? {id: product.product_sub_category.id, text:product.product_sub_category.title} : ''
      this.productImages = product.images || []
      this.productPdf = product.documents || []
      this.selectedTags = product.product_tags || []
      this.markedFeatured = product.featured == 1 ? true : false
      this.max_upload_files = this.max_upload_files - this.productImages.length;

      if (product.accessoriesproducts.length) {
        this.accessories = product.accessoriesproducts.map(product => {
          return {
            text: product.product_name,
            id: product.product_id,
          }
        })
      }
      if (product.compatibleproducts.length) {
        this.compatibles = product.compatibleproducts.map(product => {
          return {
            text: product.product_name,
            id: product.product_id,
          }
        })
      }

    },
    deleteProductImage(imageId, key) {
      const data = new FormData();
      axios.post(window.api_path + "product/deletecoverimage/"+imageId, {}, { headers })
        .then((res) => {
          
          if (res.status == 200) {
            if(res.data.code == 0){
              this.$toast.error(res.data.data);
              return
            }
               this.$toast.success(res.data.message);
                delete this.productImages[key]
                this.productImages = {...this.productImages}; 
            return;
          }
          this.$toast.error('Error occurred. Please try again later');
        });
    },
    async publishProduct () {
      const regesYoutube = /^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;

      if (this.product_title === "") {
        this.$toast.error("Please enter public system name");
        return;
      }else if (this.product_title.length < 2 || this.product_title.length >= 55) {
        this.$toast.error("Please enter minimum 2 and maximum 55 characters in system name");
        return;
      }
      if (!this.productCategory) {
        this.$toast.error("Please select a category")
        return
      }
      if (this.link_youtube != "" && this.link_youtube != null && !this.link_youtube.match(regesYoutube)) {
        this.link_youtube = "";
        this.$toast.error("Please enter valid youtube url link");
        this.$refs.link_youtube.focus();
        return;
      }
      // if (!this.imageFilesCount) {
      //   this.$toast.error('Upload at least one image')
      //   return
      // }
      this.submitting = true
      const d = new FormData()
      d.append("user_id", localStorage.getItem('logged_user_id'))
      d.append("name", this.product_title)
      d.append("sku", this.product_sku)
      d.append("product_id", this.productId)
      d.append("product_category", this.productCategory ? this.productCategory.id : '')
      d.append("product_sub_category", this.productSubCategory ? this.productSubCategory.id : '')
      d.append("price", this.product_price)
      d.append("brand", this.product_brand ? this.product_brand.id : '')
      d.append("desc", this.product_desc)
      d.append("is_featured", this.markedFeatured);
      d.append("short_desc", this.product_specs)
      d.append("website_link", this.link_url || '')
      d.append("youtube_link", this.link_youtube || '')
      d.append("youtube_link2", '')
    
      if (this.accessories.length) {
        const accs = this.accessories.map(acc => acc.id)
        d.append("accessories", JSON.stringify(accs))
      }
      
      if (this.compatibles.length) {
        const comps = this.compatibles.map(c => c.id)
        d.append("compatible_product", JSON.stringify(comps))
      }
      if (this.autocompleteTagItems.length) {
        const filterTags = this.autocompleteTagItems.filter(val => val.checked == true);
        const tags = filterTags.map(c => c.id)
        d.append("tags", JSON.stringify(tags))
      }
      for (let i = 0; i <= 4; i++) {
        if (arr_image[i]) {
          d.append("images[]", arr_image[i]);
          d.append("image_caption[]", document.getElementById(arr_image[i].name + "_caption").value);
          d.append("image_is_main[]", document.getElementById(arr_image[i].name + "_ismain").checked ? 1 : 0);
        }
        if (arr_pdf[i]) {
          d.append("file_pdf[]", arr_pdf[i]);
          d.append(
            "file_pdf_caption[]",
            document.getElementById(arr_pdf[i].name).value
          );
        }
      }
     
      const res = await axios.post(window.api_path + "product/updateproduct", d, { headers })
      this.submitting = false

      if (res.status === 200) {
        if (res.data.code === 1) {
          this.$toast.success(res.data.message)
          await this.$router.push({ name: 'Product Page', params: { slug:  this.$route.params.slug}})
        } else {
          this.$toast.error(res.data.message)
        }
        return;
      }
      this.$toast.error('Error occurred during execution. Please check all the fields and try again')
    },
    async getLoadBrands () {
       this.$modal.hide("add-brand-dialog");
      const res = await this.callApi(
        "get",
        window.api_path + 'getBrandList',
        {
          user_id: localStorage.getItem("logged_user_id")
        }
      )
      if (res.status !== 200) {
        this.$toast.error(res.data.message);
        this.isLoading = false
        return
      }
      if (res.data.data.brands.length) {
        res.data.data.brands.forEach(brand => {
          this.brandList.push({
            id: brand.id,
            text: brand.name
          })
        })
      }
    },
    async getLoadProductList() {
      const result = await this.callApi(
        "post",
        window.api_path + "getProductsList",
        {mode: "only_name"}
      );
      if (result.status != 200) {
        this.$toast.error(result.data.message);
        this.productList = [];
        this.isLoading = false;
        return;
      }
      this.productList = result.data.products.map(p => {
        return { ...p, qty: 1 }
      });
    },
    async loadSubcategories (id) {
      const res = await this.callApi(
        "get",
        window.api_path + "product/getproductsubcategories/" + id
      )
      if (res.status !== 200) {
        this.$toast.error(res.data.message);
        return;
      }
      if (res.data.data.productsubcategories) {
        this.productSubCategoryOptions = []
        Object.keys(res.data.data.productsubcategories).forEach(cat => {
          this.productSubCategoryOptions.push({
            id: cat,
            text: res.data.data.productsubcategories[cat]
          })
        })
      }
    },
    async loadCategories() {
      const res = await this.callApi(
        "get",
        window.api_path + "product/getproductcategories"
      );
      if (res.status !== 200) {
        this.$toast.error(res.data.message);
        this.isLoading = false;
        return;
      }
      if (res.data.data.productcategories) {
        Object.keys(res.data.data.productcategories).forEach(cat => {
          this.productCategoryOptions.push({
            id: cat,
            text: res.data.data.productcategories[cat]
          })
        })
      }
    },
    async loadCompatibles () {
      const res = await this.callApi(
        "get",
        window.api_path + "product/getcompatibleproduct"
      )
      console.log(res.data)
    },
    openDialog() {
      this.$modal.show("add-brand-dialog");
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
    inputFile(newFile, oldFile) {
      if (newFile && oldFile && !newFile.active && oldFile.active) {
        if (newFile.xhr) {
          console.log("statusaa", newFile.xhr.status);
        }
      }
    },
    async getTags(categoryId) {
      const res = await this.callApi("post",
        window.api_path + "getTagsList",
        {mode: "only_title", category_id: categoryId}
      )
     const {tags} = res.data;

      if(this.selectedTags.length){
        const selectedTagIds = this.selectedTags.map(c => c.tag_product_id)
         const tagsList = tags.map(function(val){
            val['checked'] = selectedTagIds.includes(val.id)
            return val;
          });
            this.autocompleteTagItems = tagsList;
          
        }else{
        this.autocompleteTagItems = tags
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
    filteredCompatibles () {
      return this.productList.filter((i) => {
        return (
          i.text
            .toLowerCase()
            .indexOf(this.compatible.toLowerCase()) !== -1
        );
      })
    },
    filteredAccessories () {
      return this.productList.filter((i) => {
        return (
          i.text
            .toLowerCase()
            .indexOf(this.accessory.toLowerCase()) !== -1
        );
      })
    },
  }
};
</script>

<style lang="scss" scoped>
  .skeleton {
    width: 100%;
    height: 1400px;
    border-radius: 8px;
  }
  .spinner-border {
    width: 1rem;
    height: 1rem;
  }
  .form-control {
    height: 48px;
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
