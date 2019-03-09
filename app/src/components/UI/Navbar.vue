<template>
    <div>
    <v-toolbar  dark color="#5c6bc0">

        <v-toolbar-title><router-link to="/"><img src='@/assets/scissors.svg'  alt="" width="45" ></router-link></v-toolbar-title>
        <v-spacer></v-spacer>

        <v-toolbar-items class="hidden-xs-only">
            <v-tooltip bottom v-if="token">
                <template v-slot:activator="{ on }">
                    <v-btn flat v-on="on">
                        <router-link to="/reservation"><i class="fas fa-table"></i></router-link>
                    </v-btn>
                </template>
                <span>Reservations</span>
            </v-tooltip>
            <v-tooltip bottom>
                <template v-slot:activator="{ on }">
            <v-btn flat v-on="on"> <router-link to="/profile"> <i class="far fa-user-circle"></i></router-link></v-btn>
                </template>
                <span>Profile</span>
            </v-tooltip>
            <v-tooltip bottom>
                <template v-slot:activator="{ on }">
                <v-btn flat v-on="on"> <router-link to="/contact"> <i class="fas fa-envelope"></i></router-link></v-btn>
                </template>
                <span>Contact us</span>
            </v-tooltip>
            <v-tooltip bottom  v-if="token">
                <template v-slot:activator="{ on }">
                     <v-btn flat v-on="on">  <router-link to="/logout"> <i class="fas fa-sign-out-alt"></i></router-link></v-btn>
                </template>
                <span>Logout</span>
            </v-tooltip>


        </v-toolbar-items>
        <v-toolbar-side-icon class="hidden-sm-and-up"   @click.stop="drawer = !drawer"></v-toolbar-side-icon>

    </v-toolbar>



        <v-navigation-drawer
                v-model="drawer"
                absolute
                temporary
        >
            <v-list class="pa-1">
                <v-list-tile avatar>
                    <v-list-tile-avatar>
                        <img src='@/assets/scissors.svg'  alt="" width="45" >
                    </v-list-tile-avatar>

                    <v-list-tile-content>
                        <v-list-tile-title>Hello {{user}}</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
            </v-list>

            <v-list class="pt-0" dense>
                <v-divider></v-divider>

                <v-list-tile
                        v-for="item in menu"
                        :key="item.title"
                        @click=""
                >
                    <v-list-tile-action>
                        <router-link :to=item.link> <v-icon>{{ item.icon }}</v-icon></router-link>
                    </v-list-tile-action>
                    <v-list-tile-content>
                        <router-link :to=item.link> <v-list-tile-title>{{ item.title }}</v-list-tile-title></router-link>
                    </v-list-tile-content>

                </v-list-tile>
            </v-list>
        </v-navigation-drawer>

    </div>
</template>
<script>
    export default {
        data () {
            return {
                drawer: null,
                items: [
                    { title: 'Home', icon: 'dashboard', link: '/' },
                    { title: 'contact', icon: 'question_answer', link: '/contact' },
                    { title: 'Profile', icon: 'question_answer', link: '/profile' },
                ]
            }
        },

        computed: {
          user(){
              return this.$store.getters.user.name;
          },
            token(){
                return this.$store.getters && this.$store.getters.tokenValid;
            },
            menu(){
               let menu =  this.items

                if(this.token){
                    if (menu.filter(function(e) { return e.title === 'logout'; }).length <= 0) {
                        menu.push( { title: 'logout', icon: 'question_answer', link: '/logout' })
                        menu.unshift( { title: 'Reservations', icon: 'question_answer', link: '/reservation' })
                    }
                }
               return menu;
            }

        },
        methods: {

        }
    }
</script>