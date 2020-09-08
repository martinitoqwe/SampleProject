<template>
    <div>
        <div v-if="success" class="alert alert-success mt-3">
            Information successfully updated!
        </div>
        <br>
        <div v-for="user in user">
            <div class="info">
                <h1 class="display-4">Patient Information</h1>
                <strong>Name: </strong>{{user.lastname}}, {{user.firstname}}<br>
                <strong>Birthday:</strong> {{user.patient.birthday | moment}}<br>
                <strong>Pharmacy:</strong> {{user.patient.pharmacy.pharmacy_name}}<br>
                <a class="btn btn-info" @click.prevent="edit(user)">
                    Update Patient Information
                </a>
            </div>
            <div v-if="patientForm" class="float-none">
            <div class="pl-5 pr-5">
                <form @submit.prevent="update(fill.id)">
                    <input type="hidden" name="_token" :value="csrf">
                    <div class="col-md-8 justify-content-center">
                        <h4 class="text-center">Add Patient</h4>
                        <div class="form-group row">
                            <label for="firstname">First Name</label>
                            <input type="text" class="form-control" name="firstname" id="firstname" v-model="fill.firstname" />
                            <div v-if="errors && errors.firstname" class="text-danger">{{ errors.firstname[0] }}</div>
                        </div>

                        <div class="form-group row">
                            <label for="lastname">Last Name</label>
                            <input type="text" class="form-control" name="lastname" id="lastname" v-model="fill.lastname" />
                            <div v-if="errors && errors.lastname" class="text-danger">{{ errors.lastname[0] }}</div>
                        </div>
                        <div class="form-group row">
                            <label for="email">Email Address</label>
                            <input type="email" class="form-control" name="email" id="email" v-model="fill.email" />
                            <div v-if="errors && errors.email" class="text-danger">{{ errors.email[0] }}</div>
                        </div>
                        <div class="form-group row">
                            <label for="birthday">Birthday</label>
                            <input type="date" class="form-control" name="birthday" id="birthday" v-model="fill.birthday" />
                            <div v-if="errors && errors.birthday" class="text-danger">{{ errors.birthday[0] }}</div>
                        </div>
                        <div class="form-group row">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" name="phone" id="phone" v-model="fill.phone" />
                            <div v-if="errors && errors.phone" class="text-danger">{{ errors.phone[0] }}</div>
                        </div>
                        <div class="form-group row">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" name="address" id="address" v-model="fill.address" />
                            <div v-if="errors && errors.address" class="text-danger">{{ errors.address[0] }}</div>
                        </div>
                        <div class="form-group row">
                            <label for="city">City</label>
                            <input type="text" class="form-control" name="city" id="city" v-model="fill.city" />
                            <div v-if="errors && errors.city" class="text-danger">{{ errors.city[0] }}</div>
                        </div>
                        <div class="form-group row">
                            <label for="state">State</label>
                            <input type="text" class="form-control" name="state" id="state" v-model="fill.state" />
                            <div v-if="errors && errors.state" class="text-danger">{{ errors.state[0] }}</div>
                        </div>
                        <div class="form-group row">
                            <label for="zip">Zip</label>
                            <input type="text" class="form-control" name="zip" id="zip" v-model="fill.zip" />
                            <div v-if="errors && errors.zip" class="text-danger">{{ errors.zip[0] }}</div>
                        </div>
                    
                    <div class="form-group row">
                        <label for="pharmacy">Select Pharmacy</label>
                        <div class="col-md-6">
                            <select class="form-control" id="pharmacy" name="pharmacy" v-model="fill.pharmacy">
                                <option v-for="pharmacy in pharmacies" :selected="pharmacy === 'pharmacy 2'? true : false">
                                    {{pharmacy.pharmacy_name}}</option>
                            </select>
                        </div>
                        <div v-if="errors && errors.pharmacy" class="text-danger">{{ errors.pharmacy[0] }}</div>
                        
                    </div>
                    </div>
                    <div class="form-group row">
                        <button type="submit" name="submit" class="btn btn-primary">Update Patient Information</button>
                    </div>
                </form>
                 </div>
            </div>
        </div>
        <hr>
        <a @click="consultationForm=!consultationForm" class="btn btn-primary">Add Consultation</a><br><br>
        <div v-if="successconsultation" class="alert alert-success mt-3">
            Consultation successfully added!
        </div>
         <div v-if="consultationForm" class="float-none">
            <div class="pl-5 pr-5" v-for="user in user">
                <form @submit.prevent="addConsultation(user.id)">
                    <input type="hidden" name="_token" :value="csrf">
                    <div class="col-md-8 justify-content-center">
                        <h4 class="text-center">Add Consultation</h4>
                                <div class="col-md-12">
                                <div class="form-group">
                                    <strong>Diagnosis</strong>
                                    <textarea name="diagnosis" id="diagnosis" class="form-control" placeholder="Input diagnosis" v-model="fields.diagnosis"></textarea>
                                    <div v-if="errors && errors.diagnosis" class="text-danger">{{ errors.diagnosis[0] }}</div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <strong>Physician Name</strong>
                                    <input type="text" name="physician_name" id="physician_name" class="form-control" v-model="fields.physician_name">
                                    <div v-if="errors && errors.physician_name" class="text-danger">{{ errors.physician_name[0] }}</div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Add Consultation</button>
                            </div>
                            <br>
                    </div>    
                </form>
                 </div>
            </div>
        <h2>Recent Consultation(s):</h2>
        <div v-if="!consultations.length">
        <h3>No consultation found!</h3>
        </div>
        <ul v-for="consultation in consultations">
            <li><a :href="'/consultationshow/'+ consultation.id"><strong>{{consultation.created_at | moment}}</strong></a></li>
        </ul>
    </div>
