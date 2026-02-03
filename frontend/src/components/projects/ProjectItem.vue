<template>
  <div
    class="flex items-start justify-between p-5 bg-white rounded-xl border hover:shadow-sm transition"
  >
    <div class="flex gap-4">
      <!-- Icon -->
      <div class="text-gray-400 mt-1">
        📄
      </div>

      <!-- Content -->
      <div>
        <h3 class="font-semibold text-gray-900">
          {{ project.title }}
        </h3>

        <div class="flex flex-wrap items-center gap-4 mt-2 text-sm text-gray-500">
          <span
            class="px-2 py-0.5 rounded-full text-xs font-medium"
            :class="statusClass"
          >
            {{ project.status }}
          </span>

          <span class="flex items-center gap-1">
            📅 {{ project.due }}
          </span>
        </div>

        <div class="mt-2 text-sm text-gray-500">
          👤 {{ project.authors.join(", ") }}
        </div>

        <div class="mt-2 text-xs text-gray-400">
          {{ project.updated }}
        </div>
      </div>
    </div>

    <!-- Menu -->
    <button class="text-gray-400 hover:text-gray-600">
      ⋮
    </button>
  </div>
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
  project: Object,
});

const statusClass = computed(() => {
  switch (props.project.status) {
    case "In Progress":
      return "bg-blue-100 text-blue-700";
    case "Review":
      return "bg-yellow-100 text-yellow-700";
    case "Completed":
      return "bg-green-100 text-green-700";
    default:
      return "bg-gray-100 text-gray-600";
  }
});
</script>
