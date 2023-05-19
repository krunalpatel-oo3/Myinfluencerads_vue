
<template>
  <div>
    <loading
      :active.sync="isLoading"
      :can-cancel="false"
      :is-full-page="fullPage"
      background-color="#000"
      color="#202c54"
    ></loading>

    <Header />

    <main class="main">
      <!-- Education Hero -->
      <section class="section-education-hero">
        <div class="container">
          <h1>Education</h1>
          <p>A small description about the project will be here in the text</p>
        </div>
        <div class="education-hero-bg"></div>

      </section>
           <!-- Search -->
      <section class="section-search section-search-cposts">
        <div class="section-search-form">
          <label class="custom-label">Search</label>
          <div class="search-form-w">
             <icon-base
                width="23.5"
                height="23.5"
                view-box="0 0 16 16"
                icon-name="search"
              >
                <icon-search
                />
              </icon-base>
              <input
                type="text"
                class="form-control"
                v-model="search_text"
                placeholder="Find education"
              />
              <button type="submit" class="btn btn-secondary" @click.prevent="loadEducationsList()">
                <span class="text">Search</span>
                <icon-base
                  width="23.5"
                  height="23.5"
                  view-box="0 0 16 16"
                  icon-name="search"
                >
                  <icon-search
                  />
                </icon-base>
              </button>
          </div>
          <div class="search-tags custom-search">
            <label class="custom-label">Tags</label>
            <vue-tags-input
              v-model="searchServiceTag"
              :tags="searchServiceTags"
              :autocomplete-items="filteredItems"
              placeholder="Tags"
              @tags-changed="newTags => searchServiceTags = newTags"
            />
          </div>
        </div>
      </section>
      <!-- End of Search -->
      <!-- End of Education Hero -->

      <!-- Education List -->
      <section class="section-education section-education-list">
        <div class="container">
          <div class="row">
            <div class="col-lg-8 education-articles">
              <h2 class="h1">Articles</h2>
              <div v-if="!educationsListArticles.length" class="notification notice closeable"><h3 class="mt-3 text-center text-white">No record found..</h3></div>
              <div v-for="(nextEducationsListArticles,index) in educationsListArticles" :key="index" v-if="!!index == 0">
                  <div class="card card-dark card-lg card-article" v-if="index == 0" >
                <div class="card-img-top">
                  <router-link  :to="{
                      name: 'educationdetail',
                      params: { slug: nextEducationsListArticles.slug }
                    }">
                    <img :src="nextEducationsListArticles.educationArticleItemImageProps.image_url" alt=""  @error="setAltEduImg"/>
                  </router-link>
                </div>
                <div class="card-body">
                  <div class="card-title">
                <router-link
                    :to="{
                      name: 'educationdetail',
                      params: { slug: nextEducationsListArticles.slug }
                    }"
                  >{{ nextEducationsListArticles.title.substring(0,120) }}
                  </router-link>
                  </div>

                  <p class="card-text"  v-html="nextEducationsListArticles.short_desc.substring(0,300) + '...'"></p>

                  <div class="more">
                    <router-link   :to="{
                      name: 'educationdetail',
                      params: { slug: nextEducationsListArticles.slug }
                    }" class="btn btn-link btn-icon">
                      <span>Learn More</span>
                      <icon-base
                        width="18"
                        height="8.72"
                        view-box="0 0 18 8.72"
                        icon-name="arrow-right"
                      >
                        <icon-arrow-right />
                      </icon-base>
                    </router-link>
                  </div>
                </div>
              </div>
              </div>
              <div class="row">
                <div class="col-sm-6" v-for="(nextEducationsListArticles,index) in educationsListArticles" :key="index"  v-if="!!index != 0"  >
                  <div class="card card-dark card-article"  >
                    <div class="card-img-top">
                      <router-link  :to="{
                      name: 'educationdetail',
                      params: { slug: nextEducationsListArticles.slug }
                    }">
                        <img :src="nextEducationsListArticles.educationArticleItemImageProps.image_url" alt="" @error="setAltEduImg" />
                      </router-link>
                    </div>
                    <div class="card-body">
                      <div class="card-title">
                        <router-link
                    :to="{
                      name: 'educationdetail',
                      params: { slug: nextEducationsListArticles.slug }
                    }"
                  >{{ nextEducationsListArticles.title.substring(0,25) }}
                  </router-link>
                      </div>

                      <p class="card-text" style="height: 50px;" v-html="nextEducationsListArticles.short_desc.substring(0,80) + '...'" ></p>
                      <div class="more">
                       <router-link   :to="{
                      name: 'educationdetail',
                      params: { slug: nextEducationsListArticles.slug }
                    }" class="btn btn-link btn-icon">
                      <span>Learn More</span>
                      <icon-base
                        width="18"
                        height="8.72"
                        view-box="0 0 18 8.72"
                        icon-name="arrow-right"
                      >
                        <icon-arrow-right />
                      </icon-base>
                    </router-link>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

          <paginate
              v-model="page"
              :page-count="totalPages"
              :page-range="3"
              :margin-pages="2"
              :prev-text="'Prev'"
              :next-text="'Next'"
              :container-class="'pagination'"
              :page-class="'page-item'"
            >
            </paginate>


            </div>
            <div class="col-lg-4 education-books">
              <div class="education-books-container">
                <h2>Books</h2>

                <div class="bcard" v-for="(nexteducationsListBooks,index) in educationsListBooks" :key="index" >
                  <div class="bcard-img-top">
                    <a :href="nexteducationsListBooks.educationOtherArticleItemBookProps.book_url" target="_blank">
                      <img style="height:350px !important" :src="nexteducationsListBooks.educationOtherArticleItemImageProps.image_url" alt="" @error="setAltEduImg" />
                    </a>
                  </div>
                  <div class="bcard-body">
                    <div class="bcard-title" style="cursor: pointer;">
                       {{ nexteducationsListBooks.title.substring(0,40) }}
                    </div>

                    <p class="bcard-text" v-html="nexteducationsListBooks.short_desc.substring(0,70)">

                    </p>
                    <a style="cursor: pointer;" v-bind:href="nexteducationsListBooks.educationOtherArticleItemBookProps.book_url"
                      class="btn btn-outline-primary btn-sm" @click.prevent="book_detail(nexteducationsListBooks.id)">
                      Download
                    </a>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>

        <div class="section-bg"></div>
      </section>
      <!-- End of Education List -->
    </main>

    <Footer />
  </div>
