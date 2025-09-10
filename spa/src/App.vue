<script setup lang="ts">
import { RouterLink, RouterView } from 'vue-router'
import * as AuthService from './_services/AuthService.ts'
import { useUserStore } from '@/stores/User'
import { useCartStore } from '@/stores/Cart'
import { storeToRefs } from 'pinia'
import { onMounted, ref } from 'vue'

const userStore = useUserStore()
const cartStore = useCartStore()

const { user, isLogged } = storeToRefs(userStore)
const footerVisible = ref(false)

function logout() {
  AuthService.logout().then(() => {
    userStore.clearUser()
    window.location.href = '/login'
  })
}

// Pour détecter si le footer est visible
onMounted(() => {
  const observer = new IntersectionObserver(
    ([entry]) => {
      footerVisible.value = entry.isIntersecting
    },
    { threshold: 0.1 }
  )
  const footer = document.querySelector('footer')
  if (footer) observer.observe(footer)
})
</script>

<template>
  <div id="app">
    <!-- HEADER -->
    <header class="sticky-header">
      <div class="header-container">
        <RouterLink to="/home" class="logo">
          <img src="@/assets/LogoWindigo-preview.png" alt="Logo Windigo" />
        </RouterLink>

        <nav class="nav-links">
          <RouterLink to="/boutique">BOUTIQUE</RouterLink>
          <RouterLink to="/ateliers">ATELIERS</RouterLink>
          <RouterLink to="/portfolio">PORTFOLIO</RouterLink>
          <RouterLink to="/apropos">A PROPOS</RouterLink>
        </nav>

        <div class="user-actions">
          <div v-if="isLogged" class="logged-in">
            <span>Bienvenue {{ user.email }}</span>
            <RouterLink v-if="user && user.role === 'ROLE_ADMIN'" to="/admin" class="btn btn-warning">Panel Admin</RouterLink>
            <RouterLink to="/panier">
              <span class="badge bg-secondary">Panier: {{ cartStore.totalQuantity }}</span>
            </RouterLink>
            <button type="button" class="btn btn-outline-secondary" @click="logout">Déconnexion</button>
          </div>
          <RouterLink v-else to="/login" class="btn btn-outline-secondary">
            <img src="@/assets/account.svg" alt="Login" />
          </RouterLink>
        </div>
      </div>
    </header>

    <!-- MAIN -->
    <main>
      <RouterView />
    </main>

    <!-- FOOTER -->
    <footer :class="{ 'fade-in': footerVisible }">
      <div class="footer-container">
        <div class="footer-section socials">
          <a href="https://www.facebook.com/windigo.serigraphie" target="_blank" rel="noopener noreferrer" class="icon facebook">
            <div class="tooltip">Facebook</div>
            <svg viewBox="0 0 320 512" height="1.2em" fill="currentColor">
              <path d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 
                12.42-50.06 52.24-50.06h40.42V6.26S260.43 
                0 225.36 0c-73.22 0-121.08 44.38-121.08 
                124.72v70.62H22.89V288h81.39v224h100.17V288z"/>
            </svg>
          </a>

          <a href="https://www.instagram.com/windigo.serigraphie/" target="_blank" rel="noopener noreferrer" class="icon instagram">
            <div class="tooltip">Instagram</div>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" height="1.2em" fill="currentColor">
              <path d="M224.1 141c-63.6 0-114.9 51.3-114.9 
                114.9s51.3 114.9 114.9 114.9S339 319.5 
                339 255.9 287.7 141 224.1 141zm0 
                189.6c-41.2 0-74.7-33.5-74.7-74.7 
                s33.5-74.7 74.7-74.7 74.7 33.5 
                74.7 74.7-33.5 74.7-74.7 
                74.7zm146.4-194.3c0 14.9-12 26.9-26.9 
                26.9s-26.9-12-26.9-26.9 12-26.9 
                26.9-26.9 26.9 12 26.9 
                26.9zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9S366.1 
                9.7 330.2 8C293.9 6.3 282.6 6 
                224 6s-69.9.3-106.2 2c-35.9 
                1.7-67.7 9.9-93.9 36.2S9.7 
                145.9 8 181.8C6.3 218.1 6 
                229.4 6 288s.3 69.9 2 106.2c1.7 
                35.9 9.9 67.7 36.2 93.9s58 
                34.5 93.9 36.2c36.3 1.7 47.6 
                2 106.2 2s69.9-.3 
                106.2-2c35.9-1.7 67.7-9.9 
                93.9-36.2s34.5-58 36.2-93.9c1.7-36.3 
                2-47.6 2-106.2s-.3-69.9-2-106.2zM398.8 
                388c-7.8 19.6-22.9 34.7-42.6 
                42.6-29.5 11.7-99.5 9-132.2 
                9s-102.7 2.6-132.2-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.2s-2.6-102.7 
                9-132.2c7.8-19.6 22.9-34.7 
                42.6-42.6 29.5-11.7 99.5-9 
                132.2-9s102.7-2.6 
                132.2 9c19.6 7.8 34.7 22.9 
                42.6 42.6 11.7 29.5 9 99.5 
                9 132.2s2.7 102.7-9 132.2z"/>
            </svg>
          </a>
        </div>

        <div class="footer-section contact">
          <h5>Atelier de sérigraphie Windigo</h5>
          <h5>Clément Fouquet</h5>
          <p>39 rue Saint Pavin des champs<br/>72000 Le Mans</p>
          <p>📞 07 83 28 72 87</p>
        </div>

        <div class="footer-section links">
          <div class="footer-links">
            <RouterLink to="/">Accueil</RouterLink> |
            <RouterLink to="/login">Mon compte</RouterLink>
          </div>
          <div class="footer-links">
            <RouterLink to="/politique-confidentialite">Politique de confidentialité</RouterLink> |
            <RouterLink to="/mentions-legales">Mentions légales</RouterLink>
          </div>
        </div>
      </div>

      <div class="footer-bottom">
        <p>© 2025 Windigo – Les photos sont des propriétés intellectuelles, toute reproduction est interdite.</p>
      </div>
    </footer>
  </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Oswald:wght@200&display=swap');

