<!-- components/PropertyMap.vue -->
<template>
  <div ref="mapContainer" class="h-64 w-full rounded map-container" />
</template>

<script setup>
import mapboxgl from 'mapbox-gl'
import { onMounted, ref } from 'vue'

const mapContainer = ref(null)
const props = defineProps({
  lat: Number,
  lng: Number,
})

onMounted(() => {
  if (typeof window !== 'undefined') {
    mapboxgl.accessToken = useRuntimeConfig().public.mapboxToken
    const map = new mapboxgl.Map({
      container: mapContainer.value,
      style: 'mapbox://styles/mapbox/streets-v11',
      center: [props.lng, props.lat],
      zoom: 15,
    })

    new mapboxgl.Marker().setLngLat([props.lng, props.lat]).addTo(map)
  }
})
</script>

<style scoped>
.mapboxgl-canvas {
  border-radius: 1rem;
}

.map-container {
    position: relative;
    overflow: hidden;
}
</style>
