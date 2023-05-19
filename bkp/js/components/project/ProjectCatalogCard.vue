<template>
  <div>
    <div v-if="type == 'popular'" class="project-card">
      <!-- Newest start here -->
      <div class="row mx-0">
        <div class="col-md-3 col-12">
          <router-link :to="{ name: 'project', params: { slug: project.slug } }">
            <img class="popular-card-image" :src="project.projectImagePropsArray.image_url || `${publicPath}no-image.jpg`" style="width: 100%" alt="" @error="setAltProImg">
          </router-link>
          <div class="row mx-0 mt-2 mb-md-0 mb-2 align-items-center">
            <p class="text-white t-18 mb-0 w700">
              <router-link :to="{ name: 'project', params: { slug: project.slug } }" class="card-project-title">{{ project.name }}</router-link>
            </p>
            <div class="ml-auto d-flex align-items-center">
              <div @click="emitVote(project.id, type)" style="cursor:pointer;">
                <ThumbsUp :fill="'#F2A91C'" width="30px" height="29px" />
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-9 col-12 pcl-right" style="padding-left: 30px">
          <div class="row mx-0">
            <div class="row mx-0 w-100">
              <div class="col-md-10 col-8 pl-0">
                <p class="t-18 t-color6 proj-descs" v-html="project.desc ? project.desc.substring(0, 120) : ''" style="width: 100%; margin-top: 16px"></p>
              </div>
              <div class="col-md-2 col-4">
                  <div @click="emitVote(project.id, type)"
                    :class="(project.is_already_voted ? 'like-tag like-tag-active' : 'like-tag')">
                    <div class="svg-icon">
                      <svg width="25" height="18" viewBox="0 0 25 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12.5 0L24.1913 18H0.808657L12.5 0Z" fill="#F2A91C"/>
                      </svg>
                    </div>
                    <div>{{ project.project_votes_count }}</div>
                  </div>
              </div>
            </div>
          </div>
          <h4 class="t-18 w500 text-white roboto">Project Stage:</h4>
          <!-- Planning start here -->
            <div class="project-stage active" v-if="project.project_phase === 'P'">
              <p>Planning</p>
            </div>
            <div class="project-stage" v-else>
              <p>Planning</p>
            </div>
          <!-- Planning end here -->

          <!-- In-Progress start here -->
            <div class="ps-icon">
              <svg width="18" height="21" viewBox="0 0 18 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M1 2.23686L15.9344 10.5L1 18.7631L1 2.23686Z" fill="#F2A91C" stroke="#202C54" stroke-width="2"/>
              </svg>
            </div>
            <div class="project-stage active" v-if="project.project_phase === 'IP'">
              <p>In-Progress</p>
            </div>
            <div class="project-stage" v-else>
              <p>In-Progress</p>
            </div>
          <!-- In-Progress start here -->

          <!-- Complete start here -->
            <div class="ps-icon">
              <svg width="18" height="21" viewBox="0 0 18 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M1 2.23686L15.9344 10.5L1 18.7631L1 2.23686Z" fill="#F2A91C" stroke="#202C54" stroke-width="2"/>
              </svg>
            </div>
            <div class="project-stage active" v-if="project.project_phase === 'C'">
              <p>Complete</p>
            </div>
            <div class="project-stage" v-else>
              <p>Complete</p>
            </div>
          <!-- Complete end here -->
        </div>
        <div class="col-12">
          <div class="project-footer">
            <div class="pcf-left">
              <ul class="list-unstlyed">
                  <li>
                    <div class="pc-author">
                        Project by
                    </div>
                    <div class="pc-author-name">
                      <router-link :to="{ name: 'userprofile', params: { slug: project.creator.id } }" style="cursor: pointer;">
                        <img v-if="project.creator.profile_photo != null" :src="project.creator.profile_photo" alt="" @error="setAltUserImg"></img>
                        <img v-else :src="defaultUserImgUrl" class="user-avatar" alt="" />
                      </router-link>
                    </div>
                  </li>
                  <li>
                    <div class="pc-comment-icon">
                      <svg width="25" height="23" viewBox="0 0 25 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <ellipse cx="11.5" cy="10" rx="11.5" ry="10" fill="#F2A91C"/>
                          <path d="M21.4534 20.4316L15.5271 18.5982L20.5435 14.2953L21.4534 20.4316Z" fill="#F2A91C"/>
                      </svg>
                    </div>
                    <div class="pc-comment">
                      <span class="pc-comment-count"> {{ project.reviews_count }} </span>
                      <span class="pc-comment-text">
                        <router-link :to="{ name: 'project', params: { slug: project.slug } }" class="category-link">{{ project.categoryname }}</router-link>
                      </span>
                    </div>
                  </li>
              </ul>
            </div>
            <div class="pcf-right">
              <router-link :to="{ name: 'project', params: { slug: project.slug } }" class="text-white t-18 link-hover">Learn More
                <ArrowRight />
              </router-link>
            </div>
          </div>
        </div>
      </div>
      <!-- Newest end here -->
    </div>

    <!-- Featured start here -->
    
      <div v-if="type == 'newest' || type == 'featured'">
          <div class="card card-project streamgeeks-system-card-3 with-ribbon">
            <div v-if="type === 'featured'" class="card-tag">
              <span class="ct-icon">
                <DiamondIcon v-if="type === 'featured'" />
              </span>
              <span class="ct-text"> {{ type.toUpperCase() }} </span>
            </div>
            <div class="card-img-top">
              <img :src="project.projectImagePropsArray.image_url || `${publicPath}no-image.jpg`" style="width: 100%" alt="">
            </div>
            <div class="card-body">
                <div class="card-title-vote">
                  <div class="card-title">
                    <router-link :to="{ name: 'project', params: { slug: project.slug } }" class="card-project-title">{{ project.name }}</router-link>
                  </div>
                </div>
                <div class="card-category">
                  <div class="label">
                    <router-link :to="{ name: 'project', params: { slug: project.slug } }" class="category-link">{{ project.categoryname }}</router-link>
                  </div>
                </div>
                <p class="t-18 t-color6 proj-descs" v-html="project.desc ? project.desc.substring(0, 120) : ''" style="width: 100%; margin-top: 16px"></p>
                <div class="card-price-more">
                  <div class="more">
                    <router-link
                      :to="{name: 'project', params: { slug: project.slug }}"
                      class="btn btn-link btn-icon"
                    >
                      <span>Learn More</span>
                    </router-link>
                  </div>
                  <div class="projectby">
                    <span>Added by</span>
                    <router-link :to="{ name: 'userprofile', params: { slug: project.creator.id } }" style="cursor: pointer;">
                      <img v-if="project.creator.profile_photo != null" :src="project.creator.profile_photo" class="featured-product-img" alt=""></img>
                      <img v-else :src="defaultUserImgUrl" class="user-avatar featured-product-img" alt="" />
                    </router-link>
                  </div>
                </div>
            </div>
          </div>
      </div>
    
    <!-- Featured end here -->
  </div>
