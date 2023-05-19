<template>
  <div>
    <Header />

    <main class="main">
      <!-- Project Add -->
      <section class="section-projectadd">
        <div class="container">
          <header class="projectadd-header">
            <h1>Share Project</h1>
            <!--            <button class="btn btn-secondary btn-wide">+ New Project</button>-->
          </header>
          <div class="projectadd-container wblock">
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
                  >
                    <div class="item-img">
                      <img :src="nextFile.blob" alt="" class="rounded" />
                      <div class="btns">
<!--                        <button class="btn btn-white-icon-rounded">-->
<!--                          <icon-base-->
<!--                            width="12.53"-->
<!--                            height="14"-->
<!--                            view-box="0 0 12.53 14"-->
<!--                            icon-name="pencil"-->
<!--                          >-->
<!--                            <icon-pencil />-->
<!--                          </icon-base>-->
<!--                        </button>-->
                        <button @click="deleteImage(index)" class="btn btn-white-icon-rounded">
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
                        />
                      </div>
                    </div>
                    <div class="item-is-cover">
                      <div class="custom-radio-group">
                        <label class="custom-radio">
                          <input
                            type="radio"
                            checked
                            name="project-is-cover"
                            :value="nextFile.name"
                            v-model="selectedCoverImage"
                          />
                          <span>Cover Image</span>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- <div class="projectadd-media-items"> -->

                <div v-show="imageFiles.length >= max_upload_files">
                  <div class="">
                    You reached maximum of files
                  </div>
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
                    <file-upload
                      input-id="img-file"
                      ref="upload"
                      v-model="imageFiles"
                      post-action="/post.method"
                      put-action="/put.method"
                      @input-file="inputFile"
                      :multiple="true"
                      @input-filter="inputFilter"
                    >browse
                    </file-upload
                    >
                  </div>
                </div>

                <div class="form-group project-video-add">
                  <label>Add Youtube Video Link</label>
                  <input
                    type="text"
                    placeholder="www.youtube.com/streamgeeks"
                    class="form-control"
                    v-model="youtubeLink"
                  />
                </div>

                <div class="project-video-item">
                  <iframe
                    :src="`https://www.youtube.com/embed/${getEmbed(this.youtubeLink)}?controls=0`"
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
                    <label>Title</label>
                    <input
                      type="text"
                      class="form-control"
                      placeholder="Write public system title"
                      v-model="project_title"
                    />
                  </div>
                  <div class="form-group">
                    <label>Sub title</label>
                    <input
                      type="text"
                      class="form-control"
                      placeholder="Write public system subtitle"
                      v-model="project_subtitle"
                    />
                  </div>

                  <div class="form-group">
                    <label>Add Categories</label>
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
                        <div style="padding: 10px 15px !important;">
                          <p style="font-size: 14px; margin-bottom: 3px; color: black">{{ props.item.text }}</p>
                          <p style="color: rgba(0, 0, 0, 0.3); line-height: 23px; margin-bottom: 0">
                            {{ props.item.description }}</p>
                        </div>
                      </template>
                    </vue-tags-input>
                  </div>

                  <div class="form-group">
                    <label>Add Platforms</label>
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
                        <div style="padding: 10px 15px !important;">
                          <p style="font-size: 14px; margin-bottom: 3px; color: black">{{ props.item.text }}</p>
                          <p style="color: rgba(0, 0, 0, 0.3); line-height: 23px; margin-bottom: 0">
                            {{ props.item.description }}</p>
                        </div>
                      </template>
                    </vue-tags-input>
                  </div>

                  <div class="form-group">
                    <label>Add Products</label>
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
                        <div style="padding: 10px 15px !important;">
                          <p style="font-size: 14px; margin-bottom: 3px; color: black">{{ props.item.text }}</p>
                          <p style="color: rgba(0, 0, 0, 0.3); line-height: 23px; margin-bottom: 0">
                            {{ props.item.description }}</p>
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
                      />
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
                          :value="tag.text"
                        />
                        <span>+ {{ tag.text }}</span>
                      </label>
                    </div>
                    <!-- tagFilterValue::{{ tagFilterValue }}<br />
                    filteredTagItems::{{ filteredTagItems }}<br />
                    selectedTags::{{ selectedTags }}<br /> -->
                    <!-- <vue-tags-input
                      v-model="tagFilterValue"
                      :tags="selectedTags"
                      :autocomplete-items="filteredTagItems"
                      :add-only-from-autocomplete="true"
                      placeholder="Add..."
                      @tags-changed="updateVueTagsInput"
                    /> -->
                  </div>

                  <div class="form-group">
                    <label>Public System Description</label>
                    <textarea
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
                        <file-upload
                          input-id="pdf-file"
                          ref="uploadPDF"
                          v-model="pdfFiles"
                          post-action="/post.method"
                          put-action="/put.method"
                          :multiple="true"
                          @input-filter="pdfFilter"
                        >browse
                        </file-upload
                        >
                        documents in PDF
                      </div>
                    </div>
                    <div class="file-list">
                      <div v-for="(pdf, index) in pdfFiles" :key="index" class="file-item">
                        <div class="file-w">
                          <img :src="`${publicPath}pdf.png`" alt="" />
                          <div class="btns">
                            <!--                            <button class="btn btn-white-icon-rounded btn-sm">-->
                            <!--                              <icon-base-->
                            <!--                                width="9"-->
                            <!--                                height="9.2"-->
                            <!--                                view-box="0 0 12.53 14"-->
                            <!--                                icon-name="pencil"-->
                            <!--                              >-->
                            <!--                                <icon-pencil />-->
                            <!--                              </icon-base>-->
                            <!--                            </button>-->
                            <button @click="deletePDF(index)" class="btn btn-white-icon-rounded btn-sm">
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
                      placeholder="https://www.streamgeeks.com"
                    />
                  </div>
                </div>
              </div>
              <!-- Project Add Content -->
            </div>

            <div class="projectadd-btns">
              <div class="custom-checkbox-group mb-4">
                <label class="custom-checkbox">
                  <input type="checkbox" checked />
                  <span
                  >As Gold Member you can set your new public system as
                    featured</span
                  >
                </label>
              </div>

              <div class="btns">
                <button
                  class="btn btn-primary btn-wide"
                  @click.prevent="publishProject()"
                >
                  Share
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

