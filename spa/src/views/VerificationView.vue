<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from 'axios'

const route = useRoute()
const router = useRouter()

const message = ref('Vérification en cours...')
const success = ref(false)

onMounted(async () => {
  const email = route.query.email
  const token = route.query.token

  if (!email || !token) {
    message.value = 'Lien invalide.'
    return
  }

  try {
    await axios.post('/api/verification', { email, token })
    message.value = 'Votre compte a bien été vérifié 🎉'
    success.value = true

    setTimeout(() => {
      router.push('/login')
    }, 3000)
  } catch (error: any) {
    message.value = 'Ce lien n’est plus valide ou a déjà été utilisé.'
  }
})
</script>

<template>
  <div class="verify-container">
    <div class="verify-card">
      <h2>{{ message }}</h2>
      <p v-if="success">Redirection vers la page de connexion...</p>
    </div>
  </div>
</template>

<style scoped>
.verify-container {
  width: 100%;
  height: 80vh;
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: #f7f1ed;
}

.verify-card {
  background-color: #fff;
  padding: 2rem;
  border-radius: 1rem;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
  text-align: center;
  color: #3d2f29;
  max-width: 500px;
}

h2 {
  font-size: 1.5rem;
  margin-bottom: 1rem;
}
</style>
