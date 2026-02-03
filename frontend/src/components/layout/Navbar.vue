<template>
  <header class="h-16 bg-white border-b flex items-center px-6 justify-between">
    <div class="flex items-center gap-3">
      <div class="w-9 h-9 rounded-lg bg-blue-600 text-white flex items-center justify-center font-bold">
        VL 
      </div>
      <h1 class="font-semibold text-lg">Viron Laboratory</h1>
    </div>

    <div class="flex items-center gap-6">
      <input
        type="text"
        placeholder="Search courses, projects..."
        class="hidden md:block px-4 py-2 border rounded-md text-sm"
      />
      <UserDropdown />
    </div>
  </header>
</template>

<script setup>
import UserDropdown from "./UserDropdown.vue";
</script>
