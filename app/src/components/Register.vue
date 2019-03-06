<template>
    <v-container>
        <h1>Register </h1>
        {{token}}

        <form>
            <v-text-field
                    v-model="name"
                    :error-messages="nameErrors"
                    label="First name"
                    required
                    @input="$v.name.$touch()"
                    @blur="$v.name.$touch()"
            ></v-text-field>
            <v-text-field
                    v-model="surname"
                    :error-messages="surnameErrors"
                    label="Last name"
                    required
                    @input="$v.surname.$touch()"
                    @blur="$v.surname.$touch()"
            ></v-text-field>

            <v-text-field
                    v-model="email"
                    :error-messages="emailErrors"
                    label="E-mail"
                    name="email"
                    required
                    @input="$v.email.$touch()"
                    @blur="$v.email.$touch()"
            ></v-text-field>
            <v-text-field
                    v-model="password"
                    :error-messages="passwordErrors"
                    label="password"
                    type="password"
                    required
                    @input="$v.password.$touch()"
                    @blur="$v.password.$touch()"
            ></v-text-field>
            <v-text-field
                    v-model="repeatPassword"
                    :error-messages="repeatPasswordErrors"
                    label="Confirm password"
                    type="password"
                    required
                    @input="$v.repeatPassword.$touch()"
                    @blur="$v.repeatPassword.$touch()"
            ></v-text-field>



            <v-btn  @click="submit" >Register</v-btn>

        </form>
        <p>Already have an account? <router-link to="/profile">login</router-link></p>
    </v-container>
</template>
<script>
    import { validationMixin } from 'vuelidate'
    import router from '../router'

    import { required,  minLength,sameAs, email } from 'vuelidate/lib/validators'

    export default {
        mixins: [validationMixin],

        validations: {
            password: { required,  minLength: minLength(6) },
            repeatPassword: {
                sameAsPassword: sameAs('password')
            },
            email: { required, email },
            name: { required },
            surname: { required },

        },

        data: () => ({

            password: '',
            email: '',
            repeatPassword: '',
            name: '',
            surname: ''

        }),


        computed: {

            token(){
                if(this.$store.getters.token){
                    router.push({ name: 'profile' })
                }


            },
            nameErrors () {
                const errors = []
                if (!this.$v.name.$dirty) return errors
                !this.$v.name.required && errors.push('Name is required.')
                this.$v.valid = errors.length <= 0
                return errors
            },
            surnameErrors () {
                const errors = []
                if (!this.$v.surname.$dirty) return errors
                !this.$v.surname.required && errors.push('Last name is required.')
                return errors
            },
            passwordErrors () {
                const errors = []
                if (!this.$v.password.$dirty) return errors
                !this.$v.password.minLength && errors.push('Password must be at most 6 characters long')
                !this.$v.password.required && errors.push('Password is required.')
                return errors
            },
            repeatPasswordErrors () {
                const errors = []
                if (!this.$v.repeatPassword.$dirty) return errors
                !this.$v.repeatPassword.sameAsPassword && errors.push('Passwords don\'t match')
                return errors
            },
            emailErrors () {
                const errors = []
                if (!this.$v.email.$dirty) return errors
                !this.$v.email.email && errors.push('Must be valid e-mail')
                !this.$v.email.required && errors.push('E-mail is required')
                return errors
            }
        },

        methods: {
            submit () {

                const user = new URLSearchParams()
                user.append('email', this.email)
                user.append('name', this.name)
                user.append('surname', this.surname)
               // user.append('login', this.email)
                user.append('password', this.password)
                user.append('password_confirmation', this.password)

               /* for (let p of user) {
                    console.log(p);
                }*/
                if (this.$v.$invalid) {
                    console.log('invalid');
                } else {
                    this.$store.dispatch('registerUser', user)

                }


              this.$v.$touch()
            },
            clear () {
                this.$v.$reset()
                this.name = ''
                this.email = ''
            }
        }
    }
</script>