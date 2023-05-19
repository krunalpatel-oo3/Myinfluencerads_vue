<template>
  <div class="card card-project streamgeeks-system-card-3">
    <div class="card-img-top">
      <router-link
        :to="{name: 'project',params: { slug: slug }}"
      >
        <img
          :src="image_link || `${publicPath}no-image.jpg`"
          alt=""
        />
      </router-link>
    </div>
    <div class="card-body">
      <div class="card-title-vote">
        <div class="card-title">
          <router-link
            class="link-hover"
            :to="{ name: 'project', params: { slug: slug }}"
          >
            {{ name ? name.substring(0, 20) : 'Unknown project' }}
          </router-link>
        </div>
        <div class="home-page-rating d-flex ml-2">
          <RatingStar class="rating-star" :fill="'#FB8200'" />
          <RatingStar class="rating-star" :fill="'#FB8200'" />
          <RatingStar class="rating-star" :fill="'#FB8200'" />
          <RatingStar class="rating-star" :fill="'#FB8200'" />
          <RatingStar class="rating-star" />
        </div>
      </div>
      <div class="card-category">
        <div class="label">
          <router-link to="/">{{ category }}</router-link>
          <span v-if="category && sub_category"> | </span>
          <router-link to="/">{{ sub_category }}</router-link>
        </div>
      </div>
      <div class="card-text proj-descs" style="height: 100px">
        <p v-html="description ? description.substring(0, 120) : ''"></p>
      </div>
      <div class="card-price-more">
        <div class="more">
          <router-link
            :to="{name: 'project', params: { slug: slug }}"
            class="btn btn-link btn-icon"
          >
            <span>Learn More</span>
          </router-link>
        </div>
        <div class="projectby">
          <span>Added by</span>
          <router-link :to="{
                      name: 'userprofile',
                      params: { slug: creator_id || '' }
                    }">
            <img
              :src="user_photo || `${publicPath}no-image.jpg`"
              alt=""
              class="rounded-circle"
            />
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import RatingStar from "../rebranded/icons/RatingStar";
export default {
  name: "SystemCard",
  props: [
    'image_link',
    'name',
    'category',
    'sub_category',
    'description',
    'slug',
    'user_photo',
    'creator_id',
  ],
  components: {
    RatingStar
  },
  data() {
    return {
      publicPath: local_image_path,
    }
  }
};
</script>

<style scoped>
  .home-page-rating svg.rating-star {
    width: 16px;
  }
  .card-title a {
    height: 52px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    width: 100%;
}

</style>
