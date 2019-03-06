import Vue from 'vue'
import Vuex from 'vuex';
import router from './router'
import axios from 'axios';
import createPersistedState from 'vuex-persistedstate'
import * as Cookies from 'js-cookie'

Vue.use(Vuex)

export default new Vuex.Store({
    plugins: [
        createPersistedState({
            storage: {
                getItem: key => Cookies.get(key),
                // Please see https://github.com/js-cookie/js-cookie#json, on how to handle JSON.
                setItem: (key, value) => Cookies.set(key, value, { expires: 3, secure: false }),
                removeItem: key => Cookies.remove(key)
            }
        })
    ],
    state: {
        // init empty state
        types: [],
        reservations: [],
        userReservation: [],
        user: {},
        token: '',
        loginErrors: [],
        invalidCredentials: ''
    },
    getters: {
        // getter will fetch the data from state whenever the state changes and assign it to allVehicles
        allTypes : state => state.types,
        allReservations : state => state.reservations,
        userReservation : state => state.userReservation,
        user: state => state.user,
        token: state => state.token,
        loginErrors: state => state.loginErrors,
        invalidCredentials: state => state.invalidCredentials,
    },
    mutations: {
        GET_TYPES : (state, types) => {
            // mutations will change the state
            state.types = types
        },
        GET_RESERVATIONS : (state, reservations) => {
            // mutations will change the state
            state.reservations = reservations
        },
        GET_USER_RESERVATION : (state, userReservation) => {
            // mutations will change the state
            state.userReservation = userReservation
            //Vue.set(state.userReservation ,userReservation )
        },
        SET_USER: (state, user) => {
            state.user = user
        },
        SET_TOKEN: (state, token) => {
            state.token = token
        },
        SET_LOGIN_ERRORS: (state, loginErrors) => {
            state.loginErrors = loginErrors
        },
        SET_INVALID_CREDENTIALS: (state, invalidCredentials) => {
            state.invalidCredentials = invalidCredentials
        },
        LOGOUT: (state) => {
            state.user = ''
            state.token = ''
        }
    },

    actions: {
        getTypes ({commit }) {
            axios.get('http://barber-october.localhost/cms/types')
                .then((res)=> {
                    // commit will fire mutations
                    commit('GET_TYPES', res.data)
                })
        },
        getReservations ({commit }) {
            axios.get('http://barber-october.localhost/cms/reservations')
                .then((res)=> {
                    // commit will fire mutations

                    commit('GET_RESERVATIONS', res.data)
                })
        },
        userReservation ({commit }, id) {
            axios.get(`http://barber-october.localhost/cms/reservations/${id}`)
                .then((res)=> {

                    // commit will fire mutations
                    commit('GET_USER_RESERVATION', res.data)
                }).catch(err=> console.log(err))
        },
        editReservation ({commit, state },  data) {

            const authorization = {
                headers: {
                    Authorization: `Bearer ${this.state.token}`
                }
            }
            const id = data.id

            axios
                .patch(
                    `http://barber-october.localhost/cms/editreservation/${id}`,
                    authorization,
                    {data: data},
                )
                .then(response => {
                    this.dispatch('userReservation', +this.state.user.id);
                    this.dispatch('getReservations');

                    console.log('edited');
                })
                .catch(error => {
                    if(error.message === 'Request failed with status code 401'){
                        this.dispatch('logout')
                    }
                })
        },
        deleteReservation ({commit }, id) {

            axios
                .delete(
                    `http://barber-october.localhost/cms/deletereservation/${id}`,

                     { data: { token: this.state.token } }


                )
                .then(response => {
                    this.dispatch('userReservation', +this.state.user.id);
                    this.dispatch('getReservations');
                    console.log(response)
                })

                .catch(error => {
                    if(error.message === 'Request failed with status code 401'){
                        this.dispatch('logout')
                    }
                })
        },
        registerUser({ commit, state }, user) {
            axios
                .post('http://barber-october.localhost/cms/api/auth/register', user)
                .then(response => {
                    router.push({ name: 'profile' })
                    console.log(response)
                })
        },

        logout({commit}) {
            commit('LOGOUT')
            router.push({ name: 'home' })
        },

        loginUser({ commit, state }, user) {
            axios
                .post('http://barber-october.localhost/cms/api/auth/login', user)
                .then(response => {
                    console.log(response)
                    commit('SET_TOKEN', response.data.token)
                    commit('SET_USER', response.data.user)

                })
                .catch(error => {
                    commit('SET_INVALID_CREDENTIALS', '')
                    commit('SET_LOGIN_ERRORS', [])


                    if(error.response.data.error) {
                        commit('SET_INVALID_CREDENTIALS', error.response.data.error)
                    } else {
                        const errors = []

                        for (const key of Object.keys(error.response.data.errors)) {
                            error.response.data.errors[key].forEach(err =>{
                                errors.push(err)
                            })
                        }

                        console.log(errors)

                        commit('SET_LOGIN_ERRORS', errors)
                    }
                })
        },
        createReservation({ commit, state }, data) {
            const authorization = {
                headers: {
                    Authorization: `Bearer ${this.state.token}`
                }
            }




            axios
                .post(
                    'http://barber-october.localhost/cms/create-reservation',
                    authorization,
                    //{ data: { token: this.state.token , date:'2019-03-02 00:00:00', user_id:1, type_id:1} },
                    {data: data},

                )
                .then(response => {
                    console.log(response)
                    this.dispatch('userReservation', +this.state.user.id);
                    this.dispatch('getReservations');
                })
                .catch(error => {
                    console.log(error)
                })
        }

    }
})