</template>


<script>
import Paginate from "vuejs-paginate";
import VueTagsInput from "@johmun/vue-tags-input";
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import Header from "./common/Header.vue";
import Footer from "./common/Footer.vue";
import IconBase from "./common/IconBase.vue";
import IconArrowRight from "./common/icons/IconArrowRight.vue";
import IconSearch from "./common/icons/IconSearch";
import {saveAs} from 'file-saver';

export default {
  name: "Education",
  components: {
    Header,
    Footer,
    VueTagsInput,
    Loading,
    Paginate,
    IconBase,
    IconArrowRight,
    IconSearch
  },
  data() {
    return {
      isLoading: false,
      logged_user_id: null,
      educationsListArticles: [],
      educationsListBooks: [],
      search_text : '',
      searchServiceTag: "",
      searchServiceTags: [],
      autocompleteServiceTags: [],
      autocompleteTagItems:[],
      fullPage: true,
      publicPath: local_image_path,
      totalPages: 0,
      page: 1,
      tag: '',
      tags: [],
      autocompleteItems: [],
      url:'https://78.media.tumblr.com/tumblr_m39nv7PcCU1r326q7o1_500.png'
    };
  },
    watch: {
      page () {
      this.loadEducationsList()
    },
    '$route' (to, from) {
     // this.$router.go()
    }
  },
  created() {
    document.title = this.$route.meta.title;
  },
  mounted() {
    if(this.$route.query.key != null){
      this.search_text = this.$route.query.key;
    }

    if(this.$route.query.tag != null && this.$route.query.tag != '' ){
      this.searchServiceTagsUrl = this.$route.query.tag.split(',');
      var rows = [];
      this.searchServiceTagsUrl.forEach((entry_tag) => {
        rows.push({"text":entry_tag});
      });
      this.searchServiceTags = rows;
    }
    this.logged_user_id = localStorage.getItem("logged_user_id");
    this.loadEducationsList();
    this.loadTags();
    this.scrollToTop();
    // this.userBookDetails(0);
    //this.loadTags();
  },
  methods: {
      scrollToTop() {
        window.scrollTo(0,0);
      },
      setAltEduImg(event) {
        event.target.src = base_url + "images/emptyImg.png";
      },
      async loadEducationsList() {
      this.isLoading = true;
      var query="";
      var rows_tag = [];
      this.searchServiceTags.forEach((arry_tag) => {
        rows_tag.push(arry_tag.text);
      });
      if(this.search_text != ""){
          this.$router.push({ path: '/education', query: { key: this.search_text,tag:rows_tag.toString() }}).catch(()=>{});
      }
      else if(rows_tag.toString() != ""){
          this.$router.push({ path: '/education', query: { key: this.search_text,tag:rows_tag.toString() }}).catch(()=>{});
      }else{
          this.$router.push({ path: '/education'}).catch(()=>{});
      }
      const result = await this.callApi(
        'post',
        window.api_path + 'education/listing',
        {
          page: this.page,
          logged_user_id: this.logged_user_id,
          search_text: this.search_text,
          tags: this.searchServiceTags,
        }
      );
      console.log('loadEducationsList result::')
      console.log(result)
      if (result.status != 200) {
        this.isLoading = false;
        this.$toast.error(result.data.message);
        this.educationsList = [];
        this.totalPages = 0;
        this.page = 1;
        return;
      }
      this.isLoading = false;
      this.educationsListArticles = result.data.data.educationOtherArticles;
      this.educationsListBooks = result.data.data.educationAlsoLikeBooks;
      this.totalPages = result.data.data.totalPages;
      this.page = result.data.data.page;

    } ,
    // clickCallback(page) {
    //   this.loadEducationsList(page);
    // },
    async book_detail(current_book_id){
      this.isLoading = true;
      const result = await this.callApi(
        "post",
        window.api_path + "education/book_download",
        {
          id: this.logged_user_id,
          book_id : current_book_id
        }
      );
      if (result.data.status) {
        saveAs(result.data.file, 'education_book.pdf');
        setTimeout(() => {
          this.$toast.success(result.data.msg);
        }, 2000);
        this.isLoading = false;
      }else{
        this.$toast.error(result.data.msg);
        this.autocompleteTagItems = [];
        this.isLoading = false;
        return;
      }
    },

    async loadTags() {
      const result = await this.callApi(
        "post",
        window.api_path + "getTagsList",
        { mode: "only_title" }
      );
      if (result.status != 200) {
        this.$toast.error(result.data.message);
        this.autocompleteItems = [];
        return;
      }
      //
      this.autocompleteItems = result.data.tags;
    },
  },
   computed: {
    filteredItems() {
      return this.autocompleteItems.filter(i => {
        return i.text.toLowerCase().indexOf(this.searchServiceTag.toLowerCase()) !== -1;
      });
    },
  }
};
</script>
