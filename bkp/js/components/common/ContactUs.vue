<template>
    <div>
        <Header />
        <main class="main">
            <section class="banner-with-img-block">
                <div class="banner-with-img">
                    <img :src="contactImageUrl" />
                    <h1 class="label-title">Contact Us</h1>
                </div>
            </section>

            <section class="section-education section-education-list  about-us-con">
                <div class="container mt-5">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="title">
                                <h4 class="text-white">Are you looking for help with live streaming or video conferencing?</h4>
                            </div>
                            <div class="contect text-white mt-2">
                                <p>The StreamGeeks team has a network of expert relationships in the industry. Many of our partners can help you with aspects of your streaming journey, from consultation and system design all the way to going live.</p>
                                <p class="mt-3">Whether you’re looking for video equipment, help with a PC build, what software to use, or the best ways to reach your target audience, StreamGeeks will get you in touch with the best person to help.</p>
                                <p class="mt-3">Here are some of the scenarios our industry connections can assist with:</p>
                                <ul class="contact-ul-type">
                                    <li>Virtual Site Survey – Collaborate with an expert to map out and optimize your space</li>
                                    <li>Full review of your current system to identify pain points and offer potential upgrades or solutions</li>
                                    <li>Complete turn-key system offerings to easily outfit any new or existing space</li>
                                    <li>Live product demonstrations for a plethora of videoconferencing and live streaming devices</li>
                                </ul>
                                <p class="mt-3">Schedule a meeting to kickstart your project today!</p>
                                <div class="contact-form">
                                    <div id="hubspotForm" v-once></div>
                                </div>
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
    import Header from "./Header.vue";
    import Footer from "./Footer.vue";
    export default {
        name: "ContactUs",
        components: {
            Header,
            Footer
        },
        data() {
            return {
                contactImageUrl: base_url + "images/Contactus-banner.png",
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
                        target: "#hubspotForm"
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
<!-- <script>
  hbspt.forms.create({
    region: "na1",
    portalId: "418770",
    formId: "f4f35264-246f-40a8-8eff-4db93c38bb6d"
  });
</script> -->

<style scoped>
    .contact-ul-type {
        list-style-type: square;
    }
    .contact-ul-type li {
        font-size: 14px;
    }
    .contact-form {
        background: #fff;
        padding: 20px 20px;
        border-radius: 8px;
    }
</style>