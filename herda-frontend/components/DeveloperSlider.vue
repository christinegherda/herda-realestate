<template>
  <div class="py-12 ">
    <div class="container mx-auto"> 
      testing
      <pre>
        {{ developers }}
      </pre>
      <swiper
        effect="fade" 
        :slides-per-view="6"
        :space-between="10"
        :breakpoints="{
          768: { slidesPerView: 3 },
          1024: { slidesPerView: 6 }
        }"
        :loop="true"
        :autoplay="{ delay: 100 }"
        :pagination="true"
        class="w-full"
      >
        <swiper-slide v-for="developer in developers" :key="developer.id" class="flex justify-center items-center">
          <div class="bg-white p-2 w-full max-w-[200px] h-[100px] flex justify-center items-center">
            <img
              v-if="developer.logo"
              :src="`${config.public.images}/${developer.logo}`"
              :alt="developer.name"
              class="max-h-16 object-contain"
            />
          </div>
        </swiper-slide>
      </swiper>
    </div>
  </div>
</template>

<script setup>
import { Swiper, SwiperSlide } from 'swiper/vue'
import 'swiper/css'
import { useRuntimeConfig } from '#imports' 
// import { Autoplay, EffectFade } from 'swiper/modules' 
// Import required styles
import 'swiper/css'
import 'swiper/css/effect-fade'
import 'swiper/css/autoplay'

const config = useRuntimeConfig();

const { data: developers } = await useAsyncData('developers', () =>
  $fetch(`${useRuntimeConfig().public.apiBase}/developers`)
)

console.log(developers);
console.log(`${config.public.apiBase}/developers`);
</script>