</template>

<script>
import ArrowRight from "../rebranded/icons/ArrowRight.vue";
import IconAngleDown from "../common/icons/IconAngleDown";
import ThumbsUp from "../rebranded/icons/ThumbsUp.vue";
import DoneIcon from "../rebranded/icons/DoneIcon.vue";
import CommentIcon from "../rebranded/icons/CommentIcon.vue";
import DiamondIcon from "../rebranded/icons/DiamondIcon.vue";
import StarIcon from "../rebranded/icons/StarIcon.vue";

export default {
  name: "ProjectCatalogCard",
  data: () => {
    return {
      publicPath: local_image_path,
      defaultUserImgUrl: base_url + "images/default-user-avatar-sm.jpg",
    }
  },
  components: {
    ArrowRight,
    ThumbsUp,
    DoneIcon,
    CommentIcon,
    DiamondIcon,
    StarIcon,
    IconAngleDown
  },
  props: ['project', 'type', 'getProjects'],
  methods: {
    setAltProImg(event) {
        event.target.src = base_url + "images/emptyImg.png";
    },
    setAltUserImg(event) {
        event.target.src = base_url + "default-user-avatar-sm.jpg";
    },
    emitVote (id, type) {
      this.$emit('vote', { type, project_id: id })
      setTimeout(() => {
        this.getProjects()
      }, 1000);
    }
  }
};
</script>

