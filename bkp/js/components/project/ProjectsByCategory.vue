<template>
  <div>
<!--    <Header/>-->

    <!-- Titlebar -->
    <div class="single-page-header">
      <div class="container">

      resources/js/components/ProjectsByCategory.vue

      </div>
    </div>

<!--    <Footer/>-->

  </div>
</template>

<script>
import Header from "../common/Header.vue";
import Footer from "../common/Footer.vue";

export default {
  name: "ProjectsByCategory",
  components: {
    Header,
    Footer,
  },
  data() {
    return {
      publicPath: local_image_path,
      bgimage: local_image_path + "single-job.jpg",
    };
  },
  created() {
    // document.title = this.$route.meta.title;
  },

  mounted() {
  },
};
</script>
