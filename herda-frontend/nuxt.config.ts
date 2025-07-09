// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  compatibilityDate: '2025-05-15',
  devtools: { enabled: true },
  // axios: {
  //   baseURL: 'http://localhost:8000/api', // your Laravel API URL
  // },
  modules: ['@nuxt/icon', '@nuxt/image', '@nuxt/ui', '@nuxtjs/tailwindcss'],
  ssr: true,
  runtimeConfig: {
    public: {
      apiBase: 'http://localhost:8000/api',
      images: 'http://localhost:8000/storage',
      mapboxToken: 'pk.eyJ1IjoiY2hyaXN0aW5lZ2hlcmRhIiwiYSI6ImNtYncydnppOTBuYWwya3F3YnhkdWdzMGwifQ.AgxdfT338qilNVzj0tHdUA'
    }
  },
  css: [
    '~/assets/css/main.css', 
    'swiper/css', 
    'swiper/css/effect-fade', 
    'swiper/css/navigation',
    'swiper/css/pagination',
    'mapbox-gl/dist/mapbox-gl.css',
    '@mapbox/mapbox-gl-draw/dist/mapbox-gl-draw.css'
  ],
  vite: {
    build: {
      minify: 'terser',
    },
  },
})