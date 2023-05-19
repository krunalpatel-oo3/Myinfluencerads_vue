<template>
  <div>
    <div class="accordion" @click="approval_tab = !approval_tab">
      <p class="t-color7">Waiting for approval ({{ user.projects_pending.length || 0 }})</p>
      <AdminArrowDown class="ml-auto tr" :style="!approval_tab ? 'transform: rotate(180deg);' : ''" />
    </div>
    <div v-show="approval_tab">
      <div class="card" v-for="(project, index) in user.projects_pending">
        <div class="row mx-0">
          <p class="w600 t-18 pr-num">0{{ index + 1 }}</p>
          <router-link :to="{ name: 'project', params: { slug: project.slug } }" class="w700 t-18 text-black">{{ project.name }}</router-link>
          <button class="inv-button" style="margin-left: auto" @click="$router.push({ name: 'projectedit', params: { slug: project.slug }})">
            <AdminEdit style="margin-right: 20px" />
          </button>
          <button @click="deleteProject(project.id)" class="inv-button">
            <AdminDelete style="margin-right: 20px;" />
          </button>
          <button class="inv-button" @click="$router.push({ name: 'project', params: { slug: project.slug }})">
            <AdminView />
          </button>
        </div>
        <p class="desc" v-html="project.desc"></p>
        <div class="upvotes">
          <p class="mb-0">Number of upvotes: </p><span>0</span>
        </div>
      </div>
    </div>
    <div class="accordion" @click="published_tab = !published_tab">
      <p class="t-color7">Published ({{ user.projects.length || 0 }})</p>
      <AdminArrowDown class="ml-auto tr" :style="!published_tab ? 'transform: rotate(180deg);' : ''" />
    </div>
    <div v-show="published_tab">
      <div class="card" v-for="(project, index) in user.projects">
        <div class="question-block">
          <div class="question-count">
            <p class="w600 t-18 pr-num mr-0">0{{ index + 1 }}</p>
          </div>
          <div class="question-sec">
            <div class="question">
              <div class="ques-sec-upper">
                <router-link :to="{ name: 'project', params: { slug: project.slug } }" class="w700 t-18 text-black">{{ project.name }}</router-link>
                <div class="question-btn">
                  <button @click="$router.push({ name: 'projectedit', params: { slug: project.slug }})" class="inv-button" style="margin-left: auto">
                    <AdminEdit style="margin-left: auto; margin-right: 20px" />
                  </button>
                  <button @click="showDeleteDialog(project.id, project.name)" class="inv-button">
                    <AdminDelete style="margin-right: 20px;" />
                  </button>
                  <button class="inv-button" @click="$router.push({ name: 'project', params: { slug: project.slug }})">
                    <AdminView />
                  </button>
                </div>
              </div>
              <p class="desc mt-3 pl-0" v-html="project.desc"></p>
              <div class="upvotes pl-0">
                <ul class="list-unstyled mb-0">
                  <li>
                    <span class="upv-text">
                      Number of upvotes:
                    </span>
                    <span class="upv-count">
                      0
                    </span>
                  </li>
                </ul>
              </div>
            </div>
            
          </div>
        </div>
        <div class="row mx-0">
          
          
          
        </div>
        
        
      </div>
    </div>
    <DeleteProjectModal 
      :system_id = system_id
      :system_name = system_name
      :user = user
    />
  </div>
</template>

<script>
import IconStars from "../../common/icons/IconStars.vue";
import IconBase from "../../common/IconBase.vue";
import AdminArrowDown from "../icons/AdminArrowDown";
import AdminDelete from "../icons/AdminDelete";
import AdminEdit from "../icons/AdminEdit";
import AdminView from "../icons/AdminView";
import DeleteProjectModal from "../modals/DeleteProjectModal";

