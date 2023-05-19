<template>
  <div>
    <div class="img-container">
      <img :src="`${publicPath}Proposals-hero.png`" alt="">
    </div>
    <router-link to="">
      <p class="name">John William</p>
    </router-link>
    <div style="width: 100%; display: flex; justify-content: center; margin-bottom: 41px">
      <span>Seller</span>
      <div class="custom-switch custom-switch-y">
        <input
          type="checkbox"
          class="custom-control-input"
          id="twoFactorRecommeded"
          checked
        />
        <label for="twoFactorRecommeded"></label>
      </div>
      <span>Buyer</span>
    </div>
    <div class="card">
      <div class="row mx-0 align-items-center" style="margin-top: 14px">
        <SidebarLine style="margin-left: 11.79px; margin-right: 8px" />
        <router-link to="">
          <p class="h">Total spend</p>
        </router-link>
      </div>
      <p class="sub">$ 12,537.00</p>
    </div>
    <div class="card">
      <div class="row mx-0 align-items-center" style="margin-top: 14px">
        <SidebarLine style="margin-left: 11.79px; margin-right: 8px" />
        <router-link to="">
          <p class="h">Total amount in scrow</p>
        </router-link>
      </div>
      <p class="sub">$ 5,523.40</p>
    </div>
    <div class="card">
      <div class="row mx-0 align-items-center" style="margin-top: 14px">
        <SidebarLine style="margin-left: 11.79px; margin-right: 8px" />
        <router-link to="">
          <p class="h">Total balance</p>
        </router-link>
      </div>
      <p class="sub">$ 18,060.40</p>
    </div>
  </div>
</template>

<script>
import SidebarLine from "../icons/SidebarLine";

export default {
  name: "BuyerSidebar",
  components: {
    SidebarLine
  },
  data() {
    return {
      publicPath: local_image_path
    };
  }
};
</script>

<style lang="scss" scoped>
.h, .name {
  transition: .2s;

  &:hover {
    color: rgb(242, 169, 28) !important;
  }
}
</style>
