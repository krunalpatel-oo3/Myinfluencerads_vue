import Vue from "vue";
import axios from "axios";
import moment from "moment-timezone";
import { initFbsdk } from "./fb.js";
import { LoaderPlugin } from "vue-google-login";
import { bus } from "./app";

let client_id = "608538884327-5mk2a79llomn9va7um8tf6g0mr7pnuab.apps.googleusercontent.com";//process.env.GOOGLE_CLIENT_ID
Vue.use(LoaderPlugin, {
    client_id: client_id
});

export default {
    data() {
        return {
            isLoadingFooter: false,
            fullPageFooter: true,
            full_name: localStorage.getItem("sgname"),
            userprofilepic: window.local_image_path + "user-avatar-small-01.jpg"
        };
    },
    components: {
        initFbsdk,
        LoaderPlugin
    },
    created: function() {
        var pimg = "";
        if (localStorage.getItem("sgphoto") != null) {
            if (
                localStorage.getItem("sgphoto") != "" &&
                localStorage.getItem("sgphoto") != "null"
            ) {
                pimg = window.image_path + localStorage.getItem("sgphoto");
            } else {
                pimg = window.local_image_path + "user-avatar-small-01.jpg";
            }
        } else {
            pimg = window.local_image_path + "user-avatar-small-01.jpg";
        }
        this.userprofilepic = pimg;
    },
    methods: {
        callApi(method, url, dataobj = "", token = "") {
            try {
                var token = "";
                if (localStorage.getItem("sgtoken") != null) {
                    token = localStorage.getItem("sgtoken");
                }

                return axios({
                    method: method,
                    url: url,
                    data: dataobj,
                    headers: {
                        Authorization: `Bearer ${token}`,
                    }
                }).catch(function(error) {
                    return error.response;
                });
            } catch (e) {
                return e.response;
            }
        },

        getEmbed(url) {
            if (url) {
                const regExp =
                    /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
                const match = url.match(regExp);
                let id;
                if (match && match[2].length === 11) {
                    return match[2];
                }
            }
        },

        getYoutubeImg(src) {
            if (!src.match(/youtube\.com.*(\?v=|\/embed\/)(.{11})/)) {
                return ""
            }
            let id = src.match(/youtube\.com.*(\?v=|\/embed\/)(.{11})/).pop();
            if (id.length === 11) {
                return "//img.youtube.com/vi/" + id + "/0.jpg";
            }
            return "";
        },

        moneyFormat(price) {
            if (typeof price === "undefined" || typeof price === "object") {
                price = 0;
            }
            if (typeof price === "string") {
                price = parseFloat(price);
            }
            return "$" + price.toFixed(2);
        },

        timeInAgoFormat: function(value) {
            if (value == null || typeof value === "undefined") return;
            return this.Capitalize(moment(value).fromNow(true));
        },

        Capitalize: function(string) {
            if (typeof string != "string") return "";
            return string.charAt(0).toUpperCase() + string.slice(1);
        },

        getErrorMessage(error) {

            /*
                        console.log('getErrorMessage error::')
                        console.log(typeof error)
                        console.log(error)
                        console.log('getErrorMessage error.status::')
                        console.log(error.status)
                        console.log(typeof error.status)

                        console.log('1 getErrorMessage error.response::')
                        console.log(error.response)
                        console.log('2 getErrorMessage error.status::')
                        console.log(error.status)

                        console.log('3 +++getErrorMessage error.data.errors::')
                        console.log(error.data.errors)

            */

            if (typeof error.status != "undefined" && typeof error.response != "undefined" && error.status === 400) {
                if (typeof error.data.message != "undefined") {
                    return "Validation error : " + error.data.message;
                }
            }
            if (typeof error.status != "undefined" && typeof error.response != "undefined" && error.status === 500) {
                if (typeof error.data.message != "undefined") {
                    return "Runtime error : " + error.data.message;
                }
            }
            if (typeof error.status != "undefined" && /*typeof error.response != 'undefined' && */ error.status === 422) {
                if (typeof error.data.message != "undefined") {
                    // console.log(typeof error.data.errors)

                    if (typeof error.data.errors === "object") {
                        let errorMessage = "";
                        for (var fieldName in error.data.errors) {
                            var value = error.data.errors[fieldName];
                            errorMessage += fieldName + " : " + value + "   ";
                        }
                        return "Validation error : " + errorMessage;

                    }
                    return "Validation error : " + error.data.message;
                }
            }
            if (typeof error.data.exception != "undefined") return error.data.exception;
            if (typeof error.data.message != "undefined") return error.data.exception;
        },

        setStepForm() {
            //DOM elements
            const DOMstrings = {
                stepsBtnClass: "multisteps-form__progress-btn",
                stepsBtns: document.querySelectorAll(
                    `.multisteps-form__progress-btn`
                ),
                stepsBar: document.querySelector(".multisteps-form__progress"),
                stepsForm: document.querySelector(".multisteps-form__form"),
                stepsFormTextareas: document.querySelectorAll(
                    ".multisteps-form__textarea"
                ),
                stepFormPanelClass: "multisteps-form__panel",
                stepFormPanels: document.querySelectorAll(
                    ".multisteps-form__panel"
                ),
                stepPrevBtnClass: "js-btn-prev",
                stepNextBtnClass: "js-btn-next"
            };
            console.log(" setStepForm DOMstrings::");
            console.log(DOMstrings);

            //remove class from a set of items
            const removeClasses = (elemSet, className) => {
                elemSet.forEach(elem => {
                    elem.classList.remove(className);
                });
            };

            //return exect parent node of the element
            const findParent = (elem, parentClass) => {
                let currentNode = elem;
                while (!currentNode.classList.contains(parentClass)) {
                    currentNode = currentNode.parentNode;
                }
                return currentNode;
            };

            //get active button step number
            const getActiveStep = elem => {
                return Array.from(DOMstrings.stepsBtns).indexOf(elem);
            };

            //set all steps before clicked (and clicked too) to active
            const setActiveStep = activeStepNum => {
                //remove active state from all the state
                removeClasses(DOMstrings.stepsBtns, "js-active");
                //set picked items to active
                DOMstrings.stepsBtns.forEach((elem, index) => {
                    if (index <= activeStepNum) {
                        elem.classList.add("js-active");
                    }
                });
            };

            //get active panel
            const getActivePanel = () => {
                let activePanel;
                DOMstrings.stepFormPanels.forEach(elem => {
                    if (elem.classList.contains("js-active")) {
                        activePanel = elem;
                    }
                });
                return activePanel;
            };

            //open active panel (and close unactive panels)
            const setActivePanel = activePanelNum => {
                //remove active class from all the panels
                removeClasses(DOMstrings.stepFormPanels, "js-active");
                //show active panel
                DOMstrings.stepFormPanels.forEach((elem, index) => {
                    if (index === activePanelNum) {
                        elem.classList.add("js-active");
                        setFormHeight(elem);
                    }
                });
            };

            //set form height equal to current panel height
            const formHeight = activePanel => {
                const activePanelHeight = activePanel.offsetHeight;
                DOMstrings.stepsForm.style.height = `${activePanelHeight}px`;
            };

            const setFormHeight = () => {
                const activePanel = getActivePanel();
                formHeight(activePanel);
            };

            //STEPS BAR CLICK FUNCTION
            DOMstrings.stepsBar.addEventListener("click", e => {
                //check if click target is a step button
                const eventTarget = e.target;
                if (
                    !eventTarget.classList.contains(
                        `${DOMstrings.stepsBtnClass}`
                    )
                ) {
                    return;
                }
                //get active button step number
                const activeStep = getActiveStep(eventTarget);
                //set all steps before clicked (and clicked too) to active
                setActiveStep(activeStep);
                //open active panel
                setActivePanel(activeStep);
            });

            //PREV/NEXT BTNS CLICK
            DOMstrings.stepsForm.addEventListener("click", e => {
                const eventTarget = e.target;
                //check if we clicked on `PREV` or NEXT` buttons
                if (
                    !(
                        eventTarget.classList.contains(
                            `${DOMstrings.stepPrevBtnClass}`
                        ) ||
                        eventTarget.classList.contains(
                            `${DOMstrings.stepNextBtnClass}`
                        )
                    )
                ) {
                    return;
                }

                //find active panel
                const activePanel = findParent(
                    eventTarget,
                    `${DOMstrings.stepFormPanelClass}`
                );
                let activePanelNum = Array.from(
                    DOMstrings.stepFormPanels
                ).indexOf(activePanel);
                //set active step and active panel onclick
                if (
                    eventTarget.classList.contains(
                        `${DOMstrings.stepPrevBtnClass}`
                    )
                ) {
                    activePanelNum--;
                } else {
                    activePanelNum++;
                }
                setActiveStep(activePanelNum);
                setActivePanel(activePanelNum);

                setTimeout(() => {
                    var body = $(".dashboard-content-container");
                    body.stop().animate(
                        { scrollTop: 0 },
                        500,
                        "swing",
                        function() {
                        }
                    );
                }, 100);
            });

            setTimeout(() => {
                setFormHeight();
            }, 500);
            //SETTING PROPER FORM HEIGHT ONLOAD
            window.addEventListener("load", setFormHeight, false);

            //SETTING PROPER FORM HEIGHT ONRESIZE
            window.addEventListener("resize", setFormHeight, false);

            //changing animation via animation select !!!YOU DON'T NEED THIS CODE (if you want to change animation type, just change form panels data-attr)

            const setAnimationType = newType => {
                DOMstrings.stepFormPanels.forEach(elem => {
                    elem.dataset.animation = newType;
                });
            };

            //selector onchange - changing animation
            const animationSelect = document.querySelector(
                ".pick-animation__select"
            );
            if (animationSelect != null) {
                animationSelect.addEventListener("change", () => {
                    const newAnimationType = animationSelect.value;

                    setAnimationType(newAnimationType);
                });
            }
        },

        async checkLoginStatus() {
            if (this.$route.meta.hasOwnProperty("requiresLogin")) {
                if (this.$route.meta.requiresLogin == true) {
                    if (
                        localStorage.getItem("sgtoken") == null ||
                        localStorage.getItem("sgtype") == null ||
                        localStorage.getItem("sgemail") == null ||
                        localStorage.getItem("sgname") == null
                    ) {
                        if (localStorage.getItem("sgemail") != null) {
                            localStorage.setItem("sgemail", "");
                        }

                        if (localStorage.getItem("sgname") != null) {
                            localStorage.setItem("sgname", "");
                        }

                        if (localStorage.getItem("sgtoken") != null) {
                            localStorage.removeItem("sgtoken");
                        }

                        if (localStorage.getItem("sgtype") != null) {
                            localStorage.removeItem("sgtype");
                        }

                        window.isAuthenticated = false;
                        window.sgtype = 4;
                        this.$router.push({ name: "home" });
                        return false;
                    }

                    // ================= for FB login - start =================
                    if (window.sgtype == 1) {
                        // facebook
                        window.FB.getLoginStatus(function(response) {
                            if (response.status === "connected") {
                                var fbuid = response.authResponse.userID;

                                if (localStorage.getItem("sgemail") == fbuid) {
                                    window.isAuthenticated = true;
                                } else {
                                    window.isAuthenticated = false;
                                }
                            } else {
                                window.isAuthenticated = false;
                            }
                        });
                    }
                    // ================= for FB login - end =================

                    // ================= for Google login - start =================
                    if (window.sgtype == 2) {
                        Vue.GoogleAuth.then(auth2 => {
                            if (auth2.isSignedIn.get() == true) {
                                var profile = auth2.currentUser
                                    .get()
                                    .getBasicProfile();
                                var thisemail = profile.getEmail();

                                if (localStorage.getItem("sgemail") != null) {
                                    if (
                                        localStorage.getItem("sgemail") ==
                                        thisemail
                                    ) {
                                        window.isAuthenticated = true;
                                    } else {
                                        window.isAuthenticated = false;
                                    }
                                } else {
                                    window.isAuthenticated = false;
                                }
                            } else {
                                window.isAuthenticated = false;
                            }
                        });
                    }
                    // ================= for Google login - end =================

                    // ================= for Linkedin login - start =================
                    if (window.sgtype == 3) {
                    }
                    // ================= for Linkedin login - end =================

                    // regular
                    var token = "";
                    if (localStorage.getItem("sgtoken") != null) {
                        token = localStorage.getItem("sgtoken");
                    }

                    const auth_details = await this.callApi(
                        "post",
                        window.api_path + "isloggedin",
                        "",
                        token
                    );

                    if (auth_details.status != 200) {
                        window.isAuthenticated = false;
                    }

                    if (window.isAuthenticated == false) {
                        // regular
                        var token = "";
                        if (localStorage.getItem("sgtoken") != null) {
                            token = localStorage.getItem("sgtoken");
                        }

                        const logout_details = await this.callApi(
                            "post",
                            window.api_path + "logout",
                            "",
                            token
                        );

                        if (localStorage.getItem("sgemail") != null) {
                            localStorage.setItem("sgemail", "");
                        }

                        if (localStorage.getItem("sgname") != null) {
                            localStorage.setItem("sgname", "");
                        }

                        if (localStorage.getItem("sgtoken") != null) {
                            localStorage.removeItem("sgtoken");
                        }

                        if (localStorage.getItem("sgtype") != null) {
                            localStorage.removeItem("sgtype");
                        }

                        window.sgtype = 4;
                        this.$router.push({ name: "home" });
                    }
                }
            }

            if (
                this.$route.name == "login" ||
                this.$route.name == "register" ||
                this.$route.name == "forgot_password"
            ) {
                if (window.isAuthenticated == true) {
                    this.$router.push({ name: "dashboard" });
                }
            }
        },
        async doLogout() {
            console.log();
            localStorage.removeItem("sgtoken");
            localStorage.removeItem("sgtype");
            window.isAuthenticated = false;
            this.isLoadingFooter = true;
            let token = "";
            if (localStorage.getItem("sgtoken") != null) {
                token = localStorage.getItem("sgtoken");
            }

            const logout_details = await this.callApi(
                "post",
                window.api_path + "logout",
                "",
                token
            );

            if (localStorage.getItem("sgemail") != null) {
                localStorage.setItem("sgemail", "");
            }

            if (localStorage.getItem("sgname") != null) {
                localStorage.setItem("sgname", "");
            }

            if (localStorage.getItem("sgphoto") != null) {
                localStorage.setItem("sgphoto", "");
            }

            if (localStorage.getItem("sgtoken") != null) {
                localStorage.removeItem("sgtoken");
            }

            if (localStorage.getItem("sgtype") != null) {
                localStorage.removeItem("sgtype");
            }

            window.isAuthenticated = false;
            window.logged_user_id = null;
            window.sgtype = 4;
            this.$toast.success("You have successfully logged out");
            if (this.$route.name === 'Home') this.$router.go('/')
            await this.$router.push({ name: "Home" });
        },
        updateUserDetails() {
            this.full_name = localStorage.getItem("sgname");

            var pimg = "";
            if (localStorage.getItem("sgphoto") != null) {
                if (
                    localStorage.getItem("sgphoto") != "" &&
                    localStorage.getItem("sgphoto") != "null"
                ) {
                    pimg = window.image_path + localStorage.getItem("sgphoto");
                } else {
                    pimg = window.local_image_path + "user-avatar-small-01.jpg";
                }
            } else {
                pimg = window.local_image_path + "user-avatar-small-01.jpg";
            }
            this.userprofilepic = pimg;
        }
    },
    mounted() {
        initFbsdk();
    }
};
