<template>
  <div>
    <Header />

    <section class="section-cpostadd">
      <div class="container">
        <h1>Ask a public question</h1>
        <div class="cpostadd-container wblock">
          <div class="form-group">
            <label>Title</label>
            <input
              type="text"
              class="form-control"
              v-model="newCommunityTitle"
              placeholder="Be Specific and imagine you’re asking a Questation to another person"
              ref="newCommunityTitle"
            />
          </div>
          <div class="form-group">
            <label>Description</label>
            <textarea
              rows="14"
              class="form-control"
              v-model="newCommunityText"
              placeholder="Include all the information someone would need to answer your question"
              ref="newCommunityText"
            ></textarea>
          </div>
          <div class="search-tags custom-search">
            <label>Tags</label>
            <vue-tags-input
              v-model="searchServiceTag"
              :tags="searchServiceTags"
              :autocomplete-items="filteredTags"
              :add-only-from-autocomplete="false"
              :max-tags="5"
              placeholder="Add up to 5 tags to describe what your question is about"
              @tags-changed="
                newSearchServiceTags =>
                  (searchServiceTags = newSearchServiceTags)
              "
              @input="tagChange()"
            />
          </div>
          <!-- <div class="form-group">
            <label>Tags</label>
            <vue-tags-input
              v-model="cposttag"
              :tags="cposttags"
              :autocomplete-items="filteredItems"
              placeholder="Add up to 5 tags to describe what your question is about"
              @tags-changed="newTags => (tags = newTags)"
            />
          </div> -->
          <div class="btns">
            <button
              class="btn btn-primary btn-wide"
              @click.prevent="addNewCommunity"
            >
              Publish
            </button>
          </div>
        </div>
      </div>
    </section>

    <Footer />
  </div>
</template>

<script>
import VueTagsInput from "@johmun/vue-tags-input";
import Header from "./common/Header.vue";
import Footer from "./common/Footer.vue";

export default {
  name: "CommunityAdd",
  components: {
    VueTagsInput,
    Header,
    Footer
  },
  data() {
    return {
      isAuthenticated: true, // window.isAuthenticated,
      publicPath: local_image_path,
      cposttag: "",
      cposttags: [],
      autocompleteTagItems: [],
      searchServiceTag: "",
      searchServiceTags: [],
      autocompleteServiceTags: [],
      newCommunityTitle: null,
      newCommunityText: null,
      logged_user_id:null
    };
  },
  created() {
    document.title = this.$route.meta.title;
    this.redirecturl = "communitydetail/";
  },
  mounted() {
    // if (!this.isAuthenticated || !localStorage.getItem("logged_user_id")) {
    //   this.$toast.error("To open buyer you need to login firstly !");
    //   this.$router.push({ name: "community" });
    // }
     this.logged_user_id = localStorage.getItem("logged_user_id");
    // // this.loadCategoriesList();
    // // this.loadPlatformsList();
     this.loadTags();
    // this.loadProducts();
    // this.initDummy();
    this.scrollToTop();
  },
  methods: {
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
    async addNewCommunity() {
      if (!this.isAuthenticated || !localStorage.getItem("logged_user_id")) {
        this.$toast.error("You need to login first to add questions.");
        return;
      }
      if (!this.newCommunityTitle) {
        this.$toast.error("Title is required!");
        this.$refs.newCommunityTitle.focus()
        return;
      } else if (this.newCommunityTitle.trim() === "") {
        this.$toast.error("Only blank space is not allow!");
        this.$refs.newCommunityTitle.focus()
        this.newCommunityTitle = null;
        return;
      } else if (this.newCommunityTitle.length < 10) {
        this.$toast.error("Enter minimum 10 characters in title!");
        this.$refs.newCommunityTitle.focus()
        return;
      } else if (this.newCommunityTitle.length > 255) {
        this.$toast.error("Enter maximum 255 characters in title!");
        this.$refs.newCommunityTitle.focus()
        return;
      } else if (/<(.|\n)*?>/g.test(this.newCommunityTitle)) {
        this.$toast.error("Html tags are not allowed!");
        this.$refs.newCommunityTitle.focus()
        return;
      }


      if (!this.newCommunityText) {
        this.$toast.error("Description is required!");
        this.$refs.newCommunityText.focus()
        return;
      } else if (this.newCommunityText.trim() === "") {
        this.$toast.error("Only blank space is not allow!");
        this.$refs.newCommunityText.focus()
        this.newCommunityText = null;
        return;
      } else if (this.newCommunityText.length <= 5) {
        this.$toast.error("Description text too short!");
        this.$refs.newCommunityText.focus()
        return;
      } else if (/<(.|\n)*?>/g.test(this.newCommunityText)) {
        this.$toast.error("Html tags are not allowed!");
        this.$refs.newCommunityText.focus()
        return;
      }

      const result = await this.callApi(
        "post",
        window.api_path + "community/questionadd",
        {
          title: this.newCommunityTitle,
          user_id: this.logged_user_id,
          desc: this.newCommunityText,
          tags: this.searchServiceTags
        }
      );

      if (result.status != 200) {
        this.$toast.error(result.data.message);
        return;
      }
      this.newCommunityText = "";
      this.$toast.success("Your question was sent successfully");
      this.$router.push(this.redirecturl + result.data.slug);
    },
    scrollToTop() {
      window.scrollTo(0,0);
    },
    tagChange(){
      if(this.searchServiceTags.length == 5){
        this.$toast.error("Up to 5 tags are allowed to add!");
      }
    },
  },
  computed: {
    filteredTags() {
      console.log(this.searchServiceTag);
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
