<template>
    <v-container>

        <div v-if="token" >
            <h1>Your reservations:</h1>
            <v-data-table
                    :headers="headers"
                    :items="userReservation"
                    class="elevation-1"
            >

                <!--<template v-for="(reservation , index) in userReservation">-->
                <template  v-slot:items="userReservation">

                    <td > {{new Date(userReservation.item.date).toUTCString()}}</td>
                    <td > {{userReservation.item.type}}</td>
                    <td > <span  v-on:click="editReservation({id: userReservation.item.id, date:new Date(userReservation.item.date).toUTCString(), type:userReservation.item.type, type_id:userReservation.item.type_id} )"><i class="fas fa-pen"></i></span></td>
                    <td >  <span  v-on:click="deleteReservation(userReservation.item.id )"><i class="fas fa-trash"></i></span></td>


                </template>
            </v-data-table>
           

        </div>

            <Login v-else/>

        <v-snackbar
                v-model="snackbar"
                :bottom="y === 'bottom'"
                :multi-line="mode === 'multi-line'"
                :timeout="timeout"
                :vertical="mode === 'vertical'"

        >
            {{errors}}

        </v-snackbar>



    </v-container>

</template>
<script>
    import { mapState, mapGetters } from 'vuex';

    import Login from '../components/Login';
    import Reserve from '../components/Reserve';
    export default {
        data() {
            return {
                userData: {},
                edit: false,
                editData: {},
                editDate: '',
                headers: [
                    { text: 'Time slot', align: 'left', sortable: false, value: 'time' },
                    { text: 'Service', value: 'service',  sortable: false },
                    { text: 'Edit', value: 'edit',  sortable: false },
                    { text: 'Delete', value: 'delete',  sortable: false },
                ],
                errors:  '',
                snackbar: false,
                y: 'bottom',
                x: null,
                mode: '',
                timeout: 4000,
            }


        },
        components: {
          Login,
            Reserve
        },
        // now go back to the file and call the getter
        computed: {
            ...mapGetters([
                'loginErrors'
            ]),
            user(){

                return this.$store.getters.user;
            },

            token(){
                return this.$store.getters.token && this.$store.getters.tokenValid;
            },

            userReservation(){
                return   this.$store.getters.userReservation
            }
        },
        watch: {
            loginErrors (newCount, oldCount) {
                // Our fancy notification (2).
                // if(newCount !== oldCount) {
                this.snackbar = true
                this.errors = newCount

                // }
            }
        },
        methods:{
            editReservation(editData){
                this.edit = true
                this.editData = editData

               // this.$store.dispatch('editReservation', +reservationId);

            },
            deleteReservation(reservationId){

                this.$store.dispatch('deleteReservation', +reservationId);

            },
            createReservation(reservationId){

                this.$store.dispatch('createReservation', +reservationId);

            }

        },
        mounted(){
            this.$store.dispatch('checkToken');
            this.$store.dispatch('getTypes')
            this.$store.dispatch('userReservation', +this.$store.getters.user.id);

        },
        created() {

        },
        updated() {
           // this.$store.dispatch('userReservation', +this.$store.getters.user.id);

        }
    }
</script>