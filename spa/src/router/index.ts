import { createRouter, createWebHistory } from 'vue-router'
import Login from '../views/Login.vue'
import HomeView from '../views/HomeView.vue'
import Register from '@/views/Register.vue';
import Atelier from '@/components/Atelier.vue';
import Boutique from '@/components/Boutique.vue';
import DashboardAdmin from '@/views/admin/DashboardAdmin.vue';
import { useUserStore } from '@/stores/User';
import Panier from '@/components/Panier.vue';
import { fetchUser } from '@/_services/AuthService';
import AtelierDetailView from '@/components/AtelierDetailView.vue';
import ProduitDetailView from '@/components/ProduitDetailView.vue';
import GestionSession from '@/components/admin/GestionSession.vue';
import APropos from '@/components/APropos.vue';
import PortFolio from '@/components/PortFolio.vue';


const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/boutique',
      name: 'boutique',
      component: Boutique
    },

    {
      path: '/produits/:id',
      name: 'produit-detail',
      component: ProduitDetailView,
      props: true
    },

    {
      path: '/login',
      name: 'login',
      component: Login
    },

    {
      path: '/panier',
      name: 'panier',
      component: Panier
    },

    {
      path: '/ateliers',
      name: 'ateliers',
      component: Atelier
    },

    {
      path: '/ateliers/:id',
      name: 'atelier-detail',
      component: AtelierDetailView,
      props: true
    },

    {
      path: '/apropos',
      name: 'APropos',
      component: APropos
    },

    {
      path :'/portfolio',
      name : 'Portfolio',
      component: PortFolio
    },
    
    {
      path: "/admin/workshops/:id/sessions",
      name: "admin.workshop.sessions",
      component: GestionSession,
      props: true
    },

    {
      path: '/register',
      name: 'register',
      component: Register
    },

    {
      path: '/:pathMatch(.*)*',
      redirect: '/'
    },

    {
      path: '/admin',
      name: 'admin.dashboard',
      component: DashboardAdmin,
      meta: { role: 'ROLE_ADMIN' }
    }

  ]
});
router.beforeEach(async (to, from, next) => {
  const userStore = useUserStore();

  // Si fetchUser n'a pas été appelé, tu peux le forcer ici
  if (!userStore.user.email) {
    await fetchUser();
  }

  const role = userStore.user.role;

  if (!to.meta.role) {
    return next();
  }

  if (role === to.meta.role) {
    return next();
  }

  // Sinon redirige vers login
  return next('/login');
});

export default router
