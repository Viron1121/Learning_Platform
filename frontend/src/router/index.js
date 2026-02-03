import { createRouter, createWebHistory } from "vue-router";
import Login from "../components/Login.vue";
import Register from "../components/Register.vue";
import LandingPage from "../views/LandingPage.vue";
import AddProject from "../components/projects/AddProject.vue";
import { useAuthStore } from "../store/auth";

const routes = [
  { path: "/", name: "Login", component: Login },
  { path: "/register", name: "Register", component: Register },
  {
    path: "/dashboard",
    name: "Dashboard",
    component: LandingPage,
    meta: { requiresAuth: true },
  },
  {
    path: '/projects/new',
    name: 'AddProject',
    component: AddProject,
    meta: { requiresAuth: true },
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

// Navigation guard to protect routes
router.beforeEach((to, from, next) => {
  const auth = useAuthStore();
  if (to.meta.requiresAuth && !auth.token) {
    next({ name: "Login" });
  } else {
    next();
  }
});

export default router;
