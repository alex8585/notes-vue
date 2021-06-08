<template>
  <div>
    <h1 class="mb-8 mx-3 font-bold text-3xl">Portfolio</h1>
    <v-card flat tile>
      <!-- <v-container v-for="t in types" :key="t" fluid> -->
      <v-row>
        <!-- <v-spacer /> -->
        <v-col v-for="item in items.data" :key="item.id" cols="12" sm="6" md="4">
          <v-card>
            <h2 class="text-center my-3  text-black text-2xl">
              <a class="text-black" :href="item.fullUrl" target="_blank">
                {{ item.title }}
              </a>
            </h2>

            <a :href="item.fullUrl" target="_blank">
              <v-img :src="item.bigImgUrl" height="300px">
                <span class="headline white--text pl-4 pt-4 d-inline-block" v-text=""></span>
              </v-img>
            </a>
            <!-- <v-card-actions class="white justify-center">
                <v-btn v-for="(social, i) in socials" :key="i" :color="social.color" class="white--text" fab icon small>
                  <v-icon>{{ social.icon }}</v-icon>
                </v-btn>
              </v-card-actions> -->

            <v-card-text>
              <!-- <span class="mx-2 subheading"></span> -->

              <v-chip-group class="mx-2">
                <v-chip v-for="tag in item.tags" :key="tag.id" :value="tag.name" disabled class="v-chip-group-elem">
                  {{ tag.name }}
                </v-chip>
              </v-chip-group>
              <v-btn :href="item.fullUrl" target="_blank" style="font-weight:700" block class="font-bold ma-2 white--text" color="success">
                View
              </v-btn>
              <!-- fullUrl -->
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
      <!-- </v-container> -->
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
    types: ['Places to Be', 'Places to See'],
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
.v-application .v-card a {
  color: black;
}
.v-application .form-input.error,
.v-application .form-textarea.error,
.v-application .form-select.error {
  background-color: #ffffff !important;
  border-color: #ffffff !important;
}
</style>
