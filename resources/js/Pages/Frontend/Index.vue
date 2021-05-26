<template>
  <div>
    <h1 class="mb-8 mx-3 font-bold text-3xl">Portfolio</h1>
    <v-card flat tile>
      <v-container v-for="t in types" :key="t" fluid>
        <v-row>
          <v-spacer />
          <v-col v-for="item in items.data" :key="item.id" cols="12" sm="6" md="4">
            <v-card>
              <v-img :src="item.bigImgUrl" height="300px">
                <span class="headline white--text pl-4 pt-4 d-inline-block" v-text=""></span>
              </v-img>

              <!-- <v-card-actions class="white justify-center">
                <v-btn v-for="(social, i) in socials" :key="i" :color="social.color" class="white--text" fab icon small>
                  <v-icon>{{ social.icon }}</v-icon>
                </v-btn>
              </v-card-actions> -->

              <v-card-text>
                <!-- <span class="mx-2 subheading"></span> -->

                <v-chip-group class="mx-2">
                  <v-chip disabled v-for="tag in item.tags" :key="tag.id" :value="tag.name" class="v-chip-group-elem">
                    {{ tag.name }}
                  </v-chip>
                </v-chip-group>
                <v-btn style="font-weight:700" block class="font-bold ma-2 white--text" color="success">
                  View
                </v-btn>
              </v-card-text>
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
  props: {
    items: Object,
  },

  data: () => ({
    selection: '08',
    types: ['Places to Be', 'Places to See'],
    cards: ['Good', 'Best', 'Finest'],
    tags: ['Work', 'Home Improvement', 'Vacation'],
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
    console.log(this.items)
  },
  methods: {
    none() {},
    getImage() {
      const min = 550
      const max = 560

      return Math.floor(Math.random() * (max - min + 1)) + min
    },
  },
}
</script>
<style>
.font-bold.v-btn {
  font-weight: 700;
}
.v-chip-group-elem.v-chip.v-chip--clickable.v-chip--disabled.v-chip--no-color.theme--light.v-size--default {
  background: rgb(224, 224, 224);
  color: rgba(0, 0, 0, 0.87);

  opacity: 1;
}
</style>
