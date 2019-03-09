<template>
    <v-container grid-list-xl text-xs-center>
        <h2>{{this.$store.getters.user.name ? 'welcome '+this.$store.getters.user.name : ''}}</h2>

        <v-layout row wrap>
            <v-flex xs2 md2 lg2>
                <div>
                {{getHashId}}



                    <v-list  dense>
                        <v-list-tile  @click="getAllEmployeesData">

                            <v-list-tile-content>
                                <v-list-tile-title >All</v-list-tile-title>
                            </v-list-tile-content>

                        </v-list-tile>

                        <v-list-tile
                                v-for="employee in employees"
                                :key="employee.id"
                                @click=""
                        >

                            <v-list-tile-content    v-bind:class="{ active: +hash === +employee.id}">
                                <v-list-tile-title @click="getEmployeeData(employee.id)">{{ employee.name }}</v-list-tile-title>
                            </v-list-tile-content>

                        </v-list-tile>
                    </v-list>

                </div>
            </v-flex>
            <v-flex xs10 md10 lg10>
              <calendar :employeeData="employeeData" :all="all"/>
            </v-flex>
        </v-layout>
    </v-container>
</template>
<script>
    import '@/assets/fullcalendar.min.css'
    import Reserve from '../components/Reserve'
    import Employees from '../components/Employees'
    import Calendar from '../components/Calendar'



    /*  import '@/assets/js/moment.min.js'
      import '@/assets/js/jquery.min.js'
      import '@/assets/js/jquery-ui.min.js'
      import '@/assets/js/fullcalendar.min.js'*/

    export default {
        data(){
          return {
              employeeData: [],
              all: true,
              hash: '',
              isActive: true,

          }
        },
        components: {
            Reserve,
            Employees,
            Calendar
        },
        computed: {
            cravings() {
                return this.hash ? 'active' : '';
            },
            getHashId(){

              this.hash = window.location.hash.substr(1);
              this.getEmployeeData(this.hash)
            },
            employees(){
                return this.$store.getters.allEmployees;

            }
        },
        methods:{


            getEmployeeData(id = this.hash){
                window.location.hash = id
                this.hash = id


                this.all = false
                let res = this.$store.dispatch('getReservationByEmployee', id)
                let _self = this
                    res.then(function(result) {
                        _self.employeeData = result
                    })

            },
            getAllEmployeesData(){

                this.hash = ''
                window.location.hash = ''
                this.all = true
            }
        },
        created() {
            // fire the vuex

            this.$store.dispatch('checkToken');
            this.$store.dispatch('getEmployees');


        }


    }
</script>

<style lang="stylus" scoped>

</style>
