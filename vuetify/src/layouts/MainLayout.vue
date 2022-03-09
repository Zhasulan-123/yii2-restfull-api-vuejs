<template>
 <div>
  <v-app>
    <NavBar @toggle="drawer = !drawer"/>
    <NavigationDrawer :drawer="drawer"/>
    <v-main app>
      <v-container fluid>
        <router-view />
      </v-container>
    </v-main>
  </v-app>
  </div>
</template>

<script>
import NavBar from '@/components/main/NavBar.vue';
import NavigationDrawer from '@/components/main/NavigationDrawer.vue';

export default {
    data() {
      return {
        drawer: false,
      }
    },
    components: {
      NavBar, NavigationDrawer
    },
}
</script>

<style>

</style>
