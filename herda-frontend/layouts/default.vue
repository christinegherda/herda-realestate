<template>
  <div>
    <!-- Navbar -->
    <nav class="bg-white  px-6 py-4 flex justify-between items-center">
      <a href="/" class="brand-logo">
        <img src="/images/brand.png" /> 
      </a>
      <div class="space-x-4">
        <NuxtLink to="/" class="text-gray-700 hover:text-blue-950" active-class="font-bold text-blue-700">Home</NuxtLink>
        <NuxtLink to="/properties" class="text-gray-700 hover:text-blue-950" active-class="font-bold text-blue-700">Properties</NuxtLink>
        <NuxtLink to="/map" class="text-gray-700 hover:text-blue-950" active-class="font-bold text-blue-700">Map Search</NuxtLink>
        <NuxtLink to="/agents" class="text-gray-700 hover:text-blue-950" active-class="font-bold text-blue-700">Agents</NuxtLink>
        <NuxtLink to="/agents" class="text-gray-700 hover:text-blue-950" active-class="font-bold text-blue-700">Contact Us</NuxtLink>
        <NuxtLink
          to="/list-property"
          class="bg-blue-950 text-white px-4 py-2 rounded-md hover:bg-blue-800 transition font-semibold shadow"
        >
          LIST MY PROPERTY
        </NuxtLink>
      </div>
    </nav>

    <!-- Page content -->
    <main class="bg-gray-100">
      <slot/>
    </main>

    <!-- Footer --> 
      <footer class="bg-blue-950 text-white py-10">
        <div class="container mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 px-4">
          <!-- Our Office -->
          <div>
            <h4 class="text-lg font-semibold mb-3">Our Office</h4>
            <p>Herda Real Estate Services</p>
            <p>2/F, Cebu Parklane International Hotel</p>
            <p>N. Escario, Camputhaw, Cebu City</p>
            <p>Phone: 09062721161</p>
            <p>Email: herdarnel@gmail.com</p>
          </div>

          <!-- Services -->
          <div>
            <h4 class="text-lg font-semibold mb-3">Our Services</h4>
            <ul class="space-y-1">
              <li><a href="#" class="hover:text-gold">Project Selling</a></li>
              <li><a href="#" class="hover:text-gold">Brokerage</a></li>
              <li><a href="#" class="hover:text-gold">Appraisal</a></li>
              <li><a href="#" class="hover:text-gold">Site Viewing</a></li>
            </ul>
          </div>


          <!-- Social Media -->
          <div>
            <h4 class="text-lg font-semibold mb-3">Follow Us</h4>
            <div class="flex gap-4">
              <a href="#" target="_blank"><Icon name="uil:facebook-f" class="text-xl hover:text-gold" /></a>
              <a href="#" target="_blank"><Icon name="uil:twitter" class="text-xl hover:text-gold" /></a>
              <a href="#" target="_blank"><Icon name="uil:instagram" class="text-xl hover:text-gold" /></a>
              <a href="#" target="_blank"><Icon name="uil:linkedin-alt" class="text-xl hover:text-gold" /></a>
            </div>
          </div>  
        </div>
      </footer> 
 

  </div>
</template>

<style scoped>
a.brand-logo {
    height: 60px;
}

.brand-logo img {
    height: 100%;
}

.py-4 {
  padding-block: calc(var(--spacing) * 4);
}

.hover\:text-gold:hover {
  color: #e3b001;
}
</style>
