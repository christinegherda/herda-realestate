<!-- components/ImageGallery.vue -->
<template>
  <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
    <img
      v-for="(img, index) in images"
      :key="index"
      :src="`${config.public.images}/${img}`"
      @click="show(index)"
      class="rounded cursor-pointer h-32 object-cover w-full"
    />

    <vue-easy-lightbox
      :visible="visible"
      :imgs="images.map(i => `${config.public.images}/${i}`)"
      :index="index"
      @hide="visible = false"
    />
  </div>
</template>

<script setup>
import { ref } from 'vue'
import VueEasyLightbox from 'vue-easy-lightbox'
const config = useRuntimeConfig()

defineProps(['images'])

const visible = ref(false)
const index = ref(0)

const show = (i) => {
  index.value = i
  visible.value = true
}
</script>
