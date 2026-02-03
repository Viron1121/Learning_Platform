<template>
  <DashboardLayout>
    <h1 class="text-2xl font-bold mb-6">
      Welcome back, {{ user?.name }}
    </h1>

   
    <!-- Your cards & content go here -->
  </DashboardLayout>

</template>

<script setup>
import DashboardLayout from "@/components/layout/DashboardLayout.vue";
import { useAuthStore } from "@/store/auth";
import { computed } from "vue";

const auth = useAuthStore();
const user = computed(() => auth.user);
</script>
