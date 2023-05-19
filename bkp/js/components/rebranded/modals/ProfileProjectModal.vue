<template>
  <div style="background: rgba(0, 0, 0, 0.65); min-height: 100vh">
    <div @click="closeModal" class="d-flex justify-content-end">
      <CloseIcon />
    </div>
    <div class="container">
      <div class="row w-100">
        <div id="projectsCarousel" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-inner">
            <div  class="carousel-item "  v-for="(gallery_image,image_index) in portfolio.gallery_images" v-bind:class = "(image_index==0)?'active':''"  >
              <img :src="gallery_image.image_url" class="d-block w-100" style="height: 450px; object-fit: cover">
            </div>
            <!-- <div class="carousel-item">
              <img :src="`${publicPath}Slider_Image.png`" class="d-block w-100">
            </div>
            <div class="carousel-item">
              <img :src="`${publicPath}Slider_Image.png`" class="d-block w-100">
            </div> -->
          </div>
          <button class="carousel-control-prev" type="button" data-target="#projectsCarousel" data-slide="prev">
            <SliderLeft />
          </button>
          <button class="carousel-control-next" type="button" data-target="#projectsCarousel" data-slide="next">
            <SliderRight />
          </button>
        </div>
        <div class="row mx-0 w-100" style="margin-top: 20px;">
          <img data-target="#projectsCarousel" v-for="(gallery_image,image_index) in portfolio.gallery_images" :src="gallery_image.image_url"
               style="height: 104px; width: 104px; border-radius: 8px; margin-right: 10px;" :data-slide-to="image_index">
        </div>
        <div class="row mx-0" style="margin-top: 24px;">
          <h4 class="w700 t-24 lh-54 t-white">{{portfolio.title}}</h4>
          <p class="t-24 t-white lh-54" style="margin-left: 20px; font-style: italic">
             {{
                          momentDatetime(
                            portfolio.start_date,
                            getJsMomentDateFormat()
                          )
                        }}
   - {{
                          momentDatetime(
                            portfolio.end_date,
                            getJsMomentDateFormat()
                          )
                        }} 
                        </p>
        </div>
      
        <p class="t-color5 t-16 lh-23 w-100">{{portfolio.description}}</p>
          <ul class="tags">
                  <li
                    v-for="skill in portfolio.skills"
                    :key="skill.id"
                  ><a style="cursor: pointer;"   :class="['tag-'+'blue', 'tag']">{{  skill.title }}</a>
                  </li>
          </ul>
      </div>
    </div>
  </div>
</template>

<script>
import IconBase from "../../common/IconBase.vue";
import CloseIcon from "../icons/CloseIcon.vue";
import IconAngleRight2 from "../../common/icons/IconAngleRight2.vue";
import SliderRight from "../icons/SliderRight";
import SliderLeft from "../icons/SliderLeft";
import appMixin from "../../../appMixin";


export default {
  name: "ProfileProjectModal",
  props: ["portfolio"],
  components: {
    CloseIcon,
    IconBase,
    IconAngleRight2,
    SliderRight,
    SliderLeft
  },
   mixins: [appMixin],
  data() {
    return {
      publicPath: local_image_path
    };
  },
  methods: {
    closeModal() {
      this.$FModal.hide();
    }
  }
};
</script>

<style lang="scss" scoped>
.close-modal-icon {
  margin-right: 40px;
  margin-top: 20px;
  fill: white;
}

.carousel-control-prev, .carousel-control-next {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  z-index: 1;
  display: flex;
  padding: 0;
  color: #fff;
  text-align: center;
  background: rgba(255, 255, 255, 0.83);
  width: 60px;
  height: 88px;
  opacity: 1;
  border: 0;
}

.carousel-control-prev {
  border-radius: 0px 13px 13px 0px;
}

.carousel-control-next {
  border-radius: 13px 0px 0px 13px;
}

.carousel {
  width: 100%;

  img {
    height: auto;
    width: 100%;
  }
}
</style>
