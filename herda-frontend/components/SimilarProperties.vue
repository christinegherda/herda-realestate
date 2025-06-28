<template>
  <div v-if="similar && similar.length" class="mt-8">
    <h2 class="text-xl font-semibold mb-4 text-blue-700">Similar Properties</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
      <div
        v-for="property in similar"
        :key="property.id"
        class="border rounded-lg overflow-hidden shadow hover:shadow-md transition"
      >
        <NuxtLink :to="`/properties/${property.slug}`">
          <img
            :src="property.cover_image_url"
            alt="Property Image"
            class="h-48 w-full object-cover"
          />
          <div class="p-4 space-y-1">
            <h3 class="text-lg font-bold">{{ property.name }}</h3>
            <p class="text-sm text-gray-600">{{ property.city }}</p>
            <p class="text-blue-700 font-semibold">₱{{ property.price.toLocaleString() }}</p>
          </div>
        </NuxtLink>
      </div>
    </div>
  </div>
</template>


<script setup>
const props = defineProps({
  city: String,
  excludeId: Number,
})

const config = useRuntimeConfig()

const { data: similar } = await useAsyncData(() =>
  $fetch(`${config.public.apiBase}/properties/similar`, {
    params: {
      city: props.city,
      exclude: props.excludeId,
    },
  })
)
</script>
