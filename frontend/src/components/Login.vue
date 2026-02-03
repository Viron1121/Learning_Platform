<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-sm">
      <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>
      <form @submit.prevent="loginUser" class="space-y-4">
        <input
          type="email"
          v-model="email"
          placeholder="Email"
          required
          class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
        <input
          type="password"
          v-model="password"
          placeholder="Password"
          required
          class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
         <p class="mt-6 text-sm text-center text-gray-500">
            Don't have an account?
        <router-link
          to="/register"
          class="text-blue-600 hover:underline font-medium"
        >
          Register
        </router-link>
      </p>
        <button
          type="submit"
          class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-md transition-colors"
        >
          Login
        </button>
      </form>
      <p v-if="error" class="mt-4 text-red-500 text-center">{{ error }}</p>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { useRouter } from "vue-router";
import { useAuthStore } from "../store/auth";
import { ref } from "vue";

export default {
  setup() {
    const router = useRouter();
    const auth = useAuthStore();
    const email = ref("");
    const password = ref("");
    const error = ref("");

    const loginUser = async () => {
      error.value = "";
      try {
        const res = await axios.post(
          "http://127.0.0.1:8000/api/login",
          { email: email.value, password: password.value },
          { headers: { Accept: "application/json" } }
        );

        auth.setToken(res.data.token);
        auth.setUser(res.data.user);
        router.push("/dashboard");
      } catch (err) {
        error.value = err.response?.data?.message || "Login failed";
      }
    };

    return { email, password, error, loginUser };
  },
};
</script>
