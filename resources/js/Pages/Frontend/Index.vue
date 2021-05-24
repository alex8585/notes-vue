<template>
  <div>
    <h1 class="mb-8 mx-3 font-bold text-3xl">Portfolio</h1>
    <v-card flat tile>
      <v-container v-for="t in types" :key="t" fluid>
        <v-row>
          <v-spacer />
          <v-col v-for="card in cards" :key="card" cols="12" sm="6" md="4">
            <v-card>
              <v-img :src="`https://picsum.photos/200/300?image=${getImage()}`" height="300px">
                <span class="headline white--text pl-4 pt-4 d-inline-block" v-text=""></span>
              </v-img>

              <v-card-actions class="white justify-center">
                <v-btn v-for="(social, i) in socials" :key="i" :color="social.color" class="white--text" fab icon small>
                  <v-icon>{{ social.icon }}</v-icon>
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-col>
        </v-row>
      </v-container>
    </v-card>
  </div>
</template>

<script>
import Layout from '@/Shared/Layout2'

export default {
  metaInfo: { title: 'Main page' },
  components: {},
  layout: Layout,
  props: {},

  data: () => ({
    types: ['Places to Be', 'Places to See'],
    cards: ['Good', 'Best', 'Finest'],
    socials: [
      {
        icon: 'mdi-facebook',
        color: 'indigo',
      },
      {
        icon: 'mdi-linkedin',
        color: 'cyan darken-1',
      },
      {
        icon: 'mdi-instagram',
        color: 'red lighten-3',
      },
    ],
  }),

  mounted: function() {
    //console.log(this.contacts.data)
  },
  methods: {
    getImage() {
      const min = 550
      const max = 560

      return Math.floor(Math.random() * (max - min + 1)) + min
    },
  },
}
</script>
