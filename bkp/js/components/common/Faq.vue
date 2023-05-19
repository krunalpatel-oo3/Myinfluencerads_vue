<template>
    <div class="wrapper faq">
        <Header />
        <main class="main">
            <section class="banner-with-img-block">
                <div class="banner-with-img">
                    <img :src="faqImageUrl" />
                    <h1 class="label-title">FAQ</h1>
                </div>
            </section>

            <section class="section-education section-education-list faq-sec about-us-con">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="title">
                                <h4 class="text-white">Who are the StreamGeeks?</h4>
                            </div>
                            <div class="contect mt-2">
                                <p class="text-white">The StreamGeeks are a group of video production experts dedicated to helping businesses discover the power of live streaming. The StreamGeeks have an impressive following and a tight-knit online community which they serve through consultations and live shows that continue to inspire, motivate, and inform business owners who refuse to settle for mediocrity.</p>
                            </div>
                        </div>

                        <div class="col-md-12 mt-4">
                            <div class="title">
                                <h4 class="text-white">How can I post my live streaming project?</h4>
                            </div>
                            <div class="contect mt-2">
                                <p class="text-white">You must create an account and log-in to post your live streaming project. Some fields are required in order to post your project. Make sure all required fields have been filled out.</p>
                            </div>
                        </div>

                        <div class="col-md-12 mt-4">
                            <div class="title">
                                <h4 class="text-white">How can I edit or update my live streaming project?</h4>
                            </div>
                            <div class="contect mt-2">
                                <p class="text-white">You can edit your live streaming project by visiting the Projects tab on your profile page. You must be logged into your account in order to edit your project.</p>
                            </div>
                        </div>

                        <div class="col-md-12 mt-4">
                            <div class="title">
                                <h4 class="text-white">How can I add a product to my project?</h4>
                            </div>
                            <div class="contect mt-2">
                                <p class="text-white">Products can be added to our library one at a time via the Products page. You click the “Add a Product” button to do so. Another method is to simply add products directly to your project page. Products added directly to your project page will not have a dedicated page for each product.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="section-bg"></div>
            </section>
            <Footer />
        </main>
    </div>
</template>
<script>
import Vue from "vue";
import Header from "./Header.vue";
import Footer from "./Footer.vue";
    export default {
        name: "faq",
        components: {
            Header,
            Footer
        },
        data() {
            return {
                faqImageUrl: base_url + "images/FAQ-banner.png",
            };
        },
        created() {
            document.title = this.$route.meta.title;
        },
        mounted(){
            this.scrollToTop();
        },
        methods: {
            scrollToTop() {
                window.scrollTo(0,0);
            }
        }
    }
</script>
<style scoped>
    .label-title{
        font-size: 60px;
    }
    html{
        overflow-x:hidden;
    }
    .contact-form {
        background: #fff;
        padding: 20px 20px;
        border-radius: 8px;
    }
</style>