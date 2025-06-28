<template>
  <div class="h-screen flex flex-col">
    <!-- Top Filter Bar -->
    <div class="bg-gray shadow p-4 flex flex-wrap items-center gap-4"> 
      <input v-model.number="filters.priceMin" type="number" placeholder="Min Price" class="border px-3 py-1 rounded" />
      <input v-model.number="filters.priceMax" type="number" placeholder="Max Price" class="border px-3 py-1 rounded" />
      <select v-model="filters.status" class="border px-3 py-1 rounded">
        <option value="">Offer Type</option>
        <option value="For Sale">For Sale</option>
        <option value="For Rent">For Rent</option>
      </select>
      <select v-model="filters.propertyType" class="border px-3 py-1 rounded">
        <option value="">Property Types</option>
        <option value="House">House</option>
        <option value="Lot">Lot</option>
        <option value="Condo">Condo</option>
      </select>
      <button @click="applyFilters" class="bg-blue-700 text-white px-4 py-1 rounded">Apply</button>
    </div>

    <!-- Main Content -->
    <div class="flex flex-1 overflow-hidden">
      <!-- Left: Property List -->
      <div class="w-3/12 overflow-y-auto p-4 bg-gray-50"> 
        <div v-for="property in filteredProperties" :key="property.id" class="border rounded-lg p-4 mb-4 bg-white shadow">
          <img :src="`${config.public.images}/${property.thumbnail}`" class="h-40 w-full object-cover rounded" />
          <h3 class="text-lg font-bold mt-2">{{ property.name }}</h3>
          <p class="text-sm text-gray-600">{{ property.location }}</p>
          <p class="text-blue-700 font-semibold">₱{{ Number(property.price).toLocaleString() }}</p>
        </div>
      </div>

      <!-- Right: Mapbox Map -->
      <div id="map" class="w-9/12 h-full"></div>
    </div>
  </div>
</template>

<script setup> 
import { onMounted, ref } from 'vue'
import mapboxgl from 'mapbox-gl'
import MapboxDraw from '@mapbox/mapbox-gl-draw' 
import { useRuntimeConfig, reactive, watch, computed, useRoute, useRouter, useAsyncData } from '#imports'

const config = useRuntimeConfig()

const polygonCoordinates = ref([])
const properties = ref([]) 
let map = null
const markers = ref([])
let drawnPolygon = null // Global variable to track

const filters = ref({ 
  priceMin: null,
  priceMax: null,
  status: '',
  propertyType: '',
  polygon: polygonCoordinates.value
})

const applyFilters = async () => {

  
  const res = await $fetch(`${config.public.apiBase}/properties`, {
    // params: filters.value,
    params: {
      city: filters.city,
      priceMin: filters.priceMin,
      priceMax: filters.priceMax,
      status: filters.status,
      propertyType: filters.propertyType,
      modelType: filters.modelType,
      polygon: filters.polygon ? JSON.stringify(filters.polygon) : undefined,
    } 
  })

  
  allProperties.value = res
  addMarkersToMap()
}


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
 

onMounted(() => { 
  mapboxgl.accessToken = config.public.mapboxToken
  map = new mapboxgl.Map({
    container: 'map',
    style: 'mapbox://styles/mapbox/streets-v11',
    center: [123.8854, 10.3157], // Cebu as default center
    zoom: 10,
  })

  const draw = new MapboxDraw({
    displayControlsDefault: false,
    controls: {
      polygon: true,
      trash: true,
    },
  })

  map.addControl(draw)

  map.on('load', () => { 
    // DOM and window are now available
    addMarkersToMap(filteredProperties.value);
  });

  // map.on('draw.create', updatePolygon)
  map.on('draw.create', (e) => { 
    updatePolygon();
  })

  map.on('draw.update', updatePolygon)
  map.on('draw.delete', () => {
    // Clear or reload default list
    const res = $fetch(`${config.public.apiBase}/properties`, {
      params: {
        city: filters.city,
        priceMin: filters.priceMin,
        priceMax: filters.priceMax,
        status: filters.status,
        propertyType: filters.propertyType,
        modelType: filters.modelType,
      },
    })

    allProperties.value = res;

  })

  function updatePolygon(e) {
    const polygon = draw.getAll().features[0]
    if (!polygon) return
    
    filters.polygon = polygon.geometry.coordinates[0]
    applyFilters() 
    drawPolygon(map, filters.polygon)
  }

  function removePolygon(map) {
    console.log(map.getSource('drawn-polygon'));
    if (map.getSource('drawn-polygon')) {
      map.removeLayer('drawn-polygon')
      map.removeSource('drawn-polygon')
    }
  }


  function drawPolygon(map, coordinates) {
    removePolygon(map) // 👈 Remove existing one first

    map.addSource('drawn-polygon', {
      type: 'geojson',
      data: {
        type: 'Feature',
        geometry: {
          type: 'Polygon',
          coordinates: [coordinates] // array of [lng, lat] points
        }
      }
    })

    map.addLayer({
      id: 'drawn-polygon',
      type: 'fill',
      source: 'drawn-polygon',
      layout: {},
      paint: {
        'fill-color': '#088',
        'fill-opacity': 0.4
      }
    })
  }
  
})

function addMarkersToMap() {
  // Remove old markers
  // document.querySelectorAll('.property-marker').forEach(m => m.remove())
  markers.value.forEach(marker => marker.remove())
  markers.value = []

  

  
  filteredProperties.value.forEach(property => {
    if (!property.latitude || !property.longitude) return

    
    
    const el = document.createElement('div')
    el.className = 'property-marker' 

    // if(property.property_type == "Condo") {
    //   el.style.backgroundImage = 'url(/images/icons/condo.png)' // Your own image 
    // } else if(property.property_type == "Residential") { 
    //   el.style.backgroundImage = 'url(/images/icons/house.png)' // Your own image
    // } else { 
    //   el.style.backgroundImage = 'url(/images/icons/location-pin.png)' // Your own image
    // }
    el.style.backgroundImage = 'url(/images/icons/location-pin.png)' // Your own image

    el.style.width = '25px'
    el.style.height = '25px'
    el.style.backgroundSize = 'cover'
    // el.style.width = '20px'
    // el.style.height = '20px'
    // el.style.borderRadius = '50%'
    // el.style.backgroundColor = '#2563eb' // Tailwind blue-600
    // el.style.border = '2px solid white'
    // el.style.boxShadow = '0 0 4px rgba(0,0,0,0.3)'
    
    const marker = new mapboxgl.Marker(el)
      .setLngLat([property.longitude, property.latitude])
      .setPopup(new mapboxgl.Popup({ offset: 25 }).setHTML(`
        <div class="text-sm">
          <strong>${property.name}</strong><br>
          ₱${Number(property.price).toLocaleString()}<br>
          <em>${property.location}</em>
        </div>
      `))
      .addTo(map)

      markers.value.push(marker)
  })
}

</script>
