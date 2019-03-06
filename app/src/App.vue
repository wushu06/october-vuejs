<template>
  <v-app>
    <Navbar/>
    <v-container>
      <router-view/>
    </v-container>

    <main-footer/>
  </v-app>
</template>

<script>
import Navbar from './components/UI/Navbar';
import MainFooter from './components/UI/Footer';

export default {
  name: 'App',
  components: {

      Navbar,
      MainFooter
  },
  data () {
    return {
      //
    }
  }
}
</script>
