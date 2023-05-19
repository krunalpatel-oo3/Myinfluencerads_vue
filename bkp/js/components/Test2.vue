<template>
  <article class="page_content_container">
    <Header />

    <div class="page_content p-4" >

      <img v-if="educationImagePropsArray" class="m-1 p-1" :src="educationImagePropsArray.image_url"
           alt="Education Image"/>

<!--            {{ educationDesc}}<hr><hr><hr>-->
            <span class="m-4" v-html="educationDesc"></span>


      <fieldset class="blocks" style="display: none">
            <legend class="blocks p-3">Image Preview/Upload</legend>

            <img v-if="taskHasImage(taskRow)" class="m-1 p-1 img-preview-wrapper img_full_width_wrapper" :src="taskRow.filenameData.image_url"
                 alt="Education Image"/>
            <div class="alert alert-info m-1 p-1 row_content_left_aligned" role="alert" v-if="taskHasImage(taskRow)">

              <ul class="ul_horiz_lis">
                <li class="ul_horiz_lis_left_aligned m-1 p-1">
                  <div class="pre-formatted" v-html="taskRow.filenameData.file_info"></div>
                </li>
                <li class="ul_horiz_lis_right_aligned">
                  <a v-on:click="removeTaskImage()" class="btn btn-sm m-2 btn_right_aligned">
                    <i class="fa fa-remove a_link" title="Delete task"></i>Remove
                  </a>
                </li>
              </ul>

            </div>

            <file-upload
              ref="upload"
              v-model="imageFiles"
              post-action="/post.method"
              put-action="/put.method"
              @input-file="inputFile"
              @input-filter="inputFilter"
              :multiple="false"
              class="btn btn-outline-secondary btn-sm m-2"
            >
              Upload image
            </file-upload>

            <table class="m-2 p-0">
              <tr v-for="nextFile in imageFiles" :key="nextFile.name">
                nextFile::{{nextFile}}<br>
                <img :src="nextFile.blob" class="img-preview-wrapper img_full_width_wrapper" id="uploaded_image_file"/>
                <div class="row_content_centered p-3">
                  <div class="p-2">
                    Name : <strong>{{ nextFile.name }}</strong>
                  </div>
                  <div class="p-2">
                    Size : <strong>{{ getFileSizeAsString(nextFile.size) }}</strong>
                  </div>

                  <div v-show="uploaded_image_width" class="p-2">
                    Width : <strong>{{ uploaded_image_width }}px</strong>
                  </div>

                  <div v-show="uploaded_image_height" class="p-2">
                    Height : <strong>{{ uploaded_image_height }}</strong>
                  </div>
                </div>
              </tr>

            </table>

            <div class="row_content_right_aligned" v-show="imageFiles.length">
              <button type="reset" class="btn btn-danger btn-sm m-3" @click.prevent="cancelTaskImage()">
                Cancel
              </button>
              <button type="button" class="btn btn-success btn-sm m-3 ml-4 mr-4" @click.prevent="uploadTaskImage()">
                Upload
              </button>
            </div>
          </fieldset>


    </div> <!-- page_content -->

  </article> <!-- page_content_container -->
</template>

<script>
import { bus } from "../app";
import axios from 'axios'
import Vue from 'vue'
import Header from "./common/Header.vue";
import Footer from "./common/Footer.vue";

const VueUploadComponent = require('vue-upload-component')
Vue.component('file-upload', VueUploadComponent)


