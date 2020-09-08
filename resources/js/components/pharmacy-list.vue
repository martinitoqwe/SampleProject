<template>
    <div>
      <h2>Search</h2>
      <div class="search-container">
      <i class="fa fa-search"></i> <input type="text" placeholder="Search.." v-model="keywords">
  <br>
 </div>

<div class="mt-1" v-if="pharmacylist.length <= 0 ">
 <h3 class="text-center">No Records found</h3>
</div>
<div v-else>
<br>
        <table class="table table-bordered">
            <tr>
                <th>Name</th>
                <th>Birthday</th>
                <th>Prescription</th>
                <th width="200px">Action</th>
            </tr>
            <tr v-for="list in pharmacylist" :key="pharmacylist.id">
                <td>{{list.lastname}}, {{list.firstname}}</td>
                <td>{{list.birthday}}</td>
                <td>{{list.drug_name}}<br>
                Total:{{list.times * list.days}}</td>
                <td>
                    <a class="btn btn-danger" data-toggle="modal" data-target="#pickupConfirmation">Pickup</a>
                </td>

                <div class="modal fade mt-5" id="pickupConfirmation" tabindex="-1" role="dialog" aria-labelledby="pickupConfirmationLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pickupConfirmationLabel">Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Please confirm pickup</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <a :href="'/pickup/'+ list.id" class="btn btn-danger" type="submit">Confirm</a>
                </form>
            </div>
        </div>
    </div>
</div>
            </tr>
        </table>
        </div>
        
    </div>
</template>
<script>
    export default {
        data() {
            return {
                keywords: null,
                pharmacylist: {},
            };
        },
        watch: {
            keywords(after, before) {
                this.fetch();
            }
        },
        created() {
            this.getPrescriptions()
        },
        methods: {
        fetch() {
            axios.get('/pharmacysearch', { params: { keywords: this.keywords } })
                .then(response => this.pharmacylist = response.data)
                .catch(error => {});
        },
        getPrescriptions(){
                axios.get('/pharmacylist')
                     .then((response)=>{
                       this.pharmacylist = response.data.pharmacylist
                     })
            },
        },

    }
</script>