import HomePage from "./components/Home.vue";
import NotFound from './components/404';

import ProjectsPage from "./components/project/Projects.vue";
import ProjectDetailPage from "./components/project/ProjectDetail.vue";
import ProjectsByCategoryPage from "./components/project/ProjectsByCategory.vue";
import ProjectAddPage from "./components/project/ProjectAdd.vue";
import ProjectEditPage from "./components/project/ProjectEdit.vue";
import OriginalProjectAddPage from "./components/project/OriginalProjectAdd.vue";
import CommunityPage from "./components/Community.vue";
import PlanPage from "./components/Plan.vue";
import CommunityDetail from "./components/CommunityDetail.vue";
import CommunityAdd from "./components/CommunityAdd.vue";

import Buyer from "./components/Buyer.vue";
import Checkout from "./components/Checkout.vue";
import Order from "./components/Order.vue";
import Conversation from "./components/Conversation.vue";
import EducationPage from "./components/Education.vue";
import EducationDetail from "./components/EducationDetail.vue";
import UserProfile from "./components/UserProfile.vue";
import AllOrder from "./components/AllOrder.vue";
import ActiveOrder from "./components/ActiveOrder.vue";
import Proposals from "./components/Proposals.vue";
import BlogPage from "./components/Blog.vue";
import Dashboard from "./components/auth/Dashboard.vue";
import AccessDenied from "./components/AccessDenied.vue";
import Settings from "./components/Settings.vue";
import TestProposals from "./components/rebranded/SellerDashboardProposals.vue";
import ProposalPage from "./components/rebranded/SellerProposalPage.vue";
import BuyerDashboardProposals from "./components/rebranded/BuyerDashboardProposals";
import BuyerProposalPage from "./components/rebranded/BuyerProposalPage";
import ForgotPassword from "./components/ForgotPassword.vue";
import ResetPassword from "./components/ResetPassword.vue";
import Chat from "./components/Chat.vue";
import Demo from "./components/Demo.vue";
import HireSeller from "./components/rebranded/HireSeller";
import PaymentPage from "./components/rebranded/PaymentPage";
import RebrandedProjectDetail from "./components/rebranded/RebrandedProjectDetail";
import EditUserProfile from "./components/rebranded/EditUserProfile";
import ProjectsCatalog from "./components/rebranded/ProjectsCatalog";
import NewProjectDetail from "./components/rebranded/NewProjectDetail";
import ShareProject from "./components/rebranded/ShareProject";
import SettingsRebranded from "./components/rebranded/SettingsRebranded";
import NewProjectCatalog from "./components/NewProjectCatalog";
import AdminDashboard from "./components/rebranded/AdminDashboard";
import NewDashboard  from "./components/rebranded/Dashboard";

import Products from "./components/Products";
import AddSystem from "./components/AddSystem";
import SystemPage from "./components/SystemPage";
import AddProduct from "./components/AddProduct";
import EditProduct from "./components/EditProduct";
import ProductPage from "./components/ProductPage";
import AddIntegrationCompany from "./components/AddIntegrationCompany";
import IntegrationCompany from "./components/IntegrationCompany";
import BrandPage from "./components/BrandPage";
import AddBrand from "./components/AddBrand";
import EditBrand from "./components/EditBrand";
import EditCompany from "./components/EditCompany";
import MembershipPage from "./components/MembershipPage";
import AboutUs from "./components/common/AboutUs";
import ContactUs from "./components/common/ContactUs";
import TermsConditions from "./components/common/TermsConditions";
import Faq from "./components/common/Faq";
import Privacy from "./components/common/Privacy";

const project_name = "Stream Geeks";

