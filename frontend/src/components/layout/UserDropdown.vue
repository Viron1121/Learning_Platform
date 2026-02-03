<template>
  <div class="relative">
    <button
      @click="open = !open"
      class="flex items-center gap-3 focus:outline-none"
    >
      <div class="text-right hidden sm:block">
        <p class="text-sm font-semibold">{{ user?.name }}</p>
        <p class="text-xs text-gray-500">Professor</p>
      </div>
      <div class="w-10 h-10 rounded-full bg-blue-500 text-white flex items-center justify-center font-semibold">
        {{ initials }}
      </div>
    </button>

    <div
      v-if="open"
      class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg border z-50"
    >
      <button
        @click="logout"
        class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100 text-red-600"
      >
        Logout
      </button>
    </div>
  </div>
</template>

<script setup>
import { computed, ref } from "vue";
import { useAuthStore } from "../../store/auth";
import { useRouter } from "vue-router";
import axios from "axios";

const auth = useAuthStore();
const router = useRouter();
const open = ref(false);

const user = computed(() => auth.user);

const initials = computed(() =>
  user.value?.name
    ?.split(" ")
    .map(n => n[0])
    .join("")
);

const logout = async () => {
  try {
    await axios.post(
      "http://127.0.0.1:8000/api/logout",
      {},
      { headers: { Authorization: `Bearer ${auth.token}` } }
    );
  } finally {
    auth.logout();
    router.push("/");
  }
};
</script>
