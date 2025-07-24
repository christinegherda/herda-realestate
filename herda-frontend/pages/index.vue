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
      <div class="absolute banner-search-form-filter text-white   z-10">
        <form @submit.prevent="search">
          <div class="search-wrapper bg-white p-4 mt-4 flex flex-col md:flex-row gap-4 justify-center items-center">
            
            <!-- Radio Buttons for Status -->
            <div class="flex gap-4">
              <label
                v-for="option in ['For Sale', 'For Rent']"
                :key="option"
                class="flex items-center gap-2 px-4 py-2 border rounded-full cursor-pointer transition-all duration-200"
                :class="{
                  'bg-yellow-400 text-black border-yellow-500': filters.status === option,
                  'bg-white text-gray-700 border-white': filters.status !== option
                }"
              >
                <input
                  type="radio"
                  :value="option"
                  v-model="filters.status"
                  class="hidden"
                />
                {{ option }}
              </label>
            </div>

            <!-- Location Input -->
            <div class="w-full md:w-auto">
              <LocationSearch v-model="filters.location" class="w-full bg-white text-black p-0 rounded-lg" />
            </div>

            <!-- Search Button -->
            <!-- <button
              type="submit"
              class="bg-[#e3b001] hover:bg-yellow-400 text-black font-bold py-3 px-6 rounded-md"
            >
              Search
            </button> -->
          </div>
        </form>
        
      </div>
    </section> 
 
    <!-- Featured Properties --> 
    <section class="py-12 ">
      <div class="container mx-auto"> 
        <h2 class="text-3xl font-bold text-gray-800 mb-4 text-center">Featured Properties</h2>
        <p class="text-gray-600 mb-12 text-center">Discover our top property listings — handpicked for their exceptional value, prime location, and investment potential.</p>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
          <NuxtLink
            v-for="property in featuredProperties"
            :key="property.id"
            :to="`/properties/${property.id}`"
            class=" bg-white overflow-hidden shadow hover:shadow-lg transition block rounded-md"
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
        <h2 class="text-3xl font-bold text-gray-800 mb-4 text-center">Developer Partners</h2>
        <p class="text-gray-600 mb-12 text-center">We proudly collaborate with the most trusted and reputable real estate developers in the country.  </p>
        <!-- <DeveloperSlider />  -->

        <Swiper
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
          <SwiperSlide v-for="developer in developers" :key="developer.id" class="flex justify-center items-center">
            <div class="bg-white p-2 w-full max-w-[200px] h-[100px] flex justify-center items-center">
              <img
                v-if="developer.logo"
                :src="`${config.public.images}/${developer.logo}`"
                :alt="developer.name"
                class="max-h-16 object-contain"
              />
            </div>
          </SwiperSlide>
        </Swiper>

      </div>
    </section> 

    <!-- Our Services  -->
    <section class="py-12 ">
      <div class="container mx-auto"> 
        <h2 class="text-3xl font-bold text-gray-800 mb-4 text-center">Our Services</h2>
        <p class="text-gray-600 mb-12 text-center">We offer a wide range of professional real estate services to meet your needs.</p>


        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
          
          <!-- Sell -->
          <div v-for="service in services" :key="service.title" class="bg-white p-6 rounded-2xl shadow-md hover:shadow-xl transition  text-center">
            <div class="mb-4 text-yellow-500">
              <!-- Home Icon -->
              <Icon :name="service.icon" size="40" class="text-yellow-500 mb-4" />
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ service.title }}</h3>
            <p class="text-gray-600">{{ service.description }}</p>
          </div>
 

        </div>

 
      </div>
    </section>
 

  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useRuntimeConfig } from '#imports'
import { useAsyncData } from '#app'
import LocationSearch from '~/components/LocationSearch.vue' 
import DeveloperSlider from '~/components/DeveloperSlider.vue' 



// import { Swiper, SwiperSlide } from 'swiper/vue'
// import 'swiper/css' 
// // import { Autoplay, EffectFade } from 'swiper/modules' 
// // Import required styles
// import 'swiper/css'
// import 'swiper/css/effect-fade'
// import 'swiper/css/autoplay'
 
 


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

const services = [
  {
    title: 'Sell',
    description: 'We help you market and sell your property at the best value.',
    icon: 'material-symbols:sell'
  },
  {
    title: 'Leasing',
    description: 'We connect landlords and tenants for rentals and long-term leases.',
    icon: 'material-symbols:apartment'
  },
  {
    title: 'Real Estate Appraisal',
    description: 'Get fair property valuation by our licensed appraisers.',
    icon: 'mdi:scale-balance'
  },
  {
    title: 'Loan Mortgage Assistance',
    description: 'We guide you through the home loan process for faster approval.',
    icon: 'mdi:hand-coin-outline'
  },
  {
    title: 'Titling and Documentation',
    description: 'We assist in securing and transferring legal documents.',
    icon: 'mdi:file-document-edit-outline'
  },
  {
    title: 'Property Management',
    description: 'We take care of your property’s maintenance and leasing needs.',
    icon: 'mdi:home-city-outline'
  }
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

// const { data: developers } = await useAsyncData('developers', () =>
//   $fetch('http://localhost:8000/api/developers')
// )

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





 
const developers = ref([])
const  { data: res }  = await await useAsyncData('developers', () =>
  $fetch(`${useRuntimeConfig().public.apiBase}/developers`),
  { lazy: true }
)
console.log('Client fetch:', res)
developers.value = res.value

watchEffect(() => {
  console.log('Fetched developers:', developers.value)
})

console.log(developers.value);
console.log(`${config.public.apiBase}/developers`); 
</script>

<style scoped>
section {
  scroll-margin-top: 100px;
}

.section-banner {
  height: 600px;
  position: relative;
}

/* .filter-wrapper {
  background-color: black;
  position: absolute;
  bottom: 0;
  border-radius: 0;
} */

.banner-search-form-filter {
    /* height: 0; */
    position: absolute;
    top: 50vh;
    left: 0;
    right: 0;
    width: 30%;
    margin: 0 auto;
}

.search-wrapper {
    border-radius: 20px;
    background-color: #162455;
}
</style>
