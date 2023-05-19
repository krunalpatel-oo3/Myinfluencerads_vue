<template>
  <div>
    <Header />

    <main class="main">
      <!-- Email Verified -->
      <section class="section-email-verified">
        <div class="container">
          <div class="semail-verified-message wblock">
               <img :src="`${publicPath}email-verified.png`" alt="" />
            <h2>Congratulations!</h2>
            <p>Your Email Is Verified!</p>
          </div>
        </div>
      </section>
    </main>

    <Footer />
  </div>
</template>

<script>
import Header from "./common/Header.vue";
import Footer from "./common/Footer.vue";

export default {
  name: "email-verified",
  components: {
    Header,
    Footer
  },
  data() {
    return {
       publicPath: local_image_path,
    };
  },
  created() {
    document.title = this.$route.meta.title;
  }
};
</script>