/* ================= HEADER ================= */
header {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  background: #A88871;
  z-index: 1000;
  display: flex;
  justify-content: center;
  box-shadow: 0 2px 5px rgba(0,0,0,0.1);
  font-family: 'Oswald', sans-serif;
  font-weight: 200; /* Extralight */
}

.header-container {
  max-width: 1200px;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 1rem 2rem;
}

.logo img {
  height: 50px;
  object-fit: contain;
}

nav a {
  margin: 0 12px;
  text-decoration: none;
  color: black;
  font-weight: 200; /* Extralight */
  position: relative;
  transition: color 0.3s ease;
}

nav a::after {
  content: "";
  position: absolute;
  bottom: -4px;
  left: 0;
  width: 0%;
  height: 2px;
  background-color: #333;
  transition: width 0.3s ease-in-out;
}

nav a:hover::after {
  width: 100%;
}

/* User actions */
.user-actions {
  display: flex;
  align-items: center;
}

.user-actions .logged-in span {
  margin-right: 10px;
}

/* ================= MAIN ================= */
main {
  padding-top: 100px; /* hauteur du header */
  min-height: 80vh;
  font-family: 'Oswald', sans-serif;
  font-weight: 200; /* Extralight */
}

/* ================= FOOTER ================= */
footer {
  background: #A88871;
  color: black;
  font-family: 'Oswald', sans-serif;
  font-weight: 200; /* Extralight */
  padding: 2rem 1rem;
}

.footer-container {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  max-width: 1200px;
  margin: 0 auto;
}

.footer-section {
  flex: 1;
  min-width: 250px;
  margin: 1rem 0;
  text-align: center;
  font-weight: 200; /* Extralight */
}

/* Footer links */
.footer-links a {
  color: black;
  text-decoration: none;
  margin: 0 8px;
  position: relative;
  transition: color 0.3s ease;
  font-weight: 200; /* Extralight */
}

.footer-links a::after {
  content: "";
  position: absolute;
  bottom: -3px;
  left: 0;
  width: 0%;
  height: 2px;
  background-color: #333;
  border-radius: 2px;
  transition: width 0.3s ease-in-out;
}

.footer-links a:hover::after {
  width: 100%;
}

/* Footer bottom */
.footer-bottom {
  text-align: center;
  font-size: 0.85rem;
  margin-top: 1rem;
  font-weight: 200; /* Extralight */
}

/* Social icons */
.icon {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  margin: 0 10px;
  width: 50px;
  height: 50px;
  border-radius: 50%;
  background: white;
  color: black;
  position: relative;
  transition: all 0.3s ease;
  cursor: pointer;
}

.icon .tooltip {
  position: absolute;
  bottom: 130%;
  background: black;
  color: white;
  padding: 5px 8px;
  border-radius: 6px;
  opacity: 0;
  transform: translateY(10px);
  pointer-events: none;
  transition: all 0.3s ease;
  font-size: 0.75rem;
  white-space: nowrap;
  font-weight: 200; /* Extralight */
}

.icon:hover .tooltip {
  opacity: 1;
  transform: translateY(0);
}

.icon.facebook:hover {
  background: #1877F2;
  color: white;
}

.icon.instagram:hover {
  background: #E4405F;
  color: white;
}

</style>
