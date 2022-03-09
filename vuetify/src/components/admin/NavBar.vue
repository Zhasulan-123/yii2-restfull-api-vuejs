<template>
  <div>
  <v-app-bar
      color="blue-grey darken-2"
      dense
      dark
      app
    >
      <v-app-bar-nav-icon @click="$emit('toggle')"></v-app-bar-nav-icon>
      <v-spacer></v-spacer>
      <v-menu
        left
        bottom
      >
        <template v-slot:activator="{ on, attrs }">
          <v-btn
            icon
            v-bind="attrs"
            v-on="on"
            :menu-props="{ bottom: true, offsetY: true }"
          >
            <v-icon>mdi-dots-vertical</v-icon>
          </v-btn>
        </template>

        <v-list>
          <v-list-item @click="logoutSubmin" >
            <v-list-item-title>
              Выход
            </v-list-item-title>
          </v-list-item>
        </v-list>
      </v-menu>
    </v-app-bar>
  </div>
</template>

<script>
import authService from "../../services/auth.service";

export default {
  data() {
    return {

    }
  },
  methods: {
    logoutSubmin () {
      authService.logout();
    }
  }
}
</script>

<style>

</style>
