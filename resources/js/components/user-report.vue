<template>
    <div>
        <div v-if="success" class="alert alert-success mt-3">
            Report sent!
        </div>
        <h3>Recent Consultations:</h3>
        <div>
            <br>
            <h4>{{ consultations.created_at | moment }}</h4>
            <div v-for="prescription in consultations.prescriptions">
                <ul>
                    <li>{{prescription.drug_name}}
                        <ul>
                            <li>{{prescription.times}}x a day for {{prescription.days}} days.</li>
                        </ul>
                    </li>
                </ul>
</div>
<div class="col-md-6 border">
                    <br>
                    <h3 class="text-center">Send Report Form</h3>
                    <form @submit.prevent="submit(consultations.id)">
                        <input type="hidden" name="_token" :value="csrf">
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" class="form-control" name="subject" id="subject" v-model="fields.subject" />
                            <div v-if="errors && errors.subject" class="text-danger">{{ errors.subject[0] }}</div>
                        </div>

                        <div class="form-group">
                            <label for="body">Body</label>
                            <textarea class="form-control" name="body" id="body" v-model="fields.body" />
                            <div v-if="errors && errors.body" class="text-danger">{{ errors.body[0] }}</div>
        </div>
        <div class="form-group">

        <button type="submit" name="submit" class="btn btn-primary">Send Report</button>
        </div>
    </form>
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
            fields: {},
            errors: [],
            success: false,

            consultations: {},
        };
    },
    created() {
        this.getConsultation();
    },
    methods: {

        getConsultation() {
            axios.get('/userconsultation')
                .then((response) => {
                    this.consultations = response.data.consultations
                })
        },
        submit(id) {
            axios.post('/sendreport/' + id, this.fields)
                .then(response => {
                    this.fields = response.data
                    this.success = true
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