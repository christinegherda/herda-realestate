<template>
  <div class="p-6">
    <h2 class="text-2xl font-semibold mb-4">Our Agents</h2>
    <div v-if="error" class="text-red-500">Error loading agents.</div>
    <div v-else-if="pending" class="text-gray-500">Loading...</div>
    <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
      <div v-for="agent in agents" :key="agent.id" class="border rounded p-4 shadow">
        <h3 class="text-xl font-bold">{{ agent.name }}</h3>
        <p class="text-gray-600">{{ agent.position }}</p>
        <NuxtLink :to="`/agents/${agent.id}`" class="text-blue-500 underline mt-2 inline-block">View Profile</NuxtLink>
      </div>
    </div>
  </div>
</template>

<script setup>
const { data: agents, pending, error } = await useAsyncData('agents', () =>
  $fetch('http://localhost:8000/api/agents')
)
</script>