<style lang="scss" scoped>
 
.section-search-projects {
  margin-top: 0px;
  margin-bottom: -80px;
}

.section-createproject-hero {
  padding-bottom: 0;
}

.section-projects {
  padding-top: 150px;
  padding-bottom: 80px;
}

.section-projects-list {
  background: #000927;
  clip-path: polygon(0 0, 100% 8%, 100% 100%, 0 100%);
}

.section-h {
  font-weight: 700;
  font-size: 42px;
  color: #FFFFFF;
  font-family: Poppins;
  margin-top: 60px;
}

.badge-category {
  height: 49px;
  width: 173px;
  border-radius: 14px;
  background: #F2A91C;
  font-size: 18px;
  font-weight: 700;
  border: none;
  color: white;
  display: flex;
  justify-content: center;
  align-items: center;
  cursor: pointer;

  &:hover {
    filter: brightness(1.1);
  }
}

.add-system-btn {
  background: #202C54;
  border-radius: 4px;
  width: 162px;
  height: 42px;
  margin-left: auto;
  font-size: 14px;
  color: white;
  border: none;
  cursor: pointer;

  &:hover {
    filter: brightness(1.3);
  }
}

.projects-nav {
  border-bottom: 2px solid rgba(255, 255, 255, 0.17);

  a {
    font-size: 18px;
    line-height: 54px;
    cursor: pointer;
    color: rgba(255, 255, 255, 0.53);
    padding: 0 20px;
    font-weight: 500;
    border-bottom: 4px solid transparent;

    &:hover {
      color: white;
    }
  }

  .active-link {
    border-bottom: 4px solid #F2A91C;
    color: white;
  }
}

.project-card {
  background: #202C54;
  border-radius: 8px;
  box-shadow: 0px 4px 26px rgba(0, 0, 0, 0.08);
  margin-top: 30px;
  border-bottom: 1px solid #010A28; 
  padding: 15px 11px;
  .card-tag {
    margin-left: 15px;
    background: #F2A91C;
    border-radius: 8px;
    color: white;
    font-weight: 600;
    font-size: 13px;
    letter-spacing: 0.23em;
    padding: 2px 10px;
    line-height: 21px;
    height: 27px;
  }
  img {
    border-radius: 4px;
    height: 171px;
    object-fit: cover;
  }
  .category-link {
    width: 100%;
    color: #F2A91C;
  }
  .like-tag {
    cursor: pointer;
    border-radius: 8px;
    border: 2px solid #F2A91C;
    padding: 5px 10px;
    margin-left: auto;
    width:75px;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    span {
      padding-left: 10px;
      font-size: 14px;
      color: white;
      border-left: 1px solid #FFFFFF;
    }
    .svg-icon{
      margin-bottom:10px;
    }
    div{
      font-weight: 700;
      font-size: 18px;
      color: white;
    }
  }
  .card-project-title {
    font-size: 20px;
    font-weight: 700;
    color: white;
    cursor: pointer;

    &:hover {
      color: #F2A91C !important;
    }
  }
}
.stage-line {
  width: 150px;
  height: 3px;
  border-radius: 5px;
  margin-left: 5px;
}
.stage-line-active {
  background: #F2A91C;
}
.stage-line-inactive {
  background: #18213D;
}

.project-stage-progress {
  .project-icon {
    background: transparent;

    .progress-circle {
      width: 25px;
      height: 25px;
      border-radius: 50%;
      background: #F2A91C;
    }
  }

  p {
    margin-left: -23px;
  }
}

.project-stage-complete {
  .project-icon {
    border: 2px solid #F2A91C;
    background: #18213D;
  }

  p {
    margin-left: -14px;
  }
}

.project-stage-active {
  background: #F2A91C !important;
  border: 2px solid #FFFFFF !important;
}

