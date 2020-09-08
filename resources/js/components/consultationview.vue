<template>
    <div>
        <br>
      
        <h1 class="display-4 text-center">Consultation</h1>
        <div v-for="consultation in consultation">
            <div class="info">
                <strong>Name: </strong>{{consultation.user.firstname}}, {{consultation.user.firstname}}<br>
                <strong>Birthday:</strong> {{consultation.user.patient.birthday | moment}}<br>
                <strong>Pharmacy:</strong> {{consultation.user.patient.pharmacy.pharmacy_name}}<br>
                <button type="button" class="btn btn-primary" @click="isOpen=!isOpen">
                Add Prescription
            </button>
            <div v-if="isOpen">
            <br>
                            <h4 class="display-4 text-center">Add Prescription</h4>
                        <div class="pl-5 pr-5">
                            <form @submit.prevent="submit(consultation.id)">
                                <input type="hidden" name="_token" :value="csrf">
                                <div class="form-group row">
                                        <label for="drug_name">Drug name</label>
                                        <input type="text" class="form-control" name="drug_name" id="drug_name" v-model="fields.drug_name" />
                                        <div v-if="errors && errors.drug_name" class="text-danger">{{ errors.drug_name[0] }}</div>
                                </div>
                                <div class="form-group row">
                                        <label for="times">Intake per day</label>
                                        <input type="text" class="form-control" name="times" id="times" v-model="fields.times" />
                                        <div v-if="errors && errors.times" class="text-danger">{{ errors.times[0] }}</div>

                                </div>

                                <div class="form-group row">
                                        <label for="days">Number of days</label>
                                        <input type="text" class="form-control" name="days" id="days" v-model="fields.days" />
                                        <div v-if="errors && errors.days" class="text-danger">{{ errors.days[0] }}</div>
                                </div>


                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            Add Prescription
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                <hr>
            </div>
            <br>
            <h3 class="text-center">Prescriptions</h3>
            <table class="table table-bordered" id="patients">
                <tr>
                    <th>Drug Name</th>
                    <th>Intake per Day</th>
                    <th>Number of days</th>
                    <th width="280px">Action</th>
                </tr>
                <tr v-for="prescription in consultation.prescriptions">
                    <td>{{ prescription.drug_name }}</td>
                    <td>{{ prescription.times }}</td>
                    <td>{{ prescription.days }}</td>
                    <td>
                    <a class="btn btn-primary" href="#">Edit</a>
                        <form @submit.prevent="deletePrescription(prescription.id)">
                            
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            </table>
            <div v-if="!consultation.prescriptions.length">
                <h3 class="text-center">No prescription found!</h3>
            </div>
            <br><hr>
            <h3 class="text-center">Reports</h3>
            <table class="table table-bordered" id="patients">
                <tr>
                    <th>Subject</th>
                    <th>Body</th>
                    <th>Date</th>
                </tr>
                <tr v-for="report in consultation.dailyreports">
                    <td>{{ report.subject }}</td>
                    <td>{{ report.body }}</td>
                    <td>{{ report.created_at | moment }}</td>
                </tr>
            </table>
            <div v-if="!consultation.dailyreports.length">
                <h3 class="text-center">No reports found!</h3>
            </div>
        </div>

    </div>
</template>
<script>
import moment from 'moment'
export default {
    data() {
        return {
        csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            success: false,
            errors: [],
            fields: {},
            consultation: {},
            isOpen: false,
        };
    },
    created() {
            this.getConsultation()
        },
    methods: {
        getConsultation(id){
        var id = window.location.href.split('/');
        var lastSegment = id.pop() || id.pop();
        axios.get('/consultationview/'+ lastSegment)
                     .then((response)=>{
                       this.consultation = response.data.consultation
                     })
        },
        submit(id) {
            axios.post('/prescription/' + id, this.fields)
                .then(response => {
                    this.fields = response.data
                    this.success = true
                    this.getConsultation()
                    this.isOpen = false
                }).catch((error) => {
                    console.log(error)
                    this.errors = error.response.data.errors;
                });

        },
        deletePrescription(id) {
            axios.post('/prescription/delete/' + id)
                .then(response => {
                    this.getConsultation()
                    this.success = true
                }).catch((error) => {
                    console.log(error)
                    this.errors = error.response.data.errors;
                });

        },
    },
    filters: {
        moment: function(date) {
            return moment(date).format('MMMM Do YYYY');
        }
    },
}
</script>