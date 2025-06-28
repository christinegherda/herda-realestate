<template>
  <div> 
    <!-- Hero -->
    <section class="relative h-[80vh]">
      <Swiper
        effect="fade"
        :modules="[Autoplay, EffectFade]"
        :autoplay="{ delay: 4000 }"
        :loop="true"
        :slides-per-view="1"
        class="h-full"
      >
        <SwiperSlide v-for="(slide, i) in slides" :key="i" class="relative h-full">
          <img
            :src="slide.image"
            class="absolute inset-0 object-cover w-full h-full"
          />
          <div
            class="absolute inset-0 bg-black/40 flex items-center justify-center text-center px-4 z-10"
          >
            <div class="text-white">
              <h1 class="text-4xl md:text-5xl font-bold mb-4">{{ slide.heading }}</h1>
              <p class="text-lg mb-8">{{ slide.sub }}</p>
            </div>
          </div>
        </SwiperSlide>
      </Swiper>
      <div class="absolute inset-0 flex items-center justify-center text-white   z-10">
        <form @submit.prevent="search" >
          <div class="search-wrapper bg-white p-3 mt-50 flex flex-col md:flex-row gap-4 justify-center">
            <select class="p-3 rounded-md text-black w-full md:w-auto" v-model="filters.status">
              <option>For Sale</option>
              <option>For Rent</option>
            </select> 
            <LocationSearch v-model="filters.location"/>


            <button
              type="submit"
              class="bg-[#e3b001] hover:bg-yellow-400 text-black font-bold py-3 px-6 rounded-md"
            >
              Search
            </button>
          </div> 
        </form>
        
      </div>
    </section> 
 
    <!-- Featured Properties --> 
    <section class="py-12 ">
      <div class="container mx-auto">
        <h2 class="text-2xl font-bold mb-6">Featured Properties</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
          <NuxtLink
            v-for="property in featuredProperties"
            :key="property.id"
            :to="`/properties/${property.id}`"
            class=" bg-white overflow-hidden shadow hover:shadow-lg transition block"
          >
            <img
              :src="`${config.public.images}/${property.thumbnail}`"
              alt=""
              class="w-full h-48 object-cover"
            />
            <div class="p-4">
              <h3 class="font-semibold text-lg mb-1">{{ property.name }}</h3>
              <p class="text-sm text-gray-500 mb-2">{{ property.location }}</p>

              <p class="text-blue-950 font-bold text-lg mb-3">
                ₱{{ Number(property.price).toLocaleString() }}
              </p>

              <!-- Property Details -->
              <div class="grid grid-cols-2 gap-2 text-sm text-gray-600">
                <div v-if="property.floor_area">
                  <strong>Floor:</strong> {{ property.floor_area }} m²
                </div>
                <div v-if="property.lot_area">
                  <strong>Lot:</strong> {{ property.lot_area }} m²
                </div>
                <div v-if="property.bedrooms">
                  🛏️ {{ property.bedrooms }} Bedroom<span v-if="property.bedrooms > 1">s</span>
                </div>
                <div v-if="property.bathrooms">
                  🛁 {{ property.bathrooms }} Bathroom<span v-if="property.bathrooms > 1">s</span>
                </div>
                <div class="col-span-2">
                  <span
                    class="inline-block px-2 py-1 text-xs rounded-full"
                    :class="{
                      'bg-green-100 text-green-700': property.status === 'For Sale',
                      'bg-yellow-100 text-yellow-700': property.status === 'For Rent',
                      'bg-gray-200 text-gray-700': property.status === 'Sold'
                    }"
                  >
                    {{ property.status }}
                  </span>
                </div>
              </div>
            </div>
          </NuxtLink>
        </div>
      </div>
    </section>

    <!-- Accredited Developers -->
    <section class="py-12 bg-white">
      <div class="container mx-auto">
        <h2 class="text-2xl font-bold mb-6">Accredited Developers</h2>
        <DeveloperSlider /> 
      </div>
    </section> 

    <!-- Locations  -->
    <!-- <section class="py-12 ">
      <div class="container mx-auto">
        <h2 class="text-2xl font-bold mb-6">Locations</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 items-center">
          <img v-for="dev in developers" :key="dev.id" :src="dev.logo" :alt="dev.name" class="h-12 mx-auto">
        </div>
      </div>
    </section> -->

    <!-- News Section -->
    <!-- <section class="py-12 bg-white">
      <div class="container mx-auto">
        <h2 class="text-2xl font-bold mb-6">Latest News</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="bg-white p-4 shadow rounded" v-for="news in latestNews" :key="news.id">
            <h3 class="font-semibold text-lg">{{ news.title }}</h3>
            <p class="text-sm text-gray-600">{{ news.excerpt }}</p>
          </div>
        </div>
      </div>
    </section> -->

    <!-- Testimonials Section -->
    <!-- <section class="py-12 ">
      <div class="container mx-auto">
        <h2 class="text-2xl font-bold mb-6">Testimonials</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="p-6 border rounded shadow" v-for="testimonial in testimonials" :key="testimonial.id">
            <p class="italic">"{{ testimonial.message }}"</p>
            <p class="mt-2 font-bold">- {{ testimonial.author }}</p>
          </div>
        </div>
      </div>
    </section> -->

  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useRuntimeConfig } from '#imports'
import { useAsyncData } from '#app'
import LocationSearch from '~/components/LocationSearch.vue' 
import DeveloperSlider from '~/components/DeveloperSlider.vue' 

import { Swiper, SwiperSlide } from 'swiper/vue'
import { Autoplay, EffectFade } from 'swiper/modules' 
// Import required styles
import 'swiper/css'
import 'swiper/css/effect-fade'
import 'swiper/css/autoplay'

const slides = [
  {
    image: '/images/hero1.jpg',
    heading: 'Find Your Dream Home',
    sub: 'Explore properties for sale or rent in Cebu’s best locations.',
  },
  {
    image: '/images/hero2.jpg',
    heading: 'Invest in Your Future',
    sub: 'We help you secure the perfect property at the right time.',
  },
  {
    image: '/images/hero3.jpg',
    heading: 'Quality Homes You Deserve',
    sub: 'Trusted by hundreds of satisfied homeowners and investors.',
  },
]

const searchForm = ref({
  listingType: 'Buy',
  location: ''
})

const config = useRuntimeConfig() 

const { data: featuredProperties } = await useAsyncData('featured-properties', () =>
  $fetch(`${useRuntimeConfig().public.apiBase}/properties?featured=true`)
)

const { data: latestNews } = await useAsyncData('latest-news', () =>
  $fetch('http://localhost:8000/api/news')
)

const { data: testimonials } = await useAsyncData('testimonials', () =>
  $fetch('http://localhost:8000/api/testimonials')
)

const { data: developers } = await useAsyncData('developers', () =>
  $fetch('http://localhost:8000/api/developers')
)

function searchProperties() {
  // you can later push to /properties with query params
  alert(`Search: ${searchForm.value.purpose}, ${searchForm.value.location}`)
}


const router = useRouter()
const filters = ref({
  status: 'For Sale',
  location: '',
})

function search() {
  router.push({
    path: '/properties',
    query: {
      status: filters.value.status,
      city: filters.value.location,
    },
  })
}
</script>

<style scoped>
section {
  scroll-margin-top: 100px;
}

.section-banner {
  height: 600px;
  position: relative;
}

.filter-wrapper {
  background-color: black;
  position: absolute;
  bottom: 0;
  border-radius: 0;
}
</style>
