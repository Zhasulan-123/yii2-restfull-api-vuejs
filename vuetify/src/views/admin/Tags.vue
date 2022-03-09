<template>
  <v-row>
    <v-col cols="12" md="12">

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

        <v-form
          ref="form"
          v-model="valid"
          lazy-validation
        >
          <v-container>
            <v-row row>
              <v-col
                cols="12"
                md="1"
                class="text-center"
              >
               <v-icon :class="iconColor">
                  {{ formTitle }}
                </v-icon>
              </v-col>
              <v-col
                cols="12"
                md="4"
              >
                 <v-text-field
                  v-model="editedTag.title"
                  label="Название тэг"
                  outlined
                  :rules="titleRules"
                  dense
                  required
                  clearable
                ></v-text-field>
              </v-col>

              <v-col
                cols="12"
                md="2"

              >
              <v-switch
                v-model="editedTag.status"
                inset
                label="Статус ?"
                class="mt-0"
              ></v-switch>
              </v-col>

              <v-col
                cols="12"
                md="1"
              >
                <v-btn
                  :loading="isUpdating"
                  depressed
                  tile
                  :color="colorBotton"
                  @click="save"
                  dense
                  dark
                  >{{formBotton}}</v-btn>
              </v-col>
            </v-row>
          </v-container>
        </v-form>

        <v-card>
          <v-card-title>
            Списки тэги
            <v-spacer></v-spacer>
            <v-text-field
              v-model="search"
              append-icon="mdi-magnify"
              label="Поиск"
              single-line
              clearable
              hide-details
            ></v-text-field>
          </v-card-title>
          <v-data-table
            :headers="headers"
            :items="desserts"
            :search="search"
             :footer-props="{
              itemsPerPageText: 'Количество строк',
              'items-per-page-options': [5, 10, 20, 30, 50],
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

    </v-col>
  </v-row>
</template>

<script>

import tagsService from "@/services/tags.service";

export default {
    name: 'tags',
    data () {
      return {
        valid: true,
        search: '',
        isUpdating: false,
        editedTag: {},
        editedIndex: -1,
        defaultItem: {},
        titleRules: [
          v => !!v || 'Название тэг обязательно !',
        ],
        headers: [
          { text: 'Название тэги', value: 'title' },
          { text: 'Статус', value: 'status' },
          { text: '', value: 'actions', sortable: false },
        ],
        desserts: [],
        color: 'indigo darken-4',
        snackbar: false,
        timeout: 3000,
        x: 'right',
        y: 'top',
        text: {}
      }
    },
    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'mdi-tag-plus' : 'mdi-tag-minus'
      },
      formBotton () {
        return this.editedIndex === -1 ? 'Добавить' : 'Изменить'
      },
      colorBotton () {
        return this.editedIndex === -1 ? 'indigo' : 'green'
      },
      iconColor () {
        return this.editedIndex === -1 ? 'green--text' : 'red--text'
      },

    },
    created () {
      this.initialize()
    },
    watch: {
      isUpdating (val) {
        if (val) {
          setTimeout(() => (this.isUpdating = false), 3000)
        }
      },
    },
    methods: {
      reset () {
        this.$refs.form.reset()
      },
      close () {
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },
      getColor (status) {
        if (status !== 1){
          return 'red'
        }
        else{
          return 'green'
        }
      },
      async initialize () {
        const {status, data} = await tagsService.get();
        if (status === 200) {
          this.desserts = data;
        }
      },
      async editItem (item) {
        this.editedIndex = this.desserts.indexOf(item)
        this.editedTag = Object.assign({}, item)
      },
      async deleteItem (item) {
        if(confirm('Вы уверены, что хотите удалить этот элемент ?')){
          const index = await tagsService.delete(item.id)
          this.initialize()
          this.snackbar = true
          this.text = 'Данный было удалено !'
        }
      },
      async save () {
        if(this.$refs.form.validate()){
          if (this.editedIndex > -1) {
             this.isUpdating = true
             const formTagsUpdate = {
                 id: this.editedTag.id,
                 title: this.editedTag.title,
                 status: this.editedTag.status ? 1 : 0,
               }
              const {status, data} = await tagsService.update(formTagsUpdate);
              if (status === 200) {
                  this.reset()
                  this.initialize()
                  this.close()
                  this.snackbar = true
                  this.text = 'Данный было обновлено !'
              }
          }else{
            if (this.$refs.form.validate()) {
               this.isUpdating = true
               const formTags = {
                 title: this.editedTag.title,
                 status: this.editedTag.status ? 1 : 0,
               }
                const {status, data} = await tagsService.create(formTags)
                if (status === 201) {
                  this.initialize()
                  this.reset()
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
