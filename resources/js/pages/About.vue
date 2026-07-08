<template>
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
                    <SectionItem header="À propos de la sérigraphie">
                        <template #body>
                            <p>
                                J'anime depuis plusieurs années des ateliers
                                d'initiation pour faire découvrir au public les
                                bases techniques et le pouvoir créatif de la
                                sérigraphie.
                            </p>
                            <AppImage
                                alt="Sérigraphie"
                                class="img-fluid mt-3 rounded shadow-sm"
                            />
                            <button
                                class="btn btn-primary btn-lg mt-3"
                                @click="router.push('/ateliers')"
                            >
                                Découvrir la sérigraphie
                            </button>
                        </template>
                    </SectionItem>
                </div>

                <!-- Colonne droite -->
                <div class="col-lg-6">
                    <!-- À propos de moi -->
                    <SectionItem header="À propos de moi">
                        <template #body>
                            <div class="row align-items-center">
                                <div class="col-md-6 order-md-1 order-2 col-12">
                                    <p>
                                        Je suis Clément Fouquet, j’ai 33 ans et
                                        je suis illustrateur et sérigraphe.
                                        Après avoir fait des études de
                                        graphisme, je me suis intéressé à la
                                        sérigraphie comme moyen d’éditer
                                        moi-même mes propres illustrations.
                                    </p>
                                </div>
                                <div
                                    class="col-md-6 order-md-2 mb-md-0 order-1 col-12 mb-3"
                                >
                                    <AppImage
                                        alt="Moi"
                                        class="img-fluid rounded shadow-sm"
                                    />
                                </div>
                            </div>
                        </template>
                    </SectionItem>
                </div>
            </div>
        </div>
</template>

<script setup lang="ts">
import AppImage from '@/components/AppImage.vue';
import SectionItem from '@/components/SectionItem.vue';
import AppLayout from '@/layouts/AppLayout.vue';

defineOptions({
    layout: [AppLayout, { title: 'A propos'}],
})
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
