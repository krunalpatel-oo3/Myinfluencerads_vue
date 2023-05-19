<template>
  <div class="card card-project">
    <div class="card-img-top">
      <router-link :to="{ name: 'Product Page', params: { slug }}">
        <img :src="image_link || `${publicPath}no-image.jpg`" alt="" />
      </router-link>
    </div>
    <div class="card-body">
      <div class="card-title-vote">
        <div class="card-title mb-0 text-white">
          <router-link :to="{ name: 'Product Page', params: { slug }}">
            {{ name || '' }}
          </router-link>
        </div>
      </div>
      <div class="card-category">
        <div class="label d-flex">
          <router-link :to="{ name: 'Product Page', params: { slug }}">{{ category || '' }}</router-link>
          <div class="ml-auto row mx-0">
            <RatingStar
              v-for="i in rating"
              :key="i"
              :height="17"
              :width="19"
              :fill="'#F2A91C'"
            />
            <RatingStar
              v-for="i in (5 - rating)"
              :key="i"
              :height="17"
              :width="19"
            />
          </div>
        </div>
      </div>
      <p class="card-text">
        {{ description || '' }}
      </p>
      <div class="card-price-more">
        <div class="more">
          <router-link :to="{ name: 'Product Page', params: { slug }}" class="btn btn-link btn-icon link-hover">
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
        <div class="projectby">
          <span class="text-white">Added by</span>
          <router-link :to="{ name: 'userprofile', params: { slug: creator_id || '' } }">
            <img
              :src="user_photo || `${publicPath}user-avatar-lg.jpg`"
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
import IconBase from "./IconBase";
import IconArrowRight from "./icons/IconArrowRight"

export default {
  name: "ProductCard",
  props: [
    'image_link',
    'name',
    'category',
    'rating',
    'description',
    'slug',
    'user_photo',
    'creator_id',
  ],
  components: {
    IconBase,
    RatingStar,
    IconArrowRight
  },
  data () {
    return {
      publicPath: local_image_path,
    }
  }
};
</script>
<style scoped>
  .card-text {
    display: -webkit-box;
    -webkit-line-clamp: 6;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
  }
</style>