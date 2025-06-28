<template>
  <div class="p-6">
    <div v-if="error" class="text-red-500">Error loading property.</div>
    <div v-else-if="pending" class="text-gray-500">Loading...</div>
    <div v-else>
      <h2 class="text-2xl font-bold">{{ property.name }}</h2>
      <p class="text-gray-700">₱{{ property.price.toLocaleString() }}</p>
      <p class="mt-2 text-sm text-gray-500">Agent: {{ property.agent?.name }}</p>
    </div>
  </div>
</template>

<script setup>
const route = useRoute()
const { data: property, pending, error } = await useAsyncData(`property-${route.params.id}`, () =>
  $fetch(`http://localhost:8000/api/properties/${route.params.id}`)
)
</script>