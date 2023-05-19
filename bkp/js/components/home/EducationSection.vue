<template>
  <section class="section-books">
    <div class="container">
      <h2 class="h1">Education</h2>

      <p class="desc" v-html="headerText"></p>

      <ul class="nav nav-ctabs">
        <li
          v-for="nav in educationTabs"
          class="nav-link"
          :class="nav === educationTab ? 'active' : ''"
          @click="educationTab = nav"
        >
          {{ nav }}
        </li>
      </ul>

      <div class="tabs-content">
        <div class="tab-content" v-if="educationTab === 'Newest'">
          <div class="row">
            <div class="col-lg-3 col-sm-6" v-for="educationBook in educationList" :key="educationBook.id">
              <div class="bcard">
                <div class="bcard-img-top">
                  <router-link  :to="{
                      name: 'educationdetail',
                      params: { slug: educationBook.slug }
                    }">
                    <img style="height: 420px !important; object-fit: cover"
                         :src="educationBook.educationOtherArticleItemImageProps ? educationBook.educationOtherArticleItemImageProps.image_url : '${publicPath}book-1.jpg'"
                         alt="" @error="setAltEduImg"/>
                  </router-link>
                </div>
                <div class="bcard-body">
                  <div class="bcard-title">
                    <router-link  :to="{
                      name: 'educationdetail',
                      params: { slug: educationBook.slug }
                    }">{{ educationBook.title }}</router-link>
                  </div>

                  <p class="bcard-text" style="height: 100px !important;">
                    {{ educationBook ? educationBook.short_desc.substring(0, 150) : '' }}
                  </p>
                  <a v-bind:href="educationBook.educationOtherArticleItemBookProps.book_url"
                     class="btn btn-outline-secondary btn-sm" target="_blank" @click.prevent="book_detail(educationBook.id)"
                  >Download
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="view-all">
        <router-link :to="{ name: 'education' }">View All</router-link>
      </div>
    </div>
  </section>
</template>

<script>
import {saveAs} from 'file-saver';
export default {
  name: "EducationSection",
  props: [
    "headerText"
  ],
  data () {
    return {
      educationList: [],
      educationTab: "Newest",
      educationTabs: ["Newest"],
      isLoading: false,
    }
  },
  methods: {
    setAltEduImg(event) {
      event.target.src = base_url + "images/emptyImg.png";
    },
    async getEducationList() {
      const res = await this.callApi("get", window.api_path + "education/homelisting", {});
      this.educationList = res.data.educationAlsoLikeBooks
    },
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
  },
  mounted() {
    this.getEducationList()
  }
};
</script>

<style scoped>

</style>
