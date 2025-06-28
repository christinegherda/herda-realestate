<template>
  <div class="p-6">
    <h2 class="text-2xl font-semibold mb-4">All Properties</h2>
    <div v-if="error" class="text-red-500">Error loading properties.</div>
    <div v-else-if="pending" class="text-gray-500">Loading...</div>
    <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
      <div v-for="property in properties" :key="property.id" class="border rounded p-4 shadow">
        <h3 class="text-xl font-bold">{{ property.name }}</h3>
        <p class="text-gray-600">₱{{ property.price.toLocaleString() }}</p>
        <NuxtLink :to="`/properties/${property.id}`" class="text-blue-500 underline mt-2 inline-block">View Details</NuxtLink>
      </div>
    </div>
  </div>
</template>

<script setup>
// const { data: properties, pending, error } = await useAsyncData('properties', () =>
//   $fetch('http://localhost:8000/api/properties')
// )

const config = useRuntimeConfig()
const { data: properties, pending, error } = await useAsyncData('properties', () =>
  $fetch(`${config.public.apiBase}/properties`)
)
</script>
