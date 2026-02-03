<template>
  <div class="bg-white rounded-xl p-5 shadow-sm border">
    <p class="text-sm text-gray-500 mb-2">
      {{ title }}
    </p>

    <div class="flex items-end justify-between">
      <div>
        <h2 class="text-3xl font-bold">
          {{ value }}
        </h2>

        <p class="text-sm mt-1" :class="deltaColor">
          {{ delta }}
        </p>
      </div>

      <!-- Optional progress ring -->
      <div v-if="progress !== null" class="relative w-12 h-12">
        <svg class="transform -rotate-90" viewBox="0 0 100 100">
          <circle
            cx="50"
            cy="50"
            r="45"
            stroke="#e5e7eb"
            stroke-width="10"
            fill="none"
          />
          <circle
            cx="50"
            cy="50"
            r="45"
            stroke="#3b82f6"
            stroke-width="10"
            fill="none"
            :stroke-dasharray="circumference"
            :stroke-dashoffset="dashOffset"
            stroke-linecap="round"
          />
        </svg>
        <span class="absolute inset-0 flex items-center justify-center text-xs font-semibold">
          {{ progress }}%
        </span>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
  title: String,
  value: [String, Number],
  delta: String,
  progress: {
    type: Number,
    default: null,
  },
});

const circumference = 2 * Math.PI * 45;

const dashOffset = computed(() =>
  circumference - (props.progress / 100) * circumference
);

const deltaColor = computed(() =>
  props.delta?.startsWith("+")
    ? "text-green-600"
    : "text-gray-500"
);
</script>
