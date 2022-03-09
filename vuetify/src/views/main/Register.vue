<template>
 <div>
    <v-row class="justify-center">
      <v-col cols="6">
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
    max-width="600"
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
  <v-list-item-title class="headline mb-1 text-center">Регистрация</v-list-item-title>
    <v-form
        ref="form"
        v-model="valid"
        lazy-validation
      >
      <v-container>
      <v-row>
        <v-col
          cols="12"
          md="6"
        >
        <v-text-field
          v-model="username"
          :rules="usernameRules"
          :counter="5"
          label="Имя"
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
      </v-col>
      <v-col
          cols="12"
          md="6"
        >
        <v-text-field
          v-model="fullname"
          :rules="fullnameRules"
          :counter="5"
          label="Фамилия"
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
      </v-col>
      </v-row>

      <v-row>
        <v-col
          cols="12"
          md="6"
        >
        <v-text-field
          v-model="email"
          :rules="emailRules"
          :counter="2"
          label="E-mail"
          required
          clearable
          append-icon="mdi-email"
        >
         <template>
          <v-tooltip bottom>
            <template v-slot:activator="{ on }">
              <v-icon v-on="on">mdi-help-circle-outline</v-icon>
            </template>
          </v-tooltip>
        </template>
        </v-text-field>
      </v-col>
      <v-col
          cols="12"
          md="6"
        >
        <v-text-field
          v-model="phone"
          :rules="phoneRules"
          :counter="12"
          label="Телефон"
          required
          clearable
          append-icon="mdi-phone"
        >
        <div>+7</div>
         <template>
          <v-tooltip bottom>
            <template v-slot:activator="{ on }">
              <v-icon v-on="on">mdi-help-circle-outline</v-icon>
            </template>
          </v-tooltip>
        </template>
        </v-text-field>
      </v-col>
      </v-row>

      <v-row>
        <v-col
          cols="12"
          md="6"
        >
        <v-text-field
          v-model="password"
          :rules="passwordRules"
          :counter="6"
          label="Пороль"
          required
          clearable
          :append-icon="show ? 'mdi-eye' : 'mdi-eye-off'"
          :type="show ? 'text' : 'password'"
          @click:append="show = !show"
        >
         <template>
          <v-tooltip bottom>
            <template v-slot:activator="{ on }">
              <v-icon v-on="on">mdi-help-circle-outline</v-icon>
            </template>
          </v-tooltip>
        </template>
        </v-text-field>
      </v-col>
      <v-col
          cols="12"
          md="6"
        >
        <v-text-field
          v-model="password_confirm"
          :rules="passwordConfirmRules"
          :counter="6"
          label="Повтарите пороль"
          required
          clearable
          :append-icon="show2 ? 'mdi-eye' : 'mdi-eye-off'"
          :type="show2 ? 'text' : 'password'"
          @click:append="show2 = !show2"
        >
         <template>
          <v-tooltip bottom>
            <template v-slot:activator="{ on }">
              <v-icon v-on="on">mdi-help-circle-outline</v-icon>
            </template>
          </v-tooltip>
        </template>
        </v-text-field>
      </v-col>
      </v-row>

      <v-checkbox
        v-model="checkbox"
        :rules="[v => !!v || 'Вы должны согласиться, чтобы продолжить !']"
        label="Вы согласены с провилами ?"
        required
      ></v-checkbox>

      <v-btn :disabled="!valid" :loading="isUpdating" depressed class="mr-4" color="primary" @click="onSubmit">Создать</v-btn>
      <v-btn @click="clear" color="red" class="text_clear_white">Очистить</v-btn>
      </v-container>
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
      show: false,
      show2: false,
      alert: true,
      isUpdating: false,
      errors: null,
      username: '',
      usernameRules: [
        v => !!v || 'Имя является обязательным полем',
      ],
      fullname: '',
      fullnameRules: [
        v => !!v || 'Фамилия является обязательным полем',
      ],
      phone: '',
      phoneRules: [
        v => !!v || 'Телефон обязательно',
        v => (v && v.length <= 12) || 'Телефон должно быть +77010000000 не больше 12 символов',
        v => (v && v.length >= 11) || 'Телефон должно быть +77010000000 не меньше 11 символов',
      ],
      email: '',
      emailRules: [
        v => !!v || 'E-mail является обязательным полем',
        v => /.+@.+\..+/.test(v) || 'E-mail должен быть действителен',
      ],
      password: '',
      passwordRules: [
        v => !!v || 'Пороль является обязательным полем',
        v => (v && v.length >= 6) || 'Пороль должно быть не меньше 6 символов',
      ],
      password_confirm: '',
      passwordConfirmRules: [
        v => !!v || 'Повторить пороль является обязательным полем',
        v => (v && v.length >= 6) || 'Повторить пороль, должно быть не меньше 6 символов',
      ],
      checkbox: false,
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
          const users = {
            username: this.username,
            fullname: this.fullname,
            phone: this.phone,
            email: this.email,
            password: this.password,
            password_repeat: this.password_confirm
          }

          const {success, errors} = await authService.register(users);
          if (success) {
            this.$router.push({name: 'admin'});
          } else {
            this.errors = errors;
          }

        }
      },
      clear () {
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
