<template>
  <v-row row>
    <v-col cols="12">

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

       <v-card class="mx-auto" :loading="isUpdating">

          <template v-slot:progress>
            <v-progress-linear
              absolute
              color="red"
              height="5"
              indeterminate
            ></v-progress-linear>
          </template>

          <v-img
            class="white--text align-end"
            height="70px"
            src="https://cdn.vuetifyjs.com/images/cards/docks.jpg"
          >
            <v-card-title>Категория</v-card-title>

          </v-img>
          <v-row row>
            <v-col cols="12" md="5" class="pl-5 pr-5 pb-5 pt-5">
             <v-form
                ref="form"
                v-model="valid"
                lazy-validation
              >
               <v-select
                  v-model="categoryId"
                  :items="category"
                  item-value="id"
                  :menu-props="{ bottom: true, offsetY: true }"
                  label="Категория"
                  outlined
                  clearable
                  dense
                >
                </v-select>

                <v-text-field
                  v-model="title"
                  :counter="50"
                  :rules="titleRules"
                  label="Название"
                  required
                  outlined
                  clearable
                  dense
                ></v-text-field>

                <v-text-field
                  v-model="description"
                  :rules="descriptionRules"
                  label="Описание"
                  :counter="200"
                  required
                  outlined
                  clearable
                  dense
                ></v-text-field>

                <v-switch
                  v-model="status"
                  inset
                  label="Статус ?"
                ></v-switch>

                <v-btn
                  :disabled="!valid"
                  color="success"
                  class="mr-4"
                  @click="submitForm"
                >
                  Добавить
                </v-btn>

                <v-btn
                  color="error"
                  class="mr-4"
                  @click="reset"
                >
                  Очистить
                </v-btn>

              </v-form>

            </v-col>
            <v-col cols="12" md="7" class="pl-5 pr-5 pb-5 pt-0">

              <v-row>
                <v-col cols="12" md="12">
                  <v-text-field
                    v-model="search"
                    append-icon="mdi-magnify"
                    label="Поиск"
                    single-line
                    hide-details
                    clearable
                  ></v-text-field>
                </v-col>
              </v-row>

              <v-data-table
                :headers="headers"
                :items="category"
                :search="search"
                :items-per-page="3"
                :footer-props="{
                  itemsPerPageText: 'Количество строк',
                  'items-per-page-options': [3, 5, 20, 40, 50],
                  pageText: '{0} из {1}-{2}'
                }"
                class="elevation-1"
              >


            <template v-slot:top>
              <v-row justify="center">
                <v-dialog v-model="dialog" max-width="600px">
                  <v-card>
                    <v-card-title>
                      <span class="headline">Вид категория</span>
                    </v-card-title>
                    <v-card-text>
                       <v-simple-table>
                        <template v-slot:default>
                          <thead>
                            <tr>
                              <th class="text-left">Название</th>
                              <th class="text-left">Описание</th>
                              <th class="text-left">Родительский категория</th>
                              <th class="text-left">Статус</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>{{ viewId.text }}</td>
                              <td>{{ viewId.description }}</td>
                              <td>
                                <v-select
                                  v-model="viewId.category"
                                  :items="category"
                                  item-value="id"
                                  item-text="text"
                                  dense
                                  disabled
                                  hide-selected
                                  placeholder="нет"
                                  attach
                                  chips
                                >
                                </v-select>
                              </td>
                               <td v-if="viewId.status === 1">
                                <v-responsive
                                      class="text-center white--text green rounded-pill d-inline-flex align-center justify-center"
                                      height="25"
                                      width="90"
                                    >Активный</v-responsive>
                              </td>
                              <td v-else>
                                <v-responsive
                                    class="text-center white--text red rounded-pill d-inline-flex align-center justify-center"
                                    height="25"
                                    width="105"
                                  >Не активный</v-responsive>
                              </td>
                            </tr>
                          </tbody>
                        </template>
                      </v-simple-table>
                    </v-card-text>
                    <v-card-actions>
                      <v-spacer></v-spacer>
                      <v-btn color="black darken-1" text @click="dialog = false">Закрыть</v-btn>
                    </v-card-actions>
                  </v-card>
                </v-dialog>
              </v-row>
              <v-row justify="center">
                <v-dialog v-model="dialogEdit" max-width="600px">
                  <v-card>
                    <v-card-title class="mb-5">
                      <span class="headline">Редактировать категорий</span>
                    </v-card-title>
                    <v-card-text>
                       <v-form
                          ref="update"
                          v-model="update"
                          lazy-validation
                        >
                        <v-select
                            v-model="editItem.category"
                            :items="category"
                            item-value="id"
                            :menu-props="{ bottom: true, offsetY: true }"
                            label="Категория"
                            outlined
                            clearable
                            dense
                          >
                          </v-select>

                          <v-text-field
                            v-model="editItem.text"
                            :counter="50"
                            :rules="titleRules"
                            label="Название"
                            required
                            outlined
                            clearable
                            dense
                          ></v-text-field>

                          <v-text-field
                            v-model="editItem.description"
                            :rules="descriptionRules"
                            label="Описание"
                            :counter="200"
                            required
                            outlined
                            clearable
                            dense
                          ></v-text-field>

                          <v-switch
                            v-model="editItem.status"
                            inset
                            label="Статус ?"
                          ></v-switch>

                        </v-form>
                    </v-card-text>
                     <v-card-actions>
                        <v-spacer></v-spacer>

                        <v-btn
                          :disabled="!update"
                          color="success"
                          class="mr-4"
                          @click="editForm"
                        >
                          Обнавить
                        </v-btn>

                        <v-btn
                          color="error"
                          class="mr-4"
                          @click="resetUpdate"
                        >
                          Очистить
                        </v-btn>
                        <v-btn
                          color="indigo"
                          class="mr-4"
                          @click="dialogEdit = false"
                          outlined
                        >
                          Закрыть
                        </v-btn>
                      </v-card-actions>

                  </v-card>
                </v-dialog>
              </v-row>
            </template>

            <template v-slot:item.status="{ item }">
              <v-chip :color="getColor(item.status)" @click="edit(item)" dark>
                <span v-if="item.status != 0">Активный</span>
                <span v-else>Не активный</span>
              </v-chip>
            </template>

             <template v-slot:item.actions="{ item }">
              <v-icon
                small
                class="mr-2 green--text"
                @click="view(item)"
              >
                mdi-eye
              </v-icon>
              <v-icon
                small
                @click="deleteCategory(item)"
                class="red--text"
              >
                mdi-delete
              </v-icon>
            </template>
            <template v-slot:no-data>
              <span class="red--text">Категория пусто !</span>
            </template>
            </v-data-table>
            </v-col>
          </v-row>
        </v-card>
    </v-col>
  </v-row>
