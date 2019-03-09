<template>
    <div>
        <v-list class="pt-0" dense>
            <v-divider></v-divider>
            <v-list-tile>

                <v-list-tile-content>
                    <v-list-tile-title @click="getAllEmployeesData">All</v-list-tile-title>
                </v-list-tile-content>

            </v-list-tile>

            <v-list-tile
                    v-for="employee in employees"
                    :key="employee.id"
                    @click=""
            >

                <v-list-tile-content  v-bind:class="{active: isActive}" >
                   <v-list-tile-title @click="getEmployeeData(employee.id)">{{ employee.name }}</v-list-tile-title>
                </v-list-tile-content>

            </v-list-tile>
        </v-list>

    </div>

</template>

<script>

    export default {
        data(){
          return {
              isActive: false
          }
        },
        components: {

        },
        computed: {
            employees(){
                return this.$store.getters.allEmployees;

            }
        },
        methods:{
            getEmployeeData(id){
                this.active = true
                this.$store.dispatch('getReservationByEmployee', id)

             },
            getAllEmployeesData(){

            }
        },
        created() {
            // fire the vuex
            this.$store.dispatch('getEmployees');


        }
    }
</script>
