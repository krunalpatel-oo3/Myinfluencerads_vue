<template>
  <div>
    <div
      class="card"
      v-for="(brand, index) in brands"
      :key="index"
    >
    <div class="question-block">
      <div class="question-count ques-img">
        <img :src="brand.brandImagePropsArray.image_url || `${publicPath}company-logo-01.png`" class="company-logo">
      </div>
      <div class="question-sec">
        <div class="question">
          <div class="ques-sec-upper">
            <router-link :to="{ name: 'Brand Page', params: { slug: brand.slug }}" class="company-title">{{ brand.name }}</router-link>
          <div class="question-btn controls">
            <button @click="$router.push({ name: 'Edit Brand', params: { slug: brand.slug }})" class="inv-button">
            <AdminEdit style="margin-right: 15px"/>
            </button>
            <button @click="showDeleteDialog(brand.id, brand.name)" class="inv-button">
              <AdminDelete style="margin-right: 15px"/>
            </button>
            <button @click="$router.push({ name: 'Brand Page', params: { slug: brand.slug }})" class="inv-button" style="margin-left: auto">
              <AdminView />
            </button>
          </div>
          </div>
        </div>
      </div>
    </div>
      
    </div>
    <DeleteBrandModal 
      :brand_id = brand_id
      :brand_name = brand_name
      :user = user
    />
  </div>
</template>

<script>
import AdminArrowDown from "../icons/AdminArrowDown";
import AdminDelete from "../icons/AdminDelete";
import AdminEdit from "../icons/AdminEdit";
import AdminView from "../icons/AdminView";
import DeleteBrandModal from "../modals/DeleteBrandModal";

export default {
  name: "Brands",
  props: ["user"],
  components: {
    AdminArrowDown,
    AdminEdit,
    AdminDelete,
    AdminView,
    DeleteBrandModal
  },
  data() {
    return {
      publicPath: local_image_path,
      brand_id: "",
      brand_name: "",
    };
  },
  methods: {
    showDeleteDialog (id,name) {
      this.brand_id = id
      this.brand_name = name
      this.$modal.show("delete-brand-dialog")
    }
  },
  computed: {
    brands () {
      return this.user.brand
    }
  }
};
</script>

<style lang="scss" scoped>
  * {
    font-family: 'Poppins';
  }
  .card {
    border: 1.5px solid #D2D5DD;
    padding: 15px 30px;
    .company-logo {
      width: 50px;
      height: 50px;
      border-radius: 50%;
    }
    .company-title {
      
      font-weight: 600;
      font-size: 18px;
      
      margin-bottom: 0;
    }
  }
  
  .question-block {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
          -ms-flex-align: center;
              align-items: center;
      -webkit-box-pack: start;
          -ms-flex-pack: start;
              justify-content: flex-start;
      .question-count.ques-img {
          width: auto;
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
      .company-logo{
        width: 40px;
        height: 40px;
      }
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