</template>

<script>

import categoryService from "@/services/category.service";

export default {
  name: 'category',
	data() {
	  return {
      dialog: false,
      dialogEdit: false,
      isUpdating: false,
      search: '',
      viewId: {},
      headers: [
        { text: 'Название', value: 'text' },
        { text: 'Статус', value: 'status' },
        { text: '', value: 'actions', sortable: false },
      ],
      category: [],
      categoryId: '',
      editItem: {},
      valid: true,
      update: true,
      title: '',
      titleRules: [
        v => !!v || 'Название обязательно !',
      ],
      description: '',
      descriptionRules: [
        v => !!v || 'Описание обязательно !',
      ],
      status: false,

      color: 'indigo darken-4',
      snackbar: false,
      timeout: 3000,
      x: 'right',
      y: 'top',
      text: {},
	  }
  },
  watch: {
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
      getColor (status) {
        if (status !== 1){
          return 'red'
        }
        else{
          return 'green'
        }
      },
     async edit (id) {
         const {status, data} = await categoryService.getId(id);
          if (status === 200) {
            this.editItem = data;
          }
         this.dialogEdit = true
      },
     async view (id) {
         const {status, data} = await categoryService.getId(id);
          if (status === 200) {
            this.viewId = data;
          }
         this.dialog = true
      },
      async deleteCategory (item) {
         if(confirm('Вы уверены, что хотите удалить этот элемент ?')){
            const index = await categoryService.delete(item.id)
            this.isUpdating = true
            this.initialize()
            this.snackbar = true
            this.text = 'Данный было удалено !'
          }
      },
      async initialize () {
        const {status, data} = await categoryService.get();
        if (status === 200) {
          this.isUpdating = true
          this.category = data;
        }
      },
      async submitForm () {
        if(this.$refs.form.validate()){

          const categoryForm = {
            title: this.title,
            description: this.description,
            category_id: this.categoryId ? this.categoryId : 0,
            status: this.status ? 1 : 0
          }
          const {status, data} = await categoryService.create(categoryForm)
          if (status === 201) {
            this.isUpdating = true
            this.category.unshift(data);
            this.reset()
            this.snackbar = true
            this.text = 'Данный было добавлено !'
          }

        }
      },
      async editForm () {
        if(this.$refs.update.validate()){
          const categoryUpdateForm = {
            id: this.editItem.id,
            title: this.editItem.text,
            description: this.editItem.description,
            category_id: this.editItem.category ? this.editItem.category : 0,
            status: this.editItem.status ? 1 : 0
          }
          const {status, data} = await categoryService.update(categoryUpdateForm)
          if (status === 200) {
            this.dialogEdit = false
            this.initialize()
            this.isUpdating = true
            this.resetUpdate()
            this.snackbar = true
            this.text = 'Данный было обнавлено !'
          }
        }
      },
      reset () {
        this.$refs.form.reset()
      },
      resetUpdate () {
        this.$refs.update.reset()
      },
	},
}
</script>

<style>

</style>
