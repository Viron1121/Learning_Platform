<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8">
      <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">
        Create an Account
      </h2>

      <form @submit.prevent="registerUser" class="space-y-4">
        <div>
          <label class="block text-sm font-medium text-gray-600 mb-1">
            Name
          </label>
          <input
            type="text"
            v-model="name"
            placeholder="John Doe"
            required
            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-600 mb-1">
            Email
          </label>
          <input
            type="email"
            v-model="email"
            placeholder="email@example.com"
            required
            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-600 mb-1">
            Password
          </label>
          <input
            type="password"
            v-model="password"
            placeholder="••••••••"
            required
            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
        </div>

        <button
          type="submit"
          class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700 transition"
        >
          Register
        </button>
      </form>

      <p
        v-if="error"
        class="mt-4 text-sm text-center text-red-500"
      >
        {{ error }}
      </p>

      <p class="mt-6 text-sm text-center text-gray-500">
        Already have an account?
        <router-link
          to="/"
          class="text-blue-600 hover:underline font-medium"
        >
          Login
        </router-link>
      </p>
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
    const name = ref("");
    const email = ref("");
    const password = ref("");
    const error = ref("");

    const registerUser = async () => {
      error.value = "";
      try {
        const res = await axios.post(
          "http://127.0.0.1:8000/api/register",
          {
            name: name.value,
            email: email.value,
            password: password.value,
          },
          { headers: { Accept: "application/json" } }
        );

        auth.setToken(res.data.token);
        auth.setUser(res.data.user);
        router.push("/dashboard");
      } catch (err) {
        error.value =
          err.response?.data?.message ||
          "Registration failed. Please try again.";
      }
    };

    return { name, email, password, error, registerUser };
  },
};
</script>
