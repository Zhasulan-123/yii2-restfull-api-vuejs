<template>
<div>
    <v-app-bar
      color="light-blue darken-4"
      dense
      dark
      app
    >
        <v-app-bar-nav-icon class="white--text" @click="$emit('toggle')"></v-app-bar-nav-icon>

        <v-toolbar-title>
          <router-link class="text_url" to="/">Application</router-link>
        </v-toolbar-title>

        <v-spacer></v-spacer>
        <v-btn depressed color="light-blue darken-4">
            <router-link class="text_url" to="/login">Вход</router-link>
        </v-btn>
        <v-btn depressed color="light-blue darken-4">
          <router-link class="text_url" to="/register">Регистрация</router-link>
        </v-btn>
    </v-app-bar>
</div>
</template>

<script>
export default {
    name: 'navbar',
    data() {
        return {

        }
    },
}
</script>

<style scoped>
.text_url {
    text-decoration: none;
    color: #fff;
}
</style>
