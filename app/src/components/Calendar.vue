<template>
    <div class="">
        <div class="calendar_wrapper">
            <div id="calendar"></div>
        </div>
            {{  showCalendar}}

            <v-btn @click="ref">refresh</v-btn>
            <v-dialog v-model="dialog" persistent max-width="490" width="90%">

                <v-card>
                    <Reserve :edit="edit" :editData="editData" :monthView="monthView" :eventDate="eventDate" :all="all"/>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="green darken-1" flat @click="dialog = false">Close</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>

    </div>

</template>
<script>
    import '@/assets/fullcalendar.min.css'
    import Reserve from '../components/Reserve'
    import Employees from '../components/Employees'

    export default {
        components: {
            Reserve,
            Employees

        },
        props:{
            employeeData: {
                type: Array,
                default: []
            },
            all: {
                type: Boolean,
                default: true
            }
        },
        data: () => ({
            today: moment().format('YYYY-MM-DD') ,
            type: 'month',
            dialog: false,
            editData: {},
            monthView: false,
            edit: false,
            eventDate: '',
            dragId: '',
            allow: false,

            events: [

            ]
        }),
        computed: {

            showCalendar ()  {
                let calendarData = this.$store.getters.calendar;
                let minTime, maxTime, slot, dateRange,  disabledDates;
                calendarData.length > 0 && calendarData.map(calendar => {
                   // console.log(calendar);
                    minTime = calendar.business_hours_start;
                    maxTime = calendar.business_hours_end;
                    slot = calendar.slot;
                    dateRange = calendar.date_range;
                    disabledDates = calendar.disabled_date
                })

                let events =  this.employeeData


                const _self = this
                calendarData.length > 0 && $(document).ready(function() {

                    _self.monthView = (localStorage.getItem('view') !== 'agendaWeek')
                    let view = localStorage.getItem('view') ? localStorage.getItem('view') : 'agendaWeek'
                    $(document).on('click', '.fc-month-button', function(){
                        localStorage.setItem('view', 'month')
                       _self.monthView = true
                    });
                    $(document).on('click', '.fc-agendaWeek-button', function(){
                        localStorage.setItem('view', 'agendaWeek')
                        _self.monthView = false
                    });


                    $('#calendar').fullCalendar('destroy');

                    let holidays = [];
                    let eventData = []
                    events.length > 0 && events.map((date, i) => {

                        holidays = [...holidays]
                        return holidays.push({
                            id: date.id,
                            date:  date.date,
                            type: date.type.type ? date.type.type : date.type,
                            type_id: date.type.id ? date.type.id : date.type_id,
                            user_id: date.user_id,
                            title: date.type.type ? date.type.type : date.type,
                            start: moment(date.date).format('YYYY-MM-DD H:mm:ss'),
                            end: moment(date.date).format('YYYY-MM-DD H:mm:ss'),
                            employee_id: date.employee_id,
                            backgroundColor: '#850986'
                        })

                    })


                    $('#calendar').fullCalendar({
                        header: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'month,agendaWeek,agendaDay',

                        },

                        defaultDate: moment(new Date()).format('YYYY-MM-DD'),
                        navLinks: true, // can click day/week names to navigate views
                        selectable: true,
                        selectHelper: true,
                        droppable: true,
                        timezone : 'local',
                        defaultView:  view ,
                        start: moment(new Date()).format('YYYY-MM-DD'),
                        validRange: {
                            start: moment(new Date()).format('YYYY-MM-DD'),
                            end: moment(new Date()).add(dateRange, 'month').format('YYYY-MM-DD')
                        },
                        minTime: minTime,
                        maxTime: maxTime,
                        slotDuration: slot,
                        showNonCurrentDates: true,
                        firstDay: moment().day(),
                        businessHours: {
                            // days of week. an array of zero-based day of week integers (0=Sunday)
                            dow: [ 1, 2, 3, 4 , 5], // Monday - Thursday

                        },
                        viewRender: function(view, element){
                           let intervalStart = view.intervalStart.format();
                            let intervalEnd = view.intervalEnd.format();

                        },
                        dayClick: function( date, allDay, jsEvent, view ) {
                            var myDate = new Date();

                            //How many days to add from today?
                            var daysToAdd = 1;

                            myDate.setDate(myDate.getDate() + daysToAdd);

                            if (date < myDate) {
                            }
                            else {

                            }

                            _self.editData = {};
                            _self.edit = false;
                            _self.eventDate = date.format()
                            _self.handleClickOpen()
                            _self.allow = true
                        },


                            drop: function (date) {

                        },
                        eventDragStart: function (event, jsEvent, ui, view) {



                            _self.dragId = event.id


                        },
                        eventDragStop: function (event, jsEvent, ui, view) {


                        },
                        eventDrop: function (event, delta, revertFunc, jsEvent, ui, view) {
                            // _self.drag.time = event.start.format()
                            _self.handleDarag(event.start.format(), event.type_id, event.user_id, event.employee_id)

                        },
                        select: function (start, end) {
                            if(_self.allow ) {


                            }

                        },
                        eventClick: function (event, jsEvent, view) {
                            _self.editData = event;

                            _self.edit = true;
                            _self.handleClickOpen()
                        },
                        editable: true,
                        eventLimit: true, // allow "more" link when too many events
                        events: holidays

                    });
                    disabledDates.length > 0 && disabledDates.map(ddate=> {
                        let d = moment(ddate.disabled_date).format('YYYY-MM-DD');
                        $("[data-date="+d+"]").attr("class", 'fc-day fc-widget-content fc-disabled-day');

                    })
                    //$("[data-date='2019-03-15']").addClass("disabled-slot");
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
            handleDarag(date, type_id, user_id, employee_id) {
                const data = {
                    token:  this.$store.getters.token,
                    date:      moment(date).format('YYYY-MM-DD HH:mm'),
                    type_id: +type_id,
                    user_id: +user_id,
                    id: this.dragId,
                    employee_id:  employee_id
                }

                this.$store.dispatch('editReservation', data)
            },
            ref(){
                this.showCalendar ()
            }

        },
        mounted() {
            // fire the vuex
            this.$store.dispatch('getCalendar');
            this.$store.dispatch('getTypes');
            this.$store.dispatch('getReservations');
            this.$store.dispatch('getUsers');

        }



    }
</script>

<style lang="stylus" scoped>

</style>
