<template>
  <v-row>
    <v-col cols="12" md="12">
        <v-breadcrumbs :items="items">
          <template v-slot:divider>
            <v-icon>mdi-forward</v-icon>
          </template>
          <template v-slot:item="{ item }">
            <v-breadcrumbs-item
              :to="item.href"
              :disabled="item.disabled"
            >
              {{ item.text }}
            </v-breadcrumbs-item>
          </template>
        </v-breadcrumbs>

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


         <v-card>
          <v-card-title>
            Списки блок
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
              'items-per-page-options': [5, 10, 20, 30, 50],
              pageText: '{0} из {1}-{2}'
            }"
            :items-per-page="5"
          >

          <template v-slot:top>
            <v-toolbar flat color="white">
              <v-spacer></v-spacer>
              <v-dialog v-model="dialog" max-width="1200px">

                <v-card>
                  <v-card-title>
                    <span class="headline">Изменить блока</span>
                    <v-spacer></v-spacer>
                    <v-icon
                      class="mr-2"
                      @click="close"
                    >
                      mdi-close
                    </v-icon>
                  </v-card-title>

                  <v-card-text>

                   <v-stepper v-model="e1">
                      <v-stepper-header>
                        <v-stepper-step :complete="e1 > 1" step="1">Этап</v-stepper-step>

                        <v-divider></v-divider>

                        <v-stepper-step :complete="e1 > 2" step="2">Этап</v-stepper-step>

                        <v-divider></v-divider>

                        <v-stepper-step step="3">Этап</v-stepper-step>
                      </v-stepper-header>


                      <v-form
                        ref="form"
                        v-model="valid"
                        lazy-validation
                      >
                      <v-stepper-items>
                        <v-stepper-content step="1">
                          <v-card
                            class="mb-12"
                            height="200px"
                          >
                          <v-row>
                            <v-col cols="12" md="12">
                              <v-text-field
                                v-model="editedBlog.title"
                                :counter="10"
                                :rules="titleRules"
                                label="Название блока"
                                required
                                clearable
                              ></v-text-field>

                            </v-col>
                            <v-col cols="12" md="12">
                              <v-text-field
                                v-model="editedBlog.description"
                                :rules="descriptionRules"
                                label="Описание блока"
                                required
                                clearable
                              ></v-text-field>
                            </v-col>
                          </v-row>
                          </v-card>


                          <v-btn
                            color="primary"
                            @click="e1 = 2"
                          >
                            Далле
                          </v-btn>
                        </v-stepper-content>

                        <v-stepper-content step="2">
                          <v-card
                            class="mb-12 box_sh"
                            height="200px"
                          >
                          <v-row>
                            <v-col cols="12" md="12">
                              <v-textarea
                                v-model="editedBlog.text"
                                name="input-7-1"
                                label="Текст"
                                hint="текст"
                                :rules="textRules"
                                clearable
                              ></v-textarea>
                          </v-col>
                          </v-row>

                          </v-card>

                          <v-btn
                            color="primary"
                            @click="e1 = 3"
                          >
                            Далле
                          </v-btn>

                          <v-btn text @click="e1 = 1">Назад</v-btn>
                        </v-stepper-content>

                        <v-stepper-content step="3">
                          <v-card
                            class="mb-12"
                            height="200px"
                          >

                          <v-row>
                            <v-col cols="12" md="12">

                          <v-combobox
                              v-model="editedBlog.tags"
                              :items="tag"
                              :rules="tagRules"
                              hide-selected
                              :search-input.sync="search"
                              hint="Максимум 5 тегов"
                              label="Выберите теги"
                              item-value="id"
                              item-text="title"
                              multiple
                              persistent-hint
                              small-chips
                              clearable
                              deletable-chips

                          >

                          <template v-slot:no-data>
                            <v-list-item>
                              <v-list-item-content>
                                <v-list-item-title>
                                  Нет результатов по запросу:<strong class="ml-2">{{ search }}</strong>
                                </v-list-item-title>
                              </v-list-item-content>
                            </v-list-item>
                          </template>

                          </v-combobox>

                          </v-col>
                          <v-col cols="12" md="2">
                            <v-checkbox
                                v-model="editedBlog.status"
                                label="Активный ?"
                                class="ml-2"
                              ></v-checkbox>
                          </v-col>
                          </v-row>
                          </v-card>

                          <v-btn
                            :disabled="!valid"
                            color="primary"
                            class="mr-4"
                            @click="update"
                            :loading="isUpdating"
                          >
                            Готова
                          </v-btn>

                          <v-btn text @click="e1 = 2">Назад</v-btn>
                        </v-stepper-content>
                      </v-stepper-items>
                      </v-form>
                    </v-stepper>

                  </v-card-text>
                </v-card>
              </v-dialog>
            </v-toolbar>
          </template>


          <template v-slot:item.status="{ item }">
            <v-chip :color="getColor(item.status)" dark>
              <span v-if="item.status != 0">Активный</span>
              <span v-else>Не активный</span>
            </v-chip>
          </template>

          <template v-slot:item.tags="{ item }">
            <v-chip v-for="(tag, index) in item.tags" :key="index" color="red darken-3" class="ml-1" dark>
              <span>{{tag.title}}</span>
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
            <span class="red--text">Списки блок пусто !</span>
          </template>
          </v-data-table>
        </v-card>

    </v-col>
  </v-row>