export default {
  name: "Systems",
  props: ["user"],
  components: {
    IconStars,
    IconBase,
    AdminArrowDown,
    AdminEdit,
    AdminDelete,
    AdminView,
    DeleteProjectModal,
  },
  data() {
    return {
      publicPath: local_image_path,
      approval_tab: true,
      published_tab: true,
      projects: "",
      pending_project: "",
      system_id: "",
      system_name: ""
    };
  },
  methods: {
    showDeleteDialog (id,name) {
      this.system_id = id
      this.system_name = name
      this.$modal.show("delete-project-dialog")
    }
  },
  mounted() {
    this.projects = this.userdashboard ? this.userdashboard.projects : [];
    this.pending_project = this.userdashboard ? this.userdashboard.pending_project : "";
  }
};
</script>

<style lang="scss" scoped>
* {
  font-family: 'Poppins';
}

.tr {
  transition: .3s;
}

.card {
  border: 1.5px solid #D2D5DD;
  padding: 20px 34px;

  .pr-num {
    margin-right: 20px;
  }

  .desc {
    font-weight: 500;
    font-size: 16px;
    line-height: 19px;
    margin-top: 0;
    padding-left: 40px;
  }

  .upvotes {
    padding-left: 40px;
    margin-top: 0px;

    p {
      color: #000000;
      text-decoration: underline;
      font-weight: 500;
      font-size: 16px;
      line-height: 19px;
      display: inline-block;
    }

    span {
      margin-left: 17px;
      color: #F2A91C;
      font-weight: bold;
    }
  }
}


.question-block {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: start;
        -ms-flex-align: start;
            align-items: flex-start;
    -webkit-box-pack: start;
        -ms-flex-pack: start;
            justify-content: flex-start;
    .question-count {
        width: 30px;
    }
    .question-sec {
      width: calc(100% - 30px);
      padding-left: 10px;
      position: relative;
      display: -webkit-inline-box;
      display: -ms-inline-flexbox;
      display: inline-flex;
      -webkit-box-align: start;
          -ms-flex-align: start;
              align-items: flex-start;
      -webkit-box-pack: justify;
          -ms-flex-pack: justify;
              justify-content: space-between;
              -ms-flex-wrap: wrap;  
              -ms-flex-wrap: wrap;   
              flex-wrap: wrap;
      margin-bottom: 6px;
      .question{
        width: 100%;
        .ques-sec-upper{
          a{
            display:block;
            padding-right: 115px;
          }
          position: relative;
          .question-btn {
            position: absolute;
            right: 0;
            top: 0;
          }
        }
        .upvotes{
          ul{
            display:flex;

            li{
              margin-right:30px;
              .upv-text{
                color: #000000;
                text-decoration: underline;
                font-weight: 500;
                font-size: 16px;
                line-height: 19px;
                display: inline-block;
                margin: 0 !important;
              }
              .upv-count{
                margin-left: 17px;
                color: #F2A91C;
                font-weight: bold;
              }
            }
          }
        }
      }
      
    }
}




@media all and (max-width:991px){
  .card{
    padding:20px;
  }
  .question-block {
    .question-count{
      p{
        font-size:16px;
      }
     
    }
    .question-sec{
      .question{
        a{
          font-size:16px;
        }
        .upvotes{
          ul{
            display:flex;

            li{
              margin-right:20px;
              .upv-text,
              .upv-count{
                font-size: 14px;  
              }
             
            }
          }
        }
        .ques-sec-upper{
          .question-btn {
          
          text-align: right;
          .inv-button{
            svg{
              width:14px;
              height:16px;
              margin-right: 10px !important;
            }
          }
      }
        }
      }
     
    }
    }

   
}

@media all and (max-width:575px){
  .card{
    padding:35px 20px 20px;
  }
  .question-block{
    .question-sec{
      .question{
        .ques-sec-upper{
          .question-btn {
              width:auto;
              position: absolute;
              right: 0;
              top: -30px;
          }
        }
      }
      
      .upvotes{
        li{
          margin-right: 15px;
          text-align: center;
          .upv-text{
            line-height: normal;
          }
          .upv-count{
            margin-left: 8px;
          }
          &:last-child{
            margin-right:0 !important;
          }
        }
      }
    }
  }
}

@media all and (max-width:420px){
  .question-block{
    .question-sec{
      .upvotes{
        ul{
          flex-direction:column;
          li{
            text-align:left;
          }
        }
      }
    }
  }
}
</style>

