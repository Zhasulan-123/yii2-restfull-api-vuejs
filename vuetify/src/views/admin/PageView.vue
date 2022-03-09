<template>
  <v-row>
    <v-col cols="12">
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

    <v-simple-table>
      <template v-slot:default>
        <tbody>
          <tr>
            <td>Название</td>
            <td>{{ desserts.title }}</td>
          </tr>
          <tr>
            <td>Текст</td>
            <td>{{ desserts.text }}</td>
          </tr>
          <tr>
            <td>Описание</td>
            <td>{{ desserts.description }}</td>
          </tr>
          <tr>
            <td>Статус</td>
            <td v-if="desserts.status === 1">
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

    </v-col>
  </v-row>
</template>

<script>

import pageService from "@/services/page.service";

export default {
   name: 'page-view',
   props: ['id'],
   data: () => ({
      items: [
        {
          text: 'Страница',
          disabled: false,
          href: '/admin/page',
        },
        {
          text: 'Вид',
          disabled: true,
          href: '/admin/page-view/',
        },
      ],
       desserts: [],
    }),
    created () {
      this.initialize()
    },
    methods: {
      async initialize () {
        const {status, data} = await pageService.getId(this.id);
        if (status === 200) {
          this.desserts = data;
        }
      },
    },
}
</script>

<style>

</style>
