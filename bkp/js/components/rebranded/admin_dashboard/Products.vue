<template>
  <div>
    <div class="accordion" @click="approval_tab = !approval_tab">
      <p class="t-color7">Waiting for approval ({{ user.product_pending.length || 0 }})</p>
      <AdminArrowDown class="ml-auto tr" :style="!approval_tab ? 'transform: rotate(180deg);' : ''"/>
    </div>
    <div v-show="approval_tab">
      <div v-for="(product, index) in user.product_pending" class="card">
        <div class="question-block">
          <div class="question-count">
            <p v-if="index <= 8" class="w600 t-18 pr-num">0{{ index + 1 }}</p>
            <p v-else class="w600 t-18 pr-num">{{ index + 1 }}</p>
          </div>
          <div class="question-sec">
            <div class="question">
              <div class="ques-sec-upper">
                <router-link :to="{ name: 'Product Page', params: { slug: product.slug }}" class="w700 t-18 text-black">{{ product.name }}</router-link>
                <div class="question-btn">
                  <button class="inv-button ml-auto">
                    <AdminEdit style="margin-left: auto; margin-right: 20px"/>
                  </button>
                  <button class="inv-button">
                    <AdminDelete style="margin-right: 20px;"/>
                  </button>
                  <button class="inv-button">
                    <AdminView/>
                  </button>
                </div>
              </div>
              <p class="desc pl-0" v-html="product.desc"></p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="accordion" @click="published_tab = !published_tab">
      <p class="t-color7">Published ({{ user.approved_product.length || 0 }})</p>
      <AdminArrowDown class="ml-auto tr" :style="!published_tab ? 'transform: rotate(180deg);' : ''"/>
    </div>
    <div v-show="published_tab">
      <div v-for="(product, index) in user.approved_product" class="card">
        <div class="question-block">
          <div class="question-count">
            <p v-if="index <= 8" class="w600 t-18 pr-num">0{{ index + 1 }}</p>
            <p v-else class="w600 t-18 pr-num">{{ index + 1 }}</p>
          </div>
          <div class="question-sec">
            <div class="question">
              <div class="ques-sec-upper">
                <router-link :to="{ name: 'Product Page', params: { slug: product.slug }}" class="w700 t-18 text-black">{{ product.name }}</router-link>
                <div class="question-btn">
                  <button class="inv-button ml-auto" @click="$router.push({ name: 'Edit_Product', params: { slug: product.slug }})">
                    <AdminEdit style="margin-left: auto; margin-right: 20px"/>
                  </button>
                  <button class="inv-button" @click="showDeleteDialog(product.id, product.name)">
                    <AdminDelete style="margin-right: 20px;"/>
                  </button>
                  <button class="inv-button" @click="$router.push({ name: 'Product Page', params: { slug: product.slug }})">
                    <AdminView/>
                  </button>
                </div>
              </div>
              <p class="desc pl-0" v-html="product.desc"></p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <DeleteProductModal 
      :product_id = product_id
      :product_name = product_name
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
import DeleteProductModal from "../modals/DeleteProductModal";

export default {
  name: "Products",
  props: ['user'],
  components: {
    IconStars,
    IconBase,
    AdminArrowDown,
    AdminEdit,
    AdminDelete,
    AdminView,
    DeleteProductModal
  },
  data() {
    return {
      publicPath: local_image_path,
      approval_tab: true,
      published_tab: true,
      product_id: "",
      product_name: ""
    };
  },
  methods: {
    showDeleteDialog (id,name) {
      this.product_id = id
      this.product_name = name
      this.$modal.show("delete-product-dialog")
    }
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