</template>

<script>

import tagsService from "@/services/tags.service";
import blogService from "@/services/blogs.service";

export default {
   name: 'blog-list',
   data: () => ({
      e1: 1,
      valid: true,
      isUpdating: false,
      titleRules: [
        v => !!v || 'Название блока обязательно !',
      ],
      descriptionRules: [
        v => !!v || 'Описание блока обязательно !',
      ],
      tagRules: [
        v => !!v || 'Теги обязательно !',
      ],
      textRules: [
        v => !!v || 'Текст обязательно !',
      ],
      items: [
        {
          text: 'Блок',
          disabled: false,
          href: '/admin/blog',
        },
        {
          text: 'Списки блок',
          disabled: true,
          href: '',
        },
      ],
      dialog: false,
      editedBlog: {},
      defaultItem: {},
      tag: [],
      search: '',
      headers: [
        { text: 'Название', value: 'title' },
        { text: 'Статус', value: 'status' },
        { text: 'Теги', value: 'tags' },
        { text: '', value: 'actions', sortable: false },
      ],
      desserts: [],
      color: 'indigo darken-4',
      snackbar: false,
      timeout: 3000,
      x: 'right',
      y: 'top',
      text: {},
  }),
  watch: {
    dialog (val) {
      val || this.close()
    },
  },
  created () {
    this.initialize()
    this.initializeTag()
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
      close () {
        this.dialog = false
        this.$nextTick(() => {
          this.editedBlog = Object.assign({}, this.defaultItem)
        })
      },
      async initialize () {
        const {status, data} = await blogService.get();
        if (status === 200) {
          this.desserts = data;
        }
      },
      async initializeTag () {
        const {status, data} = await tagsService.get();
        if (status === 200) {
          this.tag = data;
        }
      },
      async editItem (item) {
        this.editedBlog = Object.assign({}, item)
        this.dialog = true
        this.e1 = 1
      },
      async deleteItem (item) {
        if(confirm('Вы уверены, что хотите удалить этот элемент ?')){
          const index = await blogService.delete(item.id)
          this.initialize()
          this.snackbar = true
          this.text = 'Данный было удалено !'
        }
      },
      async update () {
        if(this.$refs.form.validate()){
          const blogUpdateForm = {
            id: this.editedBlog.id,
            title: this.editedBlog.title,
            description: this.editedBlog.description,
            text: this.editedBlog.text,
            status: this.editedBlog.status ? 1 : 0,
            newtags: this.editedBlog.tags
          }

          const {status, data} = await blogService.update(blogUpdateForm)
          if (status === 200) {
            this.close()
            this.reset()
            this.initialize()
            this.initializeTag()
            this.snackbar = true
            this.text = 'Данный было изменено !'
          }

        }
      },
      reset () {
        this.$refs.form.reset()
      },
  },
}
</script>

<style>

</style>
