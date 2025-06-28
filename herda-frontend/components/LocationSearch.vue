<template>
  <div class="relative">
    <input
      type="text"
      v-model="input"
      @input="searchAddress"
      placeholder="Search location..."
      class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-blue-500 text-black"
    />
    <ul v-if="suggestions.length && input" class="absolute z-10 bg-white w-full border mt-1 rounded-lg shadow">
      <li
        v-for="(item, index) in suggestions"
        :key="index"
        @click="selectSuggestion(item)"
        class="p-2 cursor-pointer hover:bg-gray-100 text-gray-600"
      >
        {{ item.place_name }}
      </li>
    </ul>
  </div>
</template>

<script setup>
import { ref, useRuntimeConfig } from '#imports' 

const suggestions = ref([])
const config = useRuntimeConfig()

const searchAddress = async () => {
  if (input.value.length < 3) return

  try {
    const { data } = await useFetch(
      `https://api.mapbox.com/geocoding/v5/mapbox.places/${encodeURIComponent(input.value)}.json`,
      {
        params: {
          access_token: config.public.mapboxToken,
          autocomplete: true,
          limit: 5
        }
      }
    )
    suggestions.value = data.value?.features || []
  } catch (err) {
    console.error('Mapbox error:', err)
  }
}


const selectSuggestion = (place) => {
  input.value = place.place_name
  suggestions.value = []
  // optional: emit event with coordinates
  // emit('selected', place)
}


const props = defineProps({
  modelValue: String,
})

const emit = defineEmits(['update:modelValue'])

const input = ref(props.modelValue || '') 
watch(input, (value) => {
  emit('update:modelValue', value)
})
</script>
