<template>
  <div class="rebranded-dashboard admin-dash">
    <Header />
    <div style="background: #F5F5F5">
      <div class="container">
        <div class="row">
          <div class="col-sidebar sidebar">
            <SidebarSkeleton v-if="isLoading" />
            <Sidebar v-else :data="userDashboard" />
          </div>
          <div class="col-main">
            <MainSkeleton v-if="isLoading" />
            <template v-else>
              <div class="navigation">
                <router-link class="nav" :to="{ name: 'Dashboard', params: { tab: 'systems' }}" :class="tab === 'systems' ? 'link-active' : ''">Systems</router-link>
                <router-link class="nav" :to="{ name: 'Dashboard', params: { tab: 'products' }}" :class="tab === 'products' ? 'link-active' : ''">Products</router-link>
                <router-link class="nav" :to="{ name: 'Dashboard', params: { tab: 'communities' }}" :class="tab === 'communities' ? 'link-active' : ''">Communities</router-link>
                <router-link class="nav" :to="{ name: 'Dashboard', params: { tab: 'companies' }}" :class="tab === 'companies' ? 'link-active' : ''">Integration Companies</router-link>
                <router-link class="nav" :to="{ name: 'Dashboard', params: { tab: 'brands' }}" :class="tab === 'brands' ? 'link-active' : ''">Brands</router-link>
              </div>
              <Systems v-if="tab === 'systems' && userDashboard" :user="userDashboard"/>
              <Products v-if="tab === 'products' && userDashboard" :user="userDashboard"/>
              <Communities v-if="tab === 'communities' && userDashboard" :user="userDashboard"/>
              <Companies v-if="tab === 'companies' && userDashboard" :user="userDashboard"/>
              <Brands v-if="tab === 'brands' && userDashboard" :user="userDashboard"/>
            </template>
          </div>
        </div>
      </div>
      <div class="row mx-0 justify-content-end" id="add-row">
        <button @click="addProject" class="inv-button">
          <AddBtn class="add-btn" id="addBtn"/>
        </button>
      </div>
    </div>
    <Footer />
  </div>
</template>

<script>
import Header from "../common/Header"
import Footer from "../common/Footer"
import Sidebar from "./admin_dashboard/AdminSidebar"
import Systems from "./admin_dashboard/Systems";
import Products from "./admin_dashboard/Products";
import Communities from "./admin_dashboard/Communities";
import Companies from "./admin_dashboard/Companies";
import Brands from "./admin_dashboard/Brands";
import AddBtn from "./icons/AddBtn";
import SidebarSkeleton from "./admin_dashboard/SidebarSkeleton";
import MainSkeleton from "./admin_dashboard/MainSkeleton";

export default {
  name: "NewDashboard",
  data () {
    return {
      publicPath: local_image_path,
      tab: this.$route.params.tab || 'systems',
      isAuthenticated: window.isAuthenticated,
      logged_user_id: null,
      full_name: localStorage.getItem("sgname"),
      userDashboard: "",
      isLoading: true
    }
  },
  components: {
    Header,
    Footer,
    Sidebar,
    Systems,
    Products,
    Communities,
    Companies,
    Brands,
    AddBtn,
    SidebarSkeleton,
    MainSkeleton
  },
  watch: {
    $route() {
      this.tab = this.$route.params.tab
    }
  },
  mounted () {
    this.logged_user_id = localStorage.getItem("logged_user_id");
    this.loadDashboard();
  },
  methods:{
     async loadDashboard() {
      const res = await this.callApi(
        "get",
        window.api_path + "profile/" + this.logged_user_id + "/getUserDashboard"
      );
      this.isLoading = false;
      this.userDashboard = res.data.data;
    },
    addProject () {
      if (this.tab === 'systems') this.$router.push({ name: 'projectadd' })
      if (this.tab === 'brands') this.$router.push({ name: 'Add Brand' })
      if (this.tab === 'companies') this.$router.push({ name: 'Add Integration Company' })
      if (this.tab === 'communities') this.$router.push({ name: 'communityadd' })
      if (this.tab === 'products') this.$router.push({ name: 'Add Product' })
    }
  } 
};
</script>

<style lang="scss" scoped>
.navigation {
  height: 75px !important;
}
.nav {
  font-size: 14px;
  font-weight: 500;
}
a {
  cursor: pointer;
}
#add-row {
  position: sticky !important;
  z-index: 10;
  right:0;
  padding-bottom: 20px;
  bottom: 20px !important;
  
}
.inv-button {
  margin-top: auto;
  margin-right: 50px;
}
.add-btn {
  cursor: pointer;
  &:hover {
    filter: brightness(1.4);
  }
}

@media all and (max-width:991px){
  .inv-button {
  
  svg{
    width:40px;
    height:40px;
  }
}
}
</style>
