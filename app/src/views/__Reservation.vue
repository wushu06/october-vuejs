<template>
  <v-container>
   <h1>Reservations</h1>

        <v-btn @click="changeView">Change view</v-btn>
      <v-layout>
          <v-flex>
              <v-sheet height="500">
                  <v-calendar
                          :now="today"
                          :value="today"
                          color="primary"

                          :type="type"
                  >
                      <template v-slot:day="{ date }">
                          <template v-for="event in eventsMap[date]">

                              <v-menu
                                      :key="event.id"
                                      v-model="event.open"
                                      full-width
                                      offset-x
                              >
                                  <template v-slot:activator="{ on }">
                                      <div
                                              v-if="event.date"
                                              v-ripple
                                              class="my-event"
                                              v-on="on"
                                              v-html="event.type.type"
                                      ></div>
                                  </template>
                                  <v-card
                                          color="grey lighten-4"
                                          min-width="350px"
                                          flat
                                  >
                                      <v-toolbar
                                              color="primary"
                                              dark
                                      >
                                          <v-btn icon>
                                              <v-icon>edit</v-icon>
                                          </v-btn>
                                          <v-toolbar-title v-html="event.olddate"></v-toolbar-title>
                                          <v-spacer></v-spacer>
                                      </v-toolbar>
                                      <v-card-title primary-title>
                                          <span v-html="event.type.type"></span>
                                          <span v-html="event.cdate"></span>
                                          <span v-html="event.olddate"></span>

                                      </v-card-title>
                                      <v-card-actions>
                                          <v-btn
                                                  color="warning"
                                                  flat

                                          >
                                              Cancel
                                          </v-btn>
                                      </v-card-actions>
                                  </v-card>
                              </v-menu>
                          </template>
                      </template>
                  </v-calendar>
              </v-sheet>
          </v-flex>
      </v-layout>

      <ul>
          {{reservations}}
          <li

                  v-for="reservation in reservations"

          >

          </li>
      </ul>



  </v-container>
</template>

<script>
import moment from 'moment';
export default {
    data: () => ({
        today: moment().format('YYYY-MM-DD') ,
        type: 'month',
        events: [

        ]
    }),
    computed: {
        // convert the list of events into a map of lists keyed by date
        reservations(){
            let items = []
            let projects = this.$store.getters.allReservations
            for (var i in projects) {
                    if (projects[i].date) {
                        projects[i].olddate = moment(projects[i].date).format("hh:mm:ss a");
                        projects[i].cdate = projects[i].date;
                        projects[i].date = moment(projects[i].date).format('YYYY-MM-DD');


                    }

            }
          //  console.log(projects);
           this.events = projects;


        },
        eventsMap () {
            const map = {}

            this.events.forEach(e => {
                return (map[e.date] = map[e.date] || []).push(e)
            })
            console.log(map);
            return map
        }
    },
    methods: {
        open (event) {
            alert(event.title)
        },
        moment: function (date) {
            return moment(date).format('YYYY-MM-DD');
        },
        changeView(){
            if(this.type === 'week'){
                return this.type = 'month';
            }else{
                return this.type = 'week';
            }
        }
    },
    mounted() {
        // fire the vuex
        this.$store.dispatch('getTypes');
        this.$store.dispatch('getReservations');
    },

}
</script>

<style lang="stylus" scoped>
    .my-event {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        border-radius: 2px;
        background-color: #1867c0;
        color: #ffffff;
        border: 1px solid #1867c0;
        width: 100%;
        font-size: 12px;
        padding: 3px;
        cursor: pointer;
        margin-bottom: 1px;
    }
</style>
