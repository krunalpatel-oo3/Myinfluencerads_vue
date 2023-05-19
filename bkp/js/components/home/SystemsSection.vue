<template>
  <section class="section-gigs section-gigs-home">
    <div class="container">
      <h2 class="h1">Systems</h2>
      <p class="desc" v-html="headerText"></p>
      <ul class="nav nav-ctabs">
        <li
          v-for="nav in systemTabs"
          :key="nav"
          class="nav-link"
          :class="nav === systemTab ? 'active' : ''"
          @click="systemTab = nav"
        >
          {{ nav }}
        </li>
      </ul>

      <div v-if="isLoading" class="tabs-content">
        <div class="row">
          <div
            class="col-lg-3 col-sm-6 col-sm-12 mb-3"
            v-for="i in 4"
            :key="i"
          >
            <div class="skeleton"></div>
          </div>
        </div>
      </div>
      <div v-else class="tabs-content">
        <div class="tab-content" v-if="systemTab === 'Popular'">
          <div class="row">
            <div
              class="col-lg-3 col-sm-6 col-sm-12 mb-3"
              v-for="system in popular.slice(0, 4)"
            >
              <SystemCard
                :name="system.name"
                :category="system.categoryname"
                :slug="system.slug"
                :creator_id="system.creator.id"
                :description="system.short_desc"
                :image_link="system.projectImagePropsArray.image_url"
                :user_photo="system.creator.profile_photo"
              />
            </div>
          </div>
        </div>

        <div class="tab-content" v-if="systemTab === 'Featured'">
          <div class="row">
            <div
              class="col-lg-3 col-sm-6 col-sm-12 mb-3"
              v-for="system in featured.slice(0, 4)"
            >
              <SystemCard
                :name="system.name"
                :category="system.categoryname"
                :slug="system.slug"
                :creator_id="system.creator.id"
                :description="system.short_desc"
                :image_link="system.projectImagePropsArray.image_url"
                :user_photo="system.creator.profile_photo"
              />
            </div>
          </div>
        </div>

        <div class="tab-content" v-if="systemTab === 'Newest'">
          <div class="row">
            <div
              class="col-lg-3 col-sm-6 col-sm-12 mb-3"
              v-for="system in featured.slice(0, 4)"
            >
              <SystemCard
                :name="system.name"
                :category="system.categoryname"
                :slug="system.slug"
                :creator_id="system.creator.id"
                :description="system.short_desc"
                :image_link="system.projectImagePropsArray.image_url"
                :user_photo="system.creator.profile_photo"
              />
            </div>
          </div>
        </div>
      </div>

      <div class="view-all">
        <router-link :to="{ name: 'projects' }">View All</router-link>
      </div>
    </div>
    <div class="section-bg"></div>
  </section>
</template>

<script>
import IconBase from "../common/IconBase.vue";
import IconLike4 from "../common/icons/IconLike4.vue";
import IconLike5 from "../common/icons/IconLike5.vue";
import SystemCard from "../common/SystemCard";

export default {
  name: "SystemCardList",
  props: ["headerText"],
  data() {
    return {
      publicPath: local_image_path,
      systemTabs: ["Newest", "Popular", "Featured"],
      systemTab: "Newest",
      isLoading: true,
      popular: [],
      featured: []
    };
  },
  components: {
    IconBase,
    IconLike4,
    SystemCard,
    IconLike5
  },
  methods: {
    async getProjects() {
      const res = await Promise.all([
        this.callApi("post", window.api_path + "getFilteredProjects", { page: 1, data_type: "Featured" }),
        this.callApi("post", window.api_path + "getFilteredProjects", { page: 1, data_type: "Popular" })
      ]);
      this.featured = res[0].data.data.projects;
      this.popular = res[1].data.data.projects;
      this.isLoading = false;
    }
  },

  mounted() {
    this.getProjects();
  }
};
</script>

<style scoped>
.skeleton {
  height: 391px;
  border-radius: 8px;
}
</style>
