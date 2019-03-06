<template>
    <v-container>
        <div id="calendar"></div>
        {{  showCalendar}}
        {{reservations}}
        <v-btn @click="ref">refresh</v-btn>
        <v-dialog v-model="dialog" persistent max-width="490" width="90%">

            <v-card>
                <Reserve :edit="edit" :editData="editData" :eventDate="eventDate" :all="all"/>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="green darken-1" flat @click="dialog = false">Close</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-container>
</template>
<script>
    import '@/assets/fullcalendar.min.css'
    import Reserve from '../components/Reserve'
    export default {
        components: {
          Reserve
        },
        data: () => ({
            today: moment().format('YYYY-MM-DD') ,
            type: 'month',
            dialog: false,
            editData: {},
            edit: false,
            eventDate: '',
            dragId: '',
            all: true,
            events: [

            ]
        }),
        computed: {
            // convert the list of events into a map of lists keyed by date
            reservations(){

                $('body').css({
                    'background' : 'black'
                })

            },
            showCalendar ()  {
                let events = this.$store.getters.allReservations

                const _self = this
                $(document).ready(function() {

                    $('#calendar').fullCalendar('destroy');

                    let holidays = [];
                    let eventData = []
                    events.length > 0 && events.map((date, i) => {

                        holidays = [...holidays]
                        return holidays.push({
                            id: date.id,
                            date:  date.date,
                            type: date.type.type,
                            type_id: date.type.id,
                            user_id: date.user.id,
                            title: date.type.type,
                            start: moment(date.date).format('YYYY-MM-DD h:mm:ss'),
                            end: moment(date.date).format('YYYY-MM-DD h:mm:ss')
                        })

                    })


                    $('#calendar').fullCalendar({
                        header: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'month,agendaWeek,agendaDay'
                        },
                        defaultDate: moment(new Date()).format('YYYY-MM-DD'),
                        navLinks: true, // can click day/week names to navigate views
                        selectable: true,
                        selectHelper: true,
                        droppable: true,

                        drop: function (date) {
                            console.log(date);
                        },
                        eventDragStart: function (event, jsEvent, ui, view) {



                            _self.dragId = event.id
                           /* _self.editDate = {
                                id: userReservation.item.id,
                                date:new Date(userReservation.item.date).toUTCString(),
                                type:userReservation.item.type,
                                type_id:userReservation.item.type_id}
                             }*/

                        },
                        eventDragStop: function (event, jsEvent, ui, view) {


                        },
                        eventDrop: function (event, delta, revertFunc, jsEvent, ui, view) {
                           // _self.drag.time = event.start.format()
                            _self.handleDarag(event.start.format(), event.type_id, event.user_id)

                        },
                        select: function (start, end) {
                            console.log('select');

                            _self.editData = {};
                            _self.edit = false;
                            _self.eventDate =start.format()
                            _self.handleClickOpen()

                        },
                        eventClick: function (event, jsEvent, view) {
                            console.log('event click');
                            _self.editData = event;

                            _self.edit = true;
                            _self.handleClickOpen()
                        },
                        editable: true,
                        eventLimit: true, // allow "more" link when too many events
                        events: holidays

                    });

                    $('#calendar').fullCalendar('unselect');
                });

            }



        },
        methods: {
            open (event) {
                alert(event.title)
            },
            moment: function (date) {
                return moment(date).format('YYYY-MM-DD');
            },
            handleClickOpen(){
                this.dialog = true
            },
            handleDarag(date, type_id, user_id) {
                const data = {
                    token:  this.$store.getters.token,
                    date:      moment(date).format('YYYY-MM-DD hh:mm'),
                    type_id: +type_id,
                    user_id: +user_id,
                    id: this.dragId
                }
                this.$store.dispatch('editReservation', data)
            },
            ref(){
                this.showCalendar ()
            }

        },
        mounted() {
            // fire the vuex
            this.$store.dispatch('getTypes');
            this.$store.dispatch('getReservations');
        }



    }
</script>

<style lang="stylus" scoped>

</style>
