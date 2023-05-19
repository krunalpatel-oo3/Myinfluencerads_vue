<template>
    <div>
        <Header />
        <main class="main">
            <div class="bg-image">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-block">
                                <div class="pt-main">
                                    Membership Plans
                                </div>
                                <div class="pt-sec">
                                    <p>
                                        Join our community of video production and streaming professionals at any level that makes sense for your business
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <PlanTab />
            </div>
        </main>
        <Footer />
    </div>
</template>

<script>
    import Vue from "vue";
    import Header from "./common/Header.vue";
    import Footer from "./common/Footer.vue";
    import PlanTab from "./rebranded/settings/PlanTab.vue";
    
    export default {
        components:{
            Header,
            Footer,
            PlanTab,
        }
    }
</script>

<style>
    /* plan page css starts here  */
    .bg-image .membership-card{
        height: 100%;
        padding-bottom: 108px;
    }
    .bg-image .membership-btn{
        position: absolute;
        bottom: 40px;
        left: 40px;
        right: 40px;
        width: auto;
        margin-top:0;
    }
    .bg-image {
        padding: 132px 0 189px;
        background-image:url('public/images/bg-banner.png');
        background-repeat:no-repeat;
        background-size: 100%;
        background-position-y: 30%;
    }
    
    
    .page-title-block {
        text-align: center;
        max-width: 580px;
        width: 100%;
        margin: auto;
        margin-bottom: 100px;
    }
    
    .pt-main {
        font-weight: 700;
        font-size: 50px;
        line-height: 62px;
        color: #170F49;
        margin-bottom: 36px;
    }
    
    .pt-sec p {
        font-weight: 400;
        font-size: 18px;
        line-height: 30px;
        color: #6F6C90;
    }

    @media all and (max-width:767px){
        .membership-card{
            padding: 40px 20px;
        }
        .pt-main{
            font-size: 40px;
            line-height: 52px;
            margin-bottom: 20px;
        }
        .pt-sec p{
            font-size: 16px;
    line-height: 26px;
        }
        .page-title-block{
            margin-bottom: 50px;
        }
        .bg-image{
            padding: 62px 0 89px;
            background-position-y: 5%;
        }
        .bg-image .membership-card .icon-wrapper{
            height: 40px;
            width: 40px;
        }
        .bg-image .membership-card .icon-wrapper img{
            width: 60%;
        }
    }

    @media all and (max-width:575px){
        .bg-image{
            background-position-y: 8%;
        }
        .pt-main{
            font-size: 30px;
    line-height: 42px;
        }
        .bg-image .membership-card .membership-btn{
            height: 48px;
            bottom: 20px;
        }
        .bg-image .membership-card {
    height: 100%;
    padding-bottom: 80px;
    min-height: unset;
}
    }
    /* plan page css ends here  */
</style>