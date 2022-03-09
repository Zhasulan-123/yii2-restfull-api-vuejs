<template>
    <v-navigation-drawer
       app
       color="blue-grey darken-2"
       v-model="drawer"
    >

       <v-list-item>
        <v-list-item-content>
          <v-list-item-title class="title white--text text-center">
            Администратор
          </v-list-item-title>
        </v-list-item-content>
      </v-list-item>

      <v-divider></v-divider>
      <v-list
        dense
        nav
        rounded
      >

      <v-list-item line>
        <v-list-item-avatar>
          <img src="https://randomuser.me/api/portraits/men/81.jpg">
        </v-list-item-avatar>

        <v-list-item-content>
          <v-list-item-subtitle class="white--text">{{user.username}} {{user.fullname}}</v-list-item-subtitle>
        </v-list-item-content>
      </v-list-item>

      <hr class="black mb-2"/>

      <v-list-item-group v-model="item" color="blue lighten-5">

        <v-list-item
          v-for="item in items"
          :key="item.title"
          link
        >
          <v-list-item-icon>
            <v-icon class="white--text">{{ item.icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-content>
            <v-list-item-title class="white--text">
              <router-link
                :to="item.url"
                class="nav_text_color"
                :exact="item.exact"
              >
              {{ item.title }}
              </router-link>
            </v-list-item-title>
          </v-list-item-content>

        </v-list-item>
        </v-list-item-group>
      </v-list>
    </v-navigation-drawer>
</template>

<script>
export default {
  props: {
    drawer: Boolean,
    user: Object
  },
  data () {
      return {
        item: 1,
        items: [
          { title: 'Главная', icon: 'mdi-home', url: '/admin', exact: true },
          { title: 'Страница', icon: 'mdi-book-open-page-variant', url: '/admin/page' },
          { title: 'Категория', icon: 'mdi-content-duplicate', url: '/admin/category' },
          { title: 'Тэги', icon: 'mdi-tag', url: '/admin/tags' },
          { title: 'Блок', icon: 'mdi-post-outline', url: '/admin/blog' },
        ],
        right: null,
      }
  },
}
</script>

<style lang="scss" scoped>
.nav_text_color{
  color: #fff;
  text-decoration: none;
}
</style>

