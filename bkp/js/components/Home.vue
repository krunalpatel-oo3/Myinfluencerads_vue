<template>
  <div>
    <Header />
    <main class="main">
      <!-- Intro -->
      <section
        class="section-intro"
        :style="{ backgroundImage: `url(${publicPath}home-intro-bg.jpg)` }"
      >
        <div class="container">
          <div class="intro-i">
            <h1 v-html="homepageJoinOurCommunityBlockHeaderText"></h1>

            <div class="btns">
              <a @click.prevent="$modal.show('register-modal-dialog')" v-if="!isAuthenticated"
                 class="btn btn-primary btn-lg">Join Now</a>
                 <router-link :to="{ name: 'communityadd' }" class="btn btn-primary btn-lg" style="width: 222px">
                  Ask a Question
                 </router-link>
            </div>
          </div>
        </div>
      </section>

      <!-- Community -->
      <CommunityHome
        :header-text="homepageCommunityListingBlockHeaderText"
      />

      <!-- Systems -->
      <SystemsHome
        :header-text="homepageProjectsListingBlockHeaderText"
      />

      <!-- Background text -->
      <section
        class="section-home-info"
        :style="{ backgroundImage: `url(${publicPath}home-info-bg.jpg)` }"
      >
        <div class="container">
          <p v-html="homepageTheSiteAreGroupBlockHeaderText"></p>
        </div>
      </section>

      <!-- Education Section -->
      <EducationSection
        :header-text="homepageEducationBlockHeaderText"
      />

      <!-- Products -->
       <ProductSection
        :header-text="homepageGigsListingBlockHeaderText"
       />
    </main>

    <Footer />
  </div>
</template>

<script>
import appMixin from "../appMixin";
import Header from "./common/Header.vue";
import Footer from "./common/Footer.vue";
import CommunityHome from "./home/CommunitySection";
import SystemsHome from "./home/SystemsSection";
import EducationSection from "./home/EducationSection";
import ProductSection from "./home/ProductSection";

export default {
  name: "Home",
  components: {
    Header,
    Footer,
    SystemsHome,
    EducationSection,
    ProductSection,
    CommunityHome,
  },
  mixins: [appMixin],
  data() {
    return {
      isAuthenticated: window.isAuthenticated,
      homepageProjectsListingBlockHeaderText: "",
      homepageGigsListingBlockHeaderText: "",
      homepageCommunityListingBlockHeaderText: "",
      homepageJoinOurCommunityBlockHeaderText: "",
      homepageEducationBlockHeaderText: "",
      homepageTheSiteAreGroupBlockHeaderText: "",
      educationBooks: [],
      searchServiceTags: [],
      publicPath: local_image_path
    };
  },
  created() {
    document.title = this.$route.meta.title;
  },
  mounted() {
    this.loadCMSItemByKey("projects_listing_block_header");
    this.loadCMSItemByKey("gigs_listing_block_header");
    this.loadCMSItemByKey("community_listing_block_header");
    this.loadCMSItemByKey("join_our_community_block_header");
    this.loadCMSItemByKey("education_block_header");
    this.loadCMSItemByKey("the_site_are_group_block_header");
  },
  methods: {
    async loadCMSItemByKey(CMSItemKey) {
      const result = await this.callApi(
        "post",
        window.api_path + "getBlockCMSItem",
        {
          key: CMSItemKey
        }
      );

      if (CMSItemKey === "projects_listing_block_header") {
        this.homepageProjectsListingBlockHeaderText = result.data.cMSItem.text;
      }
      if (CMSItemKey === "gigs_listing_block_header") {
        this.homepageGigsListingBlockHeaderText = result.data.cMSItem.text;
      }
      if (CMSItemKey === "community_listing_block_header") {
        this.homepageCommunityListingBlockHeaderText = result.data.cMSItem.text;
      }
      if (CMSItemKey === "join_our_community_block_header") {
        this.homepageJoinOurCommunityBlockHeaderText = result.data.cMSItem.text;
      }
      if (CMSItemKey === "education_block_header") {
        this.homepageEducationBlockHeaderText = result.data.cMSItem.text;
      }
      if (CMSItemKey === "the_site_are_group_block_header") {
        this.homepageTheSiteAreGroupBlockHeaderText = result.data.cMSItem.text;
      }
    },
  },
  computed: {
    filteredTags() {
      return this.autocompleteServiceTags.filter(i => {
        return (
          i.text.toLowerCase().indexOf(this.searchServiceTag.toLowerCase()) !==
          -1
        );
      });
    }
  }
};
</script>
