<template>
  <DashboardLayout>
    <h1 class="text-2xl font-bold mb-6">
      Welcome back, {{ user?.name }}
    </h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      <StatCard
        title="Active Courses"
        value="12"
        delta="+2 this month"
      />

      <StatCard
        title="Overall Progress"
        value="68%"
        delta="+12% from last week"
        :progress="68"
      />

      <StatCard
        title="Research Projects"
        value="8"
        delta="3 in progress"
      />

      <StatCard
        title="Certifications"
        value="24"
        delta="2 pending"
      />
    </div>

    <ProjectList :projects="projects" />
  </DashboardLayout>


</template>

<script setup>
import { useAuthStore } from "../store/auth";
import { useRouter } from "vue-router";
import { onMounted, computed } from "vue";
import axios from "axios";
import DashboardLayout from "../components/layout/DashboardLayout.vue";
import StatCard from "../components/ui/StatCard.vue";
import ProjectList from "../components/projects/ProjectList.vue";

const projects = [
  {
    id: 1,
    title: "Machine Learning Applications in Educational Assessment",
    status: "In Progress",
    due: "Due Mar 15, 2026",
    authors: ["Dr. Chen", "Prof. Martinez", "Dr. Kim"],
    updated: "Updated 2 days ago",
  },
  {
    id: 2,
    title: "Cognitive Load Theory in Digital Learning Environments",
    status: "Review",
    due: "Due Feb 28, 2026",
    authors: ["Dr. Chen", "Dr. Watson"],
    updated: "Updated 1 week ago",
  },
  {
    id: 3,
    title: "Comparative Analysis of Pedagogical Frameworks",
    status: "Completed",
    due: "Published",
    authors: ["Dr. Chen", "Prof. Lee", "Dr. Adams", "Dr. Taylor"],
    updated: "Completed Jan 15, 2026",
  },
];

const auth = useAuthStore();
const router = useRouter();

const user = computed(() => auth.user);

const fetchUser = async () => {
  if (!auth.token) {
    router.push("/");
    return;
  }

  try {
    const res = await axios.get("http://127.0.0.1:8000/api/user", {
      headers: {
        Authorization: `Bearer ${auth.token}`,
        Accept: "application/json",
      },
    });
    auth.setUser(res.data);
  } catch {
    auth.logout();
    router.push("/");
  }
};

onMounted(fetchUser);


</script>
