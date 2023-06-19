<template>
<main>
    <!-- banner section  -->
    <section class="banner-section">

        <div class="container">
            <form @submit.prevent="update()" method="post">
                <vs-select  filter v-model="role_input">
                    <vs-option v-for="role in roles"  :value="role.id" :label="role.name">{{ role.name}} </vs-option>
                </vs-select>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="first_name">First Name:</label>
                            <label for="first_name">First Name:</label>
                            <input type="text" id="first_name" v-model="form.first_name" class="form-control" placeholder="Enter first name" rules="required"/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="last_name">Last Name:</label>
                            <input type="text" id="last_name" v-model="form.last_name" class="form-control" placeholder="Enter last name" rules="required"/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="contact_no">Contact Number:</label>
                            <input type="text" id="contact_no" v-model="form.contact_no" class="form-control" placeholder="Enter contact number">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary"><font-awesome-icon icon="fa-solid fa-floppy-disk fs-5" /> Submit</button>
            </form>
        </div>
    </section>
    </main>

</template>
<script>
    import axios from 'axios';
    import {reactive,ref} from 'vue';
        export default {
            components: {
            },
            data() {
                return {
                    token_data: localStorage.getItem('token'), 
                    form: {
                        first_name : '',
                        mobile : '',
                        is_amc: 1,
                        amc_price: '',
                    },
                    is_close: 1,
                    roles: [],
                    role_input: '',
                    name: '',
                }
            },
        }
</script>