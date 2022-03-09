<template>
 <div>
   <v-row class="justify-center">
      <v-col cols="4">
        <v-alert
            type="error"
            v-model="alert"
            border="left"
            close-text="Close Alert"
            dark
            dismissible
            v-if="errors"
          >
          <span v-for="(error, index) in errors" :key="index">
           {{error[0]}}<br>
          </span>
          </v-alert>
      </v-col>
    </v-row>
  <v-card
    class="mx-auto"
    max-width="400"
    outlined
    :loading="isUpdating"
  >

  <template v-slot:progress>
    <v-progress-linear
      absolute
      color="red"
      height="5"
      indeterminate
    ></v-progress-linear>
  </template>


  <v-list-item three-line>
    <v-list-item-content>
  <v-list-item-title class="headline mb-1 text-center">Авторизация</v-list-item-title>
    <v-form
        ref="form"
        v-model="valid"
        lazy-validation
      >
      <v-text-field
        v-model="email"
        append-icon="mdi-email"
        label="E-mail"
        color="success"
        :rules="emailRules"
        :counter="2"
        required
        clearable
      >
        <template>
          <v-tooltip bottom>
            <template v-slot:activator="{ on }">
              <v-icon v-on="on">mdi-help-circle-outline</v-icon>
            </template>
          </v-tooltip>
        </template>
      </v-text-field>
      <v-text-field
        v-model="password"
        :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
        :type="show1 ? 'text' : 'password'"
        @click:append="show1 = !show1"
        label="Пороль"
        color="success"
        :rules="passwordRules"
        :counter="6"
        required
        clearable
      >
        <template>
          <v-tooltip bottom>
            <template v-slot:activator="{ on }">
              <v-icon v-on="on">mdi-help-circle-outline</v-icon>
            </template>
          </v-tooltip>
        </template>
      </v-text-field>
      <v-btn :disabled="!valid" :loading="isUpdating" depressed class="mr-4 mt-10" color="primary" @click="onSubmit">Воити</v-btn>
      <v-btn @click="reset" color="red" class="text_clear_white mt-10">Очистить</v-btn>
    </v-form>
    </v-list-item-content>
    </v-list-item>
  </v-card>
  </div>
</template>

<script>

import authService from "../../services/auth.service";

  export default {
    data: () => ({
      valid: false,
      show1: false,
      alert: true,
      isUpdating: false,
      errors: null,
      email: '',
      emailRules: [
        v => !!v || 'Электронная почта обязательна !',
        v => /.+@.+\..+/.test(v) || 'Электронная почта должна быть действительной !',
      ],
      password: '',
      passwordRules: [
        v => !!v || 'Пороль обязательно',
        v => (v && v.length >= 6) || 'Пороль должно быть болше 6 символов.',
      ],
    }),
    watch: {
      isUpdating (val) {
        if (val) {
          setTimeout(() => (this.isUpdating = false), 6000)
        }
      },
    },
    methods: {
     async onSubmit () {
        if(this.$refs.form.validate()){
          this.isUpdating = true
          const form = {
            email: this.email,
            password: this.password
          }
          const {success, errors} = await authService.login(form);
           if (success) {
              this.$router.push({name: 'admin'});
           } else {
              this.errors = errors;
           }
        }
      },
      reset () {
        this.$refs.form.reset()
      },
    },
  }
</script>

<style scoped>
.text_clear_white{
  color: white;
}
</style>