.project-votes {
  height: 83px;
  width: 76px;
  border: 2px solid #F2A91C;
  border-radius: 8px;
  margin-right: 30px;
  margin-top: 20px;
}

.c-pointer {
  cursor: pointer;
}
.project-title {
  cursor: pointer;

  &:hover {
    color: #F2A91C !important;
  }
}
.project-cards-row {
  .card-project {
    background: #202C54;
  }

  margin-top: 40px;

  .col-3 {
    padding-left: 15px !important;

    &:nth-of-type(1) {
      padding-left: 0 !important;
    }
  }
}
.learn-more {
  height: 31px;
  width: 107px;
  border: 1px solid #F2A91C;
  background: transparent;
  font-size: 12px;
  color: white;
  border-radius: 8px;
  margin: 10px 0;

  &:hover {
    background: #F2A91C;
  }
}
.proj-descs{
    font-weight: 400;
    font-size: 20px;
    line-height: 24px;
    color: rgba(255, 255, 255, 0.8);
}
.project-stage {
    width: 25%;
    border: 2px solid #F2A91C;
    border-radius: 13px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 10px;
    p{
      margin-bottom: 0;
      color: #FFFFFF;
    }
}
.project-stage.active {
  background: #f2a91c;
  border-color: #fff;
  color: #000000;
}
.project-stage.active p {
  color: #000000 !important;
}
.ps-icon {
  display: inline-block;
  vertical-align: middle;
  margin: 0 15px;
}
.project-footer{
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-align: center;
  -ms-flex-align: center;
  align-items: center;
  -webkit-box-pack: justify;
  -ms-flex-pack: justify;
  justify-content: space-between;
  flex-wrap: wrap;
  border-top: 1px solid #010A28;
  margin-left: -18px;
  margin-right: -18px;
  padding: 10px 18px 0;
  margin-top: 15px;
  ul{
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
  -webkit-box-align: center;
      -ms-flex-align: center;
          align-items: center;
  -webkit-box-pack: start;
      -ms-flex-pack: start;
    justify-content: flex-start;
    padding: 0;
    margin: 0;
    list-style: none;
  li{
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      -webkit-box-pack: start;
      -ms-flex-pack: start;
      justify-content: flex-start;
      margin-right: 50px;
      .pc-author {
        font-weight: 500;
        font-size: 12px;
        color: #fff;
        margin-right: 12px;
      }
      .pc-author-name {
        width: 28px;
        height: 28px;
        overflow: hidden;
        border-radius: 50%;
        img{
          width: 100%;
          height: 100%;
          -o-object-fit: cover;
              object-fit: cover;
          -o-object-position: top;
              object-position: top;
        }
      }
      .pc-comment-icon {
        margin-right:17px;
      }
      .pc-comment{
        margin-left: 17px;
        span{
          display:inline-block;
          vertical-align:middle;
          font-weight: 500;
        }
        .pc-comment-count{
          font-size: 12px;
          color: #fff;
        }
        .pc-comment-text{
          font-size: 14px;
          color: #F2A91C;
          margin-left: 30px;
        }
      }
    }
  }
  .pcf-right{
    a{
      font-weight: 400;
      font-size: 14px;
      color: #FFFFFF;
      svg{
        margin-left:10px;
        width:18.5px;
      }
    }
  }
}
.featured-product-img {
  border-radius: 50% !important;
}

.with-ribbon {
    position: relative;
}

.with-ribbon .card-tag {
    position: absolute;
    z-index: 9;
    right: 31px;
    top: 20px;
    display: flex;
    height: 25px;
}

.with-ribbon .card-tag .ct-text {
    font-weight: 700;
    font-size: 9px;
    line-height: 11px;
    text-align: center;
    letter-spacing: 0.23em;
    color: #FFFFFF;
    background: #000927;
    padding: 5px 15px;
    position: relative;
    line-height: normal;
    display: flex;
    align-items: center;
    justify-content: center;
}

.with-ribbon .card-tag .ct-icon {
    background: #000927;
    padding: 0 5px;
    line-height: normal;
    margin-right: 2px;
    width: 25px;
    display: flex;
    align-items: center;
    justify-content: center;
}


