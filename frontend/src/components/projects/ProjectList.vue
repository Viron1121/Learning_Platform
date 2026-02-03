<template>
  <section class="bg-gray-50 rounded-xl p-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
      <h2 class="text-xl font-bold">
        Research Projects
      </h2>

      <button
        @click="$router.push({ name: 'AddProject' })"
        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium"
      >
        New Project
      </button>
    </div>

    <!-- List -->
    <div class="space-y-4">
      <ProjectItem
        v-for="project in projects"
        :key="project.id"
        :project="project"
      />
    </div>

    <!-- Loading / Empty State -->
    <div v-if="loading" class="text-gray-400 mt-4">Loading projects...</div>
    <div v-else-if="projects.length === 0" class="text-gray-400 mt-4">
      No projects found.
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted } from "vue";
import ProjectItem from "./ProjectItem.vue";
import api from "../../api";

const projects = ref([]);
const loading = ref(true);

onMounted(async () => {
  try {
     const res = await api.get("/projects"); // token automatically included
    projects.value = res.data.map((p) => ({
      id: p.id,
      title: p.name,
      status: p.status || "In Progress",
      due: p.due_date || "TBD",
      authors: [p.creator?.name || "Unknown"], // if you have a creator relationship
      updated: new Date(p.updated_at).toLocaleDateString(),
    }));
  } catch (error) {
    console.error("Error fetching projects:", error);
  } finally {
    loading.value = false;
  }
});
</script>
