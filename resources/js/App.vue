<template>

    <!-- header start from here  -->
    <header id="header-container" class="header" v-if="!$route.meta.hideNavbar">
        <nav class="navbar navbar-expand-xxl">
            <div class="container-fluid">
                <div class="nav-main">
                    <a class="navbar-brand p-0 m-0" href="index.html">
                        <img src="./assets/images/logo.svg" alt="">
                    </a>
                    <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mb-2 mb-lg-0">
                            <li class="nav-item active">
                                <a class="nav-link" href="index.html">Home</a>
                            </li>
                            <li class="nav-item">
                                <router-link to="/dashboard" class="nav-link">Dashboard
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link to="/manage-profile" class="nav-link">Manage profile
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link to="/engineer" class="nav-link">Engineer
                                </router-link>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Influencer
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="#">Action</a></li>
                                    <li><a class="dropdown-item" href="#">Another action</a></li>
                                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="job.html">Jobs</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Blog</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">FAQ</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">About Us</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Contact Us</a>
                            </li>
                        </ul>
                    </div>
                    <div class="login-btn">
                        <router-link to="/login" class="btn btn-pink hover-btn"><i class="fa-solid fa-user me-1"></i> <span
                                class="">Login or Register</span></router-link>
                    </div>

                </div>
            </div>
        </nav>
    </header>
    
    <div class="container">
        <!--
        <div class="text-center" style="margin: 20px 0px 20px 0px;">
             <span class="text-secondary">Laravel Vue CRUD Example</span>
        </div>
 
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse">
                <div class="navbar-nav">
                    <router-link to="/" class="nav-item nav-link">Home</router-link>
                    <router-link to="/add" class="nav-item nav-link">Add Post</router-link>
                </div>
            </div>
        </nav>
        -->
        <br/>
        
    </div>
    <router-view></router-view>

</template>
 
<script>
    const link = `home_url/assets/js/script.js`;
    //console.log(home_url);
    export default {
        mounted() {
            const externalScript = document.createElement('script')
            const externalScript2 = document.createElement('script')
            const externalScript3 = document.createElement('script')
            const intarnalScript = document.createElement('script')
            externalScript.src ='https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js'
            externalScript2.src ='https://code.jquery.com/jquery-3.7.0.min.js'
            externalScript3.src ='https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js'
            externalScript3.src = '';
            document.body.appendChild(externalScript)
            document.body.appendChild(externalScript2)
            document.body.appendChild(externalScript3)
            intarnalScript.src ='../assets/js/script.js'
        },
        head: {
            script: [
                { type: 'text/javascript', src: '../assets/js/script.js', body: true},
                { type: 'text/javascript', src: './assets/vendors/jquery/jquery-3.6.4.min.js', async: true, body: true},
                { type: 'text/javascript', src: './assets/vendors/bootstrap/bootstrap.bundle.js', async: true, body: true},
                { type: 'text/javascript', src: 'https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js', async: true, body: true},
                { type: 'text/javascript', src: './assets/js/aos.js', async: true, body: true},
            ]
        }
    }

</script>

<style>
@import './assets/vendors/bootstrap/bootstrap.min.css';
@import './assets/style.css';
@import './assets/css/shortcode.css';
/* @import './assets/css/aos.css'; */
@import './assets/css/responsive.css';
</style>