export default {
  name: 'Test2',

  components: {
    Header,
    Footer,
  },

  data() {
    return {
      educationDesc: '',
      value: '',

      task_id: null,
      taskRow: {
        name: '',
        price: 0,
        description: '',
        educationImagePropsArray: [],
        date_start: null,
        date_end: null,
        date_start_formatted: null,
        date_end_formatted: null
      },
      imageFiles: [],
      uploaded_image_width: null,
      uploaded_image_height: null,

    }
  }, // data () {

  watch: {
    imageFiles(theFile) {
      console.log('watch theFile::')
      console.log(theFile)

      if (typeof theFile[0] === 'undefined') return

      console.log('watch +++theFile::')
      console.log(theFile)
      let image = new Image()


      image.src = theFile[0].blob
      console.log('watch image::')
      console.log(image)
      image.onload = function () {
        console.log('imageUploadedEvent this::')
        console.log(this)
        bus.$emit('imageUploadedEvent', this.width, this.height)
      }
    }
  },

  created() {
    bus.$on('imageUploadedEvent', (uploaded_image_width, uploaded_image_height) => {
      this.uploaded_image_width = uploaded_image_width
      this.uploaded_image_height = uploaded_image_height
    })

  },  //  created() {

  mounted() {
    this.loadEducationTest();

  },

  methods: {


      async loadEducationTest() {
        const result = await this.callApi(
          "post",
          window.api_path + "getEducationTest",
          {
          }
        );

          this.educationDesc = result.data.desc;
          this.educationImagePropsArray = result.data.educationImagePropsArray;
      }, // loadCMSItemByKey() {


      inputFile(newFile, oldFile) {
      console.log('inputFile newFile::')
      console.log(newFile)

      this.taskRow.imageFile = newFile

      if (newFile && oldFile && !newFile.active && oldFile.active) {
        if (newFile.xhr) {
          console.log('status', newFile.xhr.status)
        }
      }
    },

    inputFilter(newFile, oldFile, prevent) {
      console.log('inputFilter newFile::')
      console.log(newFile)

      if (newFile && !oldFile) {
        if (!/\.(jpeg|jpe|jpg|gif|png|webp)$/i.test(newFile.name)) {
          return prevent()
        }
      }

      newFile.blob = ''
      let URL = window.URL || window.webkitURL
      if (URL && URL.createObjectURL) {
        newFile.blob = URL.createObjectURL(newFile.file)
      }
    },

    cancelTaskImage() {
      this.imageFiles = []
      this.uploaded_image_width = null
      this.uploaded_image_height = null
    },

    uploadTaskImage() {
      let self = this

      fetch(this.taskRow.imageFile.blob).then(function (response) {
        if (response.ok) {
          return response.blob().then(function (imageBlob) {
            let imageUploadData = new FormData()
            imageUploadData.append('id', self.taskRow.id)
            imageUploadData.append('image', imageBlob)
            imageUploadData.append('image_filename', self.taskRow.imageFile.name)

            self.credentialsConfig.headers.Authorization = 'Bearer ' + self.currentLoggedUserToken
            self.is_page_updating = true
            axios.post(self.apiUrl + '/adminarea/tasks/upload_image', imageUploadData, self.credentialsConfig).then(({data}) => {
              self.is_page_updating = false
              self.showPopupMessage('Image upload', 'Image uploaded successfully !', 'success')

              if (typeof data.task[0] != 'undefined') {
                self.taskRow = data.task[0]
              }
              self.cancelTaskImage()
            }).catch((error) => {
              console.error(error)
              self.is_page_updating = false
              self.showPopupMessage('Image upload', 'Image uploading error : ' + error.response.data.message + ' !', 'warn')
            })
          })
        } else {
          return response.json().then(function (jsonError) {
            console.error(jsonError)
          })
        }
      }).catch(function (error) {
        console.error(error)
        console.log('There has been a problem with your fetch operation: ', error.message)
      }) // fetch(this.taskRow.imageFile.blob).then(function (response) {


    },
    removeTaskImage() {
      console.log('removeTaskImage::')
    }, //removeTask(id, task_name, index) {

    taskHasImage(task) {
      if (typeof task['filenameData'] == "undefined") return false
      if (task['filenameData'] === null) return false
      if (typeof task['filenameData'].image_url == "undefined") return false
      if (typeof task['filenameData'].image_url == "string") return true
      return true
    },

    getFileSizeAsString: function (file_size) {
      if (parseInt(file_size) < 1024) {
        return file_size + 'b'
      }
      if (parseInt(file_size) < 1024 * 1024) {
        return Math.floor(file_size / 1024) + 'kb'
      }
      return Math.floor(file_size / (1024 * 1024)) + 'mb'
    },


  }
  , // methods: {

  computed: {
  }

}
</script>
