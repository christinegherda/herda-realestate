<template>
  <div class="container mx-auto py-8">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
      <!-- Sidebar Filters -->
      <aside class="md:col-span-1 sticky top-20 self-start">
        <div class="bg-white p-4 shadow space-y-4">
          <h2 class="text-lg font-bold text-blue-950">Filter Properties</h2>

          <!-- Location Filter -->
          <div>
            <label class="block text-sm font-semibold mb-1">Location</label>
            <!-- <input
              v-model="filters.location"
              type="text"
              placeholder="Enter location"
              class="w-full border rounded px-3 py-2 text-sm"
            /> -->
            <LocationSearch v-model="filters.city" />
          </div>

          <!-- Price Filter -->
           <!-- <PriceRangeSlider v-model="filters" :min="0" :max="20000000" /> -->

          <div>
            <label class="block text-sm font-semibold mb-1">Price (₱)</label>
            <div class="flex space-x-2">
              <input
                v-model.number="filters.priceMin"
                type="number"
                placeholder="Min"
                class="w-1/2 border rounded px-2 py-1 text-sm"
              />
              <input
                v-model.number="filters.priceMax"
                type="number"
                placeholder="Max"
                class="w-1/2 border rounded px-2 py-1 text-sm"
              />
            </div>
          </div>

          <!-- For Sale / Rent -->
          <div>
            <label class="block text-sm font-semibold mb-1">Listing Type</label>
            <select v-model="filters.status" class="w-full border rounded px-2 py-1 text-sm">
              <option value="">All</option>
              <option value="For Sale">For Sale</option>
              <option value="For Rent">For Rent</option>
            </select>
          </div>

          <!-- Property Type -->
          <div>
            <label class="block text-sm font-semibold mb-1">Property Type</label>
            <select v-model="filters.propertyType" class="w-full border rounded px-2 py-1 text-sm">
              <option value="">All</option>
              <option value="Residential">Residential</option>
              <option value="Commercial">Commercial</option>
            </select>
          </div>

          <!-- Model Type -->
          <div>
            <label class="block text-sm font-semibold mb-1">Model Type</label>
            <select v-model="filters.modelType" class="w-full border rounded px-2 py-1 text-sm">
              <option value="">All</option>
              <option value="Single Attached">Single Attached</option>
              <option value="Single Detached">Single Detached</option>
              <option value="Townhouse">Townhouse</option>
              <option value="Rowhouse">Rowhouse</option>
            </select>
          </div>

          <!-- Filter Button -->
          <button
            @click="fetchProperties"
            class="bg-blue-950 text-white w-full py-2 rounded font-semibold hover:bg-blue-800"
          >
            Apply Filters
          </button>
        </div>
            <MortgageCalculator />
      </aside>

      <!-- Property Results -->
      <section class="md:col-span-3">
        <div class="flex justify-between items-center mb-4">
          <h5 class="text-md font-semibold text-blue-950">
            Showing {{ filteredProperties.length }} {{ filteredProperties.length === 1 ? 'property' : 'properties' }}
          </h5>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <NuxtLink
            v-for="property in filteredProperties"
            :key="property.id"
            class="bg-white overflow-hidden shadow hover:shadow-lg transition"
            :to="`/properties/${property.id}`"
          >
            <div class="property-img-wrapper"> 
                <div class="last-update" v-if="property.status"> 
                  <div class="col-span-2">
                    <span
                      class="inline-block px-2 py-1 text-xs rounded-full text-gray-700 bg-gray-100"  
                    >
                    Listed on:
                    {{
                      new Date(property.updated_at).toLocaleDateString('en-PH', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric',
                      })
                    }} 
                    </span>
                  </div>
                </div>
                <div class="status" v-if="property.status"> 
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
                <img
                  :src="`${config.public.images}/${property.thumbnail}`"
                  alt=""
                  class="w-full h-48 object-cover"
                />
            </div>
            <div class="p-4 space-y-1">
              <h3 class="font-semibold text-lg">{{ property.name }}</h3>
              <p class="text-sm text-gray-500">{{ property.location }}</p>
              <p class="text-blue-950 font-bold">
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
                <div v-if="property.property_type">
                  <strong>🏡 {{ property.property_type }}</strong>
                </div>
              </div> 
            </div>
          </NuxtLink>
        </div>
      </section>
    </div>
  </div>
</template>

<script setup>
import { ref, useRuntimeConfig, reactive, watch, computed, useRoute, useRouter, useAsyncData } from '#imports'
import LocationSearch from '~/components/LocationSearch.vue'
import MortgageCalculator from '~/components/MortgageCalculator.vue'
import PriceRangeSlider from '~/components/PriceRangeSlider.vue'

const config = useRuntimeConfig()
const route = useRoute()
const router = useRouter()

const filters = reactive({
  city: '', 
  priceMin: 0,
  priceMax: 20000000,
  status: '',
  propertyType: '',
  modelType: '',
})

// Update filters from query params on route change
watch(
  () => route.query,
  (query) => {
    filters.city = query.city || ''
    filters.priceMin = query.priceMin ? Number(query.priceMin) : null
    filters.priceMax = query.priceMax ? Number(query.priceMax) : null
    filters.status = query.status || ''
    filters.propertyType = query.propertyType || ''
    filters.modelType = query.modelType || ''
  },
  { immediate: true }
)

// 👇 Create a dynamic key based on filters
const fetchKey = computed(() =>
  `properties-${filters.city}-${filters.priceMin}-${filters.priceMax}-${filters.status}-${filters.propertyType}-${filters.modelType}`
)

// 👇 Fetch with reactive key
const { data: allProperties, error } = await useAsyncData(fetchKey, () =>
  $fetch(`${config.public.apiBase}/properties`, {
    params: {
      city: filters.city,
      priceMin: filters.priceMin,
      priceMax: filters.priceMax,
      status: filters.status,
      propertyType: filters.propertyType,
      modelType: filters.modelType,
    },
  })
)

if (error.value) {
  console.error('Error fetching properties:', error.value)
}

// Directly bind fetched data
const filteredProperties = computed(() => allProperties.value || [])

// On Apply Filters button click
function fetchProperties() {
  router.push({
    path: '/properties',
    query: {
      city: filters.city,
      priceMin: filters.priceMin,
      priceMax: filters.priceMax,
      status: filters.status,
      propertyType: filters.propertyType,
      modelType: filters.modelType,
    },
  })
}
</script>


<style>
.property-img-wrapper {
    position: relative;
} 
.status {
    position: absolute;
    top: 5px;
    left: 10px;
}
.last-update {
    position: absolute;
    right: 10px;
    top: 5px;
}
</style>