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
      <!-- Community Questions List -->
      <section class="section-cposts">
        <header class="cposts-h">
          <div class="container">
            <h1>Questions</h1>
            <router-link
              :to="{
                name: 'communityadd'
              }"
              class="btn btn-primary"
            >
              Ask a Question
            </router-link>
          </div>
        </header>

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
                <icon-search />
              </icon-base>
              <input
                type="text"
                class="form-control"
                v-model="search_text"
                placeholder="Find Questions"
              />
              <button
                type="submit"
                class="btn btn-secondary"
                @click.prevent="loadCommunitiesList(1)"
              >
                <span class="text">Search</span>
                <icon-base
                  width="23.5"
                  height="23.5"
                  view-box="0 0 16 16"
                  icon-name="search"
                >
                  <icon-search />
                </icon-base>
              </button>
            </div>
            <div class="search-tags custom-search">
              <label class="custom-label">Tags</label>
              <vue-tags-input
                v-model="searchServiceTag"
                :tags="searchServiceTags"
                :autocomplete-items="filteredTags"
                :add-only-from-autocomplete="true"
                placeholder="Tags"
                @tags-changed="
                  newSearchServiceTags =>
                    (searchServiceTags = newSearchServiceTags)
                "
              />
            </div>
          </div>
        </section>
        <!-- End of Search -->

        <div class="container">
          <div v-if="!communitiesList.length" class="col-xl-12 col-lg-12 p-3">
            <div class="notification notice closeable"><h3 class="mt-3 text-center">No record found..</h3></div>
          </div>

          <div v-if="communitiesList.length" class="cpost-list">
            <!-- Community question -->
            <div
              v-for="nextCommunity in communitiesList"
              :key="nextCommunity.id"
              class="cpost"
            >
              <div class="cpost-body">
                <div class="cpost-title">
                  <router-link style="cursor: pointer;"
                    :to="{
                      name: 'communitydetail',
                      params: { slug: nextCommunity.slug }
                    }"
                    >{{ nextCommunity.title.substring(0, 120) }}
                  </router-link>
                </div>
                <div
                  class="cpost-text"
                  v-html="nextCommunity.desc.substring(0, 250) + '...'"
                ></div>
              </div>

              <div class="cpost-footer">
                <ul class="tags" v-if="nextCommunity.community_tag_tagged.length > 0">
                  <li v-for="nextCommunityTagTagged in nextCommunity.community_tag_tagged"
                      :key="nextCommunityTagTagged.id">
                    <a v-if="nextCommunityTagTagged.tag != null" style="cursor: pointer;" @click.prevent="searchTags(nextCommunityTagTagged.tag.title,nextCommunityTagTagged.tag.id)" :class="['tag-'+nextCommunityTagTagged.tag.color, 'tag']" >{{ nextCommunityTagTagged.tag.title }}</a>
                  </li>
                </ul>

                <div class="cpost-info">
                  <div class="cpost-info-item">
                    <div class="num">
                      {{
                        nFormatter(nextCommunity.user_community_vote_count, 1)
                      }}
                    </div>
                    <div class="lbl">
                      <icon-base
                        width="14"
                        height="13.07"
                        view-box="0 0 20 18.67"
                        icon-name="like"
                      >
                        <icon-like />
                      </icon-base>
                      <span>Votes</span>
                    </div>
                  </div>
                  <div class="cpost-info-item">
                    <div class="num">
                      {{ nFormatter(nextCommunity.community_answer_count, 1) }}
                    </div>
                    <div class="lbl">
                      <icon-base
                        width="14"
                        height="14"
                        view-box="0 0 19 18.96"
                        icon-name="answers"
                      >
                        <icon-answers />
                      </icon-base>
                      <span>Answers</span>
                    </div>
                  </div>
                  <div class="cpost-info-item">
                    <div class="num">
                      {{
                        nFormatter(nextCommunity.user_community_viewed_count, 1)
                      }}
                    </div>
                    <div class="lbl">
                      <icon-base
                        width="14.57"
                        height="9.38"
                        view-box="0 0 19.23 12.38"
                        icon-name="views"
                      >
                        <icon-views />
                      </icon-base>
                      <span>Views</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- End of Community question -->
          </div>

          <paginate
            v-if="totalPages > 1"
            :page-count="totalPages"
            :click-handler="clickCallback"
            :prev-text="'Prev'"
            :next-text="'Next'"
            :container-class="'pagination'"
            :page-class="'page-item'"
          >
          </paginate>
        </div>
      </section>
      <!-- End of Community Questions List -->
    </main>

    <Footer />
  </div>
</template>

