<template>
    <div>
        <Header />
        <main class="main">
            <section class="banner-with-img-block">
                <div class="banner-with-img">
                    <img :src="aboutImageUrl" />
                    <h1 class="label-title">About Us</h1>
                </div>
            </section>

            <section class="section-education section-education-list about-us-con">
                <div class="container mt-5">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="contect text-white mt-2">
                                <p>The StreamGeeks are a group of video production experts dedicated to helping businesses discover the power of live streaming. The StreamGeeks have an impressive following and a tight-knit online community which they serve through consultations and live shows that continue to inspire, motivate, and inform business owners who refuse to settle for mediocrity.</p>
                                <p class="mt-3">StreamGeeks.com is the world’s largest online catalog of live streaming projects. You can join the community, share your projects, learn from others, and ask questions about live streaming and video production technology.</p>
                                
                                <div class="project-video-item">
                                    <iframe
                                    :src="`https://www.youtube.com/embed/${getEmbed(
                                    'https://www.youtube.com/watch?v=jBjtRyT4zGs'
                                    )}?controls=0`"
                                    title="YouTube video player"
                                    frameborder="0"
                                    allowfullscreen
                                    width="100%"
                                    height="500px"
                                    ></iframe>
                                </div>
                                <p class="mt-3">Schedule a meeting to kickstart your project today!</p>
                                <div class="contact-form">
                                    <div id="hubspotForm" v-once></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </section>
            <Footer />
        </main>
    </div>
</template>
<script>
    import Header from "./Header.vue";
    import Footer from "./Footer.vue";
    export default {
        name: "AboutUs",
        components: {
            Header,
            Footer
        },
        data() {
            return {
                aboutImageUrl: base_url + "images/about-us-banner.png",
            };
        },
        mounted(){
            this.scrollToTop();
            const script = document.createElement("script");
            script.src="//js.hsforms.net/forms/v2.js";
            document.head.appendChild(script);
            script.addEventListener("load", () => {
                if (window.hbspt) {
                    hbspt.forms.create({
                        portalId: "418770",
                        formId: "f4f35264-246f-40a8-8eff-4db93c38bb6d",
                        target: "#hubspotForm",
                        cssClass: 'contact-form'
                    });

                }
            });
        },
        methods: {
            scrollToTop() {
                window.scrollTo(0,0);
            }
        }
    }
</script>

<style scoped>
    .contact-ul-type {
        list-style-type: square;
    }
    .contact-ul-type li {
        font-size: 14px;
    }
    .hs-form-f4f35264-246f-40a8-8eff-4db93c38bb6d_5b717a69-4447-4812-8e18-e1eaa59b078f .hs-form-field label:not(.hs-error-msg) {
        font-size: 14px;
        color: #fff !important;
    }
    .contact-form {
        background: #fff;
        padding: 20px 20px;
        border-radius: 8px;
    }
</style>