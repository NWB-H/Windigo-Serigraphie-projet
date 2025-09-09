<script setup lang="ts">
import { ref, onMounted } from 'vue';
import router from '@/router';
import * as AuthService from '@/_services/AuthService';

const auth = ref({
  email: '',
  password: ''
});

useHead({
  title: 'Connexion | Windigo',
  meta: [
    { name: 'description', content: "Connectez-vous à votre compte Windigo pour gérer vos réservations et accéder à vos ateliers de sérigraphie." },
    { property: 'og:title', content: 'Connexion | Windigo Sérigraphie' },
    { property: 'og:description', content: "Accédez à votre espace personnel Windigo pour réserver et suivre vos ateliers de sérigraphie artisanale." },
    { property: 'og:url', content: 'https://windigo.com/login' }
  ],
  link: [
    { rel: 'canonical', href: 'https://windigo.com/login' }
  ]
})

const errors = ref<any>({});

onMounted( () => {
  console.log('exec on mounted');
});

async function login() {
  try {
    await AuthService.login(auth.value);
    console.log('Connexion réussie !');
    router.push('/');
  } catch (error: any) {
    console.log(error)
    errors.value = error.response.data.errors;
  }
}
</script>

<template>
  <div class="top-container">
    <div class="login">
      <form @submit.prevent="login">
        <h2 class="form-title">Connexion</h2>
        <div class="container-champ">
        <div class="form-group">
          <input type="text" class="input" v-model="auth.email" placeholder="Email" />
        </div>
        <div class="form-group">
          <input type="password" class="input" v-model="auth.password" placeholder="Mot de passe" />
        </div>
        <div class="form-group">
          <button type="submit" class="button">Connexion</button>
        </div>
        <p class="register">
          Vous n'avez pas encore de compte ?
          <router-link to="/register">
          Inscrivez-vous
        </router-link>
        </p>
        </div>
      </form>
    </div>
  </div>
</template>

<style scoped>
.top-container {
  width: 100%;
  display: flex;
  justify-content: center;
  align-items: flex-start;
  padding: 3vw 2vw;
  flex-direction: row;
  gap: 3vw;
}

.login {
  width: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  background-color:#d2baaa;
  padding: 2vw 2vw;
}

.inscription {
  width: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  background-color: #d2baaa;
  padding: 2vw 2vw;
}

.form-title {
  text-align: center;
}

.button {
 width: fit-content;
 padding: 0 1vw;
 height: 2.3em;
 margin: 0.5em;
 background: white;
 color: #A78770;
 border: none;
 border-radius: 0.625em;
 font-size: 20px;
 font-weight: bold;
 cursor: pointer;
 position: relative;
 z-index: 1;
 overflow: hidden;
}

button:hover {
 color: white;
}

button:after {
 content: "";
 background: black;
 position: absolute;
 z-index: -1;
 left: -20%;
 right: -20%;
 top: 0;
 bottom: 0;
 transform: skewX(-45deg) scale(0, 1);
 transition: all 0.5s;
}

button:hover:after {
 transform: skewX(-45deg) scale(1, 1);
 -webkit-transition: all 0.5s;
 transition: all 0.5s;
}


.container-champ {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  position: relative;
  gap : 2vw;
}
</style>