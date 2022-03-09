<template>
  <v-row>
    <v-col cols="12">
      <v-card
        class="mx-auto"
        :loading="isUpdating"
      >

      <template v-slot:progress>
        <v-progress-linear
          absolute
          color="blue lighten-5"
          height="5"
          indeterminate
        ></v-progress-linear>
      </template>

      <v-snackbar
        v-model="snackbar"
        :color="color"
        :right="x === 'right'"
        :timeout="timeout"
        :top="y === 'top'"
        rounded="pill"
      >
        {{text}}
        <template v-slot:action="{ attrs }">
          <v-btn icon color="white" v-bind="attrs" @click="snackbar = false">
            <v-icon>mdi-close</v-icon>
        </v-btn>
        </template>
      </v-snackbar>

        <v-img
          class="white--text align-end"
          height="70px"
          src="https://cdn.vuetifyjs.com/images/cards/docks.jpg"
        >
          <v-card-title>Страница списки</v-card-title>
        </v-img>

         <v-card>
          <v-card-title>
            Страница
            <v-btn to="/admin/page-add" color="primary" fab small dark class="ma-2">
              <v-icon>mdi-plus</v-icon>
            </v-btn>

            <v-spacer></v-spacer>
            <v-text-field
              v-model="search"
              append-icon="mdi-magnify"
              label="Поиск"
              single-line
              hide-details
              clearable
            ></v-text-field>
          </v-card-title>
          <v-data-table
            :headers="headers"
            :items="desserts"
            :search="search"
            :footer-props="{
              itemsPerPageText: 'Количество строк',
              'items-per-page-options': [5, 10, 30, 40, 50],
              pageText: '{0} из {1}-{2}'
            }"
            :items-per-page="5"
          >

            <template v-slot:item.status="{ item }">
              <v-chip :color="getColor(item.status)" dark>
                <span v-if="item.status != 0">Активный</span>
                <span v-else>Не активный</span>
              </v-chip>
            </template>

            <template v-slot:item.actions="{ item }">
              <router-link
                 class="mr-2 text-decoration-none"
                 :id="item.id"
                 :to="'/admin/page-view/' + item.id"
              >
                <v-icon
                  small
                  @click="{}"
                  class="blue--text"
                >
                  mdi-eye
                </v-icon>
              </router-link>
              <router-link
                 class="text-decoration-none"
                 :id="item.id"
                 :to="'/admin/page-edit/' + item.id"
              >
                <v-icon
                  small
                  class="mr-2 green--text"
                  @click="{}"
                >
                  mdi-pencil
                </v-icon>
              </router-link>
              <v-icon
                small
                @click="deleteItem(item)"
                class="red--text"
              >
                mdi-delete
              </v-icon>
            </template>
            <template v-slot:no-data>
              <span class="red--text">Страница пусто !</span>
            </template>
          </v-data-table>
        </v-card>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>

import pageService from "@/services/page.service";

export default {
   name: 'page',
   data () {
      return {
        search: '',
        isUpdating: false,
        headers: [
          { text: 'Название', value: 'title' },
          { text: 'Описание', value: 'description' },
          { text: 'Статус', value: 'status' },
          { text: '', value: 'actions', sortable: false },
        ],
        desserts: [],
        color: 'indigo darken-4',
        snackbar: false,
        timeout: 3000,
        x: 'right',
        y: 'top',
        text: {},
      }
  },
  created () {
    this.initialize()
  },
  watch: {
    isUpdating (val) {
      if (val) {
        setTimeout(() => (this.isUpdating = false), 2000)
      }
    },
  },
  methods: {
    getColor (status) {
      if (status !== 1){
        return 'red'
      }
      else{
        return 'green'
      }
    },
     async initialize () {
      const {status, data} = await pageService.get();
      if (status === 200) {
        this.isUpdating = true
        this.desserts = data;
      }
    },
    async deleteItem (item) {
      if(confirm('Вы уверены, что хотите удалить этот элемент ?')){
        this.isUpdating = true
        const index = await pageService.delete(item.id)
        this.initialize()
        this.snackbar = true
        this.text = 'Данный было удалено !'
      }
    },
  },
}
</script>

<style>

</style>
