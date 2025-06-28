<!-- PriceRangeSlider.vue -->
<template>
  <div>
    <label class="block text-sm font-semibold mb-1">Price Range (₱)</label>

    <div class="flex justify-between text-sm text-gray-600 mb-2">
      <span>₱{{ priceMin.toLocaleString() }}</span>
      <span>₱{{ priceMax.toLocaleString() }}</span>
    </div>

    <div class="relative h-6">
      <!-- Slider Track -->
      <div class="absolute top-1/2 transform -translate-y-1/2 w-full h-1 bg-gray-300 rounded"></div>

      <!-- Active Range Highlight -->
      <div
        class="absolute top-1/2 transform -translate-y-1/2 h-1 bg-blue-500 rounded"
        :style="{
          left: `${(priceMin / maxPrice) * 100}%`,
          right: `${100 - (priceMax / maxPrice) * 100}%`,
        }"
      ></div>

      <!-- Min Thumb -->
      <input
        type="range"
        min="0"
        :max="maxPrice"
        step="100000"
        v-model="priceMin"
        class="absolute w-full h-1 bg-transparent pointer-events-auto appearance-none z-10"
      />

      <!-- Max Thumb -->
      <input
        type="range"
        min="0"
        :max="maxPrice"
        step="100000"
        v-model="priceMax"
        class="absolute w-full h-1 bg-transparent pointer-events-auto appearance-none z-10"
      />
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  modelValue: Object,
})
const emit = defineEmits(['update:modelValue'])

const maxPrice = 20000000
const priceMin = ref(props.modelValue.priceMin ?? 0)
const priceMax = ref(props.modelValue.priceMax ?? maxPrice)

watch([priceMin, priceMax], () => {
  if (priceMin.value > priceMax.value) priceMin.value = priceMax.value
  emit('update:modelValue', { priceMin: priceMin.value, priceMax: priceMax.value })
})
</script>

<style scoped>
input[type='range'] {
  -webkit-appearance: none;
  appearance: none;
  background: transparent;
}
input[type='range']::-webkit-slider-thumb {
  -webkit-appearance: none;
  height: 16px;
  width: 16px;
  background: #3b82f6;
  border-radius: 50%;
  cursor: pointer;
}
</style>
