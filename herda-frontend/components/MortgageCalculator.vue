<template>
  <div class="bg-white p-4 shadow space-y-4 mt-6">
    <h2 class="text-lg font-bold text-blue-950">Mortgage Calculator</h2>

    <!-- Loan Amount -->
    <div>
      <label class="block text-sm font-semibold mb-1">Loan Amount (₱)</label>
      <input
        v-model.number="mortgage.loanAmount"
        type="number"
        class="w-full border rounded px-3 py-2 text-sm"
        placeholder="e.g. 2000000"
      />
    </div>

    <!-- Interest Rate -->
    <div>
      <label class="block text-sm font-semibold mb-1">Annual Interest Rate (%)</label>
      <input
        v-model.number="mortgage.interestRate"
        type="number"
        class="w-full border rounded px-3 py-2 text-sm"
        placeholder="e.g. 6.5"
      />
    </div>

    <!-- Loan Term -->
    <div>
      <label class="block text-sm font-semibold mb-1">Loan Term (Years)</label>
      <input
        v-model.number="mortgage.loanTerm"
        type="number"
        class="w-full border rounded px-3 py-2 text-sm"
        placeholder="e.g. 20"
      />
    </div>

    <div class="pt-2 border-t text-center">
      <p class="text-sm font-medium">Monthly Payment</p>
      <p class="text-xl font-bold text-green-600">
        ₱{{ monthlyPayment.toLocaleString(undefined, { minimumFractionDigits: 2 }) }}
      </p>
    </div>
  </div>
</template>

<script setup>
const mortgage = reactive({
  loanAmount: 2000000,
  interestRate: 6.5,
  loanTerm: 20,
})

const monthlyPayment = computed(() => {
  const P = mortgage.loanAmount || 0
  const r = (mortgage.interestRate || 0) / 100 / 12
  const n = (mortgage.loanTerm || 0) * 12

  if (!P || !r || !n) return 0

  const numerator = P * r * Math.pow(1 + r, n)
  const denominator = Math.pow(1 + r, n) - 1

  return denominator === 0 ? 0 : numerator / denominator
})
</script>
