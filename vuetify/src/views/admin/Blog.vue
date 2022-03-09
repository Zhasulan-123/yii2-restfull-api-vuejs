<template>
  <v-row>
    <v-col cols="12" md="12">
      <v-card>
        <v-card-text>
          <div>
            <v-btn
              x-small
              color="purple darken-4"
              dark
              to="/admin/blog-list"
            >Списки блок </v-btn>
          </div>
        </v-card-text>

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
                    v-model="title"
                    :counter="10"
                    :rules="titleRules"
                    label="Название блока"
                    required
                    clearable
                  ></v-text-field>

                 </v-col>
                 <v-col cols="12" md="12">
                  <v-text-field
                    v-model="description"
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
                    v-model="text"
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
                  v-model="model"
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
                    v-model="status"
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
                @click="submitForm"
                :loading="isUpdating"
              >
                Готова
              </v-btn>

              <v-btn text @click="e1 = 2">Назад</v-btn>
            </v-stepper-content>
          </v-stepper-items>
          </v-form>
        </v-stepper>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>

import tagsService from "@/services/tags.service";
import blogsService from "@/services/blogs.service";

export default {
   name: 'blog',
   data () {
      return {
        e1: 1,
        valid: true,
        isUpdating: false,
        title: '',
        titleRules: [
          v => !!v || 'Название блока обязательно !',
        ],
        description: '',
        descriptionRules: [
          v => !!v || 'Описание блока обязательно !',
        ],
        text: '',
        textRules: [
          v => !!v || 'Текст обязательно !',
        ],
        status: false,
        tag: [],
        tagRules: [
          v => !!v || 'Теги обязательно !',
        ],
        model: '',
        search: null,
      }
   },
   watch: {
      model (val) {
        if (val.length > 5) {
          this.$nextTick(() => this.model.pop())
        }
      },
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
        const {status, data} = await tagsService.get();
        if (status === 200) {
          this.tag = data;
        }
      },
      async submitForm () {
        if(this.$refs.form.validate()){

          const blogForm = {
            title: this.title,
            description: this.description,
            text: this.text,
            status: this.status ? 1 : 0,
            newtags: this.model
          }

          const {status, data} = await blogsService.create(blogForm)
          if (status === 201) {
            this.isUpdating = true
            this.reset()
            this.initialize()
            // this.snackbar = true
            // this.text = 'Данный было добавлено !'
            this.$router.push('/admin/blog-list')
          }

        }
      },
      reset () {
        this.$refs.form.reset()
      },
  },
}
</script>

<style scope>
.v-sheet.v-card:not(.v-sheet--outlined){
  box-shadow: none !important;
}
</style>