export const routes = [
    {
        path: "/",
        name: "Home",
        component: HomePage,
        meta: { title: "Home | " + project_name }
    },

    {
        path: "/projects_by_category/:slug",
        component: ProjectsByCategoryPage,
        name: "projectsByCategory",
        meta: {
            requiresAuth: true,
            title: "Public Systems By Category  | " + project_name
        }
    },

    {
        path: "/projects",
        name: "projects",
        component: ProjectsPage,
        meta: {
            // requiresAuth: true,
            title: "Public Systems | " + project_name
        }
    },

    {
        path: "/404",
        name: "404",
        component: () => import("./components/404.vue"),
        meta: {
            requiresLogin: false,
            title: "Not Found | " + project_name
        }
    },
    {
        path: "/email-verified",
        name: "email-verified",
        component: () => import("./components/email-verified.vue"),
        meta: {
            requiresLogin: false,
            title: "Email Verified | " + project_name
        }
    },
    {
        path: "/projectadd",
        name: "projectadd",
        component: ProjectAddPage,
        meta: {
            title: "Public System add | " + project_name,
            requiresAuth: true
        }
    },
    {
        path: "/projectedit/:slug",
        name: "projectedit",
        component: ProjectEditPage,
        meta: { title: "Public System Edit | " + project_name }
    },
    {
        path: "/original_projectadd",
        name: "originalprojectadd",
        component: OriginalProjectAddPage,
        meta: { title: "Public System add | " + project_name }
    },

  {
    path: "/community/",
    name: "community",
    component: CommunityPage,
    meta: { title: "Community | " + project_name }
  },
  {
    path: "/plans/",
    name: "plans",
    component: PlanPage,
    meta: { title: "Plans | " + project_name }
  },
  {
    path: "/communitydetail/:slug",
    name: "communitydetail",
    component: CommunityDetail,
    meta: { title: "Community Detail | " + project_name }
  },
  {
    path: "/communityadd",
    name: "communityadd",
    component: CommunityAdd,
    meta: { title: "Community Add | " + project_name }
  },

    {
        path: "/buyer/:buyer_id",
        name: "buyer",
        component: Buyer,
        meta: { title: "Buyer | " + project_name }
    },

    {
        path: "/conversation",
        name: "conversation",
        component: Conversation,
        meta: { title: "Conversation | " + project_name }
    },

    {
        path: "/checkout",
        name: "checkout",
        component: Checkout,
        meta: { title: "Checkout | " + project_name }
    },

    {
        path: "/order",
        name: "order",
        component: Order,
        meta: { title: "Order | " + project_name }
    },

    {
        path: "/blog",
        name: "blog",
        component: BlogPage,
        meta: { requiresLogin: false, title: "Blog | " + project_name }
    },

  {
    path: "/education/:slug?",
    name: "education",
    component: EducationPage,
    meta: { title: "Education | " + project_name }
  },
  {
    path: "/education/tag/:tag?",
    name: "educationtag",
    component: EducationPage,
    meta: { title: "Education | " + project_name }
  },
  {
    path: "/education/search/:search?",
    name: "educationsearch",
    component: EducationPage,
    meta: { title: "Education | " + project_name }
  },

    {
         path: "/educationdetail/:slug?",
       // path: "/educationdetail/1",
        name: "educationdetail",
        component: EducationDetail,
        meta: { title: "Education Detail | " + project_name }
    },

    {
        path: "/userprofile/:slug?",
        name: "userprofile",
        component: UserProfile,
        meta: { title: "User Profile | " + project_name }
    },

    {
        path: "/allorder",
        name: "allorder",
        component: AllOrder,
        meta: { title: "AllOrder | " + project_name }
    },

    {
        path: "/forgot_password",
        name: "forgot_password",
        component: ForgotPassword,
        meta: {
            requiresLogin: false,
            title: "Forgot Password | " + project_name
        }
    },

    {
        path: "/resetpassword/:id",
        name: "resetpassword",
        component: ResetPassword,
        meta: {
            requiresLogin: false,
            title: "Reset Password | " + project_name
        }
    },

    {
        path: "/access-denied",
        name: "accessdenied",
        component: AccessDenied,
        meta: {
            title: "Access Denied | " + project_name
        }
    },

    {
        path: "/settings",
        name: "Settings",
        component: Settings,
        meta: {
            title: "Settings | " + project_name
        }
    },

    {
        path: "/chat",
        name: "Chat",
        component: Chat,
        meta: {
            requiresLogin: true,
            title: "Chat Test | " + project_name
        }
    },

    {
        path: "/demo",
        name: "demo",
        component: Demo,
        meta: {
            requiresLogin: false,
            title: "Demo | " + project_name
        }
    },



    {
        path: "/activeorder",
        name: "activeorder",
        component: ActiveOrder,
        meta: {
            title: "ActiveOrder | " + project_name
        }
    },
    {
        path: "/proposals",
        name: "proposals",
        component: Proposals,
        meta: {
            title: "Proposals | " + project_name,
            requiresAuth: true,
        }
    },
    {
        path: "/project-detail",
        name: "Project Detail",
        component: RebrandedProjectDetail,
        meta: {
            title: "Project | " + project_name,
            requiresAuth: true,
        }
    },
    {
        path: "/edit-user-profile",
        name: "EditProfile",
        component: EditUserProfile,
        meta: {
            title: "User Profile | " + project_name,
            requiresAuth: true,
        }
    },
    {
        path: "/project-catalog",
        name: "Project Catalog",
        component: ProjectsCatalog,
        meta: {
            title: "Project Catalog | " + project_name,
            requiresAuth: true,
        }
    },
    {
        path: "/project/:slug?",
        name: "project",
        component: NewProjectDetail,
        meta: {
            title: "Public System Detail | " + project_name,
        }
    },
    {
        path: "/share-project",
        name: "Share Project",
        component: ShareProject,
        meta: {
            requiresAuth: true,
            title: "Share Project | " + project_name
        }
    },
    {
        path: "/settings-rebranded",
        name: "Settings-rebranded",
        component: SettingsRebranded,
        meta: {
            requiresAuth: true,
            title: "Settings | " + project_name
        }
    },
    {
        path: "/new-projects-catalog",
        name: "New Projects Catalog",
        component: NewProjectCatalog,
        meta: {
            requiresAuth: true,
            title: "Projects Catalog | " + project_name
        }
    },
    {
        path: "/dashboard/:tab?",
        name: "Dashboard",
        component: NewDashboard,
        meta: {
            requiresAuth: true,
            title: "Dashboard | " + project_name
        }
    },
    {
        path: "/products",
        name: "products",
        component: Products,
        meta: {
            title: "Products Catalog | " + project_name,
            // requiresAuth: true,
        }
    },
    {
        path: "/add-system",
        name: "Add System",
        component: AddSystem,
        meta: {
            title: "Add System | " + project_name,
            requiresAuth: true,
        }
    },
    {
        path: "/system-detail",
        name: "System Detail",
        component: SystemPage,
        meta: {
            title: "System | " + project_name,
            requiresAuth: true,
        }
    },
    {
        path: "/add-product",
        name: "Add Product",
        component: AddProduct,
        meta: {
            title: "Add Product | " + project_name,
            requiresAuth: true,
        }
    },
    {
        path: "/edit-product/:slug",
        name: "Edit_Product",
        component: EditProduct,
        meta: {
            title: "Edit Product | " + project_name,
            requiresAuth: true,
        }
    },
    {
        path: "/product/:slug",
        name: "Product Page",
        component: ProductPage,
        meta: {
            title: "Product | " + project_name,
            requiresAuth: true,
        }
    },
    {
        path: "/add-integration-company",
        name: "Add Integration Company",
        component: AddIntegrationCompany,
        meta: {
            title: "Add Company | " + project_name,
            requiresAuth: true,
        }
    },
    {
        path: "/company/:slug",
        name: "Integration Company",
        component: IntegrationCompany,
        meta: {
            title: "Integration Company | " + project_name,
            requiresAuth: true,
        }
    },
    {
        path: "/brand/:slug",
        name: "Brand Page",
        component: BrandPage,
        meta: {
            title: "Brand | " + project_name,
            requiresAuth: true,
        }
    },
    {
        path: "/add-brand",
        name: "Add Brand",
        component: AddBrand,
        meta: {
            title: "Add Brand | " + project_name,
            requiresAuth: true,
        }
    },
    {
        path: "/edit-brand/:slug",
        name: "Edit Brand",
        component: EditBrand,
        meta: {
            title: "Edit Brand | " + project_name,
            requiresAuth: true,
        }
    },
    {
        path: "/edit-company/:slug",
        name: "Edit Company",
        component: EditCompany,
        meta: {
            title: "Edit Company | " + project_name,
            requiresAuth: true,
        }
    },
    {
        path: "/membership-plans",
        name: "Membership Plans",
        component: MembershipPage,
        meta: {
            title: "Membership Plans",
            requiresAuth: true,
        }
    },
    {
        path: "/about-us",
        name: "About Us",
        component: AboutUs,
        meta: { title: "About Us | " + project_name }
    },
    {
        path: "/contact-us",
        name: "Contact Us",
        component: ContactUs,
        meta: { title: "Contact Us | " + project_name }
    },
    {
        path: "/terms-conditions",
        name: "Terms Conditions",
        component: TermsConditions,
        meta: { title: "Terms Conditions | " + project_name }
    },
    {
        path: "/faq",
        name: "faq",
        component: Faq,
        meta: { title: "Faq | " + project_name }
    },
    {
        path: "/privacy",
        name: "privacy",
        component: Privacy,
        meta: { title: "privacy | " + project_name }
    },

    {
        path: "*",
        name: "Not Found",
        component: NotFound,
    }
];
