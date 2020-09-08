<template>
    <div>
        <div v-if="success" class="alert alert-success mt-3">
            Patient successfully added!
        </div>
            <h2>Search Patient</h2>
            <div class="search-container">
                <i class="fa fa-search"></i> <input type="text" placeholder="Search.." v-model="keywords">
            </div>
            <br>
            <button type="button" class="btn btn-success" @click="patientForm = !patientForm">
                <i aria-hidden="true" class="fa fa-fw fa-user-plus"></i> Add Patient
            </button>
            <br>
            <br>
        <br>
        <div v-if="patientForm" class="float-none">
            <div class="pl-5 pr-5">
            
                <form @submit.prevent="submit(pharmacies.id)">
                    <input type="hidden" name="_token" :value="csrf">
                    <div class="col-md-8 justify-content-center">
                        <h4 class="text-center">Add Patient</h4>
                        <div class="form-group row">
                            <label for="firstname">First Name</label>
                            <input type="text" class="form-control" name="firstname" id="firstname" v-model="fields.firstname" />
                            <div v-if="errors && errors.firstname" class="text-danger">{{ errors.firstname[0] }}</div>
                        </div>

                        <div class="form-group row">
                            <label for="lastname">Last Name</label>
                            <input type="text" class="form-control" name="lastname" id="lastname" v-model="fields.lastname" />
                            <div v-if="errors && errors.lastname" class="text-danger">{{ errors.lastname[0] }}</div>
                        </div>
                        <div class="form-group row">
                            <label for="email">Email Address</label>
                            <input type="email" class="form-control" name="email" id="email" v-model="fields.email" />
                            <div v-if="errors && errors.email" class="text-danger">{{ errors.email[0] }}</div>
                        </div>
                        <div class="form-group row">
                            <label for="birthday">Birthday</label>
                            <input type="date" class="form-control" name="birthday" id="birthday" v-model="fields.birthday" />
                            <div v-if="errors && errors.birthday" class="text-danger">{{ errors.birthday[0] }}</div>
                        </div>
                        <div class="form-group row">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" name="phone" id="phone" v-model="fields.phone" />
                            <div v-if="errors && errors.phone" class="text-danger">{{ errors.phone[0] }}</div>
                        </div>
                        <div class="form-group row">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" name="address" id="address" v-model="fields.address" />
                            <div v-if="errors && errors.address" class="text-danger">{{ errors.address[0] }}</div>
                        </div>
                        <div class="form-group row">
                            <label for="city">City</label>
                            <input type="text" class="form-control" name="city" id="city" v-model="fields.city" />
                            <div v-if="errors && errors.city" class="text-danger">{{ errors.city[0] }}</div>
                        </div>
                        <div class="form-group row">
                            <label for="state">State</label>
                            <input type="text" class="form-control" name="state" id="state" v-model="fields.state" />
                            <div v-if="errors && errors.state" class="text-danger">{{ errors.state[0] }}</div>
                        </div>
                        <div class="form-group row">
                            <label for="zip">Zip</label>
                            <input type="text" class="form-control" name="zip" id="zip" v-model="fields.zip" />
                            <div v-if="errors && errors.zip" class="text-danger">{{ errors.zip[0] }}</div>
                        </div>
                    
                    <div class="form-group row">
                        <label for="pharmacy">Select Pharmacy</label>
                        <div class="col-md-6">
                            <select class="form-control" id="pharmacy" name="pharmacy" v-model="fields.pharmacy">
                                <option v-for="pharmacy in pharmacies" :selected="pharmacy === 'pharmacy 2'? true : false">
                                    {{pharmacy.pharmacy_name}}</option>
                            </select>
                        </div>
                        <div v-if="errors && errors.pharmacy" class="text-danger">{{ errors.pharmacy[0] }}</div>
                        
                    </div>
                    </div>
                    <div class="form-group row">
                        <button type="submit" name="submit" class="btn btn-primary">Add Patient</button>
                    </div>
                </form>
            </div>
        </div>
        <table class="table table-bordered">
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Birthday</th>
                <th width="200px">Action</th>
            </tr>

            <tr v-for="user in users" :key="user.id">
                <td>{{user.firstname}}</td>
                <td>{{user.lastname}}</td>
                <td>{{user.patient.birthday}}</td>
                <td>
                    <a class="btn btn-primary" :href="'/patientrecords/'+ user.id">Show</a>
                </td>
            </tr>
        </table>
                <div v-if="!users.length">
        <h3 class="text-center">No records found!</h3>
        </div>

    </div>
</template>
<script>
export default {
    data() {
        return {
        csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            success: false,
            keywords: null,
            users: {},
            pharmacies: {},
            fields: {},
            errors: [],
            patientForm: false,
        };
    },
    watch: {
        keywords(after, before) {
        this.fetch();
    }
    },
    created() {
            this.getUser()
            this.getPharmacies()
        },
    methods: {
        fetch() {
            axios.get('/search', { params: { keywords: this.keywords } })
                .then(response => this.users = response.data)
                .catch(error => {});
        },
        getUser(){
                axios.get('/list')
                     .then((response)=>{
                       this.users = response.data.users
                     })
            },
        getPharmacies(){
                axios.get('/pharmacies')
                     .then((response)=>{
                       this.pharmacies = response.data.pharmacies
                     })
            },
            submit(id) {
            axios.post('/addpatient/user', this.fields)
                .then(response => {
                    this.fields = response.data
                    this.success = true
                    this.fetch()
                    this.patientForm = false
                }).catch((error) => {
                    console.log(error)
                    this.errors = error.response.data.errors;
                });
        }

    },

}
</script>