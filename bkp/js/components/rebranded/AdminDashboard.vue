<template>
  <div class="rebranded-dashboard admin-dash">
    <Header />
    <div style="background: #F5F5F5">
      <div class="container">
        <div class="row">
          <div class="col-sidebar sidebar">
            <Sidebar />
          </div>
          <div class="col-main">
            <div class="navigation">
              <router-link class="nav" :to="{ name: 'Admin Dashboard', query: { tab: 'systems' }}" :class="tab === 'systems' ? 'link-active' : ''">Systems</router-link>
              <router-link class="nav" :to="{ name: 'Admin Dashboard', query: { tab: 'products' }}" :class="tab === 'products' ? 'link-active' : ''">Products</router-link>
              <router-link class="nav" :to="{ name: 'Admin Dashboard', query: { tab: 'communities' }}" :class="tab === 'communities' ? 'link-active' : ''">Communities</router-link>
              <router-link class="nav" :to="{ name: 'Admin Dashboard', query: { tab: 'companies' }}" :class="tab === 'companies' ? 'link-active' : ''">Integration Companies</router-link>
              <router-link class="nav" :to="{ name: 'Admin Dashboard', query: { tab: 'brands' }}" :class="tab === 'brands' ? 'link-active' : ''">Brands</router-link>
            </div>
            <Systems v-if="tab === 'systems'"/>
            <Products v-if="tab === 'products'"/>
            <Communities v-if="tab === 'communities'"/>
            <Companies v-if="tab === 'companies'"/>
            <Brands v-if="tab === 'brands'"/>
          </div>
        </div>
      </div>
      <div class="row mx-0 justify-content-end" id="add-row">
        <AddBtn class="add-btn" id="addBtn"/>
      </div>
    </div>
    <Footer id="footer"/>
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

export default {
  name: "AdminDashboard",
  data () {
    return {
      publicPath: local_image_path,
      tab: 'systems',
      isAuthenticated: window.isAuthenticated,
      logged_user_id: null,
      full_name: localStorage.getItem("sgname"),
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
    AddBtn
  },
  mounted () {
    if (this.$route.query.tab) {
      this.tab = this.$route.query.tab
    }
    if (!this.isAuthenticated || !localStorage.getItem("logged_user_id")) {
      this.$toast.error("To open your dashboard you need to login firstly !");
      this.$router.push({name: "home"});
    }
    this.logged_user_id = localStorage.getItem("logged_user_id");
    this.loadProjects();
  },
  watch: {
    '$route.query' () {
      this.tab = this.$route.query.tab
    }
  },
  methods:{
    async loadProjects() {
      const result = await this.callApi(
        "get",
        window.api_path + "getProjectsCount",
        { 'id':this.logged_user_id }
      );
      if (result.status !== 200) {
        this.$toast.error(result.data.message);
        this.autocompleteProductItems = [];
        return;
      }
      console.log(result.data)
      this.autocompleteProductItems = result.data.products;
    },
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
  width: fit-content;
  float: right;
  bottom: 30px !important;
  margin-top: -100px;
  padding-bottom: 20px;
}
.add-btn {
  cursor: pointer;

  margin-top: auto;
  margin-right: 50px;
  &:hover {
    filter: brightness(1.4);
  }
}
</style>
