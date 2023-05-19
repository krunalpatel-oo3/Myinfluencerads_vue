<template>
  <div>
    <div
      class="card"
      v-for="(com, index) in user.communities"
      :key="index"
    >
    <div class="question-block">
      <div class="question-count">
        <p class="w600 t-18">{{ index + 1 }}</p>
      </div>
      <div class="question-sec">
        <div class="question">
          <div class="ques-sec-upper">
            <router-link :to="{ name: 'communitydetail', params: { slug: com.slug }}" class="w700 t-18 text-black">{{ com.title || '' }}</router-link>
            <div class="question-btn">
              <button class="inv-button" style="margin-left: auto" @click="$router.push({ name: 'communitydetail', params: { slug: com.slug }})">
              <!-- <AdminEdit style="margin-right: 20px"/> -->
              </button>
              <button @click="showDeleteDialog(com.id, com.title)" class="inv-button">
                <AdminDelete style="margin-right: 20px;"/>
              </button>
              <button class="inv-button" @click="$router.push({ name: 'communitydetail', params: { slug: com.slug }})">
                <AdminView/>
              </button>
            </div>
          </div>
          <p class="desc mt-3 pl-0" v-html="com.desc"></p>
          <div class="upvotes pl-0">
            <ul class="list-unstyled mb-0">
              <li>
                <span class="upv-text">
                  Number of upvotes:
                </span>
                <span class="upv-count">
                  {{ com.user_community_vote_count || 0 }}
                </span>
              </li>
              <li>
                <span class="upv-text">
                  Answers:
                </span>
                <span class="upv-count">
                  {{ com.community_answer_count || 0 }}
                </span>
              </li>
              <li>
                <span class="upv-text">
                  Views:
                </span>
                <span class="upv-count">
                  {{ com.user_community_vote_count || 0 }}
                </span>
              </li>
            </ul>
          </div>
        </div>
        
      </div>
    </div>
      
      
      
    </div>
    <DeleteCommunityModel 
      :community_id = community_id
      :community_name = community_name
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
import DeleteCommunityModel from "../modals/DeleteCommunityModel";

export default {
  name: "Communities",
  props: ["user"],
  components: {
    IconStars,
    IconBase,
    AdminArrowDown,
    AdminEdit,
    AdminDelete,
    AdminView,
    DeleteCommunityModel
  },
  data() {
    return {
      publicPath: local_image_path,
      approval_tab: true,
      published_tab: true,
      community_id: "",
      community_name: "",
    };
  },
  methods: {
    showDeleteDialog (id,name) {
      this.community_id = id
      this.community_name = name
      this.$modal.show("delete-community-dialog")
    }
  },
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
        width: calc(100% - 140px);
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
      .question-btn {
          width: 140px;
          text-align: right;
      }
    }
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

