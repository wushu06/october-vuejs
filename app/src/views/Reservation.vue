<template>
    <v-container grid-list-xl text-xs-center v-if="token">
        <h2>{{this.$store.getters.user.name ? 'welcome '+this.$store.getters.user.name : ''}}</h2>

        <v-snackbar
                v-model="snackbar"
                :bottom="y === 'bottom'"
                :multi-line="mode === 'multi-line'"
                :timeout="timeout"
                :vertical="mode === 'vertical'"

        >
            {{errors}}

        </v-snackbar>

        <v-layout row wrap >
            <v-flex xs2 md2 lg2 class="employee_wrapper">
                <div>

                {{getHashId}}
                {{single}}




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
                                v-bind:class="{ active: +hash === +employee.id}"
                        >

                            <v-list-tile-content >
                                <v-list-tile-title @click="getEmployeeData(employee.id)">{{ employee.name }}</v-list-tile-title>
                            </v-list-tile-content>

                        </v-list-tile>
                    </v-list>

                </div>
            </v-flex>
            <v-flex xs10 md10 lg10 v-bind:class="{ calendar_container: hash}" >
                <div >
              <calendar :employeeData="employeeData" :all="all"/>
                </div>
            </v-flex>
        </v-layout>
    </v-container>
</template>
<script>

    import '@/assets/fullcalendar.min.css'
    import Reserve from '../components/Reserve'
    import Employees from '../components/Employees'
    import Calendar from '../components/Calendar'
    import { mapState, mapGetters } from 'vuex';



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
              errors:  this.$store.getters.loginErrors,
              snackbar: false,
              y: 'bottom',
              x: null,
              mode: '',
              timeout: 4000,
              text: 'Hello, I\'m a snackbar',


          }
        },
        components: {
            Reserve,
            Employees,
            Calendar
        },
        computed: {
            ...mapGetters([
                'loginErrors'
            ]),

            getHashId(){

              this.hash = window.location.hash.substr(1);
              //!this.all && this.getEmployeeData(this.hash)
            },
            employees(){
                return this.$store.getters.allEmployees;

            },
            single(){
                this.employeeData = window.location.hash  ?
                    this.$store.getters.employeeData :
                    this.$store.getters.allReservations

            },
            token(){
                return this.$store.getters.token && this.$store.getters.tokenValid;
            }
        },
        watch: {
            loginErrors (newCount, oldCount) {
                // Our fancy notification (2).
                // if(newCount !== oldCount) {
                this.snackbar =  true
                this.errors = newCount

                // }
            }
        },
        methods:{


            getEmployeeData(id = this.hash){
                window.location.hash = id
                this.hash = id
                this.all = false
                return this.$store.dispatch('getReservationByEmployee', id)


            },
            getAllEmployeesData(){

                this.hash = ''
                window.location.hash = ''
                window.location.href.replace(/#.*$/, '')
                this.all = true
                this.employeeData =  this.$store.getters.allReservations
            },


        },

        created() {

            this.$store.dispatch('checkToken');
            this.$store.dispatch('getEmployees');
            if( window.location.hash.substr(1)) {
                 this.all = false
                 this.$store.dispatch('getReservationByEmployee', +window.location.hash.substr(1))
            }else{
               // this.employeeData = this.$store.getters.allReservations
            }



        }


    }
</script>

<style lang="stylus" scoped>

</style>