<script>
import Vue from "vue";
import VueTagsInput from "@johmun/vue-tags-input";
import vSelect from "vue-select";
import Paginate from "vuejs-paginate";
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import appMixin from "../appMixin";
import Header from "./common/Header.vue";
import Footer from "./common/Footer.vue";
import IconBase from "./common/IconBase.vue";
import IconSearch from "./common/icons/IconSearch.vue";
import IconLike from "./common/icons/IconLike.vue";
import IconAnswers from "./common/icons/IconAnswers.vue";
import IconViews from "./common/icons/IconViews.vue";
Vue.component("v-select", vSelect);
import "vue-select/dist/vue-select.css";
export default {
  name: "Community",
  components: {
    Header,
    VueTagsInput,
    Footer,
    Loading,
    Paginate,
    IconBase,
    IconSearch,
    IconLike,
    IconAnswers,
    IconViews
  },

  mixins: [appMixin],

  data() {
    return {
      isLoading: false,
      isAuthenticated: window.isAuthenticated,
      logged_user_id: null,
      communitiesList: [],
      search_text: "",
      autocompleteTagItems: [],
      searchServiceTag: "",
      searchServiceTags: [],
      searchServiceTagsUrl: [],
      autocompleteServiceTags: [],
      totalPages: 0,
      fullPage: ''
      // compagecount: 1 //???
    };

  },
    watch: {
    '$route' (to, from) {
  // this.$router.go()

    }
  },
  created() {
    document.title = this.$route.meta.title;
  },
  mounted() {
    this.scrollToTop();
    this.logged_user_id = localStorage.getItem("logged_user_id");
    if(this.$route.query.key != null){
      this.search_text = this.$route.query.key;
    }
    if(this.$route.query.tag != null){
      this.searchServiceTagsUrl = this.$route.query.tag.split(',');
      var rows = [];
      this.searchServiceTagsUrl.forEach((entry_tag) => {
        rows.push({"text":entry_tag});
      });
      this.searchServiceTags = rows;
    }
    this.loadCommunitiesList(1);
    this.loadTags();
  },

  methods: {
    clickCallback(page) {
      this.loadCommunitiesList(page);
    },
    scrollToTop() {
      window.scrollTo(0,0);
    },
    async loadTags() {
      const result = await this.callApi(
        "post",
        window.api_path + "getTagsList",
        { mode: "only_title" }
      );
      if (result.status != 200) {
        this.$toast.error(result.data.message);
        this.autocompleteTagItems = [];
        return;
      }
      //
      this.autocompleteTagItems = result.data.tags;
    },
//search by tag click
    async searchTags(tag,id) {
      //this.searchServiceTag = tag;
      this.searchServiceTags = [{text: tag, id: id,  tiClasses: ["ti-valid"]}];// [{text: tag, id: 7}];
      this.loadCommunitiesList(1);
    },

    async loadCommunitiesList(pageNum) {
      this.scrollToTop();
      let checkedTags = [];
      // for (let i = 0; i < this.autocompleteTagItems.length; i++) {
      //   if (this.autocompleteTagItems[i].checked) {
      //     checkedTags.push(this.autocompleteTagItems[i].id);
      //   }
      // }
      var query="";
      var rows_tag = [];
      this.searchServiceTags.forEach((arry_tag) => {
        rows_tag.push(arry_tag.text);
      });


      if(this.search_text != ""){
          this.$router.push({ path: '/community', query: { key: this.search_text,tag:rows_tag.toString() }}).catch(()=>{});
      }
      else if(rows_tag.toString() != ""){
          this.$router.push({ path: '/community', query: { key: this.search_text,tag:rows_tag.toString() }}).catch(()=>{});

      }else{
          this.$router.push({ path: '/community'}).catch(()=>{});

      }



      this.isLoading = true;
      const result = await this.callApi(
        "post",
        window.api_path + "community/list",
        {
          page: pageNum,
          logged_user_id: this.logged_user_id,
          search_text: this.search_text,
          tags: this.searchServiceTags
        }
      );
      console.log(result);
     if (result.status != 200) {
        this.isLoading = false;
        this.$toast.error(result.data.message);
        this.communitiesList = [];
        this.totalPages = 0;
        return;
      }
      this.isLoading = false;
      this.communitiesList = result.data.data.communities;
      this.totalPages = result.data.data.totalPages;
    } // async loadCommunitiesList(pageNum) {
  },
  computed: {
    filteredTags() {

      return this.autocompleteTagItems.filter(i => {

    return (
          i.text.toLowerCase().indexOf(this.searchServiceTag.toLowerCase()) !==
          -1
        );
      });
    }
  }
};
</script>

<style scoped>
  .cpost .cpost-footer{
    -ms-flex-wrap:wrap;
    flex-wrap:wrap;
  }
  .cpost-footer .tags{
    width:100%;
    margin-right:0;
  }
  .cpost-footer .cpost-info{
    width:100%;
    -webkit-box-pack:end;
    -ms-flex-pack:end;
    justify-content:flex-end;
  }

  .cpost-footer .cpost-info{
    padding-top:13px;
    margin-top:13px;
    border-top: 2px solid #D2D5DD;
  }
  .cpost-info .cpost-info-item {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: start;
    -ms-flex-pack: start;
    justify-content: flex-start;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
  }
  .cpost-info .cpost-info-item .lbl .icon-w{
    margin-right:8px;
  }
  .cpost-info .cpost-info-item .num{
    margin-right: 3px;
    font-weight: 500;
    font-size: 12px;
    line-height: 54px;
  }
  .cpost-info .cpost-info-item .num + span{
    font-weight: 500;
    font-size: 12px;
    line-height: 54px;
  }
  </style>
