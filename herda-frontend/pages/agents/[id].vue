<template>
  <div class="p-6">
    <div v-if="error" class="text-red-500">Error loading agent.</div>
    <div v-else-if="pending" class="text-gray-500">Loading...</div>
    <div v-else>
      <h2 class="text-2xl font-bold mb-1">{{ agent.name }}</h2>
      <p class="text-gray-600">{{ agent.position }}</p>
      <p class="text-sm text-gray-500">{{ agent.email }} | {{ agent.contact_number }}</p>

      <h3 class="text-xl font-semibold mt-6 mb-2">Properties by {{ agent.name }}</h3>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <div v-for="property in agent.properties" :key="property.id" class="border rounded p-4 shadow">
          <h4 class="text-lg font-bold">{{ property.name }}</h4>
          <p class="text-gray-600">₱{{ property.price.toLocaleString() }}</p>
          <NuxtLink :to="`/properties/${property.id}`" class="text-blue-500 underline">View</NuxtLink>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
const route = useRoute()
const { data: agent, pending, error } = await useAsyncData(`agent-${route.params.id}`, () =>
  $fetch(`${useRuntimeConfig().public.apiBase}/agents/${route.params.id}`)
)
</script>