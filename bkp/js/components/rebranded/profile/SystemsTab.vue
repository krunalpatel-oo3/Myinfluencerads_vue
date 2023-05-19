<template>
  <div class="projects-section mt-3">

    <div class="row">
      <div
        v-for="project_new in userProfile.projects"
        :key="project_new.id"
        class="col-lg-3 col-sm-6 col-xs-12"
      >
        <div class="card card-project">
          <div class="card-img-top">

            <router-link
              :to="{
                          name: 'project',
                          params: { slug: project_new.slug }
                        }"
            >
              <img
                :src="project_new.projectImagePropsArray.image_url"
    
              />
              <!-- <span
                class="is-featured"
                :style="{
                  backgroundImage: `url(${publicPath}featured-bg.png)`
                }"
                >New</span
              > -->
            </router-link>
          </div>

          <div class="card-body">
            <div class="card-title-vote">
              <div class="card-title">
                <router-link
                  :to="{
                              name: 'project',
                              params: { slug: project_new.slug }
                            }"
                >
                  {{ project_new.name.substring(0, 20) }}
                </router-link>
                <router-link
                  :to="{
                              name: 'projectedit',
                              params: { slug: project_new.slug }
                            }"
                >
                  <button class="edit-icon ps-edit"
                          style="position: relative; margin-left: 5px;">
                    <EditIcon />
                  </button> </router-link>
              </div>
              <button v-show="!project_new.is_already_voted" class="btn btn-link btn-icon btn-vote">
                <icon-base
                  width="18"
                  height="17.25"
                  view-box="0 0 18 17.25"
                  icon-name="like-4"
                >
                  <LikeFilled />
                </icon-base >
              </button>
              <span
                class="btn btn-link btn-icon"
                v-show="project_new.is_already_voted"
              >
                          <icon-base
                            width="18"
                            height="17.25"
                            view-box="0 0 18 17.25"
                            icon-name="like-5"
                          >
                            <LikeFilled/>
                          </icon-base>
                          </span>
            </div>
            <div class="card-category">
              <div class="label">
                <router-link
                  :to="{
                              name: 'project',
                              params: { slug: project_new.slug }
                            }"
                >{{ project_new.categoryname }}</router-link
                >
              </div>
            </div>

            <p class="card-text" v-html="project_new.desc.substring(0, 120)">
             
            </p>

            <div class="card-price-more">
              <div class="more">
                <router-link
                  :to="{
                              name: 'project',
                              params: { slug: project_new.slug }
                            }"
                  class="btn btn-link btn-icon"
                >
                  <span>Learn More</span>
                  <icon-base
                    width="18"
                    height="8.72"
                    view-box="0 0 18 8.72"
                    icon-name="arrow-right"
                  >
                    <ArrowRight />
                  </icon-base>
                </router-link>
              </div>
              <div class="projectby">
                <span>Public System by</span>
                <router-link :to="{
                      name: 'User Profile',
                      params: { slug: project_new.creator.login }
                    }">
                  <img
                    :src="project_new.creatorUserProfilePhotoImageProps.image_url"
                    alt=""
                    class="rounded-circle"
                  />
                </router-link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import IconBase from "../../common/IconBase";
import LikeFilled from "../icons/LikeFilled";
import ArrowRight from "../icons/ArrowRight";
import EditIcon from "../icons/EditIcon";

export default {
  name: "SystemsTab",
  props: {
    userProfile: {
      type: Object,
      required: true
    }
  },
  components: {
    IconBase,
    ArrowRight,
    LikeFilled,
    EditIcon
  }
};
</script>

<style scoped>

  .ps-edit.edit-icon{
    width: 25px;
    height: 25px;
  }

  .ps-edit.edit-icon svg{
    width:12px;
    height:12px;
  }
  @media all and (max-width:575px){
    .card-project {
      min-height: 350px;
    }
  }
</style>
