<template>
<v-card class="mt-2" :loading="isUpdating">

   <template v-slot:progress>
      <v-progress-linear
        absolute
        color="red"
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

  <v-card-title>
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
    sort-by="calories"
    class="elevation-1"
    :search="search"
    :footer-props="{
      itemsPerPageText: 'Количество строк',
      'items-per-page-options': [5, 10, 30, 40, 50],
      pageText: '{0} из {1}-{2}'
    }"
    :items-per-page="5"
  >
    <template v-slot:top>
      <v-toolbar flat color="white">
        <v-toolbar-title>Списки товара</v-toolbar-title>
        <v-divider
          class="mx-4"
          inset
          vertical
        ></v-divider>
        <v-spacer></v-spacer>
        <v-dialog v-model="dialog" max-width="500px">
          <template v-slot:activator="{ on, attrs }">
            <v-btn
              color="primary"
              dark
              rounded
              class="mb-2"
              v-bind="attrs"
              v-on="on"
            >Добавить</v-btn>
          </template>
          <v-card>
            <v-card-title>
              <span class="headline">{{ formTitle }}</span>
            </v-card-title>

            <v-card-text>
              <v-container>
                <v-form
                    ref="form"
                    v-model="valid"
                    lazy-validation
                  >
                <v-row>
                  <v-col cols="12" sm="6" md="12">
                    <v-text-field
                       v-model="editedItem.title"
                       label="Название"
                       :counter="100"
                       :rules="titleRules"
                       required
                       clearable
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="12">
                    <v-textarea
                      v-model="editedItem.text"
                      append-icon="mdi-comment"
                      class="mx-2"
                      label="Текст"
                      rows="1"
                      :counter="1000"
                      :rules="textRules"
                      required
                      clearable
                    ></v-textarea>
                  </v-col>
                </v-row>
                </v-form>
              </v-container>
            </v-card-text>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn rounded color="error" text @click="reset">Очистить</v-btn>
              <v-btn rounded color="red darken-3" text @click="close">Закрыть</v-btn>
              <v-btn rounded color="primary" :disabled="!valid" text @click="save">{{formBotton}}</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-toolbar>
    </template>
    <template v-slot:item.actions="{ item }">
      <v-icon
        small
        class="mr-2"
        @click="editItem(item)"
      >
        mdi-pencil
      </v-icon>
      <v-icon
        small
        @click="deleteItem(item)"
      >
        mdi-delete
      </v-icon>
    </template>
    <template v-slot:no-data>
      <span class="red--text">Списки пусто !</span>
    </template>
  </v-data-table>
  </v-card>
</template>

<script>

import postService from "../../services/post.service";

export default {
   name: 'admin',
   data: () => ({
      valid: true,
      search: '',
      dialog: false,
      isUpdating: false,
      headers: [
        { text: 'Название', value: 'title' },
        { text: 'Текст', value: 'text' },
        { text: '', value: 'actions', sortable: false },
      ],
      titleRules: [
        v => !!v || 'Имя обязательно !',
        v => (v && v.length <= 100) || 'Имя должно не больше 100 символов',
      ],
      textRules: [
        v => !!v || 'Текст обязательно !',
        v => (v && v.length <= 1000) || 'Текст должно не больше 1000 символов',
      ],
      desserts: [],
      editedIndex: -1,
      editedItem: {},
      defaultItem: {},
      color: 'indigo darken-4',
      snackbar: false,
      timeout: 3000,
      x: 'right',
      y: 'top',
      text: {}
    }),
    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'Добавить товар' : 'Изменить товар'
      },
      formBotton () {
        return this.editedIndex === -1 ? 'Добавить' : 'Изменить'
      },
    },
    watch: {
      dialog (val) {
        val || this.close()
      },
      isUpdating (val) {
        if (val) {
          setTimeout(() => (this.isUpdating = false), 2000)
        }
      },
    },
    created () {
      this.initialize()
    },
    methods: {
      reset () {
        this.$refs.form.reset()
      },
      async initialize () {
        const {status, data} = await postService.get();
        if (status === 200) {
          this.isUpdating = true
          this.desserts = data;
        }
      },
      async editItem (item) {
        this.editedIndex = this.desserts.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },
      async deleteItem (item) {
        if(confirm('Вы уверены, что хотите удалить этот элемент ?')){
          const index = await postService.delete(item.id)
          this.initialize()
          this.snackbar = true
          this.text = 'Данный было удалено !'
        }
      },
      close () {
        this.dialog = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },
      async save () {
        if(this.$refs.form.validate()){
          if (this.editedIndex > -1) {
              const {status, data} = await postService.update(this.editedItem);
              if (status === 200) {
                  this.initialize()
                  this.close()
                  this.snackbar = true
                  this.text = 'Данный было обновлено !'
              }
          }else{
            if (this.$refs.form.validate()) {
                const {status, data} = await postService.create(this.editedItem)
                if (status === 201) {
                  this.initialize()
                  this.close()
                  this.snackbar = true
                  this.text = 'Данный было добавлено !'
                }
            }
          }
        }
      },
    },
}
</script>

<style>

</style>
