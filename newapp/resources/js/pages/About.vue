<template>
    <AppLayout>
        <div class="container my-5">
            <div class="row">
                <!-- Colonne gauche -->
                <div class="col-lg-6">
                    <!-- À propos de l'entreprise -->
                    <SectionItem
                        header="À propos de l’entreprise"
                        text="J’ai fondé en 2017 Windigo, un atelier de sérigraphie artisanale sous forme de micro-entreprise, dans lequel j’imprime mes propres illustrations sur t-shirts et sur papier, sous forme d’affiches ou cartes."
                        :image="{ text: 'Entreprise' }"
                    />

                    <!-- À propos de la sérigraphie -->
                    <SectionItem
                        header="À propos de la sérigraphie"
                    >
                        <template #body>
                            <p>J'anime depuis plusieurs années des ateliers d'initiation pour faire découvrir au public les bases techniques et le pouvoir créatif de la sérigraphie.</p>
                            <AppImage alt="Sérigraphie" class="img-fluid rounded shadow-sm mt-3" />
                            <button class="btn btn-primary btn-lg mt-3" @click="router.push('/ateliers')">
                                Découvrir la sérigraphie
                            </button>
                        </template>
                    </SectionItem>
                </div>

                <!-- Colonne droite -->
                <div class="col-lg-6">
                    <!-- À propos de moi -->
                    <SectionItem
                        header="À propos de moi"
                    >
                        <template #body>
                            <div class="row align-items-center">
                                <div class="col-12 col-md-6 order-2 order-md-1">
                                    <p>Je suis Clément Fouquet, j’ai 33 ans et je suis illustrateur et sérigraphe. Après avoir
                                        fait des études de graphisme, je me suis intéressé à la sérigraphie comme moyen d’éditer
                                        moi-même mes propres illustrations.</p>
                                </div>
                                <div class="col-12 col-md-6 order-1 order-md-2 mb-3 mb-md-0">
                                    <AppImage alt="Moi" class="img-fluid rounded shadow-sm" />
                                </div>
                            </div>
                        </template>
                    </SectionItem>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from "@/layouts/AppLayout.vue";
import Section from "@/components/Section.vue";
import AppImage from "@/components/AppImage.vue";
import SectionItem from "@/components/SectionItem.vue";
</script>

<style scoped>
h2 {
    font-weight: 600;
}

p {
    line-height: 1.6;
}

.btn-primary {
    border-radius: 0.5rem;
    padding: 0.75rem 1.5rem;
}
</style>