export default {
  name: "ShareProject",
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
      fixed_payment: false,
      max_upload_files: 5,
      isAuthenticated: window.isAuthenticated,
      publicPath: local_image_path,
      dragActive: false,
      logged_user_id: null,
      categorySelectionItems: [
        "Category 1",
        "Category 2",
        "Category 3",
        "Something 1",
        "Something 2"
      ],
      selection_category_id: null,

      platformSelectionItems: ["Item 1", "Item 2", "Item 3", "Item 4"],
      selection_platform_id: null,

      imageFiles: [],
      selectedCoverImage: "",
      youtubeLink: null,
      pdfFiles: [],
      productFilterValue: "",
      project_title: "",
      project_subtitle: "",
      tagFilterValue: "",
      selectedTags: [],
      selectedProducts: [
        {
          text: "CSS"
        },
        {
          text: "Website Design"
        }
      ],
      autocompleteTagItems: [
        {
          text: "Website Design",
          description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation '
        },
        {
          text: "PSD to HTML",
          description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation "
        },
        {
          text: "CSS",
          description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation "
        },
        {
          text: "MySQL",
          description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation "
        },
        {
          text: "Javascript",
          description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation "
        }
      ],
      autocompleteProductItems: [
        {
          text: "Website Design",
          description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation '
        },
        {
          text: "PSD to HTML",
          description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation "
        },
        {
          text: "CSS",
          description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation "
        },
        {
          text: "MySQL",
          description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation "
        },
        {
          text: "Javascript",
          description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation "
        }
      ]
    };
  }, // data() {

  watch: {
    imageFiles(theFile) {
      console.log("watch theFile::");
      console.log(theFile);

      if (typeof theFile[0] === "undefined") return;

      console.log("watch +++theFile::");
      console.log(theFile);
      let image = new Image();

      image.src = theFile[0].blob;
      console.log("watch image::");
      console.log(image);
      image.onload = function() {
        console.log("imageUploadedEvent this::");
        console.log(this);
        bus.$emit("imageUploadedEvent", this.width, this.height);
      };
    }
  },

  created() {
    document.title = this.$route.meta.title;
  },

  mounted() {
    // if (!this.isAuthenticated || !localStorage.getItem("logged_user_id")) {
    //   this.$toast.error("To open buyer you need to login firstly !");
    //   this.$router.push({ name: "home" });
    // }
    // this.logged_user_id = localStorage.getItem("logged_user_id");
    // this.loadCategoriesList();
    // this.loadPlatformsList();
    // this.loadTags();
    // this.loadProducts();
    // this.initDummy();
  }, // mounted() {

  methods: {
    getEmbed (url) {
      if (url) {
        const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/
        const match = url.match(regExp)
        let id;
        if (match && match[2].length === 11) {
          return match[2]
        }
      }
    },
    initDummy() {
      this.selection_category_id = {
        code: 3,
        label: "Collaboration"
      };

      this.selection_platform_id = { code: 2, label: Epiphan };

      // this.selection_platform_id: null,

      this.project_title = "A";
      this.project_subtitle = "B";
    },

    deleteImage(idx) {
      this.imageFiles.splice(idx, 1);
    },

    deletePDF(idx) {
      this.pdfFiles.splice(idx, 1);
    },

    updateVueProductsInput(newProducts) {
      console.log("updateVueProductsInput newProducts::");
      console.log(newProducts);
      this.selectedProducts = newProducts;
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
      this.categorySelectionItems = result.data.categories;
    }, // async loadCategoriesList() {

    async loadTags() {
      // console.log(' loadTags this.selection_category_id::')
      // console.log(this.selection_category_id)
      const result = await this.callApi(
        "post",
        window.api_path + "getTagsList",
        { mode: "only_title" /*, category_id: this.selection_category_id*/ }
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
      console.log("input file");
      if (newFile && oldFile && !newFile.active && oldFile.active) {
        if (newFile.xhr) {
          console.log("status", newFile.xhr.status);
        }
      }
    },

    inputFilter(newFile, oldFile, prevent) {
      if (newFile && !oldFile) {
        if (!/\.(jpeg|jpe|jpg|gif|png|webp)$/i.test(newFile.name)) {
          return prevent();
        }
      }

      newFile.blob = "";
      let URL = window.URL || window.webkitURL;
      if (URL && URL.createObjectURL) {
        newFile.blob = URL.createObjectURL(newFile.file);
      }
    },

    pdfFilter(newFile, oldFile, prevent) {
      console.log("pdf filter");
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
      // if (!this.isAuthenticated || !localStorage.getItem("logged_user_id")) {
      //   this.$toast.error("To publish project you need to login firstly !");
      //   return;
      // }
      // console.log("this.selection_category_id::");
      // console.log(this.selection_category_id);

      if (this.project_title == "") {
        this.$toast.error("Please enter public system title");
        return;
      }
      if (this.project_subtitle == "") {
        this.$toast.error("Please enter public system subtitle");
        return;
      }
      if (this.selection_category_id === null) {
        this.$toast.error("Please select category");
        return;
      }
      if (this.selection_platform_id === null) {
        this.$toast.error("Please select platform");
        return;
      }

      console.log("this.selectedProducts::");
      console.log(this.selectedProducts);

      const result = await this.callApi(
        "post",
        window.api_path + "publishProject",
        {
          title: this.project_title,
          subtitle: this.project_subtitle,
          category_id: this.selection_category_id.code,
          platform_id: this.selection_platform_id.code,
          products: this.selectedProducts,

          user_id: localStorage.getItem("logged_user_id")
        }
      );
      let self = this;
      if (result.status == 200) {
        self.$toast.success(result.data.message);
        /*
                self.homepageProjects.forEach(function(nextHomepageProject, index) {
                  if (nextHomepageProject.id == project_id) {
                    self.homepageProjects[index].is_already_voted = true;
                  }
                });
                self.homepageProjectsPopular.forEach(function(
                  nextHomepageProjectPopular,
                  index
                ) {
                  if (nextHomepageProjectPopular.id == project_id) {
                    self.homepageProjectsPopular[index].is_already_voted = true;
                  }
                });
                self.homepageProjectsFeatured.forEach(function(
                  nextHomepageProjectFeatured,
                  index
                ) {
                  if (nextHomepageProjectFeatured.id == project_id) {
                    self.homepageProjectsFeatured[index].is_already_voted = true;
                  }
                });
                return;
*/
      }

      this.$toast.error(result.data.message);
    } // async publishProject(project_id) {
  },
  computed: {
    filteredProductItems() {
      return this.autocompleteProductItems.filter(i => {
        return (
          i.text
            .toLowerCase()
            .indexOf(this.productFilterValue.toLowerCase()) !== -1
        );
      });
    },

    filteredTagItems() {
      return this.autocompleteTagItems.filter(i => {
        return (
          i.text.toLowerCase().indexOf(this.tagFilterValue.toLowerCase()) !== -1
        );
      });
    }
  }
};
</script>
