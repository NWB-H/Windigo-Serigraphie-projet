import { ref, computed } from 'vue';
import { defineStore } from 'pinia';

// Typage strict du rôle possible
export type UserRole = 'ROLE_USER' | 'ROLE_ADMIN';

interface ConnectedUser {
  email: string | null;
  role: UserRole | null;
}

export const useUserStore = defineStore('user', () => {
  const user = ref<ConnectedUser>({
    email: localStorage.getItem('email') || null,
    role: (localStorage.getItem('role') as UserRole) || null,
  });

  const isLogged = computed(() => !!user.value.email);
  const isAdmin = computed(() => user.value.role === 'ROLE_ADMIN');

  function setUser(data: ConnectedUser) {
    user.value.email = data.email;
    user.value.role = data.role;
    localStorage.setItem('email', data.email || '');
    localStorage.setItem('role', data.role || '');
  }

  function clearUser() {
    user.value.email = null;
    user.value.role = null;
    localStorage.removeItem('email');
    localStorage.removeItem('role');
  }

  return {
    user,
    isLogged,
    isAdmin,
    setUser,
    clearUser
  };
});
