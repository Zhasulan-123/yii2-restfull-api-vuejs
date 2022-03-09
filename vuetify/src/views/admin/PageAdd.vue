<template>
  <v-card
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
    <v-app-bar
      dense
      color="accent"
    >
      <v-toolbar-title>Добавление страница</v-toolbar-title>
      <v-spacer></v-spacer>
    </v-app-bar>
    <v-form
      ref="form"
      v-model="valid"
      lazy-validation
    >
      <v-container>
        <v-row>
          <v-col
            cols="12"
            md="4"
          >
            <v-text-field
              v-model="title"
              :disabled="isUpdating"
              filled
              color="blue-grey lighten-2"
              label="Название"
              clearable
              :counter="100"
              :rules="titleRules"
              required
            ></v-text-field>
          </v-col>

          <v-col
            cols="12"
            md="4"
          >
            <v-text-field
              v-model="description"
              :disabled="isUpdating"
              filled
              color="blue-grey lighten-2"
              label="Описание"
              clearable
              :counter="100"
              :rules="descriptionRules"
              required
            ></v-text-field>
          </v-col>

          <v-col
            cols="12"
            md="4"
          >
            <v-select
              v-model="categoryId.id"
              :items="categories"
              filled
              label="Категория"
              :menu-props="{ bottom: true, offsetY: true }"
              item-value="id"
              clearable
            ></v-select>
          </v-col>


        </v-row>
        <v-row>
          <v-col cols="12" md="12">
            <v-textarea
              name="input-7-1"
              v-model="text"
              filled
              label="Текст"
              auto-grow
              clearable
              :counter="1000"
              :rules="textRules"
              required
            ></v-textarea>
          </v-col>
        </v-row>
         <v-row>
          <v-col cols="12" md="2">
            <v-checkbox
              v-model="status"
              label="Активный ?"
            ></v-checkbox>
          </v-col>
        </v-row>
      </v-container>
    </v-form>
    <v-divider></v-divider>
    <v-card-actions>
      <v-spacer></v-spacer>
      <v-btn
        color="error"
        class="mr-4"
        @click="reset"
      >
        Очистить
      </v-btn>
      <v-btn
        :loading="isUpdating"
        color="primary"
        depressed
        @click="save"
      >
        <v-icon left>mdi-plus</v-icon>
        Добавить
      </v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>

import pageService from "@/services/page.service";
import categoryService from "@/services/category.service";

  export default {
    data () {
      return {
        valid: true,
        autoUpdate: true,
        friends: ['Sandra Adams', 'Britta Holt'],
        isUpdating: false,
        title: '',
        titleRules: [
          v => !!v || 'Название обязательно',
        ],
        description: '',
        descriptionRules: [
          v => !!v || 'Описание обязательно',
        ],
        text: '',
        textRules: [
          v => !!v || 'Текст обязательно',
        ],
        status: false,
        categories: [],
        categoryId: {},
      }
    },
    watch: {
      isUpdating (val) {
        if (val) {
          setTimeout(() => (this.isUpdating = false), 3000)
        }
      },
    },
    created () {
      this.initialize()
    },
    methods: {
      async initialize () {
        const {status, data} = await categoryService.get();
        if (status === 200) {
          this.categories = data;
        }
      },
      async save () {
        if(this.$refs.form.validate()){
           this.isUpdating = true
           const pageAdd = {
             title: this.title,
             description: this.description,
             text: this.text,
             status: this.status === true ? 1 : 0,
             newcategory: this.categoryId,
           }
          const {status, data} = await pageService.create(pageAdd)
          if (status === 201) {
            this.$router.push({name: 'page'});
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
