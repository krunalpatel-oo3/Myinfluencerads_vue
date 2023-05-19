<template>
  <div>
    <div class="img-container" style="position: relative">
      <div style="position: relative">
        <img v-if="data.user.profile_photo != null" :src="data.user.profile_photo" alt="" style="border-radius: 50%; height: 80px;width:80px;">
        <img v-else :src="defaultUserImgUrl" alt="" style="border-radius: 50%; height: 80px;width:80px;"/>
        <div v-if="data.user.urank == 4" class="img-label">
          <span>
              Pro
          </span>
        </div>
      </div>
    </div>
    <router-link to="">
      <p class="name poppins">{{ data.user.full_name }}</p>
    </router-link>
    <p class="name_sub">{{ data.user.description }}</p>
    <!-- <div v-if="data.user.user_type == 'buyer' || data.user.user_type == 'seller'" class="label-switch mb-4 mt-4">
      <span>Seller</span>
      <div class="custom-switch custom-switch-y on-off">
        <input type="checkbox" class="custom-control-input" id="authenticator1" v-if="data.user.user_type == 'buyer'" checked />
        <input type="checkbox" class="custom-control-input" id="authenticator1" v-else />
        <label for="authenticator1"></label>
      </div>
      <span>Buyer</span>
    </div>   -->
    <div class="card">
      <div class="row mx-0 align-items-center" style="margin-top: 14px">
        <SidebarLine style="margin-left: 11.79px; margin-right: 8px" />
        <router-link :to="{ name: 'Dashboard', params: { tab: 'systems' }}">
          <p class="h">Systems</p>
        </router-link>
      </div>
      <p class="sub">{{ projectsCount }}</p>
    </div>  
    <div class="card">
      <div class="row mx-0 align-items-center" style="margin-top: 14px">
        <SidebarLine style="margin-left: 11.79px; margin-right: 8px" />
        <router-link  :to="{ name: 'Dashboard', params: { tab: 'products' }}">
          <p class="h">Products</p>
        </router-link>
      </div>
      <p class="sub">{{ productsCount }}</p>
    </div>
    <div class="card">
      <div class="row mx-0 align-items-center" style="margin-top: 14px">
        <SidebarLine style="margin-left: 11.79px; margin-right: 8px" />
        <router-link :to="{ name: 'Dashboard', params: { tab: 'communities' }}">
          <p class="h">Communities</p>
        </router-link>
      </div>
      <p class="sub">{{ data.communities.length || 0 }}</p>
    </div>
    <div class="card">
      <div class="row mx-0 align-items-center" style="margin-top: 14px">
        <SidebarLine style="margin-left: 11.79px; margin-right: 8px" />
        <router-link :to="{ name: 'Dashboard', params: { tab: 'companies' }}">
          <p class="h">Integration Companies</p>
        </router-link>
      </div>
      <p class="sub">{{ data.company.length || 0 }}</p>
    </div>
    <div class="card">
      <div class="row mx-0 align-items-center" style="margin-top: 14px">
        <SidebarLine style="margin-left: 11.79px; margin-right: 8px" />
        <router-link :to="{ name: 'Dashboard', params: { tab: 'brands' }}">
          <p class="h">Brands</p>
        </router-link>
      </div>
      <p class="sub">{{ data.brand.length || 0 }}</p>
    </div>
  </div>
</template>

<script>
import SidebarLine from "../icons/SidebarLine";

export default {
  name: "AdminSidebar",
  props: ['data'],
  components: {
    SidebarLine
  },
  data() {
    return {
      publicPath: local_image_path,
      full_name: localStorage.getItem("sgname"),
      defaultUserImgUrl: base_url + "images/default-user-avatar-sm.jpg",
    };
  },
  computed: {
    projectsCount() {
      let count = 0
      if (this.data.projects.length) {
        count += this.data.projects.length
      }
      if (this.data.projects_pending.length) {
        count += this.data.projects_pending.length
      }
      return count
    },
    productsCount() {
      let count = 0
      if (this.data.approved_product.length) {
        count += this.data.approved_product.length
      }
      if (this.data.product_pending.length) {
        count += this.data.product_pending.length
      }
      return count
    }
  }
};
</script>

<style lang="scss" scoped>
.name_sub {
  font-size: 19px;
  line-height: 34px;
  font-weight: 300;
  word-break: break-all;
    display: -webkit-box;
    -webkit-line-clamp: 6;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}
.name {
  margin-bottom: 0;
}
.h, .name {
  transition: .2s;

  &:hover {
    color: rgb(242, 169, 28) !important;
  }
}
.pro-badge {
  background: #F2A91C;
  border-radius: 15px;
  width: 30px;
  height: 30px;
  font-size: 12px;
  color: white;
  display: flex;
  align-items: center;
  justify-content: center;
  position: absolute;
  top: 0;
  right: -10px;
}
.sub {
  text-align: end;
  padding-right: 20px;
}
.label-switch {
  justify-content: center !important;
}
</style>
