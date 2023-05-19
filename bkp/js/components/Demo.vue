<template>
  <div>
    <Header />

    <!-- Page Content -->
    <div class="container">
      <div class="row">
        <div class="col-xl-8 offset-xl-2">
          <div class="margin-top-100"></div>
          <div class="demo-page py-5">
            <h3>Phase 3</h3>
            <ul>
              <li><a href="/product">Product Page</a></li>
              <li><a href="/new-projects-catalog">Project Catalog</a></li>
              <li><a href="/new-products-catalog">Product Catalog</a></li>
              <li><a href="/add-system">Add System</a></li>
              <li><a href="/system-detail">System Page</a></li>
              <li><a href="/add-product">Add Product</a></li>
              <li><a href="/add-integration-company">Add Integration Company</a></li>
              <li><a href="/brand">Brand Page</a></li>
              <li><a href="/integration-company">Integration Company Page</a></li>
              <li><a href="/add-brand">Add Brand</a></li>
              <li><a href="/admin-dashboard">Admin Dashboard</a></li>
            </ul>
            <h3>Main Pages</h3>
            <ul>
              <li>
                <a href="/">home</a>
                <i>(Click "Login/Register" to see Login popups)</i>
              </li>
              <li><a href="/projects">projects</a></li>
              <li>
                <a href="/project/1">project/1</a>
                <i>(Click "Send a Quote" button for popup)</i>
              </li>
              <li><a href="/projectadd">projectadd</a></li>
              <li><a href="/community">community</a></li>
              <li>
                <a
                  href="/communitydetail/community-question-et-veniam-quam-facilis-eveniet-qui-qui-sunt-sit-numquam-suscipit-est-in-molestiae-amet-quasi-et-occaecati-repudiandae-id"
                >communitydetail</a
                >
              </li>
              <li><a href="/communityadd">communityadd</a></li>
              <li><a href="/gigs">gigs</a></li>
              <li><a href="/gig/1">gig</a></li>
              <li>
                <a href="/gigadd">gigadd</a>
                <i>(click "Save and Continue" to see all steps)</i>
              </li>
              <li><a href="/buyer">buyer</a></li>
              <li><a href="/conversation">conversation</a></li>
              <li>
                <a href="/checkout">checkout</a>
                <i
                >(Click "Checkout" and "Confirm and Pay" buttons to see next
                  steps)</i
                >
              </li>
              <li><a href="/order">order</a></li>
              <li><a href="/education">education</a></li>
              <li><a href="/educationdetail/1">educationdetail</a></li>
              <li>
                <a href="/userprofile">userprofile</a>
                <i
                >(Click top tabs and "Contact Streamer" button to see
                  additional layouts)</i
                >
              </li>
              <li><a href="/allorder">allorder</a></li>
              <li><a href="/access-denied">access-denied</a></li>
              <li><a href="/404">404</a></li>
              <li>
                <a href="/settings">settings</a>
                <i>(Click "Save and Continue" button to see all steps)</i>
              </li>
              <li><a href="/activeorder">activeorder</a></li>
              <li><a href="/proposals">proposals</a></li>
            </ul>
            <h3>Rebranded</h3>
            <p>Seller Pages:</p>
            <ul>
              <li><a href="/rebranded-proposal-seller">Proposal Page (Hourly)</a></li>
              <li><a href="/rebranded-proposal-seller?payment=fixed">Proposal Page (Fixed)</a></li>
              <li><a href="/rebranded-proposal-seller?payment=fixed&type=pending-invite">Pending Invite(Fixed)</a></li>
              <li><a href="/rebranded-proposal-seller?payment=hourly&type=pending-invite">Pending Invite (Hourly)</a>
              </li>
              <li><a href="/rebranded-proposal-seller?payment=fixed&type=archived-proposal">Archived Proposal
                (Fixed)</a></li>
              <li><a href="/rebranded-proposal-seller?payment=hourly&type=archived-proposal">Archived Proposal
                (Hourly)</a></li>
              <li><a href="/rebranded-proposal-seller?payment=fixed&type=archived-invite">Archived Invite (Fixed)</a>
              </li>
              <li><a href="/rebranded-proposal-seller?payment=hourly&type=archived-invite">Archived Invite (Hourly)</a>
              </li>
              <li><a href="/rebranded-proposal-seller?payment=fixed&type=waiting-for-accept">Waiting For Accept
                (Fixed)</a></li>
              <li><a href="/rebranded-proposal-seller?payment=hourly&type=waiting-for-accept">Waiting For Accept
                (Hourly)</a></li>
              <li><a href="/rebranded-proposal-seller?payment=fixed&type=in-progress">In Progress (Fixed)</a></li>
              <li><a href="/rebranded-proposal-seller?payment=hourly&type=in-progress">In Progress (Hourly)</a></li>
              <li><a href="/rebranded-proposal-seller?payment=fixed&type=completed-project">Completed Project
                (Fixed)</a></li>
              <li><a href="/rebranded-proposal-seller?payment=hourly&type=completed-project">Completed Project
                (Hourly)</a></li>
              <li><a href="/rebranded-dashboard-seller?type=main">Dashboard Proposals</a></li>
              <li><a href="/rebranded-dashboard-seller?type=waiting-accept">Dashboard Waiting to Accept</a></li>
              <li><a href="/rebranded-dashboard-seller?type=in-progress">Dashboard In Progress</a></li>
              <li><a href="/rebranded-dashboard-seller?type=completed">Dashboard Completed</a></li>
              <li><a href="/rebranded-dashboard-seller?type=in-dispute">Dashboard Disputed</a></li>
              <li><a href="/rebranded-dashboard-seller?type=">Dashboard With Graph</a></li>
            </ul>
            <p>Buyer Pages:</p>
            <ul>
              <li><a href="/rebranded-dashboard-buyer?type=pending">Dashboard Pending</a></li>
              <li><a href="/rebranded-dashboard-buyer?type=waiting">Dashboard Waiting</a></li>
              <li><a href="/rebranded-dashboard-buyer?type=dispute">Dashboard Dispute</a></li>
              <li><a href="/rebranded-dashboard-buyer?type=progress">Dashboard In Progress</a></li>
              <li><a href="/rebranded-dashboard-buyer?type=completed">Dashboard Completed</a></li>
              <li><a href="/rebranded-dashboard-buyer?type=">Dashboard With Graph</a></li>
              <li><a href="/rebranded-proposal-buyer?payment=hourly&type=waiting-for-accept">Proposal Waiting
                (Hourly)</a></li>
              <li><a href="/rebranded-proposal-buyer?payment=fixed&type=waiting-for-accept">Proposal Waiting (Fixed)</a>
              </li>
              <li><a href="/rebranded-proposal-buyer?payment=hourly&type=in-progress">Proposal In Progress (Hourly)</a>
              </li>
              <li><a href="/rebranded-proposal-buyer?payment=fixed&type=in-progress">Proposal In Progress (Fixed)</a>
              </li>
              <li><a href="/rebranded-proposal-buyer?payment=fixed&type=completed">Proposal Completed (Fixed)</a></li>
              <li><a href="/rebranded-proposal-buyer?payment=hourly&type=completed">Proposal Completed (Hourly)</a></li>
              <li><a href="/rebranded-proposal-buyer?payment=hourly&type=archived">Proposal Archived (Hourly)</a></li>
              <li><a href="/rebranded-proposal-buyer?payment=fixed&type=archived">Proposal Archived (Fixed)</a></li>
            </ul>
            <p>Hire Pages:</p>
            <ul>
              <li><a href="/rebranded-hire-seller?payment=hourly">Hire Seller (Hourly)</a></li>
              <li><a href="/rebranded-pay?payment=hourly">Payment Page (Hourly)</a></li>
              <li><a href="/rebranded-pay?payment=fixed">Payment Page (Fixed)</a></li>
              <li><a href="/projectadd">Add Project (both hourly and fixed)</a></li>
              <li><a href="/project-detail?payment=hourly">Project Detail (Hourly)</a></li>
              <li><a href="/project-detail?payment=hourly">Project Detail (Fixed)</a></li>
              <li><a href="/projects">Projects Catalog (already exist)</a></li>
              <li><a href="/rebranded-proposal-buyer?payment=fixed&type=hire">Proposal Page (Fixed)</a></li>
              <li><a href="/rebranded-proposal-buyer?payment=hourly&type=hire">Proposal Page (Hourly)</a></li>
            </ul>
            <p>User profile</p>
            <ul>
              <li><a href="/user-profile">Seller Profile</a></li>
              <li><a href="/edit-user-profile">Edit Profile</a></li>
            </ul>
            <p>Projects</p>
            <ul>
              <li><a href="/project-catalog">Projects</a></li>
              <li><a href="/new-project-detail">Project Detail</a></li>
              <li><a href="/share-project">Share Project</a></li>
            </ul>
            <p>Settings</p>
            <ul>
              <li><a href="/settings-rebranded">Settings</a></li>
            </ul>
          </div>
          <div class="margin-top-50"></div>
        </div>
      </div>
    </div>

    <!-- Spacer -->
    <div class="margin-top-70"></div>
    <!-- Spacer / End-->

    <Footer />
  </div>
</template>

<script>
import Header from "./common/Header.vue";
import Footer from "./common/Footer.vue";

export default {
  name: "Demo",
  components: {
    Header,
    Footer
  },
  data() {
    return {};
  },
  created() {
    document.title = this.$route.meta.title;
  }
};
</script>
