<template>
 <div>
  <v-app>
      <!-- loading = true -->
    <NavBar @toggle="drawer = !drawer"/>
    <NavigationDrawer :drawer="drawer" :user="user"/>
    <v-main app>
      <v-container fluid>
        <router-view />
      </v-container>
    </v-main>
  </v-app>
  </div>
</template>

<script>
import NavBar from '@/components/admin/NavBar.vue';
import NavigationDrawer from '@/components/admin/NavigationDrawer.vue';
import authService from '@/services/auth.service';

export default {
    data() {
      return {
        drawer: true,
        user: {},
      }
    },
    components: {
      NavBar,
      NavigationDrawer
    },
    methods: {
      
    },
    async mounted() {
      this.user = await authService.getUser()
    }
}
</script>

<style>

</style>
