import Axios from './CallerService';
import { useUserStore } from '@/stores/User';

export async function login(credentials: { email: string, password: string }) {
  console.log('GET CSRF cookie');
  await Axios.get('/sanctum/csrf-cookie'); // 🔹 vérifie Network: doit renvoyer 200 et Set-Cookie

  console.log('POST authenticate');
  const res = await Axios.post('/authenticate', credentials, {
    headers: { 'Content-Type': 'application/json' }
  });

  const userStore = useUserStore();
  userStore.setUser({
    email: res.data.user.email,
    role: res.data.user.role
  });
}

export async function fetchUser() {
  const userStore = useUserStore();

  try {
    const res = await Axios.get('/api/users/me', { withCredentials: true });
    userStore.setUser({
      email: res.data.email,
      role: res.data.role
    });
  } catch {
    userStore.clearUser();
  }
}

export async function logout() {
    await Axios.get('/logout');

      const userStore = useUserStore();
      userStore.clearUser();

    const cookies = document.cookie.split(";");
    for (let i = 0; i < cookies.length; i++) {
        const cookie = cookies[i];
        const eqPos = cookie.indexOf('=');
        const name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
        document.cookie = name + '=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/';
    }
}

export async function register(payload:any) {
    await Axios.get('/sanctum/csrf-cookie', {
        baseURL: 'https://windigoprint-backend.fohu7030.odns.fr'
    });
    
    return await Axios.post('/api/register', payload)
}

export function isLogged(): boolean {
    const userStore = useUserStore();
    return userStore.isLogged;
}