.with-ribbon .card-tag .ct-text:after{
    content:
    '';
    position: absolute;
    top: 0;
    right: -14px;
    border: 2px solid transparent;
    border-left: 14px solid #000927;
    border-top: 14px solid transparent;
    transform: rotate(90deg);
}

.with-ribbon .card-tag .ct-text:before{
    content:'';
    position: absolute;
    bottom: 0;
    right: -14px;
    border: 2px solid transparent;
    border-left: 14px solid #000927;
    border-bottom: 14px solid transparent;
    transform: rotate(-90deg);
}

.project-grid .card-price-more .btn-icon{
  color:#fff;
}

.overflow-clip {
    display: -webkit-box;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}
.overflow-clip-1 {
  -webkit-line-clamp: 1;
}
.overflow-clip-2 {
  -webkit-line-clamp: 2;
}
.overflow-clip-3 {
  -webkit-line-clamp: 3;
}

.card-title a {
    height: 52px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    width: 100%;
}

@media all and (max-width:991px){
  .project-card > .row{
    justify-content:center;
  }
  .pcl-right{
    padding-left: 7px !important;
  }
  .ps-icon{
    margin: 0 10px;
  }
  .project-stage{
    width: 27%;
  }
}
@media all and (max-width:767px){
  .proj-descs p{
    margin-bottom:0 !important;
  }
  .proj-descs{
    margin: 0 !important;
    line-height:normal;
  }
  .like-tag{
    width: 50px !important;
  }
  .like-tag .svg-icon{
    margin-bottom:0 !important;
  }

  .like-tag .svg-icon svg{
    width: 16px;
  }

  .like-tag div,
  .proj-descs{
    font-size: 16px !important;
  }
  .project-card > .row > .col-md-3.col-6{
    text-align: center !important;
  }
  .project-card > .row > .col-md-3.col-6 img{
    width: 50% !important;
    height:auto !important;
  }
  .project-stage {
    width: 24% !important;
  }
  .ps-icon {
    margin: 0 5px;
  }
  .popular-card-image {
    margin-bottom: 20px;
    height: 250px!important;
  }
}
@media all and (max-width:575px){
  .project-card{
    font-size: 14px !important;
  }
  .project-footer {
    padding-top: 0 !important;
  }

  .project-footer ul li:first-child {
      margin-left: -18px;
      padding-left: 18px !important;
  }
  .project-card .card-project-title{
    font-size: 18px;
  }
  .project-footer > div{
    width:100%;
  }
  .project-footer ul{
    align-items:unset;
  }
  .project-footer ul li{
    flex-wrap: wrap;
    width: 100%;
    align-items:center;
    justify-content: space-between;
    margin-right: 0;
    padding-right: 30px;
    padding-top: 10px;
    padding-bottom: 10px;
    margin-bottom: 10px;
    border-right: 1px solid #010A28;
    border-bottom: 1px solid #010A28;
  }

  .project-footer ul li:last-child{
    border-right: none;
    padding-left: 20px;
    margin-right: -18px !important;
    padding-right: 18px;
  }

  .project-stage {
    width: 50% !important;
    display: block;
    margin: auto;
    text-align: center;
}
  .ps-icon {
    margin: 5px 0px;
    display: block;
    text-align: center;
  }
  .ps-icon svg{
    transform: rotate(90deg);
  }
  .pcf-right .link-hover {
    padding: 10px;
    display: inline-block;
    vertical-align: middle;
    background: transparent;
    border-radius: 8px;
    border: 2px solid #f2a91c;
  }

  .pcf-right {
      text-align: center;
  }
}

@media all and (max-width:420px){
  .project-footer {
    ul {
      li {
        padding-right: 10px !important;
        padding-left: 10px !important;
        .pc-comment-icon{
          margin-right: 10px;
          svg{
            width:16px;
            height:16px;
          }
        }
        .pc-comment{
          margin-left:0 !important;
          .pc-comment-count{
            font-size: 13px;
          }
          .pc-comment-text{
            font-size: 13px;
            margin-left: 3px;
          }
        }
      }
    }
  }
}
</style>
