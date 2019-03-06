<template>
    <v-container>
        <h1>Login </h1>
    <v-form @submit.prevent="submit" id="check-login-form">

        <v-text-field
                v-model="login_email"
                :error-messages="emailErrors"
                label="E-mail"
                required
                @input="$v.login_email.$touch()"
                @blur="$v.login_email.$touch()"
        ></v-text-field>
        <v-text-field
                v-model="login_password"
                :error-messages="passwordErrors"
                :counter="10"
                label="password"
                type="password"
                required
                @input="$v.login_password.$touch()"
                @blur="$v.login_password.$touch()"
        ></v-text-field>



        <v-btn type="submit" color="info" form="check-login-form" @click="submit">submit</v-btn>

    </v-form>
        <p>Don't have an account? <router-link to="/register">Register</router-link></p>
    </v-container>
</template>
<script>
    import { validationMixin } from 'vuelidate'
    import { required, minLength, email } from 'vuelidate/lib/validators'

    export default {
        mixins: [validationMixin],

        validations: {
            login_password: { required, minLength: minLength(6) },
            login_email: { required, email },

        },

        data: () => ({
            login_password: '',
            login_email: '',

        }),

        computed: {

            passwordErrors () {
                const errors = []
                if (!this.$v.login_password.$dirty) return errors
                !this.$v.login_password.minLength && errors.push('Password must at least 6 characters long')
                !this.$v.login_password.required && errors.push('Password is required.')
                return errors
            },
            emailErrors () {
                const errors = []
                if (!this.$v.login_email.$dirty) return errors
                !this.$v.login_email.email && errors.push('Must be valid e-mail')
                !this.$v.login_email.required && errors.push('E-mail is required')
                return errors
            }
        },

        methods: {
            submit () {

                const user = new URLSearchParams()
                user.append('login', this.login_email)
                user.append('password', this.login_password)
                if (this.$v.$invalid) {
                    console.log('invalid');
                } else {
                    this.$store.dispatch('loginUser', user)

                }

            }

        }
    }
</script>