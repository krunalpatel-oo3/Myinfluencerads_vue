<template>
        <main>
        <!-- banner section  -->
        <section class="banner-section">


            <div class="container">
                <p>Dashboard...</p>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <DataTable 
                            
                             :columns="columns"
                             ajax="api/users"
                             class="table table-striped table-bordered display" :options="{ responsive:true, autowidth:false, dom:'Bfrtip'}">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>No</th>
                                        <th>Desc</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                            </DataTable>
                            <ChildComponent :callMethod="parentCall" :childCall="childCall" ref="post" />
                        </div>
                    </div>
                </div>
                <button type="button" @click="logout">logout</button>
            </div>
        </section>
        </main>
</template>

<script>
import axios from 'axios';
import DataTable from 'datatables.net-vue3';
import DataTableLib from 'datatables.net-bs5';
import Buttons from 'datatables.net-buttons-bs5';
import ButtonsHTml5 from 'datatables.net-buttons/js/buttons.html5';
import print from 'datatables.net-buttons/js/buttons.print';
import pdfmake from 'pdfmake';
import pdfFonts from 'pdfmake/build/vfs_fonts';


import 'datatables.net-responsive-bs5';
import JsZip from 'jszip';
window.JsZip = JsZip;
DataTable.use(DataTableLib);
DataTable.use(pdfmake);
DataTable.use(ButtonsHTml5);
pdfMake.vfs = pdfFonts.pdfMake.vfs;

import {reactive,ref} from 'vue'
//import { userRouter } from "vue-router"
//Toaster notification
import { useToast } from "vue-toastification";
import "vue-toastification/dist/index.css" 
import ChildComponent from "./ChildComponent.vue";

// import  'https://code.jquery.com/jquery-3.7.0.min.js'
// import  'https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js'
// // import * from 'https://cdn.datatables.net/autofill/2.5.3/css/autoFill.dataTables.min.css'

    export default{
        components:{
            DataTable,
            ChildComponent
        },
        data(){
            return{
                columns: [
                        {data:null, render: function(data, type, row, meta){
                            return `${meta.row+1}`
                        }
                    },
                    {data:'name'}, 
                    {data:'mobile'}, 
                    {
                        data:'name',
                        render: function(data, type, row, meta){
                            var btn = 'btn<i class="fas fa-edit"></i>';
                            return btn;
                        }
                    }, 
                    ],
                users: null,
            }
        },
        setup(){ },
        methods:{
            parentCall(){
                alert('Parent call..');
                this.$refs.post.childCall(12)
            },
            async logout(){
                // Get toast interface
                const toast = useToast();
                const $v =this.$router;
                axios.post('api/logout').then(res =>{
                    console.log(res.data)
                    toast.error(res.data.data.message)
                    localStorage.removeItem('token');
                    $v.push('/login');
                });
            },
            getUsers(){
                
                axios.get('api/users').then(
                    respononse =>{
                        console.log(respononse.data.data);
                        this.users = 
                        respononse.data.data
                        // [[1,2,3,5]]
                        // [{'id': 1, 'name': 'krunal', 'mobile': '54545'}]
                        // respononse.data
                        ;
                        // [
                        //     {
                        //         "id" : 1
                        //     }
                        //     // {
                        //     //     // id: '1',
                        //     //     "id": '1',
                        //     //     "name": 'KRP',
                        //     //     "desc": 'KRP-desc',
                        //     //     "rep": 'KRP-Rep'
                        //     // }
                        // ];
                    }
                );
            }
        },
        mounted(){
            // this.getUsers();
            // $("#table_users").DataTable();
        }
    }
</script>

<style>
    @import 'datatables.net-bs5';
    /* @import "https://cdn.datatables.net/autofill/2.5.3/css/autoFill.dataTables.min.css" ; */
</style>