<template>
    <v-container>
        <div v-if="edit">
            <h1>Edit reservation</h1>
            {{this.$store.getters.user.id}}
            <form>
                <div class="date_time">
                    <div><h3>{{moment(editData.date)}}</h3></div>
                    <div><h3>{{editData.type}}</h3></div>
                    <div>
                        <label for="">Pick a date and time</label>
                        <datetime
                                @input="setDate($event)"
                                type="datetime"
                                :min-datetime="now"
                        />
                    </div>
                </div>
                <v-select
                        item-text="type"
                        item-value="id"
                        :items="types"
                        v-on:input="onSelect"
                        :hint="editData.type"
                        label="Select service type"
                        persistent-hint
                ></v-select>
                <v-btn @click="editReservation" color="success">Edit</v-btn>
                <v-btn  @click="deleteReservation(editData.id)" color="error">Delete</v-btn>
            </form>
        </div>
        <div v-else>
            <h1>Make new reservation</h1>

            <div  v-if="all">
                    <h2>Please choose an employee</h2>
            </div>
            <div v-else>


                <form>
                    <div v-if="!monthView">
                        <h3>{{moment(eventDate)}} </h3>
                    </div>
                    <div v-else>
                        <h3>{{moment(eventDate)}}</h3>
                        <div class="date_time">
                            <label for="">Pick a time</label>
                            <datetime
                                    @input="setDate($event)"
                                    type="time"
                                    use12-hour
                                    :min-datetime="now"
                                    :max-datetime="now"
                            />
                        </div>
                    </div>
                    <div class="date_time" v-else>
                        <label for="">Pick a date and time</label>
                        <datetime
                                @input="setDate($event)"
                                type="datetime"
                                :min-datetime="now"
                        />
                    </div>
                    <v-select
                            item-text="type"
                            item-value="id"
                            :items="types"
                            v-on:input="onSelect"
                            label="Select service type"
                    ></v-select>
                    <v-select
                            item-text="name"
                            item-value="id"
                            :items="users"
                            v-on:input="onSelectUser"
                            label="Select client"
                    ></v-select>
                    <v-btn @click="submit" color="#5c6bc0" style="color: white">submit</v-btn>
             </form>
            </div>
        </div>
    </v-container>
</template>
<script>
    import {Datetime} from 'vue-datetime';
    import moment from 'moment';
    export default {
        props: {
            edit: {
                type: Boolean,
                default: false
            },
            editData: {
                type: Object,
                default: {}
            },
            eventDate: {
                type: String,
                default: ''
            },
            all: {
                type: Boolean,
                default: true
            },
            monthView: {
                type: Boolean,
                default: false
            }
        },
        data: () => ({
            date: '',
            type: '',
            user: '',
            typeValue: '',
            userEmail : '',
            username: '',
            e7: null,
        }),
        components: {
            Datetime
        },
        computed: {
            now() {

                const date = this.eventDate ? new Date(this.eventDate) : new Date(Date.now())

                return date.toISOString()
            },
            types() {
                return this.$store.getters.allTypes
            },
            users() {
                return this.$store.getters.allUsers
            }
        },
        methods: {

            setDate(value) {
                this.date = value
            },
            onSelect(selectObj) {
                this.type = selectObj

                this.$store.getters.allTypes.map(filter => {
                     filter.id  === selectObj  ? this.typeValue  =filter.type  : ''
                })

            },
            onSelectUser(selectObj) {
                this.user = selectObj;
                this.$store.getters.allUsers.map(filter => {
                    if(filter.id  === selectObj ){
                        this.userEmail = filter.email
                        this.username = filter.name
                    }
                })

            },
            cancelReservation() {
                this.editData = {}
                this.edit = false
            },
            editReservation() {
                //if(this.date && this.type) {
                const user_id = +this.$store.getters.user.id
                const data = {
                    token: this.$store.getters.token,
                    date: this.date ? moment(this.date).format('YYYY-MM-DD hh:mm') : moment(this.editData.date).format('YYYY-MM-DD hh:mm'),
                    type_id: this.type ? +this.type : +this.editData.type_id,
                    user_id: user_id,
                    id: this.editData.id,
                    employee_id: this.editData.employee_id
                }
                console.log(data);
                this.$store.dispatch('editReservation', data)
                //}
            },
            submit() {
                const date = this.eventDate ? new Date(this.eventDate) : new Date(Date.now())
                !this.monthView ? this.date = date : ''


                if (this.date && this.type) {
              
                    const data = {
                        token: this.$store.getters.token,
                        date: moment(this.date).format('YYYY-MM-DD hh:mm'),
                        type_id: +this.type,
                        typeValue: this.typeValue,
                        user_id: +this.$store.getters.user.id,
                        employee_id: +window.location.hash.substr(1),
                        username: this.username,
                        userEmail: this.userEmail
                    }

                    this.$store.dispatch('createReservation', data)
                    this.date = ''
                    this.type = ''
                }
            },
            deleteReservation(reservationId) {
                this.$store.dispatch('deleteReservation', +reservationId);
            },
            moment: function (date) {
                return moment(date).format('MMMM Do YYYY, h:mm:ss a');
            }
        },
        created() {
            this.$store.dispatch('getUsers');
        }
    }
</script>