<template>
  <section class="section-gigs section-gigs-home">
    <div class="container">
      <h2 class="h1">Products</h2>
      <p class="desc" v-html="headerText"></p>
      <ul class="nav nav-ctabs">
        <li
          v-for="(nav, index) in ['Featured']"
          class="nav-link"
          :class="productTab === nav ? 'active' : ''"
          @click="productTab = nav"
        >
          {{ nav }}
        </li>
      </ul>

      <div class="tabs-content">
        <div class="tab-content" v-if="productTab === 'Featured'">
          <div class="row">
            <div v-for="(product, index) in products" :key="index" class="col-lg-3 col-sm-6 col-sm-12 mb-3">
              <ProductCard
                :category="product.category ? product.category.title : ''"
                :slug="product.slug"
                :description="product.desc"
                :image_link="product.product_image"
                :user_photo="product.creator.profile_photo"
                :creator_id="product.creator.id"
                :name="product.name"
                :rating="product.overall_ratings"
              />
            </div>
          </div>
        </div>
      </div>

      <div class="view-all">
        <router-link :to="{ name: 'products' }">View All</router-link>
      </div>
    </div>
    <div class="section-bg"></div>
  </section>
</template>

<script>
import RatingStar from "../rebranded/icons/RatingStar";
import ProductCard from "../common/ProductCard";

export default {
  name: "ProductCardList",
  props: ['headerText'],
  data () {
    return {
      publicPath: local_image_path,
      productTab: "Featured",
      products: []
    }
  },
  components: {
    RatingStar,
    ProductCard
  },
  methods: {
    async getProducts() {
      const res = await Promise.all([
        this.callApi("post", window.api_path + "product/getProductList", {
          featured: 1,
          limit: 4
        })
      ])
      this.products = res[0].data.data.products
    }
  },
  mounted () {
    this.getProducts()
  }
};
</script>

<style lang="scss" scoped>
.card-project, .card-product {
  height: 100%;
  margin-bottom: 0px;
  background: #202C54;
  box-shadow: 0px 4px 26px rgba(0, 0, 0, 0.08);
  border-radius: 8px;
  .card-title {
    margin-bottom: 0;
    a {
      color: #FFFFFF;
    }
  }
  .card-text {
    color: rgba(255, 255, 255, 0.8);
  }
  .more {
    a {
      color: white;
      border: 1px solid #F2A91C;
      border-radius: 5px;
      width: 107px;
      height: 31px;
      margin: 10px 0;
      &:hover {
        color: white !important;
        background: #F2A91C;
      }
    }
  }
  .projectby {
    span {
      color: white !important;
    }
  }
}
</style>
