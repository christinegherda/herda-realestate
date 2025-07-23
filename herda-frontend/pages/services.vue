<template>
<section class="py-16 bg-gray-50" id="#services">
  <div class="max-w-7xl mx-auto px-4 text-center">
    <h2 class="text-3xl font-bold text-gray-800 mb-4">Our Services</h2>
    <p class="text-gray-600 mb-12">We offer a wide range of professional real estate services to meet your needs.</p>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
      
      <!-- Service Block -->
      <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition-all">
        <div class="text-yellow-500 mb-4">
          <!-- Replace with actual icon -->
          <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M3 10l9-7 9 7v10a2 2 0 01-2 2h-4a2 2 0 01-2-2v-4H9v4a2 2 0 01-2 2H3a2 2 0 01-2-2V10z"/>
          </svg>
        </div>
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Sell</h3>
        <p class="text-gray-600">We help you sell your property at the best market value with full support and promotion.</p>
      </div>

      <!-- Leasing -->
      <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition-all">
        <div class="text-yellow-500 mb-4">
          <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M9 21V9h6v12m3-16h.01M4 4h.01"/>
          </svg>
        </div>
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Leasing</h3>
        <p class="text-gray-600">We assist property owners and tenants in finding rental solutions that suit their needs.</p>
      </div>

      <!-- Real Estate Appraisal -->
      <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition-all">
        <div class="text-yellow-500 mb-4">
          <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M3 3h18v4H3zm0 6h18v12H3z"/>
          </svg>
        </div>
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Real Estate Appraisal</h3>
        <p class="text-gray-600">Professional property valuation services for selling, insurance, or loan purposes.</p>
      </div>

      <!-- Loan Mortgage Assistance -->
      <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition-all">
        <div class="text-yellow-500 mb-4">
          <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M12 8v4l3 3m6-7a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
        </div>
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Loan Mortgage Assistance</h3>
        <p class="text-gray-600">Guidance and help with processing your home loan applications with top banks and agencies.</p>
      </div>

      <!-- Titling and Documentation -->
      <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition-all">
        <div class="text-yellow-500 mb-4">
          <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M12 20h9M3 20h9m-9-6h18M3 8h18M3 4h18"/>
          </svg>
        </div>
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Titling & Documentation</h3>
        <p class="text-gray-600">We handle the legal documentation and titling process to ensure a smooth transaction.</p>
      </div>


      <!-- Property Management -->
      <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition-all">
        <div class="text-yellow-500 mb-4">
          <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M12 20h9M3 20h9m-9-6h18M3 8h18M3 4h18"/>
          </svg>
        </div>
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Property Management</h3>
        <p class="text-gray-600">We help manage and maintain your property—from finding tenants to overseeing maintenance—so you can earn income worry-free.

</p>
      </div>

    </div>
  </div>
</section>

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
