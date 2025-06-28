<!-- components/ContactAgentForm.vue -->
<template>
  <form @submit.prevent="submitForm" class="space-y-4 bg-white p-4 rounded shadow">
    <input v-model="name" type="text" placeholder="Your Name" class="form-input w-full" required />
    <input v-model="email" type="email" placeholder="Your Email" class="form-input w-full" required />
    <textarea v-model="message" placeholder="Your Message" class="form-textarea w-full" required></textarea>
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-800">Send</button>
  </form>
</template>

<script setup>
import { ref } from 'vue'

const name = ref('')
const email = ref('')
const message = ref('')

const submitForm = async () => {
  try {
    await $fetch('/api/contact-agent', {
      method: 'POST',
      body: { name: name.value, email: email.value, message: message.value },
    })
    alert('Message sent!')
    name.value = ''
    email.value = ''
    message.value = ''
  } catch (e) {
    alert('Failed to send.')
  }
}
</script>
