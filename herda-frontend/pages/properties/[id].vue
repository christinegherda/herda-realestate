<template>
  <div class="container mx-auto py-10 grid grid-cols-1 md:grid-cols-3 gap-8" v-if="property && agent">
    <!-- Left Sidebar: Agent Info -->

    <!-- Right Panel -->
    <section class="md:col-span-2 space-y-6">
      <div
        class="property-thumbnail"
        :style="{ backgroundImage: `url('${config.public.images}/${property.thumbnail}')` }"
      ></div>
      <div v-if="property.gallery">
        <ImageGallery :images="property.gallery" />
      </div>
      <div>
        <h1 class="text-2xl font-bold">{{ property.name }}</h1>
        <p class="text-gray-600">{{ property.location }}</p>
        <p class="text-2xl text-green-700 font-bold">
          ₱{{ Number(property.price).toLocaleString() }}
        </p>
      </div>

      <!-- Info Grid -->
      <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm bg-white p-4 rounded shadow">
        <div><strong>Model:</strong> {{ property.model_type }}</div>
        <div><strong>Type:</strong> {{ property.property_type }}</div>
        <div><strong>Status:</strong> {{ property.status }}</div>
        <div><strong>Bedrooms:</strong> {{ property.bedrooms }}</div>
        <div><strong>Bathrooms:</strong> {{ property.bathrooms }}</div>
        <div><strong>Lot Area:</strong> {{ property.lot_area }} sqm</div>
        <div><strong>Floor Area:</strong> {{ property.floor_area }} sqm</div>
        <div><strong>City:</strong> {{ property.city }}</div>
        <div><strong>Listing Category:</strong> {{ property.listing_category }}</div>
      </div>

      <!-- Description -->
      <div class="prose max-w-none bg-white p-4 rounded shadow" v-html="property.description" />

      <!-- Gallery -->
      <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
        <img
          v-for="(img, index) in property.images"
          :key="index"
          :src="`${config.public.images}/${img}`"
          class="w-full h-40 object-cover rounded shadow"
        />
      </div>

      <PropertyMap :lat="property.latitude" :lng="property.longitude" />
      
      <SimilarProperties :city="property.city" :exclude-id="property.id" />

    </section>


    <aside class="md:col-span-1 space-y-6">
      <div class="p-4 shadow space-y-4 bg-white top-10 ">
        <h3 class="text-lg font-bold text-blue-950">Agent Details </h3>

        <!-- Agent Profile Picture + Info -->
        <div class="flex items-center space-x-4">
          <img
            :src="agent.photo ? `${config.public.images}/${agent.photo}` : '/default-avatar.png'"
            alt="Agent Photo"
            class="w-16 h-16 rounded-full object-cover border"
          />
          <div> 
            <p class="font-semibold text-base">{{ agent.name }}</p>
            <p class="text-sm text-gray-600">{{ agent.email }}</p>
            <p class="text-sm text-gray-600">{{ agent.contact_number }}</p>
          </div>
        </div>

        <!-- Contact Buttons -->
        <div class="flex gap-2">
          <a
            :href="`mailto:${agent.email}`"
            class="flex items-center gap-1 bg-blue-950 text-white px-3 py-2 rounded hover:bg-blue-800 transition text-sm"
          > 
            Email
          </a>
          <a
            :href="`tel:${agent.phone}`"
            class="flex items-center gap-1 bg-green-600 text-white px-3 py-2 rounded hover:bg-green-950 transition text-sm"
          > 
            Call
          </a>
        </div>
      </div>
      <MortgageCalculator />
    </aside>
  </div>
</template>

<script setup>
import mapboxgl from 'mapbox-gl'
import PropertyMap from '~/components/PropertyMap.vue'
import SimilarProperties from '~/components/SimilarProperties.vue'
import MortgageCalculator from '~/components/MortgageCalculator.vue'
import ImageGallery from '~/components/ImageGallery.vue'

import { onMounted, ref, watch } from 'vue'
import { useRoute, useAsyncData, useRuntimeConfig } from '#imports' 

const config = useRuntimeConfig()
mapboxgl.accessToken = config.public.mapboxToken

const route = useRoute()
const mapContainer = ref(null)

const { data: property } = await useAsyncData('property', () =>
  $fetch(`${config.public.apiBase}/properties/${route.params.id}`)
)

const { data: agent } = await useAsyncData('agent', () => {
  if (!property.value?.agent_id) return null
  return $fetch(`${config.public.apiBase}/agents/${property.value.agent_id}`)
})

onMounted(() => {
  if (!property.value?.lat || !property.value?.lng) return

  const map = new mapboxgl.Map({
    container: mapContainer.value,
    style: 'mapbox://styles/mapbox/streets-v12',
    center: [property.value.lng, property.value.lat],
    zoom: 14
  })

  new mapboxgl.Marker().setLngLat([property.value.lng, property.value.lat]).addTo(map)
})
</script>
<style>
.property-thumbnail {
    height: 600px;
    background-size: contain;
    background-repeat: no-repeat;
}
</style>