</template>
<script>
import moment from 'moment'
export default {
    data() {
        return {
        csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            success: false,
            successconsultation: false,
            user: {},
            fields: {},
            errors: [],
            fill: {'firstname':'','lastname':'','email':'', 'birthday': '', 'phone':'', 'address':'','city':'','state':'','zip':'','pharmacy':''},
            pharmacies: {},
            consultations: {},
            consultationForm: false,
            patientForm: false,
        };
    },
    created() {
            this.getUser()
            this.getPharmacies()
            this.getConsultation()
        },
    methods: {
        getUser(){
                var id = window.location.href.split('/');
                var lastSegment = id.pop() || id.pop();
                axios.get('/patient/'+lastSegment)
                     .then((response)=>{
                       this.user = response.data.user
                     })
            },
        getConsultation(id){
        var id = window.location.href.split('/');
        var lastSegment = id.pop() || id.pop();
        axios.get('/consultation/'+ lastSegment)
                     .then((response)=>{
                       this.consultations = response.data.consultations.reverse()
                     })
        },
        getPharmacies(){
                axios.get('/pharmacies')
                     .then((response)=>{
                       this.pharmacies = response.data.pharmacies
                     })
            },
        edit(user){
                this.patientForm = true
                this.fill.id = user.id
                this.fill.firstname = user.firstname
                this.fill.lastname = user.lastname
                this.fill.email = user.email
                this.fill.birthday = user.patient.birthday
                this.fill.phone = user.patient.phone
                this.fill.address = user.patient.address
                this.fill.city = user.patient.city
                this.fill.state = user.patient.state
                this.fill.zip = user.patient.zip
            },
            update(id) {
            axios.post('/updatepatient/' +id, this.fill)
                .then(response => {
                    this.fill = response.data
                    this.success = true
                    this.patientForm = false
                    this.getUser()
                    this.getPharmacies()
                    this.getConsultation()
                }).catch((error) => {
                    console.log(error)
                    this.errors = error.response.data.errors;
                });
        },
        addConsultation(id) {
            axios.post('/consultation/'+id, this.fields)
                .then(response => {
                    this.fields = response.data
                    this.successconsultation = true
                    this.getConsultation()
                    this.consultationForm = false
                }).catch((error) => {
                    console.log(error)
                    this.errors = error.response.data.errors;
                });
        }
    },
    filters: {
        moment: function(date) {
            return moment(date).format('MMMM Do YYYY');
        }
    },


}
</script>